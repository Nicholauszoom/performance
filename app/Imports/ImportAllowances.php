<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use App\Models\ImportsEmployee;
use App\Models\Payroll\FlexPerformanceModel;
use App\Models\PerformanceModel;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportAllowances implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
  
        
        foreach ($collection as $row) 
        {  
             

          $data = [
            'code'=>0,
            'name'=>$row['desc'],
            'amount'=>0,
            'taxable'=>'YES',
            'pentionable'=>'NO',
          ];
          DB::table('allowances')
          ->insert($data);
        

          
       
        
        }
    }
}
