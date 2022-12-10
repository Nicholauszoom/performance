<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{

	function attendance($data)
	{
		DB::table("attendance")->insert($data);
		
	}

	function checkAttendanceState($empID, $date)
	{
		$query ="SELECT id, state FROM attendance WHERE CAST(due_in as date) = '".$date."' and empID = '".$empID."' ";
	    return DB::select(DB::raw($query));
	} 
	
	function attend_out($empID, $date, $due_out) {
	$query ="UPDATE attendance SET state = 2, due_out = '".$due_out."' where empID = '".$empID."' and CAST(due_in as date) = '".$date."'";
	DB::insert(DB::raw($query));
	return true;
    }

	function attendees($date)
	{
		$query ="SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(att.due_in as date) as DATE_IN,   CAST(att.due_in as time) as time_in, IF( CAST(att.due_out as time)= CAST(att.due_in as time), 'NOT SIGNED OUT', CAST(att.due_out as time) ) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '".$date."' and d.id = '".session('departmentID')."'";

		return DB::select(DB::raw($query));
	}

	function applyleave($data)
	{
		
		DB::table("leave_application")->insert($data);

		// DB::insert(DB::raw($query))
		return true;
		
	}
	function leave_type()
	{
		$query ="SELECT * FROM leave_type";
		
		return DB::select(DB::raw($query));
	}
	function leaverecommend($id)
	{
		$query =" SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  and e.line_manager = '".$id."'" ;
		
		return DB::select(DB::raw($query));
	}


	function leaverecommendandconfirm($id)
	{
		$query =" SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id and not l.status = '2' and not l.status = '0' and not e.emp_id = '".$id."'" ;
		
		return DB::select(DB::raw($query));
	}


	function leaveconfirm($id)
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id and not l.status = '2' and not l.status = '0' and not e.emp_id = '".$id."' ";
		
		return DB::select(DB::raw($query));
	}


	function myleave($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as type, l.* FROM leave_application l, leave_type lt,  (SELECT @s:=0) as s WHERE l.nature=lt.id and l.empID='".$empID."' ORDER BY l.id DESC";
		
		return DB::select(DB::raw($query));
	}
	
	function leave_line($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND e.line_manager = '".$empID."' AND NOT e.emp_id =  '".$empID."'  ";
		
		return DB::select(DB::raw($query));
	}

	function other_leaves($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND NOT e.emp_id =  '".$empID."'  ";
		
		return DB::select(DB::raw($query));
	}

	
	function leave_hr()
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND l.status IN(1,2,5) ";
		
		return DB::select(DB::raw($query));
	}
	
	function leave_line_hr($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '".$empID."' OR l.status IN(1,2,5))  ORDER BY l.id DESC ";
		
		return DB::select(DB::raw($query));
	}

	function update_leave($data, $id)
	{

		DB::table('leave_application')->where('id',$id)->update($data);
		return true;
	}

	function deleteLeave( $id)
	{
		$this->db->where('id', $id);
		
		$this->db->delete('leave_application');
		return true;
	}
	
		
    function approve_leave($leaveID, $signatory, $todate)
	{
	    DB::transaction(function() use($leaveID, $signatory, $todate)
       {

		$query ="INSERT INTO leaves(empID, start, end, days, leave_address, mobile, nature, state, application_date, approved_by, recommended_b)";
		DB::insert(DB::raw($query));

		$query =  "SELECT la.empID, la.start, la.end,  DATEDIFF(la.end, la.start) AS days, la.leave_address, la.mobile, la.nature, 1, la.application_date, '".$signatory."', la.approved_by_line  FROM leave_application la WHERE la.id = '".$leaveID."'";

		DB::insert(DB::raw($query));


	    $query = "UPDATE leave_application SET status = 2, approved_by_hr = '".$signatory."', approved_date_hr = '".$todate."'  WHERE id ='".$leaveID."'";

		DB::insert(DB::raw($query));
		
	    });
		DB::insert(DB::raw($query));
		return true;
	}



	function insertleaves($data)
	{
		DB::table("leaves")->insert($data);
		
	}


	function get_leave_application($leaveID)
	{
		$query="SELECT  lt.type as leave_type, l.* FROM leave_application l, leave_type lt WHERE l.nature=lt.id and l.id=".$leaveID."";
		
		return DB::select(DB::raw($query));
	}

	function update_leave_application($data, $id)
	{

		
		DB::table('leave_application')->where('id', $id)->update($data);
		return true;
	}

	function getLeaveBalance($empID, $hireDate, $today)
	{
		$query="SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '".$empID."')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '".$empID."' GROUP BY nature)) as days_spent, DATEDIFF('".$today."','".$hireDate."') as days_accrued limit 1";
		$row = DB::select(DB::raw($query));
		$spent = $row[0]->days_spent;	
		$accrued = $row[0]->days_accrued;

		$accrual= 7*$accrued/90;
		$maximum_days = $accrual - $spent;
		return $maximum_days;
	}
	function myleave_current($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as type, l.* FROM leave_application l, leave_type lt,  (SELECT @s:=0) as s WHERE l.nature=lt.id and l.empID='".$empID."' AND l.notification IN(1, 3) ORDER BY l.id DESC";
		
		return DB::select(DB::raw($query));
	}

	
	function leave_line_hr_current($empID)
	{
		// $query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '".$empID."' OR l.status IN(1,2,5)) AND l.notification IN(2,3,4)  ORDER BY l.id DESC ";
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '".$empID."' OR l.notification IN(2,3,4))  ORDER BY l.id DESC ";
		
		return DB::select(DB::raw($query));
	}


	
	function leave_line_current($empID)
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND e.line_manager =  '".$empID."' AND l.notification = 2 ORDER BY l.id DESC ";
		
		return DB::select(DB::raw($query));
	}

	
	function leave_hr_current()
	{
		$query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND l.status IN(1,2,5) AND l.notification IN(3, 4)  ORDER BY l.id DESC  ";
		
		return DB::select(DB::raw($query));
	}

	function update_leave_notification_staff($empID)
	{
		DB::transaction(function()
       {
		$query ="UPDATE leave_application SET notification = 0 WHERE empID = '".$empID."' AND notification =1";
		$query ="UPDATE leave_application SET notification = 4 WHERE empID = '".$empID."' AND notification = 3";
		DB::insert(DB::raw($query));
	});
		return true;
	}

	function update_leave_notification_line_hr($empID)
	{
		DB::transaction(function()
       {
		$query ="UPDATE leave_application SET notification = 0 WHERE notification =4";
		$query ="UPDATE leave_application SET notification = 1 WHERE  notification =3";
		$query ="UPDATE leave_application SET notification = 0 WHERE  notification = 2 AND empID IN(SELECT emp_id FROM employee WHERE line_manager ='".$empID."') ";
		DB::insert(DB::raw($query));
	});
		return true;
	}

	function update_leave_notification_line($empID)
	{
		$query ="UPDATE leave_application SET notification = 0 WHERE  notification = 2 AND empID IN(SELECT emp_id FROM employee WHERE line_manager ='".$empID."') ";

		DB::insert(DB::raw($query));
		return true;
	}


	function update_leave_notification_hr()
	{
		DB::transaction(function()
       {
		$query ="UPDATE leave_application SET notification = 0 WHERE notification = 4";
		DB::insert(DB::raw($query));
		$query ="UPDATE leave_application SET notification = 1 WHERE  notification =3";
		DB::insert(DB::raw($query));
	});
		return true;
	}
	
	function leave_line_manager_current($empID)
	{
		$query =" SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  AND l.status = 0 AND l.notification = 2 AND e.line_manager = '".$empID."'" ;
		
		return DB::select(DB::raw($query));
	}
	
	
	function leave_line_manager_hr_current($empID)
	{
		$query="SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id AND l.notification = 3 AND l.status =1 UNION 
		SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id AND l.status = 0 AND l.notification = 2 AND e.line_manager = '".$empID."'";
		
		return DB::select(DB::raw($query));
	}
	// LEAVE REPORTS
	function leave_employees() {
	    $query ="SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name FROM employee e  ";
        return DB::select(DB::raw($query));
    }

	function my_leavereport($empID)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id  AND ls.empID = '".$empID."' AND ls.nature = lt.id ORDER BY ls.state DESC";
				
		return DB::select(DB::raw($query));
	}

	function leavereport_line($empID)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND e.emp_id IN(SELECT emp_id FROM employee WHERE line_manager = '".$empID."') ORDER BY ls.state DESC";
				
		return DB::select(DB::raw($query));
	}


	function leavereport_hr()
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id AND ls.nature = lt.id ORDER BY ls.state DESC";
				
		return DB::select(DB::raw($query));
	}

	function leavereport1($dates, $datee)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' ";
				
		return DB::select(DB::raw($query));
	}

	function leavereport1_all($dates, $datee)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' ";
				
		return DB::select(DB::raw($query));
	}

	function leavereport1_completed($dates, $datee, $today)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end < '".$today."' AND ls.start BETWEEN '".$dates."' AND '".$datee."' ";
				
		return DB::select(DB::raw($query));
	}

	function leavereport1_progress($dates, $datee, $today)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end > '".$today."' AND ls.start between '".$dates."' and '".$datee."' ";
				
		return DB::select(DB::raw($query));
	}

	function leavereport2($id)
	{
		$query ="SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.empID = '".$id."'   ";
				
		return DB::select(DB::raw($query));
	}


	function leave_notification_employee($empID)
	{
		$query ="SELECT l.id FROM leave_application l WHERE l.empID = '".$empID."' AND l.notification = 1";
		return $query->num_rows();
	}
	
	function leave_notification_line_manager($empID)
	{
		$query ="SELECT l.id FROM leave_application l, employee e WHERE l.empID = e.emp_id AND  e.line_manager = '".$empID."' AND l.notification = 2";
		return $query->num_rows();
	}
	
	function leave_notification_hr()
	{
		$query ="SELECT l.id FROM leave_application l  WHERE l.notification =3 ";
		return $query->num_rows();
	}	



}