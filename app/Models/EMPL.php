<?php

namespace App\Models;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EMPL extends Model
{
    use HasFactory;
    protected $table= 'employee';
    protected $fillable = ['accrual_rate'];


    // for relationship
   public function position()
   {
	   return $this->belongsTo(Position::class, 'position','id');
   }
   public function departments()
   {
       return $this->belongsTo(Department::class, 'department','id');
   }
}
