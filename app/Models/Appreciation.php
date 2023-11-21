<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Appreciation extends Model
{
    protected $table = 'appreciation';

    protected $fillable = [
        'empID',
        'description',
        'date_apprd',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'empID', 'emp_id');
    }
    }
