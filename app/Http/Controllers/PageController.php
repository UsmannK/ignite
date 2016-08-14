<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use \Excel;
use App\Models\Application;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Import new records in Excel sheet to database
     *
     * @return \Illuminate\Http\Response
     */
    public function importExcel()
    {
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
                $application = \App\Models\Application::firstOrNew(['uuid' => $rowData[0][0], 'name' => $rowData[0][1]]);
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
        return view('home');
    }
}
