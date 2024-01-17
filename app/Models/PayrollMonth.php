<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollMonth extends Model
{
    use HasFactory;


    protected $fillable = [
        'payroll_date',
        'approval_status',
    ];

}
