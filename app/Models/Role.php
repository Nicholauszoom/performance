<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // use HasFactory;
    // protected $table = 'role';

    // protected $fillable = [
    //     'name',
    //     'permissions'
    // ];

    protected $fillable = [
        'slug','added_by','status','price',
   ];
   protected $touches = ['permissions'];

   public function users()
   {
       return $this->belongsToMany(User::class, 'users_roles');
   }

   public function permissions()
   {
       return $this->belongsToMany(Permission::class, 'roles_permissions');
   }

   public function givePermissionTo(array $permissions)
   {
       $permissions = $this->getAllPermissions($permissions);
       if ($permissions === null) {
           return $this;
       }
       $this->permissions()->saveMany($permissions);
       return $this;
   }

   protected function getAllPermissions(array $permissions)
   {
       return Permission::whereIn('id', $permissions)->get();
   }

   // Getting all permission

   public function getPermissions(array $permissions)
   {
       return Permission::whereIn('slug', $permissions)->get();
   }

   public function hasAccess($permission)
   {
       return (bool)$this->permissions()->where('slug', $permission)->count();
   }

   public function refreshPermissions(array $permissions)
   {
       $this->permissions()->detach();
       return $this->givePermissionTo($permissions);
   }
}
