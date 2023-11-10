<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeaveApprovalsExport implements FromCollection, WithHeadings{

    protected $approvals;

    public function __construct(Collection $approvals)
    {
        $this->approvals = $approvals;
    }

    public function collection()
    {
        return $this->approvals->map(function ($approval) {
            // dd(Employee::where('emp_id', $approval->empID)->first()->fname ?? null);
            return [
                'ID' => $approval->id,
                'Employee Name' => Employee::where('emp_id', $approval->empID)->first()->fname ?? null,
                'Level 1' =>  Employee::where('emp_id', $approval->level1)->first()->fname ?? null,
                'Level 2' => Employee::where('emp_id', $approval->level2)->first()->fname ?? null,
                'Level 3' => Employee::where('emp_id', $approval->level3)->first()->fname ?? null,
                'Escallation Time' => $approval->escallation_time,
            ];
        });
    }

    public function headings(): array
    {
        // Column headers based on your leave_approvals table structure
        return [
            'ID',
            'Employee ID',
            'Level 1',
            'Level 2',
            'Level 3',
            'Escalation Time',
        ];
    }
}
