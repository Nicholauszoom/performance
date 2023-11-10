<?php

namespace App\Exports;

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
        return $this->approvals;
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
            'Created At',
        ];
    }
}
