<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Exports\ExportHESLB;
use App\Imports\ImportAllowances;
use App\Imports\ImportBranches;
use App\Imports\ImportDepartment;
use App\Imports\ImportEmployee;
use App\Imports\ImportPosition;
use App\Imports\ImportHeslb;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Storage;
 
class ImportEmployeeController extends Controller
{
    use Importable;
    
    public function import(Request $request){
        
        //$data2 = Excel::import(new ImportDepartment, $request->file('file')->store('files'));
        //$data2 = Excel::import(new ImportDepartment, $request->file('file')->store('files'));
        //$data1 = Excel::import(new ImportPosition, $request->file('file')->store('files'));

        // $data1 = Excel::import(new ImportBranches, $request->file('file')->store('files'));

       // $data1 = Excel::import(new ImportAllowances, $request->file('file')->store('files'));

          //$data1 = Excel::import(new ImportAllowances, $request->file('file')->store('files'));
          
          $data = Excel::import(new ImportHeslb, $request->file('file')->store('files'));

        // $data = Excel::import(new ImportEmployee, $request->file('file')->store('files'));
        
        // $response_array['title'] = "SUCCESS";
        // header('Content-type: application/json');
        // echo json_encode($response_array);
    }
    public function sample(Request $request){
        return Storage::download('sample.xlsx');
    }

    public function download(){

        return Excel::download(new ExportHESLB, 'users.xlsx');
    }
}
