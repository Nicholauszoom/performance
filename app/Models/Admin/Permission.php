<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Permission extends Model
{
   //
   //use SoftDeletes;

    protected $fillable = [
       'id', 'slug', 'sys_module_id'
    ];

    protected $with = ['modules'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Admin\Role', 'roles_permissions');
    }

    public function modules()
    {
        return $this->belongsTo('App\Models\Admin\SystemModule', 'sys_module_id');
    }
}
