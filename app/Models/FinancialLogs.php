<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialLogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'payrollno',
        'changed_by',
        'field_name',
        'action_from',
        'action_to',
        'input_screen'
    ];
}
