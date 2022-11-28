<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'designations';

    protected $fillable = [
        'name','status','department_id'
    ];

public function department(){
    
        return $this->belongsTo('App\Models\AccessControll\Departments','department_id');
      }

}
