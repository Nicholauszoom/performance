<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeParent extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeID', 'parent_names','parent_relation','parent_birthdate','parent_residence','parent_living_status'
    ];
}
