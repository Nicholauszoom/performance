<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_email',
        'user_id',
        'action_performed',
        'ip_address',
        'user_agent',
        'risk',
    ];
}
