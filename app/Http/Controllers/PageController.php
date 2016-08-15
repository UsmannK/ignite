<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use \Excel;
use \App\Models\Application;
use \App\Models\ApplicationRating;
use \App\Models\InterviewSlot;
use Auth;
use DB;
use Carbon\Carbon;
use Datatables;

class PageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
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
            for ($row = 3; $row <= $highestRow; $row++)
            {
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

    public function dashboard() {
        $applications = Application::count();
        $data['count'] = Auth::user()->ratings->count();
        return view('dashboard', compact('applications', 'data'));
    }
    public function index() {
        return view('home');
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
            $slots = InterviewSlot::all();
            return view('rate', compact('application', 'data', 'rating', 'slots'));
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Could not find application.'); 
        }
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
            if($app->reviews < 3) {
                if(!ApplicationRating::where('application_id',$app->id)->where('user_id',$user->id)->first()) {
                    return($app->id);
                }
            }
        }
        return null;
    }
    public function showApplications() {
        return view('applications');
    }
    public function getApplications() {
        // $applications = Application::with('ratings')->select('application_rating.*');
        $applications = Application::select([
            'applications.id',
            'applications.name',
            'applications.email',
            \DB::raw('count(application_ratings.application_id) as ratings'),
            \DB::raw('AVG(application_ratings.rating) as avg'),
            \DB::raw('application_ratings.rating as myrating'),
        ])->leftJoin('application_ratings','application_ratings.application_id','=','applications.id')
        ->groupBy('applications.id');

        return Datatables::of($applications)->make(true);
    }
    public function showSettings() {
        return view('settings');
    }
    public function submitSettings(Request $request) {
        $validator = \Validator::make($request->all(), [
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $user = Auth::user();
        if($request->enable_keyboard) {
            $user->enable_keyboard = 1;
        } else {
            $user->enable_keyboard = 0;
        }
        $user->save();
        return response()->json(['message' => 'success']);
    }
    public function showCreateInterview() {
        return view('interview_create');
    }
    public function submitCreateInterview(Request $request) {
        $validator = \Validator::make($request->all(), [
            'start_day' => 'required|date_format:"d/m/Y"',
            'end_day' => 'required|date_format:"d/m/Y"',
            'start_time' => 'required|numeric',
            'end_time' => 'required|numeric',
            'increment' => 'required|numeric|min:0',
        ]);
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
                $interview->end_time = $currTime->copy()->addMinutes($request->increment);
                $interview->save();
                $currTime->addMinutes($request->increment);
            }
            $currDay->addDays(1);
        }
        return response()->json(['message' => 'success']);
    }
    public function showInterview($id = null) {
        try {
            $application = Application::findOrFail($id);
            return view('interview', compact('application'));
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Could not find application.'); 
        }        
    }
    public function showAllInterviews() {
        $interviews = InterviewSlot::all();
        return view('interview_view', compact('interviews'));
    }
    public function submitTimeslot(Request $request) {
        if(!Auth::user()->hasRole('admin'))
            return;

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
}