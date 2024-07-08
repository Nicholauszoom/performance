<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\LeaveApproval;
use Illuminate\Support\Facades\DB;

class LeaveApprovalsExport implements FromCollection, WithHeadings{

    protected $approvals;

    public function __construct(Collection $approvals)
    {
        $this->approvals = $approvals;
    }

    public function collection()
    {
        // Fetch approvals excluding those with empID where state = 4
        $approvals = LeaveApproval::join('employee', 'leave_approvals.empID', '=', 'employee.emp_id')
            ->where('employee.state', '!=', 4)
            ->orderBy('leave_approvals.created_at', 'asc')
            ->get(['leave_approvals.*']);

             // Initialize a counter for SN
         $sn = 1;


        // Loop through the approvals and map the details
        $approvalsWithPayrollNumbers = $approvals->map(function($approval) use(&$sn) {
            // Check if any level has state = 4 and exclude the record if tr
            $employee  = Employee::where('emp_id', $approval->empID)->value('state');
            $level1State = Employee::where('emp_id', $approval->level1)->value('state');
            $level2State = Employee::where('emp_id', $approval->level2)->value('state');
            $level3State = Employee::where('emp_id', $approval->level3)->value('state');

            // If any level has state 4, skip this approval
            if ($employee == 4) {
                return null;
            }

            return [
                'SN' => $sn++,
                'Payroll Number' => $approval->empID,
                'Employee Name' => Employee::where('emp_id', $approval->empID)->selectRaw("CONCAT(fname, ' ', lname) as full_name")->value('full_name'),
                'Level 1' =>   Employee::where('emp_id', $approval->level1)->selectRaw("CONCAT(fname, ' ', lname) as full_name")->value('full_name'),
                'Level 2' =>  Employee::where('emp_id', $approval->level2)->selectRaw("CONCAT(fname, ' ', lname) as full_name")->value('full_name'),
                'Level 3' =>  Employee::where('emp_id', $approval->level3)->selectRaw("CONCAT(fname, ' ', lname) as full_name")->value('full_name'),
                'Escallation Time' => $approval->escallation_time,
            ];
        })->filter(); // Use filter() to remove null values

        return $approvalsWithPayrollNumbers;
    }

    public function headings(): array
    {
        // Column headers based on your leave_approvals table structure
        return [
            'SN',
            'Payroll Number',
            'Employee Name',
            'Level 1',
            'Level 2',
            'Level 3',
            'Escalation Time',
        ];
    }
}
