<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public function customemployee() {
        $query = "SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE e.state != 4 and e.login_user != 1 ";
        return DB::select(DB::raw($query));
    }

    public function customemployeeExit() {
        $query = "SELECT DISTINCT e.emp_id as empID, CONCAT(e.fname,' ', e.mname,' ', e.lname) as NAME FROM employee e WHERE e.state = 4";
        return DB::select(DB::raw($query));
    }

    public function payroll_month_list(){
        $query = 'SELECT DISTINCT payroll_date FROM payroll_logs ORDER BY payroll_date DESC';
        return DB::select(DB::raw($query));
    }

    public function payroll_year_list(){
        $query = "SELECT DISTINCT DATE_FORMAT(`payroll_date`,'%Y') as year  FROM payroll_logs ORDER BY DATE_FORMAT(`payroll_date`,'%Y') DESC";
        return DB::select(DB::raw($query));
    }

    public function selectBonus() {
        $query='SELECT * FROM bonus_tags';

        return DB::select(DB::raw($query));
    }

    public function setOvertimeNotification($for) {
        DB::transaction(function()
       {
        $query= "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('line',0,'You have a pending overtime to approve','".$for."')";
        DB::insert(DB::raw($query));
        });
        return true;
    }
    public function setPayrollNotification($for) {
        DB::transaction(function()
       {
        $query= "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',2,'You have a pending payroll to approve','".$for."')";
        DB::insert(DB::raw($query));
       });
        return true;
    }
    public function setImprestNotification($for) {
        DB::transaction(function()
       {
        $query= "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',1,'You have a pending imprest to approve','".$for."')";
        DB::insert(DB::raw($query));
      });
        return true;
    }
    public function setAdvSalaryNotification($for) {
        DB::transaction(function()
       {
        $query= "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('hr',3,'You have a pending advance salary to approve','".$for."')";
        DB::insert(DB::raw($query));
     
       });
        return true;
    }
    public function setIncentiveNotification($for) {
        DB::transaction(function()
       {
        $query=  "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',4,'You have a pending incentive to approve','".$for."')";
        DB::insert(DB::raw($query)); 
       });
        return true; 
    }



    public function clearNotification($type,$payroll_id) {
        DB::transaction(function()
       {
        $query= "DELETE FROM notifications WHERE notifications.type='".$type."' AND notifications.for='".$payroll_id."' ";
        DB::insert(DB::raw($query));  
       });
        return true;
    }

    public function seenPayrollNotification($type) {
        DB::transaction(function()
       {
        $query= "DELETE FROM notifications WHERE notifications.type='".$type."' ";
        DB::insert(DB::raw($query)); 
        });
        return true;
    }

    public function updatePayrollNotification() {
        DB::transaction(function()
       {
        $query= "INSERT INTO notifications (`role`, `type`, `message`, `for`) VALUES ('fin',2,'You have a pending pyroll to approve',1)";
        DB::insert(DB::raw($query));
        });
        return true;
    }






    public function selectAllowances() {
        $query='SELECT * FROM allowances';
        return DB::select(DB::raw($query));
    }

    public function getAllowanceAmount($salary, $allowanceID) {
        $query=" IF((a.mode = 1), a.amount, (".$salary.")*(a.percent)) AS amount  WHERE a.id = ".$allowanceID." ";
        
        $row = DB::table('allowances as a')
        ->select(DB::raw($query))
       
        ->first();

        return $row->amount;
    }

    public function getPensionAmount($pensionFund) {
        $query="SELECT pf.deduction_from, pf.amount_employee FROM pension_fund pf WHERE id = ".$pensionFund."";
        return DB::select(DB::raw($query));
    }

    public function getHealthInsuranceAmount() {
        $query="rate_employee  WHERE id = 9";
        $row = DB::table('deduction')
        ->select(DB::raw($query))
       
        ->first();
        return $row->rate_employee;
    }

    public function getPayeAmount($taxableAmount) {
        $query="SELECT IF(count(id)>0, minimum, 0) AS minimum, IF(count(id)>0, rate, 0) AS rate, IF(count(id)>0, excess_added, 0) AS excess_added FROM paye WHERE minimum <= ".$taxableAmount." AND Maximum > '".$taxableAmount."' group by minimum, rate, excess_added ";
        return DB::select(DB::raw($query));
    }





    public function payrollMonthList() {
        $query='SELECT (@s:=@s+1) as SNo, pm.* FROM payroll_months pm, (SELECT @s:=0) as s ORDER BY pm.id DESC';

        return DB::select(DB::raw($query));
    }

    public function getNotifications(){
        $query='SELECT * FROM notifications  ORDER BY id DESC';
        return DB::select(DB::raw($query));
    }

    public function payrollMonthListpending() {
        $query='SELECT (@s:=@s+1) as SNo, pm.* FROM payroll_months pm, (SELECT @s:=0) as s WHERE pm.state=1 OR pm.state=2  ORDER BY pm.id DESC';

        return DB::select(DB::raw($query));
    }

    public function employee_bonuses() {
        $query = "SELECT @s:=@s+1 SNo, b.*, tags.name as tag,  CONCAT(e.fname,' ', e.mname,' ', e.lname) as name, d.name as department, p.name as position FROM employee e, department d, position p, bonus b, bonus_tags tags, (SELECT @s:=0) as s WHERE e.department = d.id AND e.position = p.id AND e.emp_id = b.empID AND tags.id = b.name and e.state != 4 and e.login_user != 1";
        return DB::select(DB::raw($query));
    }

    public function waitingbonusesRecom() {
        $query = "SELECT * FROM bonus WHERE bonus.state=0";
        return DB::select(DB::raw($query));
    }

    public function waitingbonusesAppr() {
        $query = "SELECT * FROM bonus WHERE bonus.state=2";
        return DB::select(DB::raw($query));
    }

    public function waitingpayroll_fin() {
        $query = "SELECT * FROM payroll_months WHERE state =2";
        return DB::select(DB::raw($query));
    }
    public function waitingpayroll_appr() {
        $query = "SELECT * FROM payroll_months WHERE state =1";
        return DB::select(DB::raw($query));
    }

    //START RUN PAYROLL FOR SCANIA
    public function pendingPayrollCheck(){
       
        $row = DB::table('payroll_months')
        ->where('state',1)
        ->orWhere('state',2)
        ->select(DB::raw('COUNT(id) as counts '))
        ->first();
    
        return $row->counts;
    }


    public function pendingPayroll(){
        $row = DB::table('payroll_months')
        ->where('state',1)
        ->orWhere('state',2)
        ->select(DB::raw('*'))
        ->limit(1)
        ->first();
   
        return $row;
        
    }


    public function recommendPayroll($author,$date){
        $query = ["state" => 1,"recom_author" =>$author,"recom_date" =>$date];
           
        DB::table('payroll_months')
        ->where('state',2)
        ->update($query);
        return true;
    }



     public function pendingPayroll_month(){
        $query = "payroll_date as payroll_month  WHERE state = 1 OR state = 2  LIMIT 1";
        $record = DB::table('payroll_months')
        ->select(DB::raw($query));
        
        $records = $record->count();
        if ($records==1) {
            $row = $record->row();
            return $row->payroll_month;
        } else return 0;
    }

    public function payrollcheck($date){
        $query = "id  WHERE payroll_date like  '%".$date."%' ";
        $row = DB::table('payroll_logs')
        ->select(DB::raw($query));
        return $row->count();
    }

    public function initPayroll( $dateToday, $payroll_date, $payroll_month, $empID){

        DB::transaction(function()
       {

        //Insert into Pending Payroll Table
        $query = "INSERT INTO payroll_months (payroll_date, state, init_author, appr_author, init_date, appr_date,sdl, wcf) VALUES
('".$payroll_date."', 2, '".$empID."', '', '".$dateToday."', '".$payroll_date."', (SELECT rate_employer from deduction where id=4 ), (SELECT rate_employer from deduction where id=2 ) )";
        DB::insert(DB::row($query));
        //INSERT ALLOWANCES
        $query = "INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)

	    SELECT ea.empID AS empID, a.name AS description,

	    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

	    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS amount,

	     '".$payroll_date."' AS payment_date

	    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND a.state = 1 AND e.state != 4 and e.login_user != 1";
        DB::insert(DB::row($query));
        //INSERT BONUS
        $query = " INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)

	    SELECT b.empID AS empID, bt.name AS description,

	    'Fixed Amount' AS policy,

	    SUM(b.amount) AS amount,

	    '".$payroll_date."' AS payment_date

	    FROM employee e,  bonus b, bonus_tags bt WHERE e.emp_id =  b.empID and bt.id = b.name AND b.state = 1 and e.state != 4 and e.login_user != 1 GROUP BY b.empID, bt.name";
        DB::insert(DB::row($query));
        //INSERT OVERTIME
        $query = " INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)
	    SELECT o.empID AS empID, 'Overtime' AS description,

	    'Fixed Amount' AS policy,

	     SUM(o.amount) AS amount,

	    '".$payroll_date."' AS payment_date

	    FROM  employee e, overtimes o WHERE  o.empID =  e.emp_id and e.state != 4 and e.login_user != 1 GROUP BY o.empID";
        DB::insert(DB::row($query));

        //UPDATE SALARY ADVANCE.
        /*$query = "UPDATE loan SET paid = IF(((paid+deduction_amount) > amount), amount, (paid+deduction_amount)),
        amount_last_paid = IF(((paid+deduction_amount) > amount), amount-paid, ((paid+deduction_amount))),
        last_paid_date = '".$payroll_date."' WHERE  state = 1 AND NOT type = 3";*/

        //UPDATE LOAN BOARD
        /*$query = " UPDATE loan SET paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount, (paid+ (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
        amount_last_paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) ) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID) )),
        last_paid_date = '".$payroll_date."' WHERE  state = 1 AND type = 3";*/

        //

        //INSERT SALARY ADVANCE, FORCED DEDUCTIONS and other LOANS INTO LOAN LOGS
        $query = "INSERT into temp_loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID, IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy, IF(((paid+deduction_amount) > amount), amount, deduction_amount) as  paid, (amount - IF(((paid+deduction_amount) >= amount), amount-paid,  ((paid+deduction_amount)))) as remained,  '".$payroll_date."' as payment_date FROM loan  WHERE  state = 1 AND NOT type = 3";
        DB::insert(DB::row($query));
        //INSERT HESLB INTO LOGS
        $query = "INSERT into temp_loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID, IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy, IF(((paid+deduction_amount) > amount), amount, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1))) as  paid, (amount - IF(((paid+deduction_amount) >= amount), amount-paid,  ((paid+((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1)))))) as remained, '".$payroll_date."' as payment_date FROM loan  WHERE  state = 1 AND type = 3";
        DB::insert(DB::row($query));
        //INSERT DEDUCTION LOGS
        $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT ed.empID as empID, name as description,

	    IF( (d.mode = 1), 'Fixed Amount', CONCAT(100*d.percent,'% ( Basic Salary )') ) as policy,

	    IF( (d.mode = 1), d.amount, (d.percent*e.salary) ) as paid,

	    '".$payroll_date."' as payment_date

	    FROM emp_deductions ed,  deductions d, employee e WHERE e.emp_id = ed.empID and e.state != 4 and e.login_user != 1 AND ed.deduction = d.id AND  d.state = 1";
        DB::insert(DB::row($query));
        //DEDUCTION LOGS FROM IMPREST REFUND
        $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT empID, description, policy, paid, '".$payroll_date."'

	    FROM once_off_deduction";
        DB::insert(DB::row($query));



        // DEDUCTION LOGS FOR EXPATRIATES(HOUSING ALLOWANCE REFUND)
        // Housing Allowance has id = 6
        $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    	SELECT ea.empID AS empID, 'Housing Allowance Compasation' AS description,

	    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

	    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS paid,

	     '".$payroll_date."' AS payment_date

	    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND e.is_expatriate = 1 and e.state != 4 and e.login_user != 1 AND a.id = 6";
        DB::insert(DB::row($query));
        //STOP LOAN
        // $query = " UPDATE loan SET state = 0 WHERE amount = paid and state = 1";

        //INSERT PAYROLL LOG TABLE
        $query = "INSERT INTO temp_payroll_logs(

	        empID,
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
	        payroll_date

	        )

	    SELECT

	    e.emp_id AS empID,

	    e.salary AS salary,

	    /*Allowances and Bonuses*/ (

	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	     )

         /*End Allowances and Bonuses*/ AS  allowances,

        IF(e.retired !=2, IF((pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  ) AS pension_employee,




        IF(e.retired !=2,IF((pf.deduction_from = 1), (e.salary*pf.amount_employer), (pf.amount_employer*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  ) AS pension_employer,



	    ((SELECT rate_employee from deduction where id=9 )*(e.salary)) as medical_employee,

	    ((SELECT rate_employer from deduction where id=9 )*(e.salary)) as medical_employer,


	    (
	    ( SELECT excess_added FROM paye WHERE maximum >
	    (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/

         IF( e.retired !=2,IF((pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  )


	   /*  IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +
        --     IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        --     IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )


         End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) )

	    +

	    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/))) )


	    ) AS taxdue,



	    IF(((e.salary +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

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

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  )) as sdl,

	    ((SELECT rate_employer from deduction where id=2 )*(e.salary +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  )) as wcf,

	     '".$payroll_date."' as payroll_date
	     FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state != 4 and e.login_user != 1";

         DB::insert(DB::row($query));

        });
        return true;


    }



    //START  RUN PAYROLL FOR SCANIA
    public function run_payroll($payroll_date, $payroll_month, $empID, $todate){

        DB::transaction(function()
       {

        //INSERT ALLOWANCES
        $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

	    SELECT ea.empID AS empID, a.name AS description,

	    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

	    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS amount,

	     '".$payroll_date."' AS payment_date

	    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND a.state = 1 AND e.state != 4 and e.login_user != 1";
        DB::insert(DB::row($query));
        //INSERT BONUS LOGS
        $query = " INSERT INTO bonus_logs(empID, amount, name, init_author, appr_author, payment_date) SELECT b.empID, b.amount, b.name, b.init_author, b.appr_author, '".$payroll_date."'  FROM bonus b WHERE b.state = 1";
        DB::insert(DB::row($query));
        //INSERT BONUS
        $query = " INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)

	    SELECT b.empID AS empID, bt.name AS description,

	    'Fixed Amount' AS policy,

	    SUM(b.amount) AS amount,

	    '".$payroll_date."' AS payment_date

	    FROM employee e,  bonus b, bonus_tags bt WHERE e.emp_id =  b.empID and bt.id = b.name  AND b.state = 1 and e.state != 4 and e.login_user != 1 GROUP BY b.empID, bt.name";
        DB::insert(DB::row($query));
        //INSERT OVERTIME
        $query = "INSERT INTO allowance_logs(empID, description, policy, amount, payment_date)
	    SELECT o.empID AS empID, 'Overtime' AS description,

	    'Fixed Amount' AS policy,

	     SUM(o.amount) AS amount,

	    '".$payroll_date."' AS payment_date

	    FROM  employee e, overtimes o WHERE  o.empID =  e.emp_id and e.state != 4 and e.login_user != 1 GROUP BY o.empID";
        DB::insert(DB::row($query));
        //INSERT OVERTIME LOGS
        $query = " INSERT INTO overtime_logs(empID,time_start,time_end,amount,linemanager,hr,application_time,confirmation_time,approval_time,payment_date)  SELECT empID,time_start,time_end,amount,linemanager,hr,application_time,confirmation_time,approval_time, '".$payroll_date."'  FROM overtimes";
        DB::insert(DB::row($query));

        //UPDATE SALARY ADVANCE.
        $query = " UPDATE loan SET paid = IF(((paid+deduction_amount) > amount), amount, (paid+deduction_amount)),
		amount_last_paid = IF(((paid+deduction_amount) > amount), amount-paid, (deduction_amount)),
		last_paid_date = '".$payroll_date."' WHERE  state = 1 AND NOT type = 3";
        DB::insert(DB::row($query));
        //UPDATE LOAN BOARD
        $query = " UPDATE loan SET paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1) ) > amount), amount, (paid+ (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1) )),
		amount_last_paid = IF(((paid + (SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1) ) > amount), amount-paid, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1) )),
		last_paid_date = '".$payroll_date."' WHERE  state = 1 AND type = 3";
        DB::insert(DB::row($query));
        //INSERT LOAN LOGS
        // $query = "INSERT into loan_logs(loanID, paid, remained, payment_date) SELECT id, amount_last_paid, amount-paid, last_paid_date FROM loan WHERE state = 1";


        //INSERT SALARY ADVANCE, FORCED DEDUCTIONS and other LOANS INTO LOAN LOGS
        $query = "INSERT into loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID,
IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy,
IF(((paid) >= amount), paid, deduction_amount) as  paid,
(amount - IF(((loan.paid) >= amount), amount,  ((paid)))) as remained,
'".$payroll_date."' as payment_date FROM loan  WHERE  state = 1 AND NOT type = 3";
DB::insert(DB::row($query));
        //INSERT HESLB INTO LOGS
        $query = "INSERT into loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID, IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy, IF(((paid+deduction_amount) > amount), amount, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1))) as  paid, (amount - IF(((paid+deduction_amount) >= amount), amount-paid,  ((paid+((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1)))))) as remained, '".$payroll_date."' as payment_date FROM loan  WHERE  state = 1 AND type = 3";
        DB::insert(DB::row($query));
        //INSERT DEDUCTION LOGS
        $query = "INSERT INTO deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT ed.empID as empID, name as description,

	    IF( (d.mode = 1), 'Fixed Amount', CONCAT(100*d.percent,'% ( Basic Salary )') ) as policy,

	    IF( (d.mode = 1), d.amount, (d.percent*e.salary) ) as paid,

	    '".$payroll_date."' as payment_date

	    FROM emp_deductions ed,  deductions d, employee e WHERE e.emp_id = ed.empID AND ed.deduction = d.id AND  d.state = 1 and e.state != 4 and e.login_user != 1";
        DB::insert(DB::row($query));
        // DEDUCTION LOGS FROM IMPREST REFUND
        $query = "INSERT INTO deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT empID, description, policy, paid, '".$payroll_date."'

	    FROM once_off_deduction";
        DB::insert(DB::row($query));

        // DEDUCTION LOGS FOR EXPATRIATES(HOUSING ALLOWANCE REFUND)
        // Housing Allowance has id = 6
        $query = "INSERT INTO deduction_logs(empID, description, policy, paid, payment_date)

	    	SELECT ea.empID AS empID, 'Housing Allowance Compasation' AS description,

	    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

	    IF( (a.mode = 1), a.amount, (a.percent*e.salary) ) AS paid,

	     '".$payroll_date."' AS payment_date

	    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND e.is_expatriate = 1 and e.state != 4 and e.login_user != 1 AND a.id = 6";
        DB::insert(DB::row($query));
        //STOP LOAN
        $query = " UPDATE loan SET state = 0 WHERE amount = paid and state = 1";
        DB::insert(DB::row($query));
        //INSERT PAYROLL LOG TABLE
        $query = "INSERT INTO payroll_logs(

	        empID,
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
	        payroll_date

	        )

	    SELECT

	    e.emp_id AS empID,

	    e.salary AS salary,

	    /*Allowances and Bonuses*/ (

	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	     ) /*End Allowances and Bonuses*/ AS  allowances,




        IF(e.retired !=2, IF((pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  ) AS pension_employee,



        IF(e.retired !=2,IF((pf.deduction_from = 1), (e.salary*pf.amount_employer), (pf.amount_employer*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  ) AS pension_employer,






	    ((SELECT rate_employee from deduction where id=9 )*(e.salary)) as medical_employee,

	    ((SELECT rate_employer from deduction where id=9 )*(e.salary)) as medical_employer,


	    (
	    ( SELECT excess_added FROM paye WHERE maximum >
	    (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/

       /* IF( e.retired !=2,IF((pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  )
        */


	    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	       /* End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/


	    IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )


         /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) )

	    +

	    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
	    ( e.salary -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (e.salary*pf.amount_employee), (pf.amount_employee*(e.salary+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/))) )


	    ) AS taxdue,



	    IF(((e.salary +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

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

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  )) as sdl,

	    ((SELECT rate_employer from deduction where id=2 )*(e.salary +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(a.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(e.salary*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  )) as wcf,

	     '".$payroll_date."' as payroll_date
	     FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state != 4 and e.login_user != 1";
         DB::insert(DB::row($query));
        //Confirm The Pending Payoll
        $query = " UPDATE payroll_months SET state = 0, appr_author = '".$empID."', appr_date = '".$todate."'  WHERE state = 1 ";
        DB::insert(DB::row($query));
        //CLEAR TEMPORARY PAYROLL LOGS
        DB::table('temp_allowance_logs')->truncate();
        DB::table('temp_deduction_logs')->truncate();
        DB::table('temp_loan_logs')->truncate();
        DB::table('temp_payroll_logs')->truncate();
        DB::table('bonus')->truncate();
        DB::table('overtimes')->truncate();
        DB::table('once_off_deduction')->truncate();
        });
        return true;


    }

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

    public function cancel_payroll(){
        DB::transaction(function()
       {
        DB::table('temp_allowance_logs')->truncate();
        DB::table('temp_deduction_logs')->truncate();
        DB::table('temp_loan_logs')->truncate();
        DB::table('temp_payroll_logs')->truncate();
        DB::table('temp_arrears')->truncate();
      
        DB::table('payroll_months')
        ->where('state',1)
        ->orWhere('state',2)
        ->delete();
        //$query = " DELETE FROM payroll_months WHERE state = 1 || state = 2";
        });
        return true;

    }

    public function getPayrollMonth1(){
        $query = "SELECT distinct payroll_date FROM temp_payroll_logs";
        return DB::select(DB::raw($query));
    }

    public function deleteArrears($date){
        DB::table('arrears')->where('payroll_date',$date)->delete();
        DB::table('employee_activity_grant_logs')->where('payroll_date',$date)->delete();
        DB::table('arrears_logs')->where('payroll_date',$date)->delete();
        return true;
    }

//END RUN PAYROLL FOR SCANIA


    //PAYROLL REVIEW




    public function sdl_contribution(){
        $query = "rate_employer  as sdl  WHERE  id = 4";
       $row =  DB::table('deduction')
        ->select(DB::raw($query))
        ->first();
        return $row->sdl;
    }

    public function wcf_contribution(){
        $query = "rate_employer as wcf  WHERE id = 2";
        $row =  DB::table('deduction')
        ->select(DB::raw($query))
        ->first();
        return $row->wcf;
    }

    public function recent_payroll_month($currentDate){

        $query = "IF((SELECT COUNT(id))>0, (payroll_date WHERE state = 0 ORDER BY id DESC LIMIT 1), ".$currentDate.") as payroll_date ";
        $row =  DB::table('payroll_months')
        ->select(DB::raw($query))
        ->first();
        return $row->payroll_date ;
    }

    public function recent_payroll_month1($currentDate){
       $count = DB::table('payroll_months')
       ->select('id')
       ->count();
        $query = "IF((".$count.")>0, (SELECT payroll_date WHERE state != 0 ORDER BY id DESC LIMIT 1), ".$currentDate.") as payroll_date ";
        $row =  DB::table('payroll_months')
        //->where('state','!=',0)
        ->select(DB::raw($query))
        ->first();
        return $row->payroll_date ;
    }


    public function getPayroll($payrollMonth){
        $query = "SELECT CONCAT(ie.fname,' ', ie.mname,' ', ie.lname) as initName, IF( (pm.state=0), (SELECT CONCAT(ae.fname,' ', ae.mname,' ', ae.lname) FROM employee ae WHERE ae.emp_id = pm.appr_author and ae.state != 4 and ae.login_user != 1), 1) as apprName, pm.* FROM payroll_months pm, employee ie WHERE ie.emp_id = pm.init_author and ie.state != 4 and ie.login_user != 1 AND pm.payroll_date = '".$payrollMonth."' ";
        return DB::select(DB::raw($query));
    }

    public function payrollTotals($table, $payrollMonth){
        $query = "SELECT SUM(less_takehome) as takehome_less, SUM(salary) as salary, SUM(pension_employee) as pension_employee, SUM(pension_employer) as pension_employer,  SUM(medical_employer) as medical_employer, SUM(medical_employee) as medical_employee, SUM(allowances) as allowances, SUM(taxdue) as taxdue, SUM(meals) as meals, SUM(sdl) as sdl, SUM(wcf) as wcf FROM ".$table." WHERE payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }

    public function staffPayrollTotals($table, $payrollMonth){
        $query = "SELECT SUM(pl.less_takehome) as takehome_less, SUM(pl.salary) as salary, SUM(pl.pension_employee) as pension_employee, SUM(pl.pension_employer) as pension_employer,  SUM(pl.medical_employer) as medical_employer, SUM(pl.medical_employee) as medical_employee, SUM(pl.allowances) as allowances, SUM(pl.taxdue) as taxdue, SUM(pl.meals) as meals, SUM(pl.sdl) as sdl, SUM(pl.wcf) as wcf 
        FROM ".$table." as pl, employee e where e.emp_id = pl.empID and e.contract_type != 2 and payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }

    public function volunteerPayrollTotals($table, $payrollMonth){
        $query = "SELECT SUM(pl.less_takehome) as takehome_less, SUM(pl.salary) as salary, SUM(pl.pension_employee) as pension_employee, SUM(pl.pension_employer) as pension_employer,  SUM(pl.medical_employer) as medical_employer, SUM(pl.medical_employee) as medical_employee, SUM(pl.allowances) as allowances, SUM(pl.taxdue) as taxdue, SUM(pl.meals) as meals, SUM(pl.sdl) as sdl, SUM(pl.wcf) as wcf 
        FROM ".$table." as pl, employee e where e.emp_id = pl.empID and e.contract_type = 2 and payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }

    public function temp_payrollTotals($table, $payrollMonth){
        $query = "SELECT SUM(salary) as salary, SUM(pension_employee) as pension_employee, SUM(pension_employer) as pension_employer,  SUM(medical_employer) as medical_employer, SUM(medical_employee) as medical_employee, SUM(allowances) as allowances, SUM(taxdue) as taxdue, SUM(meals) as meals, SUM(sdl) as sdl, SUM(wcf) as wcf FROM ".$table." WHERE payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }


    public function total_allowances($table, $payrollMonth){

        $query = "SUM(amount) as amount";
        $row =  DB::table($table)
        ->where("payment_date",$payrollMonth)
        ->select(DB::raw($query))
        ->first();
        
        return $row->amount;
    }

    public function total_loans($table, $payrollMonth){

        $query = "SELECT SUM(paid) as paid, SUM(remained) as remained FROM  ".$table." WHERE payment_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }

    public function total_loans_separate($table, $payrollMonth){

        $query = "SELECT sum(tlg.paid) as paid, sum(tlg.remained) as remained, l.description
FROM temp_loan_logs tlg, loan l WHERE l.id = tlg.loanID and payment_date = '".$payrollMonth."' group by l.description";
        return DB::select(DB::raw($query));
    }

    public function total_heslb($table, $payrollMonth){

        $query = "SUM(ll.paid) as paid FROM  ".$table." ll, loan lo WHERE ll.payment_date = '".$payrollMonth."' AND ll.loanID = lo.id AND lo.type = 3";
        $table2 = $table."as ll";
        $row =  DB::table($table2)
        ->select(DB::raw($query))
        ->first();
        return $row->paid;
    }


    public function total_deductions($table, $payrollMonth){

        $query = "SUM(paid) as paid";
       
        $row =  DB::table($table)
        ->where('payment_date',$payrollMonth)
        ->select(DB::raw($query))
        ->first();
        return $row->paid;
    }

    public function total_bonuses($payrollMonth){

        $query = "SUM(amount) as amount";
        $row =  DB::table('bonus_logs')
        ->where('payment_date',$payrollMonth)
        ->select(DB::raw($query))
        ->first();
        return $row->amount;
    }

    public function total_overtimes($payrollMonth){

        $query = "SUM(amount) as amount";
        $row =  DB::table('overtime_logs')
        ->where('payment_date',$payrollMonth)
        ->select(DB::raw($query))
        ->first();
        return $row->amount;
    }

    public function payroll_month_info($payrollMonth){

        $query = "SELECT * FROM payroll_months WHERE payroll_date = '".$payrollMonth."'";
        return DB::select(DB::raw($query));
    }


    public function payroll_review($empID, $table, $payrollMonth){

        $query = "SELECT CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, b.name as bank, bb.name as branch, cbr.name as company_branch, bb.swiftcode, pf.name as pensionFundName, pf.*,  tpl.* FROM employee e, ".$table." tpl,  bank_branch bb, bank b, pension_fund pf, branch cbr WHERE tpl.empID = e.emp_id and e.state != 4 AND bb.id= tpl.bank_branch AND b.id = tpl.bank AND tpl.pension_fund = pf.id  AND cbr.id = tpl.branch AND tpl.empID = '".$empID."' AND tpl.payroll_date = '".$payrollMonth."'";

        return DB::select(DB::raw($query));
    }

    public function allowances_review($empID, $table, $payrollMonth){

        $query = "SELECT @s:=@s+1 AS SNo,  tal.* FROM ".$table." tal,(SELECT @s:=0) AS s WHERE tal.empID = '".$empID."' AND tal.payment_date = '".$payrollMonth."' ";

        return DB::select(DB::raw($query));
    }


    public function deductions_review($empID, $table, $payrollMonth){

        $query = "SELECT @s:=@s+1 AS SNo,  tdl.* FROM ".$table." tdl,(SELECT @s:=0) AS s WHERE tdl.empID = '".$empID."' AND tdl.payment_date = '".$payrollMonth."'";

        return DB::select(DB::raw($query));
    }

    public function loans_review($empID, $table, $payrollMonth){

        $query = "SELECT @s:=@s+1 AS SNo, tll.paid as pre_paid,  tll.*, l.* FROM ".$table." tll, loan l,(SELECT @s:=0) AS s WHERE tll.loanID = l.id AND l.empID = '".$empID."' AND tll.payment_date = '".$payrollMonth."'";

        return DB::select(DB::raw($query));
    }

    public function total_allowances_review($empID, $table, $payrollMonth){

        $query = "SUM(tal.amount) as total_al  WHERE tal.empID = '".$empID."' AND tal.payment_date = '".$payrollMonth."'";
        $table2 = $table."as tal";
        $row =  DB::table($table2)
        ->select(DB::raw($query))
        ->first();
        return $row->total_al;
    }


    public function total_deductions_review($empID, $table, $payrollMonth){

        $query = "SUM(tdl.paid) as total_de WHERE tdl.empID = '".$empID."' AND tdl.payment_date = '".$payrollMonth."'";
        $table2 = $table."as tdl";
        $row =  DB::table($table2)
        ->select(DB::raw($query))
        ->first();
        return $row->total_de;
    }

    public function total_loans_review($empID, $table, $payrollMonth){

        $query = "SELECT SUM(amount_last_paid) as total_last_paid, SUM(pre_paid) as total_paid_currently, SUM(amount) as total_loans, SUM(remained) as total_remained FROM (SELECT tll.paid as pre_paid,  tll.remained, l.amount, l.amount_last_paid  FROM ".$table." tll, loan l WHERE tll.loanID = l.id AND l.empID = '".$empID."'  AND tll.payment_date = '".$payrollMonth."') AS parent_query ";

        return DB::select(DB::raw($query));
    }

    public function employeePayrollList($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName,
		IF((SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances, p.name as position, d.name as department,
		pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
		IF((SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
		IF((SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions
		FROM employee e, ".$table_payroll_logs."  pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND e.state != 4 and e.login_user != 1 and pl.position = p.id and pl.department = d.id AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    public function employeeTempPayrollList($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs, $table_arrears){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName,
        IF((SELECT SUM(ar.amount) FROM ".$table_arrears." ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '".$date."')>0, (SELECT SUM(ar.amount) FROM ".$table_arrears." ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '".$date."'), 0) AS arrear_amount,
		IF((SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances, p.name as position, d.name as department,
		pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
		IF((SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
		IF((SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions
		FROM employee e, ".$table_payroll_logs."  pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND e.state != 4 and e.login_user != 1 and pl.position = p.id and pl.department = d.id AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }

    public function employeeTempPayrollList1($date, $table_allowance_logs, $table_deduction_logs, $table_loan_logs, $table_payroll_logs, $table_arrears){

        $query = "SELECT @s:=@s+1 AS SNo, pl.empID,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName,
        IF((SELECT SUM(ar.amount) FROM ".$table_arrears." ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '".$date."')>0, (SELECT SUM(ar.amount) FROM ".$table_arrears." ar WHERE ar.empID = e.emp_id AND ar.payroll_date = '".$date."'), 0) AS arrear_amount,
		IF((SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID)>0, (SELECT SUM(al.amount) FROM ".$table_allowance_logs." al WHERE al.empID = e.emp_id AND al.payment_date = '".$date."' GROUP BY al.empID), 0) AS allowances, p.name as position, d.name as department,
		pl.salary, pl.meals, pl.pension_employee AS pension, pl.taxdue,
		IF((SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE l.empID = e.emp_id AND  ll.payment_date = '".$date."' GROUP BY l.empID)>0,(SELECT SUM(ll.paid) FROM ".$table_loan_logs." ll, loan l WHERE e.emp_id = l.empID AND ll.loanID = l.id AND ll.payment_date = '".$date."' GROUP BY l.empID),0) AS loans,
		IF((SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID)>0,(SELECT SUM(dl.paid) FROM ".$table_deduction_logs." dl WHERE dl.empID = e.emp_id AND dl.payment_date = '".$date."' GROUP BY dl.empID),0) AS deductions
		FROM employee e, ".$table_payroll_logs."  pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND e.state != 4 and e.login_user != 1 and pl.position = p.id and pl.department = d.id AND pl.payroll_date = '".$date."'";

        return DB::select(DB::raw($query));
    }


    /*
        public function employeePayrollList($table, $payrollMonth){

            $query = "SELECT @s:=@s+1 AS SNo, pl.empID, pl.salary, CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, p.name as position, d.name as department  FROM employee e, ".$table." pl, department d, position p, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id AND  pl.position = p.id and pl.department = d.id AND pl.payroll_date = '".$payrollMonth."'";

            return DB::select(DB::raw($query));
        }*/


    public function getPayrollMonth(){

        $query = " payroll_date  ORDER BY id DESC LIMIT 1";

       
        $row =  DB::table('payroll_logs')
        ->select(DB::raw($query))
        ->first();
        return $row->payroll_date;
    }

    public function updatePayrollMail($payrollDate){

        $query = " UPDATE payroll_months SET email_status = 1 WHERE payroll_date = '".$payrollDate."'";
        DB::insert(DB::raw($query));
        return true;
    }


    public function senderInfo() {
        $query = "SELECT host, username, password, email, name, secure, port FROM company_emails WHERE use_as = 1 AND state = 1 LIMIT 1";
        return DB::select(DB::raw($query));
    }


// Real public function
    /*public function send_payslips($payroll_date){

        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND payroll_date = (SELECT payroll_date FROM payroll_logs ORDER BY id DESC LIMIT 1) AND payroll_date = '".$payroll_date."' ";

        return DB::select(DB::raw($query));
    }*/


// Below is the Test public function

    public function send_payslips($payroll_date){

        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND employee.state != 4 and payroll_date = '".$payroll_date."'";

        return DB::select(DB::raw($query));
    }


    public function update_payroll_month($updates, $payroll_date, $arrearID, $dataLogs, $dataUpdates)
    {
        DB::transaction(function()
       { 
        DB::table('payroll_months')
        ->where('payroll_date', $payroll_date)
        ->update($updates);

        DB::table('arrears')
        ->where('id', $arrearID)
        ->update($dataUpdates);


       
        DB::table('arrears_logs')->insert($dataLogs);

        DB::table('arrears')->
        where('paid','>=','amount')
        ->update('status',0);

    
        DB::table('arrears_pendings')->truncate();
        });
        return true;
    }

    public function update_payroll_month_only($updates, $payroll_date)
    {
        DB::transaction(function() use($payroll_date,$updates)
       {

        DB::table('payroll_months')->
        where('payroll_date',$payroll_date)
        ->update($updates);

        });
        return true;
    }

    public function lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth){
        DB::transaction(function()
       {

        DB::table('payroll_months')->where('payroll_date',$payrollMonth)
        ->update($update_payroll_months);  

        DB::table('arrears')->insert($update_arrears);
     
        DB::table('payroll_logs')->where('payroll_date',$payrollMonth)
        ->where('empID', $empID)
        ->update($update_payroll_logs);

        });
        return true;

    }



    public function temp_lessPayments($update_arrears, $update_payroll_months, $update_payroll_logs, $empID, $payrollMonth){
        DB::transaction(function()
       {

        DB::table('payroll_months')->where('payroll_date',$payrollMonth)
        ->update($update_payroll_months);  

        DB::table('temp_arrears')->insert($update_arrears);

        DB::table('arrears')->insert($update_arrears);
     
        DB::table('payroll_logs')->where('payroll_date',$payrollMonth)
        ->where('empID', $empID)
        ->update($update_payroll_logs);

        });
        return true;

    }

    public function all_arrears_individual(){

        $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state != 4 AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        return DB::select(DB::raw($query));
    }

    public function all_arrears_payroll_month(){

        $query = "SELECT ar.payroll_date,  SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE payroll_date = ar.payroll_date ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar WHERE ar.status = 1 GROUP BY ar.payroll_date ORDER BY ar.payroll_date DESC";
        return DB::select(DB::raw($query));
    }


    public function arrears($start, $finish){
        if($finish>$start){
            $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state != 4 AND ar.payroll_date BETWEEN '".$start."' AND '".$finish."' AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        } else {
            $query = "SELECT (@s:=@s+1) as SNo, ar.empID, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(ar.amount) as amount, SUM(ar.paid) as paid, SUM(ar.amount_last_paid) AS amount_last_paid, (SELECT last_paid_date FROM arrears WHERE empID = ar.empID ORDER BY id DESC LIMIT 1) AS last_paid_date FROM arrears ar, employee e, (SELECT @s:=0) AS s WHERE ar.empID = e.emp_id and e.state != 4 AND ar.payroll_date BETWEEN '".$finish."' AND '".$start."' AND ar.status = 1 GROUP BY ar.empID ORDER BY SNo";
        }
        return DB::select(DB::raw($query));
    }



    public function OLD_pending_arrears_payment(){
        $query = "SELECT (@s:=@s+1) as SNo, ar.empID, ar.payroll_date, ar.amount as arrear_amount, ar.paid as arrear_paid, CONCAT(fname,' ', mname,' ', lname) AS empName, arp.* FROM employee e, arrears ar, arrears_pendings arp, (SELECT @s:=0) as s WHERE ar.empID = e.emp_id and e.state != 4 AND ar.id = arp.arrear_id";
        return DB::select(DB::raw($query));
    }

    public function pending_arrears_payment(){
        $query = "SELECT (@s:=@s+1) as SNo, arp.id, ar.empID, ar.payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName, SUM(arp.amount) as amount, arp.status, ar.amount as arrear_amount, ar.paid as arrear_paid, ar.payroll_date, ar.last_paid_date, ar.amount_last_paid as amount_last_paid FROM employee e, arrears ar, arrears_pendings arp, (SELECT @s:=0) as s WHERE ar.empID = e.emp_id and e.state != 4 AND ar.id = arp.arrear_id GROUP BY ar.payroll_date, ar.empID, ar.last_paid_date, ar.amount, ar.amount_last_paid, ar.paid,arp.id, arp.status";
        return DB::select(DB::raw($query));
    }


    public function employee_arrears($empID){

        $query = "SELECT (@s:=@s+1) AS SNo,  ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '".$empID."'";
        return DB::select(DB::raw($query));
    }

    public function employee_arrears1($empID,$payroll_date){

        $query = "SELECT (@s:=@s+1) AS SNo,  ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '".$empID."' AND ar.payroll_date = '".$payroll_date."'";
        return DB::select(DB::raw($query));
    }

    public function monthly_arrears($payroll_month){

        $query = "SELECT (@s:=@s+1) AS SNo, ar.*,  CONCAT(e.fname,' ', e.mname,' ', e.lname) AS empName, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM employee e, arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.empID = e.emp_id and e.state != 4 and e.login_user != 1 AND pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID and ar.status = 1 AND ar.payroll_date = '".$payroll_month."'";
        return DB::select(DB::raw($query));
    }

    public function approved_arrears(){
        $query = "SELECT  ar.paid, arp.arrear_id, arp.amount, ar.payroll_date, arp.init_by, arp.confirmed_by, arp.date_confirmed FROM arrears_pendings arp, arrears ar WHERE arp.arrear_id = ar.id AND arp.status = 1";
        return DB::select(DB::raw($query));
    }

    public function checkPendingArrearPayment($arrearID){

        $query = "COUNT(id) as counts  WHERE arrear_id =".$arrearID."";
        $row = DB::table('arrears_pendings')
        ->select(DB::raw($query))->count();

        $result = $row;
        if ($result>0) {
            return true;
        } else return false;
    }

    public function updatePendingArrear($arrearID, $updates){
        DB::table('arrears_pendings')->where('arrear_id',$arrearID)
        ->update($updates);

       
        return true;
    }

    public function confirmPendingArrear($arrearID, $updates){
        DB::table('arrears_pendings')->where('arrear_id',$arrearID)
        ->update($updates);
        return true;
    }

    public function getArrear($id){
        $query = "SELECT * FROM arrears_pendings WHERE id = ".$id."";
        return DB::select(DB::raw($query));
    }

    public function getArrear1($id){
        $query = "SELECT * FROM arrears WHERE id = ".$id."";
        return DB::select(DB::raw($query));
    }

    public function getArrearLog($id){
        $query = "SELECT * FROM arrears_logs WHERE arrear_id = '".$id."'";
        return DB::select(DB::raw($query));
    }

    public function insertArrearLog($data){
        DB::table('arrears_logs')->insert($data);
        
    }

    public function updateArrearLog($id,$data){
        DB::table('arrears_logs')
        ->where('id', $id)
        ->update( $data);
    }

    public function updateArrear($id,$data){
        DB::table('arrears')->where('id', $id)->update( $data);

        DB::table('temp_arrears')->where('id', $id)->update( $data);

    }

    public function getPreviousArrears($month,$year){
        $query = "SELECT * FROM arrears WHERE month(payroll_date)= '".$month."' and year(payroll_date)= '".$year."'";
        return DB::select(DB::raw($query));
    }

    // SELECT (@s:=@s+1) AS SNo, ar.*, pl.less_takehome, IF( (SELECT COUNT(id) FROM arrears_pendings WHERE arrear_id = ar.id)>0, (SELECT amount FROM arrears_pendings WHERE arrear_id = ar.id), 0 ) as pending_amount FROM arrears ar, payroll_logs pl, (SELECT @s:=0) AS s WHERE pl.payroll_date = ar.payroll_date AND pl.empID = ar.empID AND ar.empID = '2550001' AND ar.id = 10

    public function arrearsPayment($arrearID, $dataLogs, $dataUpdates){
        DB::transaction(function()
       {

        DB::table('arrears')->where('id', $id)->update( $dataUpdates);
        

        DB::table('arrears_logs')->insert($dataLogs);
        });
        return true;
    }

    public function arrearsPayment_schedule($data){
        DB::table('arrears_pendings')->insert($data);
       
        return true;
    }

    public function arrearsMonth($payrollMonth){
        $query = "sum(amount) as arrear_payment  where payroll_date = '".$payrollMonth."'";
        $row = DB::table('arrears')
        ->select(DB::raw($query))
       
        ->first();

        if($row){
            return $row->arrear_payment;
        }else{
            return 0;
        }
    }

    public function arrearsPending(){
        $query = "select * from arrears_pendings where status = 1";
        return DB::select(DB::raw($query));
    }

    public function arrearsPendingByArrearId(){
        $query = "select arrear_id from arrears_pendings where status = 1 group by arrear_id";
        return DB::select(DB::raw($query));
    }

    public function truncateArrearsPending(){
        DB::table('arrears_pendings')->where('status',1)->delete();
       
        return true;
    }

    

    public function insertAllocation($data){
        DB::table('employee_activity_grant_logs')->insert($data);
        return true;
    }

    // sum_employee_arrears

    /*public function send_payslips($payrollDate){

        $query = "SELECT empID, email, payroll_date, CONCAT(fname,' ', mname,' ', lname) AS empName FROM employee, payroll_logs WHERE  emp_id = empID AND payroll_date = '".$payrollDate."'";

        return DB::select(DB::raw($query));
    }*/

    public function partial_payment_list(){
        $query = "SELECT (@s:=@s+1) as SNo, pp.*, concat(e.fname,'',e.mname,' ',e.lname) as name FROM partial_payment pp, employee e,(SELECT @s:=0) as s where pp.empID = e.emp_id and pp.status = 0 ORDER BY pp.id DESC";
        return DB::select(DB::raw($query));
    }

    public function pensionAll(){
        $query = "select * from pension_fund";
        return DB::select(DB::raw($query));
    }

    public function temp_payroll_check($payroll_date){
        $query = "select * from temp_payroll_logs where payroll_date= '".$payroll_date."' ";
        return DB::select(DB::raw($query));
    }

    public function role($permission){
        $query = "select * from role where permissions like '".$permission."' ";
        return DB::select(DB::raw($query));
    }

    public function employeeRole($role_id){
        $query = "SELECT er.userID as empID, e.fname, e.email FROM emp_role er, employee e where er.userID = e.emp_id and er.role = '".$role_id."' ";
        return DB::select(DB::raw($query));
    }

    public function mailConfig(){
        $query = "SELECT * FROM company_emails limit 1 ";
        return DB::select(DB::raw($query));
    }

    public function saveMail($id, $data){
        $result = DB::able('company_emails')
        ->where('id', $id)
        ->update($data);
        return $result;
    }
}


