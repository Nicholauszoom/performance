<?php

namespace App\Models\workforceManagement;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'emp_id',
        'old_emp_id',
        'password_set',
        'fname',
        'mname',
        'lname',
        'birthdate',
        'gender',
        'nationality',
        'merital_status',
        'hire_date',
        'department',
        'position',
        'branch',
        'shift',
        'organization',
        'line_manager',
        'contract_type',
        'contract_renewal_date',
        'salary', //DECIMALS
        'postal_address',
        'postal_city',
        'physical_address',
        'mobile',
        'email',
        'photo',
        'is_expatriate',
        'home',
        'bank',
        'bank_branch',
        'account_no',
        'pension_fund',
        'pf_membership_no',
        'username',
        'password',
        'state',
        'login_user',
        'last_updated',
        'last_login',
        'retired',
        'contract_end',
        'tin',
        'national_id',
    ];

    public function employeeData()
    {
        $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1";

		return DB::select(DB::raw($query));
    }

    public function employeelinemanager($id) {
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*,
            CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, ( SELECT
                CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT
                    sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT
                    sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.line_manager='".$id."' and e.state=1";

		return DB::select(DB::raw($query));
	}

    public function inactive_employee1()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, IF((SELECT COUNT(empID) FROM activation_deactivation WHERE state = 2 AND current_state = 0 )>0, 1, 0) as isRequested, e.last_updated as dated , CONCAT(el.fname,' ', el.mname,' ', el.lname) as LINEMANAGER FROM employee e, employee el, department d, position p, (select @s:=0) as s WHERE p.id=e.position and d.id=e.department AND el.emp_id = e.emp_id AND e.state=0 ";

		return DB::select(DB::raw($query));
	}

	public function inactive_employee2()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, ad.state as log_state, ad.current_state, ad.author as initiator,
		e.*, ad.id as logID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER FROM employee e, activation_deactivation ad,  department d, position p , (select @s:=0) as s WHERE ad.empID = e.emp_id  and  p.id=e.position and d.id=e.department and e.state = 3 and ad.state = 3  ORDER BY ad.id DESC, ad.current_state ASC ";

		return DB::select(DB::raw($query));
	}
}
