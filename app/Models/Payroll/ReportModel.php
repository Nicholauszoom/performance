<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
//NEW EMPLOYMENT COST


    function new_employment_cost_employee_list($date){

        $query = "SELECT pl.empID, dpt.name, dpt.code, CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function s_new_employment_cost_employee_list1($date){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function a_new_employment_cost_employee_list1_temp($date){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, temp_payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id  AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function v_new_employment_cost_employee_list1($date){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.medical_employer, pl.pension_employer, pl.pension_employee AS pension, pl.taxdue, pl.sdl, pl.wcf,
IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type = 3 GROUP BY l.empID),0) AS heslb_loans,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date and l.type != 3 GROUP BY l.empID),0) AS loans,	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

//END EMPLOYMENT COST

//EMPLOYEE BIO DATA
    function s_employee_bio_data_active($date){

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type != 2 and e.state != 4 ";

        return DB::select(DB::raw($query));
    }

    function s_employee_bio_data_inactive($date){

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type != 2 and e.state = 4 ";

        return DB::select(DB::raw($query));
    }

    function v_employee_bio_data_active($date){

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type = 2 and e.state != 4 ";

        return DB::select(DB::raw($query));
    }

    function v_employee_bio_data_inactive($date){

        $query = "SELECT e.emp_id as empID, dpt.name as department, p.name as position,dpt.code, e.birthdate, e.fname, e.mname, e.lname,e.hire_date as hire_date, e.gender, e.contract_end, br.name as branch, ct.name as contract, pn.name as pension, e.pf_membership_no, b.name as bank, e.account_no, e.mobile, e.salary
FROM employee e, department dpt, position p, branch br, contract ct, pension_fund pn, bank b WHERE e.bank = b.id and pn.id = e.pension_fund and e.contract_type = ct.id and e.branch = br.code and e.position = p.id and dpt.id = e.department and e.contract_type = 2 and e.state = 4 ";

        return DB::select(DB::raw($query));
    }

    //END EMPLOYEE BIO DATA



    function payCheklistStatus($payroll_date){
        $query = "COUNT(id) as counts  WHERE payroll_date = '".$payroll_date."' AND pay_checklist = 1";
        $row = DB::table('payroll_months')
        ->select(DB::raw($query))
        ->first();
        $status = $row->counts;
        if($status>0){
            return true;
        } else return false;
    }


    function pay_checklist($date){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }



    function temp_pay_checklist($date){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function staff_pay_checklist($date){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function volunteer_pay_checklist($date){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.branch_code as swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type = 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function payrollAuthorization($payrollMonth){
        $query = "SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname) AS initName, CONCAT(er.fname,' ', er.mname,' ', er.lname) AS recomName, CONCAT(ea.fname,' ', ea.mname,' ', ea.lname) AS confName, pm.appr_date, pm.init_date, pm.recom_date FROM employee e, employee ea, employee er, payroll_months pm WHERE pm.init_author = e.emp_id AND pm.appr_author = ea.emp_id AND pm.recom_author = er.emp_id and pm.payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }

    function sum_take_home($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function temp_sum_take_home($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
        IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
        pl.less_takehome,
        pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
        IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
    
        IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
        b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
        FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."') as parent_query";
            return DB::select(DB::raw($query));
    }

    function temp_sum_take_home1($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function staff_sum_take_home($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type != 2 AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function staff_sum_take_home_temp($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type != 2 AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function volunteer_sum_take_home($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type = 2 AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id and e.contract_type = 2 AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function volunteer_sum_take_home_temp($date){

        $query = "SELECT SUM(salary + allowances-pension-loans-deductions-meals-taxdue) as takehome, SUM(less_takehome) as takehome_less FROM (SELECT  pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS name,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances,
	pl.less_takehome,
	pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type = 2 AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,

	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b  WHERE pl.empID = e.emp_id and e.contract_type = 2 AND bb.id= e.bank_branch AND b.id = e.bank AND pl.payroll_date = '".$date."') as parent_query";
        return DB::select(DB::raw($query));
    }

    function p9($date){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
	FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function s_p9($date){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
    FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type != 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function v_p9($date){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.postal_address as postal_address, e.tin as tin, e.national_id as national_id, e.postal_city as postal_city, pl.*
    FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type = 2 AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    function p91($period_start, $period_end){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and pl.payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";

        return DB::select(DB::raw($query));
    }
    function s_p91($period_start, $period_end){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type != 2 and pl.payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";

        return DB::select(DB::raw($query));
    }

    function v_p91($period_start, $period_end){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, e.postal_address as postal_address, e.postal_city as postal_city, pl.*
FROM employee AS e, (SELECT @s:=0) AS s, payroll_logs pl WHERE pl.empID = e.emp_id AND e.state = 1 and e.contract_type = 2 and pl.payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";

        return DB::select(DB::raw($query));
    }

    function totalp9($date){
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID AND pl.payroll_date = '".$date."'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function s_totalp9($date){
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 AND pl.payroll_date = '".$date."'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function v_totalp9($date){
        $query = "SELECT SUM(pl.salary) as sum_salary,
SUM(pl.salary+pl.allowances) as sum_gross,
SUM(pl.pension_employee) as sum_deductions,
SUM(pl.salary+pl.allowances-pl.pension_employee) as sum_taxable,
SUM(pl.taxdue) as sum_taxdue FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 AND pl.payroll_date = '".$date."'  GROUP BY pl.payroll_date";

        return DB::select(DB::raw($query));
    }

    function company_info(){
        $query = 'SELECT * FROM company_info';
        return DB::select(DB::raw($query));
    }



    function p10check($period_start, $period_end){
        $query = " SELECT id  FROM payroll_logs WHERE payroll_date  BETWEEN '".$period_start."' AND '".$period_end."' ";
        return count(DB::select(DB::raw($query)));
    }
    function p10($period_start, $period_end){
        $query = "SELECT payroll_date, SUM(salary) as sum_salary, SUM(salary+allowances) as sum_gross, SUM(sdl) as sum_sdl FROM payroll_logs WHERE payroll_date BETWEEN   '".$period_start."' AND '".$period_end."' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }

    function s_p10($period_start, $period_end){
        $query = "SELECT payroll_date, SUM(pl.salary) as sum_salary, SUM(pl.salary+pl.allowances) as sum_gross, SUM(pl.sdl) as sum_sdl
FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 and payroll_date BETWEEN   '".$period_start."' AND '".$period_end."' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }

    function v_p10($period_start, $period_end){
        $query = "SELECT payroll_date, SUM(pl.salary) as sum_salary, SUM(pl.salary+pl.allowances) as sum_gross, SUM(pl.sdl) as sum_sdl
FROM payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 and payroll_date BETWEEN   '".$period_start."' AND '".$period_end."' GROUP BY payroll_date ORDER BY payroll_date ASC";
        return DB::select(DB::raw($query));
    }

    function totalp10($period_start, $period_end){
        $query = " SELECT SUM(salary) as total_salary, SUM(salary+allowances) as total_gross, SUM(sdl) as total_sdl FROM payroll_logs WHERE payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";
        return DB::select(DB::raw($query));
    }

    function s_totalp10($period_start, $period_end){
        $query = " SELECT SUM(pl.salary) as total_salary, SUM(pl.salary+pl.allowances) as total_gross, SUM(pl.sdl) as total_sdl
 FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type != 2 and payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";
        return DB::select(DB::raw($query));
    }

    function v_totalp10($period_start, $period_end){
        $query = " SELECT SUM(pl.salary) as total_salary, SUM(pl.salary+pl.allowances) as total_gross, SUM(pl.sdl) as total_sdl
 FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type = 2 and payroll_date BETWEEN   '".$period_start."' AND '".$period_end."'";
        return DB::select(DB::raw($query));
    }


    function heslb($payrolldate){
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE l.empID = e.emp_id AND ll.loanID = l.id AND l.type = 3 AND ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));

    }

    function s_heslb($payrolldate){
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE l.empID = e.emp_id and e.contract_type != 2 AND ll.loanID = l.id AND l.type = 3 AND ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));

    }

    function v_heslb($payrolldate){
        $query = "SELECT @s:=@s+1 as SNo, l.form_four_index_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, ll.paid, ll.remained FROM employee e, loan_logs ll, loan l, (SELECT @s:=0) s WHERE l.empID = e.emp_id and e.contract_type = 2 AND ll.loanID = l.id AND l.type = 3 AND ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));

    }

    function totalheslb($payrolldate){
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll  WHERE ll.loanID = l.id AND l.type = 3 AND  ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));
    }

    function s_totalheslb($payrolldate){
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type != 2 AND  ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));
    }

    function v_totalheslb($payrolldate){
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e  WHERE ll.loanID = l.id AND l.type = 3 AND e.emp_id = l.empID and e.contract_type = 2 and ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));
    }

    function staffTotalheslb($payrolldate){
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type != 2 AND  ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));
    }

    function volunteerTotalheslb($payrolldate){
        $query = "SELECT if(SUM(ll.paid) IS NULL, 0, SUM(ll.paid)) as total_paid, IF(SUM(ll.remained) IS NULL, 0, SUM(ll.remained)) as total_remained  FROM loan l, loan_logs ll, employee e  WHERE ll.loanID = l.id AND l.type = 3 and e.emp_id = l.empID and e.contract_type = 2 AND  ll.payment_date = '".$payrolldate."'";
        return DB::select(DB::raw($query));
    }

    function pension($date, $pensionFund){
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer  FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id AND pl.pension_fund = '".$pensionFund."' AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }

    function s_pension($date, $pensionFund){
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer
 FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type != 2 AND pl.pension_fund = '".$pensionFund."' AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }

    function v_pension($date, $pensionFund){
        $query = "SELECT @s:=@s+1 as SNo, e.pf_membership_no , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, pl.salary as salary, pl.allowances,pl.pension_employee, pl.pension_employer
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type = 2 AND pl.pension_fund = '".$pensionFund."' AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }

    function totalpension($date, $pensionFund){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer  FROM  payroll_logs pl WHERE pl.pension_fund = '".$pensionFund."' AND  pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }

    function s_totalpension($date, $pensionFund){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer
FROM  payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.pension_fund = '".$pensionFund."' AND  pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }

    function v_totalpension($date, $pensionFund){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.pension_employee) as totalpension_employee, SUM(pl.pension_employer) as totalpension_employer
FROM  payroll_logs pl, employee e WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.pension_fund = '".$pensionFund."' AND  pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));

    }


    function employmentCostCheck($date){
        $query = " SELECT id as PayrollLogs FROM payroll_logs WHERE payroll_date like  '%".$date."%' ";

        return count(DB::select(DB::raw($query)));
    }

    function employmentCost($date){

        $query = "SELECT @s:=@s+1 sNo, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, pl.*, (pl.last_paid_personal_loan+pl.last_paid_heslb+pl.last_paid_salary_advance+pl.last_paid_other_deductions) as loans
	FROM employee AS e, (SELECT @s:=0) as s, payroll_logs pl WHERE pl.empID = e.emp_id and e.state = 1 and pl.payroll_date like '%".$date."%'";

        return DB::select(DB::raw($query));
    }

    function totalEmploymentCost($date){
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
SUM(ll.taxdue) as TAXDUE FROM payroll_logs ll, employee e WHERE e.emp_id = ll.empID AND ll.payroll_date like '%".$date."%'  GROUP BY e.state";

        return DB::select(DB::raw($query));
    }



    function wcf($date){
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, pl.salary as salary, pl.allowances  FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }
    function totalwcf($date){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf  FROM  payroll_logs pl WHERE pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }

    function s_wcf($date){
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, pl.salary as salary, pl.allowances
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }

    function s_totalwcf($date){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf
FROM  payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type != 2 and pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }

    function v_wcf($date){
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id , CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, e.tin as tin, e.national_id as national_id, pl.salary as salary, pl.allowances
FROM employee e, payroll_logs pl, (SELECT @s:=0) s WHERE pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }
    function v_totalwcf($date){
        $query = "SELECT SUM(pl.salary) as totalsalary, SUM(pl.allowances) as totalgross, SUM(pl.wcf) as totalwcf
FROM  payroll_logs pl, employee e WHERE pl.empID = e.emp_id and e.contract_type = 2 and pl.payroll_date LIKE '%".$date."%'";
        return DB::select(DB::raw($query));
    }


    function individual_employment_cost($id){
        $query = "SELECT
	SUM(e.salary+((SELECT rate from allowance WHERE id=1)*e.salary)+epv.amount+((SELECT rate_employer from deduction where id =1 )*(e.salary))+((SELECT rate_employer from deduction where id =4 )*(e.salary))+((SELECT rate_employer from deduction where id =2 )*(e.salary))+((SELECT rate_employer from deduction where id =5 )*(e.salary))) as TOTAL_COST
	FROM employee e, emp_package_view epv  WHERE e.emp_id = epv.empID and e.state=1 and e.emp_id = '".$id."'";
        return DB::select(DB::raw($query));

    }



    function payrollcheck($id){
        $query = "SELECT count(empID) as CHECKs FROM payroll_logs WHERE empID = '".$id."'";

        return DB::select(DB::raw($query));
    }

    function payrollcheck2($id, $date){
        $query = "SELECT count(empID) as CHECKs FROM payroll_logs WHERE empID = '".$id."' AND due_date like '".$date."%'";

        return DB::select(DB::raw($query));
    }


    function checkleave($empID){

        $query="SELECT  empID from leaves where empID='".$empID."'";
        return count(DB::select(DB::raw($query)));

    }

    function yeartodate($id){
        $query = "SELECT sum(basic+allowance-pension_employee) as TAXABLE, SUM(paye) as paye,  SUM(allowance+basic) as GROSS,(SELECT due_date from payroll_logs WHERE empID='25500002' ORDER by id desc limit 1) as DUEDATE  FROM (select id, basic, allowance, pension_employee, paye from payroll_logs where empID='".$id."' order by id desc limit 12) as SUM, (SELECT due_date from payroll_logs WHERE empID='".$id."' ORDER by id desc limit 1) as DATE";
        return DB::select(DB::raw($query));
    }


    function leavedays($id) {
        $query=" SELECT DISTINCT empID, IF((( SELECT sum(days)  FROM `leaves` where nature=1 AND e.emp_id=leaves.empID GROUP by nature, empID)>0), (SELECT sum(days)  FROM `leaves` where nature=1 AND e.emp_id=leaves.empID GROUP by nature),0) as LEAVEDAYS,

IF((( SELECT sum(days)  FROM `leaves` where nature=2 AND e.emp_id=leaves.empID GROUP by nature)>0),  (SELECT sum(days)  FROM `leaves` where nature=2 AND e.emp_id=leaves.empID GROUP by nature),0) as EXAM,

IF((( SELECT sum(days)  FROM `leaves` where nature=3 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=3 AND e.emp_id=leaves.empID GROUP by nature),0) as MATERNITY,

IF((( SELECT sum(days)  FROM `leaves` where nature=5 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=5 AND e.emp_id=leaves.empID GROUP by nature),0) as SICK,

IF((( SELECT sum(days)  FROM `leaves` where nature=6 AND e.emp_id=leaves.empID GROUP by nature)>0),(SELECT sum(days)  FROM `leaves` where nature=6 AND e.emp_id=leaves.empID GROUP by nature),0) as COMPASSIONATE FROM employee e, leaves WHERE e.emp_id=leaves.empID and e.emp_id='".$id."' ";

        return DB::select(DB::raw($query));
    }


    function loan()
    {
        $query="SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  ";

        return DB::select(DB::raw($query));
    }


    function loanreport1($dates, $datee) //ALL
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id  and  l.last_paid_date BETWEEN '".$dates."' AND '".$datee."' ";

        return DB::select(DB::raw($query));
    }


    function loanreport3($dates, $datee) //COMPLETED
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id and l.state = 0  and  l.last_paid_date BETWEEN '".$dates."' AND '".$datee."'  ";

        return DB::select(DB::raw($query));
    }


    function loanreport2($dates, $datee) //ONPROGRESS
    {
        $query = "SELECT @s:=@s+1 SNo, l.empID, lt.name as TYPE, l.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME, d.name as DEPARTMENT, p.name as POSITION FROM loan l, employee e, position p, department d, loan_type lt, (SELECT @s:=0) as s WHERE l.empID=e.emp_id and e.position=p.id and e.department=d.id and l.type=lt.id and l.state = 1  and  l.last_paid_date BETWEEN '".$dates."' AND '".$datee."' ";

        return DB::select(DB::raw($query));
    }



    function leavereport_line($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and e.line_manager ='".$id."' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and e.emp_id ='".$id."'";

        return DB::select(DB::raw($query));
    }

    /*	function leavereport1($dates, $datee)
        {
            $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' ";

            return DB::select(DB::raw($query));
        }*/

    function leavereport_all($dates, $datee)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' ";

        return DB::select(DB::raw($query));
    }

    function leavereport_completed($dates, $datee, $today)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end < '".$today."' AND ls.start BETWEEN '".$dates."' AND '".$datee."' ";

        return DB::select(DB::raw($query));
    }

    function leavereport_progress($dates, $datee, $today)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id AND ls.end > '".$today."' AND ls.start between '".$dates."' and '".$datee."' ";

        return DB::select(DB::raw($query));
    }


    function leavereport1_line($dates, $datee, $id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.line_manager = '".$id."' UNION SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.start between '".$dates."' and '".$datee."' and e.emp_id = '".$id."'";

        return DB::select(DB::raw($query));
    }

    function leavereport2($id)
    {
        $query = "SELECT @s:=@s+1 as SNo, p.name as POSITION, lt.type as TYPE, d.name as DEPARTMENT,   CONCAT(fname,' ', mname,' ', lname) as NAME, ls.* FROM leaves ls, leave_type lt, position p, department d, employee e, (SELECT @s:=0) as s where e.emp_id = ls.empID and e.position = p.id and e.department = d.id and ls.nature = lt.id and ls.empID = '".$id."' ";

        return DB::select(DB::raw($query));
    }


    function customleave($id) {
        $query = "SELECT  CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME  FROM  employee e WHERE e.emp_id = '".$id."'";
        return DB::select(DB::raw($query));
    }


    function payslipcheck($datecheck, $empID){
        $query = " SELECT id  FROM payroll_logs WHERE payroll_date LIKE '%".$datecheck."%' AND empID = '".$empID."' ";

        return count(DB::select(DB::raw($query)));
    }

    function temp_payslipcheck($datecheck, $empID){
        $query = " SELECT id  FROM temp_payroll_logs WHERE payroll_date LIKE '%".$datecheck."%' AND empID = '".$empID."' ";

        return count(DB::select(DB::raw($query)));
    }

    function payslipcheckAll($datecheck){
        $query = " SELECT  *  FROM payroll_logs WHERE payroll_date LIKE '%".$datecheck."%' ";
        return count(DB::select(DB::raw($query)));
    }

    function s_payrollLogEmpID($datecheck){
        $query = "SELECT empID FROM payroll_logs pl, employee e where e.emp_id = pl.empID
and e.contract_type != 2 and payroll_date LIKE '%".$datecheck."%' ";
        return DB::select(DB::raw($query));
    }

    function v_payrollLogEmpID($datecheck){
        $query = "SELECT empID FROM payroll_logs pl, employee e where e.emp_id = pl.empID
and e.contract_type = 2 and payroll_date LIKE '%".$datecheck."%' ";
        return DB::select(DB::raw($query));
    }

    function payslip_info_backup($empID, $payroll_month_end, $payroll_month, $year_back ){
        $query = "SELECT pl.empID as empID,

CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,
 p.name as position,
  d.name as department, e.hire_date,

 pl.*,

(SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employee_todate,

 (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employer_todate,

 (SELECT SUM(plg.basic_salary+plg.allowance+plg.other_benefits-plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID  = '".$empID."' and plg.payroll_date BETWEEN '".$year_back."' and '".$payroll_month_end."' ) as year_todate_taxable,

 (SELECT SUM(plg.basic_salary+plg.allowance+plg.other_benefits+plg.medical_employer) FROM  payroll_logs plg WHERE  plg.empID  = '".$empID."' and plg.payroll_date BETWEEN '".$year_back."' and '".$payroll_month_end."' ) as year_todate_earnings,

 (SELECT SUM(plg.taxdue) FROM  payroll_logs plg WHERE plg.empID  =  '".$empID."' and plg.payroll_date BETWEEN '".$year_back."' and '".$payroll_month_end."') as year_todate_taxdue,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 1 AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 1 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."' ),0) as annual_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 2 and pl.empID = '".$empID."' AND lv.start BETWEEN e.hire_date AND '2018-12-25' )>0,(SELECT lv.days FROM leaves lv   where lv.nature = 2 and e.emp_id= '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."' ),0) as exam_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 3 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 3 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."' ),0)  as maternity_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 6 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 6 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '".$payroll_month_end."' ),0) as compassionate_leave,

 IF((SELECT COUNT(lv.id) FROM leaves lv where lv.empID = e.emp_id and lv.nature = 5 and e.emp_id = '".$empID."' AND lv.start BETWEEN e.hire_date AND '2018-12-30')>0,(SELECT sum(lv.days) FROM leaves lv   where lv.nature = 5 AND lv.start BETWEEN e.hire_date and e.emp_id = '".$empID."' AND '".$payroll_month_end."' ),0) as sick_leave


FROM payroll_logs pl, employee e, department d, position p  WHERE e.emp_id = pl.empID and e.position = p.id and d.id = e.department and pl.payroll_date LIKE '%".$payroll_month."%' and pl.empID = '".$empID."'";
        return DB::select(DB::raw($query));

    }


#START PAYSLIP SCANIA PAYROLL

    function payslip_info($empID, $payroll_month_end, $payroll_month){
        $query = "SELECT
    pl.empID as empID,
    e.old_emp_id as oldID,
    CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,
    d.name as department_name,
    p.name as position_name,
    br.name as branch_name,
    bn.name as bank_name,
    pf.name as pension_fund_name,
    pf.abbrv as pension_fund_abbrv,
    e.hire_date,
    (SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employee_todate,
    (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employer_todate,
    pl.*
    FROM payroll_logs pl, employee e, department d, position p, bank bn, pension_fund pf, branch br  WHERE e.emp_id = pl.empID AND pl.branch = br.id AND pl.bank = bn.id AND pl.pension_fund = pf.id AND e.position = p.id AND d.id = e.department AND pl.payroll_date LIKE '%".$payroll_month."%' and pl.empID = '".$empID."'";
        return DB::select(DB::raw($query));

    }

    function temp_payslip_info($empID, $payroll_month_end, $payroll_month){
        $query = "SELECT
    pl.empID as empID,
    e.old_emp_id as oldID,
    CONCAT(e.fname,' ', e.mname,' ', e.lname) as name,
    d.name as department_name,
    p.name as position_name,
    br.name as branch_name,
    bn.name as bank_name,
    pf.name as pension_fund_name,
    pf.abbrv as pension_fund_abbrv,
    e.hire_date,
    (SELECT SUM(plg.pension_employee) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employee_todate,
    (SELECT SUM(plg.pension_employer) FROM  payroll_logs plg WHERE plg.empID = e.emp_id and e.emp_id = '".$empID."' and plg.payroll_date BETWEEN e.hire_date and '".$payroll_month_end."' ) as pension_employer_todate,
    pl.*
    FROM temp_payroll_logs pl, employee e, department d, position p, bank bn, pension_fund pf, branch br  WHERE e.emp_id = pl.empID AND pl.branch = br.id AND pl.bank = bn.id AND pl.pension_fund = pf.id AND e.position = p.id AND d.id = e.department AND pl.payroll_date LIKE '%".$payroll_month."%' and pl.empID = '".$empID."'";
        return DB::select(DB::raw($query));

    }

    function leaves($empID, $payroll_month_end){
        $query = "SELECT lt.type AS nature, l.nature as type, SUM(l.days) AS days FROM leaves l, employee e, leave_type lt WHERE e.emp_id = l.empID AND lt.id = l.nature AND l.start BETWEEN e.hire_date AND '".$payroll_month_end."' AND e.emp_id = '".$empID."' GROUP BY l.empID, l.nature";
        return DB::select(DB::raw($query));
    }
    function annualLeaveSpent($empID, $payroll_month_end){
        $query = "SELECT IF( (SELECT SUM(l.days) FROM leaves l WHERE e.emp_id = l.empID AND l.nature = 1 AND l.start BETWEEN e.hire_date AND '".$payroll_month_end."' AND e.emp_id = '".$empID."'  GROUP BY l.empID, l.nature)>0, (SELECT SUM(l.days) FROM leaves l WHERE e.emp_id = l.empID AND l.nature = 1 AND l.start BETWEEN e.hire_date AND '".$payroll_month_end."' AND e.emp_id = '".$empID."' GROUP BY l.empID, l.nature), 0 ) AS days FROM employee e";
        $row = DB::select(DB::raw($query));
        return $row[0]->days;
    }

    function allowances($empID, $payroll_month){
        $query = "SELECT description, amount FROM allowance_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));
    }

    function temp_allowances($empID, $payroll_month){
        $query = "SELECT description, amount FROM temp_allowance_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));
    }

    function deductions($empID, $payroll_month){
        $query = "SELECT description, paid FROM deduction_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));

    }

    function temp_deductions($empID, $payroll_month){
        $query = "SELECT description, paid FROM temp_deduction_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));

    }

//This function throws Exception on Emails
    /*function total_allowances($empID, $payroll_month){
        $query = "SELECT SUM(amount) as total FROM allowance_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID";
        $row = $query->row();
        return $row->total;

    }*/
    function total_allowances($empID, $payroll_month){
        $query = "SELECT IF( (SELECT SUM(amount)  FROM allowance_logs WHERE empID = '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID)>0, (SELECT SUM(amount)  FROM allowance_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID), 0) AS total";
        $row = DB::select(DB::raw($query));
        return $row[0]->total;

    }

    function temp_total_allowances($empID, $payroll_month){
        $query = " IF( ( SUM(amount) WHERE empID = '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID)>0, (SUM(amount)  WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID), 0) AS total";
        $row = DB::table('temp_allowance_logs')
        ->select(DB::raw($query))
        ->first();
        return $row->total;

    }



    function total_pensions($empID, $payroll_date){
        $query = "SELECT SUM(pl.pension_employee) as total_pension_employee, SUM(pl.pension_employer) as total_pension_employer  FROM payroll_logs pl, employee e WHERE pl.empID = e.emp_id AND pl.empID =  '".$empID."' AND pl.payroll_date <= '".$payroll_date."' GROUP BY pl.empID";
        return DB::select(DB::raw($query));

    }

    function temp_total_pensions($empID, $payroll_date){
        $query = "SELECT SUM(pl.pension_employee) as total_pension_employee, SUM(pl.pension_employer) as total_pension_employer  FROM temp_payroll_logs pl, employee e WHERE pl.empID = e.emp_id AND pl.empID =  '".$empID."' AND pl.payroll_date <= '".$payroll_date."' GROUP BY pl.empID";
        return DB::select(DB::raw($query));

    }

//This function throws Exception on Emails
    /*function total_deductions($empID, $payroll_month){
        $query = "SELECT SUM(paid) as total FROM deduction_logs WHERE empID =  '".$empID."' and payment_date like '%".$payroll_month."%' GROUP BY empID";
        $row = $query->row();
        return $row->total;

    }*/
    function total_deductions($empID, $payroll_month){
        $query = "SELECT IF( (SELECT SUM(paid) FROM deduction_logs WHERE  empID = '".$empID."' AND payment_date like '%".$payroll_month."%' GROUP BY empID)>0, (SELECT SUM(paid) FROM deduction_logs WHERE  empID =  '".$empID."' AND payment_date like '%".$payroll_month."%' GROUP BY empID), 0) AS total";
        $row = DB::select(DB::raw($query));

        return $row[0]->total;

    }

    function temp_total_deductions($empID, $payroll_month){
        $query = " IF( (SUM(paid)  WHERE  empID = '".$empID."' AND payment_date like '%".$payroll_month."%' GROUP BY empID)>0, ( SUM(paid)  WHERE  empID =  '".$empID."' AND payment_date like '%".$payroll_month."%' GROUP BY empID), 0) AS total";
        $row = DB::table('temp_deduction_logs')
        ->select(DB::raw($query))
        ->first();
        return $row->total;

    }

    function loans($empID, $payroll_month){
        $query = "SELECT l.description, ll.paid, ll.remained, ll.policy FROM loan_logs ll, loan l WHERE ll.loanID = l.id AND l.empID =  '".$empID."' AND ll.payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));

    }

    function temp_loans($empID, $payroll_month){
        $query = "SELECT l.description, ll.paid, ll.remained, ll.policy FROM temp_loan_logs ll, loan l WHERE ll.loanID = l.id AND l.empID =  '".$empID."' AND ll.payment_date like '%".$payroll_month."%'";
        return DB::select(DB::raw($query));

    }

    function loansPolicyAmount($empID, $payroll_month){
        $query = "SELECT amount FROM loan where empID = '".$empID."'";
        $query_prev = "SELECT sum(paid) as prev_paid FROM loan_logs where remained > 0 and payment_date <= '".$payroll_month."'";
        return [DB::select(DB::raw($query)),DB::select(DB::raw($query_prev))];

    }

    function temp_loansPolicyAmount($empID, $payroll_month){
        $query = "SELECT amount FROM loan where empID = '".$empID."'";
        $query_prev = "SELECT sum(paid) as prev_paid FROM temp_loan_logs where remained > 0 and payment_date <= '".$payroll_month."'";
        return [DB::select(DB::raw($query)),DB::select(DB::raw($query_prev))];

    }

    function loansAmountRemained($empID, $payroll_month){
        $query = "SELECT remained
        FROM (
          SELECT remained
          FROM loan_logs ll, loan l where l.id = ll.loanID and l.empID = '".$empID."' and last_paid_date = '".$payroll_month."'
          ORDER BY remained ASC LIMIT 2
        ) z
        where remained != 0 ORDER BY remained asc LIMIT 1";


    $row = DB::select(DB::raw($query));
    

        if($row){
            return $row[0]->remained;
        }else{
            return null;
        }

    }

    function temp_loansAmountRemained($empID, $payroll_month){

        $query = "SELECT remained
        FROM (
          SELECT remained
          FROM temp_loan_logs ll, loan l where l.id = ll.loanID and l.empID = '".$empID."' and last_paid_date = '".$payroll_month."'
          ORDER BY remained ASC LIMIT 2
        ) z
        where remained != 0 ORDER BY remained asc LIMIT 1";


    $row = DB::select(DB::raw($query));
    

        if($row){
            return $row[0]->remained;
        }else{
            return null;
        }
    }


#END PAYSLIP SCANIA PAYROLL


    function total_employment_cost(){
        $query = 'SELECT SUM(e.salary+((SELECT rate from allowance WHERE id=1)*e.salary)+epv.amount+((SELECT rate_employer from deduction where id =1 )*(e.salary))+((SELECT rate_employer from deduction where id =4 )*(e.salary))+((SELECT rate_employer from deduction where id =2 )*(e.salary))+((SELECT rate_employer from deduction where id =5 )*(e.salary))) as TOTAL_Employment_Cost

FROM employee e, emp_package_view epv  WHERE e.emp_id = epv.empID and e.state=1';
        return DB::select(DB::raw($query));

    }

    function attendance_list($date){
        $query = "SELECT @s:=@s+1 as SNo, e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position, CAST(att.due_in as date) as date_in,   CAST(att.due_in as time) as time_in, IF( CAST(att.due_out as time)= CAST(att.due_in as time), 'NOT SIGNED OUT', CAST(att.due_out as time) ) as time_out FROM employee e, attendance att, position p, department d, (SELECT @s:=0) as s WHERE att.empID = e.emp_id and e.department = d.id and e.position = p.id and  CAST(att.due_in as date) = '".$date."'  ";

        return DB::select(DB::raw($query));
    }

    function strategic_kpi_check($empID){
        $query = "count(st.id) as strategicKPI WHERE st.id IN (SELECT t.strategy_ref FROM task t WHERE NOT t.strategy_ref = 0 AND  t.isAssigned = 1 AND t.assigned_to =  '".$empID."' )";
        $row = DB::table('strategy as st')
        ->select(DB::raw($query))
        ->first();
        return $row->strategicKPI;
    }

    function adhoc_kpi_check($empID){
        $query = "COUNT(t.id) as adhocKPI WHERE t.strategy_ref = 0 AND t.output_ref = 0 AND t.isAssigned = 1 AND t.assigned_to =  '".$empID."' ";
        $row = DB::table(' task t')
        ->select(DB::raw($query))
        ->first();
        return $row->adhocKPI;
    }
    function allStrategies($empID) 	{
        $query = "SELECT @s:=@s+1 as SNo, str.id ,  str.title as name FROM strategy str, (SELECT @s:=0) as s  WHERE str.id IN (SELECT t.strategy_ref FROM task t WHERE t.isAssigned = 1 AND t.assigned_to = '".$empID."')";

        return DB::select(DB::raw($query));
    }
    function strategicTasks($stategyID, $empID) 	{
        $query = "SELECT t.*  FROM task t WHERE t.strategy_ref = ".$stategyID." AND t.isAssigned = 1 AND t.assigned_to =  '".$empID."' ";

        return DB::select(DB::raw($query));
    }
    function adhocTasks($empID) 	{
        $query = "SELECT  @s:=@s+1 as sNo, t.*  FROM task t, (SELECT @s:=0) as s WHERE t.strategy_ref = 0 AND t.isAssigned = 1 AND t.assigned_to =  '".$empID."' ";

        return DB::select(DB::raw($query));
    }
    function employeeInfo($empID)	{
        $query = "SELECT  e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, d.name as department, p.name as position, (SELECT CONCAT(el.fname,' ', el.mname,' ', el.lname) FROM employee el WHERE el.emp_id = e.line_manager) as leader FROM employee e, department d, position p WHERE e.position = p.id AND e.department = d.id AND e.emp_id = '".$empID."' ";

        return DB::select(DB::raw($query));
    }
    function taskDuration($empID)	{
        $query = "SELECT (SELECT t.date_assigned FROM task t WHERE t.assigned_to = '".$empID."' AND t.isAssigned = 1 ORDER BY t.date_assigned ASC LIMIT 1) as started, (SELECT t.date_assigned FROM task t WHERE t.assigned_to = '".$empID."' AND t.isAssigned = 1 ORDER BY t.date_assigned DESC LIMIT 1) as updated ";

        return DB::select(DB::raw($query));
    }
    function averageTaskPerformance($empID)	{
        $query = "t.assigned_to, AVG(t.quality+t.quantity) as average WHERE t.status = 2 AND t.assigned_to = '".$empID."' ";

        $row = DB::table('task as t')
        ->select(DB::raw($query))
        ->first();
        return $row->average;
    }
    function averageQuantityBehaviour($empID)	{
        $query = "SELECT t.assigned_to, AVG(t.quality) as average_behaviour, AVG(t.quantity) as average_quantity  FROM task t WHERE t.status = 2 AND t.assigned_to = '".$empID."' ";
        return DB::select(DB::raw($query));
    }

//VSO EXCEL EXPORT
    function payrollInputJournalExport($payroll_date)	{
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank AND isActive = 1 AND pl.payroll_date = '".$payroll_date."' and eav.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    function staffPayrollInputJournalExport($payroll_date)	{
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND isActive = 1 AND pl.payroll_date = '".$payroll_date."' and eav.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    function volunteerPayrollInputJournalExport($payroll_date)	{
        $query = "SELECT eav.*,  pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID and e.contract_type = 2 AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b, vw_employee_activity eav WHERE pl.empID = eav.empID and pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch and e.contract_type = 2 AND b.id = e.bank AND isActive = 1 AND pl.payroll_date = '".$payroll_date."' and eav.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    public function staffPayrollBankExport($payroll_date){
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND NOT e.contract_type = 2 AND b.id = e.bank AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    public function staffPayrollBankExport_temp($payroll_date){
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND NOT e.contract_type = 2 AND b.id = e.bank AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }



    public function volunteerPayrollBankExport($payroll_date){
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND e.contract_type = 2  AND NOT e.bank = 5 AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    public function volunteerPayrollBankExport_temp($payroll_date){
        $query = "SELECT e.*, pl.*, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, b.name as bankName,b.bank_code as bankCode, bb.branch_code as bankLoalClearingCode, 'DAR' as debitAccountCityCode, 'TZ' as debitAccountCountryCode, 'TZS' as paymentCurrency,
	IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, temp_payroll_logs pl,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND bb.id= e.bank_branch AND b.id = e.bank AND e.contract_type = 2  AND NOT e.bank = 5 AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }



    public function volunteerAllowanceMWPExport($payroll_date){
        $query = "SELECT e.*, pl.*, br.name as branch_name, (SELECT service_name FROM mobile_service_provider WHERE number_prefix =  SUBSTRING(e.mobile, 1, 3)) as service_name, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName,
    IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions
	FROM employee e, payroll_logs pl, bank_branch br WHERE pl.empID = e.emp_id  AND  e.contract_type = 2 AND e.bank = 5 and br.id = e.bank_branch AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    public function volunteerAllowanceMWPExport_temp($payroll_date){
        $query = "SELECT e.*, pl.*, br.name as branch_name, (SELECT service_name FROM mobile_service_provider WHERE number_prefix =  SUBSTRING(e.mobile, 1, 3)) as service_name, e.account_no,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName,
    IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions
	FROM employee e, temp_payroll_logs pl, bank_branch br WHERE pl.empID = e.emp_id  AND  e.contract_type = 2 AND e.bank = 5 and br.id = e.bank_branch AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }


    public function employeeArrearByMonth($empID,$payroll_month){
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid from arrears_logs, arrears where arrear_id=arrears.id and empID = '".$empID."' and arrears_logs.payroll_date = '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearPaidAll($empID,$payroll_month){
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid from arrears_logs, arrears where arrear_id=arrears.id and empID = '".$empID."' and arrears_logs.payroll_date <= '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAllPaid($empID,$payroll_month){
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid_all from arrears_logs, arrears where arrear_id=arrears.id and empID = '".$empID."' and arrears_logs.payroll_date <= '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAllPaid1($payroll_month){
        $query = "select sum(arrears_logs.amount_paid) as arrears_paid_all from arrears_logs, arrears where arrear_id=arrears.id and arrears_logs.payroll_date <= '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeeArrearAll($empID,$payroll_month){
        $query = "select sum(arrears.amount) as arrears_all from arrears where empID = '".$empID."' and arrears.payroll_date <= '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeePaidWithArrear($empID,$payroll_month){
        $query = "select sum(arrears.amount) as with_arrears from arrears where empID = '".$empID."' and arrears.payroll_date = '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function employeeProfile($empID){
        $query = "select e.emp_id,e.fname, e.mname, e.lname, e.gender, e.birthdate, e.nationality, e.email,
d.name as department, p.name as position, b.name as branch, concat(el.fname,' ',el.mname,' ',el.lname) as line_manager, c.name as contract, e.salary,
pf.name as pension, e.pf_membership_no as pension_number, e.account_no, e.mobile
from employee e, department d, position p, branch b, employee el, contract c, pension_fund pf where e.department = d.id and e.position = p.id
and e.branch = b.code and e.line_manager = el.emp_id and c.id = e.contract_type and e.pension_fund = pf.id and e.state != 4 and e.emp_id = '".$empID."'";
        return DB::select(DB::raw($query));

    }

    public function paye(){
        $query = "select * from paye";
        return DB::select(DB::raw($query));
    }

    public function prevPayrollMonth($date){
        $query = "payroll_date";
        $condition = "%".$date."%";
         $row = DB::table('payroll_months')
         ->where('payroll_date','like',$condition)
         ->select(DB::raw($query))
         ->first();
        if ($row) {

            return $row->payroll_date;
        }else {
            return null;
        }


    }

    public function employeeGross_temp($payroll_date,$empID){
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM temp_payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '".$payroll_date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));

    }

    public function employeeGross_temp1($payroll_date,$empID){
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '".$payroll_date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));

    }

    public function s_employeeGross($payroll_date,$empID){
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.payroll_date = '".$payroll_date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));

    }

    public function v_employeeGross($payroll_date,$empID){
        $query = "SELECT concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name,SUM(pl.salary+pl.allowances) as gross
            FROM payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.payroll_date = '".$payroll_date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));

    }

    public function s_payrollEmployee($current,$previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type != 2 and (pl.payroll_date = '".$current."' or pl.payroll_date = '".$previous."')";
        return DB::select(DB::raw($query));
    }

    public function payrollEmployee_temp($current,$previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from temp_payroll_logs pl, employee e where e.emp_id = pl.empID and (pl.payroll_date = '".$current."')";
        return DB::select(DB::raw($query));
    }

    public function payrollEmployee_temp1($current,$previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and (pl.payroll_date = '".$previous."')";
        return DB::select(DB::raw($query));
    }

    public function v_payrollEmployee($current,$previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and (pl.payroll_date = '".$current."' or pl.payroll_date = '".$previous."')";
        return DB::select(DB::raw($query));
    }

    public function v_payrollEmployee_temp($current,$previous)
    {
        $query = "select distinct pl.empID, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name from temp_payroll_logs pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and (pl.payroll_date = '".$current."' or pl.payroll_date = '".$previous."')";
        return DB::select(DB::raw($query));
    }

    public function s_grossMonthly($payroll_date){
        $query = "SELECT SUM(pl.salary+pl.allowances) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID and e.contract_type != 2 and pl.payroll_date = '".$payroll_date."' group by pl.payroll_date";

        $row = DB::select(DB::raw($query));

        if ($row){
            return $row[0]->total_gross;
        }else{
            return null;
        }
    }

    public function grossMonthly_temp($payroll_date){
        $query = "SELECT SUM(pl.salary+pl.allowances) as total_gross FROM temp_payroll_logs pl, employee e
            WHERE e.emp_id = pl.empID and pl.payroll_date = '".$payroll_date."' group by pl.payroll_date";
      
      $data = DB::select(DB::raw($query));

    
       if ($data){
            return $data[0]->total_gross;
        }else{
            return null;
        }
    }

    public function grossMonthly_temp1($payroll_date){
        $query = "SUM(pl.salary+pl.allowances) as total_gross";


        $row = DB::table('payroll_logs as pl')
        ->join('employee as e', 'e.emp_id', '=', 'pl.empID')
        ->where('pl.payroll_date',$payroll_date)
         ->select(DB::raw($query))
         //->groupBy('pl.payroll_date')
         ->first();

        if ($row){
            return $row->total_gross;
        }else{
            return null;
        }
    }

    public function v_grossMonthly($payroll_date){
        $query = "SELECT SUM(pl.salary+pl.allowances) as total_gross FROM payroll_logs pl, employee e
        WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.payroll_date = '".$payroll_date."' group by pl.payroll_date";

        $row = DB::select(DB::raw($query));
        //dd($row);
        if ($row){
            return $row[0]->total_gross;
        }else{
            return null;
        }
    }

    public function v_grossMonthly_temp($payroll_date){
        $query = "SUM(pl.salary+pl.allowances) as total_gross
            WHERE e.emp_id = pl.empID and e.contract_type = 2 and pl.payroll_date = '".$payroll_date."' group by pl.payroll_date";
        $row = DB::table('payroll_logs pl, employee e')
        ->select(DB::raw($query))
        ->first();
        if ($row){
            return $row->total_gross;
        }else{
            return null;
        }
    }

    function employeeNetTemp($date, $empID){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
        IF((SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM temp_allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
     IF((SELECT COUNT(al.id) FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM temp_allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
        IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
        pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
        IF((SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM temp_loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
        IF((SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM temp_deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
     pl.account_no
        FROM employee e, temp_payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '".$date."' and pl.empID = '".$empID."' ";

            return DB::select(DB::raw($query));
    }

    function employeeNetTemp1($date, $empID){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id AND pl.payroll_date = '".$date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));
    }

    function s_employeeNet($date, $empID){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type != 2 AND pl.payroll_date = '".$date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));
    }

    function v_employeeNet($date, $empID){

        $query = "SELECT pl.empID, dpt.name, dpt.code, e.fname, e.mname, e.lname,e.hire_date as hire_date,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
 IF((SELECT COUNT(al.id) FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date )>0, (SELECT al.amount FROM allowance_logs al WHERE al.allowanceID = 6 and al.empID = pl.empID AND al.payment_date = pl.payroll_date), 0) as housingAllowance,
	IF((SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID)>0, (SELECT SUM(ol.amount) FROM overtime_logs ol WHERE ol.payment_date = pl.payroll_date and ol.empID = pl.empID), 0) as overtimes,
	pl.salary, pl.less_takehome, pl.medical_employee, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
 pl.account_no
	FROM employee e, payroll_logs pl, department dpt WHERE dpt.id = pl.department AND pl.empID = e.emp_id and e.contract_type = 2 AND pl.payroll_date = '".$date."' and pl.empID = '".$empID."' ";

        return DB::select(DB::raw($query));
    }

    function nonPensionableEmployee($emp_id){
        $query = "select * from employee where pension_fund = '3' and emp_id = '".$emp_id."' ";
        return DB::select(DB::raw($query));
    }

    function s_loanReport($payroll_date){
        $query = "select ll.id as log_id,e.emp_id, concat(e.fname,' ',e.mname,' ',e.lname) as name, l.description, l.amount,
(select sum(paid) from loan_logs ill where ill.loanID = l.id and ill.payment_date <= '".$payroll_date."' group by ill.loanID) as paid, l.amount_last_paid ,
l.amount_last_paid,ll.payment_date,pl.payroll_date
from loan_logs ll, loan l, employee e, payroll_logs pl
where ll.loanID = l.id and l.empID = pl.empID and e.contract_type != 2 and e.emp_id = pl.empID
and pl.payroll_date = '".$payroll_date."' and ll.payment_date = '".$payroll_date."' ";
        return DB::select(DB::raw($query));
    }

    function v_loanReport($payroll_date){
        $query = "select ll.id as log_id,e.emp_id, concat(e.fname,' ',e.mname,' ',e.lname) as name, l.description, l.amount,
(select sum(paid) from loan_logs ill where ill.loanID = l.id and ill.payment_date <= '".$payroll_date."' group by ill.loanID) as paid, l.amount_last_paid ,
l.amount_last_paid,ll.payment_date,pl.payroll_date
from loan_logs ll, loan l, employee e, payroll_logs pl
where ll.loanID = l.id and l.empID = pl.empID and e.contract_type = 2 and e.emp_id = pl.empID
and pl.payroll_date = '".$payroll_date."' and ll.payment_date = '".$payroll_date."' ";
        return DB::select(DB::raw($query));
    }


    function staffPayrollInputJournalExportTime($payroll_date)	{
        $query = "SELECT pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type != 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type != 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type != 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type != 2 AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    function volunteerPayrollInputJournalExportTime($payroll_date)	{
        $query = "SELECT pl.*, p.name as positionName, e.fname, e.mname,e.lname,CONCAT(trim(e.fname),' ', trim(e.mname),' ', trim(e.lname)) AS empName,
	IF((SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM allowance_logs al WHERE al.empID = e.emp_id and e.contract_type = 2 AND al.payment_date = pl.payroll_date GROUP BY al.empID), 0) AS allowances,
	pl.salary, pl.less_takehome, pl.meals, pl.pension_employee AS pension, pl.taxdue,
	IF((SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE l.empID = e.emp_id and e.contract_type = 2 AND  ll.payment_date = pl.payroll_date GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM loan_logs ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = pl.payroll_date GROUP BY l.empID),0) AS loans,
	IF((SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM deduction_logs dl WHERE dl.empID = e.emp_id and e.contract_type = 2 AND dl.payment_date = pl.payroll_date GROUP BY dl.empID),0) AS deductions,
	b.name as bank, bb.name as branch, bb.swiftcode, pl.account_no
	FROM employee e, payroll_logs pl, position p,  bank_branch bb, bank b WHERE pl.empID = e.emp_id AND p.id = e.position AND bb.id= e.bank_branch AND b.id = e.bank and e.contract_type = 2 AND pl.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    function employeeProjectActivity($payrolldate,$empID){
        $query = "select atl.emp_id, project, activity from assignment_task_logs atl, assignment a where a.id = atl.assignment_employee_id and atl.emp_id = '".$empID."' and atl.payroll_date = '".$payrolldate."' group by atl.emp_id, project,activity";
        return DB::select(DB::raw($query));
    }

    function employeeProjectActivityTime($payrolldate,$empID, $project, $activity){
        $query = "select atl.*, a.project, a.activity from assignment_task_logs atl, assignment a
where a.id = atl.assignment_employee_id and atl.emp_id = '".$empID."' and a.project = '".$project."' and a.activity = '".$activity."' and atl.payroll_date = '".$payrolldate."' ";
        return DB::select(DB::raw($query));
    }

    function projectTime($code, $from, $to){
        $query = "select concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, e.emp_id, a.activity, ast.task_name, ast.start_date,ast.end_date
from assignment a, assignment_employee ae, assignment_task ast, employee e where a.id = ae.assignment_id
and ast.assignment_employee_id = ae.id and e.emp_id = ae.emp_id and a.project = '".$code."' and (date(ast.start_date) between '".$from."' and '".$to."') ";
        return DB::select(DB::raw($query));
    }

    function projectCost($code, $from, $to){
        $query = "select concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, ac.*
from assignment a, activity_cost ac, employee e where a.id = ac.assignment
and e.emp_id = ac.emp_id and a.project = '".$code."' and (date(ac.created_at) between '".$from."' and '".$to."') ";
        return DB::select(DB::raw($query));
    }

    function funderFunds($from, $to){
        $query = "select gl.*, concat(trim(e.fname),' ',trim(e.mname),' ',trim(e.lname)) as name, f.name as funder
from grant_logs gl, employee e, funder f where gl.created_by = e.emp_id and f.id = gl.funder and (date(gl.created_at) between '".$from."' and '".$to."') and mode = 'IN' ";
        return DB::select(DB::raw($query));
    }


}
