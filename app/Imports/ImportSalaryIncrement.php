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
use App\Models\Employee;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SysHelpers;
use App\Models\PerformanceModel;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use DateTime;

class ImportSalaryIncrement implements ToCollection, WithHeadingRow
{
    protected $flexperformance_model;


    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $flexperformance_model = new FlexperformanceModel;
        $this->flexperformance_model = $flexperformance_model;


        foreach ($collection as $row) {


           if($row['emp_id'] != null){



            //start iport increments
            $id = $row['emp_id'];

            $empl = Employee::where('emp_id', $id)->first();
            if(empty($empl)){

            }
            $oldSalary = $empl->salary;
            $oldRate = $empl->rate;
            $new_salary =  $row['increment'];

            // saving old employee data
            $old = new Promotion();
            $old->employeeID = $id;
            $old->oldSalary = $empl->salary/$empl->rate;
            $old->newSalary = $new_salary;
            $old->oldPosition = $empl->position;
            $old->newPosition = $empl->position;;
            $old->oldLevel = $empl->emp_level;
            $old->newLevel = $empl->emp_level;
            $old->effective_date = $empl->effective_date;
            $old->created_by = Auth::user()->id;
            $old->action = "incremented";

            $old->save();


            $promotion = Promotion::where('id', $old->id)->first();

            // dd($promotion);
            $promotion->status = "Successful";
            $promotion->update();

            $increment = Employee::where('emp_id', $promotion->employeeID)->first();
            $increment->salary = $promotion->newSalary*$empl->rate;
            $increment->position = $promotion->newPosition;
            $increment->emp_level = $promotion->newLevel;
            $increment->update();

            SysHelpers::FinancialLogs($id, 'Salary Increment', number_format($oldSalary * $oldRate, 2).' '.'TZS', number_format($new_salary * $oldRate,2).' '.'TZS', 'Salary Increment');

            //end iport increments



            //start import  arreas
            if (!empty($row['arrears']) && $row['arrears'] > 0) {
                $rate = $this->flexperformance_model->get_rate($row['currency']);

                $data = array(
                    'empID' => $row['emp_id'],
                    'allowance' => 40,
                    'amount' => $row['arrears'] * $rate,
                    'mode' => 1,
                    'percent' => 0 / 100,
                    'currency' => $row['currency'],
                    'rate' => $rate,
                );

                $result = $this->flexperformance_model->assign_allowance($data);

                SysHelpers::FinancialLogs($data['empID'], 'Assign ' . 'Arrears', '0', ($data['amount'] != 0) ? $data['amount'] . ' ' . $data['currency'] : $data['percent'] . '%',  'Payroll Input');
            }

        }
        }
    }
}
