<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveForfeiting extends Model
{
    use HasFactory;
    protected $fillable = ['empID','nature','days', 'forfeiting_year', 'opening-balance-year', 'opening_balance', 'adjusted_days'];

    public function employee()
{
    return $this->belongsTo(Employee::class, 'empID', 'emp_id');
}
}
