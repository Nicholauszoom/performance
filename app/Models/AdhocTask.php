<?php

namespace App\Models;

use App\Models\EMPL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdhocTask extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(EMPL::class, 'assigned','emp_id');
    }
}
