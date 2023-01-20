<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Termination extends Model
{
    use HasFactory;


        // for relationship
        public function employee()
        {
            return $this->belongsTo(Employee::class, 'employeeID','emp_id');
        }
}
