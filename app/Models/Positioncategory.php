<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EMPL;
class PositionCategory extends Model
{
    use HasFactory;
    protected $table= 'position_category';
    
    public function position()
    {
        return $this->hasMany(Position::class, 'position_category','id');
    }
}
