<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveSubType extends Model
{
    use HasFactory;

    protected $table= 'leaves_subcategories';

    protected $fillable = [
        'name',
        'category_id',
        'maximum_days',
        'sex',	

    ];
    
}
