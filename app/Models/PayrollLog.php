<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollLog extends Model
{
    use HasFactory;

    protected $table = 'payroll_logs'; 

    protected $fillable = [
        'empID',
        'payroll_date',
        'pension_employer',
        'pension_employee',
        'receipt_date',
        'receipt_number',

    ];
}
