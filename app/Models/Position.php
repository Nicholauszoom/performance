<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EMPL;
class Position extends Model
{
    use HasFactory;
    protected $table= 'position';
    
    public function employees()
    {
        return $this->hasMany(EMPL::class, 'position','id');
    }
}
