<?php

namespace App\Models\LearningDevelopment;

use App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
 protected $table = 'tbl_employee';
    protected $fillable = [
        'name'
    ];
}
