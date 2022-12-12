<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PerformanceModel extends Model
{

	public function audit_log($description){
		$logData = array(
	       'empID' => $this->session->userdata('emp_id'),
	       'description' => $description,
	       'agent' =>"", //$this->session->userdata('agent'),
	       'platform' =>"", //$this->agent->platform(),
	       'due_date' =>date('Y-m-d h:i:s'),
	       'ip_address' => "" //$this->input->ip_address()
	    );
	    $this->db->insert("audit_logs", $logData);
	}

	function total_task_assigned($id)
	{
		$query = "SELECT  count(t.id) FROM task t WHERE t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function total_task_completed($id)
	{
		$query = "SELECT  count(t.id) FROM task t WHERE t.status = 2 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function total_task_duration($id)
	{
		$query = "SELECT  min(t.start) as minDATE,  max(t.end) as maxDATE FROM task t WHERE t.status = 2 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function total_task_actual_duration($id)
	{
		$query = "SELECT  IF(sum(datediff(t.start, t.end))>0, sum(datediff(t.start, t.end)), 0) as allDURATION  FROM task t WHERE t.status = 2 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function allTaskcompleted($id)
	{
		$query = "SELECT  t.id FROM task t WHERE t.status = 2 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function all_task_monetary_value($id)
	{
		$query = "SELECT  IF(count(t.id)>0, sum(t.monetaryValue), 0) as ComperableValue  FROM task t WHERE t.status = 2 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function total_task_progress($id)
	{
		$query = "SELECT  count(t.id) FROM task t WHERE t.status = 0 and t.assigned_to ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function task_count_per_dept($id)
	{
		$query = "SELECT COUNT(t.id) as tCOUNTS FROM task t, employee e, department d  WHERE e.department = d.id and e.emp_id = t.assigned_to AND e.department ='".$id."'";
		return DB::select(DB::raw($query));
	}

	function departmentChooser()
	{
		$query = "SELECT id as deptID, name FROM department WHERE  state = 1 AND type = 1 ";
		return DB::select(DB::raw($query));
	}


	function employee_productivity($start, $end) {
		$query = "SELECT @s:=@s+1 as SNo, e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,
		IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
        /*
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  (SELECT tr.title FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality) AND tr.upper_limit>AVG(t.quantity+t.quality)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS ratings,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  (SELECT tr.id FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality) AND tr.upper_limit>AVG(t.quantity+t.quality)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS  category,*/

		SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost, datediff('".$end."','".$start."') as payroll_days FROM  employee e, department d, position p, payroll_logs pl, (SELECT @s:=0) as s WHERE
		e.emp_id = pl.empID AND e.position = p.id AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'  GROUP BY e.emp_id ORDER BY ( @s:=@s+1) ASC";
	    return DB::select(DB::raw($query));
	}

	function employee_productivity_sort($start, $end, $department) {
		$query = "SELECT @s:=@s+1 as SNo, e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,
		IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
        /*
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  (SELECT tr.title FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality) AND tr.upper_limit>AVG(t.quantity+t.quality)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS ratings,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  (SELECT tr.id FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality) AND tr.upper_limit>AVG(t.quantity+t.quality)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS  category,*/

		SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost, datediff('".$end."','".$start."') as payroll_days FROM  employee e, department d, position p, payroll_logs pl, (SELECT @s:=0) as s WHERE
		e.emp_id = pl.empID AND e.position = p.id AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."' AND e.department = ".$department."  GROUP BY e.emp_id ORDER BY ( @s:=@s+1) ASC";
	    return DB::select(DB::raw($query));
	}

	function department_productivity($start, $end) {
		$query = "SELECT (@s:=@s+1) as SNo, department, SUM(duration_time) AS duration, SUM(monetary_value) AS time_cost, SUM(number_of_tasks) AS task_counts, SUM(employment_cost) AS employment_cost, SUM(payroll_days) as payroll_days, COUNT(empID) AS headcounts, SUM(scores) AS score FROM (SELECT e.department as deptID, e.emp_id as empID,
d.name as department,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost,
        datediff('".$end."','".$start."') as payroll_days
        FROM  employee e, department d, payroll_logs pl WHERE
		e.emp_id = pl.empID AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'  GROUP BY e.emp_id) AS childQuery, (SELECT @s:=0) as s  GROUP BY deptID ORDER BY SNo ASC";
	    return DB::select(DB::raw($query));
	}


	function department_productivity_sort($start, $end, $department) {
		$query = "SELECT (@s:=@s+1) as SNo, department, SUM(duration_time) AS duration, SUM(monetary_value) AS time_cost, SUM(number_of_tasks) AS task_counts, SUM(employment_cost) AS employment_cost, SUM(payroll_days) as payroll_days, COUNT(empID) AS headcounts, SUM(scores) AS score FROM (SELECT e.department as deptID, e.emp_id as empID,
d.name as department,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost,
        datediff('".$end."','".$start."') as payroll_days
        FROM  employee e, department d, payroll_logs pl WHERE
		e.emp_id = pl.empID AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'  GROUP BY e.emp_id) AS childQuery, (SELECT @s:=0) as s  WHERE deptID = ".$department."  GROUP BY deptID ORDER BY SNo ASC";
	    return DB::select(DB::raw($query));
	}

	function organization_productivity($start, $end) {
		$query = "SELECT SUM(duration_time) AS duration, SUM(monetary_value) AS time_cost, SUM(number_of_tasks) AS task_counts, SUM(employment_cost) AS employment_cost, SUM(payroll_days) as payroll_days, COUNT(empID) AS headcounts, SUM(scores) AS score FROM (SELECT e.department as deptID, e.organization AS empOrg, e.emp_id as empID,
d.name as department,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost,
        datediff('".$end."','".$start."') as payroll_days
        FROM  employee e, department d, payroll_logs pl WHERE
		e.emp_id = pl.empID AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'  GROUP BY e.emp_id) AS childQuery  GROUP BY empOrg ";
	    return DB::select(DB::raw($query));
	}


	function organization_productivity_sort($start, $end, $department) {
		$query = "SELECT SUM(duration_time) AS duration, SUM(monetary_value) AS time_cost, SUM(number_of_tasks) AS task_counts, SUM(employment_cost) AS employment_cost, SUM(payroll_days) as payroll_days, COUNT(empID) AS headcounts, SUM(scores) AS score FROM (SELECT e.department as deptID, e.organization AS empOrg, e.emp_id as empID,
d.name as department,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(datediff(t.date_completed, t.start)) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS duration_time,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT SUM(t.monetaryValue) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS monetary_value,
IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT COUNT(t.id) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 ) AS number_of_tasks,

IF((SELECT COUNT(ts.id) FROM task ts WHERE ts.progress =100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
		AND ts.date_completed BETWEEN '".$start."' AND '".$end."' )>0, (SELECT  ROUND(AVG(t.quantity+t.quality),2) FROM task t WHERE t.progress =100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
		AND t.date_completed BETWEEN '".$start."' AND '".$end."'), 0 )  AS scores,
SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) as employment_cost,
        datediff('".$end."','".$start."') as payroll_days
        FROM  employee e, department d, payroll_logs pl WHERE
		e.emp_id = pl.empID AND e.department=d.id AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'  GROUP BY e.emp_id) AS childQuery  WHERE deptID = ".$department." GROUP BY empOrg ";
	    return DB::select(DB::raw($query));
	}
	public function category_rating($avgScore){
		$query = "SELECT * FROM task_ratings WHERE lower_limit<=".$avgScore." AND upper_limit > ".$avgScore."";
    	return DB::select(DB::raw($query));
	}


	public function selectTalent($data)
	{
		$this->db->insert("talent", $data);
		return true;

	}

	function selectedTalents($empID)
	{
		$query = "SELECT COUNT(id) as counts FROM talent WHERE empID = '".$empID."'";
		$row = $query->row();
    	return $row->counts;
	}

	function total_taskline($id) {
    	$query = "SELECT (SELECT count(t.id) FROM task t WHERE t.assigned_by ='".$id."') as ALL_TASKS, (SELECT count(t.id) FROM task t WHERE t.assigned_by ='".$id."' AND t.status = 2) as COMPLETED ";
        return DB::select(DB::raw($query));
    }

	function total_taskstaff($id) {
	$query = "SELECT (SELECT count(t.id) FROM task t WHERE t.assigned_to ='".$id."') as ALL_TASKSTAFF, (SELECT count(t.id) FROM task t WHERE t.assigned_to ='".$id."' AND t.status = 2) as COMPLETEDSTAFF ";
    return DB::select(DB::raw($query));
}


function task_info($id) {
	$query = "SELECT t.*, outp.id as outpID, outp.title as outpTitle,outp.start as outpStart, outp.end as outpEnd,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName, CONCAT(el.fname,' ', el.mname,' ', el.lname) as lineName   FROM task t, employee e, employee el, output outp WHERE e.emp_id = t.assigned_to AND el.emp_id = t.assigned_by AND t.output_ref = outp.id and t.id = ".$id."";
    return DB::select(DB::raw($query));
}
function adhoc_task_info($id) {
	$query = "SELECT t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName, CONCAT(el.fname,' ', el.mname,' ', el.lname) as lineName   FROM task t, employee e, employee el WHERE e.emp_id = t.assigned_to AND el.emp_id = t.assigned_by AND t.id = ".$id." ";
    return DB::select(DB::raw($query));
}

function alltask($strategyID) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.strategy_ref = '".$strategyID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function mytask($strategyID, $empID) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.strategy_ref = '".$strategyID."' AND t.assigned_to = '".$empID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function othertask($strategyID, $empID) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.strategy_ref = '".$strategyID."' AND t.assigned_by = '".$empID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

    function pauseTask($taskID, $todate)
	{
	    $this->db->trans_start();
		$query = "INSERT INTO paused_task (id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked, date_paused)  SELECT  id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked, '".$todate."'  FROM task WHERE id ='".$taskID."'";
	    $query = "DELETE FROM task WHERE  id ='".$taskID."'";
	    $this->db->trans_complete();

		return true;
	}

    function resumeTask($taskID)
	{
	    $this->db->trans_start();
		$query = "INSERT INTO task (id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked)  SELECT  id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked  FROM paused_task WHERE id ='".$taskID."'";
	    $query = "DELETE FROM paused_task WHERE  id ='".$taskID."'";
	    $this->db->trans_complete();

		return true;
	}

function my_paused_task($strategyID, $empID) {
	$query = "SELECT @s:=@s+1 as SNo, pt.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM paused_task pt, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = pt.assigned_by AND  e.emp_id = pt.assigned_to AND pt.strategy_ref IN(0,'".$strategyID."') AND pt.assigned_to = '".$empID."' ORDER BY pt.id DESC";
    return DB::select(DB::raw($query));
}


function other_paused_task($strategyID, $empID) {
	$query = "SELECT @s:=@s+1 as SNo, pt.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM paused_task pt, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = pt.assigned_by AND  e.emp_id = pt.assigned_to AND pt.strategy_ref IN(0,'".$strategyID."') AND pt.assigned_by = '".$empID."' ORDER BY pt.id DESC";
    return DB::select(DB::raw($query));
}

function my_adhoc_task($empID) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.output_ref = 0 AND t.assigned_to = '".$empID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function other_adhoc_task($empID) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.output_ref = 0 AND t.assigned_by = '".$empID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}


function task_resources($id) {
	$query = "SELECT (@s:=@s+1) as SNo, tr.*  FROM task_resources tr, (SELECT @s:=0) AS s WHERE tr.taskID = ".$id."";
    return DB::select(DB::raw($query));
}


function resource_cost($id) {
	$query = "SELECT SUM(cost) as cost FROM task_resources  WHERE taskID = ".$id."";
    $row = $query->row();
    return $row->cost;
}


function myoutput($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM output o, employee e,  (SELECT @s:=0) as s where e.emp_id = o.assigned_to ORDER BY o.id DESC";
		return DB::select(DB::raw($query));
	}


function tasklinemanager($id) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e,(SELECT @s:=0) as s WHERE e.emp_id = t.assigned_by and t.assigned_by ='".$id."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function tasklinemanager_and_staff($id) {
	$query = "SELECT *
FROM
(SELECT @s:=@s+1 as SNo, t.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e, (SELECT @s:=0) as s WHERE e.emp_id = t.assigned_to and t.assigned_by ='".$id."' order BY t.id DESC, SNo ASC)
    AS a

UNION ALL

SELECT *
FROM
(SELECT @s:=@s+1 as SNo,  t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e, (SELECT @s:=0) as s WHERE e.emp_id = t.assigned_to and t.assigned_to ='".$id."' order BY t.id DESC,SNo ASC)
    AS b

ORDER BY SNo ASC";
    return DB::select(DB::raw($query));
}


function taskstaff($id) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e,(SELECT @s:=0) as s WHERE e.emp_id = t.assigned_by and t.assigned_to ='".$id."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function customtask() {
	$query = "SELECT DISTINCT t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e WHERE e.emp_id = t.assigned_to and t.status=2";
    return DB::select(DB::raw($query));
}

function customtask_line($id) {
	$query = "SELECT DISTINCT  t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e WHERE e.emp_id = t.assigned_to and t.status=2 and e.line_manager =  '".$id."' UNION SELECT DISTINCT t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e WHERE e.emp_id = t.assigned_to and t.status=2 and e.emp_id = '".$id."'";
    return DB::select(DB::raw($query));
}


function update_notification_task_staff($empID)
	{
		$query = "UPDATE task SET notification = 0 WHERE assigned_to = '".$empID."' AND notification = 1";
		return true;
	}

function update_notification_task_line_manager($empID)
	{
		$this->db->trans_start();
		$query = "UPDATE task SET notification = 0 WHERE assigned_to = '".$empID."' AND notification = 1";
		$query = "UPDATE task SET notification = 0 WHERE  assigned_by = '".$empID."' AND  notification = 2";
		$this->db->trans_complete();
		return true;
	}


function task_staff_current($empID) {
	$query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  CONCAT(em.fname,' ', em.mname,' ', em.lname) as NAME, t.*  FROM task t, employee e, employee em, (SELECT @s:=0) as s WHERE e.emp_id = t.assigned_by AND t.assigned_to = em.emp_id AND  t.assigned_to ='".$empID."' AND t.notification = 1 ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function task_line_manager_current($empID) {
	$query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  CONCAT(em.fname,' ', em.mname,' ', em.lname) as NAME, t.*  FROM task t, employee e, employee em, (SELECT @s:=0) as s WHERE e.emp_id = t.assigned_by AND t.assigned_to = em.emp_id AND  t.assigned_by ='".$empID."' AND t.notification = 2 ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}


//
function tasksettings() {
	$query = "SELECT * FROM task_settings where id = 1";
    return DB::select(DB::raw($query));
}

function tasksettings_behaviour() {
	$query = "SELECT (@s:=@s+1) as SNo,  b.* FROM behaviour b, (SELECT @s:=0) AS s ORDER BY id ASC";
    return DB::select(DB::raw($query));
}
function tasksettings_ratings() {
	$query = "SELECT (@s:=@s+1) as SNo,  tr.* FROM task_ratings tr, (SELECT @s:=0) AS s ORDER BY id ASC";
    return DB::select(DB::raw($query));
}

function tasksettings_delay_percent() {
	$query = "SELECT value FROM task_settings WHERE id =2";
	$row = $query->row();
    return $row->value;
}

function behaviour_ids() {
	$query = "SELECT id FROM behaviour ORDER BY id ASC";
    return DB::select(DB::raw($query));
}


function add_task_parameter($data)
	{
		$this->db->insert("behaviour", $data);
		return true;

	}

function update_task_settings($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('task_settings', $data);
		return true;
	}

function update_taskResource($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('task_resources', $data);
		return true;
	}

function update_task_behaviour($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('behaviour', $data);
		return true;
	}

function update_task_ratings($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('task_ratings', $data);
		return true;
	}

function deleteBehaviourParameter($id)
	{
		$this->db->where("id", $id);
		$this->db->delete("behaviour");
		return true;
	}

function totalMarksbehaviour() {
	$query = "SELECT SUM(marks) AS totalMarks FROM behaviour";
    $row = $query->row();
    return $row->totalMarks;
}

function approvedtask($start, $end) {
	$query = "SELECT @s:=@s+1 AS SNo, t.assigned_to AS empID, ROUND(AVG(t.quantity+t.quality),2) AS scores, CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name, d.name AS department, p.name AS position, CONCAT(em.fname,' ', em.mname,' ', em.lname) AS executive,
COUNT(t.id) as task_counts,

 (SELECT tr.id FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality)  AND tr.upper_limit>AVG(t.quantity+t.quality)) AS category,

(SELECT tr.title FROM task_ratings tr WHERE tr.lower_limit <= AVG(t.quantity+t.quality)  AND tr.upper_limit>AVG(t.quantity+t.quality)) AS ratings  FROM task t, position p, department d, employee em, employee e, (SELECT @s:=0) AS s WHERE  e.emp_id = t.assigned_to AND e.position = p.id AND e.department = d.id AND e.line_manager = em.emp_id AND t.status = 2 AND t.date_completed BETWEEN '".$start."' AND '".$end."' GROUP BY t.assigned_to";
    return $query;
}

function addTaskResource($data)
	{
		$this->db->insert("task_resources", $data);
		return true;

	}


function strategyOutcomes($strategyID)
	{
		$query = "SELECT  o.* FROM outcome o WHERE  o.strategy_ref = '".$strategyID."'";

		return DB::select(DB::raw($query));
	}



function all_outcome($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.id, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive FROM outcome o, employee e,  (SELECT @s:=0) as s WHERE o.assigned_to=e.emp_id AND o.strategy_ref = '".$strategyID."'  ORDER BY o.id DESC";
// 		$query = "SELECT @s:=@s+1 as SNo, o.id, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive FROM outcome o, strategy str, employee e,  (SELECT @s:=0) as s WHERE o.assigned_to=e.emp_id AND str.id = o.strategy_ref ORDER BY str.id DESC";

		return DB::select(DB::raw($query));
	}

function outcome_info($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, str.title as strategyTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as responsible, o.* FROM employee e, outcome o, strategy str,  (SELECT @s:=0) as s WHERE o.assigned_to=e.emp_id AND str.id = o.strategy_ref AND  o.id = '".$id."'";
// 		$query=$this->db->get();

		return DB::select(DB::raw($query));
	}

function outcomeTitle($id)
	{
		$query = "SELECT title  FROM outcome WHERE  id = '".$id."'";

		return DB::select(DB::raw($query));
	}



function output_info($id)
	{
		$query = "SELECT  o.*, otc.title as OUTCOME_REF, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM output o, outcome otc, employee e where otc.id = o.outcome_ref and o.assigned_to=e.emp_id and  o.id ='". $id."'";

		return DB::select(DB::raw($query));
	}



function strategies()
	{
		$query = "SELECT @s:=@s+1 as SNo, s.*, f.name as funder,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref IN(SELECT id from outcome WHERE strategy_ref = s.id)) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref IN(SELECT id from outcome WHERE strategy_ref = s.id)) as countOutcome FROM strategy s, funder f, (SELECT @s:=0) as s WHERE s.funder = f.id ORDER BY s.id DESC";

		return DB::select(DB::raw($query));
	}


    function strategy_info($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, s.* FROM strategy s,  (SELECT @s:=0) as s WHERE s.id = ".$id."" ;

		return DB::select(DB::raw($query));
	}


	public function deleteStrategy($id) {

	    $this->db->trans_start();
		$query = "DELETE FROM strategy where id = '".$id."'";
		$query = "DELETE FROM outcome where strategy_ref = '".$id."'";
        $this->db->trans_complete();
        return true;

    }


	public function deleteOutcome($id) {
	    $this->db->trans_start();
		$query = "DELETE FROM outcome where id = '".$id."'";
		$query = "DELETE FROM output where outcome_ref = '".$id."'";
        $this->db->trans_complete();
        return true;

    }


	public function deleteOutput($id) {
	    $this->db->trans_start();
		$query = "DELETE FROM output where id = '".$id."'";
		$query = "DELETE FROM task where output_ref = '".$id."'";
        $this->db->trans_complete();
        return true;

    }

	public function clearStrategy() {
		$query = "DELETE FROM output WHERE  outcome_ref NOT IN(SELECT id FROM outcome) ";
		$query = "DELETE FROM task WHERE output_ref NOT IN(SELECT id FROM output)";
        return true;

    }
	public function deleteTask($id) {
		$query = "DELETE FROM task WHERE id = '".$id."'";
		$query = "DELETE FROM task_resources WHERE taskID = '".$id."'";
        return true;

    }
	public function deleteTaskResources($id) {
		$query = "DELETE FROM task_resources WHERE taskID  = '".$id."'";
        return true;

    }

	public function deleteResource($id) {

        $this->db->where('id',$id);
        $this->db->delete('task_resources');
        return true;

    }



function outcomes($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o, strategy str,  (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND str.id = o.strategy_ref AND o.strategy_ref = ".$id."";

		return DB::select(DB::raw($query));
	}

	function outcomes_for_reference($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.id, o.title outcomeTitle FROM outcome o,  (SELECT @s:=0) as s WHERE o.strategy_ref = ".$id." ORDER BY o.id DESC";

		return DB::select(DB::raw($query));
	}



	function outcomeDateRange($outcomeID)
	{
		$query = "SELECT otc.start, otc.end FROM outcome otc WHERE otc.id = ".$outcomeID." ";
		return DB::select(DB::raw($query));

	}

	function outputDateRange($outputID)
	{
		$query = "SELECT o.start, o.end FROM output o WHERE o.id = ".$outputID." ";
		return DB::select(DB::raw($query));

	}

	############################  STRATEGY ##################################


	############################  STRATEGY REPORTS ##################################

	function strategy_report_info($strategyID)
	{
		$query = "SELECT  s.*,  (SELECT SUM(task.progress) FROM task WHERE strategy_ref = ".$strategyID.") as sumProgress, (SELECT COUNT(task.id) FROM task WHERE strategy_ref = ".$strategyID." ) as countTask, (SELECT COUNT(outcome.id) FROM outcome WHERE strategy_ref = ".$strategyID." ) as  countOutcome , (SELECT COUNT(output.id) FROM output WHERE strategy_ref = ".$strategyID." ) as  countOutput FROM strategy s WHERE s.id = ".$strategyID." ";

		return DB::select(DB::raw($query));
	}


	############################  END STRATEGY REPORTS ##################################



	function addstrategy($data) {
		$this->db->insert("strategy", $data);
		return true;

	}

	function strategyDateRange($strategyID)
	{
		$query = "SELECT st.start, st.end FROM strategy st WHERE st.id = ".$strategyID." ";
		return DB::select(DB::raw($query));

	}

	function update_strategy($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('strategy', $data);
		return true;
	}

	########################## OUTCOME ##########################

    function update_outcome($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('outcome', $data);
		return true;
	}
	function add_outcome($data)
	{
		$this->db->insert("outcome", $data);
		return true;

	}

	function outcomeCost($id) {
	$query = "SELECT SUM(t.monetaryValue) as outcomeCost, (SELECT count(ot.id) FROM output ot WHERE ot.outcome_ref = '".$id."' ) as outputCount, count(t.id) as taskCount FROM task t WHERE  t.output_ref IN(SELECT outp.id FROM output outp WHERE outp.outcome_ref = '".$id."' )";
    return DB::select(DB::raw($query));
	}


	function outcomeResourceCost($outcomeID) {
		$query = "SELECT SUM(tr.cost) as sumCost FROM task_resources tr, outcome o, task t WHERE tr.taskID = t.id AND t.outcome_ref =  '".$outcomeID."'";
	   	$row = $query->row();
	   	return $row->sumCost;
	}


function outcomeOutputCompleted($outcomeID) {
	$query = " SELECT count(o.id) as progress FROM output o WHERE   (SELECT count(t.id) FROM task t WHERE t.outcome_ref = '".$outcomeID."' )*100 = (SELECT SUM(t.progress) FROM task t WHERE t.status = 2 and t.outcome_ref = '".$outcomeID."' ) AND o.outcome_ref = '".$outcomeID."'";
    $row = $query->row();
   	return $row->progress;
}

function outcomeOutputProgress($outcomeID) {
	$query = "SELECT  count(o.id) as progress FROM output o WHERE (SELECT SUM(t.progress) FROM task t WHERE NOT t.status = 2 AND t.outcome_ref = '".$outcomeID."' ) > 0 AND o.outcome_ref = '".$outcomeID."' ";
    $row = $query->row();
   	return $row->progress;
}

function outcomeOutputNotStarted($outcomeID) {
	$query = "SELECT  count(o.id) as progress FROM output o WHERE (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id ) = 0 AND o.outcome_ref = ".$outcomeID." ";
    $row = $query->row();
   	return $row->progress;
}

	function outputs($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) as countTask FROM output o, employee e, (SELECT @s:=0) as s WHERE o.assigned_to = e.emp_id AND o.outcome_ref ='". $id."' and NOT o.id = 0";

		return DB::select(DB::raw($query));
	}


function outputProgress($id)
	{
		$query = "SELECT SUM(t.progress) as percent  FROM task t WHERE t.output_ref ='". $id."'";
		/*$row = $query->row();
    	return $row->percent;*/
    	 return DB::select(DB::raw($query));
	}

function outputtaskCount($id)
	{
		$query = "SELECT COUNT(t.id) as taskCount  FROM task t WHERE t.output_ref ='". $id."'";
		$row = $query->row();
    	return $row->taskCount;
	}

function outputs_select()
	{
		$query = "SELECT * FROM output";
		return DB::select(DB::raw($query));
	}

function all_output($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT COUNT(id) FROM task WHERE output_ref = o.id) as countTask, (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress FROM output o, employee e, employee ea, (SELECT @s:=0) as s WHERE o.assigned_to = ea.emp_id AND e.emp_id = o.assigned_by AND o.strategy_ref = '".$strategyID."' ORDER BY o.id DESC ";

		return DB::select(DB::raw($query));
	}



function output_tasks($id) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM task t, employee e,(SELECT @s:=0) as s WHERE e.emp_id = t.assigned_to  and t.output_ref =  '".$id."'";
    return DB::select(DB::raw($query));
}

function outputCost($outputID) {
	$query = "SELECT SUM(t.monetaryValue) as outputCost, count(t.id) as taskCount FROM task t WHERE t.output_ref =  '".$outputID."'";
    return DB::select(DB::raw($query));
}

function outputResourceCost($outputID) {
	$query = "SELECT SUM(tr.cost) as sumCost FROM task_resources tr, output o, task t WHERE tr.taskID = t.id AND t.output_ref =  '".$outputID."'";
   	$row = $query->row();
   	return $row->sumCost;
}




function outputCompleted($id) {
	$query = " SELECT count(o.id) FROM output o WHERE NOT o.id=0 AND  (SELECT count(t.id) FROM task t WHERE t.status = 2 and t.output_ref IN (SELECT outp.id FROM output outp WHERE outp.outcome_ref = '".$id."' ))";
    return DB::select(DB::raw($query));
}

function outputTaskComplete($outputID) {
	$query = "SELECT  count(t.id) as progress FROM task t WHERE t.status = 2 and t.output_ref =  '".$outputID."'";
    $row = $query->row();
   	return $row->progress;
}

function outputTaskProgress($outputID) {
	$query = "SELECT  count(t.id) as progress FROM task t WHERE t.progress >0  AND NOT t.status = 2 and t.output_ref =  '".$outputID."'";
    $row = $query->row();
   	return $row->progress;
}

function outputTaskNotStarted($outputID) {
	$query = "SELECT  count(t.id) as progress FROM task t WHERE t.progress = 0 AND t.output_ref =  '".$outputID."'";
    $row = $query->row();
   	return $row->progress;
}

function getbehaviour(){
	$query = 'SELECT @s:=@s+1 as SNo,  b.* FROM behaviour b, (SELECT @s:=0) as s ';
	return DB::select(DB::raw($query));
}

function count_behaviour(){
	$query = 'SELECT b.id FROM behaviour b';
	return $query->num_rows();
}


function addtask($data)
	{
		$this->db->insert("task", $data);
		return true;

	}

function get_task_marking_attributes(){
	$query = 'SELECT * FROM task_settings WHERE id = 1';
	return DB::select(DB::raw($query));
}

function get_task_ratings(){
	$query = 'SELECT * FROM task_ratings';
	return DB::select(DB::raw($query));
}




function gettaskbyid($id)
	{
		$query = "SELECT t.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM task t, employee e where e.emp_id=t.assigned_to and t.id =".$id."";
	return DB::select(DB::raw($query));
	}

	function getcomments($id) {
	$query = "SELECT DISTINCT t.*, c.*, (SELECT e.photo from employee e WHERE e.emp_id=c.staff ) as photo, (SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname) from employee e WHERE e.emp_id=c.staff ) as NAME  FROM task t, employee e, comments c WHERE c.taskID = t.id and t.id ='".$id."' order by c.id";
    return DB::select(DB::raw($query));
}

function progress_comment($data, $progress, $taskID){

	$this->db->trans_start();
	$this->db->insert("comments", $data);
    $query = "UPDATE task SET progress ='".$progress."' WHERE id ='".$taskID."'";
    $this->db->trans_complete();

	return true;

	}

function rejectTask($comments, $taskUpdates, $taskID){

	$this->db->trans_start();
	$this->db->insert("comments", $comments);
	$this->db->where('id', $taskID);
	$this->db->update('task', $taskUpdates);
    $this->db->trans_complete();

	return true;

	}
function updateTask($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('task', $data);
		return true;
	}

function updateTaskReference($data, $outputID)
	{
		$this->db->where('output_ref', $outputID);
		$this->db->update('task', $data);
		return true;
	}

function taskdropdown($id)
	{
		$query = "SELECT e.emp_id as ID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e where e.line_manager = '".$id."'";

		return DB::select(DB::raw($query));
	}

	function task_notification_employee($empID)
	{
		$query = "SELECT t.id FROM task t WHERE  t.assigned_to = '".$empID."' AND t.isAssigned = 1 AND t.notification =1";
		return $query->num_rows();
	}


	function task_notification_line_manager($empID)
	{
		$query = "SELECT t.id FROM task t WHERE  t.assigned_by = '".$empID."' AND t.isAssigned = 1 AND t.notification = 2 ";
		return $query->num_rows();
	}

	######################### STRATEGY DASHBOARD #################################

	function getCurrentStrategy()
	{
		$query = "SELECT id as strategyID FROM strategy ORDER BY id DESC limit 1";
		$row = $query->row();
    	return $row->strategyID;
	}

	function addFunder($data) {
		$this->db->insert("funder", $data);
		return true;

	}

    function addSegment($data) {
        $this->db->insert("project_segment", $data);
        return true;

    }

    function addCategory($data) {
        $this->db->insert("expense_category", $data);
        return true;

    }

    function addException($data) {
        $this->db->insert("exception_type", $data);
        return true;

    }

    function addRequest($data) {
        $this->db->insert("grant_logs", $data);
        return true;

    }

    function getGrantCode($activity_code,$project_code) {
        $query = "select grant_code,amount,funder from activity_grant act_g, grants g, activity act where act_g.activity_code = act.code
and g.code = act_g.grant_code and activity_code = '".$activity_code."' and act.project_ref = '".$project_code."' ";
        return DB::select(DB::raw($query));

    }

    function updateGrant($id, $data) {
	    "update grants set amount = '".$data['amount']."' where code = '".$id."' ";
        return true;

    }

    function addCost($data) {
        $this->db->insert("activity_cost", $data);
        return true;

    }

	function addActivity($data) {
		$this->db->insert("activity", $data);
		return true;

	}
    function getActivities($taskID)
	{
		$query = "SELECT *, CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee FROM activity a, employee e  WHERE e.emp_id = a.createdBy AND taskID = ".$taskID."";
		return DB::select(DB::raw($query));
	}
    function getFunders()
	{
		$query = "SELECT * FROM funder where status = 1 ";
		return DB::select(DB::raw($query));
	}

    function getRequest()
    {
        $query = "SELECT gl.*, f.name FROM grant_logs gl, funder f where gl.funder = f.id and mode = 'IN' ";
        return DB::select(DB::raw($query));
    }

    function getProjectSegment()
    {
        $query = "SELECT * FROM project_segment";
        return DB::select(DB::raw($query));
    }

    function getExpenseCategory()
    {
        $query = "SELECT * FROM expense_category";
        return DB::select(DB::raw($query));
    }

    function getException()
    {
        $query = "SELECT * FROM exception_type";
        return DB::select(DB::raw($query));
    }



	function outcomesProgress($strategyID)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id)>0 AND ((SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id)/(SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id )) <100 AND  o.strategy_ref = ".$strategyID."";
		$row = $query->row();
		return $row->progressOutcome;
	}

	function outcomesNotStarted($strategyID, $today)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id)=0 AND o.strategy_ref = ".$strategyID."";
		$row = $query->row();
		return $row->progressOutcome;
	}

	function outcomesCompleted($strategyID)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id ) =  ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id )*100) AND  o.strategy_ref = ".$strategyID."";
		$row = $query->row();
		return $row->progressOutcome;
	}

	function outcomesOverdue($strategyID, $today)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE   (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id ) < ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id )*100)  AND   o.end < '".$today."' AND  o.strategy_ref = ".$strategyID." ";
		$row = $query->row();
		return $row->progressOutcome;
	}

	function outputsNotStarted($strategyID, $today)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE  o.strategy_ref = ".$strategyID."  AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id)=0 ";
		$row = $query->row();
		return $row->progressOutput;
	}

	function outputsProgress($strategyID)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE  o.strategy_ref =  ".$strategyID."  AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id )>0  AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id )< ((SELECT COUNT(task.id) FROM task WHERE output_ref = o.id )*100) ";
		$row = $query->row();
		return $row->progressOutput;
	}

	function outputsCompleted($strategyID)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE  o.strategy_ref = ".$strategyID."  AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id )=((SELECT COUNT(task.id) FROM task WHERE output_ref = o.id )*100) AND o.strategy_ref = ".$strategyID." ";
		$row = $query->row();
		return $row->progressOutput;
	}

	function outputsOverdue($strategyID, $today)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE o.end < '".$today."' AND  o.strategy_ref = ".$strategyID."  AND (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id ) < ((SELECT COUNT(task.id) FROM task WHERE output_ref = o.id )*100)";
		$row = $query->row();
		return $row->progressOutput;
	}

	function tasksNotStarted($strategyID)
	{
		$query = "SELECT COUNT(t.id) as progressTask FROM task t WHERE t.strategy_ref = ".$strategyID."  AND t.progress=0 ";
		$row = $query->row();
		return $row->progressTask;
	}

	function tasksProgress($strategyID)
	{
		$query = "SELECT COUNT(t.id) as progressTask FROM task t WHERE  t.strategy_ref = ".$strategyID."  AND t.progress>0 AND NOT t.status =2 ";
		$row = $query->row();
		return $row->progressTask;
	}

	function tasksCompleted($strategyID)
	{
		$query = "SELECT COUNT(t.id) as progressTask FROM task t WHERE  t.strategy_ref = ".$strategyID."  AND t.status = 2 ";
		$row = $query->row();
		return $row->progressTask;
	}

	function tasksOverdue($strategyID, $today)
	{
		$query = "SELECT COUNT(t.id) as progressTask FROM task t WHERE t.end < '".$today."' AND   t.strategy_ref = ".$strategyID." AND NOT t.status=2 ";
		$row = $query->row();
		return $row->progressTask;
	}

	//0ver 80% of Time elaspsed but not Completed.
	function outcomeOffTrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE (SELECT SUM(progress) FROM task WHERE outcome_ref = o.id)>=0 AND ((SELECT SUM(progress) FROM task WHERE outcome_ref = o.id)/(SELECT COUNT(id) FROM task WHERE outcome_ref = o.id))<100  AND ( (datediff('".$today."', o.start)+1)/(datediff(o.end, o.start)+1) )*100 >= ".$elapsedPercent." AND o.end >= '".$today."' AND  o.strategy_ref = ".$strategyID." ";
		$row = $query->row();
		return $row->progressOutcome;
	}

	//0ff Track less than 80% elaspsed but not Completed.
	function outcomeOntrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(o.id) as progressOutcome FROM outcome o WHERE (SELECT SUM(progress) FROM task WHERE outcome_ref = o.id)>=0 AND ((SELECT SUM(progress) FROM task WHERE outcome_ref = o.id)/(SELECT COUNT(id) FROM task WHERE outcome_ref = o.id))<100 AND ( (datediff('".$today."', o.start)+1)/(datediff(o.end, o.start)+1) )*100 < ".$elapsedPercent." AND o.end >= '".$today."' AND  o.strategy_ref = ".$strategyID." ";
		$row = $query->row();
		return $row->progressOutcome;
	}



	//0ver 80% elaspsed but not Completed.
	function outputOffTrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE  o.strategy_ref = ".$strategyID."  AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id)) >=0 AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))<100  AND ( (datediff('".$today."', o.start)+1)/(datediff(o.end, o.start)+1) )*100 >= ".$elapsedPercent." AND o.end >= '".$today."' ";
		$row = $query->row();
		return $row->progressOutput;
	}

	//0ff Track less than 80% elaspsed but not Completed.
	function outputOntrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(o.id) as progressOutput FROM output o WHERE  o.strategy_ref = ".$strategyID."  AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))>=0 AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))<100 AND ((datediff('".$today."', o.start)+1)/(datediff(o.end, o.start)+1) )*100 < ".$elapsedPercent." AND o.end >= '".$today."' ";
		$row = $query->row();
		return $row->progressOutput;
	}


	//0ver 80% Time elaspsed but not Completed.
	function taskOffTrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(t.id) as progressTask  FROM task t WHERE NOT t.status = 2 AND ((datediff( '".$today."', t.start)+1)/(datediff(t.end, t.start)+1))*100>=".$elapsedPercent." AND  t.strategy_ref = ".$strategyID." AND t.end >=  '".$today."' ";
		$row = $query->row();
		return $row->progressTask;
	}

	//0ff Track Time Elapsed less than 80%  but not Completed.
	function taskOntrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT COUNT(t.id) as progressTask  FROM task t WHERE NOT t.status = 2 AND ((datediff( '".$today."', t.start)+1)/(datediff(t.end, t.start)+1))*100<".$elapsedPercent." AND  t.strategy_ref = ".$strategyID." AND t.end >=  '".$today."' ";
		$row = $query->row();
		return $row->progressTask;
	}

function outcomesGraph($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, otc.id,  otc.strategy_ref,  (SELECT SUM(t.progress) FROM task t WHERE t.outcome_ref = otc.id) as sumProgress, (SELECT COUNT(t.id) FROM task t WHERE t.outcome_ref = otc.id ) as taskCount FROM outcome otc, (SELECT @s:=0) as s WHERE otc.strategy_ref = ".$strategyID."";

		return DB::select(DB::raw($query));
	}
function strategyProgress($id)
	{
		$query = "SELECT  s.id,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref IN(SELECT id from outcome WHERE strategy_ref = s.id)) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref IN(SELECT id from outcome WHERE strategy_ref = s.id)) as countTask FROM strategy s WHERE s.id = ".$id."";
	    $row = DB::select(DB::raw($query));

        // dd($row);
	    if($row[0]->countTask==0){ return 0;} else return $row[0]->sumProgress/$row[0]->countTask;
	}

function outputsGraph($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo,  o.id, o.strategy_ref, o.outcome_ref,   (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress, (SELECT COUNT(t.id) FROM task t WHERE t.output_ref = o.id ) as taskCount FROM output o,  (SELECT @s:=0) as s WHERE  o.strategy_ref = ".$strategyID." ";
		return DB::select(DB::raw($query));
	}

	function outcomesList($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.id, o.title FROM outcome o, (SELECT @s:=0) as s WHERE o.strategy_ref =".$id."";

		return DB::select(DB::raw($query));
	}

	function defaultOutcome($id)
	{
		$query = "SELECT o.id FROM outcome o  WHERE o.strategy_ref =".$id." ORDER BY o.id DESC LIMIT 1";
		$row = $query->row();
		return $row->id;
	}


	function percentSetting()
	{
		$query = "SELECT value FROM task_settings WHERE id = 2 ";
		$row = $query->row();
		return $row->value;
	}



	// CLICKABLE PIE CHART REDIRECTS

	function pie_outcomescompleted($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o, strategy str,  (SELECT @s:=0) as s, employee e WHERE (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id ) =  ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id )*100) AND  e.emp_id = o.assigned_to AND str.id = o.strategy_ref AND o.strategy_ref = ".$strategyID."";
		return DB::select(DB::raw($query));
	}

function pie_outcomesoverdue($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o, strategy str,  (SELECT @s:=0) as s, employee e WHERE  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id ) < ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id )*100)  AND   o.end < '".$today."' AND  e.emp_id = o.assigned_to AND str.id = o.strategy_ref AND o.strategy_ref = ".$strategyID."";

		return DB::select(DB::raw($query));
	}

	function pie_outcomesontrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o, strategy str,  (SELECT @s:=0) as s, employee e WHERE  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) < ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND strategy_ref=".$strategyID.")*100)  AND ( (datediff('".$today."', o.start))/(datediff(o.end, o.start)) )*100 < ".$elapsedPercent." AND o.end > '".$today."' AND  e.emp_id = o.assigned_to AND str.id = o.strategy_ref AND o.strategy_ref = ".$strategyID."";
		return DB::select(DB::raw($query));
	}

	function pie_outcomesofftrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, str.title as strTitle, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o, strategy str,  (SELECT @s:=0) as s, employee e WHERE  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) < ((SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND strategy_ref=".$strategyID.")*100)  AND ( (datediff('".$today."', o.start))/(datediff(o.end, o.start)) )*100 >= ".$elapsedPercent." AND o.end > '".$today."' AND  e.emp_id = o.assigned_to AND str.id = o.strategy_ref AND o.strategy_ref = ".$strategyID."";
		return DB::select(DB::raw($query));
	}


   function pie_outputscompleted($strategyID)
	{

		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT COUNT(id) FROM task WHERE output_ref = o.id) as countTask, (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress FROM output o, employee e, employee ea, (SELECT @s:=0) as s WHERE (SELECT SUM(progress) FROM task WHERE output_ref = o.id AND strategy_ref = ".$strategyID." )=((SELECT COUNT(task.id) FROM task WHERE output_ref = o.id )*100) AND o.assigned_to = ea.emp_id AND e.emp_id = o.assigned_by AND o.strategy_ref = '".$strategyID."' ORDER BY o.id DESC ";

		return DB::select(DB::raw($query));
	}


	function pie_outputsontrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT  @s:=@s+1 as SNo, o.*, CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT COUNT(id) FROM task WHERE output_ref = o.id) as countTask, (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress  FROM output o, employee e, employee ea, (SELECT @s:=0) as s  WHERE  o.strategy_ref = ".$strategyID." AND o.assigned_to = ea.emp_id AND e.emp_id = o.assigned_by  AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))>=0 AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))<100 AND ((datediff('".$today."', o.start)+1)/(datediff(o.end, o.start)+1) )*100 < ".$elapsedPercent." AND o.end >= '".$today."' ORDER BY o.id DESC";
		return DB::select(DB::raw($query));
	}

	function pie_outputsofftrack($strategyID, $today, $elapsedPercent)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT COUNT(id) FROM task WHERE output_ref = o.id) as countTask, (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress FROM output o, employee e, employee ea, (SELECT @s:=0) as s WHERE ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id)) >=0 AND ((SELECT SUM(progress) FROM task WHERE output_ref = o.id)/(SELECT COUNT(id) FROM task WHERE output_ref = o.id))<100  AND ( (datediff('".$today."', o.start))/(datediff(o.end, o.start)) )*100 >= ".$elapsedPercent." AND o.end > '".$today."' AND o.assigned_to = ea.emp_id AND e.emp_id = o.assigned_by AND o.strategy_ref = '".$strategyID."' ORDER BY o.id DESC ";
		return DB::select(DB::raw($query));
	}

	function pie_outputsoverdue($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT COUNT(id) FROM task WHERE output_ref = o.id) as countTask, (SELECT SUM(t.progress) FROM task t WHERE t.output_ref = o.id) as sumProgress FROM output o, employee e, employee ea, (SELECT @s:=0) as s WHERE (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id ) < ((SELECT COUNT(task.id) FROM task WHERE output_ref = o.id )*100)  AND   o.end < '".$today."' AND o.assigned_to = ea.emp_id AND e.emp_id = o.assigned_by AND o.strategy_ref = '".$strategyID."' ORDER BY o.id DESC ";
		return DB::select(DB::raw($query));
	}


	function pie_taskcompleted($strategyID) {
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.status = 2 AND t.strategy_ref = '".$strategyID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
	}

function pie_taskoverdue($strategyID, $today) {
	$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE t.end < '".$today."' AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND t.strategy_ref = '".$strategyID."' ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function pie_taskontrack($strategyID, $today, $elapsedPercent)
	{

		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE  ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND ((datediff( '".$today."', t.start)+1)/(datediff(t.end, t.start)+1))*100<".$elapsedPercent." AND t.end >= '".$today."' AND t.strategy_ref = '".$strategyID."'  ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
	}

function pie_taskofftrack($strategyID, $today, $elapsedPercent) {

		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, employee e, employee ex, (SELECT @s:=0) as s WHERE  ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND ((datediff( '".$today."', t.start)+1)/(datediff(t.end, t.start)+1))*100>=".$elapsedPercent." AND t.end >= '".$today."' AND t.strategy_ref = '".$strategyID."'  ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
	}


	############################ STRATEGY REPORTS ##################################


	######## ALL ALL
function all_all_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to  AND o.strategy_ref = ".$strategyID."";

		return DB::select(DB::raw($query));
	}
   function all_all_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." ";

		return DB::select(DB::raw($query));
	}
function all_all_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE   t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}

	###### ALL FINANCIAL
function all_fin_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to  AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=1)";

		return DB::select(DB::raw($query));
	}
   function all_fin_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 1)  ";

		return DB::select(DB::raw($query));
	}
function all_fin_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE   t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.quantity_type =1 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}



	###### ALL QUANTITY
function all_qty_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to  AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=2)";

		return DB::select(DB::raw($query));
	}
   function all_qty_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 2)  ";

		return DB::select(DB::raw($query));
	}
function all_qty_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE   t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.quantity_type =2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## PROGRESS ALL
function progress_all_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=1 AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
   function progress_all_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE task.quantity_type=1 AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
function progress_all_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## PROGRESS FINANCIAL
function progress_fin_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=1 AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
   function progress_fin_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as countTask FROM output o, outcome outc, employee e, (SELECT @s:=0) as s WHERE outc.id = o.outcome_ref AND o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 1 AND NOT task.status = 2)  ";

		return DB::select(DB::raw($query));
	}
function progress_fin_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND t.quantity_type = 1 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## PROGRESS QUANTITY
function progress_qty_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=2 AND NOT task.status = 2 ) ";

		return DB::select(DB::raw($query));
	}
   function progress_qty_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as countTask FROM output o, outcome outc, employee e, (SELECT @s:=0) as s WHERE outc.id = o.outcome_ref AND o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 2 AND NOT task.status = 2)  ";

		return DB::select(DB::raw($query));
	}
function progress_qty_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND t.quantity_type = 2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}



	######## COMPLETED ALL
function completed_all_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND task.status = 2) as countOutput FROM outcome o, (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to  AND o.strategy_ref = ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.status = 2)";

		return DB::select(DB::raw($query));
	}
   function completed_all_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND task.status = 2) as countTask FROM output o, employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.id IN(SELECT task.output_ref FROM task WHERE task.status = 2)";

		return DB::select(DB::raw($query));
	}
function completed_all_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND  t.status = 2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}



function completed_fin_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.initial_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as submitted_quantity, IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id )), 0 ) as resource_cost FROM outcome o,  (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref =  ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.status = 2 AND task.quantity_type=1 )";

		return DB::select(DB::raw($query));
	}
   function completed_fin_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.initial_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as submitted_quantity,  IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id FROM task WHERE output_ref = o.id )), 0 ) as resource_cost FROM output o, employee e, (SELECT @s:=0)  as s WHERE o.assigned_to = e.emp_id AND o.strategy_ref = ".$strategyID."  AND o.id IN(SELECT task.output_ref FROM task WHERE task.status = 2 AND task.quantity_type = 1)";

		return DB::select(DB::raw($query));
	}
function completed_fin_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive, IF( (SELECT COUNT(tr.id) FROM task_resources tr WHERE tr.taskID = t.id)>0,  (SELECT SUM(tr.cost) FROM task_resources tr WHERE tr.taskID = t.id), 0 ) as resource_cost  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND  t.status = 2 AND t.quantity_type=1 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}




function completed_qty_outcomes($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.initial_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2 AND task.quantity_type = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2 AND task.quantity_type = 2) as submitted_quantity, IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id )), 0 ) as resource_cost FROM outcome o,  (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref =  ".$strategyID." AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.status = 2 AND task.quantity_type=2)";

		return DB::select(DB::raw($query));
	}
   function completed_qty_output($strategyID)
	{
		$query = "	SELECT @s:=@s+1 as SNo, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.initial_quantity) FROM task WHERE output_ref = o.id AND task.status = 2 AND task.quantity_type = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE output_ref = o.id AND task.status = 2 AND task.quantity_type = 2) as submitted_quantity,  IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id )), 0 ) as resource_cost FROM output o, employee e, (SELECT @s:=0)  as s WHERE o.assigned_to = e.emp_id AND o.strategy_ref = ".$strategyID."  AND o.id IN(SELECT task.output_ref FROM task WHERE task.status = 2 AND task.quantity_type = 2)";

		return DB::select(DB::raw($query));
	}
function completed_qty_task($strategyID)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive, IF( (SELECT COUNT(tr.id) FROM task_resources tr WHERE tr.taskID = t.id)>0,  (SELECT SUM(tr.cost) FROM task_resources tr WHERE tr.taskID = t.id), 0 ) as resource_cost  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND  t.status = 2 AND t.quantity_type=2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}




function total_completed_fin_outcomes($strategyID)
	{
		$query = "SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM  (SELECT o.*, (SELECT SUM(task.initial_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as submitted_quantity, IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id )), 0 ) as resource_cost FROM outcome o, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref =  ".$strategyID."  AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.status = 2 AND task.quantity_type=1) ) AS parent_query";

		return DB::select(DB::raw($query));
	}
   function total_completed_fin_output($strategyID)
	{
		$query = "	SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM (SELECT o.*, (SELECT SUM(task.initial_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as initial_quantity, (SELECT SUM(task.submitted_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as submitted_quantity,  IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id )), 0 ) as resource_cost FROM output o, employee e WHERE o.assigned_to = e.emp_id AND o.strategy_ref = ".$strategyID."  AND o.id IN(SELECT task.output_ref FROM task WHERE task.status = 2 AND task.quantity_type = 1) ) AS parent_query";

		return DB::select(DB::raw($query));
	}
function total_completed_fin_task($strategyID)
	{
		$query = "SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM (SELECT  t.*, IF( (SELECT COUNT(tr.id) FROM task_resources tr WHERE tr.taskID = t.id)>0,  (SELECT SUM(tr.cost) FROM task_resources tr WHERE tr.taskID = t.id), 0 ) as resource_cost  FROM task t,  employee e, employee ex WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND  t.status = 2 AND t.quantity_type=1 ) AS parent_query";

		return DB::select(DB::raw($query));
	}

function total_completed_qty_outcomes($strategyID)
	{
		$query = "SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM  (SELECT o.*, (SELECT SUM(task.initial_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as initial_quantity,  (SELECT SUM(task.submitted_quantity) FROM task WHERE outcome_ref = o.id AND task.status = 2) as submitted_quantity, IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE outcome_ref = o.id )), 0 ) as resource_cost FROM outcome o, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref =  ".$strategyID."  AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.status = 2 AND task.quantity_type=2) ) AS parent_query";

		return DB::select(DB::raw($query));
	}
   function total_completed_qty_output($strategyID)
	{
		$query = "	SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM (SELECT o.*, (SELECT SUM(task.initial_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as initial_quantity, (SELECT SUM(task.submitted_quantity) FROM task WHERE output_ref = o.id AND task.status = 2) as submitted_quantity,  IF( (SELECT COUNT(tr.id) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id ))>0,  (SELECT SUM(tr.cost) FROM task_resources tr, task t WHERE tr.taskID = t.id AND t.id IN(SELECT id from task WHERE output_ref = o.id )), 0 ) as resource_cost FROM output o, employee e WHERE o.assigned_to = e.emp_id AND o.strategy_ref = ".$strategyID."  AND o.id IN(SELECT task.output_ref FROM task WHERE task.status = 2 AND task.quantity_type = 2) ) AS parent_query";

		return DB::select(DB::raw($query));
	}
function total_completed_qty_task($strategyID)
	{
		$query = "SELECT SUM(resource_cost) AS total_resource_cost, SUM(initial_quantity) AS total_target, SUM(submitted_quantity) AS total_results FROM (SELECT  t.*, IF( (SELECT COUNT(tr.id) FROM task_resources tr WHERE tr.taskID = t.id)>0,  (SELECT SUM(tr.cost) FROM task_resources tr WHERE tr.taskID = t.id), 0 ) as resource_cost  FROM task t,  employee e, employee ex WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND  t.status = 2 AND t.quantity_type=2 ) AS parent_query";

		return DB::select(DB::raw($query));
	}



	######## OVERDUE ALL
function overdue_all_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.end < '".$today."'  AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
   function overdue_all_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.output_ref FROM task WHERE task.end < '".$today."'  AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
function overdue_all_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.end < '".$today."'  AND NOT t.status = 2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## OVERDUE FINANCIAL
function overdue_fin_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=1 AND task.end < '".$today."'  AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
   function overdue_fin_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countTask FROM output o, outcome outc, employee e, (SELECT @s:=0) as s WHERE outc.id = o.outcome_ref AND o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 1 AND task.end < '".$today."'  AND NOT task.status = 2) ";

		return DB::select(DB::raw($query));
	}
function overdue_fin_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.end < '".$today."'  AND NOT t.status = 2 AND t.quantity_type = 1 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## OVERDUE QUANTITY
function overdue_qty_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.outcome_ref FROM task WHERE task.quantity_type=2 AND task.end < '".$today."'  AND NOT task.status = 2 ) ";

		return DB::select(DB::raw($query));
	}
   function overdue_qty_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.end < '".$today."') as countTask FROM output o, outcome outc, employee e, (SELECT @s:=0) as s WHERE outc.id = o.outcome_ref AND o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end < '".$today."' AND o.id IN(SELECT task.output_ref FROM task WHERE  task.quantity_type = 2 AND task.end < '".$today."'  AND NOT task.status = 2)  ";

		return DB::select(DB::raw($query));
	}
function overdue_qty_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND NOT t.status = 2 AND t.quantity_type = 2 AND t.end < '".$today."' ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## ALL NOT STARTED
function not_started_all_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2) as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.outcome_ref =  o.id )=0 ";

		return DB::select(DB::raw($query));
	}
   function not_started_all_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2) as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.output_ref =  o.id )=0 ";

		return DB::select(DB::raw($query));
	}
function not_started_all_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.end > '".$today."' AND t.progress < 100 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}



	######## FINANCIAL NOT STARTED
function not_started_fin_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.progress = 0 AND task.end > '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.progress = 0 AND task.end > '".$today."') as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.outcome_ref =  o.id AND task.quantity_type = 1)=0 ";

		return DB::select(DB::raw($query));
	}
   function not_started_fin_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.progress = 0 AND task.end > '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.progress = 0  AND task.end > '".$today."') as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.output_ref =  o.id AND task.quantity_type = 1 AND task.end > '".$today."' )=0 ";

		return DB::select(DB::raw($query));
	}
function not_started_fin_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.end > '".$today."' AND t.progress = 0 AND t.quantity_type = 1 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}


	######## QUANTITATIVE NOT STARTED
function not_started_qty_outcomes($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, o.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end > '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id AND NOT task.status = 2 AND task.end > '".$today."') as countOutput FROM outcome o,   (SELECT @s:=0) as s, employee e WHERE e.emp_id = o.assigned_to AND o.strategy_ref = ".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.outcome_ref =  o.id AND task.quantity_type = 2 AND task.end > '".$today."')=0 ";

		return DB::select(DB::raw($query));
	}
   function not_started_qty_output($strategyID, $today)
	{
		$query = "	SELECT @s:=@s+1 as SNo,  o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.quantity_type = 2  AND task.end > '".$today."') as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id AND NOT task.status = 2 AND task.quantity_type = 2  AND task.end > '".$today."') as countTask FROM output o,  employee e, (SELECT @s:=0) as s WHERE  o.assigned_to = e.emp_id AND o.strategy_ref =".$strategyID." AND o.end > '".$today."' AND (SELECT SUM(task.progress) FROM task WHERE  task.output_ref =  o.id AND task.quantity_type = 2  AND task.end > '".$today."' )=0 ";

		return DB::select(DB::raw($query));
	}
function not_started_qty_task($strategyID, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t,  employee e, employee ex, (SELECT @s:=0) as s WHERE  t.strategy_ref = ".$strategyID." AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to AND t.end > '".$today."' AND t.progress = 0 AND t.quantity_type = 2 ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}

	############################ STRATEGY REPORTS ##################################

    function output_report($id)
	{
		$query = "	SELECT @s:=@s+1 as SNo, outc.title as outcomeTitle, o.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive, (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) as sumProgress, (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) as countTask FROM output o, outcome outc, employee e, (SELECT @s:=0) as s WHERE outc.id = o.outcome_ref AND o.assigned_to = e.emp_id AND o.outcome_ref IN(SELECT id FROM outcome WHERE strategy_ref =".$id." ) AND outc.strategy_ref = ".$id."";

		return DB::select(DB::raw($query));
	}

 function task_report($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, t.*, o.title as outputTitle,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive  FROM task t, output o, employee e, employee ex, (SELECT @s:=0) as s WHERE o.id = t.output_ref and t.outcome_ref = o.outcome_ref AND o.outcome_ref IN(SELECT id FROM outcome where strategy_ref = ".$id.") AND ex.emp_id = t.assigned_by AND  e.emp_id = t.assigned_to ORDER BY t.id DESC";

		return DB::select(DB::raw($query));
	}

	function add_output($data)
	{
		$this->db->insert("output", $data);
		return true;

	}

    function update_output($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('output', $data);
		return true;
	}

function highlights() {
	$query = " SELECT (SELECT count(emp_id) from employee) as EMPLOYEES, (SELECT count(t.id) from task t where t.status = 2) as COMPLETED_TASKS, (SELECT count(t.id) from task t where t.status = 0) as ONPROGRESS_TASKS,(SELECT count(t.id) from task t) as ALL_TASKS, (SELECT count(id) from loan) as LOANS, (SELECT count(id) from loan_application) as LOAN_APPLICATIONS";
    return DB::select(DB::raw($query));
}

function funderInfo($funderId){
	    $query = "select * from funder where id = '".$funderId."' ";
	    return DB::select(DB::raw($query));
}

    public function updateFunder($updates, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('funder', $updates);
        return true;
    }

    public function deleteSegment($id){
	    "delete from project_segment where id = '".$id."' ";
	    return true;
    }

    public function deleteCategory($id){
	    "delete from expense_category where id = '".$id."' ";
	    return true;
    }

    public function deleteException($id){
	    "delete from exception_type where id = '".$id."' ";
	    return true;
    }

    public function projectManager(){
	    $query = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and r.permissions like '%8%'";
	    return DB::select(DB::raw($query));
    }

}
