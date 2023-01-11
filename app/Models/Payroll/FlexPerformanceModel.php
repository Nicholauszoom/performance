<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlexPerformanceModel extends Model
{

	public function audit_log($description){
		$logData = array(
	       'empID' => auth()->user()->id,
	       'description' => $description,
	       'agent' =>session('agent'),
	       'platform' =>session('platform'),
	       'due_date' =>date('Y-m-d h:i:s'),
	       'ip_address' =>session('ip_address')
	    );

        DB::table('audit_logs')->insert($logData);
	}

	function audit_logs()
	{
		$query = "SELECT d.name as department, p.name as position, al.*, p.name as position, d.name as department, CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName FROM audit_trails al, employee e, position p, department d  WHERE al.emp_id = e.emp_id AND p.id = e.position AND e.department = d.id ORDER BY al.created_at DESC";

        return DB::select(DB::raw($query));
	}

	function audit_purge_logs()
	{
		$query = "SELECT  d.name as department, p.name as position, al.*, CAST(al.due_date as date) as dated,   CAST(al.due_date as time) as timed, p.name as position,  d.name as department, CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName FROM audit_purge_logs al, employee e, position p, department d  WHERE al.empID = e.emp_id AND p.id = e.position AND e.department = d.id ORDER BY al.due_date DESC";

		return DB::select(DB::raw($query));
	}

	public function clear_audit_logs() {
        DB::table('audit_logs')->truncate();

        return true;
    }

    function getCurrentStrategy()
	{
		$query = "id as strategyID  ORDER BY id DESC limit 1";

        $row =  DB::table('strategy')
        ->select(DB::raw($query))
        ->first();
    	return $row->strategyID;
	}


	function getAttributeName($attribute, $table, $referenceName, $referenceValue)
	{
		// $query = $attribute." AS attributeValue   WHERE ".$referenceName." = '".$referenceValue."' ";
		$row =  DB::table($table)
            ->select($attribute.' AS attributeValue')
            ->where($referenceName, $referenceValue)
            ->limit(1)
            ->first();

		return $row->attributeValue;
	}

	function employee() {
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1";

		return DB::select(DB::raw($query));
	}


	function employeelinemanager($id) {
		$query="SELECT @s:=@s+1 SNo,
		p.name as POSITION,
		d.name as DEPARTMENT,
		e.*,
		CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,
		(SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER,
		IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.line_manager='".$id."' and e.state=1";

		return DB::select(DB::raw($query));
	}

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

	function branch()
	{
		$query = "SELECT @s:=@s+1 as SNo, b.*,d.name as department_name FROM branch b,department d,  (SELECT @s:=0) as s WHERE b.department_id = d.id";

		return DB::select(DB::raw($query));
	}

	function costCenter()
	{
		$query = "SELECT @s:=@s+1 as SNo, c.* FROM cost_center c, (SELECT @s:=0) as s ";

		return DB::select(DB::raw($query));
	}

	function addCompanyBranch($data)
	{

        DB::table('branch')->insert($data);

        $query = " id ORDER BY id DESC LIMIT 1";
        $row =  DB::table('branch')
        ->select(DB::raw($query))
        ->first();



    	return $row->id;
	}

	function addCostCenter($data)
	{

		DB::table('cost_center')->insert($data);
		$query = "id  ORDER BY id DESC LIMIT 1";

		$row = DB::table('cost_center')
		->select(DB::raw($query))
		->first();
    	return $row->id;
	}


	function accountCodes()
	{
		$query = "SELECT @s:=@s+1 as SNo, ac.* FROM account_code ac, (SELECT @s:=0) as s ";

		return DB::select(DB::raw($query));
	}

	function addAccountCode($data)
	{
		DB::table('account_code')->insert($data);
    	return true;
	}
	function updateAccountCode($updates, $accountingId)
	{
		DB::table('account_code')->where('id', $accountingId)
		->update($updates);
		return true;
	}


	function deleteAccountCode($id)
	{
		DB::table('account_code')
		->where('id', $id)
		->delete('account_code');
		return true;
	}

	function nationality()
	{
		$query = "SELECT @s:=@s+1 as SNo, c.* FROM country c, (SELECT @s:=0) as s ";

		return DB::select(DB::raw($query));
	}

	function addEmployeeNationality($data)
	{
		DB::table('country')->insert( $data);
    	return true;
	}

	function checkEmployeeNationality($code)
	{
		$query = "COUNT(emp_id) AS counts  WHERE nationality = ".$code." ";
        $row = Db::table('employee')
		->select(DB::raw($query))
		->first();

		return $row->counts;
	}


	public function deleteCountry($id)
	{
		DB::table('country')->where('code', $id)
		->delete('country');
		return true;
	}


	function updateCompanyBranch($updates, $id)
	{
		DB::table('branch')->where('id', $id)
		->update($updates);
		return true;
	}

	function updateCostCenter($updates, $id)
	{
		DB::table('cost_center')->where('id', $id)
		->update($updates);
		return true;
	}

	function currentdepartment()
	{
		$query = "SELECT * FROM department ORDER by id DESC LIMIT 1";

		return DB::select(DB::raw($query));
	}

	function logo() {
		$query = "logo";
		$row = DB::table('company_info')
		->select(DB::raw($query))
		->first();

    	return $row->logo;
	}

	function contractdrop()
	{
		$query = "SELECT c.* FROM contract c WHERE NOT c.id = 1";

		return DB::select(DB::raw($query));
	}

	function contract()
	{
		$query = "SELECT @s:=@s+1 as SNo, c.* FROM contract c,  (SELECT @s:=0) as s WHERE c.state = 1";

		return DB::select(DB::raw($query));
	}
	function contractAdd($data)
	{
		DB::table('contract')->insert($data);
		return true;

	}





	//upload users(employees)
	function uploadEmployees($data){
		foreach($data as $employee){
			$this->employeeAdd($employee);
		}
	 	echo 'Employees Imported successfully';

	}




	/*function custom_attendees($date)
	{
		$query = "SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(att.due_in as date) as DATE_IN,  CAST(att.due_in as time) as time_in,  CAST(att.due_out as time) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '".$date."'  ";

		return DB::select(DB::raw($query));
	}*/


	/*
	IMPREST FUNCTIONS MOVED TO IMPREST MODEL
	*/


	function my_overtimes($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, ROUND( (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60), 2) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id and e.department = d.id and e.position = p.id and eo.empID = '".$id."' ORDER BY eo.id DESC";

		return DB::select(DB::raw($query));
	}

	function fetch_my_overtime($id)
	{
		$query = "SELECT eo.*, CONCAT(eo.time_start,' - ',eo.time_end) as timeframe 	FROM  employee_overtime eo WHERE eo.id =".$id."";

		return DB::select(DB::raw($query));
	}

	function all_overtimes()
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment, eo.reason as reason,  eo.status as status, eo.id as eoid, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id and e.department = d.id and e.position = p.id";

		return DB::select(DB::raw($query));
	}

	function overtimesLinemanager($lineID)
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id and e.department = d.id and e.position = p.id AND e.line_manager = '".$lineID."' ORDER BY eo.id DESC";

		return DB::select(DB::raw($query));
	}

	function allOvertimes($empID) {
		$query = "SELECT @s:=@s+1 as SNo, eo.linemanager as manager, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE NOT  eo.empID = '".$empID."' and e.department = d.id and eo.empID = e.emp_id  and e.position = p.id   ORDER BY eo.id DESC";

		return DB::select(DB::raw($query));
	}

	function lineOvertimes($id){
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE   eo.linemanager = '".$id."' and e.department = d.id and eo.empID = e.emp_id  and e.position = p.id   ORDER BY eo.id DESC";

		//$query = "SELECT *  FROM employee_overtime WHERE linemanager = '".$id."'";
		return DB::select(DB::raw($query));
	}

	function overtimesHR()
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id AND e.department = d.id AND e.position = p.id AND  eo.status IN(2,4,5) ORDER BY eo.id DESC";

		return DB::select(DB::raw($query));
	}


	function get_linemanagerID($id){
		// $query = "SELECT line_manager  FROM employee WHERE emp_id = '".$id."' LIMIT 1";

        $query = DB::table('employee')->select('line_manager')->where('emp_id', $id)->limit(1)->first();

        // dd($query->line_manager);

        // return DB::select(DB::raw($query));
        return $query->line_manager;

	}

	function approvedOvertimes()
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, o.status AS payment_status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, overtimes o, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id AND e.department = d.id AND e.position = p.id AND eo.id = o.overtimeID AND  eo.status IN(2,4,5) ORDER BY eo.id DESC";
		return DB::select(DB::raw($query));
	}


	function waitingOvertimes_hr()
	{
		$query = "SELECT * FROM employee_overtime WHERE status =1";
		return DB::select(DB::raw($query));
	}
	function waitingOvertimes_fin()
	{
		$query = "SELECT * FROM employee_overtime WHERE status =3";
		return DB::select(DB::raw($query));
	}
	function waitingOvertimes_appr()
	{
		$query = "SELECT * FROM employee_overtime WHERE status =4";
		return DB::select(DB::raw($query));
	}
	function waitingOvertimes_line($id)
	{
		$query = "SELECT * FROM employee_overtime WHERE linemanager ='".$id."' AND status =0";
		return DB::select(DB::raw($query));
	}












	function overtimes()
	{
		$query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, o.status AS payment_status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, overtimes o, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id AND e.department = d.id AND e.position = p.id AND eo.id = o.overtimeID AND  eo.status = 0 ORDER BY eo.id DESC";

		return DB::select(DB::raw($query));
	}

    function fetchOvertimeComment($id)
	{
		$query = "SELECT id, final_line_manager_comment as comment, commit  FROM employee_overtime WHERE id = '".$id."'  ";

		return DB::select(DB::raw($query));
	}

	public function apply_overtime($data)
	{
		DB::table('employee_overtime')->insert($data);
		return true;
	}

    function update_overtime($data, $id)
	{
		DB::table('employee_overtime')
            ->where('id', $id)
		    ->update($data);

        return true;
	}

    public function deny_overtime($id)
	{
	    DB::transaction(function() use($id)
        {
	        $query = "UPDATE employee_overtime SET status = 4 WHERE id ='".$id."'";

		    DB::insert(DB::raw($query));

	        $query = "DELETE FROM overtimes WHERE overtimeID ='".$id."'";

		    DB::insert(DB::raw($query));
	    });

		return true;
	}

    function confirmOvertimePayment($id, $status)
	{


	    $query = "UPDATE  overtimes SET status = ".$status." WHERE overtimeID ='".$id."'";
		DB::insert(DB::raw($query));

		return true;
	}


    function get_payment_per_hour($overtimeID)
	{
	    $query = "ROUND((salary/30), 2) as payment WHERE emp_id = (SELECT empID FROM employee_overtime WHERE id =".$overtimeID.") ";
		$row = DB::table('employee')
		->select(DB::raw($query))
		->first();
		return $row->payment;
	}

    function get_overtime_type($overtimeID)
	{
	    $query = "overtime_type as type  WHERE id =".$overtimeID." ";
		$row = DB::table('employee_overtime')
		->select(DB::raw($query))
		->first();
		return $row->type;
	}

    function checkApprovedOvertime($overtimID)
	{
		$row = DB::table('employee_overtime')
		    ->select(DB::raw('COUNT(id) as counts'))
            ->where('id', $overtimID)
            ->where('status', 2)
            ->limit(1)
		    ->first();

		return $row->counts;
	}



    function approveOvertime($id, $signatory, $time_approved) {
	     DB::transaction(function() use($id,$signatory, $time_approved)
       {
		$query = "INSERT INTO overtimes(overtimeID, empID, time_start, time_end, amount, linemanager, hr, application_time, confirmation_time, approval_time) SELECT eo.id, eo.empID, eo.time_start, eo.time_end, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))),((e.salary/240)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))) )) AS amount, eo.linemanager, '".$signatory."', eo.application_time, eo.time_confirmed_line, '".$time_approved."' FROM employee e, employee_overtime eo WHERE e.emp_id = eo.empID AND eo.id = '".$id."'  ";
         DB::insert(DB::raw($query));
	    $query = "UPDATE employee_overtime SET status = 2, cd ='".$signatory."', time_approved_cd = '".$time_approved."'  WHERE id ='".$id."'";
		DB::insert(DB::raw($query));
	    });

		return true;
	}

	public function lineapproveOvertime($id, $time_approved) {

        $query = DB::transaction(function() use($id, $time_approved)
                {
                    $query = "UPDATE employee_overtime SET status = 1, time_recommended_line ='".$time_approved."'  WHERE id ='".$id."'";

                    DB::insert(DB::raw($query));

                    return true;
                });

		return $query;
	}

	function hrapproveOvertime($id,$signatory, $time_approved) {
	     DB::transaction(function() use($id,$signatory, $time_approved)
       {
	    $query = "UPDATE employee_overtime SET status = 3, hr ='".$signatory."',time_approved_hr ='".$time_approved."'  WHERE id ='".$id."'";
		DB::insert(DB::raw($query));
	});

		return true;
	}
	function fin_approveOvertime($id,$signatory, $time_approved) {
	     DB::transaction(function() use($id,$signatory, $time_approved)
       {
	    $query = "UPDATE employee_overtime SET status = 4, finance='".$signatory."',time_approved_fin ='".$time_approved."'  WHERE id ='".$id."'";
		DB::insert(DB::raw($query));
	});

		return true;
	}


	public function deleteOvertime($id) {

        DB::table('employee_overtime')->where('id',$id)->delete();
        return true;
    }



	function getcontractbyid($id)
	{
		$data = DB::table('contract')->where('id', $id)
		->select(DB::raw('*'));

		return $data;
	}

	function updatecontract($data, $id)
	{
		DB::table('contract')->where('id', $id)
		->update($data);
		return true;
	}

	function contract_expiration()
	{
		$query = "SELECT

(SELECT count(e.emp_id) FROM employee e, contract c WHERE e.state=1 and c.id = e.contract_type and e.contract_type = 2 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder) as TEMPO,

(SELECT count(e.emp_id) FROM employee e, contract c WHERE e.state=1 and c.id = e.contract_type and e.contract_type = 4 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder) as INTERN,

(SELECT count(emp_id) FROM employee  WHERE state=1 and (DATEDIFF(CURRENT_DATE(), birthdate)/30) >= 12*(SELECT duration from contract where id = 1)) as RETIRE";

		return DB::select(DB::raw($query));
	}


	function contract_expiration_list()
	{
		$query = "SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION, e.hire_date as DATE_HIRED, e.contract_renewal_date LAST_RENEW_DATE, c.name as Contract_TYPE, c.duration as CONTRACT_DURATION, (DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30) as CONTRACT_AGE, ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) as TIME_TO_EXPIRE FROM employee e, contract c, position p, department d, (SELECT @s:=0) as s WHERE e.state=1 and e.department = d.id and e.position = p.id and c.id = e.contract_type and NOT e.contract_type = 3 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder";

		return DB::select(DB::raw($query));
	}

function retire_list()
	{
		$query = "SELECT @s:=@s+1 as SNo, parent_query.* FROM (SELECT  e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName, d.name as department, p.name as position, e.hire_date as date_hired, (SELECT notify_before FROM retire WHERE id = 1) as notify_before,  e.birthdate as birthdate, (SELECT retire_age FROM retire WHERE id = 1)-((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as ages_to_retire, ((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as age FROM employee e,department d, position p  WHERE e.state=1 AND e.department = d.id and e.position = p.id) as parent_query,(SELECT @s:=0) as s WHERE ages_to_retire <= notify_before";
		return DB::select(DB::raw($query));
	}

	function inactive_employee1()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, IF((SELECT COUNT(empID) FROM activation_deactivation WHERE state = 2 AND current_state = 0 )>0, 1, 0) as isRequested, e.last_updated as dated , CONCAT(el.fname,' ', el.mname,' ', el.lname) as LINEMANAGER FROM employee e, employee el, department d, position p, (select @s:=0) as s WHERE p.id=e.position and d.id=e.department AND el.emp_id = e.emp_id AND e.state=0 ";

		return DB::select(DB::raw($query));
	}

	function inactive_employee2()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, ad.state as log_state, ad.current_state, ad.author as initiator,
		e.*, ad.id as logID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER FROM employee e, activation_deactivation ad,  department d, position p , (select @s:=0) as s WHERE ad.empID = e.emp_id  and  p.id=e.position and d.id=e.department and e.state = 3 and ad.state = 3  ORDER BY ad.id DESC, ad.current_state ASC ";

		return DB::select(DB::raw($query));
	}

	function inactive_employee3()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, ad.state as log_state, ad.current_state, ad.author as initiator,
		e.*, ad.id as logID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER FROM employee e, activation_deactivation ad,  department d, position p , (select @s:=0) as s WHERE ad.empID = e.emp_id  and  p.id=e.position and d.id=e.department and e.state = 4  ORDER BY ad.id DESC, ad.current_state ASC ";

		return DB::select(DB::raw($query));
	}

	function updateemployeestatelog($data, $id)
	{
		$state = $data['state'];
		$empID = $data['empID'];
		$query = "UPDATE employee SET state = '".$state."' WHERE emp_id = '".$empID."'";
		DB::insert(DB::raw($query));

		DB::table('activation_deactivation')->where('id', $id)
		->update($data);
		return true;
	}

	function insert_user_password($data)
	{
		DB::table('user_passwords')->insert($data);
		return true;
	}

	public function employeeTransfer($data)
	{
		DB::table('transfer')->insert($data);

		return true;
	}

	function get_comment($date){
		$row = DB::table('payroll_comments')
		->where('payroll_date',$date)
		->select('message')
		->first();

		return $row->message;

	}



	function employeeTransfers()
	{
		$query="SELECT @s:=@s+1 SNo, p.name as position_name, d.name as department_name, br.name as branch_name, tr.*, CONCAT(e.fname,'  ', e.lname) as empName FROM employee e, transfer tr, department d, position p, branch br, (SELECT @s:=0) as s WHERE tr.empID = e.emp_id AND e.branch = br.id AND  p.id=e.position AND d.id=e.department  ORDER BY tr.id DESC ";

		return DB::select(DB::raw($query));
	}

	function newDepartmentTransfer($id){

		$query = "name WHERE id = '".$id."' ";
		$row = DB::table('department')
		->select(DB::raw($query))
		->first();
    	return $row->name;
	}

	function newPositionTransfer($id){

		$query = "name WHERE id = '".$id."'";
		$row = DB::table('position')
		->select(DB::raw($query))
		->first();
    	return $row->name;
	}

	function newBranchTransfer($id){

		$query = "name WHERE id = '".$id."'";
		$row = DB::table('branch')
		->select(DB::raw($query))
		->first();
    	return $row->name;
	}


	public function pendingSalaryTranferCheck($empID){

        $row = DB::table('transfer')->where( 'empID', $empID)->where('status' , 0)->where('parameterID' , 1)->count();

    	return $row;
	}

    public function pendingPositionTranferCheck($empID){

        $row = DB::table('transfer')->where( 'empID', $empID)->where('status' , 0)->where('parameterID' , 2)->count();

    	return $row;
	}

	public function pendingDepartmentTranferCheck($empID){

        $row = DB::table('transfer')->where( 'empID', $empID)->where('status' , 0)->where('parameterID' , 3)->count();

        return $row;
	}

    public function pendingBranchTranferCheck($empID){

        $row = DB::table('transfer')->where( 'empID', $empID)->where('status' , 0)->where('parameterID' , 4)->count();

        return $row;
	}

	function getTransferInfo($transferID)
	{
		$query = "SELECT transfer.* FROM transfer WHERE id = '".$transferID."' ";
    	return DB::select(DB::raw($query));
	}

	function confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID)
	{
		 DB::transaction(function() use($empUpdates, $transferUpdates, $empID, $transferID)
       {

		DB::table('employee as em')->where('em.emp_id', $empID)
		->update($empUpdates);

		DB::table('transfer as tr')->where('tr.id', $transferID)
		->update($transferUpdates);
		});
    	return true;
	}

	function cancelTransfer($transferID)
	{

		DB::table('transfer')->where('id', $transferID)
		->delete('transfer');
    	return true;
	}


	function departmentAdd($departmentData)
	{
		 DB::transaction(function() use($departmentData)
       {
		DB::table('department')->insert($departmentData);
// 		->insert("position", $positionData);

	});

	$query = "SELECT id as depID FROM department ORDER BY id DESC LIMIT 1";

    return DB::select(DB::raw($query));
	}


	function updateDepartmentPosition($code, $departmentID )
	{
		 DB::transaction(function() use($code, $departmentID)
       {
		$query = "UPDATE department SET code = '".$code."' WHERE id ='".$departmentID."'";
		DB::insert(DB::raw($query));
// 		$query = "UPDATE position SET dept_id = '".$departmentID."', dept_code = '".$code."' WHERE id ='".$positionID ."'";
		});
		return true;
	}

	function getdepartmentbyid($id)
	{
		$query = "SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname) as HOD, d.* FROM department d, employee e WHERE d.hod = e.emp_id and
			d.id ='".$id."'";

		return DB::select(DB::raw($query));
	}
	function updatedepartment($data, $id)
	{
		DB::table('department')->where('id', $id)
		->update($data);
		return true;
	}



	function getaccountability($id)
	{

		$query = "SELECT  @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as AUTHOR,  acc.* FROM accountability acc, employee e, (SELECT @s:=0) as s  WHERE acc.author = e.emp_id and acc.position_ref ='".$id."'";

		return DB::select(DB::raw($query));
	}

	function updateposition($data, $id)
	{
		DB::table('position')->where('id', $id)
		->update($data);
		return true;
	}



	function getpositionbyid($id)
	{
		$query = "SELECT p.*, ol.name as organization_level_name FROM position p, organization_level ol WHERE p.organization_level=ol.id AND p.id =".$id."";

		return DB::select(DB::raw($query));
	}


	function addposition($data)
	{
		DB::table('position')->insert($data);
		return true;

	}

	function addOrganizationLevel($data)
	{
		DB::table('organization_level')->insert($data);
		return true;

	}

	function getAllOrganizationLevel()
	{
		$query = "SELECT ol.* FROM organization_level ol";

		return DB::select(DB::raw($query));
	}

	function organization_level_info($id)
	{
		$query = "SELECT ol.* FROM organization_level ol WHERE ol.id = ".$id."";

		return DB::select(DB::raw($query));
	}

	function updateOrganizationLevel($data, $id)
	{
		DB::table('organization_level')->where('id', $id)
		->update($data);
		return true;
	}

	function addAccountability($data)
	{
		DB::table('accountability')->insert($data);

	}


	############################LEARNING AND DEVELOPMENT(TRAINING)#############################


	function getskills($id)
	{

		$query = "SELECT  @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as AUTHOR,  s.* FROM skills s, employee e, (SELECT @s:=0) as s  WHERE s.created_by = e.emp_id and s.isActive = '1' and s.position_ref ='".$id."'";

		return DB::select(DB::raw($query));
	}


	function confirm_graduation($data, $id)
	{
		DB::table('confirmed_trainee')->where('id', $id)
		->update($data);
		return true;
	}

	function updateTrainingRequest($data, $id)
	{
		DB::table('training_application')->where('id', $id)
		->update($data);
		return true;
	}

	function confirmTrainingRequest($data, $requestID)
	{
		 DB::transaction(function() use($data, $requestID)
       {
		DB::table('training_application')->where('id', $requestID)
		->update($data);
		$query = "INSERT INTO confirmed_trainee (skillsID, empID, cost, recommended_by, date_recommended, approved_by, date_approved, confirmed_by, date_confirmed, application_date, accepted_by, date_accepted, certificate, remarks)  SELECT skillsID, empID, sk.amount, recommended_by, date_recommended, approved_by, date_approved, confirmed_by, date_confirmed, application_date, '','2010-10-10', '','' FROM training_application, skills sk WHERE sk.id = training_application.id AND training_application.id = ".$requestID." ";
		DB::insert(DB::raw($query));

		});
		return true;
	}

	function unconfirmTrainingRequest($data, $requestID)
	{
		 DB::transaction(function() use($data, $requestID)
       {
		DB::table('training_application')->where('id', $requestID)
		->update($data);
		$query = "DELETE FROM confirmed_trainee WHERE empID = (SELECT empID FROM training_application WHERE id = ".$requestID." ) AND skillsID = (SELECT skillsID FROM training_application WHERE id = ".$requestID." ) ";
        DB::insert(DB::raw($query));
		});
		return true;
	}



	public function deleteTrainingRequest($requestID) {

		$query = "DELETE FROM training_application WHERE id = '".$requestID."'";
		DB::insert(DB::raw($query));
		$this->audit_log("Deleted Training Request with ID =".$requestID." ");
        return true;

    }


	function budget() {
		$query = "SELECT  @s:=@s+1 as SNo, tb.* FROM training_budget tb, (SELECT @s:=0) as s";
		return DB::select(DB::raw($query));
	}


	function getBudget($budgetID) {
		$query = "SELECT  @s:=@s+1 as SNo, tb.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as primary_personel FROM training_budget tb, employee e,(SELECT @s:=0) as s WHERE tb.id =  ".$budgetID." AND e.emp_id = tb.recommended_by";
		return DB::select(DB::raw($query));
	}

	function accepted_applications(){

	    $query = "SELECT @s:=@s+1 as SNo, ct.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name,   p.name as position, d.name as department FROM confirmed_trainee ct, position p, department d, (SELECT @s:=0) as s, skills sk, employee e WHERE e.emp_id = ct.empID and sk.id = ct.skillsID and e.position = p.id and e.department = d.id";
	    return DB::select(DB::raw($query));


	}

	function total_training_cost()
	{

		$query = "SUM(ct.cost) as cost WHERE ct.status = 0";
		$row = DB::table('confirmed_trainee as ct')
		->select(DB::raw($query))
		->first();
		return $row->cost;
	}

	function addBudget($data)
	{
		DB::table('training_budget')->insert($data);
		$this->audit_log("Created New Training Budget");
		return true;

	}

	public function deleteBudget($budgetID) {

		$query = "DELETE FROM training_budget WHERE id = '".$budgetID."'";
		DB::insert(DB::raw($query));
		$this->audit_log("Deleted Training Budget");
        return true;

    }


	function updateBudget($data, $budgetID)
	{
		 DB::transaction(function() use($data, $budgetID)
       {
		DB::table('training_budget')->where('id', $budgetID)
		->update($data);
		$this->audit_log("Updated the Training Budget");
		});
		return true;
	}


	function assignskills($data)
	{
		DB::table('emp_skills')->insert($data);
		return true;

	}

	function getSkillsName($skillsID)
	{
		$query = "name  WHERE id = ".$skillsID."";
		$row = DB::table('skills')
		->select(DB::raw($query))
		->first();
		return $row->name;
	}

	function requestTraining($data)
	{
		DB::table('training_application')->insert($data);
		return true;

	}
	function addskills($data)
	{
		DB::table('skills')->insert($data);

	}


	function updateskills($data, $id)
	{
		DB::table('skills')->where('id', $id)
		->update($data);
		return true;
	}

	function skill_gap()
	{
		$query = "SELECT  @s:=@s+1 as SNo, e.emp_id,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, p.name as position, d.name as department, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory FROM  skills sk, employee e, department d, position p, (SELECT @s:=0) as s  WHERE e.position = p.id and e.department = d.id and sk.mandatory = 1 and e.position = sk.position_ref and sk.id NOT IN(SELECT es.skill_ID from emp_skills es WHERE es.empID = e.emp_id ) AND CONCAT(sk.id,'',e.emp_id) NOT IN(SELECT CONCAT(skillsID,'',empID) FROM confirmed_trainee)";

		return DB::select(DB::raw($query));
	}


	function checkCourseExistance($course, $empID)
	{
		$query = " COUNT(es.id) as result  WHERE es.empID = ".$empID." AND es.skill_ID  = ".$course." ";
		$row = DB::table('emp_skills as es')
		->select(DB::raw($query))
		->first();
		return $row->result;
	}

	function my_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* , sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND ta.empID = '".$empID."' ";

	    return DB::select(DB::raw($query));
	}

	function other_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* , sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID  ";

	    return DB::select(DB::raw($query));
	}

	function all_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '".$empID."' OR ta.status IN(1,2,3,5,6))";

	    return DB::select(DB::raw($query));
	}

	function appr_conf_training_applications()
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND  ta.status IN(1,2,3,5,6) ";

	    return DB::select(DB::raw($query));
	}

	function appr_line_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '".$empID."' OR ta.status IN(1,2,5)) ";

	    return DB::select(DB::raw($query));
	}

	function conf_line_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '".$empID."' OR ta.status IN(2,3,6)) ";

	    return DB::select(DB::raw($query));
	}

	function line_training_applications($empID)
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND e.line_manager = '".$empID."' ";

	    return DB::select(DB::raw($query));
	}

	function appr_training_applications()
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ta.status IN(1,2,5) ";

	    return DB::select(DB::raw($query));
	}

	function conf_training_applications()
	{
	    $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ta.status IN(2,3,6) ";

	    return DB::select(DB::raw($query));
	}

	function all_skills($empID)
	{
		$query = "SELECT s.*  FROM skills s WHERE s.id NOT IN(SELECT skill_ID FROM emp_skills WHERE empID = '".$empID."' ) AND s.id NOT IN(SELECT skill_ID FROM emp_skills WHERE empID = '".$empID."' ) AND s.id NOT IN(SELECT skillsID FROM training_application WHERE empID = '".$empID."')";

		return DB::select(DB::raw($query));
	}

	function skills_have($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, es.empID, es.skill_ID, s.name as NAME  FROM emp_skills es,  skills s, (SELECT @s:=0) as s where es.skill_ID = s.id and es.empID = '".$id."' ";

		return DB::select(DB::raw($query));
	}


	function requested_skills($empID)
	{
		$query = "SELECT (@s:=@s+1) as SNo, sk.*, ta.status as request_status, ta.* FROM skills sk, training_application ta,  (SELECT @s:=0) as s where sk.id = ta.skillsID AND ta.empID ='".$empID."'";

		return DB::select(DB::raw($query));
	}
	function skills_missing($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, sk.*, IF((SELECT COUNT(skillsID) from training_application WHERE skillsID = sk.id AND empID = '".$empID."')>0, (SELECT status FROM training_application WHERE skillsID = sk.id AND empID = '".$empID."'), 9) AS status FROM skills sk, (SELECT @s:=0) as s where sk.position_ref = (SELECT position from employee where emp_id ='".$empID."' ) and sk.id NOT IN(SELECT skill_ID from emp_skills WHERE empID = '".$empID."') ";


		return DB::select(DB::raw($query));
	}
	##############################END LEARNING AND DEVELOPMENT(TRAINING)#############################


	function getEmployeeName_and_email($empID)
	{
		$query = "CONCAT(fname,' ', mname,' ', lname) as name, email,birthdate  WHERE emp_id = '".$empID."'  ";
		$row = DB::table('employee')
		->select(DB::raw($query))
		->count();

		if($row>0) {
			$query = "SELECT CONCAT(fname,' ', mname,' ', lname) as name, email,birthdate from employee  WHERE emp_id = '".$empID."'  ";
			return DB::select(DB::raw($query));
		} else{
			return false;
		}
	}

	function getEmployeeNameByemail($email)
	{
		$query = "CONCAT(fname,' ', mname,' ', lname) as name, email,emp_id,birthdate,account_no  WHERE state != 4 and email = '".$email."'  ";
		$row = DB::table('employee')
		->select(DB::raw($query))
		->count();
		if($row>0) {
			$query = "SELECT CONCAT(fname,' ', mname,' ', lname) as name, email,emp_id,birthdate,account_no FROM  employee WHERE state != 4 and email = '".$email."'  ";
			return DB::select(DB::raw($query));
		} else{
			return false;
		}
	}

	function userprofile($empID)
	{
		$query = "SELECT e.*, bank.name as bankName, ctry.name as country, b.name as branch_name,  bb.name as bankBranch, d.name as deptname, c.name as CONTRACT, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as LINEMANAGER from employee e, department d, contract c, country ctry, position p, bank, branch b, bank_branch bb WHERE d.id=e.department and p.id=e.position and e.contract_type = c.id AND e.bank_branch = bb.id and ctry.code = e.nationality AND e.bank = bank.id AND e.branch = b.code AND e.emp_id ='".$empID."'";
		return DB::select(DB::raw($query));
	}

	function shift()
	{
		$query = "SELECT  shift.*, DATE_FORMAT(start_time, '%H:%i') as STARTtime , DATE_FORMAT(end_time, '%H:%i') as ENDtime FROM shift";
		return DB::select(DB::raw($query));
	}



	function getLinemanager($id)
	{
		$query = "SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname) as LINEMANAGER, FROM employee e, WHERE d.id=e.department and p.id=e.position and e.emp_id ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function getkin($id)
	{
		//$this->load->database();
		$data =DB::table('next_of_kin')->where('employee_fk', $id)
		 ->select('*');
		return $data->get();

	}

	function getproperty($id)
	{
		$query = "SELECT  @s:=@s+1 as SNo, cp.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as PROVIDER FROM employee e, company_property cp, (SELECT @s:=0) as s WHERE cp.given_by =e.emp_id and cp.given_to='".$id."' and cp.isActive = 1";
		return DB::select(DB::raw($query));

	}

	function getpropertyexit($id)
	{
		$query = "SELECT  @s:=@s+1 as SNo, cp.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as PROVIDER FROM employee e, company_property cp, (SELECT @s:=0) as s WHERE cp.given_by =e.emp_id and cp.given_to='".$id."'";
		return DB::select(DB::raw($query));

	}

	function getactive_properties($id)
	{
		$query = "SELECT COUNT(cp.id) as ACTIVE_PROPERTIES FROM company_property cp WHERE cp.isActive=1 and cp.given_to='".$id."'";
		return DB::select(DB::raw($query));

	}



	function employee_exit($data)
	{
		$empID = $data['empID'];
		$initiator = $data['initiator'];
		$reason = $data['reason'];
		$date_confirmed = $data['date_confirmed'];
		$confirmed_by = $data['confirmed_by'];
		$exit_date = $data['exit_date'];

		$query  = "INSERT INTO exit_list (empID, initiator, reason, date_confirmed,confirmed_by, exit_date) VALUES ('".$empID."', '".$initiator."', '".$reason."','".$date_confirmed."','".$confirmed_by."','".$exit_date."')";
        DB::insert(DB::raw($query));
		//			->insert("exit_list", $data);
		//update the employee table state
		$query = "UPDATE employee SET state = '3', contract_end = '".$exit_date."' WHERE emp_id = '".$empID."'";
		DB::insert(DB::raw($query));

	}


	#############################LOANS AND DEDUCTIONS####################################

	function deduction()
	{
		$query='SELECT @s:=@s+1 SNo, d.* FROM deduction d, (SELECT @s:=0) as s where is_active = 1 AND d.id NOT IN(7,8)';

		return DB::select(DB::raw($query));
	}

	function overtime_allowances()
	{
		$query='SELECT oc.* FROM overtime_category oc';

		return DB::select(DB::raw($query));
	}

	function updatededuction($data, $id)
	{
		DB::table('deduction')->where('id', $id)
		->update($data);
		return true;
	}


	function addDeduction($data)
	{
		DB::table('deductions')->insert($data);
		return true;

	}


function getDeductionById($deductionID)
	{
		$query='SELECT ded.name as name,  ded.* FROM deductions ded WHERE  ded.id ='.$deductionID.'';

		return DB::select(DB::raw($query));
	}


function getcommon_deduction($id)
	{
		$query="SELECT d.* FROM deduction d WHERE id = ".$id." ";

		return DB::select(DB::raw($query));
	}

function getMeaslById($deductionID)
	{
		$query='SELECT * FROM meals_deduction  WHERE id ='.$deductionID.'';

		return DB::select(DB::raw($query));
	}


	//UPDATE DEDUCTIONS

	function updatePension($data, $id)
	{
		DB::table('pension_fund')->where('id', $id)
		->update($data);
		return true;

	}


	function updateDeductions($updates, $deductionID)
	{
		DB::table('deductions')->where('id', $deductionID)
		->update($updates);
	;
		return true;

	}

	function updateCommonDeductions($data, $id)
	{
		DB::table('deduction')->where('id', $id)
		->update($data);

		return true;

	}

	function updateMeals($updates, $deductionID)
	{
		DB::table('meals_deduction')->where('id', $deductionID)
		->update($updates);
		return true;

	}

	function get_deduction_group_in( $deduction)
	{
		$query = "SELECT DISTINCT  g.name as NAME, g.id as id FROM groups g, emp_deductions ed  WHERE g.id = ed.group_name and ed.deduction = ".$deduction."";

		return DB::select(DB::raw($query));
	}

	function assign_deduction($data)
	{
		DB::table('emp_deductions')->insert($data);
		return true;

	}


   public function remove_individual_deduction($empID, $deductionID)
    {
        DB::table('emp_deductions')->where('empID', $empID)
        ->where('group_name', 0)
        ->where('deduction', $deductionID)
        ->delete();
        return true;
    }


   public function remove_group_deduction($groupID, $deductionID)
    {
		DB::table('emp_deductions')->where('group_name', $groupID)
        ->where('deduction', $deductionID)
        ->delete();
        return true;
    }



	function get_deduction_members($deduction, $group)
	{
		$query = "SELECT empID from employee_group WHERE group_name = ".$group." and empID NOT IN (SELECT empID from emp_deductions where deduction = ".$deduction.")";

		return DB::select(DB::raw($query));
	}

	function employee_deduction($deduction) {
	$query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE e.state = 1 AND  e.emp_id NOT IN (SELECT empID from emp_deductions WHERE deduction = ".$deduction." AND group_name = 0 ) ";
    return DB::select(DB::raw($query));
    }


	function deduction_membersCount($deduction)
	{
		$query = "SELECT COUNT(DISTINCT ed.empID) members FROM  emp_deductions ed WHERE ed.deduction = ".$deduction."  ";

		$row = DB::select(DB::raw($query));

    	return $row[0]->members;
	}


	function deduction_individual_employee($deduction)
	{
		$query = "SELECT @s:=@s+1 SNo, e.emp_id as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_deductions ed, (SELECT @s:=0) as s WHERE e.emp_id = ed.empID and ed.group_name = 0 and ed.deduction = ".$deduction."  ";

		return DB::select(DB::raw($query));
	}


	function deduction_customgroup($deductionID)
	{
		$query = "SELECT * FROM groups WHERE id NOT IN(SELECT group_name FROM emp_deductions WHERE deduction =  ".$deductionID." ) AND type = 1 ";

		return DB::select(DB::raw($query));
	}





#############################DEDUCTIONS####################################


function allowance()
	{
		$query='SELECT @s:=@s+1 SNo, a.* FROM allowances a, (SELECT @s:=0) as s';

		return DB::select(DB::raw($query));
	}

function addToBonus($data)
	{
		$result = DB::table("bonus")->insert($data);
		return $result;

	}

function updateBonus($data, $id)
	{
		DB::table('bonus')->where('id', $id)
		->update($data);
		return true;
	}
public function deleteBonus($id) {

	DB::table('bonus')->where('id', $id)
	->delete();
    return true;

	}

function addBonusTag($data)
	{
		DB::table('bonus_tags')->insert($data);
		return true;

	}

function deductions()
	{
		$query='SELECT @s:=@s+1 SNo,  ded.* FROM deductions ded,  (SELECT @s:=0) as s ';

		return DB::select(DB::raw($query));
	}

function pension_fund()
	{
		$query='SELECT @s:=@s+1 SNo, pf.* FROM pension_fund pf, (SELECT @s:=0) as s';

		return DB::select(DB::raw($query));
	}

function getPensionById($deductionID)
	{
		$query='SELECT  pf.* FROM pension_fund pf WHERE pf.id = '.$deductionID.'';

		return DB::select(DB::raw($query));
	}

function meals_deduction()
	{
		$query='SELECT @s:=@s+1 SNo, meals_deduction.* FROM meals_deduction, (SELECT @s:=0) as s LIMIT 1';

		return DB::select(DB::raw($query));
	}


	function getallowancebyid($id)
	{
		$query = "SELECT * FROM allowances WHERE id =".$id."";

		return DB::select(DB::raw($query));
	}

	function get_allowance_members($allowance, $group)
	{
		$query = "SELECT empID from employee_group WHERE group_name = ".$group." and empID NOT IN (SELECT empID from emp_allowances where allowance = ".$allowance.")";

		return DB::select(DB::raw($query));
	}

	function get_allowance_group_in( $allowance)
	{
		$query = "SELECT DISTINCT  g.name as NAME, g.id as id FROM groups g, emp_allowances ea  WHERE g.id = ea.group_name and ea.allowance = ".$allowance."";

		return DB::select(DB::raw($query));
	}

	function get_individual_employee($allowance)
	{
		$query = "SELECT @s:=@s+1 SNo, e.emp_id as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_allowances ea, (SELECT @s:=0) as s WHERE e.emp_id = ea.empID and ea.group_name = 0 and ea.allowance = ".$allowance."  ";

		return DB::select(DB::raw($query));
	}

	function allowance_membersCount($allowance)
	{
		$query = "select COUNT(DISTINCT ea.empID) members from emp_allowances as ea  WHERE ea.allowance = ".$allowance."  ";
		$row = DB::select(DB::raw($query));
    	return $row[0]->members;
	}

	function allowance_groupsCount($allowance)
	{
		$query = "COUNT(ea.id) members FROM  emp_allowances ea WHERE ea.allowance = ".$allowance."  ";
		$row = DB::table('emp_allowances as ea')
		->select(DB::raw($query))
		->first();
    	return $row->members;
	}



	function assign_allowance($data)
	{
		DB::table('emp_allowances')->insert($data);
		return true;

	}

	function employee_allowance($allowance) {
	$query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE e.state = 1 AND  e.emp_id NOT IN (SELECT empID from emp_allowances where allowance = ".$allowance." AND group_name = 0 ) ";
    return DB::select(DB::raw($query));
    }

	function employeesrole($id) {
	$query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE e.emp_id NOT IN (SELECT userID from emp_role where role = ".$id." and group_name = 0 ) ";
    return DB::select(DB::raw($query));
    }




	function get_rolegroupmembers($group)
	{
		$query = "SELECT empID from employee_group WHERE group_name = ".$group."";

		return DB::select(DB::raw($query));
	}

//

	function customgroup($allowanceID)
	{
		$query = "SELECT * FROM groups WHERE id NOT IN(SELECT group_name FROM emp_allowances WHERE allowance =  ".$allowanceID." ) AND type = 1 ";

		return DB::select(DB::raw($query));
	}


	function addAllowance($data)
	{
		DB::table('allowances')->insert($data);
		return true;
	}

	public function updateAllowance($data, $id)
	{
		DB::table('allowances')->where('id', $id)
		->update($data);
		return true;

	}

	public function addOvertimeCategory($data)
	{
		DB::table('overtime_category')->insert($data);
		return true;

	}

	public function deleteOvertimeCategory($id)
	{
		DB::table('overtime_category')->delete($id);
		return true;

	}


    function overtimeCategory()
	{
		$query = "SELECT * FROM overtime_category";

		return DB::select(DB::raw($query));
	}

	public function updateOvertimeCategory($data, $id)
	{
		DB::table('overtime_category')->where('id', $id)
		->update($data);
		return true;

	}


function OvertimeCategoryInfo($id)
	{
		$query="SELECT oc.* FROM overtime_category oc WHERE oc.id =".$id."";

		return DB::select(DB::raw($query));
	}

	#############################PAYE####################################

	function paye()
	{
		$query='SELECT @s:=@s+1 SNo, p.* FROM paye p, (SELECT @s:=0) as s';

		return DB::select(DB::raw($query));
	}

	function addpaye($data)
	{
		DB::table('paye')->insert($data);
		return true;

	}

	function updatepaye($data, $id)
	{
		DB::table('paye')->where('id', $id)
		->update($data);
		return true;
	}

	function getpayebyid($id)
	{
		$data = DB::table('paye')->where('id', $id);

		return $data->get();
	}

	#############################PAYE####################################







function contract_expire_list() {
	$query = "SELECT e.emp_id as IDs  from employee e, contract c where (DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)) > (c.duration*365) and e.contract_type = c.id ";

		return DB::select(DB::raw($query));
}

function terminate_contract($id) {
	$query = "UPDATE employee SET state = 0 WHERE emp_id ='".$id."'";
    DB::insert(DB::raw($query));
		return true;
}

function payroll_month_list(){
	$query = 'SELECT DISTINCT payroll_date FROM payroll_logs ORDER BY payroll_date DESC';
	return DB::select(DB::raw($query));
}

function payroll_year_list(){
	$query = "SELECT DISTINCT DATE_FORMAT(`payroll_date`,'%Y') as year  FROM payroll_logs ORDER BY DATE_FORMAT(`payroll_date`,'%Y') DESC";
	return DB::select(DB::raw($query));
}


function updateHESLB($date) {
	$query = "UPDATE loan SET paid = IF(((paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID)) > amount), amount, (paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID))),

amount_last_paid = IF(((paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID)) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID))),

last_paid_date='".$date."' WHERE  state = 1 and type = 3";
 DB::insert(DB::raw($query));

		return true;
}

//START RUN PAYROLL FOR SCANIA

function payrollcheck($date){
	$query = " id  WHERE payroll_date like  '%".$date."%' ";
	$row = DB::table('payroll_logs')
	->select(DB::raw($query))->count();
	return $row();
}

function run_payroll($payroll_date, $payroll_month){

     DB::transaction(function() use($payroll_date, $payroll_month)
       {

    //INSERT ALLOWANCES
    $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

    SELECT ea.empID AS empID, a.name AS description,

    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS amount,

     '".$payroll_date."' AS payment_date

    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance";
   DB::insert(DB::raw($query));
    //INSERT BONUS
    $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

    SELECT b.empID AS empID, 'Monthly Bonus' AS description,

    'Fixed Amount' AS policy,

    SUM(b.amount) AS amount,

    '".$payroll_date."' AS payment_date

    FROM employee e,  bonus b WHERE e.emp_id =  b.empID  AND b.state = 1 GROUP BY b.empID";
	DB::insert(DB::raw($query));
    //INSERT OVERTIME
    $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)
    SELECT o.empID AS empID, 'Overtimes' AS description,

    'Fixed Amount' AS policy,

     SUM(o.amount) AS amount,

    '".$payroll_date."' AS payment_date

    FROM  employee e, overtimes o WHERE  o.duedate <= '".$payroll_date."' AND o.empID =  e.emp_id GROUP BY o.empID";
	DB::insert(DB::raw($query));

    //UPDATE SALARY ADVANCE.
    $query = " UPDATE loan SET paid = IF(((paid+deduction_amount) > amount), amount, (paid+deduction_amount)),
	amount_last_paid = IF(((paid+deduction_amount) > amount), amount-paid, ((paid+deduction_amount))),
	last_paid_date = '".$payroll_date."' WHERE  state = 1 AND NOT type = 3";
    DB::insert(DB::raw($query));
    //UPDATE LOAN BOARD
    $query = " UPDATE loan SET paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount, (paid+ (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
	amount_last_paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
	last_paid_date = '".$payroll_date."' WHERE  state = 1 AND type = 3";
    DB::insert(DB::raw($query));
    //INSERT LOAN LOGS
    $query = "INSERT into loan_logs(loanID, paid, remained, payment_date) SELECT id, amount_last_paid, amount-paid, last_paid_date FROM loan WHERE state = 1";
    DB::insert(DB::raw($query));
    //INSERT DEDUCTION LOGS
    $query = "INSERT INTO deduction_logs(empID, description, policy, paid, payment_date)

    SELECT ed.empID as empID, dt.name as description,

    IF( (d.mode = 1), 'Fixed Amount', CONCAT(100*d.percent,'% ( Basic Salary )') ) as policy,

    IF( (d.mode = 1), d.amount, (d.percent*e.salary) ) as paid,

    '".$payroll_date."' as payment_date

    FROM emp_deductions ed,  deductions d, deduction_tags dt, employee e WHERE e.emp_id = ed.empID AND ed.deduction = d.id AND d.name = dt.id and d.state = 1";
    DB::insert(DB::raw($query));
    //STOP LOAN
    $query = " UPDATE loan SET state = 0 WHERE amount = paid and state = 1";
    DB::insert(DB::raw($query));
    //INSERT PAYROLL LOG TABLE
	$query = "INSERT INTO payroll_logs(

        empID,
        salary,
        allowances,
        pension_employee,
        pension_employer,
        taxdue,
        meals,
        department,
        position,
        branch,
        pension_fund,
        membership_no,
        bank,
        bank_branch,
        account_no,
        sdl,
        wcf,
        payroll_date

        )

    SELECT

    e.emp_id AS empID,

    e.salary AS salary,

    /*Allowances and Bonuses*/ (

    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

     ) /*End Allowances and Bonuses*/ AS  allowances,

    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  ) AS pension_employee,

    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employer), (pf.amount_employer*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  ) AS pension_employer,


    (
    ( SELECT excess_added FROM paye WHERE maximum >
    (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) )

    +

    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/))) )


    ) AS taxdue,



    IF(((e.salary +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/ )<(SELECT minimum_gross FROM meals_deduction WHERE id = 1)), (SELECT minimum_payment FROM meals_deduction WHERE id = 1), (SELECT maximum_payment FROM meals_deduction WHERE id = 1)) AS meals,



     e.department AS department,

     e.position AS position,

     e.branch AS branch,

     e.pension_fund AS pension_fund,

     e.pf_membership_no as membership_no,

     e.bank AS bank,
     e.bank_branch AS bank_branch,
     e.account_no AS account_no,

    ((SELECT rate_employer from deduction where id=4 )*(e.salary +

    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/  )) as sdl,

    ((SELECT rate_employer from deduction where id=2 )*(e.salary +

    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%".$payroll_month."%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/  )) as wcf,

     '".$payroll_date."' as payroll_date
     FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state = 1";
	 DB::insert(DB::raw($query));
     });
     return true;


	}

//END RUN PAYROLL FOR SCANIA




	function employee_hire_date($empID)
	{
		$query="SELECT hire_date from employee  WHERE emp_id='".$empID."'";
		$row = DB::select(DB::raw($query));

		return $row[0]->hire_date;
	}



    function get_max_salary_advance($empID)
	{
	    $query = "SELECT (rate_employee*(SELECT salary FROM employee WHERE emp_id = '".$empID."')) as margin FROM deduction WHERE id = 7 limit 1";

		$query = DB::select(DB::raw($query));
		return $query[0]->margin;
	}



	function mysalary_advance($empID)
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.empID = '".$empID."' ORDER BY la.id DESC ";
		return DB::select(DB::raw($query));
	}


	function salary_advance()
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}

	function waitingsalary_advance_hr()
	{
		$query="SELECT * from loan_application WHERE type=1 AND status =0";
		return DB::select(DB::raw($query));
	}
	function waitingsalary_advance_fin()
	{
		$query="SELECT * from loan_application WHERE type=1 AND status =6";
		return DB::select(DB::raw($query));
	}
	function waitingsalary_advance_appr()
	{
		$query="SELECT * from loan_application WHERE type=1 AND status =1";
		return DB::select(DB::raw($query));
	}


	function fin_salary_advance()
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id AND la.type=lt.id AND la.status IN(1,2,5) ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}



	function mysalary_advance_current($empID)
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.empID = '".$empID."' AND la.notification IN(1, 3) ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}



	function hr_fin_salary_advance_current()
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification IN(2,3,4) ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}



	function hr_salary_advance_current()
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification = 2 ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}



	function fin_salary_advance_current()
	{
		$query="SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification IN(3, 4) ORDER BY la.id DESC ";

		return DB::select(DB::raw($query));
	}

	function update_salary_advance_notification_staff($empID)
	{
		 DB::transaction(function() use($empID)
       {
		$query = "UPDATE loan_application SET notification = 0 WHERE empID = '".$empID."' AND notification =1";
		DB::insert(DB::raw($query));
		$query = "UPDATE loan_application SET notification = 4 WHERE empID = '".$empID."' AND notification = 3";
		DB::insert(DB::raw($query));
		});
		return true;
	}

	function update_salary_advance_notification_hr_fin($empID)
	{
		 DB::transaction(function()
       {
		$query = "UPDATE loan_application SET notification = 0 WHERE notification = 4";
		DB::insert(DB::raw($query));
		$query = "UPDATE loan_application SET notification = 1 WHERE  notification =3";
		DB::insert(DB::raw($query));
		$query = "UPDATE loan_application SET notification = 0 WHERE  notification = 2";
		DB::insert(DB::raw($query));
		});
		return true;
	}

	function update_salary_advance_notification_hr($empID)
	{
		$query = "UPDATE loan_application SET notification = 0 WHERE  notification = 2 ";
		DB::insert(DB::raw($query));
		return true;
	}


	function update_salary_advance_notification_fin()
	{
		 DB::transaction(function()
       {
		$query = "UPDATE loan_application SET notification = 0 WHERE notification = 4";
		DB::insert(DB::raw($query));
		$query = "UPDATE loan_application SET notification = 1 WHERE  notification =3";
		DB::insert(DB::raw($query));
		});
		return true;
	}



	function getloanapplicationbyid($id)
	{
		//$this->load->database();
		$data = DB::table('loan_application')->where('id', $id);

		return $data->get();
	}

	function confirmloan($data, $id)
	{
		DB::table('loan_application')->where('id', $id)
		->update($data);
		return true;
	}

	function my_confirmedloan($empID)
	{
		$query="SELECT @s:=@s+1 SNo, l.empID, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position FROM loan l, employee e, position p, department d,  (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id AND l.empID='".$empID."' ORDER BY l.state DESC ";

		return DB::select(DB::raw($query));
	}

	function all_confirmedloan()
	{
		$query="SELECT @s:=@s+1 SNo, l.empID, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position FROM loan l, employee e, position p, department d,  (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id ORDER BY l.state DESC ";
		//$query="SELECT @s:=@s+1 SNo, l.empID, l.* FROM loan l ";

		//dd(DB::select(DB::raw($query)));
		return DB::select(DB::raw($query));
	}



	function getloan($loanID)
	{
		$query="SELECT l.empID, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position FROM loan l, employee e, position p, department d WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id AND l.id = ".$loanID." ";

		return DB::select(DB::raw($query));
	}


	function updateLoan($data, $id)
	{
		DB::table('loan')->where('id', $id)
		->update($data);
		return true;
	}
 // ONPROGRESS LOAN
	// SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and l.state = 1 and  l.last_paid_date BETWEEN '2017-12-21' AND '2018-12-21'

	// COMPLETED LOAN
	// SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and l.state = 0 and  l.last_paid_date BETWEEN '2017-12-21' AND '2018-12-21'

	function getloanbyid($id)
	{
		//$this->load->database();
		$data = DB::table('loan_application')->where('id', $id);

		return $data->get();
	}

    function update_loan($data, $id)
	{
		DB::table('loan_application')->where('id', $id)
		->update($data);
		return true;
	}

	function getAllocation(){
        $query = "SELECT * FROM employee_activity_grant";
        return DB::select(DB::raw($query));
    }

    function deleteLoan($id)
	{
		DB::table('loan_application')->where('id', $id)
		->delete('loan_application');
		return true;
	}

    function applyloan($data)
	{
		DB::table('loan_application')->insert($data);
		return true;

	}


    function approve_loan($loanID, $signatory, $todate)
	{
	     DB::transaction(function()  use ($loanID, $signatory, $todate)
       {
		$query = "INSERT INTO loan(

		empID,
		description,
		type,
		form_four_index_no,
		amount,
		deduction_amount,
		application_date,
		state,
		approved_hr,
		approved_finance,
		approved_date_hr,
		approved_date_finance,
		paid,
		amount_last_paid,
		last_paid_date )

		SELECT la.empID, IF((la.type=2), la.reason, lt.name) as description, la.type, la.form_four_index_no, la.amount, la.deduction_amount, la.application_date, 1, la.approved_hr, '".$signatory."', la.approved_date_hr, '".$todate."', 0, 0, '".$todate."' FROM loan_application la, loan_type lt WHERE lt.id = la.type AND la.id ='".$loanID."' ";
		DB::insert(DB::raw($query));
	    $query = "UPDATE loan_application SET status = 2, notification=1, approved_cd = '".$signatory."', time_approved_cd = '".$todate."'  WHERE id ='".$loanID."'";
		DB::insert(DB::raw($query));
	    });

		return true;
	}



function count_employees(){
	$query = 'e.emp_id  WHERE e.state = 1';
	$row = DB::table('employee as e')
	->select(DB::raw($query))
	->first();
	return $row;
}

function employees_info(){
	$query = "SELECT (SELECT COUNT(emp_id) FROM employee WHERE state = 1)  as emp_count, (SELECT COUNT(emp_id) FROM employee WHERE GENDER = 'Male' AND state = 1 ) as males,(SELECT COUNT(emp_id) FROM employee WHERE GENDER = 'Female' AND state = 1 ) as females, (SELECT COUNT(emp_id) FROM employee WHERE state = 0 ) as inactive,  (SELECT COUNT(emp_id) FROM employee WHERE is_expatriate = 1 AND state = 1 ) as expatriate, (SELECT COUNT(emp_id) FROM employee WHERE is_expatriate = 0 AND state = 1 ) as local_employee ";
	return DB::select(DB::raw($query));
}

function comment($data){

	DB::table('comments')->insert($data);

	return true;

	}

function position(){
	$query = "SELECT @s:=@s+1 as SNo, (SELECT pp.name from position pp WHERE p.parent_code = pp.position_code) as parent, d.name as department, p.* FROM position p, department d, (SELECT @s:=0) as s WHERE d.id = p.dept_id AND p.state = 1";
	return DB::select(DB::raw($query));
	}
function inactive_position(){
	$query = "SELECT @s:=@s+1 as SNo, (SELECT pp.name from position pp WHERE p.parent_code = pp.position_code) as parent, d.name as department, p.* FROM position p, department d, (SELECT @s:=0) as s WHERE d.id = p.dept_id AND p.state = 0";
	return DB::select(DB::raw($query));
	}
function allposition()
	{
		$query = "SELECT * FROM position WHERE state = 1";
		return DB::select(DB::raw($query));
	}
function allLevels()
	{
		$query = "SELECT * FROM organization_level";
		return DB::select(DB::raw($query));
	}


	// FORM
	function positiondropdown()
	{
		$query = "SELECT * FROM position WHERE state = 1 ";

		return DB::select(DB::raw($query));
	}
	function positiondropdown2($id)
	{
		$query = "SELECT * FROM position WHERE dept_id = '".$id."' AND state = 1";

		return DB::select(DB::raw($query));
	}

	function linemanagerdropdown()
	{
		$query = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and  r.permissions like '%p%'";

		return DB::select(DB::raw($query));
	}

	function departmentdropdown()
	{
		$query = "SELECT d.* FROM department d WHERE state = 1 AND type = 1 ";

		return DB::select(DB::raw($query));
	}


	function pensiondropdown()
	{
		$query = "SELECT pf.* FROM pension_fund pf";

		return DB::select(DB::raw($query));
	}

	function countrydropdown()
	{
		$query = "SELECT c.* FROM country c";

		return DB::select(DB::raw($query));
	}

	function branchdropdown()
	{
		$query = "SELECT b.* FROM branch b";

		return DB::select(DB::raw($query));
	}

	function getPositionSalaryRange($positionID)
	{
		$query = "SELECT TRUNCATE((ol.minSalary/12),0) as minSalary, TRUNCATE((ol.maxSalary/12),0) as maxSalary from position p, organization_level ol WHERE p.organization_level = ol.id AND p.id = ".$positionID."";

		return DB::select(DB::raw($query));
	}


	function bank()
	{
		$query = "SELECT @s:=@s+1 as SNo, b.* FROM bank b, (SELECT @s:=0) as s";

		return DB::select(DB::raw($query));
	}

	function bank_branch()
	{
		$query = "SELECT @s:=@s+1 as SNo, b.name as bankname, bb.*  FROM bank b, bank_branch bb, (SELECT @s:=0) as s WHERE b.id = bb.bank";

		return DB::select(DB::raw($query));
	}


	function bankBranchFetcher($id)
	{
		$query = "SELECT * FROM bank_branch where bank = ".$id."";

		return DB::select(DB::raw($query));
	}

	function department_reference()
	{
		$query = "id  ORDER BY id DESC limit 1";
		$row = DB::table('department')
		->select(DB::raw($query))
		->first();
		return $row->id;
	}


	function addBank($data)
	{
		DB::table('bank')->insert($data);
		return true;

	}
	function addBankBranch($data)
	{
		DB::table('bank_branch')->insert($data);

		return true;
	}
	function getbank($id)
	{
		$query = "SELECT * FROM bank where id = '".$id."'";

		return DB::select(DB::raw($query));
	}
	function getbankbranch($id)
	{
		$query = "SELECT * FROM bank_branch where id = '".$id."'";

		return DB::select(DB::raw($query));
	}

	function updateBank($data, $bankID)
	{
		DB::table('bank')->where('id', $bankID)
		->update($data);
		return true;
	}

	function updateBankBranch($data, $branchID)
	{
		DB::table('bank_branch')->where('id', $branchID)
		->update($data);
		return true;
	}


	// FORM
	public function positionFetcher($id)
	{
		$query = "SELECT * FROM position where dept_id = '".$id."' and state = 1";
        $query = DB::select(DB::raw($query));
        $query_linemanager = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and r.permissions like '%bs%' and e.department = '".$id."'";
        $query_linemanager = DB::select(DB::raw($query_linemanager));
		// $query_country_director = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and (r.permissions like '%l%' || r.permissions like '%q%')";
		// $query_country_director = DB::select(DB::raw($query_country_director));
		// return [$query,$query_linemanager,$query_country_director];

		return [$query,$query_linemanager];
	}

	// FORM
	public function employeeAdd($employee, $newEmp)
	{
	    $result  =   DB::transaction(function() use($employee, $newEmp){
                        DB::table('employee')->insert($employee);

                        // ->insert("company_property", $property);
                        // ->insert("employee_group", $datagroup);

                        //DB::table('sys_account')->insert($newEmp);

                        $row = DB::table('employee')
                            ->select('id')
                            ->orderBy('id', 'DESC')
                            ->limit(1)
                            ->first();

                        return $row;
                    });

        return $result->id;
	}

	function updateEmployeeID($recordID, $empID, $property, $datagroup)
	{
		DB::transaction(function()  use ($recordID, $empID, $property, $datagroup)
        {
		    $query = "UPDATE employee SET emp_id = '".$empID."' WHERE id ='".$recordID."'";

            DB::insert(DB::raw($query));
		    DB::table('company_property')->insert($property);
            DB::table('employee_group')->insert($datagroup);
        });

		return true;
	}

	function get_latestEmployee()
	{
		$query = "emp_id  order by id DESC LIMIT 1";

		$row = DB::table('employee')
		    ->select(DB::raw($query))
		    ->first();

        return $row->emp_id;
	}

	function getldPhoto($empID)
	{
		$query = "photo WHERE emp_id = '".$empID."' ";
		$row = DB::table('employee')
            ->select(DB::raw($query))
            ->first();
		return $row->ephoto;
	}

	function updateEmployee($data, $empID)
	{
		DB::table('employee')->where('emp_id', $empID)->update($data);
		return true;
	}

	function updateContractStart($data, $empID)
	{
		DB::table('employee')->where('emp_id', $empID)
		->update($data);
		return true;
	}

	function updateContractEnd($data, $empID)
	{
		DB::table('employee')->where('emp_id', $empID)
		->update($data);
		return true;
	}

	public function activateEmployee($property, $datagroup, $datalog, $empID, $logID, $todate)
	{
	    $result = DB::transaction(function()  use($property, $datagroup, $datalog, $empID, $logID, $todate)
                    {
                        DB::table('company_property')->insert($property);
                        DB::table('company_property')->insert($datagroup);
		                DB::table('activation_deactivation')->insert($datalog);

                        $query = "UPDATE employee SET state = 1, last_updated = '".$todate."' WHERE emp_id ='".$empID."'";

                        DB::insert(DB::raw($query));

                        $query = "UPDATE activation_deactivation SET current_state = 1 WHERE id ='".$logID."'";

                        DB::insert(DB::raw($query));

                        return true;
                    });

		return $result;
	}

	function deactivateEmployee($empID, $datalog, $logID, $todate)
	{	//set status to 4 as is confirm exit
		$state = $datalog['state'];
	     DB::transaction(function() use($empID, $datalog, $logID, $todate,$state)
       {
        $query = "UPDATE employee SET state = '".$state."', last_updated = '".$todate."' WHERE emp_id ='".$empID."'";
		DB::insert(DB::raw($query));
//        $query = "DELETE FROM company_property WHERE given_to ='".$empID."'";
		DB::table('activation_deactivation')->insert($datalog);
//        $query = "UPDATE activation_deactivation SET current_state = '".$state."' WHERE id ='".$logID."'";
//        $query = "DELETE FROM employee_group  WHERE empID ='".$empID."'";
//        $query = "DELETE FROM emp_allowances  WHERE empID ='".$empID."'";
//        $query = "DELETE FROM emp_deductions  WHERE empID ='".$empID."'";
        });

		return true;

	}

	function addkin($data)
	{
		DB::table('next_of_kin')->insert($data);

	}


	function addproperty($data)
	{
		DB::table('next_of_kin')->insert($data);
		return true;

	}

	function updateproperty($data, $id)
	{
		DB::table('company_property')->where('id', $id)
		->update($data);
		return true;
	}




	public function delete_employee($data, $id)
	{
		DB::table('employee')->where('emp_id', $id)
		    ->update($data);
		return true;
	}


	public function employeestatelog($data){
		$empID = $data['empID'];
		$state = $data['state'];
		$query = "UPDATE employee SET state = '".$state."' WHERE emp_id = '".$empID."'";

        DB::insert(DB::raw($query));

        DB::table('activation_deactivation')->insert($data);

        // return true;
	}


	function login_info($empID)
	{
		$query = "SELECT username, password FROM employee WHERE emp_id = '".$empID."'";
		return DB::select(DB::raw($query));
	}


	// to be checked
	public function login_user($username, $password){
		// $query = "SELECT e.*, d.name as dname, c.name as CONTRACT, d.id as departmentID, p.id as positionID, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as lineManager from employee e, contract c, department d, position p WHERE d.id=e.department and e.contract_type = c.id and p.id=e.position and (e.state = '1' or e.state = '3')  and e.username ='".$username."'";
		// $row = DB::select(DB::raw($query));
		// if(count($row)>0) {
		// 	$row = $row->row();
		// 	$password_hash = $row->password;

	    //     if (password_verify($password, $password_hash)){
	    //     	return $query->row_array();
	    //     }else{
		// 	    return false;
		// 	}
		// } else{
		//     return false;
		// }
	}

	public function get_login_user($username){
		// $query = "SELECT e.*, d.name as dname, c.name as CONTRACT, d.id as departmentID, p.id as positionID, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as lineManager from employee e, contract c, department d, position p WHERE d.id=e.department and e.contract_type = c.id and p.id=e.position and (e.state = '1' or e.state = '3')  and e.fname ='".$username."'";
		// $row = DB::select(DB::raw($query));
		// if(count($row)>0) {
		// 	return $row;

		// }
	}


	function password_age($empID)
	{
		$query = "SELECT u.time FROM user_passwords u WHERE empID = '".$empID."' ORDER BY id DESC LIMIT 1";
		return DB::select(DB::raw($query));
	}


	function insertAuditLog($logData)
	{
		DB::table('audit_logs')->insert($logData);
		return true;

	}

	function insertAuditPurgeLog($logData)
	{
		DB::table('audit_purge_logs')->insert($logData);
		return true;

	}

	function userID(){
		$query= 'SELECT id FROM employee ORDER BY id DESC LIMIT 1';
		$row =DB::table('employee')
		->select(DB::raw($query))
		->first();
		return $row->id;
	}


	#############################PRIVELEGES##############################


	#############################EMPLOYER##############################



	function allpositioncodes()
	{

		$query = "SELECT p.position_code AS POSITION FROM position p WHERE p.state = 1 ";
		return DB::select(DB::raw($query));
	}


	function otherpositions()
	{

		$query = "SELECT p.name as name, p.id as positionID,

(SELECT COUNT(e.emp_id) FROM employee e WHERE e.position = p.id) as head_counts,

IF( (SELECT COUNT(e.emp_id) FROM employee e WHERE e.position IN(SELECT pl.position FROM payroll_logs pl  WHERE pl.payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 )) )>0,
   (SELECT SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) FROM payroll_logs pl WHERE pl.position = p.id AND pl.payroll_date = ( SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 ) GROUP BY pl.position), 0) AS employment_cost,

p.position_code AS child_position, p.parent_code as parent_position FROM  position p WHERE NOT p.id = 6 AND p.state = 1 ORDER BY p.level";
		return DB::select(DB::raw($query));
	}

	function topposition()
	{

		$query = "SELECT p.name as NAME, p.position_code as POSITION, p.parent_code as PARENT FROM  position p WHERE p.id = 1";
		return DB::select(DB::raw($query));
	}


	function alldepartmentcodes()
	{

		$query = "SELECT d.department_pattern AS department FROM department d WHERE d.state = 1 ";
		return DB::select(DB::raw($query));
	}

	function topDepartment()
	{

		$query = "SELECT d.name , d.department_pattern AS pattern FROM  department d WHERE d.id = 3";
		return DB::select(DB::raw($query));
	}
	function childDepartments() {

		$query = "SELECT d.name as name, d.id as deptID,(SELECT COUNT(e.emp_id) FROM employee e WHERE e.department = d.id) as head_counts,

IF( (SELECT COUNT(e.emp_id) FROM employee e WHERE e.department IN(SELECT pl.department FROM payroll_logs pl  WHERE pl.payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 )) )>0,
   (SELECT SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) FROM payroll_logs pl WHERE pl.department = d.id AND pl.payroll_date = ( SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 ) GROUP BY pl.department), 0) AS employment_cost,

d.department_pattern AS child_department, d.parent_pattern as parent_department FROM  department d WHERE NOT d.id = 3 order by d.level";
		return DB::select(DB::raw($query));
	}

	public function employer($data){
		DB::table('company_info')->insert($data);
	}

	public function updateemployer($data, $id)
	{
		DB::table('company_info')->where('id', $id)
		->update( $data);
		return true;
	}

	function employerdetails()
	{
		$query='SELECT * FROM company_info';
		return DB::select(DB::raw($query));
	}


	#############################EMPLOYER##############################


	public function departmentnum_rows($id)
	{
		$query = "SELECT count(hod) as DETCOUNT FROM department WHERE hod ='".$id."'";
	 	return DB::select(DB::raw($query));
	}

	function role($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, r.id, r.name FROM role r, (SELECT @s:=0) as s where r.id NOT IN (SELECT role FROM emp_role where userID ='".$id."') ";


		return DB::select(DB::raw($query));
	}

	function rolecount($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, r.id, r.name FROM role r, (SELECT @s:=0) as s where r.id NOT IN (SELECT role FROM emp_role where userID ='".$id."' ) ";
        $row = DB::select(DB::raw($query));

		return count($row);
	}
	function allrole()
	{
		$query = "SELECT @s:=@s+1 as SNo, r.*  FROM role r, (SELECT @s:=0) as s  ";


		return DB::select(DB::raw($query));
	}

	function finencialgroups()
	{
		$query = "SELECT @s:=@s+1 as SNo, g.* FROM groups g, (SELECT @s:=0) as s  WHERE type IN (0,1) ";


		return DB::select(DB::raw($query));
	}

	function rolesgroupsnot()
	{
		$query = "SELECT @s:=@s+1 as SNo, g.* FROM groups g, (SELECT @s:=0) as s WHERE type = '2' and g.id NOT IN( SELECT group_name FROM emp_role ) ";


		return DB::select(DB::raw($query));
	}

	function rolesgroupsin()
	{
		$query = "SELECT @s:=@s+1 as SNo, g.* FROM groups g, (SELECT @s:=0) as s WHERE type = '2' ";


		return DB::select(DB::raw($query));
	}

	function rolesgroups()
	{
		$query = "SELECT @s:=@s+1 as SNo, g.* FROM groups g, (SELECT @s:=0) as s WHERE type IN (0,2) ";


		return DB::select(DB::raw($query));
	}

	function group_byid($id)
	{
		$query = "SELECT id, name  FROM groups where id =".$id."";


		return DB::select(DB::raw($query));
	}

	function memberscount($id)
	{
		$query = "SELECT count(id) as headcounts  FROM employee_group WHERE group_name =".$id."";
		$row = DB::select(DB::raw($query));
		

    	return $row[0]->headcounts;

	}


	function nonmembers_roles_byid($id)
	{

		$query = "SELECT DISTINCT @s:=@s+1 as SNo,p.id as ID, p.name as POSITION,d.name as DEPARTMENT   FROM position p INNER JOIN department d ON p.dept_id = d.id,  (SELECT @s:=0) as s  where  p.id NOT IN (SELECT roleID from role_groups  where group_name=".$id.")";

		//dd(DB::select(DB::raw($query)));
		return DB::select(DB::raw($query));
	}

    function nonmembers_byid($id)
	{
		$query = "SELECT DISTINCT @s:=@s+1 as SNo, e.emp_id as ID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM employee e, position p, department d,  (SELECT @s:=0) as s  where e.position = p.id AND e.department = d.id AND e.state =1 AND e.emp_id NOT IN (SELECT empID from employee_group where group_name=".$id.")";

		return DB::select(DB::raw($query));
	}


    function roleswithingroup($id)
	{
		$query = "SELECT DISTINCT role roleswithin FROM emp_role WHERE `group_name`=".$id."";

		return DB::select(DB::raw($query));
	}


    function allowanceswithingroup($id)
	{
		$query = "SELECT DISTINCT allowance as allowanceswithin FROM emp_allowances WHERE `group_name`=".$id."";

		return DB::select(DB::raw($query));
	}

    function members_byid($id)
	{

		$query = "SELECT DISTINCT @s:=@s+1 as SNo, eg.id as EGID,  e.emp_id as ID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM employee e, position p, department d, employee_group eg,  (SELECT @s:=0) as s  where e.position = p.id and e.emp_id = eg.empID and e.department = d.id and eg.group_name = ".$id."  and e.emp_id IN (SELECT empID from employee_group where group_name=".$id.")";

		return DB::select(DB::raw($query));
	}
	function roles_byid($id)
	{

		$query = "SELECT DISTINCT @s:=@s+1 as SNo, rg.id as RGID,  p.id as ID, d.name as DEPARTMENT, p.name as POSITION FROM  position p INNER JOIN department d ON p.dept_id = d.id INNER JOIN role_groups rg ON p.id = rg.roleID,  (SELECT @s:=0) as s  where  p.id = rg.roleID  and rg.group_name = ".$id."  and p.id IN (SELECT roleID from role_groups where group_name=".$id.")";



		return DB::select(DB::raw($query));
	}
	function get_employee_by_position($position){
		$query = "SELECT emp_id from employee where position=".$position;
		return DB::select(DB::raw($query));
	}

	function role_members_byid($id){
		$query = "SELECT @s:=@s+1 as SNo, eg.id as roleID,  e.emp_id as userID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM employee e, position p, department d, emp_role eg,  (SELECT @s:=0) as s  where e.position = p.id and e.emp_id = eg.userID and e.department = d.id and eg.role = ".$id."";
		return DB::select(DB::raw($query));
	}


	function add_to_group($data)
	{
		DB::table('employee_group')->insert($data);
		return true;
	}

	function get_group_roles($groupID)
	{
		$query = "SELECT DISTINCT role FROM emp_role WHERE group_name=".$groupID."";

		return DB::select(DB::raw($query));
	}

	function get_group_deductions($groupID)
	{
		$query = "SELECT DISTINCT deduction FROM emp_deductions WHERE group_name=".$groupID."";

		return DB::select(DB::raw($query));
	}

	function get_group_allowances($groupID)
	{
		$query = "SELECT DISTINCT allowance FROM emp_allowances WHERE group_name=".$groupID."";

		return DB::select(DB::raw($query));
	}

	function getEmpByGroupID($group_id,$position){

		$query = "SELECT eg.empID from employee_group eg INNER JOIN  employee e ON e.emp_id=eg.empID WHERE eg.group_name = ".$group_id." AND  e.position =".$position;


		//dd(count(DB::select(DB::raw($query))));
		return DB::select(DB::raw($query));
	}

	function removeEmployeeByROleFromGroup($empID, $groupID)
	{
	     DB::transaction(function() use($empID, $groupID)
       {

	    $query = "DELETE FROM employee_group  WHERE  group_name ='".$groupID."' AND empID = '".$empID."' ";
        DB::insert(DB::raw($query));
	    $query = "DELETE FROM emp_allowances WHERE  group_name ='".$groupID."' AND empID = '".$empID."' ";
	    DB::insert(DB::raw($query));
		$query = "DELETE FROM emp_deductions WHERE  group_name ='".$groupID."' AND empID = '".$empID."' ";
	    DB::insert(DB::raw($query));
		$query = "DELETE FROM emp_role WHERE  group_name ='".$groupID."' AND userID = '".$empID."' ";
		DB::insert(DB::raw($query));
	    });

		return true;
	}


	function removeEmployeeFromGroup($refID, $empID, $groupID)
	{
	     DB::transaction(function() use($refID, $empID, $groupID)
       {
	    $query = "DELETE FROM employee_group WHERE id ='".$refID."'";
        DB::insert(DB::raw($query));
	    $query = "DELETE FROM emp_allowances WHERE  group_name ='".$groupID."' AND empID = '".$empID."' ";
	    DB::insert(DB::raw($query));
		$query = "DELETE FROM emp_deductions WHERE  group_name ='".$groupID."' AND empID = '".$empID."' ";
	    DB::insert(DB::raw($query));
		$query = "DELETE FROM emp_role WHERE  group_name ='".$groupID."' AND userID = '".$empID."' ";
		DB::insert(DB::raw($query));
	    });

		return true;
	}
	function delete_role_group($roleID,$GroupID){
		DB::table('role_groups')
		->where('roleID',$roleID)
		->where('Group_name',$GroupID)
		->delete();

		return true;
	}



	function removeEmployeeFromRole($refID, $empID)
	{
	     DB::transaction(function() use($refID, $empID)
       {
	    $query = "DELETE FROM emp_role WHERE id ='".$refID."'";
		DB::insert(DB::raw($query));
	    });

		return true;
	}

	function employeeFromGroup($refID)
	{
		$query = "SELECT group_name FROM emp_role WHERE id ='".$refID."'";
		$row = DB::select(DB::raw($query));

		if (count($row) > 0){
			return $row[0]->group_name;
		}else{
			return null;
		}
	}

	function deleteEmployeeFromGroup($group_id, $empID)
	{
		 DB::transaction(function() use ($group_id, $empID)
       {
		$query = "DELETE FROM employee_group WHERE empID ='".$empID."' and group_name = '".$group_id."'";
        DB::insert(DB::raw($query));
		});

		return true;
	}


	function addEmployeeToGroup($empID, $groupID)
	{
		;
	    $query = "INSERT INTO  employee_group(empID, group_name) VALUES ('".$empID."', ".$groupID.") ";

		DB::insert(DB::raw($query));
		return true;
	}

	function addRoleToGroup($roleID, $groupID)
	{
	    $query = "INSERT INTO  role_groups(roleID, group_name) VALUES ('".$roleID."', ".$groupID.") ";
		DB::insert(DB::raw($query));
		return true;
	}




   public function remove_from_group($id)
    {
        DB::table('employee_group')->where('id',$id)
        ->delete();
        return true;

    }


   public function remove_from_grouprole($value, $groupID)
    {
        // $id = $this->input->get("id";
        DB::table('emp_role')->where('userID',$value)
        ->where('group_ref',$groupID)
        ->delete();
        return true;
    }

   public function remove_individual_from_allowance($empID, $allowanceID)
    {
        DB::table('emp_allowances')->where('empID', $empID)
        ->where('group_name', 0)
        ->where('allowance', $allowanceID)
        ->delete();
        return true;
    }


   public function remove_group_from_allowance($groupID, $allowanceID)
    {
        DB::table('emp_allowances')->where('group_name', $groupID)
        ->where('allowance', $allowanceID)
        ->delete();
        return true;
    }





	function addrole($data)
	{
		DB::table('role')->insert($data);
		return true;

	}
	function deleteGroup($groupID)
	{
	     DB::transaction(function() use($groupID)
       {

	    $query = "DELETE FROM groups WHERE id ='".$groupID."'";
		DB::insert(DB::raw($query));
	    $query = "DELETE FROM employee_group WHERE group_name ='".$groupID."'";
		DB::insert(DB::raw($query));
	    $query = "DELETE FROM emp_allowances WHERE group_name ='".$groupID."'";
		DB::insert(DB::raw($query));
	    $query = "DELETE FROM emp_role WHERE group_name='".$groupID."'";
		DB::insert(DB::raw($query));

	    });

		return true;
	}
	function deleteRole($roleID)
	{
	     DB::transaction(function() use($roleID)
       {

	    $query = "DELETE FROM role WHERE id ='".$roleID."'";
		DB::insert(DB::raw($query));
	    $query = "DELETE FROM emp_role WHERE role ='".$roleID."'";
		DB::insert(DB::raw($query));

	    });

		return true;
	}


	function addgroup($data)
	{
		DB::table('groups')->insert($data);
		return true;

	}


	/*function getpermission($empID, $permissionID)
	{
		$query = "SELECT r.name as permission FROM role r,emp_role er  WHERE er.role=r.id and er.userID='".$empID."'  and r.name like '%".$permissionID."%'";
		//$query = "SELECT r.name as permission FROM role r,emp_role er  WHERE er.role=r.id and er.userID='".$empID."'";
		return $query->num_rows();
	}*/

	function getpermission($empID, $permissionID)
	{
		$query = "SELECT r.permissions as permission FROM emp_role er, role r WHERE er.role=r.id and er.userID='".$empID."'  and r.permissions like '%".$permissionID."%'";
		$results = DB::table('emp_role er')
		->select(DB::raw($query))
		->count();
		if ($results>0) {
			return true;
		}else{
			return false;
		}
	}

	function assignrole($data)
	{
		DB::table('emp_role')->insert($data);
		return true;

	}


	function permission()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1";

		return DB::select(DB::raw($query));
	}

	function general_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 5";

		return DB::select(DB::raw($query));
	}
	function cdir_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 6";

		return DB::select(DB::raw($query));
	}
	function hr_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 1";

		return DB::select(DB::raw($query));
	}

	function fin_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 3";

		return DB::select(DB::raw($query));
	}

	function line_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 4";

		return DB::select(DB::raw($query));
	}

	function perf_permissions()
	{
		$query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 2";

		return DB::select(DB::raw($query));
	}

	function getrolebyid($id)
	{
		$query = "SELECT * FROM role WHERE id =".$id."";

		return DB::select(DB::raw($query));
	}

	function getuserrole($id)
	{
		$query = "SELECT @s:=@s+1 as SNo,  er.id,  CAST(er.duedate as date) as DATED, er.role, CONCAT(e.fname,' ', e.mname,' ', e.lname) as eNAME,   r.name as NAME  FROM emp_role er, employee e, role r, (SELECT @s:=0) as s WHERE er.role=r.id AND er.userID = e.emp_id  AND er.userID ='".$id."'";

		return DB::select(DB::raw($query));
	}


	function updaterole($data, $id)
	{
		DB::table('role')->where('id', $id)
		->update($data);
		return true;
	}
	function revokerole($id, $role, $isGroup)
	{
		DB::table('emp_role')->where('userID', $id)
		->where('role', $role)
		->where('group_name', $isGroup)
		->delete();


		return true;
	}

	############################PRIVELEGES###############################





/*	function leavereportline($id)
	{
		$query = " SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id  and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id  and ls.empID = '".$id."'" );

		return DB::select(DB::raw($query));
	}*/

/*	function leavereport1_line($dates, $datee, $id)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.emp_id = '".$id."'";

		return DB::select(DB::raw($query));
	}*/





	function customemployee() {
	$query = "SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE state = 1 ";
	return DB::select(DB::raw($query));

}

function employeeMails() {
	$query = "SELECT DISTINCT email, name FROM company_emails";
    return DB::select(DB::raw($query));
}

	function employeehiredate($id) {
	$query = "SELECT e.hire_date as HIRE FROM employee e WHERE e.emp_id = '".$id."' ";
    return DB::select(DB::raw($query));
}

function appreciated_employee()
	{
		$query = "SELECT a.empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, e.photo, a.description, a.date_apprd FROM appreciation a, employee e, department d, position p WHERE a.empID = e.emp_id and p.id = e.position and d.id = e.department ORDER BY a.id DESC LIMIT 1";

		return DB::select(DB::raw($query));
	}


	function add_apprec($data)
	{
		DB::table('appreciation')->insert($data);

	}

	function payslip($id, $date){

		$query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, (pl.basic+pl.allowance) as GOSS, pl.pension_employee as PENSION, pl.paye as PAYE, pl.medical as MEDICAL, (pl.basic+pl.allowance-pl.pension_employee) as TAXABLE, (pl.allowance+pl.basic-pl.paye-pl.pension_employee-pl.medical) as NET_PAY,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=3 and l.empID = '".$id."' and payment_date = '".$date."')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=3 and l.empID = '".$id."' and payment_date = '".$date."'),0)) as HESLB_DEDUCTION,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=1 and l.empID = '".$id."' and payment_date = '".$date."')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=1 and l.empID = '".$id."' and payment_date = '".$date."'),0)) as SALARY_ADV,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=2 and l.empID = '".$id."' and payment_date = '".$date."')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=2 and l.empID = '".$id."' and payment_date = '".$date."'),0)) as LOAN_DEDUCTION,

(SELECT IF((SELECT COUNT(l.amount) FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 2 and l.approved_date_finance BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."')>0,(SELECT l.amount FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 2 and l.approved_date_finance BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."'),0)) as Amount_LOAN,

(SELECT IF((SELECT COUNT(l.amount) FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 3 and l.approved_date_finance BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."')>0,(SELECT l.amount FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 3 and l.approved_date_finance BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."'),0)) as Amount_HESLB, '".$date."' as OUTSTANDING_DATE, e.hire_date as HIRE,

 (SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 1 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 1 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."'),0)) as PAID_SALARYADVANCE,

(SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 3 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 3 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."'),0)) as PAID_HESLB,
(SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 2 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 2 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '".$date."' and l.empID = '".$id."'),0)) as PAID_PERSONAL,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."'),0))as ANNUAL,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 2 AND lv.start BETWEEN e.hire_date AND '2018-12-25' and lv.empID = '".$id."')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 2 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."'),0))as EXAM,


(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 3 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 3 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."'),0))as MARTENITY,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 6 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 6 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."'),0))as COMPASSIONATE,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 5 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 5 AND lv.start BETWEEN e.hire_date AND '".$date."' and lv.empID = '".$id."'),0))as SICK

FROM payroll_logs pl, employee e, position p, department d where e.emp_id=pl.empID and e.department=d.id and pl.position=p.id and pl.empID= '".$id."' and pl.due_date = '2018-12-25' ";
DB::insert(DB::raw($query));
	}





	######################NOTIFICATION#################################
	function contract_to_expire()
	{
		$query = "e.emp_id WHERE e.state=1 and c.id = e.contract_type AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder";
        $row = DB::table('employee as e','contract as c')
		->select(DB::raw($query))
		->count();
		return $row;
	}


	function employee_to_retire()
	{
		$query = "SELECT empID FROM (SELECT emp_id as empID, (SELECT notify_before FROM retire WHERE id = 1) as notify_before, (SELECT retire_age FROM retire WHERE id = 1)-((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as ages_to_retire, ((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as age FROM employee  WHERE state=1) as parent_query WHERE ages_to_retire <= notify_before";
        $row = DB::select(DB::raw($query));
		return count($row);
	}


	function init_emp_state()
	{
		$query = "SELECT id FROM activation_deactivation WHERE  current_state = 1 AND state IN(0,1) AND notification = 1";
		$row = DB::select(DB::raw($query));
		return count($row);
	}

	function appr_emp_state()
	{
		$query = "SELECT id FROM activation_deactivation WHERE  current_state = 0 AND state IN(2,3) AND notification = 1";
		$row = DB::select(DB::raw($query));
		return count($row);
	}

	function loan_notification_employee($empID)
	{
		$query = "SELECT l.id FROM loan_application l WHERE l.empID = '".$empID."' AND l.notification = 1";
		$row = DB::select(DB::raw($query));
		return count($row);
	}

	function loan_notification_hr()
	{
		$query = "SELECT l.id FROM loan_application l WHERE l.notification = 2";
		$row = DB::select(DB::raw($query));
		return count($row);
	}

	function loan_notification_finance()
	{
		$query = "SELECT l.id FROM loan_application l  WHERE l.notification =3 ";
		$row = DB::select(DB::raw($query));
		return count($row);
	}

	function getParentPositionName($id)
	{
		$query = "SELECT name from position  WHERE position_code = '".$id."'";
		$row = DB::select(DB::raw($query));
    	return !empty($row)? $row[0]->name:"";
	}

	function get_allowance_name($id)
	{
		$query = "CONCAT(name,'(',amount,')') as output  WHERE id = ".$id."";
		$row = DB::table('allowances')
		->select(DB::raw($query))
		->first();
    	return !empty($row)? $row->output:"";

	}


	####################################### GRIEVANCES ###########################
	function add_grievance($data)
	{
		DB::table('grievances')->insert($data);

	}

function updategrievances($data, $id)
	{
		DB::table('grievances')->where('id', $id)
		->update($data);
		return true;
	}

	function forward_grievance($data, $id){
		DB::table('grievances')->where('id', $id)
		->update($data);
		return true;
	}

function grievance_details($id)
	{
		$query = "SELECT  @s:=@s+1 as SNo, g.id, g.*, CAST(g.timed as date) as DATED, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, g.description FROM grievances g, employee e, department d, position p, (SELECT @s:=0) as s WHERE g.empID = e.emp_id and p.id = e.position and d.id = e.department and g.id = '".$id."'";

		return DB::select(DB::raw($query));
	}

function all_grievances()
	{
		$query = "SELECT  @s:=@s+1 as SNo, g.id, g.*, CAST(g.timed as date) as DATED, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, g.description FROM grievances g, employee e, department d, position p, (SELECT @s:=0) as s WHERE g.empID = e.emp_id and p.id = e.position and d.id = e.department";

		return DB::select(DB::raw($query));
	}

function my_grievances($empID)
	{
		$query = "SELECT  @s:=@s+1 as SNo, g.*, CAST(g.timed as date) as DATED FROM grievances g,(SELECT @s:=0) as s where g.empID = '".$empID."'";

		return DB::select(DB::raw($query));
	}

	####################### END GRIEVANCES #####################################

	########### ACCOUNTING CODDING #############


	function accounting_coding()
	{
		$query = "select * from account_code";

		return DB::select(DB::raw($query));
	}


	########### END ACCOUNTING CODDING #############


	function employeeRetired($empID){
		$query = "UPDATE employee set retired = '2' where emp_id ='".$empID."'";
		DB::insert(DB::raw($query));
		return true;
	}

	function employeeLogin($empID){
		$query = "UPDATE employee set login_user = '1' where emp_id ='".$empID."'";
		DB::insert(DB::raw($query));
		return true;
	}

	function employeeReport() {
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1 and e.state != 4";
		return DB::select(DB::raw($query));
	}

	function addPartialPayment($data)
	{
		 DB::transaction(function() use($data)
       {
		DB::table('partial_payment')->insert($data);
		});
		return true;
	}

	function updatePartialPayment($date){
		 DB::transaction(function()  use($date)
       {
		$query = "update partial_payment set status = 1, payroll_date = '".$date."' where status = 0 ";
		DB::insert(DB::raw($query));
		});
	}

	function presentPartialPayment($payroll_date){
		$query = "select * from partial_payment where payroll_date = '".$payroll_date."' and status = 1 ";
		return DB::select(DB::raw($query));
	}

	function employeePayrollLog($empID,$payroll_date){
		$query = "*  where empID = '".$empID."' and payroll_date = '".$payroll_date."' ";
		$row = DB::table('payroll_logs')
		->select(DB::raw($query))
		->first();
		return $row;
	}

	function employeePension($pension_id){
		$query = "*  where id = '".$pension_id."' ";
		$row = DB::table('pension_fund')
		->select(DB::raw($query))
		->first();
		return $row;
	}

	function updatePayrollLog($empID, $payroll_date, $data){
		 DB::transaction(function() use($empID, $payroll_date, $data)
       {
		$query = "update payroll_logs set salary = '".$data['salary']."', pension_employee = '".$data['pension_employee']."',
		 pension_employer = '".$data['pension_employer']."', taxdue = '".$data['taxdue']."', sdl = '".$data['sdl']."',
		 wcf = '".$data['wcf']."' where payroll_date = '".$payroll_date."' and empID = '".$empID."' ";
		 DB::insert(DB::raw($query));
		});
	}

    public function deletePayment($id) {

        DB::table('partial_payment')->where('id',$id)
        ->delete();
        return true;

    }

	public function updateGroupEdit($id, $name) {
		$query = "update groups set name = '".$name."' where id='".$id."' ";
		DB::insert(DB::raw($query));
		return true;

	}

	public function memberWithGroup($role_id,$empID){
		$query = "select * from emp_role er, employee_group eg, groups as g where eg.group_name
= er.group_name and role = '".$role_id."' and empID = '".$empID."' and eg.group_name = g.id  ";
		return DB::select(DB::raw($query));
	}

	public function transfers($id){
		$query = "SELECT * from transfer where id = '".$id."' ";
        $row = DB::select(DB::raw($query));

		if ($row){
			return $row[0];
		}else{
			return null;
		}
	}

	public function approveRegistration($empID, $transferID, $approver, $date){
		 DB::transaction(function() use($empID, $approver, $date, $transferID){
		    $query = "update employee set state = 1 where emp_id = '".$empID."' ";
		    DB::insert(DB::raw($query));
		    $query = "update transfer set status = 6, approved_by = '".$approver."', date_approved = '".$date."'
		    where id = '".$transferID."' ";
		    DB::insert(DB::raw($query));
		});

		return true;
	}

	public function disapproveRegistration($empID, $transferID){
		 DB::transaction(function() use($empID, $transferID){
		    $query = "delete from employee where emp_id = '".$empID."' ";
		    DB::insert(DB::raw($query));
		    $query = "delete from employee_group where empID = '".$empID."' ";
		    DB::insert(DB::raw($query));
		    $query = "delete from employee_activity_grant where empID = '".$empID."' ";
		    DB::insert(DB::raw($query));
		    $query = "update transfer set status = 7 where id = '".$transferID."' ";
		    DB::insert(DB::raw($query));
		});

		return true;
	}

	public function assignment_task_log($payroll_date){
		 DB::transaction(function() use($payroll_date){
		    $query = "insert into assignment_task_logs (assignment_employee_id,emp_id,task_name,description,start_date,end_date,remarks,status,payroll_date)
                select ae.assignment_id, ae.emp_id, ast.task_name, ast.description, ast.start_date,
                ast.end_date, ast.remarks, ast.status, '".$payroll_date."' from assignment_employee ae, assignment_task ast
                where ae.id = ast.assignment_employee_id and ast.status = 1 and ast.date is null;";
            DB::insert(DB::raw($query));
		    $query = "update assignment_task set date = '".$payroll_date."' where date is null ";
		    DB::insert(DB::raw($query));
		});

		return true;
	}


}


