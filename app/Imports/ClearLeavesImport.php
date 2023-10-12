<?php

namespace App\Imports;

use App\Models\EMPL;
use App\Models\Leaves;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ClearLeavesImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Check if 'Payroll Number' key exists in the row
            Log::info($row);
            if (isset($row['payroll_number'])) {


                $empId = $row['payroll_number'];
                $remaining = $row['leave_days_forfeited'];
                $employee = EMPL::where('emp_id',$empId )->first();
                $accrual_rate = $employee->accrual_rate;

                $employee= EMPL::where('emp_id',$empId )->first()
                ->update(['accrual-rate',$remaining/$employee->accrual_rate] );

                // Update the record if 'Payroll Number' key exists
                $leave =   Leaves::where('empId', $empId)
                            ->where('nature', 1)
                            ->update(['remaining' => $remaining,
                                    'start'=>'00-00-0000',
                                    'end'=>'00-00-0000'
                        ]);

                $employee= EMPL::where('emp_id',$empId )->first()
                ->update(['accrual-rate',$accrual_rate] );
            } else {
                // Handle the case where 'Payroll Number' key is missing
                // You can log an error, skip the row, or take appropriate action.
                // For example, you can add a log message:
                Log::error("Missing 'Payroll Number' key in row: " . json_encode($row));
            }
        }
    }
}
