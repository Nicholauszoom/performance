<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvals extends Model
{
    use HasFactory;
    protected $table = 'approvals';

    protected $fillable = [
        'process_name',
        'levels',
        'escallation',
        'escallation_time',
    ];

    public function ApprLevels(){
        return $this->hasMany(ApprovalLevel::class, 'approval_id',);
    }
}
