<?php

namespace App\Models\AccessControll;

use App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departments extends Model
{
    use HasFactory;
    protected $table = 'department';

    protected $fillable = [
        'name',
        'code',
        'type',
        'department_head_id',
        'reports_to',
        'State',
        'department_pattern',
        'parent_pattern',
        'level',
        'created_by',
    ];

    function department($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as HOD,  d.* FROM department d, employee e,  (SELECT @s:=0) as s  WHERE d.hod = e.emp_id and and d.state = 1 AND d.hod='".$id."'";

		return DB::select(DB::raw($query));
	}

	function alldepartment()
	{
		$query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as HOD,  d.*, pd.name as parentdept,cs.name as CostCenterName FROM department d, department pd, employee e,cost_center as cs,  (SELECT @s:=0) as s  WHERE d.reports_to = pd.id AND d.state = 1 AND d.type = 1 AND d.cost_center_id = cs.id  AND d.hod = e.emp_id";

		return DB::select(DB::raw($query));
	}

	function inactive_department()
	{
		$query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as HOD,  d.*, pd.name as parentdept FROM department d, department pd, employee e,  (SELECT @s:=0) as s  WHERE d.reports_to = pd.id AND d.state = 0 AND d.hod = e.emp_id";

		return DB::select(DB::raw($query));
	}

}
