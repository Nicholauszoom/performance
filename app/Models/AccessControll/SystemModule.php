<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemModule extends Model
{
    use SoftDeletes;

    protected $table = 'sys_modules';
    protected $fillable = [
        'slug',
    ];

    public function permissions()
    {
        return $this->hasMany('App\Models\AccessControll\Permission', 'sys_module_id');


    }
}

