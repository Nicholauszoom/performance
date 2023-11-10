<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class LeaveApprovalsExport implements FromCollection
{
    protected $approvals;

    public function __construct(Collection $approvals)
    {
        $this->approvals = $approvals;
    }

    public function collection()
    {
        return $this->approvals;
    }
}
