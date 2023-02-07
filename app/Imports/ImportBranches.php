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
use DateTime;

class ImportBranches implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {


        foreach ($collection as $row)
        {

//dd($row['emp_id']);
        $date = DB::table('employee')->where('emp_id',$row['emp_id'])->select('*')->first();
		$d1 = new DateTime($date->hire_date);
		$todayDate = date('Y-m-d',strtotime('2022-12-31'));
		$d2 = new DateTime($todayDate);
		$diff = $d1->diff($d2);

		$years = $diff->y;
		$months = $diff->m;
        $days = $diff->d;
        if($days > 1){

            $months = $months;

        }

        $accrue = $months * $date->accrual_rate + $years * 12 * $date->accrual_rate;
        if($row['emp_id'] == 102927){
            $leave = $accrue - $row['days'];
            dd($accrue,$date->emp_id);
        }
        $leave = $accrue - $row['days'];

          $data = [
            //'code'=>$row['code'],
            'days'=>$leave,
            //'location_code'=>$row['location_code'],
            //'location_id'=>$row['location_id'],

          ];
          DB::table('leaves')->where('empID',$row['emp_id'])->update($data);
        //   DB::table('branch')
        //   ->insert($data);





        }
    }
}
