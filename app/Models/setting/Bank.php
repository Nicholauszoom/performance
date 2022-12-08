<?php

namespace App\Models\setting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';

    public function bank()
    {
        $query = "SELECT @s:=@s+1 as SNo, b.* FROM bank b, (SELECT @s:=0) as s";

		return DB::select(DB::raw($query));
    }
}
