<?php

namespace App\Models;

use App\Models\EMPL;
use App\Models\LeaveType;
use App\Models\LeaveSubType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leaves extends Model
{
    use HasFactory;
    protected $table= 'leaves';



      // for relationship
      public function type()
      {
          return $this->belongsTo(LeaveType::class, 'nature','id');
      }

      public function employee()
      {
          return $this->belongsTo(EMPL::class, 'empID','emp_id');
      }

      public function sub_type()
      {
          return $this->belongsTo(LeaveSubType::class, 'sub_category','id');
      }
}
