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
            $i = 1;
           $data = DB::table('department')
           ->where('name',$row['dept'])
           ->select('id')
           ->first();
            if($data == null)
            dd($row['department']);

          $data2 = [
            'name'=>$row['job'],
            'state'=>1,
            'dept_id'=>$data->id,
            'code'=>"TZ".$i,
            'organization_level'=>1,
          ];

          // $data2 = DB::table('position')
          //  ->where('name',$row['position'])
          //  ->select('id')
          //  ->first();
          // if($data2 == null)
          // DB::table('position')
          // ->insert($data);


        //   $data2 = DB::table('position')
        //   ->where('name','like','%'.$row['job'].'%')
        //   ->update($data);

        //     $dept = DB::table('department')
        //    ->where('name',$row['dept'])
        //    ->select('id')
        //    ->first();
        //    $dept_id = $dept->id;
        //   $data2 = [
        //     'dept_id'=>$dept_id,
        //     'name'=>$row['job'],

        //   ];
        //   $test = DB::table('position')->where('name',$row['job'])->select('*')->first();

         // if(empty($test))
          DB::table('position')->insert($data2);
        //   else
        //   DB::table('position')->where('name',$row['job'])->update($data);


$i++;
        }
    }
}
