<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'product',
        'amount',
    ];
}
