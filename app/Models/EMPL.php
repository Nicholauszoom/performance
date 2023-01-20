<?php

namespace App\Models;

use App\Models\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EMPL extends Model
{
    use HasFactory;
    protected $table= 'employee';


    // for relationship
   public function position()
   {
	   return $this->belongsTo(Position::class, 'position','id');
   }
}
