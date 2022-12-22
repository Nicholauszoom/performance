<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Imports\ImportEmployee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Storage;

class ImportEmployeeController extends Controller
{
    use Importable;
    
    public function import(Request $request){
        
      
        $data = Excel::import(new ImportEmployee, $request->file('file')->store('files'));
        
        $response_array['title'] = "SUCCESS";
        header('Content-type: application/json');
        echo json_encode($response_array);
    }
    public function sample(Request $request){
        return Storage::download('sample.xlsx');
    }
}
