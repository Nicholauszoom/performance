<?php

namespace App\Imports;

use App\Models\LeaveForfeiting;
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
                // Update the record if 'Payroll Number' key exists
                $leave =   LeaveForfeiting::create([
                            'empID'=>$empId,
                            'nature'=> 1,
                            'days' => $remaining
                        ]);

                        Log::info($leave);
            } else {
                // Handle the case where 'Payroll Number' key is missing
                // You can log an error, skip the row, or take appropriate action.
                // For example, you can add a log message:
                Log::error("Missing 'Payroll Number' key in row: " . json_encode($row));
            }
        }
    }
}
