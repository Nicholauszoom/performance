<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\post;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

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

 
   
  
       public function basic_details()
    {
        return $this->hasOne('App\Models\UserDetails\BasicDetails','user_id');
    }

    public function bank_details()
    {
        return $this->hasOne('App\Models\UserDetails\BankDetails','user_id');
    }
    
    public function designation(){
    
        return $this->belongsTo('App\Models\Designation','designation_id');
      }
  public function department(){
    
        return $this->belongsTo('App\Models\Departments','department_id');
      }
    use HasPermissionsTrait; //Import The Trait
}