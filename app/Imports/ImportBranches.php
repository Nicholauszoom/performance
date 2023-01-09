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


class ImportBranches implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
  
        
        foreach ($collection as $row) 
        {  
             

          $data = [
            //'code'=>$row['code'],
            'name'=>$row['branch'],
            //'location_code'=>$row['location_code'],
            //'location_id'=>$row['location_id'],
        
          ];
          DB::table('branch')
          ->insert($data);
        

          
       
        
        }
    }
}
