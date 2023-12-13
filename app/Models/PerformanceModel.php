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
    $query = "SELECT count(t.id) FROM task t WHERE t.assigned_to = '".$id."'";
    return DB::select(DB::raw($query));
}

function total_task_completed($id)
{
    $query = "SELECT count(t.id) FROM task t WHERE t.status = 2 AND t.assigned_to = '".$id."'";
    return DB::select(DB::raw($query));
}

function total_task_duration($id)
{
    $query = "SELECT min(t.start) as minDATE, max(t.end) as maxDATE FROM task t WHERE t.status = 2 AND t.assigned_to = '".$id."'";
    return DB::select(DB::raw($query));
}

function total_task_actual_duration($id)
{
    $result = DB::table('task as t')
        ->select(DB::raw('
            CASE WHEN SUM(EXTRACT(EPOCH FROM AGE(t.end, t.start)) / 60)::numeric > 0
                 THEN SUM(EXTRACT(EPOCH FROM AGE(t.end, t.start)) / 60)::numeric
                 ELSE 0
            END as allDURATION'))
        ->where('t.status', '=', 2)
        ->where('t.assigned_to', '=', $id)
        ->get();

    return $result[0]->allDURATION ?? 0;
}

function allTaskcompleted($id)
{
    $query = "SELECT t.id FROM task t WHERE t.status = 2 AND t.assigned_to = '".$id."'";
    return DB::select(DB::raw($query));
}

function all_task_monetary_value($id)
{
    $query = "SELECT CASE WHEN count(t.id) > 0
                           THEN sum(t.\"monetaryValue\")
                           ELSE 0
                      END as ComperableValue
              FROM task t
              WHERE t.status = 2 AND t.assigned_to = '" . $id . "'";

    return DB::select(DB::raw($query));
}


function total_task_progress($id)
{
    $query = "SELECT count(t.id) FROM task t WHERE t.status = 0 AND t.assigned_to = '".$id."'";
    return DB::select(DB::raw($query));
}

function task_count_per_dept($id)
{
    $query = "SELECT COUNT(t.id) as tCOUNTS FROM task t, employee e, department d WHERE e.department = d.id AND e.emp_id = t.assigned_to AND e.department = '".$id."'";
    return DB::select(DB::raw($query));
}

function departmentChooser()
{
    $query = "SELECT id as deptID, name FROM department WHERE state = 1 AND type = 1";
    return DB::select(DB::raw($query));
}



function employee_productivity($start, $end) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,
            e.emp_id AS empID,
            CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
            d.name AS department,
            p.name AS position,
            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT SUM(EXTRACT(EPOCH FROM (t.date_completed - t.start)))/60
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS duration_time,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT SUM(t.monetaryValue)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS monetary_value,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT COUNT(t.id)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS number_of_tasks,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT ROUND(AVG(t.quantity + t.quality), 2)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS scores,

            SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) AS employment_cost,
            date_part('day', '".$end."'::timestamp - '".$start."'::timestamp) AS payroll_days

            FROM employee e, department d, position p, payroll_logs pl

            WHERE e.emp_id = pl.empID AND e.position = p.id AND e.department=d.id
                AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'

            GROUP BY e.emp_id, d.name, p.name

            ORDER BY SNo ASC";

    return DB::select(DB::raw($query));
}


function employee_productivity_sort($start, $end, $department) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,
            e.emp_id AS empID,
            CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
            d.name AS department,
            p.name AS position,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT SUM(EXTRACT(EPOCH FROM (t.date_completed - t.start)))/60
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS duration_time,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT SUM(t.monetaryValue)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS monetary_value,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT COUNT(t.id)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS number_of_tasks,

            CASE WHEN
                (SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                THEN
                    (SELECT ROUND(AVG(t.quantity + t.quality), 2)
                        FROM task t
                        WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                            AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                ELSE 0
            END AS scores,

            SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) AS employment_cost,
            date_part('day', '".$end."'::timestamp - '".$start."'::timestamp) AS payroll_days

            FROM employee e, department d, position p, payroll_logs pl

            WHERE e.emp_id = pl.empID AND e.position = p.id AND e.department = d.id
                AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'
                AND e.department = ".$department."

            GROUP BY e.emp_id, d.name, p.name

            ORDER BY SNo ASC";

    return DB::select(DB::raw($query));
}
function department_productivity($start, $end) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,
            department,
            SUM(duration_time) AS duration,
            SUM(monetary_value) AS time_cost,
            SUM(number_of_tasks) AS task_counts,
            SUM(employment_cost) AS employment_cost,
            SUM(payroll_days) AS payroll_days,
            COUNT(empID) AS headcounts,
            SUM(scores) AS score

            FROM
            (
                SELECT e.department AS deptID,
                        e.emp_id AS empID,
                        d.name AS department,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(EXTRACT(EPOCH FROM (t.date_completed - t.start)))/60
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS duration_time,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(t.monetaryValue)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS monetary_value,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT COUNT(t.id)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS number_of_tasks,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT ROUND(AVG(t.quantity + t.quality), 2)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS scores,

                        SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) AS employment_cost,
                        date_part('day', '".$end."'::timestamp - '".$start."'::timestamp) AS payroll_days

                FROM employee e, department d, payroll_logs pl
                WHERE e.emp_id = pl.empID AND e.department = d.id
                    AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'
                GROUP BY e.emp_id, d.name
            ) AS childQuery,
            (SELECT @s:=0) AS s

            GROUP BY deptID
            ORDER BY SNo ASC";

    return DB::select(DB::raw($query));
}



function department_productivity_sort($start, $end, $department) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,
            department,
            SUM(duration_time) AS duration,
            SUM(monetary_value) AS time_cost,
            SUM(number_of_tasks) AS task_counts,
            SUM(employment_cost) AS employment_cost,
            SUM(payroll_days) AS payroll_days,
            COUNT(empID) AS headcounts,
            SUM(scores) AS score

            FROM
            (
                SELECT e.department AS deptID,
                        e.emp_id AS empID,
                        d.name AS department,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(EXTRACT(EPOCH FROM (t.date_completed - t.start)))/60
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS duration_time,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(t.monetaryValue)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS monetary_value,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT COUNT(t.id)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS number_of_tasks,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT ROUND(AVG(t.quantity + t.quality), 2)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS scores,

                        SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) AS employment_cost,
                        date_part('day', '".$end."'::timestamp - '".$start."'::timestamp) AS payroll_days

                FROM employee e, department d, payroll_logs pl
                WHERE e.emp_id = pl.empID AND e.department = d.id
                    AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'
                    AND e.department = ".$department."
                GROUP BY e.emp_id, d.name
            ) AS childQuery,
            (SELECT @s:=0) AS s

            GROUP BY deptID
            ORDER BY SNo ASC";

    return DB::select(DB::raw($query));
}

function organization_productivity($start, $end) {
    $query = "SELECT SUM(duration_time) AS duration,
            SUM(monetary_value) AS time_cost,
            SUM(number_of_tasks) AS task_counts,
            SUM(employment_cost) AS employment_cost,
            SUM(payroll_days) AS payroll_days,
            COUNT(empID) AS headcounts,
            SUM(scores) AS score

            FROM
            (
                SELECT e.department AS deptID,
                        e.organization AS empOrg,
                        e.emp_id AS empID,
                        d.name AS department,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(EXTRACT(EPOCH FROM (t.date_completed - t.start)))/60
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS duration_time,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT SUM(t.monetaryValue)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS monetary_value,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT COUNT(t.id)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS number_of_tasks,

                        CASE WHEN
                            (SELECT COUNT(ts.id)
                                FROM task ts
                                WHERE ts.progress = 100 AND ts.assigned_to = e.emp_id AND ts.status = 2 AND ts.isAssigned = 1
                                    AND ts.date_completed BETWEEN '".$start."' AND '".$end."' ) > 0
                            THEN
                                (SELECT ROUND(AVG(t.quantity + t.quality), 2)
                                    FROM task t
                                    WHERE t.progress = 100 AND t.assigned_to = e.emp_id AND t.status = 2 AND t.isAssigned = 1
                                        AND t.date_completed BETWEEN '".$start."' AND '".$end."')
                            ELSE 0
                        END AS scores,

                        SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) AS employment_cost,
                        date_part('day', '".$end."'::timestamp - '".$start."'::timestamp) AS payroll_days

                FROM employee e, department d, payroll_logs pl
                WHERE e.emp_id = pl.empID AND e.department = d.id
                    AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'
                GROUP BY e.emp_id, e.organization, d.name
            ) AS childQuery

            GROUP BY empOrg";

    return DB::select(DB::raw($query));
}


// hereeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee


public function organization_productivity_sort($start, $end, $department) {
    $query = "SELECT
        SUM(duration_time) AS duration,
        SUM(monetary_value) AS time_cost,
        SUM(number_of_tasks) AS task_counts,
        SUM(employment_cost) AS employment_cost,
        SUM(payroll_days) as payroll_days,
        COUNT(empID) AS headcounts,
        SUM(scores) AS score
    FROM (
        SELECT
            e.department as deptID,
            e.organization AS empOrg,
            e.emp_id as empID,
            d.name as department,
            CASE
                WHEN (
                    SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100
                        AND ts.assigned_to = e.emp_id
                        AND ts.status = 2
                        AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."'
                ) > 0 THEN (
                    SELECT SUM(datediff(t.date_completed, t.start))
                    FROM task t
                    WHERE t.progress = 100
                        AND t.assigned_to = e.emp_id
                        AND t.status = 2
                        AND t.isAssigned = 1
                        AND t.date_completed BETWEEN '".$start."' AND '".$end."'
                )
                ELSE 0
            END AS duration_time,

            CASE
                WHEN (
                    SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100
                        AND ts.assigned_to = e.emp_id
                        AND ts.status = 2
                        AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."'
                ) > 0 THEN (
                    SELECT SUM(t.monetaryValue)
                    FROM task t
                    WHERE t.progress = 100
                        AND t.assigned_to = e.emp_id
                        AND t.status = 2
                        AND t.isAssigned = 1
                        AND t.date_completed BETWEEN '".$start."' AND '".$end."'
                )
                ELSE 0
            END AS monetary_value,

            CASE
                WHEN (
                    SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100
                        AND ts.assigned_to = e.emp_id
                        AND ts.status = 2
                        AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."'
                ) > 0 THEN (
                    SELECT COUNT(t.id)
                    FROM task t
                    WHERE t.progress = 100
                        AND t.assigned_to = e.emp_id
                        AND t.status = 2
                        AND t.isAssigned = 1
                        AND t.date_completed BETWEEN '".$start."' AND '".$end."'
                )
                ELSE 0
            END AS number_of_tasks,

            CASE
                WHEN (
                    SELECT COUNT(ts.id)
                    FROM task ts
                    WHERE ts.progress = 100
                        AND ts.assigned_to = e.emp_id
                        AND ts.status = 2
                        AND ts.isAssigned = 1
                        AND ts.date_completed BETWEEN '".$start."' AND '".$end."'
                ) > 0 THEN (
                    SELECT ROUND(AVG(t.quantity + t.quality), 2)
                    FROM task t
                    WHERE t.progress = 100
                        AND t.assigned_to = e.emp_id
                        AND t.status = 2
                        AND t.isAssigned = 1
                        AND t.date_completed BETWEEN '".$start."' AND '".$end."'
                )
                ELSE 0
            END AS scores,

            SUM(pl.salary + pl.allowances + pl.pension_employer + pl.wcf + pl.sdl) as employment_cost,
            datediff('".$end."','".$start."') as payroll_days
        FROM
            employee e,
            department d,
            payroll_logs pl
        WHERE
            e.emp_id = pl.empID
            AND e.department = d.id
            AND pl.payroll_date BETWEEN '".$start."' AND '".$end."'
        GROUP BY e.emp_id
    ) AS childQuery
    WHERE deptID = ".$department."
    GROUP BY empOrg ";

    return DB::select(DB::raw($query));
}

public function category_rating($avgScore) {
    $query = "SELECT * FROM task_ratings WHERE lower_limit <= ".$avgScore." AND upper_limit > ".$avgScore."";
    return DB::select(DB::raw($query));
}

public function selectTalent($data)
{
    DB::table("talent")->insert($data);
    return true;
}

function selectedTalents($empID)
{
    $query = "SELECT COUNT(id) as counts FROM talent WHERE empID = '".$empID."'";
    $row = DB::select(DB::raw($query));
    return $row[0]->counts;
}

function total_taskline($id) {
    $query = "SELECT (SELECT count(t.id) FROM task t WHERE t.assigned_by ='".$id."') as ALL_TASKS,
              (SELECT count(t.id) FROM task t WHERE t.assigned_by ='".$id."' AND t.status = 2) as COMPLETED ";
    return DB::select(DB::raw($query));
}

function total_taskstaff($id) {
    $query = "SELECT (SELECT count(t.id) FROM task t WHERE t.assigned_to ='".$id."') as ALL_TASKSTAFF,
              (SELECT count(t.id) FROM task t WHERE t.assigned_to ='".$id."' AND t.status = 2) as COMPLETEDSTAFF ";
    return DB::select(DB::raw($query));
}

function task_info($id) {
    $query = "SELECT t.*, outp.id as outpID, outp.title as outpTitle, outp.start as outpStart, outp.end as outpEnd,
              CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName, CONCAT(el.fname,' ', el.mname,' ', el.lname) as lineName
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              JOIN employee el ON el.emp_id = t.assigned_by
              JOIN output outp ON t.output_ref = outp.id
              WHERE t.id = ".$id."";
    return DB::select(DB::raw($query));
}

function adhoc_task_info($id) {
    $query = "SELECT t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as empName, CONCAT(el.fname,' ', el.mname,' ', el.lname) as lineName
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              JOIN employee el ON el.emp_id = t.assigned_by
              WHERE t.id = ".$id."";
    return DB::select(DB::raw($query));
}


    function alltask($strategyID) {
        $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,
                  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
                  FROM task t
                  JOIN employee e ON ex.emp_id = t.assigned_by
                  JOIN employee ex ON e.emp_id = t.assigned_to
                  WHERE t.strategy_ref = '".$strategyID."'
                  ORDER BY t.id DESC";
        return DB::select(DB::raw($query));
    }

    function mytask($strategyID, $empID) {
        $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,
                  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
                  FROM task t
                  JOIN employee e ON ex.emp_id = t.assigned_by
                  JOIN employee ex ON e.emp_id = t.assigned_to
                  WHERE t.strategy_ref = '".$strategyID."' AND t.assigned_to = '".$empID."'
                  ORDER BY t.id DESC";
        return DB::select(DB::raw($query));
    }

    function othertask($strategyID, $empID) {
        $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,
                  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
                  FROM task t
                  JOIN employee e ON ex.emp_id = t.assigned_by
                  JOIN employee ex ON e.emp_id = t.assigned_to
                  WHERE t.strategy_ref = '".$strategyID."' AND t.assigned_by = '".$empID."'
                  ORDER BY t.id DESC";
        return DB::select(DB::raw($query));
    }

    function pauseTask($taskID, $todate)
    {
        $this->db->trans_start();
        $query = "INSERT INTO paused_task (id, description, title, initial_quantity, submitted_quantity, start, end,
                  assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity,
                  quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification,
                  date_completed, date_marked, date_paused)
                  SELECT  id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by,
                  date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality,
                  excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked,
                  '".$todate."'  FROM task WHERE id ='".$taskID."'";
        $query = "DELETE FROM task WHERE  id ='".$taskID."'";
        $this->db->trans_complete();

        return true;
    }

    function resumeTask($taskID)
    {
        $this->db->trans_start();
        $query = "INSERT INTO task (id, description, title, initial_quantity, submitted_quantity, start, end,
                  assigned_to, assigned_by, date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity,
                  quantity_type, quality, excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification,
                  date_completed, date_marked)
                  SELECT  id, description, title, initial_quantity, submitted_quantity, start, end, assigned_to, assigned_by,
                  date_assigned, progress, outcome_ref, strategy_ref, output_ref, status, quantity, quantity_type, quality,
                  excess_points, qb_ratio, monetaryValue, remarks, isAssigned, notification, date_completed, date_marked
                  FROM paused_task WHERE id ='".$taskID."'";
        $query = "DELETE FROM paused_task WHERE  id ='".$taskID."'";
        $this->db->trans_complete();

        return true;
    }

    function my_paused_task($strategyID, $empID) {
        $query = "SELECT ROW_NUMBER() OVER () AS SNo, pt.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,
                  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
                  FROM paused_task pt
                  JOIN employee e ON ex.emp_id = pt.assigned_by
                  JOIN employee ex ON e.emp_id = pt.assigned_to
                  WHERE pt.strategy_ref IN(0,'".$strategyID."') AND pt.assigned_to = '".$empID."'
                  ORDER BY pt.id DESC";
        return DB::select(DB::raw($query));
    }


function other_paused_task($strategyID, $empID) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, pt.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
              FROM paused_task pt
              JOIN employee e ON ex.emp_id = pt.assigned_by
              JOIN employee ex ON e.emp_id = pt.assigned_to
              WHERE pt.strategy_ref IN(0,'".$strategyID."') AND pt.assigned_by = '".$empID."'
              ORDER BY pt.id DESC";
    return DB::select(DB::raw($query));
}

function my_adhoc_task($empID) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              JOIN employee ex ON ex.emp_id = t.assigned_by
              WHERE t.output_ref = 0 AND t.assigned_to = '".$empID."'
              ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function other_adhoc_task($empID) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME,  CONCAT(ex.fname,' ', ex.mname,' ', ex.lname) as executive
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              JOIN employee ex ON ex.emp_id = t.assigned_by
              WHERE t.output_ref = 0 AND t.assigned_by = '".$empID."'
              ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function task_resources($id) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, tr.*
              FROM task_resources tr
              WHERE tr.taskID = ".$id."";
    return DB::select(DB::raw($query));
}

function resource_cost($id) {
    $query = "SELECT SUM(cost) as cost FROM task_resources  WHERE taskID = ".$id."";
    $row = DB::select(DB::raw($query));
    return $row[0]->cost;
}

function myoutput($id)
{
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, o.*,CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM output o
              JOIN employee e ON e.emp_id = o.assigned_to
              ORDER BY o.id DESC";
    return DB::select(DB::raw($query));
}

function tasklinemanager($id) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_by
              WHERE t.assigned_by ='".$id."'
              ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function tasklinemanager_and_staff($id) {
    $query = "SELECT *
              FROM
              (SELECT ROW_NUMBER() OVER () AS SNo, t.*, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
               FROM task t
               JOIN employee e ON e.emp_id = t.assigned_to
               WHERE t.assigned_by ='".$id."'
               ORDER BY t.id DESC, SNo ASC)
               AS a
               UNION ALL
               SELECT *
               FROM
               (SELECT ROW_NUMBER() OVER () AS SNo,  t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
                FROM task t
                JOIN employee e ON e.emp_id = t.assigned_to
                WHERE t.assigned_to ='".$id."'
                ORDER BY t.id DESC, SNo ASC)
                AS b
               ORDER BY SNo ASC";
    return DB::select(DB::raw($query));
}


function taskstaff($id) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, t.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_by
              WHERE t.assigned_to ='".$id."'
              ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function customtask() {
    $query = "SELECT DISTINCT t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              WHERE t.status=2";
    return DB::select(DB::raw($query));
}

function customtask_line($id) {
    $query = "SELECT DISTINCT  t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              WHERE t.status=2 AND e.line_manager =  '".$id."'
              UNION
              SELECT DISTINCT t.assigned_to as IDs,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
              FROM task t
              JOIN employee e ON e.emp_id = t.assigned_to
              WHERE t.status=2 AND e.emp_id = '".$id."'";
    return DB::select(DB::raw($query));
}

function update_notification_task_staff($empID)
{
    $query = "UPDATE task SET notification = 0 WHERE assigned_to = '".$empID."' AND notification = 1";
    DB::update(DB::raw($query));
    return true;
}

function update_notification_task_line_manager($empID)
{
    $query = "UPDATE task SET notification = 0 WHERE assigned_to = '".$empID."' AND notification = 1;
              UPDATE task SET notification = 0 WHERE  assigned_by = '".$empID."' AND  notification = 2";
    DB::unprepared($query);
    return true;
}




function task_staff_current($empID) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  CONCAT(em.fname,' ', em.mname,' ', em.lname) as NAME, t.*  FROM task t, employee e, employee em WHERE e.emp_id = t.assigned_by AND t.assigned_to = em.emp_id AND  t.assigned_to ='".$empID."' AND t.notification = 1 ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function task_line_manager_current($empID) {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,  CONCAT(em.fname,' ', em.mname,' ', em.lname) as NAME, t.*  FROM task t, employee e, employee em WHERE e.emp_id = t.assigned_by AND t.assigned_to = em.emp_id AND  t.assigned_by ='".$empID."' AND t.notification = 2 ORDER BY t.id DESC";
    return DB::select(DB::raw($query));
}

function tasksettings() {
    $query = "SELECT * FROM task_settings where id = 1";
    return DB::select(DB::raw($query));
}

function tasksettings_behaviour() {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,  b.* FROM behaviour b";
    return DB::select(DB::raw($query));
}

function tasksettings_ratings() {
    $query = "SELECT ROW_NUMBER() OVER () AS SNo,  tr.* FROM task_ratings tr";
    return DB::select(DB::raw($query));
}


function tasksettings_delay_percent() {
    $query = "SELECT value FROM task_settings WHERE id = 2";
    $row = DB::select(DB::raw($query));
    return $row[0]->value;
}

function behaviour_ids() {
    $query = "SELECT id FROM behaviour";
    return DB::select(DB::raw($query));
}

function add_task_parameter($data)
{
    DB::table('behaviour')->insert($data);
    return true;
}

function update_task_settings($data, $id)
{
    DB::table('task_settings')->where('id', $id)->update($data);
    return true;
}

function update_taskResource($data, $id)
{
    DB::table('task_resources')->where('id', $id)->update($data);
    return true;
}

function update_task_behaviour($data, $id)
{
    DB::table('behaviour')->where('id', $id)->update($data);
    return true;
}

function update_task_ratings($data, $id)
{
    DB::table('task_ratings')->where('id', $id)->update($data);
    return true;
}

function deleteBehaviourParameter($id)
{
    DB::table('behaviour')->where('id', $id)->delete();
    return true;
}

function totalMarksbehaviour() {
    $query = "SELECT SUM(marks) AS totalMarks FROM behaviour";
    $row = DB::select(DB::raw($query));
    return $row[0]->totalMarks;
}

function approvedtask($start, $end) {
    $query = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        t.assigned_to AS empID,
        ROUND(AVG(t.quantity + t.quality), 2) AS scores,
        CONCAT(e.fname, ' ', e.mname, ' ', e.lname) AS name,
        d.name AS department,
        p.name AS position,
        CONCAT(em.fname, ' ', em.mname, ' ', em.lname) AS executive,
        COUNT(t.id) as task_counts,
        (
            SELECT tr.id
            FROM task_ratings tr
            WHERE tr.lower_limit <= AVG(t.quantity + t.quality)
                AND tr.upper_limit > AVG(t.quantity + t.quality)
        ) AS category,
        (
            SELECT tr.title
            FROM task_ratings tr
            WHERE tr.lower_limit <= AVG(t.quantity + t.quality)
                AND tr.upper_limit > AVG(t.quantity + t.quality)
        ) AS ratings
    FROM
        task t,
        position p,
        department d,
        employee em,
        employee e
    WHERE
        e.emp_id = t.assigned_to
        AND e.position = p.id
        AND e.department = d.id
        AND e.line_manager = em.emp_id
        AND t.status = 2
        AND t.date_completed BETWEEN '".$start."' AND '".$end."'
    GROUP BY
        t.assigned_to";
    return DB::select(DB::raw($query));
}

function addTaskResource($data)
{
    DB::table('task_resources')->insert($data);
    return true;
}

function strategyOutcomes($strategyID)
{
    $query = "SELECT  o.* FROM outcome o WHERE  o.strategy_ref = '".$strategyID."'";
    return DB::select(DB::raw($query));
}

function all_outcome($strategyID)
{
    $query = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        o.id,
        o.*,
        CONCAT(e.fname, ' ', e.mname, ' ', e.lname) as executive
    FROM
        outcome o,
        employee e
    WHERE
        o.assigned_to = e.emp_id
        AND o.strategy_ref = '".$strategyID."'
    ORDER BY
        o.id DESC";
    return DB::select(DB::raw($query));
}

function outcome_info($id)
{
    $query = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        str.title as strategyTitle,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as responsible,
        o.*
    FROM
        employee e,
        outcome o,
        strategy str
    WHERE
        o.assigned_to=e.emp_id
        AND str.id = o.strategy_ref
        AND o.id = '".$id."'";
    return DB::select(DB::raw($query));
}

function outcomeTitle($id)
{
    $query = "SELECT title FROM outcome WHERE id = '".$id."'";
    return DB::select(DB::raw($query));
}

function output_info($id)
{
    $query = "SELECT
        o.*,
        otc.title as OUTCOME_REF,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
    FROM
        output o,
        outcome otc,
        employee e
    WHERE
        otc.id = o.outcome_ref
        AND o.assigned_to=e.emp_id
        AND o.id ='". $id."'";
    return DB::select(DB::raw($query));
}

function strategies()
{
    $query = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        s.*,
        f.name as funder,
        (
            SELECT SUM(task.progress)
            FROM task
            WHERE outcome_ref IN (SELECT id from outcome WHERE strategy_ref = s.id)
        ) as sumProgress,
        (
            SELECT COUNT(task.id)
            FROM task
            WHERE outcome_ref IN (SELECT id from outcome WHERE strategy_ref = s.id)
        ) as countOutcome
    FROM
        strategy s,
        funder f
    ORDER BY
        s.id DESC";
    return DB::select(DB::raw($query));
}

function strategy_info($id)
{
    $query = "SELECT ROW_NUMBER() OVER () AS SNo, s.* FROM strategy s WHERE s.id = ".$id."" ;
    return DB::select(DB::raw($query));
}

public function deleteStrategy($id) {
    $this->db->trans_start();
    $query = "DELETE FROM strategy WHERE id = '".$id."'";
    $query = "DELETE FROM outcome WHERE strategy_ref = '".$id."'";
    $this->db->trans_complete();
    return true;
}

public function deleteOutcome($id) {
    $this->db->trans_start();
    $query = "DELETE FROM outcome WHERE id = '".$id."'";
    $query = "DELETE FROM output WHERE outcome_ref = '".$id."'";
    $this->db->trans_complete();
    return true;
}

public function deleteOutput($id) {
    $this->db->trans_start();
    $query = "DELETE FROM output WHERE id = '".$id."'";
    $query = "DELETE FROM task WHERE output_ref = '".$id."'";
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
    $query = "DELETE FROM task_resources WHERE taskID = '".$id."'";
    return true;
}

public function deleteResource($id) {
    $this->db->where('id', $id);
    $this->db->delete('task_resources');
    return true;
}

function outcomes($id)
{
    $query = "SELECT
        @s:=@s+1 as SNo,
        o.*,
        str.title as strTitle,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,
        (
            SELECT SUM(task.progress)
            FROM task
            WHERE outcome_ref = o.id
        ) as sumProgress,
        (
            SELECT COUNT(task.id)
            FROM task
            WHERE outcome_ref = o.id
        ) as countOutput
    FROM
        outcome o,
        strategy str,
        (SELECT @s:=0) as s,
        employee e
    WHERE
        e.emp_id = o.assigned_to
        AND str.id = o.strategy_ref
        AND o.strategy_ref = ".$id."";
    return DB::select(DB::raw($query));
}

function outcomes_for_reference($id)
{
    $query = "SELECT
        @s:=@s+1 as SNo,
        o.id,
        o.title outcomeTitle
    FROM
        outcome o,
        (SELECT @s:=0) as s
    WHERE
        o.strategy_ref = ".$id."
    ORDER BY
        o.id DESC";
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
    $query = "SELECT
        s.*,
        (
            SELECT SUM(task.progress)
            FROM task
            WHERE strategy_ref = ".$strategyID."
        ) as sumProgress,
        (
            SELECT COUNT(task.id)
            FROM task
            WHERE strategy_ref = ".$strategyID."
        ) as countTask,
        (
            SELECT COUNT(outcome.id)
            FROM outcome
            WHERE strategy_ref = ".$strategyID."
        ) as countOutcome ,
        (
            SELECT COUNT(output.id)
            FROM output
            WHERE strategy_ref = ".$strategyID."
        ) as countOutput
    FROM
        strategy s
    WHERE
        s.id = ".$strategyID." ";

    return DB::select(DB::raw($query));
}

function addstrategy($data) {
    DB::table('strategy')->insert($data);
    return true;
}

function strategyDateRange($strategyID)
{
    $query = "SELECT st.start, st.end FROM strategy st WHERE st.id = ".$strategyID." ";
    return DB::select(DB::raw($query));
}

function update_strategy($data, $id)
{
    DB::table('strategy')->where('id', $id)->update($data);
    return true;
}

function update_outcome($data, $id)
{
    DB::table('outcome')->where('id', $id)->update($data);
    return true;
}

function add_outcome($data)
{
    DB::table('outcome')->insert($data);
    return true;
}

function outcomeCost($id) {
    $query = "SELECT
        SUM(t.monetaryValue) as outcomeCost,
        (
            SELECT COUNT(ot.id)
            FROM output ot
            WHERE ot.outcome_ref = '".$id."'
        ) as outputCount,
        COUNT(t.id) as taskCount
    FROM
        task t
    WHERE
        t.output_ref IN(
            SELECT outp.id
            FROM output outp
            WHERE outp.outcome_ref = '".$id."'
        )";

    return DB::select(DB::raw($query));
}

function outcomeResourceCost($outcomeID) {
    $query = "SELECT
        SUM(tr.cost) as sumCost
    FROM
        task_resources tr,
        outcome o,
        task t
    WHERE
        tr.taskID = t.id
        AND t.outcome_ref = '".$outcomeID."'";

    return DB::select(DB::raw($query));
}

function outcomeOutputCompleted($outcomeID) {
    $query = " SELECT
        COUNT(o.id) as progress
    FROM
        output o
    WHERE
        (
            SELECT COUNT(t.id)
            FROM task t
            WHERE t.outcome_ref = '".$outcomeID."'
        )*100 = (
            SELECT SUM(t.progress)
            FROM task t
            WHERE t.status = 2 and t.outcome_ref = '".$outcomeID."'
        )
        AND o.outcome_ref = '".$outcomeID."'";

    return DB::select(DB::raw($query));
}

function outcomeOutputProgress($outcomeID) {
    $query = "SELECT
        COUNT(o.id) as progress
    FROM
        output o
    WHERE
        (
            SELECT SUM(t.progress)
            FROM task t
            WHERE NOT t.status = 2 AND t.outcome_ref = '".$outcomeID."'
        ) > 0
        AND o.outcome_ref = '".$outcomeID."' ";

    return DB::select(DB::raw($query));
}

function outcomeOutputNotStarted($outcomeID) {
    $query = "SELECT
        COUNT(o.id) as progress
    FROM
        output o
    WHERE
        (
            SELECT SUM(t.progress)
            FROM task t
            WHERE t.output_ref = o.id
        ) = 0
        AND o.outcome_ref = ".$outcomeID." ";

    return DB::select(DB::raw($query));
}

function outputs($id)
{
    $query = "SELECT
        @s:=@s+1 as SNo,
        o.*,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,
        (
            SELECT SUM(task.progress)
            FROM task
            WHERE output_ref = o.id
        ) as sumProgress,
        (
            SELECT COUNT(task.id)
            FROM task
            WHERE output_ref = o.id
        ) as countTask
    FROM
        output o,
        employee e,
        (SELECT @s:=0) as s
    WHERE
        o.assigned_to = e.emp_id
        AND o.outcome_ref ='". $id."'
        AND NOT o.id = 0";

    return DB::select(DB::raw($query));
}

function outputProgress($id)
{
    $query = "SELECT
        SUM(t.progress) as percent
    FROM
        task t
    WHERE
        t.output_ref ='". $id."'";

    return DB::select(DB::raw($query));
}

function outputtaskCount($id)
{
    $query = "SELECT
        COUNT(t.id) as taskCount
    FROM
        task t
    WHERE
        t.output_ref ='". $id."'";

    $row = DB::select(DB::raw($query))->first();
    return $row->taskCount;
}

function outputs_select()
{
    $query = "SELECT * FROM output";
    return DB::select(DB::raw($query));
}

function all_output($strategyID)
{
    $query = "SELECT
        @s:=@s+1 as SNo,
        o.*,
        CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) as empName,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as executive,
        (
            SELECT COUNT(id)
            FROM task
            WHERE output_ref = o.id
        ) as countTask,
        (
            SELECT SUM(t.progress)
            FROM task t
            WHERE t.output_ref = o.id
        ) as sumProgress
    FROM
        output o,
        employee e,
        employee ea,
        (SELECT @s:=0) as s
    WHERE
        o.assigned_to = ea.emp_id
        AND e.emp_id = o.assigned_by
        AND o.strategy_ref = '".$strategyID."'
    ORDER BY
        o.id DESC ";

    return DB::select(DB::raw($query));
}
function output_tasks($id) {
    $query = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        t.*,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
    FROM
        task t,
        employee e,
        (SELECT ROW_NUMBER() OVER () AS s FROM task LIMIT 1) as s
    WHERE
        e.emp_id = t.assigned_to
        AND t.output_ref =  '".$id."'";

    return DB::select(DB::raw($query));
}

function outputCost($outputID) {
    $query = "SELECT
        SUM(t.monetaryValue) as outputCost,
        COUNT(t.id) as taskCount
    FROM
        task t
    WHERE
        t.output_ref =  '".$outputID."'";

    return DB::select(DB::raw($query));
}

function outputResourceCost($outputID) {
    $query = "SELECT
        SUM(tr.cost) as sumCost
    FROM
        task_resources tr,
        output o,
        task t
    WHERE
        tr.taskID = t.id
        AND t.output_ref =  '".$outputID."'";

    return DB::select(DB::raw($query));
}

function outputCompleted($id) {
    $query = "SELECT
        COUNT(o.id)
    FROM
        output o
    WHERE
        NOT o.id=0
        AND (
            SELECT COUNT(t.id)
            FROM task t
            WHERE t.status = 2
            AND t.output_ref IN (
                SELECT outp.id
                FROM output outp
                WHERE outp.outcome_ref = '".$id."'
            )
        )";

    return DB::select(DB::raw($query));
}

function outputTaskComplete($outputID) {
    $query = "SELECT
        COUNT(t.id) as progress
    FROM
        task t
    WHERE
        t.status = 2
        AND t.output_ref =  '".$outputID."'";

    return DB::select(DB::raw($query));
}

function outputTaskProgress($outputID) {
    $query = "SELECT
        COUNT(t.id) as progress
    FROM
        task t
    WHERE
        t.progress > 0
        AND NOT t.status = 2
        AND t.output_ref =  '".$outputID."'";

    return DB::select(DB::raw($query));
}

function outputTaskNotStarted($outputID) {
    $query = "SELECT
        COUNT(t.id) as progress
    FROM
        task t
    WHERE
        t.progress = 0
        AND t.output_ref =  '".$outputID."'";

    return DB::select(DB::raw($query));
}

function getbehaviour(){
    $query = 'SELECT
        ROW_NUMBER() OVER () AS SNo,
        b.*
    FROM
        behaviour b,
        (SELECT ROW_NUMBER() OVER () AS s FROM behaviour LIMIT 1) as s ';

    return DB::select(DB::raw($query));
}

function count_behaviour(){
    $query = 'SELECT b.id FROM behaviour b';

    return DB::select(DB::raw($query))->rowCount();
}

function addtask($data)
{
    DB::table("task")->insert($data);

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
    $query = "SELECT
        t.*,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
    FROM
        task t,
        employee e
    WHERE
        e.emp_id=t.assigned_to
        AND t.id =".$id."";

    return DB::select(DB::raw($query));
}

function getcomments($id) {
    $query = "SELECT
        DISTINCT t.*,
        c.*,
        (
            SELECT e.photo
            FROM employee e
            WHERE e.emp_id=c.staff
        ) as photo,
        (
            SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname)
            FROM employee e
            WHERE e.emp_id=c.staff
        ) as NAME
    FROM
        task t,
        employee e,
        comments c
    WHERE
        c.taskID = t.id
        AND t.id ='".$id."'
    ORDER BY
        c.id";

    return DB::select(DB::raw($query));
}

function progress_comment($data, $progress, $taskID){

    DB::beginTransaction();

    try {
        DB::table("comments")->insert($data);

        DB::table("task")
            ->where('id', $taskID)
            ->update(['progress' => $progress]);

        DB::commit();

        return true;
    } catch (Exception $e) {
        DB::rollback();
        return false;
    }
}

function rejectTask($comments, $taskUpdates, $taskID){
    DB::beginTransaction();

    try {
        DB::table("comments")->insert($comments);

        DB::table("task")
            ->where('id', $taskID)
            ->update($taskUpdates);

        DB::commit();

        return true;
    } catch (Exception $e) {
        DB::rollback();
        return false;
    }
}

function updateTask($data, $id)
{
    DB::table('task')
        ->where('id', $id)
        ->update($data);

    return true;
}

function updateTaskReference($data, $outputID)
{
    DB::table('task')
        ->where('output_ref', $outputID)
        ->update($data);

    return true;
}

function taskdropdown($id)
{
    $query = "SELECT
        e.emp_id as ID,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME
    FROM
        employee e
    WHERE
        e.line_manager = '".$id."'";

    return DB::select(DB::raw($query));
}

function task_notification_employee($empID)
{
    $query = "SELECT
        t.id
    FROM
        task t
    WHERE
        t.assigned_to = '".$empID."'
        AND t.isAssigned = 1
        AND t.notification = 1";

    return $query->rowCount();
}

function task_notification_line_manager($empID)
{
    $query = "SELECT
        t.id
    FROM
        task t
    WHERE
        t.assigned_by = '".$empID."'
        AND t.isAssigned = 1
        AND t.notification = 2 ";

    return $query->rowCount();
}

######################### STRATEGY DASHBOARD #################################

function getCurrentStrategy()
{
    $query = "SELECT
        id as strategyID
    FROM
        strategy
    ORDER BY
        id DESC
    LIMIT 1";

    $row = $query->row();
    return $row->strategyID;
}

function addFunder($data) {
    DB::table("funder")->insert($data);

    return true;
}

function addSegment($data) {
    DB::table("project_segment")->insert($data);

    return true;
}

function addCategory($data) {
    DB::table("expense_category")->insert($data);

    return true;
}

function addException($data) {
    DB::table("exception_type")->insert($data);

    return true;
}

function addRequest($data) {
    DB::table("grant_logs")->insert($data);

    return true;
}

function getGrantCode($activity_code, $project_code) {
    $query = "SELECT
        grant_code,
        amount,
        funder
    FROM
        activity_grant act_g,
        grants g,
        activity act
    WHERE
        act_g.activity_code = act.code
        AND g.code = act_g.grant_code
        AND activity_code = '".$activity_code."'
        AND act.project_ref = '".$project_code."' ";

    return DB::select(DB::raw($query));
}

function updateGrant($id, $data) {
    DB::table("grants")
        ->where('code', $id)
        ->update(['amount' => $data['amount']]);

    return true;
}

function addCost($data) {
    DB::table("activity_cost")->insert($data);

    return true;
}

function addActivity($data) {
    DB::table("activity")->insert($data);

    return true;
}

function getActivities($taskID)
{
    $query = "SELECT
        *,
        CONCAT(e.fname,' ', e.mname,' ', e.lname) as employee
    FROM
        activity a,
        employee e
    WHERE
        e.emp_id = a.createdBy
        AND taskID = ".$taskID."";

    return DB::select(DB::raw($query));
}

function getFunders()
{
    $query = "SELECT * FROM funder where status = 1 ";

    return DB::select(DB::raw($query));
}

function getRequest()
{
    $query = "SELECT
        gl.*,
        f.name
    FROM
        grant_logs gl,
        funder f
    WHERE
        gl.funder = f.id
        AND mode = 'IN' ";

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
    $query = "SELECT
        COUNT(o.id) as progressOutcome
    FROM
        outcome o
    WHERE
        (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id)>0
        AND (
            (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) /
            (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id)
        ) < 100
        AND o.strategy_ref = ".$strategyID;

    $row = $query->row();
    return $row->progressOutcome;
}

function outcomesNotStarted($strategyID, $today)
{
    $query = "SELECT
        COUNT(o.id) as progressOutcome
    FROM
        outcome o
    WHERE
        (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) = 0
        AND o.strategy_ref = ".$strategyID;

    $row = $query->row();
    return $row->progressOutcome;
}

function outcomesCompleted($strategyID)
{
    $query = "SELECT
        COUNT(o.id) as progressOutcome
    FROM
        outcome o
    WHERE
        (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) =
        (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) * 100
        AND o.strategy_ref = ".$strategyID;

    $row = $query->row();
    return $row->progressOutcome;
}

function outcomesOverdue($strategyID, $today)
{
    $query = "SELECT
        COUNT(o.id) as progressOutcome
    FROM
        outcome o
    WHERE
        (SELECT SUM(task.progress) FROM task WHERE outcome_ref = o.id) <
        (SELECT COUNT(task.id) FROM task WHERE outcome_ref = o.id) * 100
        AND o.end < '".$today."'
        AND o.strategy_ref = ".$strategyID;

    $row = $query->row();
    return $row->progressOutcome;
}

function outputsNotStarted($strategyID, $today)
{
    $query = "SELECT
        COUNT(o.id) as progressOutput
    FROM
        output o
    WHERE
        o.strategy_ref = ".$strategyID."
        AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id) = 0 ";

    $row = $query->row();
    return $row->progressOutput;
}

function outputsProgress($strategyID)
{
    $query = "SELECT
        COUNT(o.id) as progressOutput
    FROM
        output o
    WHERE
        o.strategy_ref = ".$strategyID."
        AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id) > 0
        AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id) <
        (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) * 100";

    $row = $query->row();
    return $row->progressOutput;
}

function outputsCompleted($strategyID)
{
    $query = "SELECT
        COUNT(o.id) as progressOutput
    FROM
        output o
    WHERE
        o.strategy_ref = ".$strategyID."
        AND (SELECT SUM(progress) FROM task WHERE output_ref = o.id) =
        (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) * 100";

    $row = $query->row();
    return $row->progressOutput;
}

function outputsOverdue($strategyID, $today)
{
    $query = "SELECT
        COUNT(o.id) as progressOutput
    FROM
        output o
    WHERE
        o.end < '".$today."'
        AND o.strategy_ref = ".$strategyID."
        AND (SELECT SUM(task.progress) FROM task WHERE output_ref = o.id) <
        (SELECT COUNT(task.id) FROM task WHERE output_ref = o.id) * 100";

    $row = $query->row();
    return $row->progressOutput;
}

function tasksNotStarted($strategyID)
{
    $query = "SELECT
        COUNT(t.id) as progressTask
    FROM
        task t
    WHERE
        t.strategy_ref = ".$strategyID."
        AND t.progress = 0 ";

    $row = $query->row();
    return $row->progressTask;
}

function tasksProgress($strategyID)
{
    $query = "SELECT
        COUNT(t.id) as progressTask
    FROM
        task t
    WHERE
        t.strategy_ref = ".$strategyID."
        AND t.progress > 0
        AND NOT t.status = 2";

    $row = $query->row();
    return $row->progressTask;
}

function tasksCompleted($strategyID)
{
    $query = "SELECT
        COUNT(t.id) as progressTask
    FROM
        task t
    WHERE
        t.strategy_ref = ".$strategyID."
        AND t.status = 2";

    $row = $query->row();
    return $row->progressTask;
}


function tasksOverdue($strategyID, $today)
{
    $progressTask = DB::table('task')
        ->where('end', '<', $today)
        ->where('strategy_ref', $strategyID)
        ->where('status', '!=', 2)
        ->count();

    return $progressTask;
}

function outcomeOffTrack($strategyID, $today, $elapsedPercent)
{
    $progressOutcome = DB::table('outcome as o')
        ->select(DB::raw('COUNT(o.id) as progressOutcome'))
        ->whereRaw('(SELECT SUM(progress) FROM task WHERE outcome_ref = o.id) >= 0')
        ->whereRaw('((SELECT SUM(progress) FROM task WHERE outcome_ref = o.id) / (SELECT COUNT(id) FROM task WHERE outcome_ref = o.id)) < 100')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - o.start)) + 1) / (EXTRACT(EPOCH FROM (o.end - o.start)) + 1)) * 100 >= ?', [$elapsedPercent])
        ->where('o.end', '>=', $today)
        ->where('o.strategy_ref', $strategyID)
        ->count();

    return $progressOutcome;
}

function outcomeOntrack($strategyID, $today, $elapsedPercent)
{
    $progressOutcome = DB::table('outcome as o')
        ->select(DB::raw('COUNT(o.id) as progressOutcome'))
        ->whereRaw('(SELECT SUM(progress) FROM task WHERE outcome_ref = o.id) >= 0')
        ->whereRaw('((SELECT SUM(progress) FROM task WHERE outcome_ref = o.id) / (SELECT COUNT(id) FROM task WHERE outcome_ref = o.id)) < 100')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - o.start)) + 1) / (EXTRACT(EPOCH FROM (o.end - o.start)) + 1)) * 100 < ?', [$elapsedPercent])
        ->where('o.end', '>=', $today)
        ->where('o.strategy_ref', $strategyID)
        ->count();

    return $progressOutcome;
}

function outputOffTrack($strategyID, $today, $elapsedPercent)
{
    $progressOutput = DB::table('output as o')
        ->select(DB::raw('COUNT(o.id) as progressOutput'))
        ->where('o.strategy_ref', $strategyID)
        ->whereRaw('((SELECT SUM(progress) FROM task WHERE output_ref = o.id) / (SELECT COUNT(id) FROM task WHERE output_ref = o.id)) >= 0')
        ->whereRaw('((SELECT SUM(progress) FROM task WHERE output_ref = o.id) / (SELECT COUNT(id) FROM task WHERE output_ref = o.id)) < 100')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - o.start)) + 1) / (EXTRACT(EPOCH FROM (o.end - o.start)) + 1)) * 100 >= ?', [$elapsedPercent])
        ->where('o.end', '>=', $today)
        ->count();

    return $progressOutput;
}

	//0ff Track less than 80% elaspsed but not Completed.
	function outputOntrack($strategyID, $today, $elapsedPercent)
{
    $progressOutput = DB::table('output as o')
        ->select(DB::raw('COUNT(o.id) as progressOutput'))
        ->where('o.strategy_ref', $strategyID)
        ->whereRaw('((SELECT COALESCE(SUM(progress), 0) FROM task WHERE output_ref = o.id) / NULLIF((SELECT COUNT(id) FROM task WHERE output_ref = o.id), 0)) >= 0')
        ->whereRaw('((SELECT COALESCE(SUM(progress), 0) FROM task WHERE output_ref = o.id) / NULLIF((SELECT COUNT(id) FROM task WHERE output_ref = o.id), 0)) < 100')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - o.start)) + 1) / NULLIF((EXTRACT(EPOCH FROM (o.end - o.start)) + 1), 0)) * 100 < ?', [$elapsedPercent])
        ->where('o.end', '>=', $today)
        ->count();

    return $progressOutput;
}

function taskOffTrack($strategyID, $today, $elapsedPercent)
{
    $progressTask = DB::table('task as t')
        ->select(DB::raw('COUNT(t.id) as progressTask'))
        ->whereRaw('NOT t.status = 2')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - t.start)) + 1) / NULLIF((EXTRACT(EPOCH FROM (t.end - t.start)) + 1), 0)) * 100 >= ?', [$elapsedPercent])
        ->where('t.strategy_ref', $strategyID)
        ->where('t.end', '>=', $today)
        ->count();

    return $progressTask;
}

function taskOntrack($strategyID, $today, $elapsedPercent)
{
    $progressTask = DB::table('task as t')
        ->select(DB::raw('COUNT(t.id) as progressTask'))
        ->whereRaw('NOT t.status = 2')
        ->whereRaw('((EXTRACT(EPOCH FROM (CURRENT_DATE - t.start)) + 1) / NULLIF((EXTRACT(EPOCH FROM (t.end - t.start)) + 1), 0)) * 100 < ?', [$elapsedPercent])
        ->where('t.strategy_ref', $strategyID)
        ->where('t.end', '>=', $today)
        ->count();

    return $progressTask;
}

function outcomesGraph($strategyID)
{
    $query = "SELECT s.sno, otc.id, otc.strategy_ref, (SELECT COALESCE(SUM(t.progress), 0) FROM task t WHERE t.outcome_ref = otc.id) as sumProgress, (SELECT COUNT(t.id) FROM task t WHERE t.outcome_ref = otc.id) as taskCount FROM outcome otc, (SELECT ROW_NUMBER() OVER () as sno FROM outcome WHERE strategy_ref = ".$strategyID.") s WHERE otc.strategy_ref = ".$strategyID;

    return DB::select(DB::raw($query));
}

function strategyProgress($id)
{
    $query = "SELECT s.id,
                     COALESCE((SELECT SUM(task.progress) FROM task WHERE outcome_ref IN (SELECT id FROM outcome WHERE strategy_ref = s.id)), 0) as sumProgress,
                     COALESCE((SELECT COUNT(task.id) FROM task WHERE outcome_ref IN (SELECT id FROM outcome WHERE strategy_ref = s.id)), 0) as countTask
              FROM strategy s WHERE s.id = ".$id;

    $result = DB::select(DB::raw($query));

    if (!empty($result) && property_exists($result[0], 'countTask') && $result[0]->countTask == 0) {
        return 0;
    } elseif (!empty($result) && property_exists($result[0], 'sumProgress') && property_exists($result[0], 'countTask')) {
        return $result[0]->countTask != 0 ? $result[0]->sumProgress / $result[0]->countTask : 0;
    } else {
        // Handle the case when the result is not as expected
        return 0;
    }
}


function outputsGraph($strategyID)
{
    $query = "SELECT s.sno, o.id, o.strategy_ref, o.outcome_ref, (SELECT COALESCE(SUM(t.progress), 0) FROM task t WHERE t.output_ref = o.id) as sumProgress, (SELECT COUNT(t.id) FROM task t WHERE t.output_ref = o.id) as taskCount FROM output o, (SELECT ROW_NUMBER() OVER () as sno FROM output WHERE strategy_ref = ".$strategyID.") s WHERE o.strategy_ref = ".$strategyID;

    return DB::select(DB::raw($query));
}

function outcomesList($id)
{
    $query = "SELECT s.sno, o.id, o.title FROM outcome o, (SELECT ROW_NUMBER() OVER () as sno FROM outcome WHERE strategy_ref = ".$id.") s WHERE o.strategy_ref = ".$id;

    return DB::select(DB::raw($query));
}

function defaultOutcome($id)
{
    $query = "SELECT o.id FROM outcome o  WHERE o.strategy_ref = ".$id." ORDER BY o.id DESC LIMIT 1";
    $row = DB::select(DB::raw($query));
    return $row[0]->id;
}

function percentSetting()
{
    $query = "SELECT value FROM task_settings WHERE id = 2";
    $row = DB::select(DB::raw($query));
    return $row[0]->value;
}

// The rest of the functions would follow a similar pattern, modifying SQL queries accordingly.




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
