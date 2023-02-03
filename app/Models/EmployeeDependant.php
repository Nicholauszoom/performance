<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDependant extends Model
{
    use HasFactory;

    protected $fillable = [
        'employeeID', 'dep_name','dep_surname','dep_birthdate','dep_gender','dep_certificate'
    ];
}
