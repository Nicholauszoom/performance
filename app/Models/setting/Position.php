<?php

namespace App\Models\setting;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;

    public function positionFetcher($id)
	{
		$query = "SELECT * FROM position where dept_id = '".$id."' and state = 1";

        $query_linemanager = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and r.permissions like '%bs%' and e.department = '".$id."'";

		$query_country_director = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and (r.permissions like '%l%' || r.permissions like '%q%')";

        $query = DB::select(DB::raw($query));

        $query_linemanager = DB::select(DB::raw($query_linemanager));

        $query_country_director = DB::select(DB::raw($query_country_director));

		return [$query, $query_linemanager, $query_country_director] ;
	}
}
