<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    //NEW EMPLOYMENT COST


    //     function new_employment_cost_employee_list($date)
    //     {

    //         $query = "SELECT pl.empID, dpt.name, dpt.code, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
    // 	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
    //  IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
    // 	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
    // 	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
    // 	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
    // 	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
    //  pl.account_no
    // 	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '" . $date . "'";

    //         return DB::select(DB::raw($query));
    //     }

    function new_employment_cost_employee_list($date)
    {
        $query = "SELECT pl.empID, dpt.name, dpt.code, CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) AS name,
              COALESCE((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
              COALESCE((SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 AND al.empID = pl.empID AND al.payment_date = pl.payroll_date LIMIT 1), 0) as housingAllowance,
              COALESCE((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date AND ol.empID = pl.empID GROUP BY ol.empID), 0) as overtimes,
              pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
              COALESCE((SELECT SUM(ll.paid) FROM loan_logs ll JOIN loan l ON e.emp_id = l.empID AND ll.loanID = l.id WHERE ll.payment_date = pl.payroll_date GROUP BY l.empID), 0) AS loans,
              COALESCE((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID), 0) AS deductions,
              pl.account_no
              FROM employee e
              JOIN payroll_logs pl ON pl.\"empID\" = e.emp_id
              JOIN department dpt ON dpt.id = pl.department
              WHERE pl.payroll_date = :date";

        return DB::select(DB::raw($query), ['date' => $date]);
    }


    function s_new_employment_cost_employee_list1($date)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function a_new_employment_cost_employee_list1_temp($date)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, temp_payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id  AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function v_new_employment_cost_employee_list1($date)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    //END EMPLOYMENT COST

    //EMPLOYEE BIO DATA
    function s_employee_bio_data_active($date)
    {

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type != 2 and e.state != 4 ";

        return DB::select(DB::raw($query));
    }

    function s_employee_bio_data_inactive($date)
    {

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type != 2 and e.state = 4 ";

        return DB::select(DB::raw($query));
    }

    function v_employee_bio_data_active($date)
    {

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type = 2 and e.state != 4 ";

        return DB::select(DB::raw($query));
    }

    function v_employee_bio_data_inactive($date)
    {

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type = 2 and e.state = 4 ";

        return DB::select(DB::raw($query));
    }

    //END EMPLOYEE BIO DATA



    function payCheklistStatus($payroll_date)
    {
        $query = "COUNT(id) as counts  WHERE payroll_date = '" . $payroll_date . "' AND pay_checklist = 1";
        $row = DB::table('payroll_months')
            ->select(DB::raw($query))
            ->first();
        $status = $row->counts;
        if ($status > 0) {
            return true;
        } else return false;
    }


    function pay_checklist($date)
    {

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,pl.rate,pl.currency,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '" . $date . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }



    function temp_pay_checklist($date)
    {

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function staff_pay_checklist($date)
    {

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function temporary_pay_checklist($date)
    {

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type = 2 AND pl.payroll_date = '" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function payrollAuthorization($payrollMonth)
    {
        $query = "SELECT CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS initName, CONCAT(er.fname,' ', er.mname,' ', er.lname) AS recomName, CONCAT(er.fname,' ', er.mname,' ', er.lname) AS financeRecomName, CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) AS confName, pm.appr_date, pm.init_date, pm.recom_date,pm.recom_date2 FROM employee e, employee ea, employee er, payroll_months pm WHERE pm.init_author = e.emp_id AND pm.appr_author = ea.emp_id AND pm.recom_author = er.emp_id AND pm.recom_author2 = er.emp_id and pm.payroll_date = '" . $payrollMonth . "'";
        return DB::select(DB::raw($query));
    }

    function sum_take_home($date)
    {
        $query = "SELECT
                    -- SUM(takehome) as total_takehome,
                    -- SUM(takehome_less) as total_takehome_less
                  FROM (
                    SELECT
                        pl.\"id\",
                        CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) AS name,
                        COALESCE(
                            (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.\"empID\" = e.\"emp_id\" AND al.payment_date = pl.payroll_date GROUP BY al.\"empID\"),
                            0
                        ) AS allowances,
                        pl.less_takehome,
                        pl.salary,
                        pl.meals,
                        pl.pension_employee AS pension,
                        pl.taxdue,
                        COALESCE(
                            (SELECT SUM(ll.paid) FROM loan_logs ll JOIN loan l ON e.\"emp_id\" = l.\"empID\" AND ll.\"loanID\" = l.id WHERE ll.payment_date = pl.payroll_date GROUP BY l.\"empID\"),
                            0
                        ) AS loans,
                        COALESCE(
                            (SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.\"empID\" = e.\"emp_id\" AND dl.payment_date = pl.payroll_date GROUP BY dl.\"empID\"),
                            0
                        ) AS deductions,
                        b.name as bank,
                        bb.name as branch,
                        bb.swiftcode,
                        pl.account_no
                    FROM
                        employee e
                        JOIN payroll_logs pl ON pl.\"id\" = e.\"id\"
                        JOIN bank_branch bb ON bb.id = e.bank_branch
                        JOIN bank b ON b.id = e.bank
                    WHERE
                        pl.payroll_date = :date
                  ) as parent_query";

        return DB::select(DB::raw($query), ['date' => $date]);
    }


    function temp_sum_take_home($date)
    {

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
        IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
        pl.less_takehome,
        pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
        IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,

        IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
        b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
        FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '" . $date . "') as parent_query";
        return DB::select(DB::raw($query));
    }

    function temp_sum_take_home1($date)
    {

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '" . $date . "') as parent_query";
        return DB::select(DB::raw($query));
    }

    public function staff_sum_take_home($date)
    {
        $query = "SELECT
                    SUM(salary + allowances - pension - loans - deductions - meals - taxdue) as takehome,
                    SUM(less_takehome) as takehome_less
                  FROM (
                    SELECT
                        pl.\"empID\",
                        CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) AS name,
                        COALESCE(
                            (
                                SELECT SUM(al.amount)
                                FROM allowance_logs al
                                WHERE al.\"empID\" = e.emp_id
                                AND (e.contract_type::integer <> 2 OR e.contract_type IS NULL)
                                AND al.payment_date = :date -- Use parameterized query
                                GROUP BY al.\"empID\"
                            ),
                            0
                        ) AS allowances,
                        pl.less_takehome,
                        pl.salary,
                        pl.meals,
                        pl.pension_employee AS pension,
                        pl.taxdue,

                        COALESCE(
                            (
                                SELECT SUM(ll.paid)
                                FROM loan_logs ll
                                JOIN loan l ON e.emp_id = l.\"empID\"
                                WHERE e.contract_type::integer <> 2
                                  AND ll.\"loanID\" = l.id
                                  AND ll.payment_date = :date -- Use parameterized query
                                GROUP BY l.\"empID\"
                            ),
                            0
                        ) AS loans,

                        COALESCE(
                            (
                                SELECT SUM(dl.paid)
                                FROM deduction_logs dl
                                WHERE dl.\"empID\" = e.emp_id
                                  AND e.contract_type::integer <> 2
                                  AND dl.payment_date = :date -- Use parameterized query
                                GROUP BY dl.\"empID\"
                            ),
                            0
                        ) AS deductions,

                        b.name as bank,
                        bb.name as branch,
                        bb.swiftcode,
                        pl.account_no
                    FROM
                        employee e
                        JOIN payroll_logs pl ON pl.\"empID\" = e.emp_id
                        JOIN bank_branch bb ON bb.id = e.bank_branch
                        JOIN bank b ON b.id = e.bank
                    WHERE
                        e.contract_type::integer <> 2 AND
                        pl.payroll_date = :date -- Use parameterized query
                  ) as parent_query";

        return DB::select(DB::raw($query), ['date' => $date]);
    }



    function staff_sum_take_home_temp($date)
    {

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type != 2 AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '" . $date . "') as parent_query";
        return DB::select(DB::raw($query));
    }

    function temporary_sum_take_home($date)
    {
        $query = "SELECT
                SUM(salary + allowances - pension - loans - deductions - meals - taxdue) as takehome,
                SUM(less_takehome) as takehome_less
              FROM (
                SELECT
                    pl.\"empID\",
                    CONCAT(e.fname, ' ', COALESCE(NULLIF(e.mname, ''), ' '), ' ', e.lname) AS name,
                    COALESCE(
                        (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.\"empID\" = e.emp_id AND e.contract_type::integer = 2 AND al.payment_date = :date GROUP BY al.\"empID\"),
                        0
                    ) AS allowances,
                    pl.less_takehome,
                    pl.salary,
                    pl.meals,
                    pl.pension_employee AS pension,
                    pl.taxdue,
                    COALESCE(
                        (SELECT SUM(ll.paid) FROM loan_logs ll JOIN loan l ON e.emp_id = l.\"empID\" WHERE e.contract_type::integer = 2 AND ll.payment_date = :date GROUP BY l.\"empID\"),
                        0
                    ) AS loans,
                    COALESCE(
                        (SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.\"empID\" = e.emp_id AND e.contract_type::integer = 2 AND dl.payment_date = :date GROUP BY dl.\"empID\"),
                        0
                    ) AS deductions,
                    b.name as bank,
                    bb.name as branch,
                    bb.swiftcode,
                    pl.account_no
                FROM
                    employee e
                    JOIN payroll_logs pl ON pl.\"empID\" = e.emp_id
                    JOIN bank_branch bb ON bb.id = e.bank_branch
                    JOIN bank b ON b.id = e.bank
                WHERE
                    e.contract_type::integer = 2 AND
                    pl.payroll_date = :date
              ) as parent_query";

        return DB::select(DB::raw($query), ['date' => $date]);
    }


    function temporary_sum_take_home_temp($date)
    {

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '" . $date . "' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '" . $date . "' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = '" . $date . "' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type = 2 AND ll.loanID = l.id AND ll.payment_date = '" . $date . "' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id and e.contract_type = 2 AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '" . $date . "') as parent_query";
        return DB::select(DB::raw($query));
    }

    function p9($date)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.postal_address as postal_address,e.emp_id, e.postal_city as postal_city, pl.*
	FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 AND pl.payroll_date = '" . $date . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }

    function s_p9($date)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,e.emp_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
    FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.branch = 1 AND e.state = 1 and e.contract_type != 2 AND pl.payroll_date = '" . $date . "' order by e.emp_id ASC
    ";


        return DB::select(DB::raw($query));
    }

    function s_p9_termination($date)
    {
        $raw_date = explode('-', $date);
        $terminationDate = $raw_date[0] . '-' . $raw_date[1];
        //dd($terminationDate);

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,e.emp_id, e.postal_address as postal_address, e.postal_city as postal_city, tm.*
        FROM employee AS e, (SELECT @s:=0) AS s, terminations tm WHERE tm.employeeID = e.emp_id AND e.state = 4 and e.contract_type != 2 AND tm.terminationDate LIKE '%" . $terminationDate . "%' order by e.emp_id ASC
     ";


        return DB::select(DB::raw($query));
    }


    function v_p9($date)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.postal_address as postal_address, e.tin as tin, e.national_id as national_id, e.postal_city as postal_city, pl.*
    FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id  AND e.state = 1 and e.contract_type = 2 AND pl.payroll_date = '" . $date . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }

    function p91($period_start, $period_end)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name,e.emp_id, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and pl.payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }
    function s_p91($period_start, $period_end)
    {
        $raw1  = explode('-', $period_start);
        $raw2  = explode('-', $period_end);
        $termination_start = $raw1[0] . '-' . $raw1[1] . '-01';
        $termination_end = $raw2[0] . '-' . $raw2[1] . '-01';

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,e.emp_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
        FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type != 2 and pl.payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }

    function s_p91_terminated($period_start, $period_end)
    {
        $raw1  = explode('-', $period_start);
        $raw2  = explode('-', $period_end);
        $termination_start = $raw1[0] . '-' . $raw1[1] . '-01';
        $termination_end = $raw2[0] . '-' . $raw2[1] . '-01';
        $termination_date =  $raw2[0] . '-' . $raw2[1];
        if ($termination_start != $termination_end) {

            $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin,e.emp_id, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, tm.*
        FROM employee AS e, (SELECT @s:=0) AS s, terminations tm WHERE tm.employeeID = e.emp_id AND e.state = 4 and e.contract_type != 2 and tm.terminationDate BETWEEN   '" . $termination_start . "' AND '" . $termination_end . "' order by e.emp_id ASC";
        } else {

            $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address,e.emp_id, e.postal_city as postal_city, tm.*
    FROM employee AS e, (SELECT @s:=0) AS s, terminations tm WHERE tm.employeeID = e.emp_id AND e.state = 4 and e.contract_type != 2 and tm.terminationDate LIKE   '%" . $termination_date . "%' order by e.emp_id ASC";
        }
        return DB::select(DB::raw($query));
    }

    function v_p91($period_start, $period_end)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,e.emp_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type = 2 and pl.payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' order by e.emp_id ASC";

        return DB::select(DB::raw($query));
    }

    function totalp9($date)
    {
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID AND pl.payroll_date = '" . $date . "'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function s_totalp9($date)
    {
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 AND pl.payroll_date = '" . $date . "'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function v_totalp9($date)
    {
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 AND pl.payroll_date = '" . $date . "'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function company_info()
    {
        $query = 'SELECT * FROM company_info';
        return DB::select(DB::raw($query));
    }



    function p10check($period_start, $period_end)
    {
        $query = " SELECT id  FROM payroll_logs WHERE payroll_date  BETWEEN '" . $period_start . "' AND '" . $period_end . "' ";
        return count(DB::select(DB::raw($query)));
    }
    function p10($period_start, $period_end)
    {
        $query = "SELECT payroll_date, SUM(salary) as sum_salary, SUM(salary+allowances) as sum_gross, SUM(sdl) as sum_sdl FROM payroll_logs WHERE payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }

    function s_p10($period_start, $period_end)
    {

        $query = "SELECT payroll_date, SUM(pl.salary) as sum_salary, SUM(pl.salary+pl.allowances) as sum_gross, SUM(pl.sdl) as sum_sdl
FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 and payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }



    function v_p10($period_start, $period_end)
    {
        $query = "SELECT payroll_date, SUM(pl.salary) as sum_salary, SUM(pl.salary+pl.allowances) as sum_gross, SUM(pl.sdl) as sum_sdl
FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 and payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }

    function totalp10($period_start, $period_end)
    {
        $query = " SELECT SUM(salary) as total_salary, SUM(salary+allowances) as total_gross, SUM(sdl) as total_sdl FROM payroll_logs WHERE payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "'";
        return DB::select(DB::raw($query));
    }

    function s_totalp10($period_start, $period_end)
    {
        $query = " SELECT SUM(pl.salary) as total_salary, SUM(pl.salary+pl.allowances) as total_gross, SUM(pl.sdl) as total_sdl
 FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type != 2 and payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "'";
        return DB::select(DB::raw($query));
    }

    function v_totalp10($period_start, $period_end)
    {
        $query = " SELECT SUM(pl.salary) as total_salary, SUM(pl.salary+pl.allowances) as total_gross, SUM(pl.sdl) as total_sdl
 FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type = 2 and payroll_date BETWEEN   '" . $period_start . "' AND '" . $period_end . "'";
        return DB::select(DB::raw($query));
    }


    function heslb($payrolldate)
    {
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE l.empID = e.emp_id AND ll.loanID = l.id AND l.type = 3 AND ll.payment_date = '" . $payrolldate . "'";
        return DB::select(DB::raw($query));
    }

    function get_payroll_temp_summary($date)
    {


        $query = 'SELECT @s:=@s+1 SNo, a.* FROM allowance_categories a , (SELECT @s:=0) as s ';

        $categories = DB::select(DB::raw($query));

        $allowance_categories_query = "";
        foreach ($categories as $category) {

            $allowance_categories_query = $allowance_categories_query . "(IF((SELECT SUM(al.amount) FROM temp_allowance_logs al join allowances on allowances.id=al.allowanceID WHERE  al.empID = e.emp_id AND allowances.allowance_category_id=" . $category->id . "  AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM temp_allowance_logs al join allowances on allowances.id=al.allowanceID WHERE al.empID = e.emp_id AND allowances.allowance_category_id=" . $category->id . " AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS category" . $category->id . ",";
        }

        $query = "SELECT
        pl.*,
        e.fname,e.mname,e.lname,
        e.emp_id,e.account_no,e.pf_membership_no,pl.sdl,pl.wcf,e.currency,de.name,e.cost_center as costCenterName,b.name as bank_name,e.branch as branch_code,
        e.emp_id,e.rate,
        'al.description' as allowance_id,
        0 as allowance_amount,
        (IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.description lIKE '%Overtime%' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.description lIKE '%Overtime%' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS overtime,
          " . $allowance_categories_query . "

         (IF((SELECT SUM(al.amount) FROM temp_allowance_logs al join allowances on allowances.id=al.allowanceID WHERE  al.empID = e.emp_id AND allowances.allowance_category_id is null  AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM temp_allowance_logs al join allowances on allowances.id=al.allowanceID WHERE al.empID = e.emp_id AND allowances.allowance_category_id is null AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS other_payments,

        IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,

        (SELECT SUM(ll.paid) FROM temp_loan_logs ll,loan l WHERE ll.loanID = l.id AND e.emp_id = l.empID AND  ll.payment_date = '" . $date . "' GROUP BY ll.loanID) AS loans,

        (SELECT SUM(ll.paid) FROM temp_loan_logs ll,loan l WHERE ll.loanID = l.id AND e.emp_id = l.empID AND  ll.payment_date = '" . $date . "' GROUP BY ll.payment_date) AS total_loans

        from temp_payroll_logs pl,employee e,bank b,department de,cost_center cc where b.id = e.bank and e.department = de.id and de.cost_center_id = cc.id and e.emp_id = pl.empID /* and e.state !=4 */  and pl.payroll_date='" . $date . "' ORDER BY e.emp_id ASC


        ";


        //$query = "SELECT tl.*, e.* from temp_payroll_logs tl,employee e where e.emp_id = tl.empID and tl.payroll_date='".$date."'";

        return DB::select(DB::raw($query));
    }
    function get_payroll_inputs_before_payroll($empID)
    {

        $query = "select e.emp_id,e.fname,e.hire_date,e.cost_center,e.salary,(SELECT concat(el.fname,' ',el.mname,' ',el.lname) from employee el where el.emp_id = e.line_manager) as lime_manager, e.mname, IF(e.state = 1,'Active','InActive') as status, e.lname, e.gender, e.birthdate, e.nationality, e.email,
        d.name as department, p.name as position, b.name as branch, c.name as contract, e.salary,
        pf.name as pension, e.pf_membership_no as pension_number, e.account_no, e.mobile
        from employee e, department d, position p, branch b, employee el, contract c, pension_fund pf where e.department = d.id and e.position = p.id
        and e.branch = b.code  and c.id = e.contract_type and e.pension_fund = pf.id and e.state != 4 and e.emp_id = '" . $empID . "'";

        $row  =  DB::select(DB::raw($query));

        $data['employee']  =  $row[0];


        $query = "SELECT al.name as NAME,al.Isrecursive as nature,al.pensionable,al.taxable,(IF((SELECT tl.amount from temp_allowance_logs tl where tl.description = al.name and tl.empID = '" . $empID . "') > 0,(SELECT tl.amount from temp_allowance_logs tl where tl.description = al.name and tl.empID = '" . $empID . "'),0)) as amount from allowances al";
        $data['allowances']  =  DB::select(DB::raw($query));

        $query = "SELECT d.name as NAME,(IF((SELECT td.paid from temp_deduction_logs td where td.description = d.name and td.empID = '" . $empID . "') > 0,(SELECT td.paid from temp_deduction_logs td where td.description = d.name and td.empID = '" . $empID . "'),0)) as amount from deductions d";
        $data['deductions']  =  DB::select(DB::raw($query));
        // dd($data);
        return $data;
    }

    function get_payroll_inputs_after_payroll($empID)
    {
        $query = "select e.emp_id,e.fname,e.hire_date,e.cost_center,e.salary, e.mname, IF(e.state = 1,'Active','InActive') as status, e.lname, e.gender, e.birthdate, e.nationality, e.email,
        d.name as department, p.name as position, b.name as branch, concat(el.fname,' ',el.mname,' ',el.lname) as line_manager, c.name as contract, e.salary,
        pf.name as pension, e.pf_membership_no as pension_number, e.account_no, e.mobile
        from employee e, department d, position p, branch b, employee el, contract c, pension_fund pf where e.department = d.id and e.position = p.id
        and e.branch = b.code and e.line_manager = el.emp_id and c.id = e.contract_type and e.pension_fund = pf.id and e.state != 4 and e.emp_id = '" . $empID . "'";

        $row  =  DB::select(DB::raw($query));

        $data['employee']  =  $row[0];

        $query = "SELECT al.name as NAME,al.Isrecursive as nature,al.pensionable,al.taxable,(IF((SELECT tl.amount from allowance_logs tl where tl.description = al.name and tl.empID = '" . $empID . "') > 0,(SELECT tl.amount from allowance_logs tl where tl.description = al.name and tl.empID = '" . $empID . "'),0)) as amount from allowances al";
        $data['allowances']  =  DB::select(DB::raw($query));

        $query = "SELECT d.name as NAME,(IF((SELECT td.paid from deduction_logs td where td.description = d.name and td.empID = '" . $empID . "') > 0,(SELECT td.paid from deduction_logs td where td.description = d.name and td.empID = '" . $empID . "'),0)) as amount from deductions d";
        $data['deductions']  =  DB::select(DB::raw($query));
        // dd($data);
        return $data;
    }

    function get_payroll_summary($date)
    {
        $query = "SELECT
        pl.*,
        e.fname,e.mname,e.lname,e.account_no,e.pf_membership_no,pl.sdl,pl.wcf,e.currency,de.name,e.cost_center as costCenterName,b.name as bank_name,e.branch as branch_code,
        e.emp_id,e.rate,
        'al.description' as allowance_id,
        0 as allowance_amount,
        (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description lIKE '%Overtime%' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description lIKE '%Overtime%' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS overtime,
         (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'House Rent' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'House Rent' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS house_rent,
        (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'House Rent' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'House Rent' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS disturbance_allowance,

         (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'Teller Allowance' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'Teller Allowance' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS teller_allowance,
         (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'Arrears' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description = 'Arrears' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS arrears_allowance,

         (IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description != 'House Rent' AND al.description != 'Teller Allowance' AND al.description != 'Arrears' AND al.description NOT lIKE '%Overtime%' AND al.payment_date = '" . $date . "' GROUP BY al.empID >0),(SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.description != 'House Rent' AND  al.description != 'Arrears' AND al.description NOT lIKE '%Overtime%' AND al.description != 'Teller Allowance' AND al.payment_date = '" . $date . "' GROUP BY al.empID),0)) AS other_payments,

        IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '" . $date . "' GROUP BY dl.empID),0) AS deductions,

        (SELECT SUM(ll.paid) FROM loan_logs ll,loan l WHERE ll.loanID = l.id AND e.emp_id = l.empID AND  ll.payment_date = '" . $date . "' GROUP BY ll.loanID) AS loans,

        (SELECT SUM(ll.paid) FROM loan_logs ll,loan l WHERE ll.loanID = l.id AND e.emp_id = l.empID AND  ll.payment_date = '" . $date . "' GROUP BY ll.payment_date) AS total_loans

        from payroll_logs pl,employee e,bank b,department de,cost_center cc where b.id = e.bank and e.department = de.id and de.cost_center_id = cc.id and e.emp_id = pl.empID /* and e.state !=4 */  and pl.payroll_date='" . $date . "' ORDER BY e.emp_id ASC

        ";

        return DB::select(DB::raw($query));
    }
    function get_termination($date)
    {

        $calendar = explode('-', $date);
        $date =  isset($calendar) && is_array($calendar) && count($calendar) >= 2 ? '%' . $calendar[0] . '-' . $calendar[1] . '%' : null;

        $query  = "SELECT t.*,e.pf_membership_no,e.cost_center as costCenterName,e.account_no,de.name,e.emp_id,e.mname,e.fname,e.lname,CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name from terminations t,employee e,department de where e.emp_id = t.employeeID and e.department = de.id and t.terminationDate LIKE '%" . $date . "%' ";
        return (DB::select(DB::raw($query)));
    }

    function get_payroll_temp_summary1($date)
    {
        $query = "SELECT pl.*, e.* from temp_payroll_logs pl,employee e where e.emp_id = pl.empID  and pl.payroll_date='" . $date . "'";

        return DB::select(DB::raw($query));
    }

    function s_heslb($payrolldate)
    {
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE l.empID = e.emp_id and e.contract_type != 2 AND e.state != 4 AND ll.loanID = l.id AND l.type = 3 AND ll.payment_date = '" . $payrolldate . "'";
        //dd(DB::select(DB::raw($query)));
        return DB::select(DB::raw($query));
    }

    function v_heslb($payrolldate, $emp_id)
    {
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE e.emp_id=l.empID AND e.emp_id= '" . $emp_id . "' and e.contract_type != 2 AND ll.loanID = l.id AND l.type = 3 ";
        return DB::select(DB::raw($query));
    }
    function v_totalheslb($payrolldate, $emp_id)
    {
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid,MIN(ll.remained) as total_remained  FROM loan l, loan_logs ll, employee e  WHERE ll.loanID = l.id  AND l.type = 3 AND e.emp_id = l.empID  AND e.emp_id= '" . $emp_id . "' and e.contract_type !=2 ";
        return DB::select(DB::raw($query));
    }



    function totalheslb($payrolldate)
    {
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll  WHERE ll.loanID = l.id AND l.type = 3 AND  ll.payment_date = '" . $payrolldate . "'";
        return DB::select(DB::raw($query));
    }

    function s_totalheslb($payrolldate)
    {
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type != 2 AND  ll.payment_date = '" . $payrolldate . "'";
        return DB::select(DB::raw($query));
    }


    function staffTotalheslb($payrolldate)
    {
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type != 2 AND  ll.payment_date = '" . $payrolldate . "'";
        return DB::select(DB::raw($query));
    }

    function temporaryTotalheslb($payrolldate)
    {
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e  WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type = 2 AND  ll.payment_date = '" . $payrolldate . "'";
        return DB::select(DB::raw($query));
    }

    function pension($date, $pensionFund)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer  FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id AND pl.pension_fund = '" . $pensionFund . "' AND pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }
    //start


    //end

    function s_pension($date, $pensionFund)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no ,e.fname,e.mname,e.lname, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name,e.emp_id, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer
 FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type != 2 AND e.salary != 0.00 AND pl.pension_fund = '" . $pensionFund . "' AND pl.payroll_date LIKE '%" . $date . "%'";


        return DB::select(DB::raw($query));
    }

    function s_pension_termination($date, $pensionFund)
    {
        $raw_date = explode('-', $date);
        $terminationDate = $raw_date[0] . '-' . $raw_date[1];
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no ,e.fname,e.mname,e.lname, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name,e.emp_id, tm.salaryEnrollment as salary,tm.pension_employee,tm.total_gross
        FROM employee e, terminations tm, (SELECT @s:=0) s WHERE tm.employeeID = e.emp_id and e.contract_type != 2 AND e.salary != 0.00  AND tm.terminationDate LIKE '%" . $terminationDate . "%'";


        return DB::select(DB::raw($query));
    }

    function get_pension_years($empID)
    {
        $query = "SELECT DISTINCT years from payroll_logs where empID = '" . $empID . "' ORDER BY years DESC";
        return DB::select(DB::raw($query));
    }

    function employee_pension($empID)
    {

        $query = DB::table('employee as e')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'e.pf_membership_no',
                'e.emp_id',
                'e.fname',
                'e.mname',
                'e.lname',
                'e.hire_date',
                DB::raw("CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as name"),
                'e.emp_id',
                'pl.salary as salary',
                'pl.years',
                'pl.pension_employee',
                'pl.receipt_no',
                'pl.receipt_date',
                'pl.payroll_date as payment_date',
                'pl.pension_employee as pension_employer'
            )
            ->join('payroll_logs as pl', 'pl.empID', '=', 'e.emp_id')
            ->crossJoin(DB::raw('(SELECT 0) as s'))
            ->where('e.contract_type', '<>', 2)
            ->where('e.salary', '<>', 0.00)
            ->where('pl.empID', $empID)
            ->orderBy('pl.payroll_date', 'ASC');

        $unionQuery = DB::table('employee as e')
            ->select(
                DB::raw('ROW_NUMBER() OVER () as SNo'),
                'e.pf_membership_no',
                'e.emp_id',
                'e.fname',
                'e.mname',
                'e.lname',
                'e.hire_date',
                DB::raw("CONCAT(e.fname, ' ', COALESCE(e.mname, ' '), ' ', e.lname) as name"),
                'e.emp_id',
                'tm.salaryEnrollment as salary',
                DB::raw("EXTRACT(YEAR FROM tm.\"terminationDate\") AS years"),
                'tm.pension_employee',
                DB::raw("'-' as receipt_no"),
                DB::raw("'-' as receipt_date"),
                'tm.terminationDate as payment_date',
                'tm.pension_employee as pension_employer'
            )
            ->join('terminations as tm','tm."employeeID"', '=',   'e.emp_id')
            ->crossJoin(DB::raw('(SELECT 0) as s'))
            ->where('e.contract_type', '<>', 2)
            ->where('e.salary', '<>', 0.00)
            ->where('tm."/employeeID/"') ;// Explicitly cast $empID to integer
            // ->orderBy('tm."\terminationDate\"', 'ASC');

        $query->union($unionQuery);

        return $query->get();
    }



    function v_pension($date, $pensionFund)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type = 2 AND pl.pension_fund = '" . $pensionFund . "' AND pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }

    function totalpension($date, $pensionFund)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer  FROM  payroll_logs pl WHERE pl.pension_fund = '" . $pensionFund . "' AND  pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }

    function s_totalpension($date, $pensionFund)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer
FROM  payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.pension_fund = '" . $pensionFund . "' AND  pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }

    function v_totalpension($date, $pensionFund)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer
FROM  payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.pension_fund = '" . $pensionFund . "' AND  pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }


    function employmentCostCheck($date)
    {
        $query = " SELECT id as PayrollLogs FROM payroll_logs WHERE payroll_date like  '%" . $date . "%' ";

        return count(DB::select(DB::raw($query)));
    }

    function employmentCost($date)
    {

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME, pl.*, (pl.last_paid_personal_loan+pl.last_paid_heslb+pl.last_paid_salary_advance+pl.last_paid_other_deductions) as loans
	FROM employee AS e, (SELECT @s:=0) as s, payroll_logs pl WHERE pl.empID = e.emp_id and e.state = 1 and pl.payroll_date like '%" . $date . "%'";

        return DB::select(DB::raw($query));
    }

    function totalEmploymentCost($date)
    {
        $query = "SELECT SUM(ll.basic_salary) as basic_salary_total,
SUM(ll.allowance+ll.other_benefits) as allowance_total,
SUM(ll.basic_salary+ll.allowance+ll.other_benefits) as gross_total,
SUM(ll.other_benefits) as other_benefits_total,
SUM(ll.pension_employee) as pension_employee_total,
SUM(ll.pension_employer) as pension_employer_total,
SUM(ll.sdl) as sdl_total,
SUM(ll.wcf) as wcf_total,
SUM(ll.medical_employee) as medical_employee_total,
SUM(ll.medical_employer) as medical_employer_total,
SUM(ll.taxdue) as taxdue_total,
SUM(ll.last_paid_personal_loan+ll.last_paid_heslb+ll.last_paid_salary_advance+ll.last_paid_other_deductions) as loans_total,
SUM(ll.taxdue) as TAXDUE FROM payroll_logs ll, employee e WHERE e.emp_id = ll.empID AND ll.payroll_date like '%" . $date . "%'  GROUP BY e.state";

        return DB::select(DB::raw($query));
    }



    function wcf($date)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, pl.salary as salary, pl.allowances  FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id AND pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }
    function totalwcf($date)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf  FROM  payroll_logs pl WHERE pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }

    function s_wcf($date)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,pl.wcf as wcf, pl.salary as salary, pl.allowances
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }
    function s_wcf_termination($date)
    {
        $raw_date = explode('-', $date);
        $terminationDate = $raw_date[0] . '-' . $raw_date[1];
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id,tm.wcf as wcf, tm.salaryEnrollment as salary,tm.total_gross as total_gross
FROM employee e, terminations tm, (SELECT @s:=0) s WHERE tm.employeeID = e.emp_id and e.contract_type != 2 AND tm.terminationDate LIKE '%" . $terminationDate . "%'";
        //   dd(DB::select(DB::raw($query)));
        return DB::select(DB::raw($query));
    }

    function s_totalwcf($date)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf
FROM  payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type != 2 and pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }

    function v_wcf($date)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.tin as tin, e.national_id as national_id, pl.salary as salary, pl.allowances
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }
    function v_totalwcf($date)
    {
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf
FROM  payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type = 2 and pl.payroll_date LIKE '%" . $date . "%'";
        return DB::select(DB::raw($query));
    }


    function individual_employment_cost($id)
    {
        $query = "SELECT
	SUM(e.salary+((SELECT rate from allowance WHERE id=1)*e.salary)+epv.amount+((SELECT rate_employer from deduction where id =1 )*(e.salary))+((SELECT rate_employer from deduction where id =4 )*(e.salary))+((SELECT rate_employer from deduction where id =2 )*(e.salary))+((SELECT rate_employer from deduction where id =5 )*(e.salary))) as TOTAL_COST
	FROM employee e, emp_package_view epv  WHERE e.emp_id = epv.empID and e.state=1 and e.emp_id = '" . $id . "'";
        return DB::select(DB::raw($query));
    }



    function payrollcheck($id)
    {
        $query = "SELECT count(empID) as CHECKs FROM payroll_logs WHERE empID = '" . $id . "'";

        return DB::select(DB::raw($query));
    }

    function payrollcheck2($id, $date)
    {
        $query = "SELECT count(empID) as CHECKs FROM payroll_logs WHERE empID = '" . $id . "' AND due_date like '" . $date . "%'";

        return DB::select(DB::raw($query));
    }


    function checkleave($empID)
    {

        $query = "SELECT  empID from leaves where empID='" . $empID . "'";
        return count(DB::select(DB::raw($query)));
    }

    function yeartodate($id)
    {
        $query = "SELECT sum(basic+allowance-pension_employee) as TAXABLE, SUM(paye) as paye,  SUM(allowance+basic) as GROSS,(SELECT due_date from payroll_logs WHERE empID='25500002' ORDER by id desc limit 1) as DUEDATE  FROM (select id, basic, allowance, pension_employee, paye from payroll_logs where empID='" . $id . "' order by id desc limit 12) as SUM, (SELECT due_date from payroll_logs WHERE empID='" . $id . "' ORDER by id desc limit 1) as DATE";
        return DB::select(DB::raw($query));
    }


    function leavedays($id)
    {
        $query = " SELECT DISTINCT empID, IF((( SELECT sum(days)  FROM `leaves` where nature=1 AND e.emp_id=leaves.empID GROUP by nature, empID)>0), (SELECT sum(days)  FROM `leaves` where nature=1 AND e.emp_id=leaves.empID GROUP by nature),0) as LEAVEDAYS,

IF((( SELECT sum(days)  FROM `leaves` where nature=2 AND e.emp_id=leaves.empID GROUP by nature)>0),  (SELECT sum(days)  FROM `leaves` where nature=2 AND e.emp_id=leaves.empID GROUP by nature),0) as EXAM,

IF((( SELECT sum(days)  FROM `leaves` where nature=3 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=3 AND e.emp_id=leaves.empID GROUP by nature),0) as MATERNITY,

IF((( SELECT sum(days)  FROM `leaves` where nature=5 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=5 AND e.emp_id=leaves.empID GROUP by nature),0) as SICK,

IF((( SELECT sum(days)  FROM `leaves` where nature=6 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=6 AND e.emp_id=leaves.empID GROUP by nature),0) as COMPASSIONATE FROM employee e, leaves WHERE e.emp_id=leaves.empID and e.emp_id='" . $id . "' ";

        return DB::select(DB::raw($query));
    }


    function loan()
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  ";

        return DB::select(DB::raw($query));
    }


    function loanreport1($dates, $datee) //ALL
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and  l.last_paid_date BETWEEN '" . $dates . "' AND '" . $datee . "' ";

        return DB::select(DB::raw($query));
    }


    function loanreport3($dates, $datee) //COMPLETED
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id and l.state = 0  and  l.last_paid_date BETWEEN '" . $dates . "' AND '" . $datee . "'  ";

        return DB::select(DB::raw($query));
    }


    function loanreport2($dates, $datee) //ONPROGRESS
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id and l.state = 1  and  l.last_paid_date BETWEEN '" . $dates . "' AND '" . $datee . "' ";

        return DB::select(DB::raw($query));
    }



    function leavereport_line($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and e.line_manager ='" . $id . "' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and e.emp_id ='" . $id . "'";

        return DB::select(DB::raw($query));
    }

    /*	function leavereport1($dates, $datee)
        {
            $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' ";

            return DB::select(DB::raw($query));
        }*/

    function leavereport_all($dates, $datee)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '" . $dates . "' and '" . $datee . "' ";

        return DB::select(DB::raw($query));
    }

    function leavereport_completed($dates, $datee, $today)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end < '" . $today . "' AND ls.start BETWEEN '" . $dates . "' AND '" . $datee . "' ";

        return DB::select(DB::raw($query));
    }

    function leavereport_progress($dates, $datee, $today)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end > '" . $today . "' AND ls.start between '" . $dates . "' and '" . $datee . "' ";

        return DB::select(DB::raw($query));
    }


    function leavereport1_line($dates, $datee, $id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '" . $dates . "' and '" . $datee . "' and e.line_manager = '" . $id . "' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '" . $dates . "' and '" . $datee . "' and e.emp_id = '" . $id . "'";

        return DB::select(DB::raw($query));
    }

    function leavereport2($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.empID = '" . $id . "' ";

        return DB::select(DB::raw($query));
    }


    function customleave($id)
    {
        $query = "SELECT  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as NAME  FROM  employee e WHERE e.emp_id = '" . $id . "'";
        return DB::select(DB::raw($query));
    }


    function payslipcheck($datecheck, $empID)
    {
        $query = " SELECT id  FROM payroll_logs WHERE payroll_date LIKE '%" . $datecheck . "%' AND empID = '" . $empID . "' ";

        return count(DB::select(DB::raw($query)));
    }

    function temp_payslipcheck($datecheck, $empID)
    {
        $query = " SELECT id  FROM temp_payroll_logs WHERE payroll_date LIKE '%" . $datecheck . "%' AND empID = '" . $empID . "' ";

        return count(DB::select(DB::raw($query)));
    }

    function payslipcheckAll($datecheck)
    {
        $query = " SELECT  *  FROM payroll_logs WHERE payroll_date LIKE '%" . $datecheck . "%' ";
        return count(DB::select(DB::raw($query)));
    }

    function s_payrollLogEmpID($datecheck)
    {
        $query = "SELECT empID FROM payroll_logs pl, employee e where e.emp_id = pl.empID
and e.contract_type != 2 and payroll_date LIKE '%" . $datecheck . "%' ";

        return DB::select(DB::raw($query));
    }

    function v_payrollLogEmpID($datecheck)
    {
        $query = "SELECT empID FROM payroll_logs pl, employee e where e.emp_id = pl.empID
and e.contract_type = 2 and payroll_date LIKE '%" . $datecheck . "%' ";
        return DB::select(DB::raw($query));
    }

    function payslip_info_backup($empID, $payroll_month_end, $payroll_month, $year_back)
    {
        $query = "SELECT pl.empID as empID,CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, e.salary as basic_salary,
       p.name as position,d.name as department, e.hire_date,pl.*,

  (SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employee_todate,

 (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employer_todate,

 (SELECT SUM(plg.basic_salary+plg.allowance+plg.other_benefits-plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID  = '" . $empID . "' and plg.payroll_date BETWEEN '" . $year_back . "' and '" . $payroll_month_end . "' ) as year_todate_taxable,

 (SELECT SUM(plg.basic_salary+plg.allowance+plg.other_benefits+plg.medical_employer) FROM  payroll_logs plg WHERE  plg.empID  = '" . $empID . "' and plg.payroll_date BETWEEN '" . $year_back . "' and '" . $payroll_month_end . "' ) as year_todate_earnings,

 (SELECT SUM(plg.taxdue) FROM  payroll_logs plg WHERE plg.empID  =  '" . $empID . "' and plg.payroll_date BETWEEN '" . $year_back . "' and '" . $payroll_month_end . "') as year_todate_taxdue,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 1 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' ),0) as annual_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 2 and pl.empID = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '2018-12-25' )>0,(SELECT lv.days FROM leaves lv   where lv.nature = 2 and e.emp_id= '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' ),0) as exam_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 3 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 3 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' ),0)  as maternity_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 6 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 6 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' ),0) as compassionate_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 5 and e.emp_id = '" . $empID . "' AND lv.start BETWEEN e.hire_date AND '2018-12-30')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 5 AND lv.start BETWEEN e.hire_date and e.emp_id = '" . $empID . "' AND '" . $payroll_month_end . "' ),0) as sick_leave


FROM payroll_logs pl, employee e, department d, position p  WHERE e.emp_id = pl.empID and e.position = p.id and d.id = e.department and pl.payroll_date LIKE '%" . $payroll_month . "%' and pl.empID = '" . $empID . "'";


        return DB::select(DB::raw($query));
    }


    #START PAYSLIP SCANIA PAYROLL

    function payslip_info($empID, $payroll_month_end, $payroll_month)
    {
        $query = "SELECT
    pl.empID as empID,
    e.salary as basic_salary,
    pl.salary as net_basic,
    e.old_emp_id as oldID,
    pl.rate as rate,
    CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name,
    d.name as department_name,
    p.name as position_name,
    br.name as branch_name,
    bn.name as bank_name,
    pf.name as pension_fund_name,
    pf.abbrv as pension_fund_abbrv,
    e.hire_date,
    (SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employee_todate,
    (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employer_todate,
    pl.*
    FROM payroll_logs pl, employee e, department d, position p, bank bn, pension_fund pf, branch br  WHERE e.emp_id = pl.empID AND pl.branch = br.id AND pl.bank = bn.id AND pl.pension_fund = pf.id AND e.position = p.id AND d.id = e.department AND pl.payroll_date LIKE '%" . $payroll_month . "%' and pl.empID = '" . $empID . "'";

        return DB::select(DB::raw($query));
    }

    function temp_payslip_info($empID, $payroll_month_end, $payroll_month)
    {
        $query = "SELECT
    pl.empID as empID,
    e.old_emp_id as oldID,
    CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name,
    d.name as department_name,
    p.name as position_name,
    br.name as branch_name,
    bn.name as bank_name,
    pf.name as pension_fund_name,
    pf.abbrv as pension_fund_abbrv,
    e.hire_date,
    (SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employee_todate,
    (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '" . $empID . "' and plg.payroll_date BETWEEN e.hire_date and '" . $payroll_month_end . "' ) as pension_employer_todate,
    pl.*
    FROM temp_payroll_logs pl, employee e, department d, position p, bank bn, pension_fund pf, branch br  WHERE e.emp_id = pl.empID AND pl.branch = br.id AND pl.bank = bn.id AND pl.pension_fund = pf.id AND e.position = p.id AND d.id = e.department AND pl.payroll_date LIKE '%" . $payroll_month . "%' and pl.empID = '" . $empID . "'";
        return DB::select(DB::raw($query));
    }

    function leaves($empID, $payroll_month_end)
    {
        $query = "SELECT lt.type AS nature, l.nature as type, SUM(l.days) AS days FROM leaves l, employee e, leave_type lt WHERE e.emp_id = l.empID AND lt.id = l.nature AND l.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' AND e.emp_id = '" . $empID . "' GROUP BY l.empID, l.nature";
        return DB::select(DB::raw($query));
    }
    function annualLeaveSpent($empID, $payroll_month_end)
    {
        $query = "SELECT IF( (SELECT SUM(l.days) FROM leaves l WHERE e.emp_id = l.empID AND l.nature = 1 AND l.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' AND e.emp_id = '" . $empID . "'  GROUP BY l.empID, l.nature)>0, (SELECT SUM(l.days) FROM leaves l WHERE e.emp_id = l.empID AND l.nature = 1 AND l.start BETWEEN e.hire_date AND '" . $payroll_month_end . "' AND e.emp_id = '" . $empID . "' GROUP BY l.empID, l.nature), 0 ) AS days FROM employee e";
        $row = DB::select(DB::raw($query));
        return $row[0]->days;
    }

    function allowances($empID, $payroll_month)
    {
        $query = "SELECT description, amount FROM allowance_logs WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    function temp_allowances($empID, $payroll_month)
    {
        $query = "SELECT description, amount FROM temp_allowance_logs WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    function deductions($empID, $payroll_month)
    {
        $query = "SELECT description, paid FROM deduction_logs WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    function temp_deductions($empID, $payroll_month)
    {
        $query = "SELECT description, paid FROM temp_deduction_logs WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    //This function throws Exception on Emails
    /*function total_allowances($empID, $payroll_month){
        $query = "SELECT SUM(amount) as total FROM allowance_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID";
        $row = $query->row();
        return $row->total;

    }*/
    function total_allowances($empID, $payroll_month)
    {
        $query = "SELECT IF( (SELECT SUM(amount)  FROM allowance_logs WHERE empID = '" . $empID . "' and payment_date like '%" . $payroll_month . "%' GROUP BY empID)>0, (SELECT SUM(amount)  FROM allowance_logs WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%' GROUP BY empID), 0) AS total";
        $row = DB::select(DB::raw($query));
        return $row[0]->total;
    }

    function temp_total_allowances($empID, $payroll_month)
    {
        $query = " IF( ( SUM(amount) WHERE empID = '" . $empID . "' and payment_date like '%" . $payroll_month . "%' GROUP BY empID)>0, (SUM(amount)  WHERE empID =  '" . $empID . "' and payment_date like '%" . $payroll_month . "%' GROUP BY empID), 0) AS total";
        $row = DB::table('temp_allowance_logs')
            ->select(DB::raw($query))
            ->first();
        return $row->total;
    }



    function total_pensions($empID, $payroll_date)
    {
        $query = "SELECT SUM(pl.pension_employee) as total_pension_employee, SUM(pl.pension_employer) as total_pension_employer,pl.rate as rate  FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id AND pl.empID =  '" . $empID . "' AND pl.payroll_date <= '" . $payroll_date . "' GROUP BY pl.empID";
        return DB::select(DB::raw($query));
    }

    function temp_total_pensions($empID, $payroll_date)
    {
        $query = "SELECT SUM(pl.pension_employee) as total_pension_employee, SUM(pl.pension_employer) as total_pension_employer  FROM temp_payroll_logs pl, employee e WHERE pl.empID = e.emp_id AND pl.empID =  '" . $empID . "' AND pl.payroll_date <= '" . $payroll_date . "' GROUP BY pl.empID";
        return DB::select(DB::raw($query));
    }

    //This function throws Exception on Emails
    /*function total_deductions($empID, $payroll_month){
        $query = "SELECT SUM(paid) as total FROM deduction_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID";
        $row = $query->row();
        return $row->total;

    }*/
    function total_deductions($empID, $payroll_month)
    {
        $query = "SELECT IF( (SELECT SUM(paid) FROM deduction_logs WHERE  empID = '" . $empID . "' AND payment_date like '%" . $payroll_month . "%' GROUP BY empID)>0, (SELECT SUM(paid) FROM deduction_logs WHERE  empID =  '" . $empID . "' AND payment_date like '%" . $payroll_month . "%' GROUP BY empID), 0) AS total";
        $row = DB::select(DB::raw($query));

        return $row[0]->total;
    }
    function sum_bank_loans($empID, $payroll_date)
    {
        $data = DB::table('bank_loans')->where('employee_id', 1)->where('created_at', 'like', $payroll_date . '%')->sum('amount');
        return $data;
    }

    function bank_loans($empID, $payroll_date)
    {

        $data = DB::table('bank_loans')->where('employee_id', 1)->where('created_at', 'like', $payroll_date . '%')->select('product', 'amount')->get();
        return $data;
    }

    function temp_total_deductions($empID, $payroll_month)
    {
        $query = " IF( (SUM(paid)  WHERE  empID = '" . $empID . "' AND payment_date like '%" . $payroll_month . "%' GROUP BY empID)>0, ( SUM(paid)  WHERE  empID =  '" . $empID . "' AND payment_date like '%" . $payroll_month . "%' GROUP BY empID), 0) AS total";
        $row = DB::table('temp_deduction_logs')
            ->select(DB::raw($query))
            ->first();
        return $row->total;
    }

    function loans($empID, $payroll_month)
    {
        $query = "SELECT l.description, ll.paid, ll.remained, ll.policy FROM loan_logs ll, loan l WHERE ll.loanID = l.id AND l.empID =  '" . $empID . "' AND ll.payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    function temp_loans($empID, $payroll_month)
    {
        $query = "SELECT l.description, ll.paid, ll.remained, ll.policy FROM temp_loan_logs ll, loan l WHERE ll.loanID = l.id AND l.empID =  '" . $empID . "' AND ll.payment_date like '%" . $payroll_month . "%'";
        return DB::select(DB::raw($query));
    }

    function loansPolicyAmount($empID, $payroll_month)
    {
        $query = "SELECT amount FROM loan where empID = '" . $empID . "'";
        $query_prev = "SELECT sum(paid) as prev_paid FROM loan_logs where remained > 0 and payment_date <= '" . $payroll_month . "'";
        return [DB::select(DB::raw($query)), DB::select(DB::raw($query_prev))];
    }

    function temp_loansPolicyAmount($empID, $payroll_month)
    {
        $query = "SELECT amount FROM loan where empID = '" . $empID . "'";
        $query_prev = "SELECT sum(paid) as prev_paid FROM temp_loan_logs where remained > 0 and payment_date <= '" . $payroll_month . "'";
        return [DB::select(DB::raw($query)), DB::select(DB::raw($query_prev))];
    }

    function loansAmountRemained($empID, $payroll_month)
    {
        $query = "SELECT remained
        FROM (
          SELECT remained
          FROM loan_logs ll, loan l where l.id = ll.loanID and l.empID = '" . $empID . "' and last_paid_date = '" . $payroll_month . "'
          ORDER BY remained ASC LIMIT 2
        ) z
        where remained != 0 ORDER BY remained asc LIMIT 1";


        $row = DB::select(DB::raw($query));


        if ($row) {
            return $row[0]->remained;
        } else {
            return null;
        }
    }

    function temp_loansAmountRemained($empID, $payroll_month)
    {

        $query = "SELECT remained
        FROM (
          SELECT remained
          FROM temp_loan_logs ll, loan l where l.id = ll.loanID and l.empID = '" . $empID . "' and last_paid_date = '" . $payroll_month . "'
          ORDER BY remained ASC LIMIT 2
        ) z
        where remained != 0 ORDER BY remained asc LIMIT 1";


        $row = DB::select(DB::raw($query));


        if ($row) {
            return $row[0]->remained;
        } else {
            return null;
        }
    }


    #END PAYSLIP SCANIA PAYROLL


    function total_employment_cost()
    {
        $query = 'SELECT SUM(e.salary+((SELECT rate from allowance WHERE id=1)*e.salary)+epv.amount+((SELECT rate_employer from deduction where id =1 )*(e.salary))+((SELECT rate_employer from deduction where id =4 )*(e.salary))+((SELECT rate_employer from deduction where id =2 )*(e.salary))+((SELECT rate_employer from deduction where id =5 )*(e.salary))) as TOTAL_Employment_Cost

FROM employee e, emp_package_view epv  WHERE e.emp_id = epv.empID and e.state=1';
        return DB::select(DB::raw($query));
    }

    function attendance_list($date)
    {
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id as empID, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) as name, d.name as department, p.name as position, CAST(att.due_in as date) as date_in,   CAST(att.due_in as time) as time_in, IF( CAST(att.due_out as time)= CAST(att.due_in as time), 'NOT SIGNED OUT', CAST(att.due_out as time) ) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '" . $date . "'  ";

        return DB::select(DB::raw($query));
    }

    function strategic_kpi_check($empID)
    {
        $query = "count(st.id) as strategicKPI WHERE st.id IN (SELECT t.strategy_ref FROM task t WHERE NOT t.strategy_ref = 0 AND  t.isAssigned = 1 AND t.assigned_to =  '" . $empID . "' )";
        $row = DB::table('strategy as st')
            ->select(DB::raw($query))
            ->first();
        return $row->strategicKPI;
    }

    function adhoc_kpi_check($empID)
    {
        $query = "COUNT(t.id) as adhocKPI WHERE t.strategy_ref = 0 AND t.output_ref = 0 AND t.isAssigned = 1 AND t.assigned_to =  '" . $empID . "' ";
        $row = DB::table(' task t')
            ->select(DB::raw($query))
            ->first();
        return $row->adhocKPI;
    }
    function allStrategies($empID)
    {
        $query = "SELECT @s:=@s+1 as SNo, str.id ,  str.title as name FROM strategy str, (SELECT @s:=0) as s  WHERE str.id IN (SELECT t.strategy_ref FROM task t WHERE t.isAssigned = 1 AND t.assigned_to = '" . $empID . "')";

        return DB::select(DB::raw($query));
    }
    function strategicTasks($stategyID, $empID)
    {
        $query = "SELECT t.*  FROM task t WHERE t.strategy_ref = " . $stategyID . " AND t.isAssigned = 1 AND t.assigned_to =  '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }
    function adhocTasks($empID)
    {
        $query = "SELECT  @s:=@s+1 as sNo, t.*  FROM task t, (SELECT @s:=0) as s WHERE t.strategy_ref = 0 AND t.isAssigned = 1 AND t.assigned_to =  '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }
    function employeeInfo($empID)
    {
        $query = "SELECT  e.emp_id as empID, CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, d.name as department, p.name as position, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el WHERE el.emp_id = e.line_manager) as leader FROM employee e, department d, position p WHERE e.position = p.id AND e.department = d.id AND e.emp_id = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }
    function taskDuration($empID)
    {
        $query = "SELECT (SELECT t.date_assigned FROM task t WHERE t.assigned_to = '" . $empID . "' AND t.isAssigned = 1 ORDER BY t.date_assigned ASC LIMIT 1) as started, (SELECT t.date_assigned FROM task t WHERE t.assigned_to = '" . $empID . "' AND t.isAssigned = 1 ORDER BY t.date_assigned DESC LIMIT 1) as updated ";

        return DB::select(DB::raw($query));
    }
    function averageTaskPerformance($empID)
    {
        $query = "t.assigned_to, AVG(t.quality+t.quantity) as average WHERE t.status = 2 AND t.assigned_to = '" . $empID . "' ";

        $row = DB::table('task as t')
            ->select(DB::raw($query))
            ->first();
        return $row->average;
    }
    function averageQuantityBehaviour($empID)
    {
        $query = "SELECT t.assigned_to, AVG(t.quality) as average_behaviour, AVG(t.quantity) as average_quantity  FROM task t WHERE t.status = 2 AND t.assigned_to = '" . $empID . "' ";
        return DB::select(DB::raw($query));
    }

    //VSO EXCEL EXPORT
    function payrollInputJournalExport($payroll_date)
    {
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank AND isActive = 1 AND pl.payroll_date = '" . $payroll_date . "' and eav.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    function staffPayrollInputJournalExport($payroll_date)
    {
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
        IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
        pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
        IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
        IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
        b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
        FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND isActive = 1 AND pl.payroll_date = '" . $payroll_date . "' and eav.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    function temporaryPayrollInputJournalExport($payroll_date)
    {
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type = 2 AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch and e.contract_type = 2 AND b.id = e.bank AND isActive = 1 AND pl.payroll_date = '" . $payroll_date . "' and eav.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    public function staffPayrollBankExport($payroll_date)
    {
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND NOT e.contract_type = 2 AND b.id = e.bank AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    public function staffPayrollBankExport_temp($payroll_date)
    {
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND NOT e.contract_type = 2 AND b.id = e.bank AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }



    public function temporaryPayrollBankExport($payroll_date)
    {
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND e.contract_type = 2  AND NOT e.bank = 5 AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    public function temporaryPayrollBankExport_temp($payroll_date)
    {
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND e.contract_type = 2  AND NOT e.bank = 5 AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }



    public function temporaryAllowanceMWPExport($payroll_date)
    {
        $query = "SELECT e.*, pl.*, br.name as branch_name, (SELECT service_name FROM mobile_service_provider WHERE number_prefix =  SUBSTRING(e.mobile, 1, 3)) as service_name, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName,
    IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions
	FROM employee e, payroll_logs pl, bank_branch br WHERE pl.empID = e.emp_id  AND  e.contract_type = 2 AND e.bank = 5 and br.id = e.bank_branch AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    public function temporaryAllowanceMWPExport_temp($payroll_date)
    {
        $query = "SELECT e.*, pl.*, br.name as branch_name, (SELECT service_name FROM mobile_service_provider WHERE number_prefix =  SUBSTRING(e.mobile, 1, 3)) as service_name, e.account_no,  CONCAT(e.fname,' ', IF(e.mname != null,e.mname,' '),' ', e.lname) AS empName,
    IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions
	FROM employee e, temp_payroll_logs pl, bank_branch br WHERE pl.empID = e.emp_id  AND  e.contract_type = 2 AND e.bank = 5 and br.id = e.bank_branch AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }


    public function employeeArrearByMonth($empID, $payroll_month)
    {
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid from arrears_logs, arrears where arrear_id=arrears.id and empID = '" . $empID . "' and arrears_logs.payroll_date = '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearPaidAll($empID, $payroll_month)
    {
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid from arrears_logs, arrears where arrear_id=arrears.id and empID = '" . $empID . "' and arrears_logs.payroll_date <= '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAllPaid($empID, $payroll_month)
    {
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid_all from arrears_logs, arrears where arrear_id=arrears.id and empID = '" . $empID . "' and arrears_logs.payroll_date <= '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAllPaid1($payroll_month)
    {
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid_all from arrears_logs, arrears where arrear_id=arrears.id and arrears_logs.payroll_date <= '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAll($empID, $payroll_month)
    {
        $query = "select sum(arrears.amount) as arrears_all from arrears where empID = '" . $empID . "' and arrears.payroll_date <= '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeePaidWithArrear($empID, $payroll_month)
    {
        $query = "select sum(arrears.amount) as with_arrears from arrears where empID = '" . $empID . "' and arrears.payroll_date = '" . $payroll_month . "'";
        return DB::select(DB::raw($query));
    }

    public function employeeProfile($empID)
    {
        $query = "select e.emp_id,e.fname, e.mname, e.lname, e.gender, e.birthdate, e.nationality, e.email,
d.name as department, p.name as position, b.name as branch, concat(el.fname,' ',el.mname,' ',el.lname) as line_manager, c.name as contract, e.salary,
pf.name as pension, e.pf_membership_no as pension_number, e.account_no, e.mobile
from employee e, department d, position p, branch b, employee el, contract c, pension_fund pf where e.department = d.id and e.position = p.id
and e.branch = b.code and e.line_manager = el.emp_id and c.id = e.contract_type and e.pension_fund = pf.id and e.state != 4 and e.emp_id = '" . $empID . "'";
        return DB::select(DB::raw($query));
    }

    public function paye()
    {
        $query = "select * from paye";
        return DB::select(DB::raw($query));
    }

    public function s_count($date)
    {

        $row = DB::table('payroll_logs')->where('payroll_date', $date)->select('id')->count();

        $calendar = explode('-', $date);
        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }

        $row2 = DB::table('terminations')->where('terminationDate', 'like', $terminationDate)->select('id')->count();


        return $row + $row2;
    }

    public function new_employee($date, $date2)
    {
        // $calendar = explode('-', $date);
        // $date2 = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        $query = "SELECT count(pl.empID) as total from payroll_logs pl where pl.payroll_date = '" . $date . "' and pl.empID NOT IN (SELECT pl2.empID from payroll_logs pl2 where pl2.payroll_date = '" . $date2 . "')";

        $row =  DB::select(DB::raw($query));


        return $row[0]->total;
    }

    public function new_employee1($date, $date2)
    {
        // $calendar = explode('-', $date);
        // $date2 = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        $query = "SELECT count(pl.empID) as total from temp_payroll_logs pl where pl.payroll_date = '" . $date . "' and pl.empID NOT IN (SELECT pl2.empID from payroll_logs pl2 where pl2.payroll_date = '" . $date2 . "')";

        $row =  DB::select(DB::raw($query));


        $data =  $row[0]->total;



        return $data;
    }

    public function new_employee_salary($date, $date2)
    {
        $query = "SELECT SUM(pl.salary) as total from payroll_logs pl where pl.payroll_date = '" . $date . "' and pl.empID NOT IN (SELECT pl2.empID from payroll_logs pl2 where pl2.payroll_date = '" . $date2 . "')";

        $row =  DB::select(DB::raw($query));
        return $row[0]->total;
    }

    public function new_employee_salary1($date, $date2)
    {
        $query = "SELECT SUM(pl.salary) as total from temp_payroll_logs pl where pl.payroll_date = '" . $date . "' and pl.empID NOT IN (SELECT pl2.empID from payroll_logs pl2 where pl2.payroll_date = '" . $date2 . "')";

        $row =  DB::select(DB::raw($query));
        return $row[0]->total;
    }

    public function s_count1($date)
    {

        // $query = "SELECT * from temp_payroll_logs where payroll_date = '".$date."' and empID NOT IN (SELECT empID from payroll_logs where payroll_date = '2023-02-17')";
        //$row = DB::select(DB::raw($query));
        $row = DB::table('temp_payroll_logs')->where('payroll_date', $date)->select('id')->count();

        $calendar = explode('-', $date);
        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }
        $row2 = DB::table('terminations')->where('terminationDate', 'like', $terminationDate)->select('id')->count();


        return $row + $row2;
    }

    function terminated_salary($previous_payroll_month)
    {
        $calendar = explode('-', $previous_payroll_month);
        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }
        $query = "SELECT SUM(salaryEnrollment) as amount from terminations where terminationDate LIKE '" . $terminationDate . "'";
        $row = DB::select(DB::raw($query));

        return $row[0]->amount;
    }

    function terminated_employee($date)
    {
        $calendar = explode('-', $date);
        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }



        $query = "SELECT COUNT(id) as number from terminations where terminationDate LIKE '" . $terminationDate . "'";
        $row = DB::select(DB::raw($query));
        $number = 0;
        if (count($row) > 0) {
            $number = $row[0]->number;
        }


        return $number;
    }



    public function s_overtime($date)
    {

        $row = DB::table('allowance_logs')->where('payment_date', $date)->where('allowanceID', 23)->sum('amount');

        return $row;
    }


    public function s_overtime1($date)
    {

        $row = DB::table('temp_allowance_logs')->where('payment_date', $date)->where('allowanceID', 23)->sum('amount');

        return $row;
    }

    function basic_decrease($previous_payroll_month, $current_payroll_month)
    {


        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate =  isset($calendar1) && is_array($calendar1) && count($calendar1) >= 2 ? '%' . $calendar1[0] . '-' . $calendar1[1] . '%' : null;
        $subquery = "SELECT SUM(tm.actual_salary - tm.salaryEnrollment) as amount from terminations tm where  tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.actual_salary-pl.salary) as amount from payroll_logs pl where pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));
        $data['basic_decrease'] = $row[0]->amount + $row1[0]->amount;


        $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.actual_salary > tm.salaryEnrollment and  tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.actual_salary) as amount from payroll_logs pl where   pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $data['actual_amount'] = $row[0]->amount + $row1[0]->amount;

        return $data;
    }

    function basic_decrease1($previous_payroll_month, $current_payroll_month)
    {





        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);
        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = $calendar1[0] . '-' . $calendar1[1];
        $subquery = "SELECT SUM(tm.actual_salary - tm.salaryEnrollment) as amount from terminations tm where  tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));



        $query = "SELECT SUM(pl.actual_salary-pl.salary) as amount from temp_payroll_logs pl where pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));
        $data['basic_decrease'] = $row[0]->amount + $row1[0]->amount;


        $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.actual_salary > tm.salaryEnrollment and  tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.actual_salary) as amount from temp_payroll_logs pl where   pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $data['actual_amount'] = $row[0]->amount + $row1[0]->amount;

        return $data;
    }



    function basic_increase($previous_payroll_month, $current_payroll_month)
    {

        // if (empty($previous_payroll_month)) {
        //     $data['basic_decrease'] = 0;
        //     $data['actual_amount'] = 0;

        //     return $data;
        // }

        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = isset($calendar1) && is_array($calendar1) && count($calendar1) >= 2 ? '%' . $calendar1[0] . '-' . $calendar1[1] . '%' : null;
        $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));
        //dd($row1);

        $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $query = "SELECT SUM(pl.salary - (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "')) as amount,SUM(pl.actual_salary) as actual_salary from payroll_logs pl where pl.actual_salary = pl.salary and pl.actual_salary > (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row2 = DB::select(DB::raw($query));

        $data['basic_increase'] = $row[0]->amount + $row1[0]->amount + $row2[0]->amount;

        $data['actual_amount'] = $row2[0]->actual_salary;




        // $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.actual_salary < tm.salaryEnrollment and  tm.terminationDate like '%" . $current_terminationDate . "%'";
        // $row1 = DB::select(DB::raw($subquery));

        // $query = "SELECT SUM(pl.actual_salary) as amount from payroll_logs pl where   pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row = DB::select(DB::raw($query));

        //$data['actual_amount'] = $row[0]->amount + $row1[0]->amount;

        // dd($data);
        return $data;
    }

    function basic_increase_temp($previous_payroll_month, $current_payroll_month)
    {

        // if (empty($previous_payroll_month)) {
        //     $data['basic_decrease'] = 0;
        //     $data['actual_amount'] = 0;

        //     return $data;
        // }

        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = $calendar1[0] . '-' . $calendar1[1];
        $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from temp_payroll_logs pl where pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $query = "SELECT SUM(pl.salary - (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "')) as amount,SUM(pl.actual_salary) as actual_salary from temp_payroll_logs pl where pl.actual_salary = pl.salary and pl.actual_salary > (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row2 = DB::select(DB::raw($query));
        $data['basic_increase'] = $row[0]->amount /*+ $row1[0]->amount */ + $row2[0]->amount;

        $data['actual_amount'] = $row2[0]->actual_salary;




        // $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.actual_salary < tm.salaryEnrollment and  tm.terminationDate like '%" . $current_terminationDate . "%'";
        // $row1 = DB::select(DB::raw($subquery));

        // $query = "SELECT SUM(pl.actual_salary) as amount from payroll_logs pl where   pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row = DB::select(DB::raw($query));

        //$data['actual_amount'] = $row[0]->amount + $row1[0]->amount;

        // dd($data);
        return $data;
    }

    function basic_increase1($previous_payroll_month, $current_payroll_month)
    {

        // if (empty($previous_payroll_month)) {
        //     $data['basic_decrease'] = 0;
        //     $data['actual_amount'] = 0;

        //     return $data;
        // }

        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = $calendar1[0] . '-' . $calendar1[1];
        $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $query = "SELECT SUM(pl.salary - (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "')) as amount from temp_payroll_logs pl where pl.actual_salary = pl.salary and pl.actual_salary > (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row2 = DB::select(DB::raw($query));
        $data['basic_increase'] = $row[0]->amount + $row1[0]->amount + $row2[0]->amount;


        $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.actual_salary < tm.salaryEnrollment and  tm.terminationDate like '%" . $current_terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.actual_salary) as amount from temp_payroll_logs pl where   pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'";
        $row = DB::select(DB::raw($query));

        $data['actual_amount'] = $row[0]->amount + $row1[0]->amount;

        return $data;
    }

    function basic_increase_old($date)
    {
        if (empty($date)) {
            $data['basic_increase'] = 0;
            $data['actual_salary'] = 0;
            return $data;
        }
        $calendar = explode('-', $date);
        $terminationDate = $calendar[0] . '-' . $calendar[1];
        $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary < pl.salary and pl.payroll_date = '" . $date . "'";
        $row = DB::select(DB::raw($query));
        $data['basic_increase'] = $row[0]->amount + $row1[0]->amount;

        $subquery = "SELECT SUM(tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $terminationDate . "%'";
        $row1 = DB::select(DB::raw($subquery));

        $query = "SELECT SUM(pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary > pl.salary and pl.payroll_date = '" . $date . "'";
        $row = DB::select(DB::raw($query));
        $data['actual_salary'] = $row[0]->amount + $row1[0]->amount;

        return $data;
    }




    public function total_basic($date)
    {
        $calendar = explode('-', $date);
        $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';

        $query = "SELECT SUM(pl.actual_salary) as total_amount from payroll_logs pl where  pl.payroll_date = '" . $date . "'";

        $row  = DB::select(DB::raw($query));

        $query2 = "SELECT IF(SUM(tm.salaryEnrollment) > 0,SUM(tm.salaryEnrollment),0) as total_amount from terminations tm where  tm.terminationDate like '" . $terminationDate . "'";
        $row2  = DB::select(DB::raw($query2));

        return $row[0]->total_amount + $row2[0]->total_amount;
    }

    public function total_basic1($date)
    {
        $calendar = explode('-', $date);
        $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';

        $query = "SELECT SUM(pl.actual_salary) as total_amount from temp_payroll_logs pl where  pl.payroll_date = '" . $date . "'";

        $row  = DB::select(DB::raw($query));

        $query2 = "SELECT IF(SUM(tm.salaryEnrollment) > 0,SUM(tm.salaryEnrollment),0) as total_amount from terminations tm where  tm.terminationDate like '" . $terminationDate . "'";
        $row2  = DB::select(DB::raw($query2));
        //dd($row2[0]->total_amount);
        return $row[0]->total_amount + $row2[0]->total_amount;
    }
    public function employee_increase1($current_payroll_month, $previous_payroll_month)
    {
        $query = "
        (SELECT  'Add Employee' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,pl.salary,pl.salary as current_amount,0 as previous_amount
        from employee e,temp_payroll_logs pl where e.emp_id = pl.empID and pl.payroll_date = '" . $current_payroll_month . "' and e.emp_id NOT IN (SELECT empID from  payroll_logs where payroll_date = '" . $previous_payroll_month . "') )";
        $row = DB::select(DB::raw($query));

        return $row;
    }
    public function employee_increase($current_payroll_month, $previous_payroll_month)
    {
        $query = "
        (SELECT  'Add Employee' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,pl.salary,pl.salary as current_amount,0 as previous_amount
        from employee e,payroll_logs pl where e.emp_id = pl.empID and pl.payroll_date = '" . $current_payroll_month . "' and e.emp_id NOT IN (SELECT empID from  payroll_logs where payroll_date = '" . $previous_payroll_month . "') )";
        $row = DB::select(DB::raw($query));

        return $row;
    }
    public function employee_basic_increase($current_payroll_month, $previous_payroll_month)
    {

        $query = "SELECT  'Add Increase in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) > (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "')

        ";
        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function employee_basic_increase1($current_payroll_month, $previous_payroll_month)
    {

        $query = "SELECT  'Add Increase in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from temp_payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from temp_payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) > (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT emp_id from temp_payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "')

        ";
        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function employee_basic_decrease($current_payroll_month, $previous_payroll_month)
    {

        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = $calendar1[0] . '-' . $calendar1[1];
        //dd($current_terminationDate);
        // $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'";
        // $row1 = DB::select(DB::raw($subquery));

        // $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row = DB::select(DB::raw($query));

        // $query = "SELECT SUM(pl.salary - (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."')) as amount from payroll_logs pl where pl.actual_salary = pl.salary and pl.actual_salary > (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row2 = DB::select(DB::raw($query));
        // $data['basic_increase'] = $row[0]->amount + $row1[0]->amount + $row2[0]->amount;
        $s = "
        SELECT tm.salaryEnrollment as current_amount,(SELECT salary from payroll_logs where tm.employeeID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') as previous_amount,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname from terminations tm,employee e where tm.employeeID = e.emp_id and tm.salaryEnrollment < tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'
        UNION
        SELECT pl.salary as current_amount,(SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') as previous_amount,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname from payroll_logs pl,employee e where pl.empID = e.emp_id and pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'



        ";
        $row = DB::select(DB::raw($s));

        return $row;


        $calendar = explode('-', $current_payroll_month);
        $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        $query = "SELECT  'Less Decrease in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) < (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "')


         UNION

         SELECT  'Less Decrease in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "' limit 1) < (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT employeeID from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "')



        ";
        // $row = DB::select(DB::raw($query));

        // return $row;
    }


    public function employee_basic_decrease1($current_payroll_month, $previous_payroll_month)
    {

        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);

        // $previous_terminationDate = $calendar2[0] . '-' . $calendar2[1];
        $current_terminationDate = $calendar1[0] . '-' . $calendar1[1];
        //dd($current_terminationDate);
        // $subquery = "SELECT SUM(tm.salaryEnrollment-tm.actual_salary) as amount from terminations tm where tm.salaryEnrollment > tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'";
        // $row1 = DB::select(DB::raw($subquery));

        // $query = "SELECT SUM(pl.salary - pl.actual_salary) as amount from payroll_logs pl where pl.actual_salary < pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row = DB::select(DB::raw($query));

        // $query = "SELECT SUM(pl.salary - (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."')) as amount from payroll_logs pl where pl.actual_salary = pl.salary and pl.actual_salary > (SELECT actual_salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '".$previous_payroll_month."') and pl.payroll_date = '" . $current_payroll_month . "'";
        // $row2 = DB::select(DB::raw($query));
        // $data['basic_increase'] = $row[0]->amount + $row1[0]->amount + $row2[0]->amount;
        $s = "
        SELECT tm.salaryEnrollment as current_amount,(SELECT salary from payroll_logs where tm.employeeID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') as previous_amount,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname from terminations tm,employee e where tm.employeeID = e.emp_id and tm.salaryEnrollment < tm.actual_salary and tm.terminationDate like '%" . $current_terminationDate . "%'
        UNION
        SELECT pl.salary as current_amount,(SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') as previous_amount,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname from temp_payroll_logs pl,employee e where pl.empID = e.emp_id and pl.actual_salary > pl.salary and pl.salary != (SELECT salary from payroll_logs where pl.empID = payroll_logs.empID and payroll_logs.payroll_date = '" . $previous_payroll_month . "') and pl.payroll_date = '" . $current_payroll_month . "'



        ";
        $row = DB::select(DB::raw($s));

        return $row;


        $calendar = explode('-', $current_payroll_month);
        $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        $query = "SELECT  'Less Decrease in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "' limit 1) < (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $current_payroll_month . "')


         UNION

         SELECT  'Less Decrease in Basic Pay incomparison to Last M' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
        (SELECT salary from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "' limit 1) as current_amount,
         (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1) as previous_amount

         from employee e where (SELECT salary from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "' limit 1) < (SELECT salary from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "' limit 1)
         and e.emp_id IN (SELECT emp_id from payroll_logs pl where e.emp_id = pl.empID and payroll_date = '" . $previous_payroll_month . "')
         and e.emp_id IN (SELECT employeeID from terminations tm where e.emp_id = tm.employeeID and tm.terminationDate LIKE '" . $terminationDate . "')



        ";
        // $row = DB::select(DB::raw($query));

        // return $row;
    }

    public function employee_decrease($current_payroll_month, $previous_payroll_month)
    {
        $calendar = explode('-', $previous_payroll_month);

        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }

        $query = "SELECT  'Less Terminated Employee' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,tm.salaryEnrollment as salary,tm.salaryEnrollment as previous_amount,0 as current_amount
        from terminations tm,employee e where  e.emp_id = tm.employeeID and terminationDate LIKE'" . $terminationDate . "'";

        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function employee_decrease1($current_payroll_month, $previous_payroll_month)
    {
        $calendar = explode('-', $previous_payroll_month);

        if (count($calendar) > 2) {
            $terminationDate = '%' . $calendar[0] . '-' . $calendar[1] . '%';
        } else {
            $terminationDate = 'null';
        }

        $query = "SELECT  'Less Terminated Employee' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,tm.salaryEnrollment as salary,tm.net_pay as previous_amount,0 as current_amount
        from terminations tm,employee e where  e.emp_id = tm.employeeID and terminationDate LIKE'" . $terminationDate . "'";

        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function allowance_by_employee($current_payroll_month, $previous_payroll_month)
    {
        $calendar = explode('-', $current_payroll_month);
        $calendar1 = explode('-', $previous_payroll_month);
        if (count($calendar1) > 2) {
            $previous_termination_date = $calendar1[0] . '-' . $calendar1[1];
        } else {
            $previous_termination_date = 'null';
        }


        $current_termination_date = $calendar[0] . '-' . $calendar[1];


        //Cases active employee both months

        //Active employee last month not this month

        //Employee terminated last month

        $query = "



          (SELECT  CONCAT('Add/Less ',al.description) as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
          (IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID  and  allowance_logs.payment_date = '" . $current_payroll_month . "' LIMIT 1 ) > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $current_payroll_month . "'),0)) as current_amount,
         (IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "' LIMIT 1)  > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "'),0)) as previous_amount
           from employee e,allowance_logs al where e.emp_id = al.empID and e.state!=4)

           UNION


            SELECT 'Add/Less N-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(normal_days_overtime_amount > 0,normal_days_overtime_amount,0) as current_amount,
            IF((SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and e.emp_id = allowance_logs.empID and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1) > 0,(SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and allowance_logs.empId = e.emp_id  and  payment_date = '" . $previous_payroll_month . "' limit 1),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION



            SELECT 'Add/Less S-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(public_overtime_amount > 0,public_overtime_amount,0) as current_amount,
            IF((SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and e.emp_id = allowance_logs.empID and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1) > 0,(SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Leave Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leaveAllowance > 0,leaveAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less House Rent' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(houseAllowance > 0,houseAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent'  and e.emp_id = allowance_logs.empID  and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Teller Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(tellerAllowance > 0,tellerAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id) > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and e.emp_id = allowance_logs.empID  and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Arrears' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(arrears > 0,arrears,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id) > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(arrears > 0,arrears,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance'  and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Notice Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Leave Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leavePay != 0,leavePay,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'


            UNION

            SELECT 'Add/Less Night Shift Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(nightshift_allowance != 0,nightshift_allowance,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Transport Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(transport_allowance != 0,transport_allowance,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'



            /* employee terminated last month  */

            UNION

            SELECT 'Add/Less N-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,

            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount,
            IF(tm.normal_days_overtime_amount > 0,tm.normal_days_overtime_amount,0) as previous_amount
            from terminations tm,employee e where e.emp_id = tm.employeeID and tm.terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less S-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(public_overtime_amount > 0,public_overtime_amount,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


            UNION

            SELECT 'Add/Less Leave Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(leaveAllowance > 0,leaveAllowance,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'
            UNION


            SELECT 'Add/Less House Rent' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(houseAllowance > 0,houseAllowance,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


            UNION

            SELECT 'Add/Less Teller Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(tellerAllowance > 0,tellerAllowance,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


            UNION

            SELECT 'Add/Less Arrears' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(arrears > 0,arrears,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(arrears > 0,arrears,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(longServing > 0,longServing,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Notice Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(longServing > 0,longServing,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


            UNION

            SELECT 'Add/Less Leave Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(leavePay > 0,leavePay,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


            UNION

            SELECT 'Add/Less Night Shift Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(nightshift_allowance > 0,nightshift_allowance,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Transport Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            0 as current_amount,IF(transport_allowance > 0,transport_allowance,0) as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'


           ";

        $row = DB::select(DB::raw($query));


        return $row;
        //dd(DB::select(DB::raw($query)));
    }



    public function allowance_by_employee1($current_payroll_month, $previous_payroll_month)
    {
        $calendar = explode('-', $current_payroll_month);
        $calendar1 = explode('-', $previous_payroll_month);
        if (count($calendar1) > 2) {
            $previous_termination_date = $calendar1[0] . '-' . $calendar1[1];
        } else {
            $previous_termination_date = 'null';
        }


        $current_termination_date = $calendar[0] . '-' . $calendar[1];

        $query = "



          (SELECT  CONCAT('Add/Less ',al.description) as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
          (IF((SELECT amount  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and e.emp_id = temp_allowance_logs.empID  and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "' LIMIT 1 ) > 0,(SELECT amount  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and e.emp_id = temp_allowance_logs.empID and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "'),0)) as current_amount,
         (IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "' LIMIT 1)  > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "'),0)) as previous_amount
           from employee e,temp_allowance_logs al where e.emp_id = al.empID and e.state!=4)

           UNION

           (SELECT  CONCAT('Add/Less ',al.description) as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
           0 as current_amount,
          (IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "' LIMIT 1)  > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = al.description and e.emp_id = allowance_logs.empID and  allowance_logs.payment_date = '" . $previous_payroll_month . "'),0)) as previous_amount
            from employee e,allowance_logs al where e.emp_id = al.empID and al.description not in (select description from temp_allowance_logs where  temp_allowance_logs.payment_date = '" . $current_payroll_month . "') and e.state!=4)

           UNION

            SELECT 'Add/Less N-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(normal_days_overtime_amount > 0,normal_days_overtime_amount,0) as current_amount,
            IF((SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and e.emp_id = allowance_logs.empID and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1) > 0,(SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and allowance_logs.empId = e.emp_id  and  payment_date = '" . $previous_payroll_month . "' limit 1),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION



            SELECT 'Add/Less S-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(public_overtime_amount > 0,public_overtime_amount,0) as current_amount,
            IF((SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and e.emp_id = allowance_logs.empID and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1) > 0,(SELECT sum(amount)  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and allowance_logs.empId = e.emp_id and  payment_date = '" . $previous_payroll_month . "' limit 1),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Leave Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leaveAllowance > 0,leaveAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Transport Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(transport_allowance > 0,transport_allowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Transport Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Transport Allowance' and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Night Shift Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(nightshift_allowance > 0,nightshift_allowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Night Shift Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Night Shift Allowance' and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less House Rent' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(houseAllowance > 0,houseAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent' and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Teller Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(tellerAllowance > 0,tellerAllowance,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id) > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Arrears' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(arrears > 0,arrears,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id) > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and  payment_date = '" . $previous_payroll_month . "' group by e.emp_id),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as current_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $previous_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance' and  payment_date = '" . $previous_payroll_month . "'),0) as  previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Notice Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(noticePay > 0,noticePay,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'

            UNION

            SELECT 'Add/Less Leave Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leavePay != 0,leavePay,0) as current_amount, 0 as previous_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $current_termination_date . "%'



            /* employee terminated last month  */

            UNION

            SELECT 'Add/Less N-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,

            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'N-Overtime' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount,
            IF(tm.normal_days_overtime_amount > 0,tm.normal_days_overtime_amount,0) as previous_amount
            from terminations tm,employee e where e.emp_id = tm.employeeID and tm.terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less S-Overtime' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(public_overtime_amount > 0,public_overtime_amount,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'S-Overtime' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION
/*
            SELECT 'Add/Less Leave Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leaveAllowance > 0,leaveAllowance,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Leave Allowance' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION
            */

            SELECT 'Add/Less House Rent' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(houseAllowance > 0,houseAllowance,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'House Rent' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Teller Allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(tellerAllowance > 0,tellerAllowance,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Teller Allowance' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Arrears' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(arrears > 0,arrears,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Arrears' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(arrears > 0,arrears,0) as previous_amount,
            IF((SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance' and e.emp_id = allowance_logs.empID and  payment_date = '" . $current_payroll_month . "') > 0,(SELECT amount  FROM allowance_logs WHERE allowance_logs.description = 'Long Serving allowance' and  payment_date = '" . $current_payroll_month . "'),0) as  current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Long Serving allowance' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as previous_amount, 0 as current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

            UNION

            SELECT 'Add/Less Notice Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(longServing > 0,longServing,0) as previous_amount, 0 as current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

/*
            UNION

            SELECT 'Add/Less Leave Pay' as description,e.emp_id,e.hire_date,e.contract_end,e.fname,e.lname,
            IF(leavePay != 0,leavePay,0) as previous_amount, 0 as current_amount
            from terminations,employee e where e.emp_id = terminations.employeeID and terminationDate like '%" . $previous_termination_date . "%'

*/



           ";

        $row = DB::select(DB::raw($query));


        return $row;
        //dd(DB::select(DB::raw($query)));
    }


    public function total_allowance_og($current_payroll_month, $previous_payroll_month)
    {


        $query = "SELECT  distinct(CONCAT('Add/Less ',al.description)) as description,al.description as allowance,
     (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)) as current_amount,
     (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

     (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

     IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


     ) as difference
      from allowance_logs al  GROUP BY al.description

      ";
        $row = DB::select(DB::raw($query));

        //dd($row);
        return $row;
    }

    public function total_allowance($current_payroll_month, $previous_payroll_month)
    {


        $query = "SELECT  distinct(CONCAT('Add/Less ',al.description)) as description,al.description as allowance,
(IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)) as current_amount,
(IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

(IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


) as difference
 from allowance_logs al  GROUP BY al.description

 ";
        $row = DB::select(DB::raw($query));


        return $row;
    }

    // public function total_s_overtime($current_payroll_month, $previous_payroll_month)
    // {

    //     $query = "SELECT  distinct(CONCAT('Add/Less ',al.description)) as description,al.description as allowance,
    //  (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)) as current_amount,
    //  (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

    //  (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

    //  IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


    //  ) as difference
    //   from allowance_logs al GROUP BY al.description

    //   ";
    //     $row = DB::select(DB::raw($query));


    //     return $row;
    // }



    public function total_allowance1($current_payroll_month, $previous_payroll_month)
    {

        $query = "

        SELECT  distinct(CONCAT('Add/Less ',al.description)) as description,al.description as allowance,
     (IF((SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(temp_allowance_logs.amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "' GROUP BY temp_allowance_logs.description),0)) as current_amount,
     (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

     (IF((SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

     IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


     ) as difference
      from temp_allowance_logs al GROUP BY al.description

     UNION

     SELECT  distinct(CONCAT('Add/Less ',al.description)) as description,al.description as allowance,
     (IF((SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(temp_allowance_logs.amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  temp_allowance_logs.payment_date = '" . $current_payroll_month . "' GROUP BY temp_allowance_logs.description),0)) as current_amount,
     (IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

     (IF((SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM temp_allowance_logs WHERE temp_allowance_logs.description = al.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

     IF((SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(amount)  FROM allowance_logs WHERE allowance_logs.description = al.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


     ) as difference
      from allowance_logs al WHERE al.description NOT IN (SELECT description  FROM temp_allowance_logs WHERE  payment_date = '" . $current_payroll_month . "')  GROUP BY al.description


      ";
        $row = DB::select(DB::raw($query));


        return $row;
    }


    public function total_terminated_allowance($current_payroll_month, $previous_payroll_month, $type)
    {
        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);
        $current_termination = '%' . $calendar1[0] . '-' . $calendar1[1] . '%';
        $previous_termination = !empty($previous_payroll_month) ? '%' . $calendar2[0] . '-' . $calendar2[1] . '%' : null;

        if ($type == "N-Overtime") {
            $query = "SELECT CONCAT('Add/Less N-Overtime') as description,
        (IF((SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE    terminations.terminationDate LIKE '" . $current_termination . "') > 0,(SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
         (IF((SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  terminations.terminationDate LIKE '" . $previous_termination . "') > 0,(SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
         from terminations tm";
        } elseif ($type == "S-Overtime") {

            $query = "SELECT CONCAT('Add/Less S-Overtime') as description,
        (IF((SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
         (IF((SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
         from terminations tm";
        } elseif ($type == "leave_pay") {

            $query = "SELECT CONCAT('Add/Less Leave Pay') as description,
    (IF((SELECT SUM(leavePay)  FROM terminations WHERE   terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(leavePay)  FROM terminations WHERE   terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(leavePay)  FROM terminations WHERE   terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(leavePay)  FROM terminations WHERE   terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount

     from terminations tm";
        } elseif ($type == "notice_pay") {
            $query = "SELECT CONCAT('Add/Less Notice Pay') as description,
    (IF((SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "house_allowance") {
            $query = "SELECT CONCAT('Add/Less House Rent') as description,
    (IF((SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "leave_allowance") {
            $query = "SELECT CONCAT('Add/Less Leave Allowance') as description,
    (IF((SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "teller_allowance") {
            $query = "SELECT CONCAT('Add/Less Teller Allowance') as description,
    (IF((SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "arreas") {
            $query = "SELECT CONCAT('Add/Less Arrears') as description,
    (IF((SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') = null,(SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') = null,(SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "long_serving") {
            $query = "SELECT CONCAT('Add/Less Long Serving allowance') as description,
    (IF((SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "transport_allowance") {
            $query = "SELECT CONCAT('Add/Less Transport allowance') as description,
    (IF((SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "nightshift_allowance") {
            $query = "SELECT CONCAT('Add/Less Nightshift allowance') as description,
    (IF((SELECT SUM(nightshift_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(nightshift_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(nightshift_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        } elseif ($type == "other_payments") {
            $query = "SELECT CONCAT('Add/Less Other Payments') as description,
    (IF((SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0)) as current_amount,
     (IF((SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0)) as previous_amount
     from terminations tm";
        }
        $row = DB::select(DB::raw($query));


        return $row;
    }

    public function all_terminated_allowance($current_payroll_month, $previous_payroll_month)
    {
        $calendar1 = explode('-', $current_payroll_month);
        $calendar2 = explode('-', $previous_payroll_month);
        $current_termination = isset($calendar1) && is_array($calendar1) && count($calendar1) >= 2 ? '%' . $calendar1[0] . '-' . $calendar1[1] . '%' : null;
        $previous_termination = !empty($previous_payroll_month) ? '%' . $calendar2[0] . '-' . $calendar2[1] . '%' : null;
        $data = [];


        $query = "SELECT CONCAT('Add/Less N-Overtime') as description,
        SUM((IF((SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE    terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
         SUM((IF((SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(normal_days_overtime_amount)  FROM terminations WHERE  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
         from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);


        $query = "SELECT CONCAT('Add/Less S-Overtime') as description,
        SUM((IF((SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
         SUM((IF((SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(public_overtime_amount)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
         from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Leave Pay') as description,
    SUM((IF((SELECT SUM(leavePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(leavePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(leavePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(leavePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));

        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Notice Pay') as description,
    SUM((IF((SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(noticePay)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less House Rent') as description,
    SUM((IF((SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(houseAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Leave Allowance') as description,
    SUM((IF((SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(leaveAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));

        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Teller Allowance') as description,
    SUM((IF((SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(tellerAllowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Arrears') as description,
    SUM((IF((SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(arrears)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));

        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Long Serving allowance') as description,
    SUM((IF((SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(longServing)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);
        /*
    $query = "SELECT CONCAT('Add/Less Transport Allowance') as description,
         SUM((IF((SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(transport_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
          SUM((IF((SELECT SUM(al.amount)  FROM allowance_logs al WHERE al.description = 'Transport Allowance' and  al.payment_date = '" . $previous_payroll_month . "' GROUP BY al.description) > 0,(SELECT SUM(al.amount)  FROM allowance_logs al WHERE al.description = 'Transport Allowance' and  al.payment_date = '" . $previous_payroll_month . "' GROUP BY al.description),0))) as previous_amount
          from terminations tm";
        $row = DB::select(DB::raw($query));

        array_push($data,['description'=>$row[0]->description,'current_amount'=>$row[0]->current_amount,'previous_amount'=>$row[0]->previous_amount]);

        $query = "SELECT CONCAT('Add/Less Night Shift Allowance') as description,
        SUM((IF((SELECT SUM(nightshift_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(nightshift_allowance)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
 SUM((IF((SELECT SUM(al.amount)  FROM allowance_logs al WHERE al.description = 'Night Shift Allowance' and  al.payment_date = '" . $previous_payroll_month . "' GROUP BY al.description) > 0,(SELECT SUM(al.amount)  FROM allowance_logs al WHERE al.description = 'Night Shift Allowance' and  al.payment_date = '" . $previous_payroll_month . "' GROUP BY al.description),0))) as previous_amount
 from terminations tm";
       $row = DB::select(DB::raw($query));
       array_push($data,['description'=>$row[0]->description,'current_amount'=>$row[0]->current_amount,'previous_amount'=>$row[0]->previous_amount]);
 */

        $query = "SELECT CONCAT('Add/Less Other Payments') as description,
    SUM((IF((SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "') != 0,(SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $current_termination . "'),0))) as current_amount,
     SUM((IF((SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "') != 0,(SELECT SUM(otherPayments)  FROM terminations WHERE tm.id = terminations.id and  terminations.terminationDate LIKE '" . $previous_termination . "'),0))) as previous_amount
     from terminations tm";
        $row = DB::select(DB::raw($query));
        array_push($data, ['description' => $row[0]->description, 'current_amount' => $row[0]->current_amount, 'previous_amount' => $row[0]->previous_amount]);



        return $data;
    }





    public function total_deduction($current_payroll_month, $previous_payroll_month)
    {

        $query = "SELECT  distinct(CONCAT('Add/Less ',dl.description)) as description,
         (IF((SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)) as current_amount,
         (IF((SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)) as previous_amount,

         (IF((SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $current_payroll_month . "' GROUP BY description),0)-

         IF((SELECT SUM(paid)  FROM deduction_logs WHERE deduction_logs.description = dl.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description) > 0,(SELECT SUM(paid)  FROM deduction_logs WHERE dl.description = dl.description and  payment_date = '" . $previous_payroll_month . "' GROUP BY description),0)


         ) as difference
          from deduction_logs dl GROUP BY dl.description ";
        $row = DB::select(DB::raw($query));


        return $row;
    }

    public function prevPayrollMonth($date)
    {
        $query = "payroll_date";
        $condition = "%" . $date . "%";
        $row = DB::table('payroll_months')
            ->where('payroll_date', 'like', $condition)
            ->select(DB::raw($query))
            ->first();
        if ($row) {

            return $row->payroll_date;
        } else {
            return null;
        }
    }

    public function employeeGross_temp($payroll_date, $empID)
    {
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM temp_payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '" . $payroll_date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function employeeGross_temp1($payroll_date, $empID)
    {
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '" . $payroll_date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function s_employeeGross($payroll_date, $empID)
    {
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.payroll_date = '" . $payroll_date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function v_employeeGross($payroll_date, $empID)
    {
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.payroll_date = '" . $payroll_date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    public function s_payrollEmployee($current, $previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type != 2 and (pl.payroll_date = '" . $current . "' or pl.payroll_date = '" . $previous . "')";
        return DB::select(DB::raw($query));
    }

    public function payrollEmployee_temp($current, $previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from temp_payroll_logs pl, employee e where e.emp_id = pl.empID and (pl.payroll_date = '" . $current . "')";
        return DB::select(DB::raw($query));
    }

    public function payrollEmployee_temp1($current, $previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and (pl.payroll_date = '" . $previous . "')";
        return DB::select(DB::raw($query));
    }

    // public function v_payrollEmployee($current, $previous)
    // {
    //     $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and (pl.payroll_date = '" . $current . "' or pl.payroll_date = '" . $previous . "')";
    //     return DB::select(DB::raw($query));
    // }

    public function v_payrollEmployee($current, $previous)
    {
        $query = "SELECT DISTINCT pl.\"empID\", CONCAT(TRIM(e.fname), ' ', TRIM(e.mname), ' ', TRIM(e.lname)) AS name
                  FROM payroll_logs pl
                  JOIN employee e ON e.emp_id = pl.\"empID\"
                  WHERE e.contract_type::integer = 2 AND (pl.payroll_date = :current OR pl.payroll_date = :previous)";

        return DB::select(DB::raw($query));
    }




    public function v_payrollEmployee_temp($current, $previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from temp_payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and (pl.payroll_date = '" . $current . "' or pl.payroll_date = '" . $previous . "')";
        return DB::select(DB::raw($query));
    }

    public function s_grossMonthly($payroll_date)
    {
        // $query =  "DELETE FROM financial_logs where Date(created_at) Like '2023-02-19%'";
        // DB::insert(DB::raw($query));
        if ($payroll_date === null) {
            return 0;
        }
        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;

        $query = "SELECT SUM(pl.salary+pl.allowances)+(IF((SELECT SUM(tm.total_gross) from terminations tm where terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.total_gross) from terminations tm where terminationDate like '%" . $date . "%'),0)) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.payroll_date = '" . $payroll_date . "'";

        $row = DB::select(DB::raw($query));


        if ($row) {
            return $row[0]->total_gross;
        } else {
            return null;
        }
    }

    public function gross_management($payroll_date)
    {

        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;

        $query = "SELECT SUM(pl.salary)+(IF((SELECT SUM(tm.total_gross) from terminations tm,employee e2 where e2.emp_id = tm.employeeID and e2.cost_center = 'Management' and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.total_gross) from terminations tm,employee e2 where tm.employeeID = e2.emp_id and e.cost_center = 'Management' and terminationDate like '%" . $date . "%'),0)) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID  and e.cost_center = 'Management'  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";

        $query2 = "SELECT SUM(al.amount) as total_gross FROM allowance_logs al,employee e
        WHERE  al.empID = e.emp_id and al.benefit_in_kind = 'NO'   and e.cost_center = 'Management'  and  al.payment_date = '" . $payroll_date . "'";

        $query3 = "SELECT SUM(al.amount) as total_gross FROM allowance_logs al,employee e
        WHERE   al.empID = e.emp_id and al.benefit_in_kind = 'NO'   and e.cost_center = 'Management'  and  al.payment_date = '" . $payroll_date . "'";

        $row = DB::select(DB::raw($query));

        $row2 = DB::select(DB::raw($query2));

        $data = 0;

        if ($row) $data = $row[0]->total_gross;
        if ($row2) $data = $data + $row2[0]->total_gross;


        return $data;
    }
    public function gross($payroll_date)
    {

        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;

        $query = "SELECT SUM(pl.salary)+(IF((SELECT SUM(tm.total_gross) from terminations tm  where tm.terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.total_gross) from terminations tm where  tm.terminationDate like '%" . $date . "%'),0)) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID   and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";

        $query2 = "SELECT SUM(al.amount) as total_gross FROM allowance_logs al,employee e
        WHERE  al.empID = e.emp_id and al.benefit_in_kind = 'NO'  and  al.payment_date = '" . $payroll_date . "'";


        $row = DB::select(DB::raw($query));

        $row2 = DB::select(DB::raw($query2));

        $data = 0;

        if ($row) $data = $row[0]->total_gross;
        if ($row2) $data = $data + $row2[0]->total_gross;


        return $data;
    }

    public function benefit_allowance($payroll_date)
    {

        $query = "SELECT SUM(al.amount) as amount,al.description as description,e.cost_center as account_name FROM allowance_logs al,employee e
        WHERE   al.empID = e.emp_id and al.benefit_in_kind = 'YES'  and  al.payment_date = '" . $payroll_date . "' group by al.description";

        $row = DB::select(DB::raw($query));


        return $row;
    }

    public function contributions($payroll_date)
    {
        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;
        //paye
        $query = "SELECT SUM(pl.taxdue)+(IF((SELECT SUM(tm.paye) from terminations tm,employee e2 where e2.emp_id = tm.employeeID  and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.paye) from terminations tm,employee e2 where tm.employeeID = e2.emp_id  and terminationDate like '%" . $date . "%'),0)) as paye FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";
        $paye = DB::select(DB::raw($query));

        //sdl
        $query = "SELECT SUM(pl.sdl)+(IF((SELECT SUM(tm.sdl) from terminations tm,employee e2 where e2.emp_id = tm.employeeID  and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.sdl) from terminations tm,employee e2 where tm.employeeID = e2.emp_id  and terminationDate like '%" . $date . "%'),0)) as sdl FROM payroll_logs pl, employee e
         WHERE e.emp_id = pl.empID  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";
        $sdl = DB::select(DB::raw($query));

        //wcf
        $query = "SELECT SUM(pl.wcf)+(IF((SELECT SUM(tm.wcf) from terminations tm,employee e2 where e2.emp_id = tm.employeeID  and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.wcf) from terminations tm,employee e2 where tm.employeeID = e2.emp_id  and terminationDate like '%" . $date . "%'),0)) as wcf FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";
        $wcf = DB::select(DB::raw($query));



        //nssf
        $query = "SELECT SUM(pl.pension_employee)+(IF((SELECT SUM(tm.pension_employee) from terminations tm,employee e2 where e2.emp_id = tm.employeeID  and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.pension_employee) from terminations tm,employee e2 where tm.employeeID = e2.emp_id  and terminationDate like '%" . $date . "%'),0)) as pension_employee FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";
        $nssf = DB::select(DB::raw($query));
        $data['paye'] = ' ';
        $data['wcf'] = ' ';
        $data['wcf'] = ' ';
        $data['wcf'] = ' ';

        if ($paye) $data['paye'] = $paye[0]->paye;
        if ($wcf) $data['wcf'] = $wcf[0]->wcf;
        if ($sdl) $data['sdl'] = $sdl[0]->sdl;
        if ($nssf) $data['nssf'] = $nssf[0]->pension_employee;


        return $data;
    }

    public function net_terminal_benefit($payroll_date)
    {
        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;
        $query = "SELECT tm.take_home as amount,'Terminal Benefit' as Description,e.fname as name from terminations tm,employee e where e.emp_id = tm.employeeID and tm.terminationDate like '%" . $date . "%'";

        $row = DB::select(DB::raw($query));

        return $row;
    }

    public function net_pay($payroll_date)
    {
        $data = $this->get_payroll_summary($payroll_date);
        $net_salary = 0;
        foreach ($data as $row) {

            $net_salary += $row->salary + $row->allowances - $row->pension_employer - $row->loans - $row->deductions - $row->meals - $row->taxdue;
        }

        //dd($net_salary);

        return $net_salary;
    }

    public function journal_heslb($payroll_date)
    {
        $query = "SELECT SUM(paid) as amount from loan_logs where payment_date = '" . $payroll_date . "' limit 1";

        $row = DB::select(DB::raw($query));




        $amount = 0;
        if ($row)
            $amount = $row[0]->amount;

        return $amount;
    }

    public function journal_deductions($payroll_date)
    {
        $query = "SELECT SUM(dl.paid) as amount,dl.description as description,CONCAT(dl.description,'-',e.fname,' ',e.lname) as naration FROM deduction_logs dl,employee e
        WHERE   dl.empID = e.emp_id   and  dl.payment_date = '" . $payroll_date . "' group by dl.description";

        $row = DB::select(DB::raw($query));


        return $row;
    }

    public function gross_non_management($payroll_date)
    {

        $calendar = explode('-', $payroll_date);
        $date = !empty($payroll_date) ? $calendar[0] . '-' . $calendar[1] : null;

        $query = "SELECT SUM(pl.salary)+(IF((SELECT SUM(tm.total_gross) from terminations tm,employee e2 where e2.emp_id = tm.employeeID and e2.cost_center = 'Non Management' and terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.total_gross) from terminations tm,employee e2 where tm.employeeID = e2.emp_id and e.cost_center = 'Non Management' and terminationDate like '%" . $date . "%'),0)) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID  and e.cost_center = 'Non Management'  and e.contract_type != 2  and pl.payroll_date = '" . $payroll_date . "'";

        $query2 = "SELECT SUM(al.amount) as total_gross FROM allowance_logs al,employee e
        WHERE  al.empID = e.emp_id and al.benefit_in_kind = 'NO'   and e.cost_center = 'Non Management'  and  al.payment_date = '" . $payroll_date . "'";



        $row = DB::select(DB::raw($query));

        $row2 = DB::select(DB::raw($query2));

        $data = 0;

        if ($row) $data = $row[0]->total_gross;
        if ($row2) $data = $data + $row2[0]->total_gross;


        return $data;
    }

    public function s_grossMonthly1($payroll_date)
    {
        $calendar = explode('-', $payroll_date);
        $date = $calendar[0] . '-' . $calendar[1];
        $query = "SELECT SUM(pl.salary+pl.allowances)+(IF((SELECT SUM(tm.total_gross) from terminations tm where terminationDate like '%" . $date . "%') > 0,(SELECT SUM(tm.total_gross) from terminations tm where terminationDate like '%" . $date . "%'),0)) as total_gross FROM temp_payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.payroll_date = '" . $payroll_date . "' group by pl.payroll_date";

        $row = DB::select(DB::raw($query));

        if ($row) {
            return $row[0]->total_gross;
        } else {
            return null;
        }
    }

    public function grossMonthly_temp($payroll_date)
    {
        $query = "SELECT SUM(pl.salary+pl.allowances) as total_gross FROM temp_payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '" . $payroll_date . "' group by pl.payroll_date";

        $data = DB::select(DB::raw($query));


        if ($data) {
            return $data[0]->total_gross;
        } else {
            return null;
        }
    }

    public function grossMonthly_temp1($payroll_date)
    {
        $query = "SUM(pl.salary+pl.allowances) as total_gross";


        $row = DB::table('payroll_logs as pl')
            ->join('employee as e', 'e.emp_id', '=', 'pl.empID')
            ->where('pl.payroll_date', $payroll_date)
            ->select(DB::raw($query))
            //->groupBy('pl.payroll_date')
            ->first();

        if ($row) {
            return $row->total_gross;
        } else {
            return null;
        }
    }

    public function v_grossMonthly($payroll_date)
    {
        $totalGross = DB::table('payroll_logs as pl')
            ->join('employee as e', 'e.emp_id', '=', 'pl.empID')
            ->where('e.contract_type', 2)
            ->where('pl.payroll_date', $payroll_date)
            ->groupBy('pl.payroll_date')
            ->selectRaw('SUM(pl.salary + pl.allowances) as total_gross')
            ->first();

        return $totalGross ? $totalGross->total_gross : null;
    }


    public function v_grossMonthly_temp($payroll_date)
    {
        $query = "SUM(pl.salary+pl.allowances) as total_gross
            WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.payroll_date = '" . $payroll_date . "' group by pl.payroll_date";
        $row = DB::table('payroll_logs pl, employee e')
            ->select(DB::raw($query))
            ->first();
        if ($row) {
            return $row->total_gross;
        } else {
            return null;
        }
    }

    function employeeNetTemp($date, $empID)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
        IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
     IF((SELECT COUNT(al.id) FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
        IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
        pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
        IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
        IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
     pl.account_no
        FROM employee e, temp_payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '" . $date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    function employeeNetTemp1($date, $empID)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '" . $date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    function s_employeeNet($date, $empID)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date = '" . $date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    function v_employeeNet($date, $empID)
    {

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date = '" . $date . "' and pl.empID = '" . $empID . "' ";

        return DB::select(DB::raw($query));
    }

    function nonPensionableEmployee($emp_id)
    {
        $query = "select * from employee where pension_fund = '3' and emp_id = '" . $emp_id . "' ";
        return DB::select(DB::raw($query));
    }

    function s_loanReport($payroll_date)
    {
        $query = "select ll.id as log_id,e.emp_id, concat(e.fname,' ',e.mname,' ',e.lname) as name, l.description, l.amount,
(select sum(paid) from loan_logs ill where ill.loanID = l.id and ill.payment_date <= '" . $payroll_date . "' group by ill.loanID) as paid, l.amount_last_paid ,
l.amount_last_paid,ll.payment_date,pl.payroll_date
from loan_logs ll, loan l, employee e, payroll_logs pl
where ll.loanID = l.id and l.empID = pl.empID and e.contract_type != 2 and e.emp_id = pl.empID
and pl.payroll_date = '" . $payroll_date . "' and ll.payment_date = '" . $payroll_date . "' ";
        return DB::select(DB::raw($query));
    }

    function v_loanReport($payroll_date)
    {
        $query = "select ll.id as log_id,e.emp_id, concat(e.fname,' ',e.mname,' ',e.lname) as name, l.description, l.amount,
(select sum(paid) from loan_logs ill where ill.loanID = l.id and ill.payment_date <= '" . $payroll_date . "' group by ill.loanID) as paid, l.amount_last_paid ,
l.amount_last_paid,ll.payment_date,pl.payroll_date
from loan_logs ll, loan l, employee e, payroll_logs pl
where ll.loanID = l.id and l.empID = pl.empID and e.contract_type = 2 and e.emp_id = pl.empID
and pl.payroll_date = '" . $payroll_date . "' and ll.payment_date = '" . $payroll_date . "' ";
        return DB::select(DB::raw($query));
    }


    function staffPayrollInputJournalExportTime($payroll_date)
    {
        $query = "SELECT pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    function temporaryPayrollInputJournalExportTime($payroll_date)
    {
        $query = "SELECT pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type = 2 AND pl.payroll_date = '" . $payroll_date . "'";
        return DB::select(DB::raw($query));
    }

    function employeeProjectActivity($payrolldate, $empID)
    {
        $query = "select atl.emp_id, project, activity from assignment_task_logs atl, assignment a where a.id = atl.assignment_employee_id and atl.emp_id = '" . $empID . "' and atl.payroll_date = '" . $payrolldate . "' group by atl.emp_id, project,activity";
        return DB::select(DB::raw($query));
    }

    function employeeProjectActivityTime($payrolldate, $empID, $project, $activity)
    {
        $query = "select atl.*, a.project, a.activity from assignment_task_logs atl, assignment a
where a.id = atl.assignment_employee_id and atl.emp_id = '" . $empID . "' and a.project = '" . $project . "' and a.activity = '" . $activity . "' and atl.payroll_date = '" . $payrolldate . "' ";
        return DB::select(DB::raw($query));
    }

    function projectTime($code, $from, $to)
    {
        $query = "select concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, e.emp_id, a.activity, ast.task_name, ast.start_date,ast.end_date
from assignment a, assignment_employee ae, assignment_task ast, employee e where a.id = ae.assignment_id
and ast.assignment_employee_id = ae.id and e.emp_id = ae.emp_id and a.project = '" . $code . "' and (date(ast.start_date) between '" . $from . "' and '" . $to . "') ";
        return DB::select(DB::raw($query));
    }

    function projectCost($code, $from, $to)
    {
        $query = "select concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, ac.*
from assignment a, activity_cost ac, employee e where a.id = ac.assignment
and e.emp_id = ac.emp_id and a.project = '" . $code . "' and (date(ac.created_at) between '" . $from . "' and '" . $to . "') ";
        return DB::select(DB::raw($query));
    }

    function funderFunds($from, $to)
    {
        $query = "select gl.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, f.name as funder
from grant_logs gl, employee e, funder f where gl.created_by = e.emp_id and f.id = gl.funder and (date(gl.created_at) between '" . $from . "' and '" . $to . "') and mode = 'IN' ";
        return DB::select(DB::raw($query));
    }
}
