<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';

    protected $fillable = [
        'empID',
        'platform',
        'description',
        'ip_address',
        'agent',
        'due_date',
    ];
}
