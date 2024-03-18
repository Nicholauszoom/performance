<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalLevel extends Model
{
    use HasFactory;

    // for relationship
    public function roles()
    {
        return $this->belongsTo(Position::class, 'role_id','id');
    }
}
