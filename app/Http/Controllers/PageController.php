<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use \Excel;
use \App\Models\Application;
use \App\Models\ApplicationRating;
use \App\Models\InterviewSlot;
use \App\Models\Interview;
use \App\Models\User;
use Auth;
use DB;
use Carbon\Carbon;
use Datatables;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Mail;

class PageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'calendar']]);
    }

    /**
     * Import new records in Excel sheet to database
     */
    public function importExcel() {
        $excel = [];
        Excel::load('resources/report.xlsx', function($reader) use (&$excel) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            //  Loop through each row of the worksheet in turn
            for ($row = 3; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $excel[] = $rowData[0];
                $application = Application::firstOrNew(['uuid' => $rowData[0][0], 'name' => $rowData[0][1]]);
                $application->email = $rowData[0][2];
                $application->q1 = $rowData[0][3];
                $application->q2 = $rowData[0][4];
                $application->q3 = $rowData[0][5];
                $application->q4 = $rowData[0][6];
                $application->q5 = $rowData[0][7];
                $application->q6 = $rowData[0][8];
                $application->save();
            }
        });
    }

    /**
    * Display mentor dashboard
    */
    public function dashboard() {
        $applications = Application::count();
        $users = User::with('ratings')->get()->sortBy(function($users) {
            return $users->ratings->count();
        });
        $data['count'] = Auth::user()->ratings->count();
        return view('dashboard.dashboard', compact('applications', 'data', 'users'));
    }
    public function index() {
        \App\Models\Role::with('users')->where('name', 'admin')->get();
        $mentors = User::with(array('roles' => function($query) {
            $query->where('name', 'admin');
        }))
        ->get(['name', 'tagline', 'image', 'fb', 'website', 'github', 'about'])->toArray();
        return view('home', compact('mentors'));
    }
    public function calendar() {
    	return view('calendar');
    }
    public function showRate($id  = null) {
        if(is_null($id)) {
            $id = $this->getNextApplicationID();
            // If user has rated all applicants
            if(is_null($id)) {
                return redirect()->action('PageController@dashboard')->with('message', 'Looks like you\'ve rated everyone. Great job!');
            }
            return redirect()->action('PageController@showRate', ['id' => $id]);
        }
        try {
            $application = Application::findOrFail($id);
            $rating = ApplicationRating::where('application_id', $id)->where('user_id', Auth::user()->id)->first();
            if($rating) {
                $rating = $rating->toArray();
            }
            $data['id'] = $id;
            $slots = InterviewSlot::orderBy('start_time', 'asc')->get();
            if(($interviews = Interview::where('app_id', $id)->get()) != null) {
            	$interviews = $interviews->toArray();
            }
            return view('dashboard.rate', compact('application', 'data', 'rating', 'slots', 'interviews'));
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Could not find application.'); 
        }
    }
    public function submitInterviewDecision(Request $request) {
        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applications,id',
            'decision' => 'required|numeric|max:3|min:1',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $interview = Interview::firstOrNew(['app_id' => $request->app_id, 'user_id' => Auth::user()->id]);
        $interview->app_id = $request->app_id;
        $interview->user_id = Auth::user()->id;
        $interview->decision = $request->decision;
        $interview->save();
        $updated_at = new Carbon($interview->updated_at);
        return response()->json(['message' => 'success', 'updated_at' => $updated_at->format('g:i:s A')]);
    }
    public function submitInterviewAttribute(Request $request) {
        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applications,id',
            'attribute' => 'required|in:passion,commitment,drive',
            'value' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $attribute = $request->attribute;
        $interview = Interview::firstOrNew(['app_id' => $request->app_id, 'user_id' => Auth::user()->id]);
        $interview->app_id = $request->app_id;
        $interview->user_id = Auth::user()->id;
        $interview->$attribute = $request->value;
        $interview->save();
        $updated_at = new Carbon($interview->updated_at);
        return response()->json(['message' => 'success', 'updated_at' => $updated_at->format('g:i:s A')]);
    }
    public function submitDecision(Request $request) {
        if(!Auth::user()->hasRole('admin'))
            return redirect('/dashboard')->with('message', 'Invalid Permissions.');

        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applications,id',
            'decision' => 'required|numeric|max:1|min:-1',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $application = Application::findOrFail($request->app_id);
        $application->accepted = $request->decision;
        $application->save();
        return response()->json(['message' => 'success']);
    }
    public function submitRating(Request $request) {
        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applications,id',
            'rating' => 'required|numeric|max:3|min:1',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $rating = ApplicationRating::firstOrNew(['application_id' => $request->app_id, 'user_id' => Auth::user()->id]);
        $rating->application_id = $request->app_id;
        $rating->user_id = Auth::user()->id;
        $rating->rating = $request->rating;
        $rating->save();
        return response()->json(['message' => 'success', 'redirect' => action('PageController@showRate', ['id' => $this->getNextApplicationID()])]);
    }
    public function getNextApplicationID() {
        $user = Auth::user();
        foreach(Application::orderBy(DB::raw('RAND()'))->get() as $app) {
        	$rating = ApplicationRating::where('application_id',$app->id)->where('user_id','=',$user->id)->first();
            if(!$rating) {
                return($app->id);
            }      
        }
        return null;
    }
    public function showApplications() {
        return view('dashboard.applications');
    }

    /**
    * Retrieve data for DataTables
    */
    public function getApplications() {
        $applications = Application::select([
            'applications.id',
            'applications.name',
            'applications.email',
            'applications.interview_timeslot',
            'applications.accepted',
            \DB::raw('count(application_ratings.application_id) as ratings'),
            \DB::raw('TRUNCATE(AVG(application_ratings.rating),2) as avg'),
            \DB::raw('application_ratings.rating as myrating'),
            \DB::raw('TRUNCATE(AVG(interviews.decision),2) as interview_avg'),
            \DB::raw('TRUNCATE((AVG(interviews.decision)+AVG(application_ratings.rating))/2, 3) as total_avg'),
        ])->leftJoin('application_ratings','application_ratings.application_id','=','applications.id')
        ->leftJoin('interviews', 'interviews.app_id', '=', 'applications.id')
        ->groupBy('applications.id');

        return Datatables::of($applications)->make(true);
    }
    public function showSettings() {
        return view('dashboard.settings');
    }
    public function showSettingsPicture() {
        return view('dashboard.settings_picture');
    }
    public function submitSettings(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'tagline' => 'required',
            'about' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $user = Auth::user();
        $user->name = $request->name;
        $user->tagline = $request->tagline;
        $user->fb = $request->fb;
        $user->github = $request->github;
        $user->website = $request->website;
        $user->about = $request->about;
        if($request->enable_keyboard) {
            $user->enable_keyboard = 1;
        } else {
            $user->enable_keyboard = 0;
        }
        $user->save();
        return response()->json(['message' => 'success']);
    }
    public function showCreateInterview() {
        return view('dashboard.interview_create');
    }
    public function submitCreateInterview(Request $request) {
        $validator = \Validator::make($request->all(), [
            'start_day' => 'required|date_format:"d/m/Y"',
            'end_day' => 'required|date_format:"d/m/Y"',
            'start_time' => 'required|numeric',
            'end_time' => 'required|numeric',
            'length' => 'required|numeric|min:0',
        ]);
        $offset = 5;
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $currDay = new Carbon($request->start_day);
        $endDay = new Carbon($request->end_day);

        while($currDay <= $endDay) {
            $currTime = $currDay->copy();
            $currTime->addHours($request->start_time);

            $endTime = $currDay->copy();
            $endTime->addHours($request->end_time);
         
            while($currTime <= $endTime) {
                $interview = new InterviewSlot;
                $interview->start_time = $currTime;
                $interview->end_time = $currTime->copy()->addMinutes($request->length);
                $interview->save();
                $currTime->addMinutes($request->length)->addMinutes($offset);
            }
            $currDay->addDays(1);
        }
        return response()->json(['message' => 'success']);
    }
    public function showInterview($id = null) {
        if($id) {
            $params = array_unique(explode('/', $id));
            try {
                $applications = array();
                $interviews = array();
                foreach($params as $interviewID) {
                    $application = Application::findOrFail($interviewID, ['id', 'name', 'email'])->toArray();
                    $applications[] = $application;
                    $interview = Interview::where('app_id', $interviewID)->where('user_id', Auth::user()->id)->first();
                    if(!is_null($interview)) {
                        $interviews[] = $interview->toArray();
                    } else {
                        $interviews[] = array('notes' => '', 'app_id' => $application['id'], 'user_id' => Auth::user()->id, 'decision' => -1, 'passion' => 0, 'commitment' => 0, 'drive' => 0);
                    }
                }
                return view('dashboard.interview', compact('applications', 'interviews'));
            } catch (\Exception $e) {
                return redirect('/dashboard')->with('message', 'Error building interview'); 
            }
        }      
    }
    public function updateInterview(Request $request) {
        $validator = \Validator::make($request->all(), [
            'app_id' => 'required|exists:applications,id',
            'notes' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $interview = Interview::firstOrNew(['app_id' => $request->app_id, 'user_id' => Auth::user()->id]);
        $interview->app_id = $request->app_id;
        $interview->user_id = Auth::user()->id;
        $interview->notes = $request->notes;
        $interview->save();
        $updated_at = new Carbon($interview->updated_at);
    	return response()->json(['message' => 'success', 'updated_at' => $updated_at->format('g:i:s A')]);
    }
    public function showAllInterviews() {
        $interviews = InterviewSlot::orderBy('start_time', 'asc')->get();
        $mentors = User::get(array('id', 'name'))->toArray();
        return view('dashboard.interview_view', compact('interviews', 'mentors'));
    }
    public function submitTimeslot(Request $request) {
        if(!Auth::user()->hasRole('admin'))
        	return redirect('/')->with('message', 'Invalid Permissions.');

        $validator = \Validator::make($request->all(), [
            'id' => 'required|exists:applications,id',
            'timeslot' => 'required|exists:interview_slot,id',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $application = Application::find($request->id);
        $application->interview_timeslot = $request->timeslot;
        $application->save();
        return response()->json(['message' => 'success']);
    }
    public function tempProfilePicStore(Request $request) {
        $validator = \Validator::make($request->all(), [
            'photo' => 'required|image',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $image = $request->file('photo');
        $destinationPath = storage_path('app/public') . '/uploads';
        $random = str_random(40);
        $name =  $random . '.' . $image->getClientOriginalExtension();
        if(!$image->move($destinationPath, $name)) {
            return $this->errors(['message' => 'Error saving the file.', 'code' => 400]);
        }
        return response()->json(['message' => 'success', 'location' => asset('storage/' .  $name)], 200);
    }
    public function cropPicture(Request $request) {
        $validator = \Validator::make($request->all(), [
            'src' => 'required',
            'width' => 'required',
            'height' => 'required',
            'x' => 'required',
            'y' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $url = explode("/", $request->src);
        $src = $url[count($url)-1];
        $img = Image::make(storage_path('app/public') . '/uploads/' . $src);
        $img->crop(intval($request->width), intval($request->height), intval($request->x), intval($request->y));
        $img->save(storage_path('app/public') . '/uploads/' . $src);
        Auth::user()->image = $src;
        Auth::user()->save();
        \Session::flash('message', 'Updated profile photo!'); 
        return response()->json(['message' => 'success']);
    }
    public function sendInterviewTimes() {
        $applications = Application::where('emailed', '!=', 1)->get(['name', 'email', 'interview_timeslot', 'id']);
        foreach($applications as $applicant) {
            if($applicant->interview_timeslot) {
                $slot = InterviewSlot::find($applicant->interview_timeslot);
                $start = new Carbon($slot->start_time);
                $string = "";
                foreach ($slot->mentorsAssigned->toArray() as $mentor) {
                    $string .= $mentor['mentor']['name'] . " and ";
                }
                $string = substr($string, 0, -5);
                echo $applicant->email . " " . $applicant->name ."<br/>";
                Mail::send('emails.interview',  ['slot' => $slot, 'applicant' => $applicant, 'start' => $start, 'string' => $string], function ($message) use ($slot,$applicant,$start,$string) {
                     $message->to($applicant->email, $name = $applicant->name);
                });
                $applicant->emailed = 1;
                $applicant->save();
            }
        }
    }
}