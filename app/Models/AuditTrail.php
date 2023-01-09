<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_trails';

    protected $fillable = [
        'emp_id',
        'emp_name',
        'action_performed',
        'ip_address',
        'user_agent',
        'risk',
    ];
}
