<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disciplinary extends Model
{
    use HasFactory;



            // for relationship
            public function employee()
            {
                return $this->belongsTo(Employee::class, 'employeeID','emp_id');
            }

            public function departments()
            {
                return $this->belongsTo(Department::class, 'department','id');
            }
}
