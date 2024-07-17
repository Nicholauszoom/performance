<?php

namespace App\Models\Payroll;

use App\Helpers\SysHelpers;
use App\Models\FinancialLogs;
use App\Models\Termination;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class FlexPerformanceModel extends Model
{

    public function audit_log($description)
    {
        $request = App::make('request');
        $userAgent = $request->header('User-Agent');
        $ipAddress = $request->ip();
        $logData = array(
            'emp_id' => auth()->user()->emp_id,
            'emp_name' => auth()->user()->fname . ' ' . auth()->user()->lname,
            'action_performed' => $description,
            'user_agent' => $userAgent,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
            'ip_address' => $ipAddress,
            'risk' => 1,
        );

        DB::table('audit_trails')->insert($logData);
    }

    public function audit_logs()
{
    $query = "SELECT d.name as department, p.name as position, al.*, p.name as position, d.name as department, CONCAT(e.fname,' ', COALESCE(e.mname, ' '), ' ', e.lname) as empName
              FROM audit_trails al
              JOIN employee e ON al.emp_id = e.emp_id
              JOIN position p ON p.id = e.position
              JOIN department d ON e.department = d.id
              ORDER BY al.created_at DESC";

    return DB::select(DB::raw($query));
}


    public function financialLogs1($last_payroll_month_date, $payroll_date)
    {
        $query = "SELECT Date(fn.created_at),fn.*, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,''),' ', e.lname) as empName, CONCAT(au.fname,' ', au.mname,' ', au.lname) as authName FROM financial_logs fn, employee e, employee au  WHERE Date(fn.created_at) Like '%" . $date . "%' and fn.payrollno = e.emp_id AND fn.changed_by = au.emp_id  ORDER BY fn.created_at DESC";

        return DB::select(DB::raw($query));
    }

    public function financialLogs($start_date, $end_date)
    {

        // Calculate the date after the start_date
        $next_day = date('Y-m-d', strtotime($start_date . ' +1 day'));
        $query = "SELECT Date(fn.created_at) as created_date, fn.*,
                        CONCAT(e.fname,' ', IF(e.mname IS NOT NULL, e.mname, ''),' ', e.lname) as empName,
                        CONCAT(au.fname,' ', IF(au.mname IS NOT NULL, au.mname, ''),' ', au.lname) as authName
                FROM financial_logs fn
                JOIN employee e ON fn.payrollno = e.emp_id
                JOIN employee au ON fn.changed_by = au.emp_id
                WHERE Date(fn.created_at) BETWEEN :next_day AND :end_date
                ORDER BY fn.created_at DESC";

        return DB::select(DB::raw($query), ['next_day' => $next_day, 'end_date' => $end_date]);
    }


public function audit_purge_logs()
{
    $query = "SELECT d.name as department, p.name as position, al.*, CAST(al.due_date as date) as dated, CAST(al.due_date as time) as timed, p.name as position, d.name as department, CONCAT(e.fname,' ', COALESCE(e.mname, ''),' ', e.lname) as empName
              FROM audit_purge_logs al
              JOIN employee e ON al.empID = e.emp_id
              JOIN position p ON p.id = e.position
              JOIN department d ON e.department = d.id
              ORDER BY al.due_date DESC";

    return DB::select(DB::raw($query));
}


public function clear_audit_logs()
{
    DB::table('audit_logs')->truncate();

    return true;
}

public function getCurrentStrategy()
{
    $query = "SELECT id as strategyID FROM strategy ORDER BY id DESC LIMIT 1";

    $row = DB::select(DB::raw($query));

    return count($row) > 0 ? $row[0]->strategyID : null;
}


    public function getAttributeName($attribute, $table, $referenceName, $referenceValue)
    {
        // $query = $attribute." AS attributeValue   WHERE ".$referenceName." = '".$referenceValue."' ";
        $row = DB::table($table)
            ->select($attribute . ' AS attributeValue')
            ->where($referenceName, $referenceValue)
            ->limit(1)
            ->first();

        return $row->attributeValue;
    }

    // public function employee()
    // {
    //     $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id = e.line_manager limit 1 ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1";

    //     return DB::select(DB::raw($query));
    // }



    public function employee()
{
    $query = "WITH serial AS (
            SELECT ROW_NUMBER() OVER () AS SNo, emp_id
            FROM employee
        ),
        accrued_leaves AS (
            SELECT empID, COALESCE(SUM(days), 0) AS accrued
            FROM leaves
            WHERE nature = '1'
            GROUP BY empID
        ),
        linemanagers AS (
            SELECT emp_id, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS linemanager_name
            FROM employee
        )
        SELECT
            s.SNo,
            p.name AS \"POSITION\",
            d.name AS \"DEPARTMENT\",
            e.*,
            CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS \"NAME\",
            lm.linemanager_name AS \"LINEMANAGER\",
            COALESCE(al.accrued, 0) AS \"ACCRUED\"
        FROM
            employee e
        JOIN
            department d ON d.id = e.department
        JOIN
            position p ON p.id = e.position
        LEFT JOIN
            accrued_leaves al ON al.empID = e.emp_id
        LEFT JOIN
            linemanagers lm ON lm.emp_id = e.line_manager
        JOIN
            serial s ON s.emp_id = e.emp_id
        WHERE
            e.state = 1
    ";

    return DB::select(DB::raw($query));
}



    public function employeeTerminatedPartial()
    {
        $query = "WITH employee_data AS (
            SELECT
                e.*,
                p.name as POSITION_NAME,
                d.name as DEPARTMENT_NAME,
                CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as NAME,
                (SELECT CONCAT(el.fname, ' ', COALESCE(el.mname, ''), ' ', el.lname)
                 FROM employee el
                 WHERE el.emp_id = e.line_manager
                 LIMIT 1) as LINEMANAGER,
                COALESCE((SELECT sum(days) FROM leaves WHERE nature='1' AND empID=e.emp_id GROUP BY nature), 0) as ACCRUED,
                CASE WHEN t.\"employeeID\" IS NOT NULL THEN 1 ELSE 0 END AS termination_flag
            FROM
                employee e
            JOIN
                department d ON d.id = e.department
            JOIN
                position p ON p.id = e.position
            LEFT JOIN
                terminations t ON t.\"employeeID\" = e.emp_id
            WHERE
                t.\"employeeID\" IS NULL AND e.state = 1
        )
        SELECT
            ROW_NUMBER() OVER (ORDER BY e.emp_id) as SNo,
            POSITION_NAME,
            DEPARTMENT_NAME,
            e.*
        FROM
            employee_data e
    ";

        return DB::select(DB::raw($query));
    }



    public function employeelinemanager($id)
    {
        $query = "SELECT @s:=@s+1 SNo,
		p.name as POSITION,
		d.name as DEPARTMENT,
		e.*,
		CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME,
		(SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) from employee el where el.emp_id=e.line_manager ) as LINEMANAGER,
		IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.line_manager='" . $id . "' and e.state=1";

        return DB::select(DB::raw($query));
    }

    public function department($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as HOD,  d.* FROM department d, employee e,  (SELECT @s:=0) as s  WHERE d.hod = e.emp_id and and d.state = 1 AND d.hod='" . $id . "'";

        // return DB::select(DB::raw($query));
        return DB::select(DB::raw($query));
    }

    public function allDepartment()
{
    $test = DB::table('department')
        ->join('cost_center', 'cost_center.id', '=', 'department.cost_center_id')
        ->join('employee', 'employee.emp_id', '=',    DB::raw('CAST(department.hod AS TEXT)'))
        ->join('department as d2', 'department.reports_to', '=', 'd2.id')
        ->select('cost_center.name as CostCenterName', 'department.*', DB::raw("CONCAT(employee.fname, ' ', employee.mname, ' ', employee.lname) as HOD"), 'd2.name as parentdept')
        ->where('department.state', 1)
        ->where('department.type', 1)
        ->get();

    return $test;
}



    public function costDepartments()
    {
        $query = DB::table('department')
            ->select('dept_no as id', 'name')
            ->where('state', 1)
            ->where('type', 1)
            ->get();

        return $query;
    }

    public function costProjects()
    {
        $query = DB::table('project')
            ->select('id', 'name')
            ->get();

        return $query;
    }

    public function inactive_department()
    {
        $result = DB::table(DB::raw('(SELECT 0) as s'))
        ->join('department as d', function ($join) {
            $join->on('d.state', '=', DB::raw('0'));
        })
        ->join('department as pd', 'd.reports_to', '=', 'pd.id')
        ->join('employee as e', DB::raw('CAST(d.hod AS TEXT)'), '=', 'e.emp_id')
        ->selectRaw('ROW_NUMBER() OVER () as "SNo"')
        ->selectRaw('CONCAT(e.fname, \' \', COALESCE(e.mname, \'\'), \' \', e.lname) as "HOD"')
        ->select('d.*', 'pd.name as "parentdept"')
        ->get();

    return $result;

    }
    public function get_deligates($id)
    {
        $level1 = DB::table('level1')->where('deligetor', $id)->count();

        $level2 = DB::table('level2')->where('deligetor', $id)->count();

        $level3 = DB::table('level3')->where('deligetor', $id)->count();

        return ($level1 + $level2 + $level3);
    }

    public function branch()
    {
        $query = "SELECT ROW_NUMBER() OVER () AS \"SNo\", b.*FROM branch b";

        return DB::select(DB::raw($query));
    }

    public function addEvaluation($evaluation, $evaluation_id)
    {
        $query = "INSERT INTO performance_evaluations(empID,evaluation_id,pillar_id,target,achieved,actions,measures,results,rating,weighting,score,strategy_type)
         SELECT '" . $evaluation->empID . "','" . $evaluation_id . "',p.id,0,0,'N/A','N/A','N/A',0,0,0,p.type from performance_pillars p ";

        $result = DB::insert(DB::raw($query));

        return true;
    }

    public function get_employee_details($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, c.* FROM cost_center c, (SELECT @s:=0) as s ";

        return DB::select(DB::raw($query));
    }

    public function costCenter()
    {
        return $this->selectRaw('ROW_NUMBER() OVER () as SNo, cost_centers.*')
            ->from('cost_center as cost_centers')
            ->crossJoin(DB::raw('(SELECT 0) as s'))
            ->get();
    }
    public function addCompanyBranch($data)
    {

        DB::table('branch')->insert($data);

        $query = "SELECT id from branch ORDER BY id DESC LIMIT 1";
        $row = DB::select(DB::raw($query));

        return $row[0]->id;
    }

    public function addCompanyInfo($data)
    {

        DB::table('company_info')->insert($data);

        return true;
    }

    /**
     * Getting company information
     */
    public function getCompanyInfo()
    {
        $query = DB::table('company_info')->first();

        

        return $query;
    }

    public function updateCompanyInfo($data, $id)
    {

        unset($data['id']);

        DB::table('company_info')->where('id', $id)->update($data);

        return true;
    }

    public function addCostCenter($data)
    {

        DB::table('cost_center')->insert($data);
        $query = "SELECT id from cost_center  ORDER BY id DESC LIMIT 1";

        $row = DB::select(DB::raw($query));
        return $row[0]->id;
    }

    public function accountCodes()
    {
        $query = "SELECT @s:=@s+1 as SNo, ac.* FROM account_code ac, (SELECT @s:=0) as s ";

        return DB::select(DB::raw($query));
    }

    public function addAccountCode($data)
    {
        DB::table('account_code')->insert($data);
        return true;
    }
    public function updateAccountCode($updates, $accountingId)
    {
        DB::table('account_code')->where('id', $accountingId)
            ->update($updates);
        return true;
    }

    public function deleteAccountCode($id)
    {
        DB::table('account_code')
            ->where('id', $id)
            ->delete('account_code');
        return true;
    }

    public function nationality()
{
    $countries = DB::table('country')
        ->select(DB::raw('ROW_NUMBER() OVER() as SNo'), 'country.*')
        ->get();

    return $countries;

    }

    public function addEmployeeNationality($data)
    {
        DB::table('country')->insert($data);
        return true;
    }

    public function checkEmployeeNationality($code)
    {
        $query = "COUNT(emp_id) AS counts  WHERE nationality = " . $code . " ";
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

    public function updateCompanyBranch($updates, $id)
    {
        DB::table('branch')->where('id', $id)
            ->update($updates);
        return true;
    }

    public function updateCostCenter($updates, $id)
    {
        DB::table('cost_center')->where('id', $id)
            ->update($updates);
        return true;
    }

    public function currentdepartment()
    {
        $query = "SELECT * FROM department ORDER by id DESC LIMIT 1";

        return DB::select(DB::raw($query));
    }

    public function logo()
    {
        $query = "logo";
        $row = DB::table('company_info')
            ->select(DB::raw($query))
            ->first();

        return $row->logo;
    }

    public function get_lastPayrollNo()
    {
        $query = "SELECT emp_id from employee where emp_id not like '%JOB_%' ORDER BY emp_id DESC LIMIT 1";
        $row = DB::select(DB::raw($query));

        return $row[0]->emp_id;
    }

    public function contractdrop()
    {
        $query = "SELECT c.* FROM contract c WHERE NOT c.item_code = 23";

        return DB::select(DB::raw($query));
    }

    public function contract()
    {
        $query = "SELECT @s:=@s+1 as SNo, c.* FROM contract c,  (SELECT @s:=0) as s WHERE c.state = 1";

        return DB::select(DB::raw($query));
    }
    public function contractAdd($data)
    {
        DB::table('contract')->insert($data);
        return true;
    }

    //upload users(employees)
    public function uploadEmployees($data)
    {
        foreach ($data as $employee) {
            $this->employeeAdd($employee);
        }
        echo 'Employees Imported successfully';
    }

    /*function custom_attendees($date)
    {
    $query = "SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(att.due_in as date) as DATE_IN,  CAST(att.due_in as time) as time_in,  CAST(att.due_out as time) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '".$date."'  ";

    return DB::select(DB::raw($query));
    }*/

    /*
    IMPREST FUNCTIONS MOVED TO IMPREST MODEL
     */

     public function my_overtimes($id)
     {
        $query = "SELECT
            row_number() OVER () as \"SNo\",
            eo.final_line_manager_comment as comment,
            eo.linemanager as line_manager,
            eo.status as status,
            eo.id as eoid,
            eo.reason as reason,
            eo.\"empID\" as empID,
            CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as name,
            d.name as DEPARTMENT,
            p.name as POSITION,
            CAST(eo.application_time AS DATE) as \"applicationDATE\",
            CAST(eo.time_end AS TIME) as time_out,
            CAST(eo.time_start AS TIME) as time_in,
            (EXTRACT(EPOCH FROM (eo.time_end - eo.time_start)) / 3600) *
                (CASE WHEN eo.overtime_type = 0 THEN (e.salary / 240) * (SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)
                    ELSE (e.salary / 240) * (SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)
                END) AS earnings,
            ROUND((EXTRACT(EPOCH FROM (eo.time_end - eo.time_start)) / 3600), 2) as \"total_hours\"
        FROM
            employee e
        JOIN
            employee_overtime eo ON eo.\"empID\" = e.emp_id
        JOIN
            department d ON e.department = d.id
        JOIN
            position p ON e.position  = p.id
        WHERE
            eo.\"empID\" = '$id'
        ORDER BY
            eo.id DESC;
        ";


        // dd(DB::select(DB::raw($query)));
         return DB::select(DB::raw($query));
     }






    public function Overtime_total($id)
    {
        $query = "SELECT SUM(amount) as total_amount,SUM((TIMESTAMPDIFF(MINUTE, time_start, time_end)/60)) as total_hours from overtimes WHERE empID = '" . $id . "'";
        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function fetch_my_overtime($id)
    {
        $query = "SELECT eo.*, CONCAT(eo.time_start,' - ',eo.time_end) as timeframe 	FROM  employee_overtime eo WHERE eo.id =" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function all_overtimes()
    {
        $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment, eo.reason as reason,  eo.status as status, eo.id as eoid, eo.empID as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id and e.department = d.id and e.position = p.id";

        return DB::select(DB::raw($query));
    }

    public function overtimesLinemanager($lineID)
    {
        $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id and e.department = d.id and e.position = p.id AND e.line_manager = '" . $lineID . "' ORDER BY eo.id DESC";

        return DB::select(DB::raw($query));
    }

    public function allOvertimes($empID)
    {
        $query = "SELECT
    ROW_NUMBER() OVER (ORDER BY eo.id DESC) AS SNo,
    eo.linemanager AS manager,
    eo.final_line_manager_comment AS comment,
    eo.status AS status,
    eo.id AS eoid,
    eo.reason AS reason,
    eo.\"empID\" AS empID,
    CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS name,
    d.name AS DEPARTMENT,
    p.name AS POSITION,
    CAST(eo.application_time AS DATE) AS applicationDATE,
    CAST(eo.time_end AS TIME) AS time_out,
    CAST(eo.time_start AS TIME) AS time_in,
    ((EXTRACT(EPOCH FROM eo.time_end - eo.time_start) / 3600) *
        (CASE
            WHEN eo.overtime_type = 0 THEN ((e.salary / 240) * (SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))
            ELSE ((e.salary / 240) * (SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))
        END)) AS earnings,
    (EXTRACT(EPOCH FROM eo.time_end - eo.time_start) / 3600) AS totoalHOURS
FROM
    employee e
JOIN
    employee_overtime eo ON eo.\"empID\" = e.emp_id
JOIN
    position p ON e.position = p.id
JOIN
    department d ON e.department = d.id
WHERE
    eo.\"empID\" != \"empID\"
ORDER BY
    eo.id DESC
";

        return DB::select(DB::raw($query));
    }

    public function pending_overtime()
    {
        $query = "SELECT count(id) as total from employee_overtime where status = 1";
        $row = DB::select(DB::raw($query));
        return $row[0]->total;
    }

    // public function lineOvertimes($id)
    // {
    //     $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
	// 	CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
	// 	FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE   e.department = d.id and eo.empID = e.emp_id  and e.position = p.id   ORDER BY eo.id DESC";

    //     //$query = "SELECT *  FROM employee_overtime";

    //     return DB::select(DB::raw($query));
    // }

    public function lineOvertimes($id)
{
    $query = "SELECT row_number() OVER () as \"SNo\",
        eo.final_line_manager_comment as comment,
        eo.status as status,
        eo.id as eoid,
        eo.reason as reason,
        eo.\"empID\" as empID,
        CONCAT(e.fname,' ',COALESCE(e.mname,''),' ', e.lname) as name,
        d.name as department,
        p.name as position,
        CAST(eo.application_time AS date) as application_date,
        CAST(eo.time_end AS time) as time_out,
        CAST(eo.time_start AS time) as time_in,
        EXTRACT(EPOCH FROM (eo.time_end - eo.time_start))/3600 as total_hours
    FROM employee e
    JOIN employee_overtime eo ON e.emp_id = eo.\"empID\"
    JOIN position p ON e.position = p.id
    JOIN department d ON e.department = d.id
    ORDER BY eo.id DESC";

    return DB::select(DB::raw($query));
}


    public function lineOvertime($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment, eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ',IF(e.mname != null, e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
	CAST(eo.time_end as time) as time_out, CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totalHOURS
	FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s
	WHERE e.department = d.id AND eo.empID = e.emp_id AND e.position = p.id AND eo.linemanager = :id
	ORDER BY eo.id DESC";

        return DB::select(DB::raw($query), ['id' => $id]);
    }

    public function approvedOvertimes()
    {
        $query1 = "SELECT  eo.id as id,CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION,
		  eo.days as totoalHOURS,eo.amount,eo.status as status,oc.name as overtime_category
		FROM employee e, overtimes eo, position p, department d,overtime_category oc, (SELECT @s:=0) as s WHERE   e.department = d.id and eo.empID = e.emp_id  and e.position = p.id and eo.overtime_category = oc.id  ORDER BY eo.id DESC";
        $query = "SELECT
        eo.id as id,
        CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as name,
        d.name as DEPARTMENT,
        p.name as POSITION,
        eo.days as totalHOURS,
        eo.amount,
        eo.status as status,
        oc.name as overtime_category
    FROM
        employee e
    JOIN
        overtimes eo ON eo.\"empid\" = e.emp_id
    JOIN
        position p ON e.position = p.id
    JOIN
        department d ON e.department = d.id
    JOIN
        overtime_category oc ON eo.overtime_category::bigint = oc.id
    ORDER BY
        eo.id DESC
    ";

        //$query = "SELECT *  FROM employee_overtime";

        return DB::select(DB::raw($query));
    }

    public function overtimesHR()
    {
        $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id AND e.department = d.id AND e.position = p.id AND  eo.status IN(2,4,5) ORDER BY eo.id DESC";

        return DB::select(DB::raw($query));
    }

    public function get_linemanagerID($id)
    {
        // $query = "SELECT line_manager  FROM employee WHERE emp_id = '".$id."' LIMIT 1";

        $query = DB::table('employee')->select('line_manager')->where('emp_id', $id)->limit(1)->first();

        // dd($query->line_manager);

        // return DB::select(DB::raw($query));
        return $query->line_manager;
    }

    public function waitingOvertimes_hr()
    {
        $query = "SELECT * FROM employee_overtime WHERE status =1";
        return DB::select(DB::raw($query));
    }
    public function waitingOvertimes_fin()
    {
        $query = "SELECT * FROM employee_overtime WHERE status =3";
        return DB::select(DB::raw($query));
    }
    public function waitingOvertimes_appr()
    {
        $query = "SELECT * FROM employee_overtime WHERE status =4";
        return DB::select(DB::raw($query));
    }
    public function waitingOvertimes_line($id)
    {
        $query = "SELECT * FROM employee_overtime WHERE linemanager ='" . $id . "' AND status =0";
        return DB::select(DB::raw($query));
    }

    public function overtimes()
    {
        $query = "SELECT @s:=@s+1 as SNo, eo.final_line_manager_comment as comment,  eo.status as status, o.status AS payment_status, eo.id as eoid, eo.reason as reason, eo.empID as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as DEPARTMENT, p.name as POSITION, CAST(eo.application_time as date) as applicationDATE,
		CAST(eo.time_end as time) as time_out ,CAST(eo.time_start as time) as time_in, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)),((e.salary/240)*(SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category)) )) AS earnings, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) as totoalHOURS
		FROM employee e, employee_overtime eo, overtimes o, position p, department d, (SELECT @s:=0) as s WHERE eo.empID = e.emp_id AND e.department = d.id AND e.position = p.id AND eo.id = o.overtimeID AND  eo.status = 0 ORDER BY eo.id DESC";

        return DB::select(DB::raw($query));
    }

    public function fetchOvertimeComment($id)
    {
        $query = "SELECT id, final_line_manager_comment as comment, commit  FROM employee_overtime WHERE id = '" . $id . "'  ";

        return DB::select(DB::raw($query));
    }

    public function apply_overtime($data)
    {
        DB::table('employee_overtime')->insert($data);
        return true;
    }

    public function update_overtime($data, $id)
    {
        DB::table('employee_overtime')
            ->where('id', $id)
            ->update($data);

        return true;
    }

    public function deny_overtime($id)
    {
        DB::transaction(function () use ($id) {
            $query = "UPDATE employee_overtime SET status = 4 WHERE id ='" . $id . "'";

            DB::insert(DB::raw($query));

            $query = "DELETE FROM overtimes WHERE overtimeID ='" . $id . "'";

            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function confirmOvertimePayment($id, $status)
    {

        $query = "UPDATE  overtimes SET status = " . $status . " WHERE overtimeID ='" . $id . "'";
        DB::insert(DB::raw($query));

        return true;
    }

    public function get_payment_per_hour($overtimeID)
    {
        $query = "ROUND((salary/30), 2) as payment WHERE emp_id = (SELECT empID FROM employee_overtime WHERE id =" . $overtimeID . ") ";
        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->first();
        return $row->payment;
    }

    public function get_overtime_type($overtimeID)
    {
        $query = "overtime_type as type  WHERE id =" . $overtimeID . " ";
        $row = DB::table('employee_overtime')
            ->select(DB::raw($query))
            ->first();
        return $row->type;
    }

    public function checkApprovedOvertime($overtimID)
    {
        $row = DB::table('employee_overtime')
            ->select(DB::raw('COUNT(id) as counts'))
            ->where('id', $overtimID)
            ->where('status', 2)
            ->limit(1)
            ->first();

        return $row->counts;
    }
    public function checkApprovedOvertimeApi($overtimID)
    {
        $row = DB::table('employee_overtime')
            ->select(DB::raw('COUNT(id) as counts'))
            ->where('id', $overtimID)
            ->where('status', 1)
            ->limit(1)
            ->first();

        return $row->counts;
    }
    public function checkOvertimeStatus($overtimeID)
    {
        $row = DB::table('employee_overtime')
            ->where('id', $overtimeID)
            ->value('status');

        return $row;
    }
    public function checkOvertimeExistence($overtimeID)
    {
        $exists = DB::table('employee_overtime')
            ->where('id', $overtimeID)
            ->exists();

        return $exists;
    }

    public function get_employee_overtime($overtimeID)
    {
        $query = "Select eo.empID, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/176)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))),((e.salary/176)*((SELECT night_percent FROM overtime_category WHERE id = eo.overtime_category))) )) AS amount from employee_overtime eo,employee e where e.emp_id = eo.empID and  eo.id = '" . $overtimeID . "'";
        $data = DB::select(DB::raw($query));
        return $data[0]->amount;
    }

    public function get_employee_overtimeID($overtimeID)
    {
        $query = "Select eo.empID, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/176)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))),((e.salary/176)*((SELECT night_percent FROM overtime_category WHERE id = eo.overtime_category))) )) AS amount from employee_overtime eo,employee e where e.emp_id = eo.empID and  eo.id = '" . $overtimeID . "'";
        $data = DB::select(DB::raw($query));
        return $data[0]->empID;
    }

    public function get_employee_overtime_category($overtimeID)
    {
        $query = "Select eo.overtime_category, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/176)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))),((e.salary/176)*((SELECT night_percent FROM overtime_category WHERE id = eo.overtime_category))) )) AS amount from employee_overtime eo,employee e where e.emp_id = eo.empID and  eo.id = '" . $overtimeID . "'";
        $data = DB::select(DB::raw($query));
        return $data[0]->overtime_category;
    }

    public function approveOvertime($id, $signatory, $time_approved)
    {
        DB::transaction(function () use ($id, $signatory, $time_approved) {
            $query = "INSERT INTO overtimes(overtimeID, empID, time_start, time_end,overtime_category, amount, linemanager, hr, application_time, confirmation_time, approval_time) SELECT eo.id, eo.empID, eo.time_start, eo.time_end,eo.overtime_category, (TIMESTAMPDIFF(MINUTE, eo.time_start, eo.time_end)/60) * (IF((eo.overtime_type = 0),((e.salary/176)*((SELECT day_percent FROM overtime_category WHERE id = eo.overtime_category))),((e.salary/176)*((SELECT night_percent FROM overtime_category WHERE id = eo.overtime_category))) )) AS amount, eo.linemanager, '" . $signatory . "', eo.application_time, eo.time_confirmed_line, '" . $time_approved . "' FROM employee e, employee_overtime eo WHERE e.emp_id = eo.empID AND eo.id = '" . $id . "'  ";
            DB::insert(DB::raw($query));

            $query = "UPDATE employee_overtime SET status = 2, cd ='" . $signatory . "', time_approved_cd = '" . $time_approved . "'  WHERE id ='" . $id . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function get_percent($id)
    {
        $query = "SELECT day_percent from overtime_category where id = $id limit 1";
        $row = DB::select(DB::raw($query));

        return $row[0]->day_percent;
    }

    public function get_overtime_name($id)
    {
        $query = "SELECT name from overtime_category where id = $id limit 1";
        $row = DB::select(DB::raw($query));

        return $row[0]->name;
    }

    public function direct_insert_overtime($empID, $signatory, $overtime_category, $date, $days, $percent, $line_maager)
    {
        $time_start = $date;
        $time_end = $date;
        $application_time = $date;
        $time_confirmed_line = $date;
        $time_approved = $date;
        $type = 0;

        //     DB::transaction(function() use($id,$signatory, $time_approved)
        //   {
        $query = "INSERT INTO overtimes(overtimeID, empID, time_start, time_end,overtime_category, amount, linemanager, hr, application_time, confirmation_time, approval_time,days) SELECT 1, '" . $empID . "', '" . $time_start . "','" . $time_end . "','" . $overtime_category . "', (('" . $days . "') * ((e.salary/195)*('" . $percent . "')))
        AS amount,'" . $line_maager . "', '" . $signatory . "','" . $application_time . "','" . $time_confirmed_line . "', '" . $time_approved . "','" . $days . "' FROM employee e WHERE e.emp_id = '" . $empID . "'  ";
        DB::insert(DB::raw($query));

        //$query = "UPDATE employee_overtime SET status = 2, cd ='".$signatory."', time_approved_cd = '".$time_approved."'  WHERE id ='".$id."'";
        // DB::insert(DB::raw($query));

        //    });

        return true;
    }

    public function getDeletedOvertime($id)
    {
        $query = "SELECT * from overtimes where id = '" . $id . "' limit 1";
        $row = DB::select(DB::raw($query));
        return $row[0];
    }

    public function lineapproveOvertime($id, $time_approved)
    {

        $query = DB::transaction(function () use ($id, $time_approved) {
            $query = "UPDATE employee_overtime SET status = 1, time_recommended_line ='" . $time_approved . "'  WHERE id ='" . $id . "'";

            DB::insert(DB::raw($query));

            return true;
        });

        return $query;
    }

    public function hrapproveOvertime($id, $signatory, $time_approved)
    {
        DB::transaction(function () use ($id, $signatory, $time_approved) {
            $query = "UPDATE employee_overtime SET status = 3, hr ='" . $signatory . "',time_approved_hr ='" . $time_approved . "'  WHERE id ='" . $id . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }
    public function fin_approveOvertime($id, $signatory, $time_approved)
    {
        DB::transaction(function () use ($id, $signatory, $time_approved) {
            $query = "UPDATE employee_overtime SET status = 4, finance='" . $signatory . "',time_approved_fin ='" . $time_approved . "'  WHERE id ='" . $id . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function deleteOvertime($id)
    {

        DB::table('employee_overtime')->where('id', $id)->delete();
        return true;
    }
    public function deleteAllowanceCategory($id)
    {

        DB::table('allowance_categories')->where('id', $id)->delete();
        return true;
    }

    public function deleteApprovedOvertime($id)
    {

        $overtime_yenyewe =  DB::table('overtimes')->where('id', $id)->select()->first();
        $payroll_number = $overtime_yenyewe->empID;
        $changed_by = $overtime_yenyewe->hr;
        $overtime_category = $overtime_yenyewe->overtime_category;

        $overtime_name = $this->get_overtime_name($overtime_category);

        $amount = $overtime_yenyewe->amount;
        DB::table('overtimes')->where('id', $id)->delete();

        SysHelpers::FinancialLogs($payroll_number, 'Cancelled '. $overtime_name, (number_format($amount, 2)." TZS"), "0.00", 'Payroll Input');

        return true;
    }

    public function getcontractbyid($id)
    {
        $data = DB::table('contract')->where('id', $id)
            ->select(DB::raw('*'));

        return $data;
    }

    public function updatecontract($data, $id)
    {
        DB::table('contract')->where('id', $id)
            ->update($data);
        return true;
    }

    public function contract_expiration()
    {
        $query = "SELECT

(SELECT count(e.emp_id) FROM employee e, contract c WHERE e.state=1 and c.id = e.contract_type and e.contract_type = 2 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder) as TEMPO,

(SELECT count(e.emp_id) FROM employee e, contract c WHERE e.state=1 and c.id = e.contract_type and e.contract_type = 4 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder) as INTERN,

(SELECT count(emp_id) FROM employee  WHERE state=1 and (DATEDIFF(CURRENT_DATE(), birthdate)/30) >= 12*(SELECT duration from contract where id = 1)) as RETIRE";

        return DB::select(DB::raw($query));
    }

    public function contract_expiration_list()
    {
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION, e.hire_date as DATE_HIRED, e.contract_renewal_date LAST_RENEW_DATE, c.name as Contract_TYPE, c.duration as CONTRACT_DURATION, (DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30) as CONTRACT_AGE, ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) as TIME_TO_EXPIRE FROM employee e, contract c, position p, department d, (SELECT @s:=0) as s WHERE e.state=1 and e.department = d.id and e.position = p.id and c.id = e.contract_type and NOT e.contract_type = 3 AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder";

        return DB::select(DB::raw($query));
    }

    public function retire_list()
    {
        $query = "SELECT @s:=@s+1 as SNo, parent_query.* FROM (SELECT  e.emp_id as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as empName, d.name as department, p.name as position, e.hire_date as date_hired, (SELECT notify_before FROM retire WHERE id = 1) as notify_before,  e.birthdate as birthdate, (SELECT retire_age FROM retire WHERE id = 1)-((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as ages_to_retire, ((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as age FROM employee e,department d, position p  WHERE e.state=1 AND e.department = d.id and e.position = p.id) as parent_query,(SELECT @s:=0) as s WHERE ages_to_retire <= notify_before";
        return DB::select(DB::raw($query));
    }

    // public function inactive_employee1()
    // {
    //     $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ',
    //IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME,
    //IF((SELECT COUNT(empID) FROM activation_deactivation WHERE state = 2 AND current_state = 0 )>0, 1, 0) as isRequested,
    //e.last_updated as dated ,
    //      CONCAT(el.fname,' ', el.mname,' ', el.lname) as LINEMANAGER
    //       FROM employee e, employee el, department d, position p, (select @s:=0) as s
    //        WHERE p.id=e.position and d.id=e.department AND el.emp_id = e.emp_id AND e.state=0 ";

    //     return DB::select(DB::raw($query));
    // }


    public function inactive_employee1()
    {
        $result = DB::table('employee')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'position.name as POSITION',
                'department.name as DEPARTMENT',
                'employee.*',
                DB::raw("CONCAT_WS(' ', employee.fname, employee.mname, employee.lname) as NAME"),
                DB::raw('(SELECT COUNT(empid) FROM activation_deactivation WHERE state = 2 AND current_state = 0 ) > 0 as isRequested'),
                'employee.last_updated as dated',
                DB::raw("CONCAT_WS(' ', linem.fname, linem.mname, linem.lname) as LINEMANAGER")
            )
            ->join('position', 'position.id', '=', 'employee.position')
            ->join('department', 'department.id', '=', 'employee.department')
            ->join('employee as linem', 'linem.emp_id', '=', 'employee.emp_id')
            ->where('employee.state', '=', 0)
            ->get();

        return $result;
    }


    public function inactive_employee2()
    {
        $result = DB::table('employee as e')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'p.name as POSITION',
                'd.name as DEPARTMENT',
                'ad.state as log_state',
                'ad.current_state',
                'ad.author as initiator',
                'e.*',
                'ad.id as logID',
                DB::raw("CONCAT(e.fname, ' ', CASE WHEN e.mname IS NOT NULL THEN e.mname ELSE '' END, ' ', e.lname) as NAME"),
                DB::raw("(SELECT CONCAT(el.fname, ' ', el.mname, ' ', el.lname) FROM employee el WHERE el.emp_id = e.line_manager) as LINEMANAGER")
            )
            ->join('activation_deactivation as ad', 'ad.empid', '=', 'e.emp_id')
            ->join('department as d', 'd.id', '=', 'e.department')
            ->join('position as p', 'p.id', '=', 'e.position')
            ->where('e.state', '=', 3)
            ->where('ad.state', '=', 3)
            ->orderBy('ad.id', 'DESC')
            ->orderBy('ad.current_state', 'ASC')
            ->get();

        return $result;
    }

    public function inactive_employee3()
    {
        $result = DB::table('employee as e')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'p.name as POSITION',
                'd.name as DEPARTMENT',
                'ad.state as log_state',
                'ad.current_state',
                'ad.author as initiator',
                'e.*',
                'ad.id as logID',
                DB::raw("CONCAT(e.fname, ' ', CASE WHEN e.mname IS NOT NULL THEN e.mname ELSE '' END, ' ', e.lname) as NAME"),
                DB::raw("(SELECT CONCAT(el.fname, ' ', el.mname, ' ', el.lname) FROM employee el WHERE el.emp_id = e.line_manager) as LINEMANAGER")
            )
            ->join('activation_deactivation as ad', 'ad.empid', '=', 'e.emp_id')
            ->join('department as d', 'd.id', '=', 'e.department')
            ->join('position as p', 'p.id', '=', 'e.position')
            ->where('e.state', '=', 4)
            ->orderBy('ad.current_state', 'ASC')
            ->get();

        return $result;
    }


    public function updateemployeestatelog($data, $id)
    {
        $state = $data['state'];
        $empID = $data['empID'];
        $query = "UPDATE employee SET state = '" . $state . "' WHERE emp_id = '" . $empID . "'";
        DB::insert(DB::raw($query));

        DB::table('activation_deactivation')->where('id', $id)
            ->update($data);
        return true;
    }

    public function insert_user_password($data)
    {
        DB::table('user_passwords')->insert($data);
        return true;
    }

    public function employeeTransfer($data)
    {
        DB::table('transfer')->insert($data);

        return true;
    }

    public function get_comment($date)
    {
        $row = DB::table('payroll_comments')
            ->where('payroll_date', $date)
            ->select('message')
            ->first();

        return $row->message;
    }

    public function employeeTransfers()
    {
$query = "SELECT
        ROW_NUMBER() OVER (ORDER BY tr.id DESC) AS \"SNo\",
        p.name AS position_name,
        d.name AS \"department_name\",
        br.name AS \"branch_name\",
        tr.empID AS \"empID\",
        tr.*,
        CONCAT(e.fname, ' ', e.lname) AS \"empName\",
        e.approval_status
    FROM
        employee e
    JOIN
        transfer tr ON tr.empID = e.emp_id
    JOIN
        department d ON d.id = e.department
    JOIN
        position p ON p.id = e.position
    JOIN
        branch br ON br.id = CAST(e.branch AS BIGINT)
    ORDER BY
        tr.id DESC
";

        $results = DB::select(DB::raw($query));
        return $results;
    }



    public function newDepartmentTransfer($id)
{
    $row = DB::table('department')
        ->select('name')
        ->where('id', $id)
        ->first();

    if ($row) {
        return $row->name;
    } else {
        return 'Department not found'; // Or handle the case when department is not found
    }
}



public function newPositionTransfer($id)
{
    $row = DB::table('position')
        ->select('name')
        ->where('id', $id)
        ->first();

    if ($row) {
        return $row->name;
    } else {
        return 'Position not found'; // Or handle the case when position is not found
    }
}




    public function newBranchTransfer($id)
    {

        $query = "name WHERE id = '" . $id . "'";
        $row = DB::table('branch')
            ->select(DB::raw($query))
            ->first();
        return $row->name;
    }

    public function pendingSalaryTranferCheck($empID)
    {

        $row = DB::table('transfer')->where('empid', $empID)->where('status', 0)->where('parameterID', 1)->count();

        return $row;
    }

    public function pendingPositionTranferCheck($empID)
    {

        $row = DB::table('transfer')->where('empid', $empID)->where('status', 0)->where('parameterID', 2)->count();

        return $row;
    }

    public function pendingDepartmentTranferCheck($empID)
    {

        $row = DB::table('transfer')->where('empid', $empID)->where('status', 0)->where('parameterID', 3)->count();

        return $row;
    }

    public function pendingBranchTranferCheck($empID)
    {

        $row = DB::table('transfer')->where('empid', $empID)->where('status', 0)->where('parameterID', 4)->count();

        return $row;
    }

    public function getTransferInfo($transferID)
    {
        $query = "SELECT transfer.* FROM transfer WHERE id = '" . $transferID . "' ";
        return DB::select(DB::raw($query));
    }

    public function confirmTransfer($empUpdates, $transferUpdates, $empID, $transferID)
    {
        DB::transaction(function () use ($empUpdates, $transferUpdates, $empID, $transferID) {

            DB::table('employee as em')->where('em.emp_id', $empID)
                ->update($empUpdates);

            DB::table('transfer as tr')->where('tr.id', $transferID)
                ->update($transferUpdates);
        });
        return true;
    }

    public function cancelTransfer($transferID)
    {

        DB::table('transfer')->where('id', $transferID)
            ->delete('transfer');
        return true;
    }

    public function departmentAdd($departmentData)
    {
        DB::transaction(function () use ($departmentData) {
            DB::table('department')->insert($departmentData);
            //         ->insert("position", $positionData);

        });

        $query = "SELECT id as depID FROM department ORDER BY id DESC LIMIT 1";

        return DB::select(DB::raw($query));
    }

    public function updateDepartmentPosition($code, $departmentID)
{
    DB::transaction(function () use ($code, $departmentID) {
        DB::table('department')
            ->where('id', $departmentID)
            ->update(['code' => $code]);

        // If you have the information for updating positions, you can uncomment and include the position update logic as well.
        // $positionID = ...; // You need to provide the positionID
        // DB::table('position')
        //    ->where('id', $positionID)
        //    ->update(['dept_id' => $departmentID, 'dept_code' => $code]);
    });

    return true;
}


public function getdepartmentbyid($id)
{
    return DB::table('department as d')
        ->join('employee as e', 'd.hod', '=', 'e.emp_id')
        ->where('d.id', $id)
        ->select(DB::raw('CONCAT(e.fname, \' \' || COALESCE(e.mname, \'\') || \' \' || e.lname) as HOD'), 'd.*')
        ->get();
}


public function updatedepartment($data, $id)
{
    DB::table('department')->where('id', $id)->update($data);

    return true;
}


    public function getaccountability($id)
    {

        $query = "SELECT  @s:=@s+1 as SNo, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as AUTHOR,  acc.* FROM accountability acc, employee e, (SELECT @s:=0) as s  WHERE acc.author = e.emp_id and acc.position_ref ='" . $id . "'";

        return DB::select(DB::raw($query));
    }

    public function updateposition($data, $id)
    {
        DB::table('position')->where('id', $id)
            ->update($data);
        return true;
    }

    public function getpositionbyid($id)
    {
        $query = "SELECT p.*, ol.name as organization_level_name FROM position p, organization_level ol WHERE p.organization_level=ol.id AND p.id =" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function addposition($data)
    {
        // dd($data);
        DB::table('position')->insert($data);

        return true;
    }

    public function addOrganizationLevel($data)
    {
        DB::table('organization_level')->insert($data);
        return true;
    }

    public function getAllOrganizationLevel()
    {
        $query = "SELECT ol.* FROM organization_level ol";

        return DB::select(DB::raw($query));
    }

    public function organization_level_info($id)
    {
        $query = "SELECT ol.* FROM organization_level ol WHERE ol.id = " . $id . "";

        return DB::select(DB::raw($query));
    }

    public function updateOrganizationLevel($data, $id)
    {
        DB::table('organization_level')->where('id', $id)
            ->update($data);
        return true;
    }

    public function addAccountability($data)
    {
        DB::table('accountability')->insert($data);
    }

    ############################LEARNING AND DEVELOPMENT(TRAINING)#############################

    public function getskills($id)
    {

        $query = "SELECT  @s:=@s+1 as SNo, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as AUTHOR,  s.* FROM skills s, employee e, (SELECT @s:=0) as s  WHERE s.created_by = e.emp_id and s.isActive = '1' and s.position_ref ='" . $id . "'";

        return DB::select(DB::raw($query));
    }

    public function confirm_graduation($data, $id)
    {
        DB::table('confirmed_trainee')->where('id', $id)
            ->update($data);
        return true;
    }

    public function updateTrainingRequest($data, $id)
    {
        DB::table('training_application')->where('id', $id)
            ->update($data);
        return true;
    }

    public function confirmTrainingRequest($data, $requestID)
    {
        DB::transaction(function () use ($data, $requestID) {
            DB::table('training_application')->where('id', $requestID)
                ->update($data);
            $query = "INSERT INTO confirmed_trainee (skillsID, empID, cost, recommended_by, date_recommended, approved_by, date_approved, confirmed_by, date_confirmed, application_date, accepted_by, date_accepted, certificate, remarks)  SELECT skillsID, empID, sk.amount, recommended_by, date_recommended, approved_by, date_approved, confirmed_by, date_confirmed, application_date, '','2010-10-10', '','' FROM training_application, skills sk WHERE sk.id = training_application.id AND training_application.id = " . $requestID . " ";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    public function unconfirmTrainingRequest($data, $requestID)
    {
        DB::transaction(function () use ($data, $requestID) {
            DB::table('training_application')->where('id', $requestID)
                ->update($data);
            $query = "DELETE FROM confirmed_trainee WHERE empID = (SELECT empID FROM training_application WHERE id = " . $requestID . " ) AND skillsID = (SELECT skillsID FROM training_application WHERE id = " . $requestID . " ) ";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    public function deleteTrainingRequest($requestID)
    {

        $query = "DELETE FROM training_application WHERE id = '" . $requestID . "'";
        DB::insert(DB::raw($query));
        $this->audit_log("Deleted Training Request with ID =" . $requestID . " ");
        return true;
    }

    public function deleteOrganizationLevel($requestID)
    {

        $query = "DELETE FROM organization_level WHERE id = '" . $requestID . "'";
        DB::insert(DB::raw($query));
        $this->audit_log("Deleted Oraganization Level with ID =" . $requestID . " ");
        return true;
    }

    public function budget()
    {
        $query = "SELECT  @s:=@s+1 as SNo, tb.* FROM training_budget tb, (SELECT @s:=0) as s";
        return DB::select(DB::raw($query));
    }

    public function getBudget($budgetID)
    {
        $query = "SELECT  @s:=@s+1 as SNo, tb.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as primary_personel FROM training_budget tb, employee e,(SELECT @s:=0) as s WHERE tb.id =  " . $budgetID . " AND e.emp_id = tb.recommended_by";
        return DB::select(DB::raw($query));
    }

    public function accepted_applications()
    {

        $query = "SELECT @s:=@s+1 as SNo, ct.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name,   p.name as position, d.name as department FROM confirmed_trainee ct, position p, department d, (SELECT @s:=0) as s, skills sk, employee e WHERE e.emp_id = ct.empID and sk.id = ct.skillsID and e.position = p.id and e.department = d.id";
        return DB::select(DB::raw($query));
    }

    public function total_training_cost()
    {

        $query = "SUM(ct.cost) as cost WHERE ct.status = 0";
        $row = DB::table('confirmed_trainee as ct')
            ->select(DB::raw($query))
            ->first();
        return $row->cost;
    }

    public function addBudget($data)
    {
        DB::table('training_budget')->insert($data);
        $this->audit_log("Created New Training Budget");
        return true;
    }

    public function deleteBudget($budgetID)
    {

        $query = "DELETE FROM training_budget WHERE id = '" . $budgetID . "'";
        DB::insert(DB::raw($query));
        $this->audit_log("Deleted Training Budget");
        return true;
    }

    public function updateBudget($data, $budgetID)
    {
        DB::transaction(function () use ($data, $budgetID) {
            DB::table('training_budget')->where('id', $budgetID)
                ->update($data);
            $this->audit_log("Updated the Training Budget");
        });
        return true;
    }

    public function assignskills($data)
    {
        DB::table('emp_skills')->insert($data);
        return true;
    }

    public function getSkillsName($skillsID)
    {
        $query = "name  WHERE id = " . $skillsID . "";
        $row = DB::table('skills')
            ->select(DB::raw($query))
            ->first();
        return $row->name;
    }

    public function requestTraining($data)
    {
        DB::table('training_application')->insert($data);
        return true;
    }
    public function addskills($data)
    {
        DB::table('skills')->insert($data);
    }

    public function updateskills($data, $id)
    {
        DB::table('skills')->where('id', $id)
            ->update($data);
        return true;
    }

    public function skill_gap()
    {
        $query = "SELECT  @s:=@s+1 as SNo, e.emp_id,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, p.name as position, d.name as department, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory FROM  skills sk, employee e, department d, position p, (SELECT @s:=0) as s  WHERE e.position = p.id and e.department = d.id and sk.mandatory = 1 and e.position = sk.position_ref and sk.id NOT IN(SELECT es.skill_ID from emp_skills es WHERE es.empID = e.emp_id ) AND CONCAT(sk.id,'',e.emp_id) NOT IN(SELECT CONCAT(skillsID,'',empID) FROM confirmed_trainee)";

        return DB::select(DB::raw($query));
    }

    public function checkCourseExistance($course, $empID)
    {
        $query = " COUNT(es.id) as result  WHERE es.empID = " . $empID . " AND es.skill_ID  = " . $course . " ";
        $row = DB::table('emp_skills as es')
            ->select(DB::raw($query))
            ->first();
        return $row->result;
    }

    public function my_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* , sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND ta.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function other_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* , sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID  ";

        return DB::select(DB::raw($query));
    }

    public function all_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '" . $empID . "' OR ta.status IN(1,2,3,5,6))";

        return DB::select(DB::raw($query));
    }

    public function appr_conf_training_applications()
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND  ta.status IN(1,2,3,5,6) ";

        return DB::select(DB::raw($query));
    }

    public function appr_line_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '" . $empID . "' OR ta.status IN(1,2,5)) ";

        return DB::select(DB::raw($query));
    }

    public function conf_line_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ( e.line_manager = '" . $empID . "' OR ta.status IN(2,3,6)) ";

        return DB::select(DB::raw($query));
    }

    public function line_training_applications($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND e.line_manager = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function appr_training_applications()
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ta.status IN(1,2,5) ";

        return DB::select(DB::raw($query));
    }

    public function conf_training_applications()
    {
        $query = "SELECT @s:=@s+1 as SNo, ta.* ,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as trainee, sk.name as course_name, sk.amount, sk.id as courseID, sk.mandatory, sk.amount FROM  skills sk, training_application ta, employee e, (SELECT @s:=0) as s  WHERE  sk.id = ta.skillsID AND e.emp_id = ta.empID AND ta.status IN(2,3,6) ";

        return DB::select(DB::raw($query));
    }

    public function all_skills($empID)
{
    $query = "SELECT s.*
              FROM skills s
              WHERE s.id NOT IN (SELECT skill_ID FROM emp_skills WHERE empID = '" . $empID . "')
                AND s.id NOT IN (SELECT skill_ID FROM emp_skills WHERE empID = '" . $empID . "')
                AND s.id NOT IN (SELECT skillsID FROM training_application WHERE empID = '" . $empID . "')";

    return DB::select(DB::raw($query));
}


public function skills_have($id)
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, es.\"empid\", es.\"skill_ID\", s.name as NAME
              FROM emp_skills es
              JOIN skills s ON es.\"skill_ID\" = s.id
              WHERE es.\"empid\" = '" . $id . "'";

    return DB::select(DB::raw($query));
}


public function requested_skills($empID)
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, sk.*, ta.status as request_status, ta.*
              FROM skills sk
              JOIN training_application ta ON sk.id = ta.\"skillsID\"
              WHERE ta.\"empid\" = '" . $empID . "'";

    return DB::select(DB::raw($query));
}

public function skills_missing($empID)
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, sk.*,
                     CASE WHEN (SELECT COUNT(\"skillsID\") FROM training_application WHERE \"skillsID\"::text = sk.id::text AND \"empid\" = '" . $empID . "') > 0
                          THEN (SELECT status FROM training_application WHERE \"empid\"::text = sk.id::text AND \"empid\" = '" . $empID . "')
                          ELSE 9
                     END AS status
              FROM skills sk
              WHERE sk.position_ref = (SELECT position FROM employee WHERE emp_id ='" . $empID . "')
                AND sk.id NOT IN (SELECT \"skill_ID\" FROM emp_skills WHERE \"empid\" = '" . $empID . "')";

    return DB::select(DB::raw($query));
}

    ##############################END LEARNING AND DEVELOPMENT(TRAINING)#############################

    public function getEmployeeName_and_email($empID)
    {
        $query = "CONCAT(fname,' ', mname,' ', lname) as name, email,birthdate  WHERE emp_id = '" . $empID . "'  ";
        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->count();

        if ($row > 0) {
            $query = "SELECT CONCAT(fname,' ', mname,' ', lname) as name, email,birthdate from employee  WHERE emp_id = '" . $empID . "'  ";
            return DB::select(DB::raw($query));
        } else {
            return false;
        }
    }

    public function getEmployeeNameByemail($email)
    {
        $query = "CONCAT(fname,' ', mname,' ', lname) as name, email,emp_id,birthdate,account_no  WHERE state != 4 and email = '" . $email . "'  ";
        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->count();
        if ($row > 0) {
            $query = "SELECT CONCAT(fname,' ', mname,' ', lname) as name, email,emp_id,birthdate,account_no FROM  employee WHERE state != 4 and email = '" . $email . "'  ";
            return DB::select(DB::raw($query));
        } else {
            return false;
        }
    }

    public function userprofile($empID)
    {


        $query = "SELECT
        e.*,
        bank.name as bankName,
        ctry.description as country,
        b.name as branch_name,
        bb.name as bankBranch,
        d.name as deptname,
        c.name as CONTRACT,
        p.name as pName,
        (
            SELECT CONCAT(fname,' ', mname,' ', lname)
            FROM employee
            WHERE emp_id = e.line_manager
        ) as LINEMANAGER
    FROM
        employee e
        JOIN department d ON d.id = e.department
        JOIN contract c ON e.contract_type = CAST(c.item_code AS character varying)
        JOIN country ctry ON CAST(ctry.item_code  AS character varying)= e.nationality
        JOIN position p ON p.id = CAST(e.position AS BIGINT)
        JOIN bank ON bank.id = CAST(e.bank AS BIGINT)
        JOIN branch b ON b.id = CAST(e.branch AS BIGINT)
        JOIN bank_branch bb ON e.bank_branch = bb.id
    WHERE
        e.emp_id = '" . $empID . "'
";

        $row = DB::select(DB::raw($query));

// return $row;


    }

    public function shift()
    {
        $query = "SELECT
                    shift.*,
                    TO_CHAR(start_time, 'HH24:MI') AS STARTtime,
                    TO_CHAR(end_time, 'HH24:MI') AS ENDtime
                FROM
                    shift";


       return DB::select(DB::raw($query));
    }

    public function getLinemanager($id)
    {
        $query = "SELECT CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as LINEMANAGER, FROM employee e, WHERE d.id=e.department and p.id=e.position and e.emp_id ='" . $id . "'";
        return DB::select(DB::raw($query));
    }

    public function getkin($id)
    {
        //$this->load->database();
        $data = DB::table('next_of_kin')->where('employee_fk', $id)
            ->select('*');
        return $data->get();
    }

    // public function getproperty($id)
    // {
    //     $query = "SELECT  @s:=@s+1 as SNo, cp.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as PROVIDER FROM employee e, company_property cp, (SELECT @s:=0) as s WHERE cp.given_by =e.emp_id and cp.given_to='" . $id . "' and cp.isActive = 1";
    //     return DB::select(DB::raw($query));
    // }

    public function getproperty($id)
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, cp.*, CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as PROVIDER
              FROM employee e
              JOIN company_property cp ON cp.given_by = e.emp_id
              WHERE cp.given_to = '" . $id . "' AND cp.\"isActive\" = 1";

    return DB::select(DB::raw($query));
}


public function getpropertyexit($id)
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, cp.*, CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as PROVIDER
              FROM employee e
              JOIN company_property cp ON cp.given_by = e.emp_id
              WHERE cp.given_to = '" . $id . "'";

    return DB::select(DB::raw($query));
}

    public function getactive_properties($id)
    {
        $query = "SELECT COUNT(cp.id) as \"ACTIVE_PROPERTIES\" FROM company_property cp WHERE cp.\"isActive\"=1 and cp.given_to='" . $id . "'";
        return DB::select(DB::raw($query));
    }

    public function employee_exit($data)
    {
        $empID = $data['empID'];
        $initiator = $data['initiator'];
        $reason = $data['reason'];
        $date_confirmed = $data['date_confirmed'];
        $confirmed_by = $data['confirmed_by'];
        $exit_date = $data['exit_date'];

        $query = "INSERT INTO exit_list (empID, initiator, reason, date_confirmed,confirmed_by, exit_date) VALUES ('" . $empID . "', '" . $initiator . "', '" . $reason . "','" . $date_confirmed . "','" . $confirmed_by . "','" . $exit_date . "')";
        DB::insert(DB::raw($query));
        //            ->insert("exit_list", $data);
        //update the employee table state
        $query = "UPDATE employee SET state = '3', contract_end = '" . $exit_date . "' WHERE emp_id = '" . $empID . "'";
        DB::insert(DB::raw($query));
    }

    #############################LOANS AND DEDUCTIONS####################################

    public function deduction()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, d.*
        FROM (
            SELECT * FROM deduction
            WHERE is_active = 1 AND id NOT IN (7, 8)
        ) d
        ';

        return DB::select(DB::raw($query));
    }

    public function overtime_allowances()
    {
        $query = 'SELECT oc.* FROM overtime_category oc';

        return DB::select(DB::raw($query));
    }

    public function updatededuction($data, $id)
    {
        DB::table('deduction')->where('id', $id)
            ->update($data);
        return true;
    }

    // public function unpaid_leave_employee()
    // {

    //     $query = "SELECT e.emp_id,ul.status,ul.start_date,ul.end_date,CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME,ul.reason FROM employee e,unpaid_leave ul where e.emp_id=ul.empID  AND ul.state=0";

    //     return DB::select(DB::raw($query));
    // }

    public function unpaid_leave_employee()
    {
        return $this->select('employee.emp_id', 'unpaid_leave.status', 'unpaid_leave.start_date', 'unpaid_leave.end_date')
            ->selectRaw('CONCAT(employee.fname, \' \', COALESCE(employee.mname, \' \', \'\'), \' \', employee.lname) as name')
            ->addSelect('unpaid_leave.reason')
            ->from('employee as employee')
            ->join('unpaid_leave as unpaid_leave', 'employee.emp_id', '=', 'unpaid_leave.empid')
            ->where('unpaid_leave.state', '=', 0)
            ->get();
    }

    public function confirm_upaid_leave($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('employee')->where('emp_id', $id)->update(['unpaid_leave' => 0]);

            DB::table('unpaid_leave')->where('empid', $id)->update(['status' => 1]);
        });

        return true;
    }

    public function end_upaid_leave($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('employee')->where('emp_id', $id)->update(['unpaid_leave' => 1]);

            DB::table('unpaid_leave')->where('empid', $id)->update(['state' => 1]);
        });

        return true;
    }

    public function save_unpaid_leave($data)
    {
        $data['state'] = 0;

        DB::transaction(function () use ($data) {
            // DB::table('employee')->where('emp_id',$data['empID'])->update(['unpaid_leave'=>0]);

            DB::table('unpaid_leave')->insert($data);
        });

        return true;
    }
    public function updatededuction_non_statutory_deduction($data, $id)
    {
        DB::table('deductions')->where('id', $id)
            ->delete();
        return true;
    }

    public function addDeduction($data)
    {
        DB::table('deductions')->insert($data);
        return true;
    }

    public function getDeductionById($deductionID)
    {
        $query = 'SELECT ded.name as name,  ded.* FROM deductions ded WHERE  ded.id =' . $deductionID . '';

        return DB::select(DB::raw($query));
    }

    public function getcommon_deduction($id)
    {
        $query = "SELECT d.* FROM deduction d WHERE id = " . $id . " ";

        return DB::select(DB::raw($query));
    }

    public function getMeaslById($deductionID)
    {
        $query = 'SELECT * FROM meals_deduction  WHERE id =' . $deductionID . '';

        return DB::select(DB::raw($query));
    }

    //UPDATE DEDUCTIONS

    public function updatePension($data, $id)
    {
        DB::table('pension_fund')->where('id', $id)
            ->update($data);
        return true;
    }

    public function updateDeductions($updates, $deductionID)
    {
        DB::table('deductions')->where('id', $deductionID)
            ->update($updates);

        return true;
    }

    public function updateCommonDeductions($data, $id)
    {
        DB::table('deduction')->where('id', $id)
            ->update($data);

        return true;
    }

    public function updateMeals($updates, $deductionID)
    {
        DB::table('meals_deduction')->where('id', $deductionID)->update($updates);
        return true;
    }

    public function get_deduction_group_in($deduction)
    {
        $query = "SELECT DISTINCT  g.name as NAME, g.id as id FROM groups g, emp_deductions ed  WHERE g.id = ed.group_name and ed.deduction = " . $deduction . "";
        return DB::select(DB::raw($query));
    }

    public function assign_deduction($data)
    {
        DB::table('emp_deductions')->insert($data);
        return true;
    }

    public function remove_individual_deduction($empID, $deductionID)
    {
        DB::table('emp_deductions')->where('empid', $empID)
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

    public function get_deduction_members($deduction, $group)
    {
        $query = "SELECT empID from employee_group WHERE group_name = " . $group . " and empID NOT IN (SELECT empID from emp_deductions where deduction = " . $deduction . ")";

        return DB::select(DB::raw($query));
    }

    public function employee_deduction($deduction)
    {
        $query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME FROM employee e WHERE e.state = 1 AND  e.emp_id NOT IN (SELECT empID from emp_deductions WHERE deduction = " . $deduction . " AND group_name = 0 ) ";
        return DB::select(DB::raw($query));
    }

    public function deleteLog($id)
    {
        DB::table('financial_logs')->where('payrollno', $id)->delete();

        return true;
    }

    public function deduction_membersCount($deduction)
    {
        $query = "SELECT COUNT(DISTINCT ed.empID) members FROM  emp_deductions ed WHERE ed.deduction = " . $deduction . "  ";

        $row = DB::select(DB::raw($query));

        return $row[0]->members;
    }

    public function deduction_individual_employee($deduction)
    {
        $query = "SELECT @s:=@s+1 SNo, e.emp_id as empID,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME FROM employee e, emp_deductions ed, (SELECT @s:=0) as s WHERE e.emp_id = ed.empID and ed.group_name = 0 and ed.deduction = " . $deduction . "  ";

        return DB::select(DB::raw($query));
    }

    public function deduction_customgroup($deductionID)
    {
        $query = "SELECT * FROM groups WHERE id NOT IN(SELECT group_name FROM emp_deductions WHERE deduction =  " . $deductionID . " ) AND type = 1 ";

        return DB::select(DB::raw($query));
    }

    #############################DEDUCTIONS####################################

    public function allowance()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS "SNo", sub.*
        FROM (
            SELECT * FROM allowances WHERE state = 1
        ) sub
        ';

        return DB::select(DB::raw($query));
    }

    public function allowance_category()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, sub.*
        FROM (
            SELECT * FROM allowance_categories
        ) sub
        ';

        return DB::select(DB::raw($query));
    }


    public function addToBonus($data)
    {
        $result = DB::table("bonus")->insert($data);
        return $result;
    }

    public function updateBonus($data, $id)
    {
        DB::table('bonus')->where('id', $id)
            ->update($data);
        return true;
    }
    public function deleteBonus($id)
    {

        DB::table('bonus')->where('id', $id)
            ->delete();
        return true;
    }

    public function addBonusTag($data)
    {
        DB::table('bonus_tags')->insert($data);
        return true;
    }

    public function deductions()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, ded.*
        FROM deductions ded;
         ';

        return DB::select(DB::raw($query));
    }

    public function pension_fund()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, pf.*
        FROM pension_fund pf;
        ';

        return DB::select(DB::raw($query));
    }

    public function getPensionById($deductionID)
    {
        $query = 'SELECT  pf.* FROM pension_fund pf WHERE pf.id = ' . $deductionID . '';

        return DB::select(DB::raw($query));
    }

    public function meals_deduction()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, sub.*
        FROM (
            SELECT * FROM meals_deduction
        ) sub
        ';

        return DB::select(DB::raw($query));
    }

    public function getallowancebyid($id)
    {


        $query = "SELECT * FROM allowances WHERE id =" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function get_allowance_members($allowance, $group)
    {
        $query = "SELECT empID from employee_group WHERE group_name = " . $group . " and empID NOT IN (SELECT empID from emp_allowances where allowance = " . $allowance . ")";

        return DB::select(DB::raw($query));
    }

    public function get_currencies()
    {
        $data = DB::table('currencies')->select('*')->get();

        return $data;
    }

    public function get_rate($currency)
    {
        $row = DB::table('currencies')->where('currency', $currency)->select('rate')->first();

        return $row->rate;
    }

    public function get_allowance_group_in($allowance)
    {
        $query = "SELECT DISTINCT  g.name as NAME, g.id as id FROM groups g, emp_allowances ea  WHERE g.id = ea.group_name and ea.group_name != 0 and ea.allowance = " . $allowance . "";

        return DB::select(DB::raw($query));
    }

    public function get_individual_employee($allowance)
    {
        $query = "SELECT ROW_NUMBER() OVER () AS \"SNo\", e.emp_id AS \"empID\", CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS \"NAME\", ea.* FROM employee e
        JOIN emp_allowances ea ON e.emp_id = ea.\"empid\" WHERE ea.group_name = 0 AND ea.allowance = :allowance";

        return DB::select(DB::raw($query), ['allowance' => $allowance]);
    }

    public function allowance_membersCount($allowance)
    {
        $query = "select COUNT(DISTINCT ea.empID) members from emp_allowances as ea,employee e  WHERE e.emp_id=ea.empID AND e.state=1 AND ea.allowance = " . $allowance . "  ";
        $row = DB::select(DB::raw($query));
        return $row[0]->members;
    }

    public function allowance_groupsCount($allowance)
    {
        $query = "COUNT(ea.id) members FROM  emp_allowances ea WHERE ea.allowance = " . $allowance . "  ";
        $row = DB::table('emp_allowances as ea')
            ->select(DB::raw($query))
            ->first();
        return $row->members;
    }

    public function get_overtime($normalDays, $publicDays, $employeeID)
    {
        $row = DB::table('employee')->where('emp_id', $employeeID)->select('salary')->first();
        $normal_days = ($row->salary / 176) * 1.5 * $normalDays;
        $public_overtime = ($row->salary / 176) * 2.0 * $publicDays;

        $total = $normal_days + $public_overtime;

        return $total;
    }
    public function get_pensionable_amount($salaryEnrollment, $leavePay, $arrears, $overtime_amount, $emp_id)
    {

        $pesionable_amount = $this->get_pensionable_allowance($emp_id);
        $total_amount = $salaryEnrollment + $leavePay + $arrears + $overtime_amount + $pesionable_amount;

        return $total_amount;
    }
    public function get_pension_employee($salaryEnrollment, $serevancePay, $exgracia, $leavePay, $noticePay, $arrears, $overtime_amount, $emp_id, $tellerAllowance)
    {

        //$pesionable_amount =  $this->get_pensionable_allowance($emp_id);
        $total_amount = $salaryEnrollment + $leavePay + $arrears + $overtime_amount + $serevancePay + $exgracia + $noticePay+$tellerAllowance;
        // + $pesionable_amount;

        $query = "SELECT pf.amount_employee FROM employee e,pension_fund pf where e.pension_fund = pf.id AND  e.emp_id =" . $emp_id . " ";
        $row = DB::select(DB::raw($query));
        $rate = $row[0]->amount_employee;

        return $total_amount * $rate;
    }

    public function get_pension_employer($salaryEnrollment, $serevancePay, $exgracia, $leavePay, $noticePay, $arrears, $overtime_amount ,$emp_id, $tellerAllowance)
    {

        //$pesionable_amount =  $this->get_pensionable_allowance($emp_id);
        $total_amount = $salaryEnrollment + $leavePay + $arrears + $overtime_amount + $serevancePay + $exgracia + $noticePay +$tellerAllowance;


            $query = "SELECT pf.amount_employer
        FROM employee e
        JOIN pension_fund pf ON e.pension_fund = pf.id
        WHERE e.emp_id = :emp_id
        ";


       $row = DB::select($query, ['emp_id' => $emp_id]);




        $rate = $row[0]->amount_employer;

        return $total_amount * $rate;
    }

    public function get_pensionable_allowance($emp_id)
    {

        $query = "SELECT IF(ea.mode =1,SUM(ea.amount),SUM(ea.percent*ea.amount)) as total_allowance  FROM employee e,emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND type=0 AND e.emp_id =" . $emp_id . " AND a.pensionable='Yes'  AND a.state= 1 GROUP BY ea.empID";

        $row = DB::select(DB::raw($query));

        return !empty($row) ? $row[0]->total_allowance : 0;
    }

    public function get_all_allowance($emp_id)
    {

        $query = "SELECT IF(ea.mode =1,SUM(ea.amount),SUM(ea.percent*ea.amount)) as total_allowance  FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND type=0 AND e.emp_id =" . $emp_id . "  AND a.state= 1 GROUP BY ea.empID";

        $row = DB::select(DB::raw($query));

        return $row[0]->total_allowance;
    }

    public function get_allowance_names_for_employee($empID)
    {

        $query = "SELECT a.id, a.name, ea.amount
        FROM emp_allowances ea
        JOIN allowances a ON a.id = ea.allowance
        WHERE ea.empID = {$empID}";

        $rows = DB::select(DB::raw($query));
        return $rows;
    }


    public function check_termination_payroll_date($date)
    {

        $row = DB::table('payroll_logs')->where('payroll_date', 'like', '%' . $date . '%')->select('id');

        if ($row->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_leave_balance($empID, $today)
    {
        $query = "SELECT  IF( (SELECT COUNT(id)  FROM leaves WHERE nature=1 AND empID = '" . $empID . "')=0, 0, (SELECT SUM(days)  FROM leaves WHERE nature=1 and empID = '" . $empID . "' GROUP BY nature)) as days_spent, DATEDIFF('" . $today . "','" . $hireDate . "') as days_accrued limit 1";
        $row = DB::select(DB::raw($query));
        $spent = $row[0]->days_spent;
        $accrued = $row[0]->days_accrued;

        $accrual = 7 * $accrued / 90;
        $maximum_days = $accrual - $spent;
        return $maximum_days;
    }

    public function get_actual_basic_salary($empID)
    {
        //   $query = "SELECT e.salary from employee e where e.emp_id = " . $empID . "";
        $row = DB::table('employee')->where('emp_id', $empID)->select('salary')->first();

        return $row->salary;
    }

    public function get_employee_salary($empID, $termination_date, $termination_day)
    {
        $days = intval(date('t', strtotime($termination_date)));

        $query = "
        SELECT
        IF((month(e.hire_date) = month('" . $termination_date . "')) AND (year(e.hire_date) = year('" . $termination_date . "'))
        ,
          ((" . $termination_day . " - day(e.hire_date)+1)*e.salary/30)

          ,e.salary) as salary
          from employee e where e.emp_id = " . $empID . "";

        $row = DB::select(DB::raw($query));
        $salary = $row[0]->salary;

        return $salary;
    }

    public function get_leave_allowance($empID, $termination_date, $january_date)
    {

        $query = "
SELECT
IF(
  (YEAR('" . $termination_date . "') = YEAR(e.hire_date)),
(
  ((DATEDIFF('" . $termination_date . "',e.hire_date)+1)/365)*e.salary
)
  ,

 (
    ((DATEDIFF('" . $termination_date . "','" . $january_date . "')+1)/365)*e.salary
 )

  ) as leave_allowance
  from employee e where e.emp_id = " . $empID . "";

        $leave_allowance = DB::select(DB::raw($query))[0]->leave_allowance;

        return $leave_allowance;
    }

    public function delete_logs($id)
    {

        DB::table('financial_logs')->where('payrollno', $id)->where('input_screen', 'Termination')->delete();

        $query = "UPDATE employee set state = 1 where emp_id = '" . $id . "'";
        DB::insert(DB::raw($query));

        return true;
    }

    public function assign_allowance($data)
    {
        DB::table('emp_allowances')->insert($data);
        return true;
    }

    public function employee_allowance($allowance)
    {
        $query = "SELECT e.emp_id as \"empID\", CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as \"NAME\" FROM employee e WHERE e.state = 1 AND e.emp_id NOT IN ( SELECT empid FROM emp_allowances WHERE allowance = :allowance AND group_name = 0)";

        return DB::select(DB::raw($query), ['allowance' => $allowance]);
    }

    public function employeesrole($id)
    {

        $query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME FROM employee e WHERE e.emp_id NOT IN (SELECT userID from emp_role where role = " . $id . " and group_name = 0 ) ";
        return DB::select(DB::raw($query));
    }

    public function get_rolegroupmembers($group)
    {
        $query = "SELECT empID from employee_group WHERE group_name = " . $group . "";

        return DB::select(DB::raw($query));
    }

    //

    public function customgroup($allowanceID)
    {
        $query = "SELECT * FROM groups WHERE id NOT IN(SELECT group_name FROM emp_allowances WHERE allowance =  " . $allowanceID . " ) AND type = 1 ";

        return DB::select(DB::raw($query));
    }

    public function addAllowance($data)
    {
        DB::table('allowances')->insert($data);
        return true;
    }
    public function addAllowanceCategory($data)
    {
        DB::table('allowance_categories')->insert($data);
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

    public function overtimeCategory()
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
    public function updateAllowaceCategory($data, $id)
    {
        DB::table('allowance_categories')->where('id', $id)
            ->update($data);
        return true;
    }

    public function OvertimeCategoryInfo($id)
    {
        $query = "SELECT oc.* FROM overtime_category oc WHERE oc.id =" . $id . "";

        return DB::select(DB::raw($query));
    }
    public function AllowanceCategoryInfo($id)
    {
        $query = "SELECT ac.* FROM allowance_categories ac WHERE ac.id =" . $id . "";

        return DB::select(DB::raw($query));
    }

    #############################PAYE####################################

    public function paye()
    {
        $query = 'SELECT ROW_NUMBER() OVER (ORDER BY id) AS SNo, p.*
        FROM paye p
        ';

        return DB::select(DB::raw($query));
    }

    public function addpaye($data)
    {
        DB::table('paye')->insert($data);
        return true;
    }

    public function updatepaye($data, $id)
    {
        DB::table('paye')->where('id', $id)
            ->update($data);
        return true;
    }

    public function getpayebyid($id)
    {
        $data = DB::table('paye')->where('id', $id);

        return $data->get();
    }

    #############################PAYE####################################

    public function contract_expire_list()
    {
        $query = "SELECT e.emp_id as IDs  from employee e, contract c where (DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)) > (c.duration*365) and e.contract_type = c.id ";

        return DB::select(DB::raw($query));
    }

    public function update_employee_termination($id)
    {
        $termination = Termination::where('id', $id)->first();

        $datalog = array(
            'state' => 4,
            'current_state' => 4,
            'empID' => $termination->employeeID,
            'author' => session('emp_id'),
        );

        $this->employeestatelog($datalog);

        //update employee status
        DB::table('employee')->where('emp_id', $termination->employeeID)->update(['state' => 4]);

        //termination date
        SysHelpers::FinancialLogs($termination->employeeID, 'Termination Date', '0.00', $termination->terminationDate, 'Termination');
        //reason for termination
        SysHelpers::FinancialLogs($termination->employeeID, 'Reason For Termination', '0.00', $termination->reason, 'Termination');
        //salary
        SysHelpers::FinancialLogs($termination->employeeID, 'Salary', number_format($termination->actual_salary, 2). ' TZS', number_format($termination->salaryEnrollment, 2). ' TZS', 'Termination');
        //overtimes
        if ($termination->normalDays != 0) {
            // SysHelpers::FinancialLogs($termination->employeeID,'N-Overtime', 0.00 ,number_format($termination->normalDays,2), 'Termination');
            SysHelpers::FinancialLogs($termination->employeeID, 'Normal Days Overtime', 0.00, number_format($termination->normal_days_overtime_amount, 2). ' TZS', 'Termination');
        }
        if ($termination->publicDays != 0) {
            //SysHelpers::FinancialLogs($termination->employeeID,'S-Overtime', 0.00 ,number_format($termination->publicDays,2), 'Termination');
            SysHelpers::FinancialLogs($termination->publicDays, 'Sunday Overtime', 0.00, number_format($termination->public_overtime_amount, 2). ' TZS', 'Termination');
        }
        if ($termination->noticePay != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Notice Pay', 0.00, number_format($termination->noticePay, 2). ' TZS', 'Termination');
        }

        if ($termination->leavePay != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Leave Pay', 0.00, number_format($termination->leavePay, 2). ' TZS', 'Termination');
        }

        if ($termination->houseAllowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'House Allowance', 0.00, number_format($termination->houseAllowance, 2). ' TZS', 'Termination');
        }

        if ($termination->utilityAllowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Utility Allowance', 0.00, number_format($termination->utilityAllowance, 2). ' TZS', 'Termination');
        }

        if ($termination->leaveAllowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Leave Allowance', 0.00, number_format($termination->leaveAllowance, 2). ' TZS', 'Termination');
        }

        if ($termination->nightshift_allowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Night Shift Allowance', 0.00, number_format($termination->nightshift_allowance, 2). ' TZS', 'Termination');
        }

        if ($termination->transport_allowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Night Shift Allowance', 0.00, number_format($termination->transport_allowance, 2). ' TZS', 'Termination');
        }

        if ($termination->tellerAllowance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Teler Allowance', 0.00, number_format($termination->tellerAllowance, 2). ' TZS', 'Termination');
        }

        if ($termination->leaveStand != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Leave Stand', 0.00, number_format($termination->leaveStand, 2). ' TZS', 'Termination');
        }

        if ($termination->arrears != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Arrears', 0.00, number_format($termination->arrears, 2). ' TZS', 'Termination');
        }

        if ($termination->longServing != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'LSA', 0.00, number_format($termination->longServing, 2). ' TZS', 'Termination');
        }

        if ($termination->loanBalance != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Loan Balance', 0.00, number_format($termination->loanBalance, 2). ' TZS', 'Termination');
        }

        if ($termination->otherPayments != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Other Payments', 0.00, number_format($termination->otherPayments, 2). ' TZS', 'Termination');
        }

        if ($termination->otherDeductions != 0) {
            SysHelpers::FinancialLogs($termination->employeeID, 'Other Deductions', 0.00, number_format($termination->otherDeductions, 2). ' TZS', 'Termination');
        }

        DB::table('employee')->where('emp_id', $termination->employeeID)->update(['state' => 4]);

        return true;
    }

    public function get_deduction_rate()
    {
        $row = DB::table('deduction')->select('rate_employer')->where('id', 2)->get();

        $row2 = DB::table('deduction')->select('rate_employer')->where('id', 4)->get();

        $data['wcf'] = $row[0]->rate_employer;
        $data['sdl'] = $row2[0]->rate_employer;

        return $data;
    }

    public function terminate_contract($id)
    {
        $query = "UPDATE employee SET state = 0 WHERE emp_id ='" . $id . "'";
        DB::insert(DB::raw($query));
        return true;
    }

    public function payroll_month_list()
    {
        $query = 'SELECT DISTINCT payroll_date FROM payroll_logs ORDER BY payroll_date DESC';
        return DB::select(DB::raw($query));
    }
    public function payroll_month_list2($empId)
    {
        $query = 'SELECT DISTINCT payroll_date FROM payroll_logs WHERE empID = '.$empId.' ORDER BY payroll_date DESC';
        return DB::select(DB::raw($query));
    }

    public function payroll_year_list()
    {
        $query = "SELECT DISTINCT TO_CHAR(payroll_date, 'YYYY') AS year 
        FROM payroll_logs 
        ORDER BY TO_CHAR(payroll_date, 'YYYY') DESC";
                return DB::select(DB::raw($query));
    }

    public function updateHESLB($date)
    {
        $query = "UPDATE loan SET paid = IF(((paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID)) > amount), amount, (paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID))),

amount_last_paid = IF(((paid+(SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID)) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID))),

last_paid_date='" . $date . "' WHERE  state = 1 and type = 3";
        DB::insert(DB::raw($query));

        return true;
    }

    //START RUN PAYROLL FOR SCANIA

    public function payrollcheck($date)
    {
        $query = " id  WHERE payroll_date like  '%" . $date . "%' ";
        $row = DB::table('payroll_logs')
            ->select(DB::raw($query))->count();
        return $row();
    }

    public function run_payroll($payroll_date, $payroll_month)
    {

        DB::transaction(function () use ($payroll_date, $payroll_month) {

            //INSERT ALLOWANCES
            $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

    SELECT ea.empID AS empID, a.name AS description,

    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS amount,

     '" . $payroll_date . "' AS payment_date

    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance";
            DB::insert(DB::raw($query));
            //INSERT BONUS
            $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

    SELECT b.empID AS empID, 'Monthly Bonus' AS description,

    'Fixed Amount' AS policy,

    SUM(b.amount) AS amount,

    '" . $payroll_date . "' AS payment_date

    FROM employee e,  bonus b WHERE e.emp_id =  b.empID  AND b.state = 1 GROUP BY b.empID";
            DB::insert(DB::raw($query));
            //INSERT OVERTIME
            $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)
    SELECT o.empID AS empID, 'Overtimes' AS description,

    'Fixed Amount' AS policy,

     SUM(o.amount) AS amount,

    '" . $payroll_date . "' AS payment_date

    FROM  employee e, overtimes o WHERE  o.duedate <= '" . $payroll_date . "' AND o.empID =  e.emp_id GROUP BY o.empID";
            DB::insert(DB::raw($query));

            //UPDATE SALARY ADVANCE.
            $query = " UPDATE loan SET paid = IF(((paid+deduction_amount) > amount), amount, (paid+deduction_amount)),
	amount_last_paid = IF(((paid+deduction_amount) > amount), amount-paid, ((paid+deduction_amount))),
	last_paid_date = '" . $payroll_date . "' WHERE  state = 1 AND NOT type = 3";
            DB::insert(DB::raw($query));
            //UPDATE LOAN BOARD
            $query = " UPDATE loan SET paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount, (paid+ (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
	amount_last_paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
	last_paid_date = '" . $payroll_date . "' WHERE  state = 1 AND type = 3";
            DB::insert(DB::raw($query));
            //INSERT LOAN LOGS
            $query = "INSERT into loan_logs(loanID, paid, remained, payment_date) SELECT id, amount_last_paid, amount-paid, last_paid_date FROM loan WHERE state = 1";
            DB::insert(DB::raw($query));
            //INSERT DEDUCTION LOGS
            $query = "INSERT INTO deduction_logs(empID, description, policy, paid, payment_date)

    SELECT ed.empID as empID, dt.name as description,

    IF( (d.mode = 1), 'Fixed Amount', CONCAT(100*d.percent,'% ( Basic Salary )') ) as policy,

    IF( (d.mode = 1), d.amount, (d.percent*e.salary) ) as paid,

    '" . $payroll_date . "' as payment_date

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

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

     ) /*End Allowances and Bonuses*/ AS  allowances,

    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  ) AS pension_employee,

    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employer), (pf.amount_employer*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  ) AS pension_employer,


    (
    ( SELECT excess_added FROM paye WHERE maximum >
    (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) )

    +

    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
    ( e.salary -

     /*pension*/
     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)))  )
     /*End pension*/

    ) +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/
     )/*End Taxable Amount*/))) )


    ) AS taxdue,



    IF(((e.salary +
    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/ )<(SELECT minimum_gross FROM meals_deduction WHERE id = 1)), (SELECT minimum_payment FROM meals_deduction WHERE id = 1), (SELECT maximum_payment FROM meals_deduction WHERE id = 1)) AS meals,



     e.department AS department,

     e.position AS position,

     e.branch AS branch,

     e.pension_fund AS pension_fund,

     e.\"pf_membership_no\" as membership_no,

     e.bank AS bank,
     e.bank_branch AS bank_branch,
     e.account_no AS account_no,

    ((SELECT rate_employer from deduction where id=4 )*(e.salary +

    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/  )) as sdl,

    ((SELECT rate_employer from deduction where id=2 )*(e.salary +

    /*all Allowances and Bonuses*/
    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate like '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE o.duedate LIKE '%" . $payroll_month . "%' AND o.empID =  e.emp_id GROUP BY o.empID), 0) +

    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)

    /*End all Allowances and Bonuses*/  )) as wcf,

     '" . $payroll_date . "' as payroll_date
     FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state = 1";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    //END RUN PAYROLL FOR SCANIA

    public function employee_hire_date($empID)
    {
        $query = "SELECT hire_date from employee  WHERE emp_id='" . $empID . "'";
        $row = DB::select(DB::raw($query));

        return $row[0]->hire_date;
    }

    public function get_max_salary_advance($empID)
    {
        $query = "SELECT (rate_employee*(SELECT salary FROM employee WHERE emp_id = '" . $empID . "')) as margin FROM deduction WHERE id = 7 limit 1";

        $query = DB::select(DB::raw($query));
        return isset($query[0]->margin) ? $query[0]->margin : 0;
    }

    // public function mysalary_advance($empID)
    // {
    //     $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.empID = '" . $empID . "' ORDER BY la.id DESC ";
    //     return DB::select(DB::raw($query));
    // }

    public function mysalary_advance($empID)
    {
        $result = DB::table('loan_application')
            ->join('employee', 'loan_application.empid', '=', 'employee.emp_id')
            ->join('position', 'employee.position', '=', 'position.id')
            ->join('department', 'employee.department', '=', 'department.id')
            ->join('loan_type', 'loan_application.type', '=', DB::raw('CAST(loan_type.id AS VARCHAR)'))
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'loan_application.empid',
                'loan_type.name as TYPE',
                'loan_application.*',
                DB::raw("CONCAT(employee.fname, ' ', CASE WHEN employee.mname IS NOT NULL THEN employee.mname ELSE '' END, ' ', employee.lname) as NAME"),
                'department.name as DEPARTMENT',
                'position.name as POSITION'
            )
            ->where('loan_application.empid', '=', $empID)
            ->orderBy('loan_application.id', 'DESC')
            ->get();

        return $result;
    }



    // public function salary_advance()
    // {
    //     $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id ORDER BY la.id DESC ";

    //     return DB::select(DB::raw($query));
    // }

    // public function salary_advance()
    // {

    //     return $this->selectRaw('ROW_NUMBER() OVER () as "SNo", la.empid, loan_types.name as \"TYPE\", la.*, CONCAT(employee.fname, \' \', COALESCE(employee.mname, \' \', \'\'), \' \', employee.lname) as "NAME", departments.name as "DEPARTMENT", positions.name as "POSITION"')
    //     ->from('loan_application as la')
    //     ->join('employee as employee', 'la.empid', '=', 'employee.emp_id')
    //     ->join('position as positions', 'employee.position', '=', 'positions.id')
    //     ->join('department as departments', 'employee.department', '=', 'departments.id')
    //     ->join('loan_type as loan_types', 'la.type', '=', DB::raw('CAST("loan_types".id AS text)')) // Explicit cast to INTEGER
    //     ->orderBy('la.id', 'DESC')
    //     ->get();


    // }

    public function salary_advance()
    {
        return $this->selectRaw('ROW_NUMBER() OVER () as "SNo", la.empid, loan_types.name as "TYPE", la.*, CONCAT(employee.fname, \' \', COALESCE(employee.mname, \' \', \'\'), \' \', employee.lname) as "NAME", departments.name as "DEPARTMENT", positions.name as "POSITION"')
            ->from('loan_application as la')
            ->join('employee as employee', 'la.empid', '=', 'employee.emp_id')
            ->join('position as positions', 'employee.position', '=', 'positions.id')
            ->join('department as departments', 'employee.department', '=', 'departments.id')
            ->join('loan_type as loan_types', 'la.type', '=', DB::raw('CAST("loan_types".id AS text)')) // Explicit cast to INTEGER
            ->orderBy('la.id', 'DESC')
            ->get();
    }


    public function waitingsalary_advance_hr()
    {
        $query = "SELECT * from loan_application WHERE type=1 AND status =0";
        return DB::select(DB::raw($query));
    }
    public function waitingsalary_advance_fin()
    {
        $query = "SELECT * from loan_application WHERE type=1 AND status =6";
        return DB::select(DB::raw($query));
    }
    public function waitingsalary_advance_appr()
    {
        $query = "SELECT * from loan_application WHERE type=1 AND status =1";
        return DB::select(DB::raw($query));
    }

    public function fin_salary_advance()
    {
        $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id AND la.type=lt.id AND la.status IN(1,2,5) ORDER BY la.id DESC ";

        return DB::select(DB::raw($query));
    }

    public function mysalary_advance_current($empID)
    {
        $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.empID = '" . $empID . "' AND la.notification IN(1, 3) ORDER BY la.id DESC ";

        return DB::select(DB::raw($query));
    }

    public function hr_fin_salary_advance_current()
    {
        $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification IN(2,3,4) ORDER BY la.id DESC ";

        return DB::select(DB::raw($query));
    }

    public function hr_salary_advance_current()
    {
        $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification = 2 ORDER BY la.id DESC ";

        return DB::select(DB::raw($query));
    }

    public function fin_salary_advance_current()
    {
        $query = "SELECT @s:=@s+1 SNo, la.empID, lt.name as TYPE, la.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan_application la, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE la.empID=e.emp_id and e.position=p.id and e.department=d.id and la.type=lt.id AND la.notification IN(3, 4) ORDER BY la.id DESC ";

        return DB::select(DB::raw($query));
    }

    public function update_salary_advance_notification_staff($empID)
    {
        DB::transaction(function () use ($empID) {
            $query = "UPDATE loan_application SET notification = 0 WHERE empid = '" . $empID . "' AND notification =1";
            DB::insert(DB::raw($query));
            $query = "UPDATE loan_application SET notification = 4 WHERE empid = '" . $empID . "' AND notification = 3";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    public function update_salary_advance_notification_hr_fin($empID)
    {
        DB::transaction(function () {
            $query = "UPDATE loan_application SET notification = 0 WHERE notification = 4";
            DB::insert(DB::raw($query));
            $query = "UPDATE loan_application SET notification = 1 WHERE  notification =3";
            DB::insert(DB::raw($query));
            $query = "UPDATE loan_application SET notification = 0 WHERE  notification = 2";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    public function update_salary_advance_notification_hr($empID)
    {
        $query = "UPDATE loan_application SET notification = 0 WHERE  notification = 2 ";
        DB::insert(DB::raw($query));
        return true;
    }

    public function update_salary_advance_notification_fin()
    {
        DB::transaction(function () {
            $query = "UPDATE loan_application SET notification = 0 WHERE notification = 4";
            DB::insert(DB::raw($query));
            $query = "UPDATE loan_application SET notification = 1 WHERE  notification =3";
            DB::insert(DB::raw($query));
        });
        return true;
    }

    public function getloanapplicationbyid($id)
    {
        //$this->load->database();
        $data = DB::table('loan_application')->where('id', $id);

        return $data->get();
    }

    public function confirmloan($data, $id)
    {
        DB::table('loan_application')->where('id', $id)
            ->update($data);
        return true;
    }

    public function my_confirmedloan($empID)
    {
        $queryResult = "SELECT
        ROW_NUMBER() OVER () AS SNo,
        l.\"empid\",
        l.*,
        CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS name,
        d.name AS department,
        p.name AS position
    FROM
        loan l
    JOIN
        employee e ON l.\"empid\" = e.emp_id
    JOIN
        position p ON e.position = p.id
    JOIN
        department d ON e.department = d.id";

        return DB::select(DB::raw($queryResult));
    }

    // public function all_confirmedloan()
    // {
    //     $query = "SELECT @s:=@s+1 SNo, l.empID, l.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as department, p.name as position FROM loan l, employee e, position p, department d,  (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id ORDER BY l.state DESC ";
    //     return DB::select(DB::raw($query));
    // }


    public function all_confirmedloan()
    {
        return $this->selectRaw('ROW_NUMBER() OVER () as SNo, loans.empID, loans.*, CONCAT(employees.fname, \' \', COALESCE(employees.mname, \' \', \'\'), \' \', employees.lname) as name, departments.name as department, positions.name as position')
            ->from('loan as loans')
            ->join('employee as employees', 'loans.empid', '=', 'employees.emp_id')
            ->join('position as positions', 'employees.position', '=', 'positions.id')
            ->join('department as departments', 'employees.department', '=', 'departments.id')
            ->orderByDesc('loans.state')
            ->get();
    }


    public function getloan($loanID)
    {
        $query = "SELECT l.empID, l.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as department, p.name as position FROM loan l, employee e, position p, department d WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id AND l.id = " . $loanID . " ";

        return DB::select(DB::raw($query));
    }

    public function updateLoan($data, $id)
    {
        DB::table('loan')->where('id', $id)
            ->update($data);
        return true;
    }
    // ONPROGRESS LOAN
    // SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and l.state = 1 and  l.last_paid_date BETWEEN '2017-12-21' AND '2018-12-21'

    // COMPLETED LOAN
    // SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and l.state = 0 and  l.last_paid_date BETWEEN '2017-12-21' AND '2018-12-21'

    public function getloanbyid($id)
    {
        //$this->load->database();
        $data = DB::table('loan_application')->where('id', $id);

        return $data->get();
    }

    public function update_loan($data, $id)
    {
        DB::table('loan_application')->where('id', $id)
            ->update($data);
        return true;
    }

    public function getAllocation()
    {
        $query = "SELECT * FROM employee_activity_grant";
        return DB::select(DB::raw($query));
    }

    public function deleteLoan($id)
    {
        DB::table('loan_application')->where('id', $id)
            ->delete('loan_application');
        return true;
    }

    public function applyloan($data)
    {
        DB::table('loan_application')->insert($data);
        return true;
    }

    public function approve_loan($loanID, $signatory, $todate)
    {
        DB::transaction(function () use ($loanID, $signatory, $todate) {
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

		SELECT la.empID, IF((la.type=2), la.reason, lt.name) as description, la.type, la.form_four_index_no, la.amount, la.deduction_amount, la.application_date, 1, la.approved_hr, '" . $signatory . "', la.approved_date_hr, '" . $todate . "', 0, 0, '" . $todate . "' FROM loan_application la, loan_type lt WHERE lt.id = la.type AND la.id ='" . $loanID . "' ";
            DB::insert(DB::raw($query));
            $query = "UPDATE loan_application SET status = 2, notification=1, approved_cd = '" . $signatory . "', time_approved_cd = '" . $todate . "'  WHERE id ='" . $loanID . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function count_employees()
    {
        $query = 'e.emp_id  WHERE e.state = 1';
        $row = DB::table('employee as e')
            ->select(DB::raw($query))
            ->first();
        return $row;
    }

    public function employees_info()
    {
        $query = "SELECT (SELECT COUNT(emp_id) FROM employee WHERE state = 1)  as emp_count, (SELECT COUNT(emp_id) FROM employee WHERE GENDER = 'Male' AND state = 1 ) as males,(SELECT COUNT(emp_id) FROM employee WHERE GENDER = 'Female' AND state = 1 ) as females, (SELECT COUNT(emp_id) FROM employee WHERE state = 0 ) as inactive,  (SELECT COUNT(emp_id) FROM employee WHERE is_expatriate = 1 AND state = 1 ) as expatriate, (SELECT COUNT(emp_id) FROM employee WHERE is_expatriate = 0 AND state = 1 ) as local_employee ";
        return DB::select(DB::raw($query));
    }

    public function comment($data)
    {

        DB::table('comments')->insert($data);

        return true;
    }

    public function position()
    {
        //$query = "SELECT @s:=@s+1 as SNo, (SELECT pp.name from position pp WHERE p.parent_code = pp.position_code) as parent, d.name as department, p.* FROM position p, department d, (SELECT @s:=0) as s WHERE d.id = p.dept_id AND p.state = 1";
        // $query = "SELECT @s:=@s+1 as SNo, 'none' as parent, d.name as department, p.* FROM position p, department d, (SELECT @s:=0) as s WHERE d.id = p.dept_id AND p.state = 1";
        $query = "SELECT row_number() OVER () as \"SNo\", 'none' as parent, d.name as department, p.* FROM position p JOIN department d ON d.id = p.dept_id WHERE p.state = 1; ";
        return DB::select(DB::raw($query));
    }
    public function inactive_position()
    {
        $query = "SELECT row_number() OVER () as \"SNo\",(SELECT pp.name FROM position pp WHERE p.parent_code = pp.position_code) as parent, d.name as department, p.* FROM position p JOIN department d ON d.id = p.dept_id WHERE p.state = 0;";
        return DB::select(DB::raw($query));
    }
    public function allposition()
    {
        $query = "SELECT * FROM position WHERE state = 1";
        return DB::select(DB::raw($query));
    }
    public function allLevels()
    {
        $query = "SELECT * FROM organization_level";
        return DB::select(DB::raw($query));
    }

    // FORM
    public function positiondropdown()
    {
        $query = "SELECT * FROM position WHERE state = 1 ";

        return DB::select(DB::raw($query));
    }
    public function positiondropdown2($id)
    {
        $query = "SELECT * FROM position WHERE dept_id = '" . $id . "' AND state = 1";

        return DB::select(DB::raw($query));
    }



    public function linemanagerdropdown()
    {
        // $query = "SELECT DISTINCT er.userID as empID,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME FROM employee e, emp_role er, role r WHERE er.role = r.id and er.userID = e.emp_id and  r.permissions like '%p%'";
        $query = "SELECT DISTINCT
            e.emp_id as empID,
            CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as NAME
        FROM employee e
        WHERE e.state != 4
            AND e.emp_id NOT LIKE '%JOB_%'
    ";        return DB::select(DB::raw($query));
    }

    public function departmentdropdown()
    {
        $query = "SELECT d.* FROM department d WHERE state = 1 AND type = 1 ";

        return DB::select(DB::raw($query));
    }

    public function pensiondropdown()
    {
        $query = "SELECT pf.* FROM pension_fund pf";

        return DB::select(DB::raw($query));
    }

    public function countrydropdown()
    {
        $query = "SELECT c.* FROM country c";

        return DB::select(DB::raw($query));
    }

    public function branchdropdown()
    {
        $query = "SELECT b.* FROM branch b";

        return DB::select(DB::raw($query));
    }

    public function getPositionSalaryRange($positionID)
    {
        $result = DB::table('position')
            ->join('organization_level', 'organization_level.id', '=', 'position.organization_level')
            ->select(
                DB::raw('(SELECT ROUND((minsalary/12), 0) FROM organization_level WHERE organization_level.id = position.organization_level) as minsalary'),
                DB::raw('(SELECT ROUND((maxsalary/12), 0) FROM organization_level WHERE organization_level.id = position.organization_level) as maxsalary')
            )
            ->where('position.id', $positionID)
            ->get();


        return $result;
    }


    public function bank()
    {
        $query = DB::table('bank')
        ->select(
            DB::raw('ROW_NUMBER() OVER () as SNo'),
            'bank.*'
        )
        ->get();

    return $query;
    }

    public function bank_branch()
    {
        $query = DB::table('bank_branch')
        ->select(
            DB::raw('ROW_NUMBER() OVER () as SNo'),
            'bank.name as bankname',
            'bank_branch.*'
        )
        ->join('bank', 'bank.id', '=', 'bank_branch.bank')
        ->get();

    return $query;
    }

    public function bankBranchFetcher($id)
    {
        $query = "SELECT * FROM bank_branch where bank = " . $id . "";
        // dd($query);
        return DB::select(DB::raw($query));
    }

    public function department_reference()
    {
        $query = "id  ORDER BY id DESC limit 1";
        $row = DB::table('department')
            ->select(DB::raw($query))
            ->first();
        return $row->id;
    }

    public function addBank($data)
    {
        DB::table('bank')->insert($data);
        return true;
    }
    public function addBankBranch($data)
    {
        DB::table('bank_branch')->insert($data);

        return true;
    }
    public function getbank($id)
    {
        $query = "SELECT * FROM bank where id = '" . $id . "'";

        return DB::select(DB::raw($query));
    }
    public function getbankbranch($id)
    {
        $query = "SELECT * FROM bank_branch where id = '" . $id . "'";

        return DB::select(DB::raw($query));
    }

    public function updateBank($data, $bankID)
    {
        DB::table('bank')->where('id', $bankID)
            ->update($data);
        return true;
    }

    public function updateBankBranch($data, $branchID)
    {
        DB::table('bank_branch')->where('id', $branchID)
            ->update($data);
        return true;
    }

    // FORM



public function positionFetcher($id)
{

    $positions = DB::table('position')
        ->where('dept_id', $id)
        ->where('state', 1)
        ->get();

    $lineManagers = DB::table('employee')
        ->select('emp_role.userid as empID', DB::raw("CONCAT(fname, ' ', COALESCE(mname, ' '), ' ', lname) as NAME"))
        ->join('emp_role', 'employee.emp_id', '=', 'emp_role.userid')
        ->join('role', 'emp_role.role', '=', 'role.id')
        ->where('role.permissions', 'like', '%bs%')
        ->where('employee.department', $id)
        ->distinct()
        ->get();

    // $countryDirectors = DB::table('employee')
    //     ->select('emp_role.userID as empID', DB::raw("CONCAT(fname, ' ', COALESCE(mname, ' '), ' ', lname) as NAME"))
    //     ->join('emp_role', 'employee.emp_id', '=', 'emp_role.userID')
    //     ->join('role', 'emp_role.role', '=', 'role.id')
    //     ->where(function ($query) {
    //         $query->where('role.permissions', 'like', '%l%')
    //               ->orWhere('role.permissions', 'like', '%q%');
    //     })
    //     ->distinct()
    //     ->get();

    // Uncomment the above code if you want to fetch country directors as well.

    return [$positions, $lineManagers];
}


    // FORM
    public function employeeAdd($employee, $newEmp)
    {
        $result = DB::transaction(function () use ($employee, $newEmp) {
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

    public function updateEmployeeID($recordID, $empID, $property, $datagroup)
    {
        DB::transaction(function () use ($recordID, $empID, $property, $datagroup) {
            $query = "UPDATE employee SET emp_id = '" . $empID . "' WHERE id ='" . $recordID . "'";

            DB::insert(DB::raw($query));
            DB::table('company_property')->insert($property);
            DB::table('employee_group')->insert($datagroup);
        });

        return true;
    }


    public function get_latestEmployee()
    {
        $query = "emp_id  order by id DESC LIMIT 1";

        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->first();

        return $row->emp_id;
    }

    public function getldPhoto($empID)
    {
        $query = "photo WHERE emp_id = '" . $empID . "' ";
        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->first();
        return $row->ephoto;
    }

    public function updateEmployee($data, $empID)
    {
        DB::table('employee')->where('emp_id', $empID)->update($data);
        return true;
    }

    public function updateContractStart($data, $empID)
    {
        DB::table('employee')->where('emp_id', $empID)
            ->update($data);
        return true;
    }

    public function updateContractEnd($data, $empID)
    {
        DB::table('employee')->where('emp_id', $empID)
            ->update($data);
        return true;
    }

    public function activateEmployee($property, $datagroup, $datalog, $empID, $logID, $todate)
    {
        $result = DB::transaction(function () use ($property, $datagroup, $datalog, $empID, $logID, $todate) {
            DB::table('company_property')->insert($property);
            DB::table('company_property')->insert($datagroup);
            DB::table('activation_deactivation')->insert($datalog);

            $query = "UPDATE employee SET state = 1, last_updated = '" . $todate . "' WHERE emp_id ='" . $empID . "'";

            DB::insert(DB::raw($query));

            $query = "UPDATE activation_deactivation SET current_state = 1 WHERE id ='" . $logID . "'";

            DB::insert(DB::raw($query));

            return true;
        });

        return $result;
    }

    public function deactivateEmployee($empID, $datalog, $logID, $todate)
    { //set status to 4 as is confirm exit
        $state = $datalog['state'];
        DB::transaction(function () use ($empID, $datalog, $logID, $todate, $state) {
            $query = "UPDATE employee SET state = '" . $state . "', last_updated = '" . $todate . "' WHERE emp_id ='" . $empID . "'";
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

    public function addkin($data)
    {
        DB::table('next_of_kin')->insert($data);
    }

    public function addproperty($data)
    {
        DB::table('next_of_kin')->insert($data);
        return true;
    }

    public function updateproperty($data, $id)
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

    public function employeestatelog($data)
    {
        $empID = $data['empID'];
        $state = $data['state'];
        $query = "UPDATE employee SET state = '" . $state . "' WHERE emp_id = '" . $empID . "'";

        DB::insert(DB::raw($query));

        DB::table('activation_deactivation')->insert($data);

        // return true;
    }

    public function login_info($empID)
    {
        $query = "SELECT username, password FROM employee WHERE emp_id = '" . $empID . "'";
        return DB::select(DB::raw($query));
    }

    // to be checked
    public function login_user($username, $password)
    {
        // $query = "SELECT e.*, d.name as dname, c.name as CONTRACT, d.id as departmentID, p.id as positionID, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as lineManager from employee e, contract c, department d, position p WHERE d.id=e.department and e.contract_type = c.id and p.id=e.position and (e.state = '1' or e.state = '3')  and e.username ='".$username."'";
        // $row = DB::select(DB::raw($query));
        // if(count($row)>0) {
        //     $row = $row->row();
        //     $password_hash = $row->password;

        //     if (password_verify($password, $password_hash)){
        //         return $query->row_array();
        //     }else{
        //         return false;
        //     }
        // } else{
        //     return false;
        // }
    }

    public function get_login_user($username)
    {
        // $query = "SELECT e.*, d.name as dname, c.name as CONTRACT, d.id as departmentID, p.id as positionID, p.name as pName, (SELECT CONCAT(fname,' ', mname,' ', lname) from employee where  emp_id = e.line_manager) as lineManager from employee e, contract c, department d, position p WHERE d.id=e.department and e.contract_type = c.id and p.id=e.position and (e.state = '1' or e.state = '3')  and e.fname ='".$username."'";
        // $row = DB::select(DB::raw($query));
        // if(count($row)>0) {
        //     return $row;

        // }
    }

    public function password_age($empID)
    {
        $query = "SELECT u.time FROM user_passwords u WHERE empID = '" . $empID . "' ORDER BY id DESC LIMIT 1";
        return DB::select(DB::raw($query));
    }

    public function insertAuditLog($logData)
    {
        DB::table('audit_logs')->insert($logData);
        return true;
    }

    public function insertAuditPurgeLog($logData)
    {
        DB::table('audit_purge_logs')->insert($logData);
        return true;
    }

    public function userID()
    {
        $query = 'SELECT id FROM employee ORDER BY id DESC LIMIT 1';
        $row = DB::table('employee')
            ->select(DB::raw($query))
            ->first();
        return $row->id;
    }

    #############################PRIVELEGES##############################

    #############################EMPLOYER##############################

    public function allpositioncodes()
    {

        $query = "SELECT p.position_code AS POSITION FROM position p WHERE p.state = 1 ";
        return DB::select(DB::raw($query));
    }

    public function otherpositions()
    {

        $query = "SELECT p.name as name, p.id as positionID,

(SELECT COUNT(e.emp_id) FROM employee e WHERE e.position = p.id) as head_counts,

IF( (SELECT COUNT(e.emp_id) FROM employee e WHERE e.position IN(SELECT pl.position FROM payroll_logs pl  WHERE pl.payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 )) )>0,
   (SELECT SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) FROM payroll_logs pl WHERE pl.position = p.id AND pl.payroll_date = ( SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 ) GROUP BY pl.position), 0) AS employment_cost,

p.position_code AS child_position, p.parent_code as parent_position FROM  position p WHERE NOT p.id = 6 AND p.state = 1 ORDER BY p.level";
        return DB::select(DB::raw($query));
    }

    public function topposition()
    {

        $query = "SELECT p.name as NAME, p.position_code as POSITION, p.parent_code as PARENT FROM  position p WHERE p.id = 1";
        return DB::select(DB::raw($query));
    }

    public function alldepartmentcodes()
    {

        $query = "SELECT d.department_pattern AS department FROM department d WHERE d.state = 1 ";
        return DB::select(DB::raw($query));
    }

    public function topDepartment()
    {

        $query = "SELECT d.name , d.department_pattern AS pattern FROM  department d WHERE d.id = 3";
        return DB::select(DB::raw($query));
    }
    public function childDepartments()
    {

        $query = "SELECT d.name as name, d.id as deptID,(SELECT COUNT(e.emp_id) FROM employee e WHERE e.department = d.id) as head_counts,

IF( (SELECT COUNT(e.emp_id) FROM employee e WHERE e.department IN(SELECT pl.department FROM payroll_logs pl  WHERE pl.payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 )) )>0,
   (SELECT SUM(pl.salary+pl.allowances+pl.pension_employer+pl.wcf+pl.sdl) FROM payroll_logs pl WHERE pl.department = d.id AND pl.payroll_date = ( SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1 ) GROUP BY pl.department), 0) AS employment_cost,

d.department_pattern AS child_department, d.parent_pattern as parent_department FROM  department d WHERE NOT d.id = 3 order by d.level";
        return DB::select(DB::raw($query));
    }

    public function employer($data)
    {
        DB::table('company_info')->insert($data);
    }

    public function updateemployer($data, $id)
    {
        DB::table('company_info')->where('id', $id)
            ->update($data);
        return true;
    }

    public function employerdetails()
    {
        $query = 'SELECT * FROM company_info';
        return DB::select(DB::raw($query));
    }

    #############################EMPLOYER##############################

    public function departmentnum_rows($id)
    {
        $query = "SELECT count(hod) as DETCOUNT FROM department WHERE hod ='" . $id . "'";
        return DB::select(DB::raw($query));
    }

    public function role($id)
{
    $query = DB::table('position as p')
    ->selectRaw('ROW_NUMBER() OVER (ORDER BY p.id) AS SNo')
    ->selectRaw("'none' AS parent")
    ->selectRaw('d.name AS department')
    ->select('p.*')
    ->join('department as d', 'd.id', '=', 'p.dept_id')
    ->where('p.state', 1);

$rolesSubquery = DB::table('public.role as r')
    ->select('r.id', 'r.name')
    ->leftJoin('public.emp_role as er', 'r.id', '=', 'er.role')
    ->where('er.userid', $id)
    ->whereNull('er.role');

$query = DB::table(DB::raw("({$query->toSql()}) as seq"))
    ->mergeBindings($query) // Ensure the bindings are merged correctly
    ->select('seq.sno', 'seq.parent', 'seq.department', 'seq.*', 'roles.id as role_id', 'roles.name as role_name')
    ->leftJoin(DB::raw("({$rolesSubquery->toSql()}) as roles"), function($join) {
        // Use a proper column for joining; this example assumes 'id' columns can be used
        $join->on('seq.id', '=', 'roles.id');
    })
    ->mergeBindings($rolesSubquery) // Ensure the bindings are merged correctly
    ->orderBy('seq.SNo')
    ->get();


    return $query;


        }        

    public function rolecount($id)
    {
        $query = "SELECT ROW_NUMBER() OVER () as SNo, r.id, r.name
                  FROM role r
                  WHERE r.id NOT IN (SELECT role FROM emp_role WHERE \"userid\" = '" . $id . "')";

        $rows = DB::select(DB::raw($query));

        return count($rows);
    }

    public function allrole()
    {
        $query = "SELECT ROW_NUMBER() OVER () as SNo, r.id FROM roles r";



        return DB::select(DB::raw($query));
    }

    public function finencialgroups()
    {
        $query = "SELECT ROW_NUMBER() OVER () as SNo, g.* FROM groups g WHERE type IN (0,1)";

        return DB::select(DB::raw($query));
    }


    public function rolesgroupsnot()
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, g.* FROM groups g WHERE type = '2' AND g.id NOT IN (SELECT group_name FROM emp_role)";

    return DB::select(DB::raw($query));
}
public function rolesgroupsin()
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, g.* FROM groups g WHERE type = '2'";

    return DB::select(DB::raw($query));
}


public function rolesgroups()
{
    $query = "SELECT ROW_NUMBER() OVER () as SNo, g.* FROM groups g WHERE type IN (0,2)";

    return DB::select(DB::raw($query));
}

public function group_byid($id)
{
    $query = "SELECT id, name FROM groups WHERE id = " . $id;

    return DB::select(DB::raw($query));
}


    public function memberscount($id)
    {

        $query = "SELECT count(eg.id) as headcounts  FROM employee_group eg,employee e WHERE   eg.empID=e.emp_id and e.state=1 and  eg.group_name =" . $id . "";
        $row = DB::select(DB::raw($query));

        return $row[0]->headcounts;
    }

    public function nonmembers_roles_byid($id)
    {

        // $query = "SELECT DISTINCT @s:=@s+1 as SNo,p.id as ID, p.name as POSITION,d.name as DEPARTMENT   FROM position p INNER JOIN department d ON p.dept_id = d.id ,  (SELECT @s:=0) as s WHERE p.state = 1 AND   p.id NOT IN (SELECT roleID from role_groups  where group_name=" . $id . ")";


        $results = DB::table('position as p')
    ->select(
        DB::raw('DISTINCT ROW_NUMBER() OVER () as SNo'),
        'p.id as ID',
        'p.name as POSITION',
        'd.name as DEPARTMENT'
    )
    ->join('department as d', 'p.dept_id', '=', 'd.id')
    ->where('p.state', 1)
    ->whereNotIn('p.id', function ($query) use ($id) {
        $query->select('roleID')
            ->from('role_groups')
            ->where('group_name', $id);
    })
    ->get();

        //dd(DB::select(DB::raw($query)));
        return $results;
    }

    public function nonmembers_byid($id)
    {

$results = DB::table('employee as e')
    ->select(
        DB::raw('DISTINCT ROW_NUMBER() OVER (ORDER BY e.emp_id) as SNo'),
        'e.emp_id as ID',
        DB::raw("CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as NAME"),
        'd.name as DEPARTMENT',
        'p.name as POSITION'
    )
    ->join('position as p', 'e.position', '=', 'p.id')
    ->join('department as d', 'e.department', '=', 'd.id')
    ->where('e.state', 1)
    ->whereNotIn('e.emp_id', function ($query) use ($id) {
        $query->select('empid')
            ->from('employee_group')
            ->where('group_name', $id);
    })
    ->get();
        // $query = "SELECT DISTINCT @s:=@s+1 as SNo, e.emp_id as ID,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM employee e, position p, department d,  (SELECT @s:=0) as s  where e.position = p.id AND e.department = d.id AND e.state =1 AND e.emp_id NOT IN (SELECT empID from employee_group where group_name=" . $id . ")";

        return $results;
    }

    public function roleswithingroup($id)
    {
        $query = "SELECT DISTINCT role roleswithin FROM emp_role WHERE `group_name`=" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function allowanceswithingroup($id)
    {
        $query = "SELECT DISTINCT allowance as allowanceswithin FROM emp_allowances WHERE `group_name`=" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function members_byid($id)
    {
        $query = "WITH s AS (SELECT 0 AS s) SELECT DISTINCT s.s + row_number() OVER () AS SNo, eg.id AS EGID, e.emp_id AS ID, CONCAT(e.fname, ' ', CASE WHEN e.mname IS NOT NULL THEN e.mname ELSE ' ' END, ' ', e.lname) AS NAME, d.name AS DEPARTMENT, p.name AS POSITION
        FROM employee e JOIN position p ON e.position = p.id JOIN department d ON e.department = d.id JOIN employee_group eg ON e.emp_id = eg.empID CROSS JOIN s WHERE eg.group_name = :id AND e.state = 1 AND e.emp_id IN (SELECT empID FROM employee_group WHERE group_name = :id)";

        return DB::select(DB::raw($query), ['id' => $id]);
    }
    public function roles_byid($id)
    {

        // $query = "SELECT DISTINCT @s:=@s+1 as SNo, rg.id as RGID,  p.id as ID, d.name as DEPARTMENT, p.name as POSITION FROM  position p INNER JOIN department d ON p.dept_id = d.id INNER JOIN role_groups rg ON p.id = rg.roleID,  (SELECT @s:=0) as s  where  p.id = rg.roleID  and rg.group_name = " . $id . "  and p.id IN (SELECT roleID from role_groups where group_name=" . $id . ")";


        $results = DB::table('position as p')
    ->select(
        DB::raw('DISTINCT ROW_NUMBER() OVER () as SNo'),
        'rg.id as RGID',
        'p.id as ID',
        'd.name as DEPARTMENT',
        'p.name as POSITION'
    )
    ->join('department as d', 'p.dept_id', '=', 'd.id')
    ->join('role_groups as rg', 'p.id', '=', 'rg.roleID')
    ->where('rg.group_name', $id)
    ->whereIn('p.id', function ($query) use ($id) {
        $query->select('roleID')
            ->from('role_groups')
            ->where('group_name', $id);
    })
    ->get();

        return $results;
    }
    public function get_employee_by_position($position)
    {
        $query = "SELECT emp_id from employee where position=" . $position;
        return DB::select(DB::raw($query));
    }

    public function role_members_byid($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, eg.id as roleID,  e.emp_id as userID,  CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM employee e, position p, department d, emp_role eg,  (SELECT @s:=0) as s  where e.position = p.id and e.emp_id = eg.userID and e.department = d.id and eg.role = " . $id . "";
        return DB::select(DB::raw($query));
    }

    public function add_to_group($data)
    {
        DB::table('employee_group')->insert($data);
        return true;
    }

    public function get_group_roles($groupID)
    {
        $query = "SELECT DISTINCT role FROM emp_role WHERE group_name=" . $groupID . "";

        return DB::select(DB::raw($query));
    }

    public function get_group_deductions($groupID)
    {
        $query = "SELECT DISTINCT deduction FROM emp_deductions WHERE group_name=" . $groupID . "";

        return DB::select(DB::raw($query));
    }

    public function get_group_allowances($groupID)
    {
        $query = "SELECT DISTINCT allowance FROM emp_allowances WHERE group_name=" . $groupID . "";

        return DB::select(DB::raw($query));
    }

    public function getEmpByGroupID($group_id, $position)
    {
        $query = 'SELECT eg."empid" from employee_group eg INNER JOIN  employee e ON e.emp_id=eg."empid" WHERE eg.group_name = :group_id AND  e.position = :position';
        return DB::select(DB::raw($query), ['group_id' => $group_id, 'position' => $position]);
    }

    public function removeEmployeeByROleFromGroup($empID, $groupID)
    {
        DB::transaction(function () use ($empID, $groupID) {
            $query = 'DELETE FROM employee_group  WHERE  "group_name" = :groupID AND "empid" = :empID';
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);

            $query = 'DELETE FROM emp_allowances WHERE  "group_name" = :groupID AND "empid" = :empID';
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);

            $query = 'DELETE FROM emp_deductions WHERE  "group_name" = :groupID AND "empID" = :empID';
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);

            $query = 'DELETE FROM emp_role WHERE  "group_name" = :groupID  AND "userid" = :empID';
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);
        });

        return true;
    }

    public function removeEmployeeFromGroup($refID, $empID, $groupID)
    {
        DB::transaction(function () use ($refID, $empID, $groupID) {
            $query = 'DELETE FROM employee_group WHERE id = :refID';
            DB::delete(DB::raw($query), ['refID' => $refID]);

            $query = "DELETE FROM emp_allowances WHERE group_name = :groupID AND empID = :empID";
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);

            $query = 'DELETE FROM emp_deductions WHERE "group_name" = :groupID AND "empID" = :empID';
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);

            $query = "DELETE FROM emp_role WHERE group_name = :groupID AND userID = :empID";
            DB::delete(DB::raw($query), ['groupID' => $groupID, 'empID' => $empID]);
        });

        return true;
    }

    public function delete_role_group($roleID, $GroupID)
    {
        DB::table('role_groups')
            ->where('roleID', $roleID)
            ->where('group_name', $GroupID)
            ->delete();

        return true;
    }

    public function removeEmployeeFromRole($refID, $empID)
    {
        DB::transaction(function () use ($refID, $empID) {
            $query = "DELETE FROM emp_role WHERE id ='" . $refID . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function employeeFromGroup($refID)
    {
        $query = "SELECT group_name FROM emp_role WHERE id ='" . $refID . "'";
        $row = DB::select(DB::raw($query));

        if (count($row) > 0) {
            return $row[0]->group_name;
        } else {
            return null;
        }
    }

    public function deleteEmployeeFromGroup($group_id, $empID)
    {
        DB::transaction(function () use ($group_id, $empID) {
            $query = "DELETE FROM employee_group WHERE empID ='" . $empID . "' and group_name = '" . $group_id . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function addEmployeeToGroup($empID, $groupID)
    {;
        $query = "INSERT INTO  employee_group(empID, group_name) VALUES ('" . $empID . "', " . $groupID . ") ";

        DB::insert(DB::raw($query));
        return true;
    }

    public function addRoleToGroup($roleID, $groupID)
    {
        $query = 'INSERT INTO role_groups("roleID", "group_name") VALUES (:roleID, :groupID)';
        DB::insert(DB::raw($query), ['roleID' => $roleID, 'groupID' => $groupID]);
        return true;
    }

    public function remove_from_group($id)
    {
        DB::table('employee_group')->where('id', $id)
            ->delete();
        return true;
    }

    public function remove_from_grouprole($value, $groupID)
    {
        // $id = $this->input->get("id";
        DB::table('emp_role')->where('userID', $value)
            ->where('group_ref', $groupID)
            ->delete();
        return true;
    }

    public function remove_individual_from_allowance($empID, $allowanceID)
    {
        DB::table('emp_allowances')->where('empid', $empID)
            ->where('group_name', 0)
            ->where('allowance', $allowanceID)
            ->delete();
        return true;
    }

    public function get_individual_from_allowance($empID, $allowanceID)
    {
        $row = DB::table('emp_allowances')->where('empid', $empID)
            ->where('group_name', 0)
            ->where('allowance', $allowanceID)
            ->select('*')->first();
        return $row;
    }

    public function remove_group_from_allowance($groupID, $allowanceID)
    {
        DB::table('emp_allowances')->where('group_name', $groupID)
            ->where('allowance', $allowanceID)
            ->delete();
        return true;
    }

    public function addrole($data)
    {
        DB::table('role')->insert($data);
        return true;
    }
    public function deleteGroup($groupID)
    {
        DB::transaction(function () use ($groupID) {

            $query = "DELETE FROM groups WHERE id ='" . $groupID . "'";
            DB::insert(DB::raw($query));
            $query = "DELETE FROM employee_group WHERE group_name ='" . $groupID . "'";
            DB::insert(DB::raw($query));
            $query = "DELETE FROM emp_allowances WHERE group_name ='" . $groupID . "'";
            DB::insert(DB::raw($query));
            $query = "DELETE FROM emp_role WHERE group_name='" . $groupID . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }
    public function deleteRole($roleID)
    {
        DB::transaction(function () use ($roleID) {

            $query = "DELETE FROM role WHERE id ='" . $roleID . "'";
            DB::insert(DB::raw($query));
            $query = "DELETE FROM emp_role WHERE role ='" . $roleID . "'";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function addgroup($data)
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

    public function getpermission($empID, $permissionID)
    {
        $query = "SELECT r.permissions as permission FROM emp_role er, role r WHERE er.role=r.id and er.userID='" . $empID . "'  and r.permissions like '%" . $permissionID . "%'";
        $results = DB::table('emp_role er')
            ->select(DB::raw($query))
            ->count();
        if ($results > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function assignrole($data)
    {
        DB::table('emp_role')->insert($data);
        return true;
    }

    public function permission()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1";

        return DB::select(DB::raw($query));
    }

    public function general_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 5";

        return DB::select(DB::raw($query));
    }
    public function cdir_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 6";

        return DB::select(DB::raw($query));
    }
    public function hr_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 1";

        return DB::select(DB::raw($query));
    }

    public function fin_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 3";

        return DB::select(DB::raw($query));
    }

    public function line_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 4";

        return DB::select(DB::raw($query));
    }

    public function perf_permissions()
    {
        $query = "SELECT @s:=@s+1 as SNo, a.* FROM permission a, (SELECT @s:=0) as s  WHERE a.state = 1 AND a.permission_type = 2";

        return DB::select(DB::raw($query));
    }

    public function getrolebyid($id)
    {
        $query = "SELECT * FROM role WHERE id =" . $id . "";

        return DB::select(DB::raw($query));
    }

    public function getuserrole($id)
    {
        $query = "SELECT ROW_NUMBER() OVER () as SNo, er.id, CAST(er.duedate as date) as DATED, er.role, CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as eNAME, r.name as NAME
                  FROM emp_role er
                  JOIN employee e ON er.\"userid\" = e.emp_id
                  JOIN role r ON er.role = r.id
                  WHERE er.\"userid\" = '" . $id . "'";

        return DB::select(DB::raw($query));
    }

    public function updaterole($data, $id)
    {
        DB::table('role')->where('id', $id)
            ->update($data);
        return true;
    }
    public function revokerole($id, $role, $isGroup)
    {
        DB::table('emp_role')->where('userID', $id)
            ->where('role', $role)
            ->where('group_name', $isGroup)
            ->delete();

        return true;
    }

    ############################PRIVELEGES###############################

    /*    function leavereportline($id)
{
$query = " SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id  and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id  and ls.empID = '".$id."'" );

return DB::select(DB::raw($query));
}*/

    /*    function leavereport1_line($dates, $datee, $id)
{
$query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.emp_id = '".$id."'";

return DB::select(DB::raw($query));
}*/

    public function customemployee()
    {
         $query = "SELECT DISTINCT e.emp_id AS \"empID\",
         CONCAT(e.fname, ' ',
             CASE
                 WHEN e.mname IS NOT NULL THEN e.mname || ' '
                 ELSE ''
             END,
             e.lname) AS \"NAME\"
     FROM employee e
     WHERE state = 1";



        return DB::select(DB::raw($query));
    }

    public function employeeMails()
    {
        $query = "SELECT DISTINCT email, name FROM company_emails";
        return DB::select(DB::raw($query));
    }

    public function employeehiredate($id)
    {
        $query = "SELECT e.hire_date as HIRE FROM employee e WHERE e.emp_id = '" . $id . "' ";
        return DB::select(DB::raw($query));
    }

    public function appreciated_employee()
    {
        $query = "SELECT * from appreciation LIMIT 1";

        return DB::select(DB::raw($query));
    }

    // public function appreciated_employee()
    // {
    //     $query = "SELECT a.empID, CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, e.photo, a.description, a.date_apprd FROM appreciation a, employee e, department d, position p WHERE a.empID = e.emp_id and p.id = e.position and d.id = e.department ORDER BY a.id DESC LIMIT 1";

    //     return DB::select(DB::raw($query));
    // }




//     public function appreciated_employee()
// {
//     $query = "SELECT a.empID,
//                      CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) as NAME,
//                      p.name as POSITION,
//                      d.name as DEPARTMENT,
//                      e.photo,
//                      a.description,
//                      a.date_apprd
//               FROM appreciation a
//               JOIN employee e ON a.empID = e.emp_id  -- Adjust this line based on the actual column name
//               JOIN department d ON d.id = e.department
//               JOIN position p ON p.id = e.position
//               ORDER BY a.id DESC
//               LIMIT 1";

//     return DB::select(DB::raw($query));
// }


    public function add_apprec($data)
    {
        DB::table('appreciation')->insert($data);
    }

    public function payslip($id, $date)
    {

        $query = "SELECT e.emp_id as empID, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, p.name as POSITION, d.name as DEPARTMENT, (pl.basic+pl.allowance) as GOSS, pl.pension_employee as PENSION, pl.paye as PAYE, pl.medical as MEDICAL, (pl.basic+pl.allowance-pl.pension_employee) as TAXABLE, (pl.allowance+pl.basic-pl.paye-pl.pension_employee-pl.medical) as NET_PAY,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=3 and l.empID = '" . $id . "' and payment_date = '" . $date . "')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=3 and l.empID = '" . $id . "' and payment_date = '" . $date . "'),0)) as HESLB_DEDUCTION,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=1 and l.empID = '" . $id . "' and payment_date = '" . $date . "')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=1 and l.empID = '" . $id . "' and payment_date = '" . $date . "'),0)) as SALARY_ADV,

(SELECT IF((SELECT COUNT(ll.paid) FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=2 and l.empID = '" . $id . "' and payment_date = '" . $date . "')>0,(SELECT ll.paid FROM loan_logs ll, loan l where ll.loan_fk =l.id and l.type=2 and l.empID = '" . $id . "' and payment_date = '" . $date . "'),0)) as LOAN_DEDUCTION,

(SELECT IF((SELECT COUNT(l.amount) FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 2 and l.approved_date_finance BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "')>0,(SELECT l.amount FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 2 and l.approved_date_finance BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "'),0)) as Amount_LOAN,

(SELECT IF((SELECT COUNT(l.amount) FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 3 and l.approved_date_finance BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "')>0,(SELECT l.amount FROM loan l, employee e  where e.emp_id = l.empID and l.state = 1 and l.type = 3 and l.approved_date_finance BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "'),0)) as Amount_HESLB, '" . $date . "' as OUTSTANDING_DATE, e.hire_date as HIRE,

 (SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 1 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 1 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "'),0)) as PAID_SALARYADVANCE,

(SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 3 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 3 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "'),0)) as PAID_HESLB,
(SELECT IF((SELECT COUNT(llg.id) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 2 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "')>0,(SELECT SUM(llg.paid) FROM loan_logs llg, loan l, employee e where l.empID=e.emp_id and l.type = 2 AND l.id = llg.loan_fk and llg.payment_date BETWEEN e.hire_date AND '" . $date . "' and l.empID = '" . $id . "'),0)) as PAID_PERSONAL,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "'),0))as ANNUAL,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 2 AND lv.start BETWEEN e.hire_date AND '2018-12-25' and lv.empID = '" . $id . "')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 2 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "'),0))as EXAM,


(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 3 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 3 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "'),0))as MARTENITY,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 6 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 6 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "'),0))as COMPASSIONATE,

(SELECT IF((SELECT COUNT(lv.id) FROM leaves lv where lv.nature = 5 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "')>0,(SELECT lv.days FROM leaves lv   where lv.nature = 5 AND lv.start BETWEEN e.hire_date AND '" . $date . "' and lv.empID = '" . $id . "'),0))as SICK

FROM payroll_logs pl, employee e, position p, department d where e.emp_id=pl.empID and e.department=d.id and pl.position=p.id and pl.empID= '" . $id . "' and pl.due_date = '2018-12-25' ";
        DB::insert(DB::raw($query));
    }

    ######################NOTIFICATION#################################
    public function contract_to_expire()
    {
        $query = "e.emp_id WHERE e.state=1 and c.id = e.contract_type AND ((c.duration*12)-(DATEDIFF(CURRENT_DATE(), e.contract_renewal_date)/30)) <= c.reminder";
        $row = DB::table('employee as e', 'contract as c')
            ->select(DB::raw($query))
            ->count();
        return $row;
    }

    public function employee_to_retire()
    {
        $query = "SELECT empID FROM (SELECT emp_id as empID, (SELECT notify_before FROM retire WHERE id = 1) as notify_before, (SELECT retire_age FROM retire WHERE id = 1)-((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as ages_to_retire, ((DATEDIFF(CURRENT_DATE(), birthdate)/30)/12) as age FROM employee  WHERE state=1) as parent_query WHERE ages_to_retire <= notify_before";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function init_emp_state()
    {
        $query = "SELECT id FROM activation_deactivation WHERE  current_state = 1 AND state IN(0,1) AND notification = 1";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function appr_emp_state()
    {
        $query = "SELECT id FROM activation_deactivation WHERE  current_state = 0 AND state IN(2,3) AND notification = 1";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function loan_notification_employee($empID)
    {
        $query = "SELECT l.id FROM loan_application l WHERE l.empID = '" . $empID . "' AND l.notification = 1";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function loan_notification_hr()
    {
        $query = "SELECT l.id FROM loan_application l WHERE l.notification = 2";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function loan_notification_finance()
    {
        $query = "SELECT l.id FROM loan_application l  WHERE l.notification =3 ";
        $row = DB::select(DB::raw($query));
        return count($row);
    }

    public function getParentPositionName($id)
    {
        $query = "SELECT name from position  WHERE position_code = '" . $id . "'";
        $row = DB::select(DB::raw($query));
        return !empty($row) ? $row[0]->name : "";
    }

    public function get_allowance_name($id)
    {
        $query = "CONCAT(name,'(',amount,')') as output  WHERE id = " . $id . "";
        $row = DB::table('allowances')
            ->select(DB::raw($query))
            ->first();
        return !empty($row) ? $row->output : "";
    }

    ####################################### GRIEVANCES ###########################
    public function add_grievance($data)
    {
        DB::table('grievances')->insert($data);
    }

    public function updategrievances($data, $id)
    {
        DB::table('grievances')->where('id', $id)
            ->update($data);
        return true;
    }

    public function forward_grievance($data, $id)
    {
        DB::table('grievances')->where('id', $id)
            ->update($data);
        return true;
    }

    public function grievance_details($id)
    {
        $result = DB::table('grievances as g')
            ->join('employee as e', 'g.empid', '=', 'e.emp_id')
            ->join('position as p', 'e.position', '=', 'p.id')
            ->join('department as d', 'e.department', '=', 'd.id')
            ->select(
                DB::raw('row_number() OVER () as "SNo"'),
                'g.id',
                'g.*',
                DB::raw('CAST(g.timed AS DATE) as DATED'),
                DB::raw("CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as NAME"),
                'p.name as POSITION',
                'd.name as DEPARTMENT',
                'g.description'
            )
            ->where('g.id', '=', $id)
            ->get();

        return $result;
    }


    public function all_grievances()
    {
        $result = DB::table('grievances as g')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'g.id',
                'g.*',
                DB::raw('CAST(g.timed as date) as DATED'),
                DB::raw("CONCAT(e.fname, ' ', CASE WHEN e.mname IS NOT NULL THEN e.mname ELSE '' END, ' ', e.lname) as NAME"),
                'p.name as POSITION',
                'd.name as DEPARTMENT',
                'g.description'
            )
            ->join('employee as e', 'g.empid', '=', 'e.emp_id')
            ->join('position as p', 'p.id', '=', 'e.position')
            ->join('department as d', 'd.id', '=', 'e.department')
            ->get();

        return $result;
    }


            public function my_grievances($empID)
        {
            $result = "SELECT 
        ROW_NUMBER() OVER () as \"SNo\",
        g.*,
        CAST(g.timed as date) as \"DATED\"
        FROM grievances g
        WHERE g.empid = :empID";

    $row = DB::select(DB::raw($result), ['empID' => $empID]);
            return $row;
}


    ####################### END GRIEVANCES #####################################

    ########### ACCOUNTING CODDING #############

    public function accounting_coding()
    {
        $query = "select * from account_code";

        return DB::select(DB::raw($query));
    }

    ########### END ACCOUNTING CODDING #############

    public function employeeRetired($empID)
    {
        $query = "UPDATE employee set retired = '2' where emp_id ='" . $empID . "'";
        DB::insert(DB::raw($query));
        return true;
    }

    public function employeeLogin($empID)
    {
        $query = "UPDATE employee set login_user = '1' where emp_id ='" . $empID . "'";
        DB::insert(DB::raw($query));
        return true;
    }

    public function employeeReport()
    {
        $query = "SELECT @s:=@s+1 SNo, p.name as POSITION, d.name as DEPARTMENT, e.*, CONCAT(e.fname,' ',IF( e.mname != null,e.mname,' '),' ', e.lname) as NAME, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el where el.emp_id=e.line_manager ) as LINEMANAGER, IF((( SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id GROUP by nature)>0), (SELECT sum(days)  FROM `leaves` where nature=1 and empID=e.emp_id  GROUP by nature),0) as ACCRUED FROM employee e, department d, position p , (select @s:=0) as s WHERE  p.id=e.position and d.id=e.department and e.state=1 and e.state != 4";
        return DB::select(DB::raw($query));
    }

    public function addPartialPayment($data)
    {
        DB::transaction(function () use ($data) {
            DB::table('partial_payment')->insert($data);
        });
        return true;
    }

    public function updatePartialPayment($date)
    {
        DB::transaction(function () use ($date) {
            $query = "update partial_payment set status = 1, payroll_date = '" . $date . "' where status = 0 ";
            DB::insert(DB::raw($query));
        });
    }

    public function presentPartialPayment($payroll_date)
    {
        $query = "select * from partial_payment where payroll_date = '" . $payroll_date . "' and status = 1 ";
        return DB::select(DB::raw($query));
    }

    public function employeePayrollLog($empID, $payroll_date)
    {
        $query = "*  where empID = '" . $empID . "' and payroll_date = '" . $payroll_date . "' ";
        $row = DB::table('payroll_logs')
            ->select(DB::raw($query))
            ->first();
        return $row;
    }

    public function employeePension($pension_id)
    {
        $query = "*  where id = '" . $pension_id . "' ";
        $row = DB::table('pension_fund')
            ->select(DB::raw($query))
            ->first();
        return $row;
    }

    public function updatePayrollLog($empID, $payroll_date, $data)
    {
        DB::transaction(function () use ($empID, $payroll_date, $data) {
            $query = "update payroll_logs set salary = '" . $data['salary'] . "', pension_employee = '" . $data['pension_employee'] . "',
		 pension_employer = '" . $data['pension_employer'] . "', taxdue = '" . $data['taxdue'] . "', sdl = '" . $data['sdl'] . "',
		 wcf = '" . $data['wcf'] . "' where payroll_date = '" . $payroll_date . "' and empID = '" . $empID . "' ";
            DB::insert(DB::raw($query));
        });
    }

    public function deletePayment($id)
    {

        DB::table('partial_payment')->where('id', $id)
            ->delete();
        return true;
    }

    public function updateGroupEdit($id, $name)
    {
        $query = "update groups set name = '" . $name . "' where id='" . $id . "' ";
        DB::insert(DB::raw($query));
        return true;
    }

    public function memberWithGroup($role_id, $empID)
    {
        $query = "select * from emp_role er, employee_group eg, groups as g where eg.group_name
= er.group_name and role = '" . $role_id . "' and empID = '" . $empID . "' and eg.group_name = g.id  ";
        return DB::select(DB::raw($query));
    }

    public function transfers($id)
    {
        $query = "SELECT * from transfer where id = '" . $id . "' ";
        $row = DB::select(DB::raw($query));

        if ($row) {
            return $row[0];
        } else {
            return null;
        }
    }

    public function approveRegistration($empID, $transferID, $approver, $date)
    {
        DB::transaction(function () use ($empID, $approver, $date, $transferID) {
            $query = "update employee set state = 1 where emp_id = '" . $empID . "' ";
            DB::insert(DB::raw($query));
            $query = "update transfer set status = 6, approved_by = '" . $approver . "', date_approved = '" . $date . "'
		    where id = '" . $transferID . "' ";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function disapproveRegistration($empID, $transferID)
    {
        DB::transaction(function () use ($empID, $transferID) {
            $query = "delete from employee where emp_id = '" . $empID . "' ";
            DB::insert(DB::raw($query));
            $query = "delete from employee_group where empID = '" . $empID . "' ";
            DB::insert(DB::raw($query));
            $query = "delete from employee_activity_grant where empID = '" . $empID . "' ";
            DB::insert(DB::raw($query));
            $query = "update transfer set status = 7 where id = '" . $transferID . "' ";
            DB::insert(DB::raw($query));
        });

        return true;
    }

    public function assignment_task_log($payroll_date)
    {
        DB::transaction(function () use ($payroll_date) {
            $query = "insert into assignment_task_logs (assignment_employee_id,emp_id,task_name,description,start_date,end_date,remarks,status,payroll_date)
                select ae.assignment_id, ae.emp_id, ast.task_name, ast.description, ast.start_date,
                ast.end_date, ast.remarks, ast.status, '" . $payroll_date . "' from assignment_employee ae, assignment_task ast
                where ae.id = ast.assignment_employee_id and ast.status = 1 and ast.date is null;";
            DB::insert(DB::raw($query));
            $query = "update assignment_task set date = '" . $payroll_date . "' where date is null ";
            DB::insert(DB::raw($query));
        });

        return true;
    }
}
