<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;


    public function employee()
    {
        return $this->belongsTo(EMPL::class, 'assigned','emp_id');
    }
}
