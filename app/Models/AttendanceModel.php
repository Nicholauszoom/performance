<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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

    function myLeaves($empId)
    {
        $query = "SELECT l.*, la.level1, la.level2, la.level3
              FROM leaves AS l
              JOIN leave_approvals AS la ON l.empID = la.empID
              WHERE :empId IN (la.level1, la.level2, la.level3)
              ORDER BY l.id DESC";

        $bindings = ['empId' => $empId];
        $results = DB::select(DB::raw($query), $bindings);
        return $results;
    }




    function leave_line($empID)
    {
        $query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND e.line_manager = '" . $empID . "' AND NOT e.emp_id =  '" . $empID . "'  ";

        return DB::select(DB::raw($query));
    }

    function all_leave_line()
    {
        $query = "SELECT *  FROM leaves ORDER BY id DESC";

        return DB::select(DB::raw($query));
    }

    function other_leaves($empID)
    {
        $query = "SELECT @s:=@s+1 SNo,  lt.type as TYPE,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, l.* FROM leave_application l, employee e,  leave_type lt,  (SELECT @s:=0) as s WHERE l.empID = e.emp_id AND  l.nature=lt.id AND NOT e.emp_id =  '" . $empID . "'  ";

        return DB::select(DB::raw($query));
    }


    function get_pertenity_leave_balance($empID, $nature, $year, $todayDate)
    {
        //month from hire date
        $leave_balance = 0;
        $query = "SELECT YEAR('" . $todayDate . "')*12 + MONTH('" . $todayDate . "') - (YEAR(e.hire_date)*12 + MONTH(e.hire_date)) as 'month_difference' from employee e where e.emp_id = '" . $empID . "'  ";
        $result = DB::select(DB::raw($query));
        $months_from_hiredate = !empty($result) ? $result[0]->month_difference : 0;

        $query = "SELECT YEAR('" . $todayDate . "')*12 + MONTH('" . $todayDate . "') - (YEAR(l.end)*12 + MONTH(l.end)) as 'month_difference' from leaves l where l.empID = '" . $empID . "'  and l.nature = '" . $nature . "' ORDER BY l.end DESC LIMIT 1";
        $result = DB::select(DB::raw($query));

        $month_from_last_pertenity_leave = !empty($result) ? $result[0]->month_difference : 0;
        dd($month_from_last_pertenity_leave);

        if ($months_from_hiredate < 4) {
            $leave_balance = 7;
        } elseif ($months_from_hiredate >= 4 || $month_from_last_pertenity_leave >= 4) {
        }
        dd($result[0]->month_difference);
        $row = DB::table('leaves')
            ->where('application_date', 'like', $year . '%')
            ->where('nature', $nature)->where('empID', $empID)->sum('days');


        return (126 - $row);
    }
    function get_sick_leave_balance($empID, $nature, $year)
    {
        //like
        // $condition  =  '%".$permissionID."%'";
        $row = DB::table('leaves')
            ->where('application_date', 'like', $year . '%')
            ->where('nature', $nature)->where('empID', $empID)->sum('days');


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
        $leave = DB::table('leave_application')->where('id', $leaveID)->first();
        $leave_days = $this->getNumberOfWorkingDays($leave->start, $leave->end);
        DB::transaction(function () use ($leaveID, $signatory, $todate, $leave_days) {

            $query = "INSERT INTO leaves(empID, start, end, days, leave_address, mobile, nature, state, application_date, approved_by, recommended_by)
		SELECT la.empID, la.start, la.end,  '" . $leave_days . "' AS days, la.leave_address, la.mobile, la.nature, 1, la.application_date, '" . $signatory . "', la.approved_by_line  FROM leave_application la WHERE la.id = '" . $leaveID . "'  ";
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


    function getNumberOfWorkingDays($startDate, $endDate, $holidays = null)
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

        return $workingDays - $number_of_hodays;
    }




    function getLeaveBalance1($empID, $hireDate, $today)
    {

        // dd("here");


        $holidays = [];


        // dd($this->getNumberOfWorkingDays('2020/01/5','2020/01/10',[]));


        //	$query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '" . $empID . "' GROUP BY nature)) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";


        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '" . $empID . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";


        // IF()
        $row = DB::select(DB::raw($query));

        //$date = DB::table('employee')->where('emp_id', $empID)->select('hire_date')->first();
        $d1 = new DateTime($hireDate);

        //$todayDate = date('Y-m-d');

        $todayDate = $today;
        $d2 = new DateTime($todayDate);
        $diff = $d1->diff($d2);


        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;
        if ($days > 1) {

            $months = $months + 1;
        }


        $employee = DB::table('employee')->where('emp_id', $empID)->first();


        $days_this_month = intval(date('t', strtotime(date('Y-m-d'))));
        $accrual_days = $days * $employee->accrual_rate / $days_this_month + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

        $interval = $d1->diff($d2);
        $diffInMonths  = $diff->m;

        $spent = $row[0]->days_spent;
        $accrued = $row[0]->days_accrued;


        // dd($accrual_days);

        $accrual = 7 * $accrued / 90;
        $maximum_days = $accrual_days - $spent;
        return $maximum_days;
    }


    function days_entilted($nature)
    {

        $query = "SELECT max_days FROM leave_type WHERE id = '" . $nature . "' limit 1";

        $row = DB::select(DB::raw($query));

        return $row[0]->max_days;
    }

    function leave_name($nature)
    {
        $query = "SELECT type FROM leave_type WHERE id = '" . $nature . "' limit 1";

        $row = DB::select(DB::raw($query));

        return $row[0]->type;
    }

    function getLeaveTypes(){
        $query = "SELECT id FROM leave_type" ;

        $rows = DB::select(DB::raw($query));

        $ids = [];

        foreach ($rows as $row) {
            $ids[] = (string) $row->id; // Cast to string
        }

        return $ids;
    }


    function getLeaveBalance($empID, $hireDate, $today)
    {

        $nature = 1;

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        $query = "SELECT
                IF(
                    (SELECT COUNT(id) FROM leaves WHERE nature = '" . $nature . "' AND empID = '" . $empID . "') = 0,
                    0,
                    (SELECT SUM(days) FROM leaves WHERE nature = '" . $nature . "' AND state = 0 AND empID = '" . $empID . "' AND start <= '" . $today . "' AND leave_address != 'auto' AND start BETWEEN '" . $hireDate . "' AND '" . $today . "' GROUP BY nature)
                ) as days_spent,
                DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued";


        $row = DB::select(DB::raw($query));

        $employee = DB::table('employee')->where('emp_id', $empID)->first();

        $remain = DB::table('leaves')->where('empID', $empID)   ->latest('created_at')->first();

        $d1 = new DateTime($hireDate);

        $d2 = new DateTime($today);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));

        $remaining_after_forfeitDays = LeaveForfeiting::where('empID', $empID)->value('days') ?? 0;
        $broughtFowardDays = LeaveForfeiting::where('empID', $empID)->value('opening_balance') ?? 0;


        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

        $interval = $d1->diff($d2);

        $diffInMonths  = $interval->m;

        $spent = $row[0]->days_spent;

        $accrual = 0;

        if ($nature == 1) {
            $maximum_days =  ($broughtFowardDays - floatval($remaining_after_forfeitDays)) + $accrual_days - $spent;
        } else {
            $days_entitled  = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }

        return $maximum_days;
    }


    function getAnnualOutstandingBalance($empID, $hireDate, $today)
    {

        $nature = 1;

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        $query = "SELECT
                IF(
                    (SELECT COUNT(id) FROM leaves WHERE nature = '" . $nature . "' AND empID = '" . $empID . "') = 0,
                    0,
                    (SELECT SUM(days) FROM leaves WHERE nature = '" . $nature . "' AND state = 0 AND empID = '" . $empID . "' AND start <= '" . $today . "' AND leave_address != 'auto' AND start BETWEEN '" . $hireDate . "' AND '" . $today . "' GROUP BY nature)
                ) as days_spent,
                DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued";


        $row = DB::select(DB::raw($query));

        $employee = DB::table('employee')->where('emp_id', $empID)->first();

        $remain = DB::table('leaves')->where('empID', $empID)   ->latest('created_at')->first();

        $d1 = new DateTime($hireDate);

        $d2 = new DateTime($today);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));

        $forfeitDays = LeaveForfeiting::where('empID', $empID)->value('days') ?? 0;
        $broughtFowardDays = LeaveForfeiting::where('empID', $empID)->value('opening_balance') ?? 0;

        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;

        $interval = $d1->diff($d2);

        $diffInMonths  = $interval->m;

        $spent = $row[0]->days_spent;


        $accrual = 0;

        $maximum_days = $broughtFowardDays + $accrual_days - $spent + floatval($forfeitDays);
        return $maximum_days;
    }




    function getLeaveBalance_report($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        //dd($today);

        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

        $row = DB::select(DB::raw($query));
        $employee = DB::table('employee')->where('emp_id', $empID)->first();
        //$date = $employee->hire_date;
        $d1 = new DateTime($hireDate);
        // $todayDate = date('Y-m-d');
        $d2 = new DateTime($today);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));
        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
        $interval = $d1->diff($d2);
        $diffInMonths  = $interval->m;
        //    dd($diffInMonths);
        $spent = $row[0]->days_spent;
        // $accrued = $row[0]->days_accrued;

        // $accrual= 7*$accrued/90;
        $accrual = 0;
        if ($nature == 1) {
            $maximum_days = $accrual_days - $spent;
        } else {
            $days_entitled  = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }


        //dd($days);



        return $maximum_days;
    }


    function getLeaveBalance2($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        //$prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        //$last_month_date = date('Y-m-t', strtotime($prev_month));

        $calender = explode('-', $today);


        $last_month_date = $calender[0] . '-01-01';

        //dd($today);

        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

        $row = DB::select(DB::raw($query));
        $employee = DB::table('employee')->where('emp_id', $empID)->first();
        //$date = $employee->hire_date;
        $d1 = new DateTime($hireDate);
        // $todayDate = date('Y-m-d');
        $d2 = new DateTime($today);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));
        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
        $interval = $d1->diff($d2);
        $diffInMonths  = $interval->m;
        //    dd($diffInMonths);
        $spent = $row[0]->days_spent;
        // $accrued = $row[0]->days_accrued;

        // $accrual= 7*$accrued/90;
        $accrual = 0;
        if ($nature == 1) {
            $maximum_days = $accrual_days - $spent;
        } else {
            $days_entitled  = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }


        //dd($days);



        return $maximum_days;
    }
    function getLeaveBalance3($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        //$prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        //$last_month_date = date('Y-m-t', strtotime($prev_month));

        $calender = explode('-', $today);


        $last_month_date = $calender[0] . '-01-01';

        //dd($today);

        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

        $row = DB::select(DB::raw($query));
        $employee = DB::table('employee')->where('emp_id', $empID)->first();
        //$date = $employee->hire_date;
        $d1 = new DateTime($hireDate);
        // $d1 = new DateTime($hireDate);
        $year = $d1->format('Y');

// $year now contains the four-digit year from the DateTime object


        // $todayDate = date('Y-m-d');
        $d2 = new DateTime($last_month_date);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));
        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
        // dd($accrual_days);
        $interval = $d1->diff($d2);
        $diffInMonths  = $interval->m;
        //    dd($diffInMonths);
        $spent = $row[0]->days_spent;
        // $accrued = $row[0]->days_accrued;

        // $accrual= 7*$accrued/90;
        $accrual = 0;
        if ($nature == 1) {
            $maximum_days = $accrual_days - $spent;
        } else {
            $days_entitled  = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }


        //dd($days);



        return $maximum_days;
    }

    function get_anualLeave($empID, $nature = null)
    {

        $leaves = DB::table('leaves')->where('empID', $empID)->where('nature', $nature)->sum('days');

        return $leaves;
    }


    function getLeaveTaken($empID, $hireDate, $today, $nature)
    {

        // $last_month_date = date('Y-m-t', strtotime($prev_month));

        $holidays = [];

        $leaves = DB::table('leaves')->where('empID', $empID)->where('nature', $nature)->get();

        $first_this_month = date('Y-m-01', strtotime($today));

        $end_this_month  = date('Y-m-t', strtotime($today));




        $total_leave = 0;
        foreach ($leaves as $leave) {

            $leave_start = $leave->start;
            $leave_end = $leave->end;

            if ($leave->start <= $end_this_month && $leave->end >= $first_this_month) { //if leave doesn't end this month


                if ($leave->start <= $first_this_month) {  //If leave doesn't start this month
                    $leave_start = $first_this_month;
                }

                if ($leave->end >= $end_this_month) {   //if leave doesn't end this month

                    $leave_end = $end_this_month;
                }






                $total_leave = $total_leave + $this->getNumberOfWorkingDays($leave_start, $leave_end, $holidays);
            }
        }

        return $total_leave;
    }

    function getLeaveTaken2($empID, $hireDate, $today, $nature)
    {

        // $last_month_date = date('Y-m-t', strtotime($prev_month));

        $holidays = [];

        $leaves = DB::table('leaves')->where('empID', $empID)->where('nature', $nature)->get();

        $calender = explode('-', $today);


        $this_month = $calender[0] . '-01-01';

        $first_this_month = date('Y-m-01', strtotime($this_month));

        $end_this_month  = date('Y-m-t', strtotime($today));




        $total_leave = 0;
        foreach ($leaves as $leave) {

            $leave_start = $leave->start;
            $leave_end = $leave->end;

            if ($leave->start <= $end_this_month && $leave->end >= $first_this_month) { //if leave doesn't end this month


                if ($leave->start <= $first_this_month) {  //If leave doesn't start this month
                    $leave_start = $first_this_month;
                }

                if ($leave->end >= $end_this_month) {   //if leave doesn't end this month

                    $leave_end = $end_this_month;
                }






                $total_leave = $total_leave + $this->getNumberOfWorkingDays($leave_start, $leave_end, $holidays);
            }
        }

        return $total_leave;
    }

    public function get_anual_leave_position($month)
    {

        $first_date = date('Y-m-01', strtotime($month));
        $last_date = date('Y-m-t', strtotime($month));

        // $opening_balance = $this->getOpeningLeaveBalance($month);
        //$row = DB::table('employee')

        $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1";

        //return DB::select(DB::raw($query));
        dd(DB::select(DB::raw($query)));
    }

    function getClossingLeaveBalance($empID, $hireDate, $today)
    {


        // dd($today);

        //$prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($today));

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
        $accrual_days =  $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
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

    function save_deligated($id)
    {
        $query = "insert into level1 (deligetor,line_employee) SELECT la.level1 as deligetor,la.empID as line_employee from
            leave_approvals la where la.level1 = '" . $id . "'";
        DB::insert(DB::raw($query));

        $query = "insert into level2 (deligetor,line_employee) SELECT la.level2 as deligetor,la.empID as line_employee from
        leave_approvals la where la.level2 = '" . $id . "' ";
        DB::insert(DB::raw($query));

        $query = "insert into level3 (deligetor,line_employee) SELECT la.level3 as deligetor,la.empID as line_employee from
    leave_approvals la where la.level3 = '" . $id . "' ";
        DB::insert(DB::raw($query));

        return true;
    }

    public function days_spent($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        //dd($today);

        //opening balance
        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start >= '" . $last_month_date . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";
        $row = DB::select(DB::raw($query));


        $days_spent = $row[0]->days_spent;

        //dd($nature,$last_month_date,$today);

        return $days_spent;
    }


    public function days_spent2($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $calender = explode('-', $today);


        $this_month = ($calender[0] - 1) . '-12-31';

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        $last_month_date = $this_month;

        //opening balance
        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start >= '" . $last_month_date . "' and start <= '" . $today . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";
        $row = DB::select(DB::raw($query));


        $days_spent = $row[0]->days_spent;

        //dd($nature,$last_month_date,$today);

        return $days_spent;
    }
    public function days_spent3($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));

        $hireYear = date('Y', strtotime($hireDate));
        $currentYear = date('Y', strtotime($today));
        // if ($hireYear !== $currentYear) {


            $leaves = Leaves::where('empID', $empID)
                ->where('state', 0) // Include state = 0
                ->whereNot('leave_address','auto')
                ->whereRaw('YEAR(start) = ? AND YEAR(end) = ?', [$currentYear, $currentYear])
                ->get();


                $totalDays = 0;

    foreach ($leaves as $leave) {
        $startDate = date_create($leave->start);
        $endDate = date_create($leave->end);

        if ($endDate < date_create($today)) {
            // If the leave has ended, use the difference between start and end date
            $difference = date_diff($startDate, $endDate);
            $totalDays += $difference->days;
        } else {
            // If the leave has not ended, calculate the difference between start date and today
            $difference = date_diff($startDate, date_create($today));
            $totalDays += $difference->days;
        }
    }
    return $totalDays;
    // }

    //     } else {


    //         echo "Hire date and current date are in the same year.";
    //     }


}


    function getOpeningLeaveBalance($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        $last_month_date = date('Y-m-t', strtotime($prev_month));

        //dd($today);

        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start <= '" . $last_month_date . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

        $row = DB::select(DB::raw($query));
        $employee = DB::table('employee')->where('emp_id', $empID)->first();
        //$date = $employee->hire_date;
        $d1 = new DateTime($hireDate);
        // $todayDate = date('Y-m-d');
        $d2 = new DateTime($last_month_date);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));
        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
        $interval = $d1->diff($d2);
        $diffInMonths  = $interval->m;
        //    dd($diffInMonths);
        $spent = $row[0]->days_spent;
        // $accrued = $row[0]->days_accrued;

        // $accrual= 7*$accrued/90;
        $accrual = 0;

        if ($nature == 1) {
            $maximum_days = $accrual_days - $spent;
        } else {
            $days_entitled = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }



        //dd($days);



        return $maximum_days;
    }

    function getOpeningLeaveBalance2($empID, $hireDate, $today, $nature)
    {

        $today = date("Y-m-d", strtotime($today));


        //$prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));

        // $last_month_date = date('Y-m-t', strtotime($prev_month));

        $calender = explode('-', $today);


        $last_month_date = ($calender[0] - 1) . '-12-31';

        //dd($today);

        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature= '" . $nature . "' AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature= '" . $nature . "' and empID = '" . $empID . "' and start <= '" . $last_month_date . "'  GROUP BY nature )) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";

        $row = DB::select(DB::raw($query));
        $employee = DB::table('employee')->where('emp_id', $empID)->first();
        //$date = $employee->hire_date;
        $d1 = new DateTime($hireDate);
        // $todayDate = date('Y-m-d');
        $d2 = new DateTime($last_month_date);

        $diff = $d1->diff($d2);

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        $days_this_month = intval(date('t', strtotime($last_month_date)));
        $accrual_days = (($days * $employee->accrual_rate) / 30) + $months * $employee->accrual_rate + $years * 12 * $employee->accrual_rate;
        //$days * $employee->accrual_rate / $days_this_month +
        $interval = $d1->diff($d2);
        $diffInMonths  = $interval->m;
        //    dd($diffInMonths);
        $spent = $row[0]->days_spent;
        // $accrued = $row[0]->days_accrued;

        // $accrual= 7*$accrued/90;
        $accrual = 0;

        if ($nature == 1) {
            $maximum_days = $accrual_days - $spent;
        } else {
            $days_entitled = $this->days_entilted($nature);

            $maximum_days = $days_entitled - $spent;
        }



        //dd($days);



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

    function get_dept_name($id)
    {
        $query = "SELECT name from department where id = '" . $id . "' limit 1";
        $row = DB::select(DB::raw($query));


        return $row[0]->name;
    }

    function get_position_name($id)
    {
        $query = "SELECT name from position where id = '" . $id . "' limit 1";
        $row = DB::select(DB::raw($query));

        return $row[0]->name;
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

    function getMonthlyLeave()
    {
        $monthlyleave = DB::table('leaves')
            ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
            ->select('*')
            // ->whereMonth('application_date', '<=', $month)
            // ->whereYear('application_date','<=', $year)
            ->get();
        // ->where('employee.emp_id',$name)
        // ->where('job_posts.id',$job_id)
        return $monthlyleave;
    }

    function getApprovedMonthlyLeave($empID, $today, $nature, $department, $position)
    {

        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));
        $last_month_date = date('Y-m-t', strtotime($prev_month));
        $givenDate = Carbon::parse($today);
        $firstDayOfMonth = $givenDate->firstOfMonth()->toDateString();
        $lastDayOfMonth = $givenDate->endOfMonth()->toDateString();
        if ($empID == 'All') {
            if ($department != 'All' && $position != 'All') {
                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->select('*')
                    ->where('start', '<=', $today)
                    ->where('employee.position', $position)
                    ->where('employee.state', 1)
                    ->where('leaves.status',3)
                    ->where('employee.department', $department)
                    ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('start', '>=', $firstDayOfMonth)
                                ->where('start', '>=', $lastDayOfMonth);
                        })
                        ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('end', '>=', $firstDayOfMonth)
                                ->where('end', '<=', $lastDayOfMonth);
                        });
                    })
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department != 'All' && $position == 'All') {

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->where('leaves.status',3)
                    ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->where('employee.state', 1)
                    ->where('employee.department', $department)
                    ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('start', '>=', $firstDayOfMonth)
                                ->where('start', '>=', $lastDayOfMonth);
                        })
                        ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('end', '>=', $firstDayOfMonth)
                                ->where('end', '<=', $lastDayOfMonth);
                        });
                    })
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department == 'All') {
                $employees = Employee::where('state', '=', 1)->get();

                // $monthlyleave = DB::table('leaves')
                //     ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                //     ->join('department', 'department.id', '=', 'employee.department')
                //     ->join('position', 'position.id', '=', 'employee.position')
                //     ->where('leaves.status',3)
                //     ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->where('employee.state', 1)
                //     ->where('start', '>=', $firstDayOfMonth)
                //     ->where('start', '<=', $lastDayOfMonth)
                //     ->where('end', '>=', $firstDayOfMonth)
                //     ->where('end', '<=', $lastDayOfMonth)
                //     ->where('nature', $nature)
                //     ->toSql();
                $monthlyleave = DB::table('leaves')
                ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as position_name')
                ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                ->join('department', 'department.id', '=', 'employee.department')
                ->join('position', 'position.id', '=', 'employee.position')
                ->where('leaves.status', 3)
                ->where('employee.state', 1)
                ->where('nature', $nature)
                ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                    $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('start', '>=', $firstDayOfMonth)
                            ->where('start', '>=', $lastDayOfMonth);
                    })
                    ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('end', '>=', $firstDayOfMonth)
                            ->where('end', '<=', $lastDayOfMonth);
                    });
                })
                ->get();
            }
        } else {

            $monthlyleave = DB::table('leaves')
                ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                ->join('department', 'department.id', '=', 'employee.department')
                ->join('position', 'position.id', '=', 'employee.position')
                ->where('leaves.status',3)
                ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->where('start', '>=', $last_month_date)
                ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                    $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('start', '>=', $firstDayOfMonth)
                            ->where('start', '>=', $lastDayOfMonth);
                    })
                    ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('end', '>=', $firstDayOfMonth)
                            ->where('end', '<=', $lastDayOfMonth);
                    });
                })
                ->where('nature', $nature)
                ->where('employee.emp_id', $empID)
                ->get();
        }




        return $monthlyleave;
    }


    function getMonthlyLeave2($empID, $today, $nature, $department, $position)
    {

        $calender = explode('-',$today);
        $january = $calender[0].'-01-01';

        $last_month_date = date('Y-m-t', strtotime($january));


        if ($empID == 'All') {
            if ($department != 'All' && $position != 'All') {
                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->where('leaves.status',3)
                    ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->select('*')
                    ->where('employee.position', $position)
                    ->where('employee.state', 1)
                    ->where('employee.department', $department)
                    ->where('start', '>=', $january)
                    ->where('start', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department != 'All' && $position == 'All') {

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->where('leaves.status',3)
                    ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->where('employee.state', 1)
                    ->where('employee.department', $department)
                    ->where('start', '>=', $january)
                    ->where('start', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department == 'All') {
                $employees = Employee::where('state', '=', 1)->get();

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->where('leaves.status',3)
                    ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')->where('employee.state', 1)
                    ->where('start', '>=', $january)
                    ->where('start', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            }
        } else {

            $monthlyleave = DB::table('leaves')
                ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                ->join('department', 'department.id', '=', 'employee.department')
                ->join('position', 'position.id', '=', 'employee.position')
                ->where('leaves.status',3)
                ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                ->where('nature', $nature)
                ->where('employee.emp_id', $empID)
                ->where('start', '<=', $today)
                ->where('start', '>=', $january)
                ->get();
        }

        return $monthlyleave;
    }



function getMonthlyLeave22($empID, $today, $nature2, $department, $position)
{
    $calender = explode('-', $today);
    $january = $calender[0] . '-01-01';
    $lastMonthDate = date('Y-m-t', strtotime($january));

    $query = DB::table('leaves')
        ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
        ->join('department', 'department.id', '=', 'employee.department')
        ->join('position', 'position.id', '=', 'employee.position')
        ->where('leaves.status', 3)
        ->select(
            'leaves.*',
            'employee.*',
            'department.name as department_name',
            'position.name as position_name'
        )
        ->where('start', '>=', $january)
        ->where('start', '<=', $today)
        ->where('nature', $nature2);

    if ($empID != 'All') {
        $query->where('employee.emp_id', $empID);
    }

    if ($department != 'All') {
        $query->where('employee.department', $department);
    }

    if ($position != 'All') {
        $query->where('employee.position', $position);
    }

    $monthlyleave = $query->where('employee.state', 1)->get();

    return $monthlyleave;
}


    function getpendingLeaves1($empID, $today, $nature, $department, $position)
    {

        $calender = explode('-',$today);
        $january = $calender[0].'-01-01';

        if ($empID == 'All') {
            if ($department != 'All' && $position != 'All') {
                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                    ->where('employee.position', $position)
                    ->where('employee.state', 1)
                    ->where('leaves.status','!=',3)
                    ->where('employee.department', $department)
                    ->where('start', '>=', $january)
                    ->where('end', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department != 'All' && $position == 'All') {

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                    ->where('employee.department', $department)
                    ->where('start', '>=', $january)
                    ->where('leaves.status','!=',3)
                    ->where('start', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department == 'All') {
                $employees = Employee::where('state', '=', 1)->get();

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                    ->where('start', '>=', $january)
                    ->where('leaves.status','!=',3)
                    ->where('start', '<=', $today)
                    ->where('nature', $nature)
                    ->get();
            }
        } else {

            $monthlyleave = DB::table('leaves')
                ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                ->join('department', 'department.id', '=', 'employee.department')
                ->join('position', 'position.id', '=', 'employee.position')
                ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                ->where('start', '>=', $january)
                ->where('nature', $nature)
                ->where('leaves.status','!=',3)
                ->where('employee.emp_id', $empID)
                ->where('start', '<=', $today)
                ->where('start', '>=', $january)
                ->get();
        }




        return $monthlyleave;
    }


    function getMonthlyPendingLeaves($empID, $today, $nature, $department, $position)
    {

        $prev_month = date("Y-m-d", strtotime('-1 month', strtotime($today)));
        $last_month_date = date('Y-m-t', strtotime($prev_month));
        // dd($last_month_date);
        $givenDate = Carbon::parse($today);
        $firstDayOfMonth = $givenDate->firstOfMonth()->toDateString();
        $lastDayOfMonth = $givenDate->endOfMonth()->toDateString();
        if ($empID == 'All') {
            if ($department != 'All' && $position != 'All') {
                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')                    ->where('start', '<=', $today)
                    ->where('employee.position', $position)
                    ->where('employee.state', 1)
                    ->where('employee.department', $department)
                    ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('start', '>=', $firstDayOfMonth)
                                ->where('start', '>=', $lastDayOfMonth);
                        })
                        ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('end', '>=', $firstDayOfMonth)
                                ->where('end', '<=', $lastDayOfMonth);
                        });
                    })
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department != 'All' && $position == 'All') {

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')                    ->where('employee.department', $department)
                    ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('start', '>=', $firstDayOfMonth)
                                ->where('start', '>=', $lastDayOfMonth);
                        })
                        ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('end', '>=', $firstDayOfMonth)
                                ->where('end', '<=', $lastDayOfMonth);
                        });
                    })
                    ->where('nature', $nature)
                    ->get();
            } elseif ($department == 'All') {
                $employees = Employee::where('state', '=', 1)->get();

                $monthlyleave = DB::table('leaves')
                    ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                    ->join('department', 'department.id', '=', 'employee.department')
                    ->join('position', 'position.id', '=', 'employee.position')
                    ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                    ->select('leaves.*','leave_approvals.level1', 'employee.*', 'department.name as department_name', 'position.name as  position_name')                    ->where('start', '>=', $last_month_date)
                    ->where('nature', $nature)
                    ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('start', '>=', $firstDayOfMonth)
                                ->where('start', '>=', $lastDayOfMonth);
                        })
                        ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                            $query->where('end', '>=', $firstDayOfMonth)
                                ->where('end', '<=', $lastDayOfMonth);
                        });
                    })
                    ->get();
            }
        } else {

            $monthlyleave = DB::table('leaves')
                ->join('employee', 'leaves.empID', '=', 'employee.emp_id')
                ->join('department', 'department.id', '=', 'employee.department')
                ->join('leave_approvals', 'leave_approvals.empID', '=', 'leaves.empID')
                ->join('position', 'position.id', '=', 'employee.position')
                ->select('leaves.*', 'employee.*', 'department.name as department_name', 'position.name as  position_name')
                ->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                    $query->where(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('start', '>=', $firstDayOfMonth)
                            ->where('start', '>=', $lastDayOfMonth);
                    })
                    ->orWhere(function ($query) use ($firstDayOfMonth, $lastDayOfMonth) {
                        $query->where('end', '>=', $firstDayOfMonth)
                            ->where('end', '<=', $lastDayOfMonth);
                    });
                })
                ->where('nature', $nature)
                ->where('employee.emp_id', $empID)
                ->get();
        }




        // dd($monthlyleave);
        return $monthlyleave;
    }


    function getAllNatureValues($nature){
        if($nature == 'All'){
            return DB::table('leave_type')->select(['id', 'type'])->get(); // Assuming 'name' is the field that stores the nature value
        }else{
            return [$nature]; // Return the provided nature value as an array
        }
    }

    function getAllNatureValues2($nature){
        if($nature == 'All'){
            return DB::table('leave_type')->select(['id'])->get(); // Assuming 'name' is the field that stores the nature value
        }else{
            return [$nature]; // Return the provided nature value as an array
        }
    }

}
