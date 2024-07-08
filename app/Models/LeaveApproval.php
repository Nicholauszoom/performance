<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{

    use HasFactory;
    protected $table= 'leave_approvals';

    protected $fillable = ['empID','level1','level2', 'level3', 'escallation_time'];


    public function employee()
    {
        return $this->belongsTo(EMPL::class, 'empID','emp_id');
    }

    public function levelOne()
    {
        return $this->belongsTo(EMPL::class, 'level1','emp_id');
    }
    public function levelTwo()
    {
        return $this->belongsTo(EMPL::class, 'level2','emp_id');
    }
    public function levelThree()
    {
        return $this->belongsTo(EMPL::class, 'level3','emp_id');
    }
}
