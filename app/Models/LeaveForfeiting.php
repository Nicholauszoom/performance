<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveForfeiting extends Model
{
    use HasFactory;
    protected $fillable = ['empID','nature','days'];
}
