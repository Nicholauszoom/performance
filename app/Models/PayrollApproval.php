<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_month_id',
        'employee_id',
        'approval_date',
        'amount',
    ];

    

}
