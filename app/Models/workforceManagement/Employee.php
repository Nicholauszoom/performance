<?php

namespace App\Models\workforceManagement;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

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

    public function employee()
    {
        $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employees el where el.emp_id = e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature = 1 and empID = e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employees e, departments d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id = e.department and e.state=1";

		return DB::select(DB::raw($query));
    }
}
