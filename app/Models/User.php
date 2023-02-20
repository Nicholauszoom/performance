<?php

namespace App\Models;



use App\Models\post;
use App\Models\Position;
use App\Models\Department;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'employee';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'added_by',
        'status',
        'joining_date',
        'department_id',
        'designation_id',
        'disabled',
        'disabled_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function roles(){
    //     return $this->belongsTo('App\Models\Role','emp_level');
    // }

    use HasPermissionsTrait; //Import The Trait
    // for relationship
    public function positions()
    {
        return $this->belongsTo(Position::class, 'position','id');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class, 'department','id');
    }

}
