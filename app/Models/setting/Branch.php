<?php

namespace App\Models\setting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'bank_branch';

    public function bank_branch()
	{
		$query = "SELECT @s:=@s+1 as SNo, b.name as bankname, bb.*  FROM bank b, bank_branch bb, (SELECT @s:=0) as s WHERE b.id = bb.bank";

		return DB::select(DB::raw($query));
	}


	public function bankBranchFetcher($id)
	{
		$query = "SELECT * FROM bank_branch where bank = ".$id."";

		return DB::select(DB::raw($query));
	}
}
