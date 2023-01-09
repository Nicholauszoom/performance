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


class ImportDepartment implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row) 
        {  
             

          // $data = [
          //   'dept_no'=>$row['deptno'],
          //   'company'=>$row['company'],
          //   'code'=>$row['code'],
          //   'name'=>$row['name'],
          //   'type'=>1,
          //   'hod'=>$row['head'],
          //   'reports_to'=>$row['reportto'],
          //   'state'=>1,
          //   'department_pattern'=>'ewqacr',
          //   'parent_pattern'=>'ewqacr',
          // ];

          $data2 = [
            //'dept_no'=>$row['deptno'],
            'name'=>$row['dept'],
            // 'code'=>$row['code'],
            // 'name'=>$row['name'],
            // 'type'=>1,
            // 'hod'=>$row['head'],
            // 'reports_to'=>$row['reportto'],
            // 'state'=>1,
            // 'department_pattern'=>'ewqacr',
            // 'parent_pattern'=>'ewqacr',
          ];
          $test = DB::table('department')->where('name',$row['dept'])->select('*')->first();
        
          if(empty($test))
          DB::table('department')->insert($data2);
          else
          DB::table('department')->where('name',$row['dept'])->update($data2);
        

          
       
        
        }
    }
}
