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
use Carbon\Carbon;


class ImportHeslb implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

         foreach ($collection as $row)
         {
          if($row['contract_end'] != null){
        $date= \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['contract_end'])->format('Y-m-d');


          $data = [
            //  'description'=>'HESLB',
            // 'form_four_index_no'=>$row['form_4_index'],
            // 'empID'=>$row['payroll'],
            // 'amount'=>$row['heslb_balance'],
            // 'deduction_amount'=>0,
            // 'type'=>3,
            // 'state'=>1,
            'contract_end'=>$date

          ];
          DB::table('employee')->where('emp_id',$row['payroll'])
          ->update($data);
        //   if($row['form_4_index'] != null)
        //   DB::table('loan')
        //   ->insert($data);


    }


        }
    }
}
