<?php

namespace App\Imports;

use App\Models\LeaveForfeiting;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ClearLeavesImport implements ToCollection, WithHeadingRow
{
    private $year;

    public function __construct($year)
        {
            $this->year = $year;
        }
    public function collection(Collection $rows)
    {
        $forfeit_year = $this->year;



        foreach ($rows as $row) {
            // Check if 'Payroll Number' key exists in the row
            if (isset($row['payroll_number'])) {
                $empId = $row['payroll_number'];
                $remaining = $row['leave_days_forfeited'];
                 
                // Check if a record with the same empID and forfeiting_year exists
                // Check if a record with the same empID, forfeiting_year, or opening_balance_year exists
                    $existingRecord = LeaveForfeiting::where('empid', $empId)
                    ->where(function($query) use ($forfeit_year) {
                        $query->where('forfeiting_year', $forfeit_year)
                            ->orWhere('opening_balance_year', $forfeit_year);
                    })
                    ->first();

                    // dd($existingRecord);

                if ($existingRecord) {
                    // If a record already exists, update its attributes
                    $existingRecord->days = $remaining;
                    $existingRecord->forfeiting_year = $forfeit_year;
                    $existingRecord->save();
                } else {
                    // If no record exists, create a new one
                    LeaveForfeiting::create([
                        'empid' => $empId,
                        'nature' => 1,
                        'days' => $remaining,
                        'forfeiting_year' => $forfeit_year
                    ]);
                }
            } else {
                Log::error("Missing 'Payroll Number' key in row: " . json_encode($row));
            }
        }

    }
}
