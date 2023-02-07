<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use DateTime;

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
		$query = "SELECT id, state FROM attendance WHERE CAST(due_in as date) = '" . $date . "' and empID = '" . $empID . "' ";
		return DB::select(DB::raw($query));
	}

	function attend_out($empID, $date, $due_out)
	{
		$query = "UPDATE attendance SET state = 2, due_out = '" . $due_out . "' where empID = '" . $empID . "' and CAST(due_in as date) = '" . $date . "'";
		DB::insert(DB::raw($query));
		return true;
	}

	function attendees($date)
	{
		$query = "SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(att.due_in as date) as DATE_IN,   CAST(att.due_in as time) as time_in, IF( CAST(att.due_out as time)= CAST(att.due_in as time), 'NOT SIGNED OUT', CAST(att.due_out as time) ) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '" . $date . "' and d.id = '" . session('departmentID') . "'";

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
		$query = "SELECT * FROM leave_type";

		return DB::select(DB::raw($query));
	}
	function leaverecommend($id)
	{
		$query = " SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  and e.line_manager = '" . $id . "'";

		return DB::select(DB::raw($query));
	}


	function leaverecommendandconfirm($id)
	{
		$query = " SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  and e.line_manager = '" . $id . "' UNION SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id and not l.status = '2' and not l.status = '0' and not e.emp_id = '" . $id . "'";

		return DB::select(DB::raw($query));
	}


	function leaveconfirm($id)
	{
		$query = "SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id and not l.status = '2' and not l.status = '0' and not e.emp_id = '" . $id . "' ";

		return DB::select(DB::raw($query));
	}


	function myleave($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as type, l.* FROM leave_application l, leave_type lt,  (SELECT @s:=0) as s WHERE l.nature=lt.id and l.empID='" . $empID . "' ORDER BY l.id DESC";

		return DB::select(DB::raw($query));
	}

	function leave_line($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND e.line_manager = '" . $empID . "' AND NOT e.emp_id =  '" . $empID . "'  ";

		return DB::select(DB::raw($query));
	}

	function other_leaves($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND NOT e.emp_id =  '" . $empID . "'  ";

		return DB::select(DB::raw($query));
	}


    function get_pertenity_leave_balance($empID,$nature,$year,$todayDate){
        //month from hire date
        $leave_balance = 0;
        $query = "SELECT YEAR('".$todayDate."')*12 + MONTH('".$todayDate."') - (YEAR(e.hire_date)*12 + MONTH(e.hire_date)) as 'month_difference' from employee e where e.emp_id = '".$empID."'  ";
        $result = DB::select(DB::raw($query));
        $months_from_hiredate = !empty($result)?$result[0]->month_difference:0;

        $query = "SELECT YEAR('".$todayDate."')*12 + MONTH('".$todayDate."') - (YEAR(l.end)*12 + MONTH(l.end)) as 'month_difference' from leaves l where l.empID = '".$empID ."'  and l.nature = '".$nature."' ORDER BY l.end DESC LIMIT 1";
        $result = DB::select(DB::raw($query));

        $month_from_last_pertenity_leave = !empty($result)?$result[0]->month_difference:0;
        dd($month_from_last_pertenity_leave);

        if($months_from_hiredate < 4){
            $leave_balance = 7;
        }elseif($months_from_hiredate >= 4 || $month_from_last_pertenity_leave >= 4){

        }
        dd($result[0]->month_difference);
       $row = DB::table('leaves')
        ->where('application_date','like',$year.'%')
       ->where('nature',$nature)->where('empID',$empID)->sum('days');


       return (126 - $row);
    }
    function get_sick_leave_balance($empID,$nature,$year){
        //like
       // $condition  =  '%".$permissionID."%'";
       $row = DB::table('leaves')
        ->where('application_date','like',$year.'%')
       ->where('nature',$nature)->where('empID',$empID)->sum('days');


       return (126 - $row);
    }


	function leave_hr()
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND l.status IN(1,2,5) ";

		return DB::select(DB::raw($query));
	}

	function leave_line_hr($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '" . $empID . "' OR l.status IN(1,2,5))  ORDER BY l.id DESC ";

		return DB::select(DB::raw($query));
	}

	function update_leave($data, $id)
	{

		DB::table('leave_application')->where('id', $id)->update($data);
		return true;
	}

	function deleteLeave($id)
	{
		DB::table('leave_application')->where('id', $id)->delete();
		return true;
	}


	function approve_leave($leaveID, $signatory, $todate)
	{
        $leave = DB::table('leave_application')->where('id',$leaveID)->first();
        $leave_days = $this->getNumberOfWorkingDays($leave->start,$leave->end);
		DB::transaction(function () use ($leaveID, $signatory, $todate,$leave_days) {

			$query = "INSERT INTO leaves(empID, start, end, days, leave_address, mobile, nature, state, application_date, approved_by, recommended_by)
		SELECT la.empID, la.start, la.end,  '".$leave_days."' AS days, la.leave_address, la.mobile, la.nature, 1, la.application_date, '" . $signatory . "', la.approved_by_line  FROM leave_application la WHERE la.id = '" . $leaveID . "'  ";
			DB::insert(DB::raw($query));
			$query = "UPDATE leave_application SET status = 2, approved_by_hr = '" . $signatory . "', approved_date_hr = '" . $todate . "'  WHERE id ='" . $leaveID . "'";
			DB::insert(DB::raw($query));
		});

		return true;
	}



	function insertleaves($data)
	{
		DB::table("leaves")->insert($data);
	}


	function get_leave_application($leaveID)
	{
		$query = "SELECT  lt.type as leave_type, l.* FROM leave_application l, leave_type lt WHERE l.nature=lt.id and l.id=" . $leaveID . "";

		return DB::select(DB::raw($query));
	}

	function update_leave_application($data, $id)
	{


		DB::table('leave_application')->where('id', $id)->update($data);
		return true;
	}


	function getNumberOfHolidays($start, $end)
	{

		return 0;
	}


	function getNumberOfWorkingDays($startDate, $endDate, $holidays=null)
	{
        $number_of_hodays = DB::table('holidays')->whereBetween('date', array($startDate, $endDate))->count();
		// do strtotime calculations just once
		$endDate = strtotime($endDate);
		$startDate = strtotime($startDate);


		//The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
		//We add one to inlude both dates in the interval.
		$days = ($endDate - $startDate) / 86400 + 1;

		$no_full_weeks = floor($days / 7);
		$no_remaining_days = fmod($days, 7);

		//It will return 1 if it's Monday,.. ,7 for Sunday
		$the_first_day_of_week = date("N", $startDate);
		$the_last_day_of_week = date("N", $endDate);

		//---->The two can be equal in leap years when february has 29 days, the equal sign is added here
		//In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
		if ($the_first_day_of_week <= $the_last_day_of_week) {
			if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
			if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
		} else {
			// (edit by Tokes to fix an edge case where the start day was a Sunday
			// and the end day was NOT a Saturday)

			// the day of the week for start is later than the day of the week for end
			if ($the_first_day_of_week == 7) {
				// if the start date is a Sunday, then we definitely subtract 1 day
				$no_remaining_days--;

				if ($the_last_day_of_week == 6) {
					// if the end date is a Saturday, then we subtract another day
					$no_remaining_days--;
				}
			} else {
				// the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
				// so we skip an entire weekend and subtract 2 days
				$no_remaining_days -= 2;
			}
		}

		//The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
		//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
		$workingDays = $no_full_weeks * 5;
		if ($no_remaining_days > 0) {
			$workingDays += $no_remaining_days;
		}

		//We subtract the holidays
		// foreach ($holidays as $holiday) {
		// 	$time_stamp = strtotime($holiday);
		// 	//If the holiday doesn't fall in weekend
		// 	if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N", $time_stamp) != 6 && date("N", $time_stamp) != 7)
		// 		$workingDays--;
		// }

		return $workingDays -$number_of_hodays;
	}



	function getLeaveBalance($empID, $hireDate, $today)
	{

		// dd("here");

		$holidays = [];


		// dd($this->getNumberOfWorkingDays('2020/01/5','2020/01/10',[]));


		$query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '" . $empID . "' GROUP BY nature)) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";



		// IF()
		$row = DB::select(DB::raw($query));

		$date = DB::table('employee')->where('emp_id', $empID)->select('hire_date')->first();
		$d1 = new DateTime($hireDate);
		$todayDate = date('Y-m-d');
		$d2 = new DateTime($todayDate);
		$diff = $d1->diff($d2);

		$years = $diff->y;
		$months = $diff->m;
		$days = $diff->d;

		$employee = DB::table('employee')->where('emp_id', $empID)->first();


		$days_this_month = intval(date('t', strtotime(date('Y-m-d'))));
		$accrual_days = $days * $employee->accrual_rate / $days_this_month + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

		$interval = $d1->diff($d2);
		$diffInMonths  = $diff->m;

		$spent = $row[0]->days_spent;
		$accrued = $row[0]->days_accrued;




		$accrual = 7 * $accrued / 90;
		$maximum_days = $accrual_days - $spent;
		return $maximum_days;
	}


	function getLeaveTaken($empID, $hireDate, $today)
	{

		// $last_month_date = date('Y-m-t', strtotime($prev_month));

		$holidays = [];

		$leaves = DB::table('leaves')->where('empID', $empID)->where('nature', 1)->get();

		$first_this_month = date('Y-m-01', strtotime($today));

		$end_this_month  = date('Y-m-t', strtotime($today));




		$total_leave = 0;
		foreach ($leaves as $leave) {

			$leave_start = $leave->start;
			$leave_end = $leave->end;

			if ($leave->start <= $end_this_month && $leave->end >= $first_this_month) {//if leave doesn't end this month


				if ($leave->start <= $first_this_month) {  //If leave doesn't start this month
					$leave_start = $first_this_month;
				}

				if ($leave->end >= $end_this_month) {   //if leave doesn't end this month

					$leave_end = $end_this_month;
				}





				dd($leave_start, $leave_end);
				$total_leave = $total_leave + $this->getNumberOfWorkingDays($leave_start, $leave_end, $holidays);
			}
		}

		return $total_leave;
	}



	function getOpeningLeaveBalance($empID, $hireDate, $today)
	{


		// dd($today);

		$prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

		$last_month_date = date('Y-m-t', strtotime($prev_month));

		// dd($last_month_date);

		$query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '" . $empID . "' and start <= '" . $last_month_date . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

		$row = DB::select(DB::raw($query));
		$employee = DB::table('employee')->where('emp_id', $empID)->first();
		$date = $employee->hire_date;
		$d1 = new DateTime($hireDate);
		// $todayDate = date('Y-m-d');
		$d2 = new DateTime($last_month_date);

		$diff = $d1->diff($d2);

		$years = $diff->y;
		$months = $diff->m;
		$days = $diff->d;

		$days_this_month = intval(date('t', strtotime($last_month_date)));
		$accrual_days = $days * $employee->accrual_rate / $days_this_month + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

		$interval = $d1->diff($d2);
		$diffInMonths  = $interval->m;
		//    dd($diffInMonths);
		$spent = $row[0]->days_spent;
		// $accrued = $row[0]->days_accrued;

		// $accrual= 7*$accrued/90;
		$accrual = 0;

		$maximum_days = $accrual_days - $spent;

		// dd($maximum_days);


		return $maximum_days;
	}

	function myleave_current($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as type, l.* FROM leave_application l, leave_type lt,  (SELECT @s:=0) as s WHERE l.nature=lt.id and l.empID='" . $empID . "' AND l.notification IN(1, 3) ORDER BY l.id DESC";

		return DB::select(DB::raw($query));
	}


	function leave_line_hr_current($empID)
	{
		// $query="SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '".$empID."' OR l.status IN(1,2,5)) AND l.notification IN(2,3,4)  ORDER BY l.id DESC ";
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND (e.line_manager =  '" . $empID . "' OR l.notification IN(2,3,4))  ORDER BY l.id DESC ";

		return DB::select(DB::raw($query));
	}



	function leave_line_current($empID)
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND e.line_manager =  '" . $empID . "' AND l.notification = 2 ORDER BY l.id DESC ";

		return DB::select(DB::raw($query));
	}


	function leave_hr_current()
	{
		$query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND l.status IN(1,2,5) AND l.notification IN(3, 4)  ORDER BY l.id DESC  ";

		return DB::select(DB::raw($query));
	}

	function update_leave_notification_staff($empID)
	{
		DB::transaction(function () {
			$query = "UPDATE leave_application SET notification = 0 WHERE empID = '" . $empID . "' AND notification =1";
			$query = "UPDATE leave_application SET notification = 4 WHERE empID = '" . $empID . "' AND notification = 3";
			DB::insert(DB::raw($query));
		});
		return true;
	}

	function update_leave_notification_line_hr($empID)
	{
		DB::transaction(function () {
			$query = "UPDATE leave_application SET notification = 0 WHERE notification =4";
			$query = "UPDATE leave_application SET notification = 1 WHERE  notification =3";
			$query = "UPDATE leave_application SET notification = 0 WHERE  notification = 2 AND empID IN(SELECT emp_id FROM employee WHERE line_manager ='" . $empID . "') ";
			DB::insert(DB::raw($query));
		});
		return true;
	}

	function update_leave_notification_line($empID)
	{
		$query = "UPDATE leave_application SET notification = 0 WHERE  notification = 2 AND empID IN(SELECT emp_id FROM employee WHERE line_manager ='" . $empID . "') ";

		DB::insert(DB::raw($query));
		return true;
	}


	function update_leave_notification_hr()
	{
		DB::transaction(function () {
			$query = "UPDATE leave_application SET notification = 0 WHERE notification = 4";
			DB::insert(DB::raw($query));
			$query = "UPDATE leave_application SET notification = 1 WHERE  notification =3";
			DB::insert(DB::raw($query));
		});
		return true;
	}

	function leave_line_manager_current($empID)
	{
		$query = " SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id  AND l.status = 0 AND l.notification = 2 AND e.line_manager = '" . $empID . "'";

		return DB::select(DB::raw($query));
	}


	function leave_line_manager_hr_current($empID)
	{
		$query = "SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l, leave_type lt,position p, department d, employee e, (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id AND l.notification = 3 AND l.status =1 UNION
		SELECT @s:=@s+1 SNo, lt.type as TYPE, p.name as POSITION, d.name as DEPARTMENT,  l.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM leave_application l,position p, leave_type lt, department d, employee e,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id and l.nature=lt.id  and e.position = p.id and e.department=d.id AND l.status = 0 AND l.notification = 2 AND e.line_manager = '" . $empID . "'";

		return DB::select(DB::raw($query));
	}
	// LEAVE REPORTS
	function leave_employees()
	{
		$query = "SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name FROM employee e  ";
		return DB::select(DB::raw($query));
	}

	function my_leavereport($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id  AND ls.empID = '" . $empID . "' AND ls.nature = lt.id ORDER BY ls.state DESC";

		return DB::select(DB::raw($query));
	}

	function leavereport_line($empID)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND e.emp_id IN(SELECT emp_id FROM employee WHERE line_manager = '" . $empID . "') ORDER BY ls.state DESC";

		return DB::select(DB::raw($query));
	}


	function leavereport_hr()
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id AND ls.nature = lt.id ORDER BY ls.state DESC";

		return DB::select(DB::raw($query));
	}

	function leavereport1($dates, $datee)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '" . $dates . "' and '" . $datee . "' ";

		return DB::select(DB::raw($query));
	}

	function leavereport1_all($dates, $datee)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '" . $dates . "' and '" . $datee . "' ";

		return DB::select(DB::raw($query));
	}

	function leavereport1_completed($dates, $datee, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end < '" . $today . "' AND ls.start BETWEEN '" . $dates . "' AND '" . $datee . "' ";

		return DB::select(DB::raw($query));
	}

	function leavereport1_progress($dates, $datee, $today)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end > '" . $today . "' AND ls.start between '" . $dates . "' and '" . $datee . "' ";

		return DB::select(DB::raw($query));
	}

	function leavereport2($id)
	{
		$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.empID = '" . $id . "'   ";

		return DB::select(DB::raw($query));
	}


	function leave_notification_employee($empID)
	{
		$query = "SELECT l.id FROM leave_application l WHERE l.empID = '" . $empID . "' AND l.notification = 1";
		return $query->num_rows();
	}

	function leave_notification_line_manager($empID)
	{
		$query = "SELECT l.id FROM leave_application l, employee e WHERE l.empID = e.emp_id AND  e.line_manager = '" . $empID . "' AND l.notification = 2";
		return $query->num_rows();
	}

	function leave_notification_hr()
	{
		$query = "SELECT l.id FROM leave_application l  WHERE l.notification =3 ";
		return $query->num_rows();
	}

	function getMonthlyLeave(){
		$monthlyleave = DB::table('leaves')
			      ->select 
	}
}
