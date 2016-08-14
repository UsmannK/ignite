<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use \Excel;
use \App\Models\Application;
use \App\Models\ApplicationRating;
use Auth;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

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
                // if($application->exists) {
                //    echo "skipped: " . $row . "<br/>";
                // } else {
                //    echo "added: " . $row . "<br/>";
                // }
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
        // $this->getNextApplicationID();
        return view('home', compact('applications'));
    }
    public function showRate($id  = null) {
        if(is_null($id)) {
            return redirect()->action('PageController@showRate', ['id' => $this->getNextApplicationID()]);
        }
        try {
            $application = Application::findOrFail($id)->toArray();
            return view('rate', compact('application'));
        } catch (\Exception $e) {
            return redirect('/')->with('message', 'Could not find application.'); 
        }
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
}