<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'code',
        'type',
        'department_head_id',
        'reports_to',
        'State',
        'department_pattern',
        'parent_pattern',
        'level',
        'created_by',
    ];

}
