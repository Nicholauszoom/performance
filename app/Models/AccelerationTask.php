<?php

namespace App\Models;

use App\Models\Acceleration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccelerationTask extends Model
{
    use HasFactory;


    public function employee()
    {
        return $this->belongsTo(EMPL::class, 'assigned','emp_id');
    }
    public function acceleration()
    {
        return $this->belongsTo(Acceleration::class, 'acceleration_id','id');
    }
}
