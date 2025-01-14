<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use  App\Models\Payroll\ReportModel;

use App\Models\Employee;
use Carbon\Carbon;


class Payroll extends Model
{
    public function customemployee()
    {
        $query1 = "SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME FROM employee e WHERE  e.login_user != 1 ";
        $query = "SELECT DISTINCT e.emp_id AS \"empID\",
        CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS NAME
    FROM employee e
    WHERE e.login_user != 1
     ";
        return DB::select(DB::raw($query));


    }
    public function customemployeeExit()
    {
        $query = "SELECT DISTINCT e.emp_id AS \"empID\", CONCAT(e.fname, ' ',
            CASE
                WHEN e.mname IS NOT NULL THEN e.mname
                ELSE ''
            END,
            ' ', e.lname) AS \"NAME\" FROM employee e WHERE e.state = 4";
        return DB::select(DB::raw($query));
    }
    public function payroll_month_list()
    {
        $query = 'SELECT DISTINCT payroll_date FROM payroll_logs WHERE payroll_date > \'2022-12-31\' ORDER BY payroll_date DESC';
        return DB::select(DB::raw($query));
    }

    public function payroll_year_list()
    {
        $query = "SELECT DISTINCT DATE_FORMAT(`payroll_date`,'%Y') as year  FROM payroll_logs ORDER BY DATE_FORMAT(`payroll_date`,'%Y') DESC";
        return DB::select(DB::raw($query));
    }
    public function selectBonus()
    {
        $query = 'SELECT * FROM bonus_tags';
        return DB::select(DB::raw($query));
    }
    public function setOvertimeNotification($for)
    {
        DB::transaction(function () use ($for) {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('line',0,'You have a pending overtime to approve','" . $for . "')";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function setPayrollNotification($for)
    {
        DB::transaction(function () use ($for) {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',2,'You have a pending payroll to approve','" . $for . "')";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function setImprestNotification($for)
    {
        DB::transaction(function () use ($for) {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',1,'You have a pending imprest to approve','" . $for . "')";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function setAdvSalaryNotification($for)
    {
        DB::transaction(function () use ($for) {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('hr',3,'You have a pending advance salary to approve','" . $for . "')";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function setIncentiveNotification($for)
    {
        DB::transaction(function () use ($for) {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',4,'You have a pending incentive to approve','" . $for . "')";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function clearNotification($type, $payroll_id)
    {
        DB::transaction(function () use ($type, $payroll_id) {
            $query = "DELETE FROM notifications WHERE notifications.type='" . $type . "' AND notifications.for='" . $payroll_id . "' ";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function seenPayrollNotification($type)
    {
        DB::transaction(function () use ($type) {
            $query = "DELETE FROM notifications WHERE notifications.type='" . $type . "' ";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function updatePayrollNotification()
    {
        DB::transaction(function () {
            $query = "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',2,'You have a pending pyroll to approve',1)";
            DB::insert(DB::raw($query));
        });
        return true;
    }
    public function selectAllowances()
    {
        $query = 'SELECT * FROM allowances';
        return DB::select(DB::raw($query));
    }
    public function getAllowanceAmount($salary, $allowanceID)
    {
        $query = " IF((a.mode = 1), a.amount, (" . $salary . ")*(a.percent)) AS amount  WHERE a.id = " . $allowanceID . " ";
        $row = DB::table('allowances as a')->select(DB::raw($query))->first();
        return $row->amount;
    }
    public function getPensionAmount($pensionFund)
    {
        $query = "SELECT pf.deduction_from, pf.amount_employee FROM pension_fund pf WHERE id = " . $pensionFund . "";
        return DB::select(DB::raw($query));
    }
    public function getHealthInsuranceAmount()
    {
        $query = "rate_employee  WHERE id = 9";
        $row = DB::table('deduction')->select(DB::raw($query))->first();
        return $row->rate_employee;
    }
    public function getPayeAmount($taxableAmount)
    {
        $query = "SELECT IF(count(id)>0, minimum, 0) AS minimum, IF(count(id)>0, rate, 0) AS rate, IF(count(id)>0, excess_added, 0) AS excess_added FROM paye WHERE minimum <= " . $taxableAmount . " AND Maximum > '" . $taxableAmount . "' group by minimum, rate, excess_added ";
        return DB::select(DB::raw($query));
    }
    public function payrollMonthList()
    {
        $query = 'SELECT ROW_NUMBER() OVER () AS "SNo", pm.*, e.fname, e.mname, e.lname
        FROM payroll_months pm
        JOIN employee e ON pm.init_author = e.emp_id';

        return DB::select(DB::raw($query));
    }
    public function getNotifications()
    {
        $query = 'SELECT * FROM notifications  ORDER BY id DESC';
        return DB::select(DB::raw($query));
    }
    public function payrollMonthListpending()
    {
        $query = "SELECT ROW_NUMBER() OVER (ORDER BY pm.id DESC) AS SNo, pm.* FROM payroll_months pm WHERE pm.state = 1 OR pm.state = 2 ORDER BY pm.id DESC";
        return DB::select(DB::raw($query));
    }
    public function employee_bonuses()
    {
        $query1 = "SELECT @s:=@s+1 SNo, b.*, tags.name as tag,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as department, p.name as position FROM employee e, department d, position p, bonus b, bonus_tags tags, (SELECT @s:=0) as s WHERE e.department = d.id AND e.position = p.id AND e.emp_id = b.empID AND tags.id = b.name and e.state = 1 and e.login_user != 1";
        $query = "SELECT
        ROW_NUMBER() OVER (ORDER BY b.id) AS SNo,
        b.*,
        tags.name as tag,
        CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) as name,
        d.name as department,
        p.name as position
    FROM
        employee e
    JOIN
        department d ON e.department = d.id
    JOIN
        position p ON e.position = p.id
    JOIN
        bonus b ON e.emp_id = b.empID
    JOIN
        bonus_tags tags ON tags.id = b.name
    WHERE
        e.state = 1 AND e.login_user != 1
    ";
        return DB::select(DB::raw($query));
    }
    public function waitingbonusesRecom()
    {
        $query = "SELECT * FROM bonus WHERE bonus.state=0";
        return DB::select(DB::raw($query));
    }
    public function waitingbonusesAppr()
    {
        $query = "SELECT * FROM bonus WHERE bonus.state=2";
        return DB::select(DB::raw($query));
    }
    public function waitingpayroll_fin()
    {
        $query = "SELECT * FROM payroll_months WHERE state =2";
        return DB::select(DB::raw($query));
    }
    public function waitingpayroll_appr()
    {
        $query = "SELECT * FROM payroll_months WHERE state =1";
        return DB::select(DB::raw($query));
    }
    //START RUN PAYROLL FOR SCANIA
    public function pendingPayrollCheck()
    {
        $row = DB::table('payroll_months')->where('state', 1)->orWhere('state', 2)->orWhere('state', 3)->orWhere('state', 6)->select(DB::raw('COUNT(id) as counts '))->first();
        return $row->counts;
    }
    public function pendingPayroll()
    {
        $row = DB::table('payroll_months')->where('state', 1)->orWhere('state', 2)->orWhere('state', 3)->select(DB::raw('*'))->limit(1)->first();
        return $row;
    }
    public function recommendPayroll($author, $date, $state, $message)
    {
        if ($state == 1) {
            $query = ["state" => $state, "recom_author2" => $author, "recom_date2" => $date];
        } else {
            $query = ["state" => $state, "recom_author" => $author, "recom_date" => $date];
        }
        DB::table('payroll_months')->where('state', 2)->orWhere('state', 3)->update($query);
        $row = DB::table('payroll_months')->where('state', 2)->orWhere('state', 3)->orWhere('state', 1)->select('payroll_date')->first();
        $query = ["message" => $message, "payroll_date" => $row->payroll_date, "emp_id" => $author, "type" => 1, "date" => $date];
        DB::table('payroll_comments')->insert($query);
        return true;
    }
    public function pendingPayroll_month()
    {
        $query = "SELECT payroll_date as payroll_month FROM payroll_months WHERE state = 1 OR state = 2 OR state = 6 OR state = 3  LIMIT 1";
        $records = DB::select(DB::raw($query));
        if (count($records) == 1) {
            $row = $records[0];
            return $row->payroll_month;
        } else
            return 0;
    }
    public function payrollcheck($date)
    {
        // $query = "id  WHERE payroll_date like  '%".$date."%' ";
        $row = DB::table('payroll_logs')->where('payroll_date', 'like', '%' . $date . '%')->select('id');
        return $row->count();
    }

    public function initPayroll($dateToday, $payroll_date, $payroll_month, $empID)
    {
        // Extract the year from the payroll_date
        $year = date('Y', strtotime($payroll_date));

        // Calculate the number of days in the month of the payroll_date
        $days = intval(date('t', strtotime($payroll_date)));


        $payroll_date = date($payroll_date);

        DB::transaction(function () use ($dateToday, $payroll_date, $payroll_month, $empID, $days, $year) {


            $last_date = date("Y-m-t", strtotime($payroll_date)); //Last day of the month

            $query = "UPDATE allowances SET state = CASE WHEN EXTRACT(MONTH FROM DATE '" . $payroll_date . "') = 12 THEN 1 ELSE 0 END WHERE type = '1'";  //Activate leave allowance
            DB::update(DB::raw($query));

            //Insert into Pending Payroll Table
            $query = "INSERT INTO payroll_months (payroll_date, state, init_author, appr_author, init_date, appr_date,sdl, wcf) VALUES
            ('" . $payroll_date . "', 2, '" . $empID . "', '', '" . $dateToday . "', '" . $payroll_date . "', (SELECT rate_employer from deduction where id=4 ), (SELECT rate_employer from deduction where id=2 ) )";
            DB::insert(DB::raw($query));

            //INSERT ALLOWANCES
            $query = "INSERT INTO temp_allowance_logs (\"empID\", description, policy, amount, \"allowanceID\", payment_date, benefit_in_kind)
            SELECT ea.empid AS \"empID\", a.name AS description,
                CASE
                    WHEN ea.mode = '1' THEN 'Fixed Amount'
                    ELSE CONCAT(CAST(100 * CAST(ea.percent AS NUMERIC) AS VARCHAR), '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN ea.mode = '1' THEN CAST(ea.amount AS DOUBLE PRECISION)
                            ELSE
                                CASE
                                    WHEN a.type = '1' THEN
                                        CASE
                                            WHEN (DATE_PART('year', age('" . $last_date . "', e.hire_date))) < 1 THEN
                                                (DATE_PART('day', age('" . $last_date . "', e.hire_date) + INTERVAL '1 day') / 365.0) * e.salary
                                            ELSE
                                                CAST(ea.percent AS DOUBLE PRECISION) * e.salary
                                        END
                                    ELSE
                                        CAST(ea.percent AS DOUBLE PRECISION) *
                                        CASE
                                            WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                                 AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')) THEN
                                                ((" . $days . " - (EXTRACT(DAY FROM e.hire_date) + 1)) * e.salary / " . $days . ")
                                            ELSE
                                                e.salary
                                        END
                                END
                        END
                END AS amount, ea.allowance AS \"allowanceID\", DATE '" . $payroll_date . "' AS payment_date, a.\"Isbik\" AS benefit_in_kind
            FROM employee e JOIN emp_allowances ea ON e.emp_id = ea.empid JOIN allowances a ON a.id = ea.allowance
            WHERE a.state = 1 AND e.state = 1 AND e.login_user != 1";
            DB::insert(DB::raw($query));

            //INSERT BONUS
            $query = "INSERT INTO temp_allowance_logs(\"empID\", description, policy, amount, payment_date)
            SELECT b.empID AS \"empID\", bt.name AS description, 'Fixed Amount' AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE SUM(b.amount)
                END AS amount, DATE '" . $payroll_date . "' AS payment_date FROM employee e JOIN bonus b ON e.emp_id = b.empid JOIN bonus_tags bt ON bt.id = b.name
            WHERE b.state = 1 AND e.state = 1 AND e.login_user != 1 GROUP BY b.empID, bt.name, e.unpaid_leave";
            DB::insert(DB::raw($query));

            //INSERT OVERTIME
            $query = "INSERT INTO temp_allowance_logs(\"empID\", description, policy, amount, payment_date)
            SELECT ov.empid AS \"empID\",
            CASE
                WHEN ov.overtime_category = '1' THEN 'N-Overtime'
                    ELSE 'S-Overtime'
            END AS description,
            'Fixed Amount' AS policy,
            CASE
                WHEN e.unpaid_leave = '0' THEN 0
                ELSE SUM(ov.amount)
            END AS amount,
            DATE '" . $payroll_date . "' AS payment_date
            FROM employee e JOIN overtimes ov ON ov.empid = e.emp_id
            WHERE e.state = 1 AND e.login_user != 1 GROUP BY ov.empid, ov.overtime_category, e.unpaid_leave";
            DB::insert(DB::raw($query));

            //UPDATE SALARY ADVANCE.

            //INSERT SALARY ADVANCE, FORCED DEDUCTIONS and other LOANS INTO LOAN LOGS
            $query = "INSERT INTO temp_loan_logs(\"loanID\", policy, paid, remained, payment_date)
            SELECT id AS \"loanID\",
                CASE
                    WHEN deduction_amount = 0 THEN (SELECT rate_employee FROM deduction WHERE id = 3)
                    ELSE deduction_amount
                END AS policy,
                CASE
                    WHEN (paid + deduction_amount) > amount THEN amount
                    ELSE deduction_amount
                END AS paid,
                (amount -
                    CASE
                        WHEN (paid + deduction_amount) >= amount THEN amount - paid
                        ELSE paid + deduction_amount
                    END
                ) AS remained,
                DATE '" . $payroll_date . "' AS payment_date
            FROM loan WHERE state = 1 AND type != 3";
            DB::insert(DB::raw($query));

            //INSERT HESLB INTO LOGS
            $query = "INSERT INTO temp_loan_logs(\"loanID\", policy, paid, remained, payment_date)
                SELECT id AS \"loanID\",
                    CASE
                        WHEN deduction_amount = 0 THEN (SELECT rate_employee FROM deduction WHERE id = 3)
                        ELSE deduction_amount
                    END AS policy,
                    CASE
                        WHEN (paid + deduction_amount) > amount THEN amount
                        ELSE
                            (SELECT rate_employee FROM deduction WHERE id = 3) *
                            (SELECT
                                CASE
                                    WHEN e.unpaid_leave = '0' THEN 0
                                    WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                        AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "'))
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                            FROM employee e WHERE e.emp_id = empid AND e.state != 4 AND e.login_user != 1)
                    END AS paid,
                    (amount -
                        CASE
                            WHEN (paid + deduction_amount) >= amount THEN amount - paid
                            ELSE
                                (paid +
                                    ((SELECT rate_employee FROM deduction WHERE id = 3) *
                                    (SELECT
                                        CASE
                                            WHEN e.unpaid_leave = '0' THEN 0
                                            WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                                AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "'))
                                            THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                            ELSE e.salary
                                        END
                                    FROM employee e WHERE e.emp_id = empid AND e.state != 4 AND e.login_user != 1))
                                )
                        END
                    ) AS remained,
                    DATE '" . $payroll_date . "' AS payment_date
                    FROM loan WHERE state = 1 AND type = 3";
            DB::insert(DB::raw($query));

            //INSERT DEDUCTION LOGS
            $query = "INSERT INTO temp_deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT
                ed.\"empID\" AS \"empID\",
                name AS description,
                CASE
                    WHEN d.mode = 1 THEN 'Fixed Amount'
                    ELSE CONCAT(100 * d.percent, '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN d.mode = 1 THEN d.amount
                            ELSE
                                d.percent *
                                (CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                        AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END)
                        END
                END AS paid,
                DATE '" . $payroll_date . "' AS payment_date
            FROM emp_deductions ed
            JOIN deductions d ON ed.deduction = d.id
            JOIN employee e ON e.emp_id = ed.\"empID\"
            WHERE e.state = 1
            AND e.login_user != 1
            AND d.state = 1";
            DB::insert(DB::raw($query));

            //DEDUCTION LOGS FROM IMPREST REFUND
            $query = "INSERT INTO temp_deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT empid, description, policy, paid, '" . $payroll_date . "'
            FROM once_off_deduction";
            DB::insert(DB::raw($query));

            // DEDUCTION LOGS FOR EXPATRIATES(HOUSING ALLOWANCE REFUND)
            // Housing Allowance has id = 6
            $query = "INSERT INTO temp_deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT ea.empid AS \"empID\", 'Housing Allowance Compensation' AS description,
                CASE
                    WHEN ea.mode = '1' THEN 'Fixed Amount'
                    ELSE CONCAT(100 * CAST(ea.percent AS NUMERIC), '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN ea.mode = '1' THEN CAST(ea.amount AS DOUBLE PRECISION)
                            ELSE
                            CAST(ea.percent AS DOUBLE PRECISION) *
                                (CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                        AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END)
                        END
                END AS paid,
                DATE '" . $payroll_date . "' AS payment_date FROM employee e
            JOIN emp_allowances ea ON e.emp_id = ea.empid JOIN allowances a ON a.id = ea.allowance
            WHERE e.is_expatriate = 1 AND e.state = 1 AND e.login_user != 1 AND a.id = 6";
            DB::insert(DB::raw($query));

            //STOP LOAN

            //INSERT PAYROLL LOG TABLE
            //Employee Salary Calculation
            $employeeSalaryCalculation = "CASE
                WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                THEN ((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . ")
                ELSE e.salary END";

            $bonusQuery = "CASE
                WHEN (SELECT SUM(b.amount) FROM bonus b WHERE b.state = 1 AND b.empID = e.emp_id GROUP BY b.empID) >= 0
                THEN (SELECT SUM(b.amount) FROM bonus b WHERE b.state = 1 AND b.empID = e.emp_id GROUP BY b.empID)
                ELSE 0 END";

            $overtimeQuery = "CASE
                WHEN (SELECT SUM(o.amount) FROM overtimes o WHERE o.empID = e.emp_id GROUP BY o.empID) >= 0
                THEN (SELECT SUM(o.amount) FROM overtimes o WHERE o.empID = e.emp_id GROUP BY o.empID)
                ELSE 0 END";

            $employeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.taxable = 'YES' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $employeeAllowanceQueryForMeals = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $employeeAllowanceQueryForWcf = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 AND a.temporary = '0' GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 AND a.temporary = '0' GROUP BY ea.empID)
                ELSE 0 END";

            $taxableAndpensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $pensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.pensionable = 'YES' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $taxableAndPensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $pensionableEmployerAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID)
                ELSE 0 END";

            $leaveAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE e.salary
                    END
                ELSE 0 END";

            $pensionableLeaveAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.pensionable = 'YES' ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE e.salary
                    END
                ELSE 0 END";

            $pensionCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$leaveAllowance} +

                /*end leave allowance to tax */
                CASE
                    WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                        FROM emp_allowances ea
                        JOIN allowances a ON a.id = ea.allowance
                        WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                    ) > 0
                    THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                        FROM emp_allowances ea
                        JOIN allowances a ON a.id = ea.allowance
                        WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                    )
                    ELSE 0
                END) END";

            $percentSalaryCalculation = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationForMeals = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType1 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationType1ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType1ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationType0ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType0 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $taxableAndPensionablePercentSalaryCalculationType0 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pureEmployeeAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE (SELECT ea.percent::DOUBLE PRECISION FROM emp_allowances ea, allowances a WHERE a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1) * e.salary
                    END
                ELSE {$percentSalaryCalculation} END";

            $pureEmployeeAllowanceForSdl = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1ForSdl}
                    END
                ELSE 0 END";

                $pureEmployeeAllowanceForWcf = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1ForSdl}
                    END
                ELSE 0 END";

            $purePensionableEmployeeAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.pensionable = 'YES' ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1}
                    END
                ELSE 0 END";

            $pensionableCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$purePensionableEmployeeAllowance} +

                /*end leave allowance to pension */
                {$pensionablePercentSalaryCalculationType0})
                END";

            $pensionableEmployerCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployerAllowanceQuery} +

                /* start add leave allowance to tax */
                {$purePensionableEmployeeAllowance} +

                /*end leave allowance to pension */
                {$pensionablePercentSalaryCalculationType0})
                END";

            $taxableAndPensionableCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$taxableAndPensionableEmployeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$pensionableLeaveAllowance} +

                /*end leave allowance to pension */
                {$taxableAndPensionablePercentSalaryCalculationType0})
                END";

            // INSERT data into the temp_payroll_logs table
            $query = "INSERT INTO temp_payroll_logs(
                gross,
                taxable_amount,
                excess_added,
                \"empID\",
                salary,
                allowances,
                pension_employee,
                pension_employer,
                medical_employee,
                medical_employer,
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
                nhif,
                rate,
                currency,
                payroll_date,
                years,
                actual_salary

                )

            SELECT


    (SELECT

    /*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
    /*SELECTING TAXABLE*/


    (/*Taxable Amount*/ (
    (

        {$employeeSalaryCalculation} +

            /*all Allowances and Bonuses*/
            {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

            /* start add leave allowance to tax */
            {$leaveAllowance} +

            /*end leave allowance to tax */
        {$percentSalaryCalculation}

            /*End all Allowances and Bonuses*/

            /*END OF TAXABLE AMOUNT CALCULATION */

            )/*End Taxable Amount*/)
            ))

            as gross,

             /*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
             /*SELECTING TAXABLE*/


             /*Taxable Amount*/
            ({$employeeSalaryCalculation} -

                /* pension */
            ({$pensionCalculation})) +

            /* END OF PENSION CALCULATION */

            /*all Allowances and Bonuses*/
            {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

            /* start add leave allowance to tax */
            {$leaveAllowance} +

            /*end leave allowance to tax */
            {$percentSalaryCalculation}

            /*End all Allowances and Bonuses*/

            /*END OF TAXABLE AMOUNT CALCULATION */

             /*End Taxable Amount*/

             as taxable_amount,


             (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/
                 {$employeeSalaryCalculation} -

                 /*pension*/
                 ({$pensionCalculation}))
                 /*End pension*/

                +
                /*all Allowances and Bonuses*/
                {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$leaveAllowance} +

                /*end leave allowance to tax */
                {$percentSalaryCalculation}

                /*End all Allowances and Bonuses*/
                 /*End Taxable Amount*/ AND minimum <= (/*Taxable Amount*/
                 {$employeeSalaryCalculation} -

                 /*pension*/
                 ({$pensionCalculation}))
                 /*End pension*/

                +
                /*all Allowances and Bonuses*/
                {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

                /*end leave allowance to tax */
                {$percentSalaryCalculation}

                /*End all Allowances and Bonuses*/
                 )/*End Taxable Amount*/

            AS excess_added,

            e.emp_id AS empID,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                {$employeeSalaryCalculation}
            END AS salary,

            /*Allowances and Bonuses*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                {$bonusQuery}
            END +

            {$overtimeQuery} + {$employeeAllowanceQueryForMeals} +

             /*add Leave allowance */
            {$pureEmployeeAllowance} +
            /*end Leave allowance */

            /*End Allowances and Bonuses*/
            {$percentSalaryCalculation} AS allowances,


            /*start of pension employee*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                CASE
                    WHEN e.retired != 2 THEN
                    {$pensionableCalculation}
                END
            END AS pension_employee,


            /*Start of pension employer*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                CASE
                    WHEN e.retired != 2 THEN
                    {$pensionableEmployerCalculation}
                END
            END AS pension_employer,
            /*End of Pension employer*/

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE(((SELECT rate_employee from deduction where id = 9)* {$employeeSalaryCalculation}), 0)
            END AS medical_employee,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE(((SELECT rate_employer from deduction where id = 9)* {$employeeSalaryCalculation}), 0)
            END AS medical_employer,

            /*PAYE AMOUNT CALCULATIONS STARTS HERE*/
            /*SELECTING EXCESS*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT excess_added FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
                AND minimum <= ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$taxableAndpensionableEmployeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
                +
                ((SELECT rate FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
                AND minimum <= ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
                *
                ((({$employeeSalaryCalculation} - ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
                - (SELECT minimum FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
                AND minimum <= ({$employeeSalaryCalculation} -
                ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation} ) ) )
            END AS taxdue,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE((CASE
                    WHEN ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForMeals} + {$percentSalaryCalculationForMeals}) < (SELECT minimum_gross FROM meals_deduction WHERE id = 1) THEN
                    (SELECT minimum_payment FROM meals_deduction WHERE id = 1) ELSE
                    (SELECT maximum_payment FROM meals_deduction WHERE id = 1)
                END), 0)
            END AS meals,

            e.department AS department,

            e.position AS position,

            e.branch::NUMERIC AS branch,

            e.pension_fund AS pension_fund,

            e.pf_membership_no as membership_no,

            e.bank AS bank,

            e.bank_branch AS bank_branch,

            e.account_no AS account_no,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 4) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForMeals} + {$pureEmployeeAllowanceForSdl} + {$percentSalaryCalculationType0ForSdl})
            END AS sdl,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 2) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForWcf}
                +
                (CASE
                    WHEN (SELECT SUM(CASE WHEN e.unpaid_leave = '0' THEN 0 ELSE {$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION END) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1  AND a.temporary = '0' AND a.type = '0' GROUP BY ea.empID) > 0 THEN
                    (SELECT SUM(CASE WHEN e.unpaid_leave = '0' THEN 0 ELSE {$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION END) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1  AND a.temporary = '0' AND a.type = '0' GROUP BY ea.empID) ELSE
                    0
                END))
            END AS wcf,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 10) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployeeAllowanceQuery} + {$pureEmployeeAllowanceForWcf} + {$pensionablePercentSalaryCalculationType0})
            END AS nhif,

            e.rate as rate,

            e.currency AS currency,

             '" . $payroll_date . "' as payroll_date,

             '" . $year . "' as years,

             CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE e.salary
            END AS actual_salary
            FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state = 1 and e.login_user != 1";
            //  dd($query);
            DB::insert(DB::raw($query));

//            $query = "update temp_payroll_logs set wcf = gross*(SELECT rate_employer from deduction where id=2)";
//            DB::update(DB::raw($query));
        });
        return true;
    }


    public function getGrossAmountSql($payroll_date, $days, $last_date)
    {

        return "SELECT

/*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
/*SELECTING TAXABLE*/


(/*Taxable Amount*/ (
(

IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
         ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)



+

/*all Allowances and Bonuses*/
IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0)
+
/* start add leave allowance to tax */
IF(
   (SELECT a.type FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=2 AND a.state= 1)  = 1,
IF(
DATEDIFF('" . $last_date . "',e.hire_date) < 365,
((DATEDIFF('" . $last_date . "',e.hire_date)+1)/365)*e.salary,
e.salary),

0
)

/*end leave allowance to tax */
+
IF ((SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
         ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES'  AND ea.mode=2 AND a.state= 1 AND a.type=0 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
         ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=2 AND a.taxable = 'YES' AND a.state= 1 AND a.type=0 GROUP BY ea.empID), 0)

/*End all Allowances and Bonuses*/

/*END OF TAXABLE AMOUNT CALCULATION */

)/*End Taxable Amount*/)
))";
    }



    public function getTaxableAmountSql($payroll_date, $days, $last_date)
    {


        return "         /*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
        /*SELECTING TAXABLE*/


        (/*Taxable Amount*/ (
       ( IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary) -

        /*pension*/
        IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
               /*IF BASIC  */
           ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*pf.amount_employee),

           /* IF GROSS */
                 (pf.amount_employee*(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)

       + IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0)
        +

       IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0)
        +

       IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=1 AND a.state= 1  GROUP BY ea.empID)>=0,
       ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=1 AND a.state= 1 GROUP BY ea.empID)),0)
       +
       /* start add leave allowance to tax */
       IF(
           (SELECT a.type FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=2 AND a.state= 1)  = 1,
IF(
 DATEDIFF('" . $last_date . "',e.hire_date) < 365,
 ((DATEDIFF('" . $last_date . "',e.hire_date)+1)/365)*e.salary,
e.salary),

0
)



       /*end leave allowance to tax */
       +
        IF ((SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=2 AND a.state= 1 AND a.type=0 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=2 AND a.state= 1 AND a.type=0 GROUP BY ea.empID), 0)))  )

       )
       /* END OF PENSION CALCULATION */

       +

       /*all Allowances and Bonuses*/
       IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

       IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

       IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND ea.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0)
       +
       /* start add leave allowance to tax */
       IF(
           (SELECT a.type FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=2 AND a.state= 1)  = 1,
IF(
 DATEDIFF('" . $last_date . "',e.hire_date) < 365,
 ((DATEDIFF('" . $last_date . "',e.hire_date)+1)/365)*e.salary,
e.salary),

0
)

       /*end leave allowance to tax */
       +
        IF ((SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES'  AND ea.mode=2 AND a.state= 1 AND a.type=0 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('" . $payroll_date . "')) AND (year(e.hire_date) = year('" . $payroll_date . "'))
                 ,((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),e.salary)*ea.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND ea.mode=2 AND a.taxable = 'YES' AND a.state= 1 AND a.type=0 GROUP BY ea.empID), 0)

       /*End all Allowances and Bonuses*/

       /*END OF TAXABLE AMOUNT CALCULATION */

        )/*End Taxable Amount*/)
";
}

    public function run_payroll($payroll_date, $payroll_month, $empID, $todate)
    {

        $year = date('Y', strtotime($payroll_date));
        $days = intval(date('t', strtotime($payroll_date)));
        $payroll_date = date($payroll_date);

        DB::transaction(function () use ($payroll_date, $payroll_month, $empID, $todate, $days, $year) {
            $last_date = date("Y-m-t", strtotime($payroll_date));

            $query = "UPDATE allowances SET state = CASE WHEN EXTRACT(MONTH FROM DATE '" . $payroll_date . "') = 12 THEN 1 ELSE 0 END WHERE type = '1'";  //Activate leave allowance
            DB::update(DB::raw($query));

            //INSERT ALLOWANCES
            $query = "INSERT INTO allowance_logs (\"empID\", description, policy, amount, \"allowanceID\", payment_date, benefit_in_kind)
            SELECT ea.empid AS \"empID\", a.name AS description,
                CASE
                    WHEN ea.mode = '1' THEN 'Fixed Amount'
                    ELSE CONCAT(CAST(100 * CAST(ea.percent AS NUMERIC) AS VARCHAR), '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN ea.mode = '1' THEN CAST(ea.amount AS DOUBLE PRECISION)
                            ELSE
                                CASE
                                    WHEN a.type = '1' THEN
                                        CASE
                                            WHEN (DATE_PART('year', age('" . $last_date . "', e.hire_date))) < 1 THEN
                                                (DATE_PART('day', age('" . $last_date . "', e.hire_date) + INTERVAL '1 day') / 365.0) * e.salary
                                            ELSE
                                                CAST(ea.percent AS DOUBLE PRECISION) * e.salary
                                        END
                                    ELSE
                                        CAST(ea.percent AS DOUBLE PRECISION) *
                                        CASE
                                            WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                                 AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')) THEN
                                                ((" . $days . " - (EXTRACT(DAY FROM e.hire_date) + 1)) * e.salary / " . $days . ")
                                            ELSE
                                                e.salary
                                        END
                                END
                        END
                END AS amount, ea.allowance AS \"allowanceID\", DATE '" . $payroll_date . "' AS payment_date, a.\"Isbik\" AS benefit_in_kind
            FROM employee e JOIN emp_allowances ea ON e.emp_id = ea.empid JOIN allowances a ON a.id = ea.allowance
            WHERE a.state = 1 AND e.state = 1 AND e.login_user != 1";
            DB::insert(DB::raw($query));

            //INSERT BONUS
            $query = "INSERT INTO allowance_logs(\"empID\", description, policy, amount, payment_date)
            SELECT b.empID AS \"empID\", bt.name AS description, 'Fixed Amount' AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE SUM(b.amount)
                END AS amount, DATE '" . $payroll_date . "' AS payment_date FROM employee e JOIN bonus b ON e.emp_id = b.empid JOIN bonus_tags bt ON bt.id = b.name
            WHERE b.state = 1 AND e.state = 1 AND e.login_user != 1 GROUP BY b.empID, bt.name, e.unpaid_leave";
            DB::insert(DB::raw($query));

            //INSERT OVERTIME
            $query = "INSERT INTO allowance_logs(\"empID\", description, policy, amount, payment_date)
            SELECT ov.empid AS \"empID\",
            CASE
                WHEN ov.overtime_category = '1' THEN 'N-Overtime'
                    ELSE 'S-Overtime'
            END AS description,
            'Fixed Amount' AS policy,
            CASE
                WHEN e.unpaid_leave = '0' THEN 0
                ELSE SUM(ov.amount)
            END AS amount,
            DATE '" . $payroll_date . "' AS payment_date
            FROM employee e JOIN overtimes ov ON ov.empid = e.emp_id
            WHERE e.state = 1 AND e.login_user != 1 GROUP BY ov.empid, ov.overtime_category, e.unpaid_leave";
            DB::insert(DB::raw($query));

            //INSERT SALARY ADVANCE, FORCED DEDUCTIONS and other LOANS INTO LOAN LOGS
            $query = "INSERT INTO loan_logs(\"loanID\", policy, paid, remained, payment_date)
            SELECT id AS \"loanID\",
                CASE
                    WHEN deduction_amount = 0 THEN (SELECT rate_employee FROM deduction WHERE id = 3)
                    ELSE deduction_amount
                END AS policy,
                CASE
                    WHEN (paid + deduction_amount) > amount THEN amount
                    ELSE deduction_amount
                END AS paid,
                COALESCE(amount -
                    CASE
                        WHEN (paid + deduction_amount) >= amount THEN amount - paid
                        ELSE paid + deduction_amount
                    END
                , 0) AS remained,
                DATE '" . $payroll_date . "' AS payment_date
            FROM loan WHERE state = 1 AND type != 3";
            DB::insert(DB::raw($query));

            //INSERT HESLB INTO LOGS
            $query = "INSERT INTO loan_logs(\"loanID\", policy, paid, remained, payment_date)
                SELECT id AS \"loanID\",
                    CASE
                        WHEN deduction_amount = 0 THEN (SELECT rate_employee FROM deduction WHERE id = 3)
                        ELSE deduction_amount
                    END AS policy,
                    CASE
                        WHEN (paid + deduction_amount) > amount THEN amount
                        ELSE
                            (SELECT rate_employee FROM deduction WHERE id = 3) *
                            (SELECT
                                CASE
                                    WHEN e.unpaid_leave = '0' THEN 0
                                    WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                        AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "'))
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                            FROM employee e WHERE e.emp_id = empid AND e.state != 4 AND e.login_user != 1)
                    END AS paid,
                    COALESCE(amount -
                        CASE
                            WHEN (paid + deduction_amount) >= amount THEN amount - paid
                            ELSE
                                (paid +
                                    ((SELECT rate_employee FROM deduction WHERE id = 3) *
                                    (SELECT
                                        CASE
                                            WHEN e.unpaid_leave = '0' THEN 0
                                            WHEN (EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "'))
                                                AND (EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "'))
                                            THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                            ELSE e.salary
                                        END
                                    FROM employee e WHERE e.emp_id = empid AND e.state != 4 AND e.login_user != 1))
                                )
                        END
                    , 0) AS remained,
                    DATE '" . $payroll_date . "' AS payment_date
                    FROM loan WHERE state = 1 AND type = 3";
            DB::insert(DB::raw($query));


            //UPDATE LOAN BOARD
            $query = "UPDATE loan
            SET
                paid = CASE
                    WHEN (paid + (
                        SELECT rate_employee FROM deduction WHERE id = 3
                    ) * (
                        SELECT CASE
                            WHEN e.unpaid_leave = '0' THEN 0
                            ELSE
                                CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                         AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                        END
                        FROM employee e WHERE e.emp_id = loan.empID AND e.state != 4 AND e.login_user != 1
                    )) > amount THEN amount
                    ELSE (paid + (
                        SELECT rate_employee FROM deduction WHERE id = 3
                    ) * (
                        SELECT CASE
                            WHEN e.unpaid_leave = '0' THEN 0
                            ELSE
                                CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                         AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                        END FROM employee e WHERE e.emp_id = loan.empID AND e.state != 4 AND e.login_user != 1
                    ))
                END,
                amount_last_paid = CASE
                    WHEN (paid + (
                        SELECT rate_employee FROM deduction WHERE id = 3
                    ) * (
                        SELECT CASE
                            WHEN e.unpaid_leave = '0' THEN 0
                            ELSE
                                CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                         AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                        END
                        FROM employee e WHERE e.emp_id = loan.empID AND e.state != 4 AND e.login_user != 1
                    )) > amount THEN amount - paid
                    ELSE ((
                        SELECT rate_employee FROM deduction WHERE id = 3
                    ) * (
                        SELECT CASE
                            WHEN e.unpaid_leave = '0' THEN 0
                            ELSE
                                CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                         AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END
                        END
                        FROM employee e WHERE e.emp_id = loan.empID AND e.state != 4 AND e.login_user != 1
                    ))
                END,
                last_paid_date = '" . $payroll_date . "'
            WHERE state = 1
            AND type = 3";
            DB::update(DB::raw($query));


            //INSERT DEDUCTION LOGS
            $query = "INSERT INTO deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT
                ed.\"empID\" AS \"empID\",
                name AS description,
                CASE
                    WHEN d.mode = 1 THEN 'Fixed Amount'
                    ELSE CONCAT(100 * d.percent, '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN d.mode = 1 THEN d.amount
                            ELSE
                                d.percent *
                                (CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                        AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END)
                        END
                END AS paid,
                DATE '" . $payroll_date . "' AS payment_date
            FROM emp_deductions ed
            JOIN deductions d ON ed.deduction = d.id
            JOIN employee e ON e.emp_id = ed.\"empID\"
            WHERE e.state = 1
            AND e.login_user != 1
            AND d.state = 1";
            DB::insert(DB::raw($query));

            //DEDUCTION LOGS FROM IMPREST REFUND
            $query = "INSERT INTO deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT empid, description, policy, paid, '" . $payroll_date . "'
            FROM once_off_deduction";
            DB::insert(DB::raw($query));

            // DEDUCTION LOGS FOR EXPATRIATES(HOUSING ALLOWANCE REFUND)
            // Housing Allowance has id = 6
            $query = "INSERT INTO deduction_logs(\"empID\", description, policy, paid, payment_date)
            SELECT ea.empid AS \"empID\", 'Housing Allowance Compensation' AS description,
                CASE
                    WHEN ea.mode = '1' THEN 'Fixed Amount'
                    ELSE CONCAT(100 * CAST(ea.percent AS NUMERIC), '% ( Basic Salary )')
                END AS policy,
                CASE
                    WHEN e.unpaid_leave = '0' THEN 0
                    ELSE
                        CASE
                            WHEN ea.mode = '1' THEN CAST(ea.amount AS DOUBLE PRECISION)
                            ELSE
                            CAST(ea.percent AS DOUBLE PRECISION) *
                                (CASE
                                    WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                        AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                                    THEN (((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . "))
                                    ELSE e.salary
                                END)
                        END
                END AS paid,
                DATE '" . $payroll_date . "' AS payment_date FROM employee e
            JOIN emp_allowances ea ON e.emp_id = ea.empid JOIN allowances a ON a.id = ea.allowance
            WHERE e.is_expatriate = 1 AND e.state = 1 AND e.login_user != 1 AND a.id = 6";
            DB::insert(DB::raw($query));

            //STOP LOAN
            $query = " UPDATE loan SET state = 0 WHERE amount = paid and state = 1";
            DB::update(DB::raw($query));

            $employeeSalaryCalculation = "CASE
                WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                THEN ((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . ")
                ELSE e.salary END";

            $employeeSalaryCalculation0 = "CASE
                WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "')
                THEN ((" . $days . " - EXTRACT(DAY FROM e.hire_date) + 1) * e.salary / " . $days . ")
                ELSE 0 END";

            $bonusQuery = "CASE
                WHEN (SELECT SUM(b.amount) FROM bonus b WHERE b.state = 1 AND b.empID = e.emp_id GROUP BY b.empID) >= 0
                THEN (SELECT SUM(b.amount) FROM bonus b WHERE b.state = 1 AND b.empID = e.emp_id GROUP BY b.empID)
                ELSE 0 END";

            $overtimeQuery = "CASE
                WHEN (SELECT SUM(o.amount) FROM overtimes o WHERE o.empID = e.emp_id GROUP BY o.empID) >= 0
                THEN (SELECT SUM(o.amount) FROM overtimes o WHERE o.empID = e.emp_id GROUP BY o.empID)
                ELSE 0 END";

            $employeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.taxable = 'YES' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $employeeAllowanceQueryForMeals = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $employeeAllowanceQueryForWcf = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 AND a.temporary = '0' GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.state = 1 AND a.temporary = '0' GROUP BY ea.empID)
                ELSE 0 END";

            $taxableAndpensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $pensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.pensionable = 'YES' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $taxableAndPensionableEmployeeAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 GROUP BY ea.empID)
                ELSE 0 END";

            $pensionableEmployerAllowanceQuery = "CASE
                WHEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '1' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID) >= 0
                THEN (SELECT SUM(ea.amount::NUMERIC) FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '1' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID)
                ELSE 0 END";

            $leaveAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE e.salary
                    END
                ELSE 0 END";

            $pensionableLeaveAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.pensionable = 'YES' ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE e.salary
                    END
                ELSE 0 END";

            $pensionCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$leaveAllowance} +

                /*end leave allowance to tax */
                CASE
                    WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                        FROM emp_allowances ea
                        JOIN allowances a ON a.id = ea.allowance
                        WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                    ) > 0
                    THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                        FROM emp_allowances ea
                        JOIN allowances a ON a.id = ea.allowance
                        WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                    )
                    ELSE 0
                END) END";

            $percentSalaryCalculation = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationForMeals = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType1 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationType1ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType1ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '1' GROUP BY ea.empID
                )
                ELSE 0 END";

            $percentSalaryCalculationType0ForSdl = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pensionablePercentSalaryCalculationType0 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $taxableAndPensionablePercentSalaryCalculationType0 = "CASE
                WHEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND a.taxable = 'YES' AND a.pensionable = 'YES' AND ea.mode = '2' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                ) > 0
                THEN (SELECT SUM({$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION)
                    FROM emp_allowances ea
                    JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.taxable = 'YES' AND a.pensionable = 'YES' AND a.state = 1 AND a.type = '0' GROUP BY ea.empID
                )
                ELSE 0 END";

            $pureEmployeeAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE (SELECT ea.percent::DOUBLE PRECISION FROM emp_allowances ea, allowances a WHERE a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1) * e.salary
                    END
                ELSE {$percentSalaryCalculation} END";

            $pureEmployeeAllowanceForSdl = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1ForSdl}
                    END
                ELSE 0 END";

                $pureEmployeeAllowanceForWcf = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1ForSdl}
                    END
                ELSE 0 END";

            $purePensionableEmployeeAllowance = "CASE
                WHEN (SELECT a.type FROM emp_allowances ea JOIN allowances a ON a.id = ea.allowance
                    WHERE ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1 AND a.pensionable = 'YES' ) = '1'
                THEN
                    CASE
                        WHEN EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) < 365
                        THEN ((EXTRACT(DAY FROM AGE(DATE '" . $last_date . "', e.hire_date)) + 1) / 365.0) * e.salary
                        ELSE {$pensionablePercentSalaryCalculationType1}
                    END
                ELSE 0 END";

            $pensionableCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$purePensionableEmployeeAllowance} +

                /*end leave allowance to pension */
                {$pensionablePercentSalaryCalculationType0})
                END";

            $pensionableEmployerCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployerAllowanceQuery} +

                /* start add leave allowance to tax */
                {$purePensionableEmployeeAllowance} +

                /*end leave allowance to pension */
                {$pensionablePercentSalaryCalculationType0})
                END";

            $taxableAndPensionableCalculation = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$taxableAndPensionableEmployeeAllowanceQuery} +

                /* start add leave allowance to tax */
                {$pensionableLeaveAllowance} +

                /*end leave allowance to pension */
                {$taxableAndPensionablePercentSalaryCalculationType0})
                END";

            $taxableAndPensionableCalculationForPens1 = "CASE
                WHEN pf.deduction_from = 1 THEN
                        -- IF BASIC
                        {$employeeSalaryCalculation} * pf.amount_employee
                    ELSE
                        -- IF GROSS
                        pf.amount_employee * ({$employeeSalaryCalculation} +

                {$bonusQuery} + {$overtimeQuery} + {$taxableAndPensionableEmployeeAllowanceQuery} +

                /*end leave allowance to pension */
                {$taxableAndPensionablePercentSalaryCalculationType0})
                END";

            //INSERT PAYROLL LOG TABLE
            $query = "INSERT INTO payroll_logs(

                pension2,
                gross,
                taxable_amount,
                excess_added,
                \"empID\",
                salary,
                allowances,
                pension_employee,
                pension_employer,
                medical_employee,
                medical_employer,
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
                nhif,
                rate,
                currency,
                payroll_date,
                years,
                actual_salary

                )

                SELECT

/*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
/*SELECTING TAXABLE*/
    ({$employeeSalaryCalculation0} + {$taxableAndPensionableCalculationForPens1}) AS pension2,

(SELECT

    /*TAXABLE AMOUNT  CALCULATIONS STARTS HERE*/
    /*SELECTING TAXABLE*/


    (/*Taxable Amount*/ (
    (

        {$employeeSalaryCalculation} +

            /*all Allowances and Bonuses*/
            {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

            /* start add leave allowance to tax */
            {$leaveAllowance} +

            /*end leave allowance to tax */
        {$percentSalaryCalculation}

            /*End all Allowances and Bonuses*/

            /*END OF TAXABLE AMOUNT CALCULATION */

            )/*End Taxable Amount*/)
            ))

            as gross,


            /*Taxable Amount*/
            ({$employeeSalaryCalculation} -

                /* pension */
            ({$pensionCalculation})) +

            /* END OF PENSION CALCULATION */

            /*all Allowances and Bonuses*/
            {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

            /* start add leave allowance to tax */
            {$leaveAllowance} +

            /*end leave allowance to tax */
            {$percentSalaryCalculation}

            /*End all Allowances and Bonuses*/

            /*END OF TAXABLE AMOUNT CALCULATION */

             /*End Taxable Amount*/

             as taxable_amount,

             (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/
                {$employeeSalaryCalculation} -

                /*pension*/
                ({$pensionCalculation}))
                /*End pension*/

               +
               /*all Allowances and Bonuses*/
               {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

               /* start add leave allowance to tax */
               {$leaveAllowance} +

               /*end leave allowance to tax */
               {$percentSalaryCalculation}

               /*End all Allowances and Bonuses*/
                /*End Taxable Amount*/ AND minimum <= (/*Taxable Amount*/
                {$employeeSalaryCalculation} -

                /*pension*/
                ({$pensionCalculation}))
                /*End pension*/

               +
               /*all Allowances and Bonuses*/
               {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} +

               /*end leave allowance to tax */
               {$percentSalaryCalculation}

               /*End all Allowances and Bonuses*/
                )/*End Taxable Amount*/

           AS excess_added,

            e.emp_id AS empID,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                {$employeeSalaryCalculation}
            END AS salary,

            /*Allowances and Bonuses*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                {$bonusQuery}
            END +

            {$overtimeQuery} + {$employeeAllowanceQueryForMeals} +

             /*add Leave allowance */
            {$pureEmployeeAllowance} +
            /*end Leave allowance */

            /*End Allowances and Bonuses*/
            {$percentSalaryCalculation} AS allowances,

             /*start of pension employee*/
             CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                CASE
                    WHEN e.retired != 2 THEN
                    {$pensionableCalculation}
                END
            END AS pension_employee,
            /*End pension employee*/

            /*Start of pension employer*/
            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                CASE
                    WHEN e.retired != 2 THEN
                    {$pensionableEmployerCalculation}
                END
            END AS pension_employer,
            /*End of Pension employer*/

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE(((SELECT rate_employee from deduction where id = 9)* {$employeeSalaryCalculation}), 0)
            END AS medical_employee,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE(((SELECT rate_employer from deduction where id = 9)* {$employeeSalaryCalculation}), 0)
            END AS medical_employer,


    /*PAYE AMOUNT CALCULATIONS STARTS HERE*/
    /*SELECTING EXCESS*/
        CASE
            WHEN e.unpaid_leave = '0' THEN
            0 ELSE
            (SELECT excess_added FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
            AND minimum <= ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$taxableAndpensionableEmployeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
            +
            ((SELECT rate FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
            AND minimum <= ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
            *
            ((({$employeeSalaryCalculation} - ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation})
            - (SELECT minimum FROM paye WHERE maximum > ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation}
            AND minimum <= ({$employeeSalaryCalculation} -
            ({$taxableAndPensionableCalculation})) + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQuery} + {$leaveAllowance} + {$percentSalaryCalculation} ) ) )
        END AS taxdue,

        CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                COALESCE((CASE
                    WHEN ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForMeals} + {$percentSalaryCalculationForMeals}) < (SELECT minimum_gross FROM meals_deduction WHERE id = 1) THEN
                    (SELECT minimum_payment FROM meals_deduction WHERE id = 1) ELSE
                    (SELECT maximum_payment FROM meals_deduction WHERE id = 1)
                END), 0)
            END AS meals,

             e.department AS department,

             e.position AS position,

             e.branch::NUMERIC AS branch,

             e.pension_fund AS pension_fund,

             e.pf_membership_no as membership_no,

             e.bank AS bank,

             e.bank_branch AS bank_branch,

             e.account_no AS account_no,

             CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 4) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForMeals} + {$pureEmployeeAllowanceForSdl} + {$percentSalaryCalculationType0ForSdl})
            END AS sdl,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 2) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$employeeAllowanceQueryForWcf}
                +
                (CASE
                    WHEN (SELECT SUM(CASE WHEN e.unpaid_leave = '0' THEN 0 ELSE {$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION END) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1  AND a.temporary = '0' AND a.type = '0' GROUP BY ea.empID) > 0 THEN
                    (SELECT SUM(CASE WHEN e.unpaid_leave = '0' THEN 0 ELSE {$employeeSalaryCalculation} * ea.percent::DOUBLE PRECISION END) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID = e.emp_id AND ea.mode = '2' AND a.state = 1  AND a.temporary = '0' AND a.type = '0' GROUP BY ea.empID) ELSE
                    0
                END))
            END AS wcf,

            CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE
                (SELECT rate_employer from deduction where id = 10) * ({$employeeSalaryCalculation} + {$bonusQuery} + {$overtimeQuery} + {$pensionableEmployeeAllowanceQuery} + {$pureEmployeeAllowanceForWcf} + {$pensionablePercentSalaryCalculationType0})
            END AS nhif,

             e.rate as rate,

             e.currency AS currency,

             '" . $payroll_date . "' as payroll_date,

             '" . $year . "' as years,

             CASE
                WHEN e.unpaid_leave = '0' THEN
                0 ELSE e.salary
            END AS actual_salary
            FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state = 1 and e.login_user != 1";

             DB::insert(DB::raw($query));

            $query = " UPDATE payroll_months SET state = 0, appr_author = '" . $empID . "', appr_date = '" . $todate . "'  WHERE state = 1 ";
            DB::update(DB::raw($query));

            $query = "UPDATE allowances SET state = 0 WHERE type = '1' and \"Isrecursive\" = 'NO'";
            DB::update(DB::raw($query));


            //UPDATING WCF AMOUNT AND CALCULATING IT FROM GROSS
//            $query = "update payroll_logs set wcf = COALESCE(gross, 0)*(SELECT rate_employer from deduction where id = 2)";
//            DB::update(DB::raw($query));

            //CLEAR TEMPORARY PAYROLL LOGS
            DB::table('temp_allowance_logs')->delete();
            DB::table('temp_deduction_logs')->delete();
            DB::table('temp_loan_logs')->delete();
            DB::table('temp_payroll_logs')->delete();
            DB::table('bonus')->delete();
            DB::table('overtimes')->delete();
            DB::table('once_off_deduction')->delete();

            $query = "UPDATE allowances SET state = 0 WHERE type = '0' and \"Isrecursive\" = 'NO'";
            DB::update(DB::raw($query));
        });
        return true;
    }
    //START  RUN PAYROLL FOR SCANIA

    /*
    //CLEAR or DELETE ALL PAYROLL RECORDS

    DELETE FROM payroll_logs WHERE payroll_date = "2019-07-17";
    DELETE FROM allowance_logs WHERE payment_date = "2019-07-17";
    DELETE FROM bonus_logs WHERE payment_date = "2019-07-17";
    DELETE FROM loan_logs WHERE payment_date = "2019-07-17";
    DELETE FROM deduction_logs WHERE payment_date = "2019-07-17";
    DELETE FROM overtime_logs WHERE payment_date = "2019-07-17";
    DELETE FROM payroll_months WHERE payroll_date = "2019-07-17";

    TRUNCATE payroll_logs;
    TRUNCATE allowance_logs;
    TRUNCATE bonus_logs;
    TRUNCATE loan_logs;
    TRUNCATE deduction_logs;
    TRUNCATE overtime_logs;
    TRUNCATE payroll_months;

    TRUNCATE temp_allowance_logs;
    TRUNCATE temp_deduction_logs;
    TRUNCATE temp_payroll_logs;
    TRUNCATE bonus;
    TRUNCATE overtimes;
    TRUNCATE once_off_deduction;
    DELETE FROM payroll_months WHERE status = 1;


    DELETE FROM payroll_logs WHERE payroll_date = "2019-06-05";
    DELETE FROM allowance_logs WHERE payment_date = "2019-06-05";
    DELETE FROM bonus_logs WHERE payment_date = "2019-06-05";
    DELETE FROM loan_logs WHERE payment_date = "2019-06-05";
    DELETE FROM deduction_logs WHERE payment_date = "2019-06-05";
    DELETE FROM overtime_logs WHERE payment_date = "2019-06-05";

    */

    public function RemoveaddPrevMonthSalaryArrears($date)
    {
        // dd($date);
        // $date="20-11-2023";

        $reports_model= new ReportModel();

        $previous_payroll_month_raw = date('Y-m', strtotime(date('d-m-Y', strtotime($date . "-1 month"))));


        $previous_payroll_month = $reports_model->prevPayrollMonth($previous_payroll_month_raw);

        $previous_payroll_month = date('Y-m-d', strtotime($previous_payroll_month));

        $last_day_of_month = date('Y-m-t', strtotime($previous_payroll_month));

        $days = intval(date('t', strtotime($previous_payroll_month)));

        $startDate = $previous_payroll_month;
        $endDate = $last_day_of_month;
        $daysInMonth = Carbon::parse($endDate)->daysInMonth; // Get the number of days in the month

        $employees = Employee::select([
            'emp_id',
            DB::raw("({$daysInMonth} - EXTRACT(DAY FROM hire_date) + 1) * salary / 30 AS partialpayment")
        ])
        ->where(function ($query) use ($startDate, $endDate) {
            $query->where('hire_date', '>', $startDate)
                  ->where('hire_date', '<=', $endDate);
        })
        ->get();

            foreach ($employees as $employee) {

               // Get IDs of allowances that match the conditions
                $allowances = DB::table('allowances')
                ->where('created_on', $date)
                ->where('name', 'Arrears')
                ->where('amount', $employee->partialpayment)
                ->pluck('id');

                // Delete corresponding records from allowance_logs
                DB::table('allowance_logs')
                ->where('description', 'Arrears')
                ->where('payment_date', $date)
                ->where('amount', $employee->partialpayment)
                ->delete();

                // Delete corresponding records from emp_allowance
                DB::table('emp_allowance')
                ->whereIn('allowance', $allowances)
                ->delete();
            }

    }
    public function cancel_payroll($cancel_date)
    {
        $tarehefuta = $cancel_date;
        DB::transaction(function () use ($tarehefuta) {
            DB::table('temp_allowance_logs')->delete();
            DB::table('temp_deduction_logs')->delete();
            DB::table('temp_loan_logs')->delete();
            DB::table('temp_payroll_logs')->delete();
            DB::table('temp_arrears')->delete();
            DB::table('payroll_months')->where('state', 1)->orWhere('state', 2)->delete();

            $this->RemoveaddPrevMonthSalaryArrears($tarehefuta);

            $query = "SELECT created_at,id from input_submissions order by date desc";
            $row = DB::select(DB::raw($query));
            $calender = explode('-', $row[0]->created_at);
            $date = $calender[0] . '-' . $calender[1];
            $logs = DB::table('financial_logs')->where('created_at', 'like', '%' . $date . '%')->where('input_screen', 'Payroll Input')->where('field_name', 'NOT LIKE', '%vertime%')->delete();

            DB::table('input_submissions')->where('id', $row[0]->id)->delete();
        });
        return true;
    }

    public function checkInputs($date)
    {
        $query = "SELECT COUNT(id) as total from input_submissions where created_at::text like '%" . $date . "%'";

        $row = DB::select(DB::raw($query));

        return $row[0]->total;
    }

    public function getAssignedAllowanceActive($payroll_date)
    {
        // dd($payroll_date);

        $last_date = date("Y-m-t", strtotime(now())); //Last day of the month

        $year = date('Y', strtotime($payroll_date));


        // Calculate the number of days in the month of the payroll_date
        $days = intval(date('t', strtotime($payroll_date)));


        $payroll_date = date($payroll_date);

        $query = "SELECT
    ea.*,
    a.name,
    a.state,
    CASE
        WHEN ea.mode::integer = 1 THEN ea.amount::numeric
        ELSE
            CASE
                WHEN a.type::integer = 1 THEN
                    CASE
                        WHEN AGE(DATE '" . $last_date . "', e.hire_date) < INTERVAL '1 year' THEN
                            (EXTRACT(EPOCH FROM (AGE(DATE '" . $last_date . "', e.hire_date)))/(365 * 86400) * e.salary)::numeric
                        ELSE
                            (ea.percent::numeric * e.salary)::numeric
                    END
                ELSE
                    (ea.percent::numeric *
                        CASE
                            WHEN EXTRACT(MONTH FROM e.hire_date) = EXTRACT(MONTH FROM DATE '" . $payroll_date . "')
                                AND EXTRACT(YEAR FROM e.hire_date) = EXTRACT(YEAR FROM DATE '" . $payroll_date . "') THEN
                                ((DATE_PART('day', DATE '" . $last_date . "') - (DATE_PART('day', e.hire_date) + 1)) * e.salary / 30)::numeric
                            ELSE
                                e.salary::numeric
                        END)::numeric
            END
    END AS amount
FROM
    employee e,
    emp_allowances ea,
    allowances a
WHERE
    e.emp_id = ea.empid
    AND a.id = ea.allowance
    AND a.state = 1
    AND e.state = 1
    AND e.login_user != 1";

// dd($query);

$row = DB::select(DB::raw($query));


return $row;




    }


    public function getAssignedAllowance()
    {
        $query = "SELECT ea.*,a.name,a.state from emp_allowances ea,allowances a where a.id = ea.allowance";
        $row = DB::select(DB::raw($query));
        return $row;
    }

    public function getAssignedDeduction()
    {


        $query = "SELECT ed.\"empID\",ed.deduction,d.* from emp_deductions ed, deductions d where d.id = ed.deduction";
        $row = DB::select(DB::raw($query));
        // dd($row);

        return $row;
    }

    public function checkPayrollMonth($date)
    {
        // Extract year and month from the date
        $calender = explode('-', $date);
        $month = $calender[0] . '-' . $calender[1];

        // dd($month);
        // Construct the query using TO_CHAR to format the date
        $query = "SELECT count(id) as total FROM payroll_months WHERE TO_CHAR(payroll_date, 'YYYY-MM') = ?";

        // Execute the query with parameter binding
        // dd(DB::select(DB::raw($query), [$month]));
        $row = DB::select(DB::raw($query), [$month]);


        // dd( $row[0]->total ?? 0);
        // Return the total count
        return $row[0]->total ?? 0;
    }



    public function checkInputMonth($date)
{
    // Parse the date in the mm-dd-yyyy format
    $calender = explode('-', $date);
    $month = $calender[2] . '-' . $calender[0];

    // Construct the query using TO_CHAR to format the date
    $query = "SELECT count(id) as total FROM input_submissions WHERE TO_CHAR(updated_at, 'YYYY-MM') = ?";

    // Execute the query with parameter binding
    $row = DB::select(DB::raw($query), [$month]);

    // dd($row);

    // dd($row);
    // Return the total count
    return $row[0]->total ?? 0;
}


    public function getPayrollMonth1()
    {
        // $query = "SELECT distinct payroll_date FROM temp_payroll_logs";
        $query = "SELECT '2024-08-30'::date AS payroll_date ";
        return DB::select(DB::raw($query));
    }
    public function deleteArrears($date)
    {
        DB::table('allowance_logs')->where('payment_date', $date)->delete();
        DB::table('employee_activity_grant_logs')->where('payroll_date', $date)->delete();
        DB::table('arrears_logs')->where('payroll_date', $date)->delete();
        return true;
    }
    //END RUN PAYROLL FOR SCANIA
    //PAYROLL REVIEW
    public function sdl_contribution()
    {
        $query = "rate_employer  as sdl  WHERE  id = 4";
        $row = DB::table('deduction')->select(DB::raw($query))->first();
        return $row->sdl;
    }
    public function wcf_contribution()
    {
        $query = "rate_employer as wcf  WHERE id = 2";
        $row = DB::table('deduction')->select(DB::raw($query))->first();
        return $row->wcf;
    }
    public function recent_payroll_month($currentDate)
    {
        $query = "SELECT CASE WHEN (SELECT COUNT(id) FROM payroll_months) > 0
                         THEN (SELECT payroll_date FROM payroll_months WHERE state = 0 ORDER BY id DESC LIMIT 1)
                         ELSE NULL
                    END as payroll_date";
        $row = DB::select(DB::raw($query));
        return $row[0]->payroll_date;
    }

    public function recent_payroll_month1($currentDate)
    {
        $count = DB::table('payroll_months')->select('id')->count();
        $query = "IF((" . $count . ")>0, (SELECT payroll_date WHERE state != 0 ORDER BY id DESC LIMIT 1), " . $currentDate . ") as payroll_date ";
        $row = DB::table('payroll_months')
            //->where('state','!=',0)
            ->select(DB::raw($query))->first();
        return $row->payroll_date;
    }
    public function getPayroll($payrollMonth)
    {
        $query = "SELECT
        ie.fname || ' ' || ie.mname || ' ' || ie.lname AS initName,
        CASE
            WHEN pm.state = 0 THEN
                (SELECT ae.fname || ' ' || ae.mname || ' ' || ae.lname
                 FROM employee ae
                 WHERE ae.emp_id = pm.appr_author
                   AND ae.state = 1
                   AND ae.login_user != 1)
            ELSE
                '1'
        END AS apprName,
        pm.*
    FROM
        payroll_months pm
    JOIN
        employee ie ON ie.emp_id = pm.init_author
                    AND ie.state = 1
                    AND ie.login_user != 1
    WHERE
        pm.payroll_date = '" . $payrollMonth . "'
    ";
        return $query;
    }
    public function payrollTotals($table, $payrollMonth)
    {


        $query = "SELECT SUM(less_takehome) as takehome_less, SUM(salary) as salary, SUM(pension_employee) as pension_employee, SUM(pension_employer) as pension_employer,  SUM(medical_employer) as medical_employer, SUM(medical_employee) as medical_employee, SUM(allowances) as allowances, SUM(taxdue) as taxdue, SUM(meals) as meals, SUM(sdl) as sdl, SUM(wcf) as wcf FROM " . $table . " WHERE payroll_date = '" . $payrollMonth . "'";

        return DB::select(DB::raw($query));
    }
    public function staffPayrollTotals($table, $payrollMonth)
    {


        $query = "SELECT SUM(pl.less_takehome) as takehome_less, SUM(pl.salary) as salary, SUM(pl.pension_employee) as pension_employee, SUM(pl.pension_employer) as pension_employer,  SUM(pl.medical_employer) as medical_employer, SUM(pl.medical_employee) as medical_employee, SUM(pl.allowances) as allowances, SUM(pl.taxdue) as taxdue, SUM(pl.meals) as meals, SUM(pl.sdl) as sdl, SUM(pl.wcf) as wcf
        FROM " . $table . " as pl, employee e where e.emp_id = pl.empID and e.contract_type != 2 and payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function temporaryPayrollTotals($table, $payrollMonth)
    {


        $query = "SELECT SUM(pl.less_takehome) as takehome_less, SUM(pl.salary) as salary, SUM(pl.pension_employee) as pension_employee, SUM(pl.pension_employer) as pension_employer,  SUM(pl.medical_employer) as medical_employer, SUM(pl.medical_employee) as medical_employee, SUM(pl.allowances) as allowances, SUM(pl.taxdue) as taxdue, SUM(pl.meals) as meals, SUM(pl.sdl) as sdl, SUM(pl.wcf) as wcf
        FROM " . $table . " as pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function temp_payrollTotals($table, $payrollMonth)
    {


        $query = "SELECT SUM(salary) as salary, SUM(pension_employee) as pension_employee, SUM(pension_employer) as pension_employer,  SUM(medical_employer) as medical_employer, SUM(medical_employee) as medical_employee, SUM(allowances) as allowances, SUM(taxdue) as taxdue, SUM(meals) as meals, SUM(sdl) as sdl, SUM(wcf) as wcf FROM " . $table . " WHERE payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function total_allowances($table, $payrollMonth)
    {


        $query = "SUM(amount) as amount";
        $row = DB::table($table)->where("payment_date", $payrollMonth)->select(DB::raw($query))->first();
        return $row->amount;
    }
    public function total_loans($table, $payrollMonth)
    {


        $query = "SELECT SUM(paid) as paid, SUM(remained) as remained FROM  " . $table . " WHERE payment_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function total_loans_separate($table, $payrollMonth)
    {


        $query = "SELECT sum(tlg.paid) as paid, sum(tlg.remained) as remained, l.description
FROM temp_loan_logs tlg, loan l WHERE l.id = tlg.\"loanID\" and payment_date = '" . $payrollMonth . "' group by l.description";
        return DB::select(DB::raw($query));
    }
    public function total_heslb($table, $payrollMonth)
    {

        $query = "SELECT SUM(ll.paid) as paid FROM  " . $table . " ll, loan lo WHERE ll.payment_date = '" . $payrollMonth . "' AND ll.\"loanID\" = lo.id AND lo.type = 3";
        $row = DB::select(DB::raw($query));
        return $row[0]->paid;
    }



    public function total_deductions($table, $payrollMonth)
    {

        $query = "SUM(paid) as paid";
        $row = DB::table($table)->where('payment_date', $payrollMonth)->select(DB::raw($query))->first();
        return $row->paid;
    }
    public function total_bonuses($payrollMonth)
    {


        $query = "SUM(amount) as amount";
        $row = DB::table('bonus_logs')->where('payment_date', $payrollMonth)->select(DB::raw($query))->first();
        return $row->amount;
    }
    public function total_overtimes($payrollMonth)
    {


        $query = "SUM(amount) as amount";
        $row = DB::table('overtime_logs')->where('payment_date', $payrollMonth)->select(DB::raw($query))->first();
        return $row->amount;
    }
    public function payroll_month_info($payrollMonth)
    {


        $query = "SELECT * FROM payroll_months WHERE payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function payroll_review($empID, $table, $payrollMonth)
    {


        $query = "SELECT CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, b.name as bank, bb.name as branch, cbr.name as company_branch, bb.swiftcode, pf.name as pensionFundName, pf.*,  tpl.* FROM employee e, " . $table . " tpl,  bank_branch bb, bank b, pension_fund pf, branch cbr WHERE tpl.empID = e.emp_id and e.state = 1 AND bb.id= tpl.bank_branch AND b.id = tpl.bank AND tpl.pension_fund = pf.id  AND cbr.id = tpl.branch AND tpl.empID = '" . $empID . "' AND tpl.payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function allowances_review($empID, $table, $payrollMonth)
    {


        $query = "SELECT @s:=@s+1 AS SNo,  tal.* FROM " . $table . " tal,(SELECT @s:=0) AS s WHERE tal.empID = '" . $empID . "' AND tal.payment_date = '" . $payrollMonth . "' ";
        return DB::select(DB::raw($query));
    }
    public function deductions_review($empID, $table, $payrollMonth)
    {


        $query = "SELECT @s:=@s+1 AS SNo,  tdl.* FROM " . $table . " tdl,(SELECT @s:=0) AS s WHERE tdl.empID = '" . $empID . "' AND tdl.payment_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function loans_review($empID, $table, $payrollMonth)
    {


        $query = "SELECT @s:=@s+1 AS SNo, tll.paid as pre_paid,  tll.*, l.* FROM " . $table . " tll, loan l,(SELECT @s:=0) AS s WHERE tll.loanID = l.id AND l.empID = '" . $empID . "' AND tll.payment_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }
    public function total_allowances_review($empID, $table, $payrollMonth)
    {


        $query = "SUM(tal.amount) as total_al  WHERE tal.empID = '" . $empID . "' AND tal.payment_date = '" . $payrollMonth . "'";
        $table2 = $table . "as tal";
        $row = DB::table($table2)->select(DB::raw($query))->first();
        return $row->total_al;
    }
    public function total_deductions_review($empID, $table, $payrollMonth)
    {


        $query = "SUM(tdl.paid) as total_de WHERE tdl.empID = '" . $empID . "' AND tdl.payment_date = '" . $payrollMonth . "'";
        $table2 = $table . "as tdl";
        $row = DB::table($table2)->select(DB::raw($query))->first();
        return $row->total_de;
    }
    public function total_loans_review($empID, $table, $payrollMonth)
    {


        $query = "SELECT SUM(amount_last_paid) as total_last_paid, SUM(pre_paid) as total_paid_currently, SUM(amount) as total_loans, SUM(remained) as total_remained FROM (SELECT tll.paid as pre_paid,  tll.remained, l.amount, l.amount_last_paid  FROM " . $table . " tll, loan l WHERE tll.loanID = l.id AND l.empID = '" . $empID . "'  AND tll.payment_date = '" . $payrollMonth . "') AS parent_query ";
        return DB::select(DB::raw($query));
    }
    public function employeePayrollList($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs)
    {

        $query = DB::table('employee as e')
        ->join(DB::raw('payroll_logs pl'), function ($join) use ($date) {
            $join->on('pl.empID', '=', 'e.emp_id')
                 ->where('pl.payroll_date', '=', $date);
        })
        ->join('department as d', 'pl.department', '=', 'd.id')
        ->join('position as p', 'pl.position', '=', 'p.id')
        ->where('e.state', '=', 1)
        ->where('e.login_user', '!=', 1)
        ->select(
            DB::raw("row_number() OVER () AS SNo"),
            'pl.empID',
            DB::raw("e.fname || ' ' || COALESCE(e.mname, '') || ' ' || e.lname AS empName"),
            DB::raw("COALESCE(
                        (SELECT SUM(al.amount)
                         FROM " . $table_allowance_logs . " al
                         WHERE al.\"empID\" = e.emp_id
                         AND al.payment_date = '" . $date . "'
                         GROUP BY al.\"empID\"),
                        0
                     ) AS allowances"),
            'p.name as position',
            'd.name as department',
            'pl.salary',
            'pl.meals',
            'pl.pension_employee AS pension',
            'pl.taxdue',
            DB::raw("COALESCE(
                        (SELECT SUM(ll.paid)
                         FROM " . $table_loan_logs . " ll
                         JOIN loan l ON ll.\"loanID\" = l.id
                         WHERE l.empID = e.emp_id
                         AND ll.payment_date = '" . $date . "'
                         GROUP BY l.empID),
                        0
                     ) AS loans"),
            DB::raw("COALESCE(
                        (SELECT SUM(dl.paid)
                         FROM " . $table_deduction_logs . " dl
                         WHERE dl.\"empID\" = e.emp_id
                         AND dl.payment_date = '" . $date . "'
                         GROUP BY dl.\"empID\"),
                        0
                     ) AS deductions")
        )
        ->get();
          return $query;
    }
    public function employeeTempPayrollList($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs, $table_arrears)
    {
        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName,
        IF((SELECT SUM(ar.amount) FROM " . $table_arrears . " ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '" . $date . "')>0, (SELECT SUM(ar.amount) FROM " . $table_arrears . " ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '" . $date . "'), 0) AS arrear_amount,
		IF((SELECT SUM(al.amount) FROM " . $table_allowance_logs . " al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM " . $table_allowance_logs . " al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances, p.name as position, d.name as department,
		pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
		IF((SELECT SUM(ll.paid) FROM " . $table_loan_logs . " ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM " . $table_loan_logs . " ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
		IF((SELECT SUM(dl.paid) FROM " . $table_deduction_logs . " dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM " . $table_deduction_logs . " dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions
		FROM employee e, " . $table_payroll_logs . "  pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND e.state = 1 and e.login_user != 1 and pl.position = p.id and pl.department = d.id AND pl.payroll_date = '" . $date . "'";
        return DB::select(DB::raw($query));
    }
    public function employeeTempPayrollList1($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs, $table_arrears)
    {
        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName,
        IF((SELECT SUM(ar.amount) FROM " . $table_arrears . " ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '" . $date . "')>0, (SELECT SUM(ar.amount) FROM " . $table_arrears . " ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '" . $date . "'), 0) AS arrear_amount,
		IF((SELECT SUM(al.amount) FROM " . $table_allowance_logs . " al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM " . $table_allowance_logs . " al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances, p.name as position, d.name as department,
		pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
		IF((SELECT SUM(ll.paid) FROM " . $table_loan_logs . " ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM " . $table_loan_logs . " ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
		IF((SELECT SUM(dl.paid) FROM " . $table_deduction_logs . " dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM " . $table_deduction_logs . " dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions
		FROM employee e, " . $table_payroll_logs . "  pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND e.state = 1 and e.login_user != 1 and pl.position = p.id and pl.department = d.id AND pl.payroll_date = '" . $date . "'";
        return DB::select(DB::raw($query));
    }
    /*
        public function employeePayrollList($table, $payrollMonth){

            $query = "SELECT @s:=@s+1 AS SNo, pl.empID, pl.salary, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, p.name as position, d.name as department  FROM employee e, ".$table." pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND  pl.position = p.id and pl.department = d.id AND pl.payroll_date = '".$payrollMonth."'";

            return DB::select(DB::raw($query));
        }*/
    public function getPayrollMonth()
    {
        $query = " payroll_date  ORDER BY id DESC LIMIT 1";
        $row = DB::table('payroll_logs')->select(DB::raw($query))->first();
        return $row->payroll_date;
    }
    public function updatePayrollMail($payrollDate)
    {
        $query = " UPDATE payroll_months SET email_status = 1 WHERE payroll_date = '" . $payrollDate . "'";
        DB::insert(DB::raw($query));
        return true;
    }
    public function senderInfo()
    {
        $query = DB::table('company_emails')->select('host', 'username', 'password', 'email', 'name', 'secure', 'port')->where('use_as', 1)->where('state', 1)->limit(1)->first();
        return $query;
    }
    // Real public function
    /*public function send_payslips($payroll_date){

        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1) AND payroll_date = '".$payroll_date."' ";

        return DB::select(DB::raw($query));
    }*/
    // Below is the Test public function
    public function send_payslips($payroll_date)
    {
        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND employee.state = 1 and payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }
    public function update_payroll_month($updates, $payroll_date, $arrearID, $dataLogs, $dataUpdates)
    {
        DB::transaction(function () use ($updates, $payroll_date, $arrearID, $dataLogs, $dataUpdates) {
            DB::table('payroll_months')->where('payroll_date', $payroll_date)->update($updates);
            DB::table('arrears')->where('id', $arrearID)->update($dataUpdates);
            DB::table('arrears_logs')->insert($dataLogs);
            DB::table('arrears')->where('paid', '>=', 'amount')->update('status', 0);
            DB::table('arrears_pendings')->truncate();
        });
        return true;
    }
    public function update_payroll_month_only($updates, $payroll_date)
    {
        DB::transaction(function () use ($payroll_date, $updates) {
            DB::table('payroll_months')->where('payroll_date', $payroll_date)->update($updates);
        });
        return true;
    }
    public function lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth)
    {
        DB::transaction(function () use ($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth) {
            DB::table('payroll_months')->where('payroll_date', $payrollMonth)->update($update_payroll_months);
            DB::table('arrears')->insert($update_arrears);
            DB::table('payroll_logs')->where('payroll_date', $payrollMonth)->where('empID', $empID)->update($update_payroll_logs);
        });
        return true;
    }
    public function temp_lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth)
    {
        DB::transaction(function () use ($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth) {
            DB::table('payroll_months')->where('payroll_date', $payrollMonth)->update($update_payroll_months);
            DB::table('temp_arrears')->insert($update_arrears);
            DB::table('arrears')->insert($update_arrears);
            DB::table('payroll_logs')->where('payroll_date', $payrollMonth)->where('empID', $empID)->update($update_payroll_logs);
        });
        return true;
    }
    public function all_arrears_individual()
    {
        $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state = 1 AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        return DB::select(DB::raw($query));
    }
    public function all_arrears_payroll_month()
    {
        $query = "SELECT ar.payroll_date,  SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE payroll_date = ar.payroll_date ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar WHERE ar.status = 1 GROUP BY ar.payroll_date ORDER BY ar.payroll_date DESC";
        return DB::select(DB::raw($query));
    }
    public function arrears($start, $finish)
    {
        if ($finish > $start) {
            $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state = 1 AND ar.payroll_date BETWEEN '" . $start . "' AND '" . $finish . "' AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        } else {
            $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state = 1 AND ar.payroll_date BETWEEN '" . $finish . "' AND '" . $start . "' AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        }
        return DB::select(DB::raw($query));
    }
    public function OLD_pending_arrears_payment()
    {
        $query = "SELECT (@s:=@s+1) as SNo, ar.empID, ar.payroll_date, ar.amount as arrear_amount, ar.paid as arrear_paid, CONCAT(fname,' ', mname,' ', lname) AS empName, arp.* FROM employee e, arrears ar, arrears_pendings arp, (SELECT @s:=0) as s WHERE ar.empID = e.emp_id and e.state = 1 AND ar.id = arp.arrear_id";
        return DB::select(DB::raw($query));
    }
    public function pending_arrears_payment()
    {
        $query1 = "SELECT (@s:=@s+1) as SNo, arp.id, ar.empID, ar.payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(arp.amount) as amount, arp.status, ar.amount as arrear_amount, ar.paid as arrear_paid, ar.payroll_date, ar.last_paid_date, ar.amount_last_paid as amount_last_paid FROM employee e, arrears ar, arrears_pendings arp, (SELECT @s:=0) as s WHERE ar.empID = e.emp_id and e.state = 1 AND ar.id = arp.arrear_id GROUP BY e.fname,e.mname,e.lname,ar.payroll_date, ar.empID, ar.last_paid_date, ar.amount, ar.amount_last_paid, ar.paid,arp.id, arp.status";
        $query = "SELECT ROW_NUMBER() OVER (ORDER BY arp.id) AS SNo, arp.id, ar.empID, ar.payroll_date,
        CONCAT(e.fname, ' ', COALESCE(e.mname, ''), ' ', e.lname) AS empName,
        SUM(arp.amount) as amount, arp.status, ar.amount as arrear_amount,
        ar.paid as arrear_paid, ar.payroll_date, ar.last_paid_date
 FROM arrears_pendings arp
 JOIN arrears ar ON arp.id = ar.id
 JOIN employee e ON ar.empID = e.emp_id
 GROUP BY arp.id, ar.empID, ar.payroll_date, empName, arp.status, ar.amount, ar.paid, ar.payroll_date, ar.last_paid_date
 ORDER BY arp.id";
        return DB::select(DB::raw($query));
    }
    public function employee_arrears($empID)
    {
        $query = "SELECT (@s:=@s+1) AS SNo,  ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '" . $empID . "'";
        return DB::select(DB::raw($query));
    }
    public function employee_arrears1($empID, $payroll_date)
    {
        $query = "SELECT (@s:=@s+1) AS SNo,  ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '" . $empID . "' AND ar.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }
    public function monthly_arrears($payroll_month)
    {
        $query = "SELECT (@s:=@s+1) AS SNo, ar.*,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM employee e, arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id and e.state = 1 and e.login_user != 1 AND pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID and ar.status = 1 AND ar.payroll_date = '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }
    public function approved_arrears()
    {
        $query = "SELECT  ar.paid, arp.arrear_id, arp.amount, ar.payroll_date, arp.init_by, arp.confirmed_by, arp.date_confirmed FROM arrears_pendings arp, arrears ar WHERE arp.arrear_id = ar.id AND arp.status = 1";
        return DB::select(DB::raw($query));
    }
    public function checkPendingArrearPayment($arrearID)
    {
        $query = "COUNT(id) as counts  WHERE arrear_id =" . $arrearID . "";
        $row = DB::table('arrears_pendings')->select(DB::raw($query))->count();
        $result = $row;
        if ($result > 0) {
            return true;
        } else
            return false;
    }
    public function updatePendingArrear($arrearID, $updates)
    {
        DB::table('arrears_pendings')->where('arrear_id', $arrearID)->update($updates);
        return true;
    }
    public function confirmPendingArrear($arrearID, $updates)
    {
        DB::table('arrears_pendings')->where('arrear_id', $arrearID)->update($updates);
        return true;
    }
    public function getArrear($id)
    {
        $query = "SELECT * FROM arrears_pendings WHERE id = " . $id . "";
        return DB::select(DB::raw($query));
    }
    public function getArrear1($id)
    {
        $query = "SELECT * FROM arrears WHERE id = " . $id . "";
        return DB::select(DB::raw($query));
    }
    public function getArrearLog($id)
    {
        $query = "SELECT * FROM arrears_logs WHERE arrear_id = '" . $id . "'";
        return DB::select(DB::raw($query));
    }
    public function insertArrearLog($data)
    {
        DB::table('arrears_logs')->insert($data);
    }
    public function updateArrearLog($id, $data)
    {
        DB::table('arrears_logs')->where('id', $id)->update($data);
    }
    public function updateArrear($id, $data)
    {
        DB::table('arrears')->where('id', $id)->update($data);
        DB::table('temp_arrears')->where('id', $id)->update($data);
    }
    public function getPreviousArrears($month, $year)
    {
        $query = "SELECT * FROM arrears WHERE month(payroll_date)= '" . $month . "' and year(payroll_date)= '" . $year . "'";
        return DB::select(DB::raw($query));
    }
    // SELECT (@s:=@s+1) AS SNo, ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '2550001' AND ar.id = 10
    public function arrearsPayment($arrearID, $dataLogs, $dataUpdates)
    {
        DB::transaction(function () use ($arrearID, $dataLogs, $dataUpdates) {
            DB::table('arrears')->where('id', $id)->update($dataUpdates);
            DB::table('arrears_logs')->insert($dataLogs);
        });
        return true;
    }
    public function arrearsPayment_schedule($data)
    {
        DB::table('arrears_pendings')->insert($data);
        return true;
    }
    public function arrearsMonth($payrollMonth)
    {


        $query = "SELECT sum(amount) as arrear_payment from arrears where payroll_date = '" . $payrollMonth . "'";
        $row = DB::select(DB::raw($query));
        if ($row[0]) {
            return $row[0]->arrear_payment;
        } else {
            return 0;
        }
    }
    public function arrearsPending()
    {
        $query = "select * from arrears_pendings where status = 1";
        return DB::select(DB::raw($query));
    }
    public function arrearsPendingByArrearId()
    {
        $query = "select arrear_id from arrears_pendings where status = 1 group by arrear_id";
        return DB::select(DB::raw($query));
    }
    public function truncateArrearsPending()
    {
        DB::table('arrears_pendings')->where('status', 1)->delete();
        return true;
    }
    public function insertAllocation($data)
    {
        DB::table('employee_activity_grant_logs')->insert($data);
        return true;
    }
    // sum_employee_arrears
    /*public function send_payslips($payrollDate){

        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND payroll_date = '".$payrollDate."'";

        return DB::select(DB::raw($query));
    }*/
    public function partial_payment_list()
    {
        $query = "SELECT (@s:=@s+1) as SNo, pp.*, concat(e.fname,'',e.mname,' ',e.lname) as name FROM partial_payment pp, employee e,(SELECT @s:=0) as s where pp.empID = e.emp_id and pp.status = 0 ORDER BY pp.id DESC";
        return DB::select(DB::raw($query));
    }
    public function pensionAll()
    {
        $query = "select * from pension_fund";
        return DB::select(DB::raw($query));
    }
    public function temp_payroll_check($payroll_date)
    {
        $query = "select * from temp_payroll_logs where payroll_date= '" . $payroll_date . "' ";
        return DB::select(DB::raw($query));
    }
    public function role($permission)
    {
        $query = "select * from role where permissions like '" . $permission . "' ";
        return DB::select(DB::raw($query));
    }
    public function employeeRole($role_id)
    {
        $query = "SELECT er.userID as empID, e.fname, e.email FROM emp_role er, employee e where er.userID = e.emp_id and er.role = '" . $role_id . "' ";
        return DB::select(DB::raw($query));
    }
    public function mailConfig()
    {
        $query = "SELECT * FROM company_emails limit 1 ";
        return DB::select(DB::raw($query));
    }
    public function saveMail($id, $data)
    {
        $result = DB::able('company_emails')->where('id', $id)->update($data);
        return $result;
    }
}
