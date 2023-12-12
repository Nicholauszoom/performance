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

        $firstIteration = true;


        foreach ($collection as $row) {

            if ($firstIteration) {
                $firstIteration = false;
                continue; // Skip the header
            }
            // Check if the 'currency' key exists in the $row array
         $rate = $flexperformance_model->get_rate($row[3]);
         $data = array(
             'empID' => $row[0],
             'allowance' => $this->allowance,
             'amount' => $row[2] * $rate,
             'mode' => '1',
             'percent' => 0,
             'currency' => $row[3],
             'rate' => $rate,
         );

         Log::error($data);
         $result = $flexperformance_model->assign_allowance($data);

     }

    }
}
