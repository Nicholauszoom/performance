<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Payroll\FlexPerformanceModel;
use Illuminate\Support\Facades\Log;



class ImportEmployeeAllowance implements ToCollection
{
    /**
    * @param Collection $collection
    */

    private $allowance;


    public function __construct($allowance)
    {
        $this->allowance = $allowance;
    }
    public function collection(Collection $collection)
    {
        $flexperformance_model = new FlexPerformanceModel();


        foreach ($collection as $row) {

            // Check if the 'currency' key exists in the $row array
     // if (isset($row['currency'])) {
         $rate = $flexperformance_model->get_rate($row['currency']);
         $data = array(
             'empID' => $row['payroll number'],
             'allowance' => $this->allowance,
             'amount' => $row['amount'] * $rate,
             'mode' => '1',
             'percent' => 0,
             'currency' => $row['currency'],
             'rate' => $rate,
         );

         Log::error($data);
         $result = $flexperformance_model->assign_allowance($data);

     }

    }
}
