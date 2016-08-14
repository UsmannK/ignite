<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use \Excel;
use \App\Models\Application;
use \App\Models\ApplicationRating;
use Auth;
use DB;

class PageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Import new records in Excel sheet to database
     *
     * @return \Illuminate\Http\Response
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

    public function index() {
        $applications = Application::count();
        $data['count'] = Auth::user()->ratings->count();
        return view('home', compact('applications', 'data'));
    }
    public function showRate($id  = null) {
        if(is_null($id)) {
            $id = $this->getNextApplicationID();
            // If user has rated all applicants
            if(is_null($id)) {
                return redirect()->action('PageController@index')->with('message', 'Looks like you\'ve rated everyone. Great job!');
            }
            return redirect()->action('PageController@showRate', ['id' => $id]);
        }
        try {
            $application = Application::findOrFail($id);
            // var_dump($application->ratingInfo());
            $data['id'] = $id;
            // var_dump($application->ratingInfo);
            return view('rate', compact('application', 'data'));
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
            return null;
        }
    }
    public function showApplications() {
        $applications = Application::paginate(25);
        return view('applications', ['applications' => $applications]);
    }
}