<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
 protected $table = 'tbl_departments';
    protected $fillable = [
        'name'
    ];
}
