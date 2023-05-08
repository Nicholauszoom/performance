<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceEvaluation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function performance()
    {
        return $this->belongsTo('App\Models\PerformancePillar','pillar_id');
    }
}
