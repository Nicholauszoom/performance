<?php

namespace App\Models;

use App\Models\EMPL;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectTask extends Model
{
    use HasFactory;


    public function employee()
    {
        return $this->belongsTo(EMPL::class, 'assigned','emp_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id','id');
    }
}
