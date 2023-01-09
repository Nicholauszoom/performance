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


class ImportPosition implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row) 
        {  
          //  $data = DB::table('department')
          //  ->where('name',$row['department'])
          //  ->select('id')
          //  ->first();
          //   if($data == null)
          //   dd($row['department']);

          $data = [
            'name'=>$row['job'],
           // 'dept_id'=>$data->id,
            //'code'=>234,
           // 'organization_level'=>1,
          ];

          // $data2 = DB::table('position')
          //  ->where('name',$row['position'])
          //  ->select('id')
          //  ->first();
          // if($data2 == null)
          // DB::table('position')
          // ->insert($data);
        

          $data2 = DB::table('position')
          ->where('name','like','%'.$row['job'].'%')
          ->update($data);
          
       
        
        }
    }
}
