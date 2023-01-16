
    public function initPayroll($dateToday, $payroll_date, $payroll_month, $empID)
    {


        $days = intval(date('t', strtotime($payroll_date)));

        $payroll_date=date($payroll_date);

       /// dd($payroll_date);

    //   $query = "SELECT DATEDIFF('".$payroll_date."',e.hire_date) as datediff from employee e";
    //   DD(DB::select(DB::raw($query)));


        DB::transaction(function () use ($dateToday, $payroll_date, $payroll_month, $empID,$days) {

            $query = "UPDATE allowances SET state = IF(month('".$payroll_date."') = 12,1,0) WHERE type = 1";
            DB::insert(DB::raw($query));

            //Insert into Pending Payroll Table
            $query = "INSERT INTO payroll_months (payroll_date, state, init_author, appr_author, init_date, appr_date,sdl, wcf) VALUES
        ('" . $payroll_date . "', 2, '" . $empID . "', '', '" . $dateToday . "', '" . $payroll_date . "', (SELECT rate_employer from deduction where id=4 ), (SELECT rate_employer from deduction where id=2 ) )";
            DB::insert(DB::raw($query));
            //INSERT ALLOWANCES
            $query = "INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)

SELECT ea.empID AS empID, a.name AS description,




IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

IF((e.unpaid_leave = 0)
,0,IF((a.mode = 1),
          ea.amount,
          IF(a.type = 1,IF(DATEDIFF('".$payroll_date."',e.hire_date) < 365,(DATEDIFF('".$payroll_date."',e.hire_date)/365)*e.salary,a.percent*e.salary),(a.percent*
          IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
          ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)

      ))
      )

  ) AS amount,

 '" . $payroll_date . "' AS payment_date

FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND a.state = 1 AND e.state != 4 and e.login_user != 1";
    DB::insert(DB::raw($query));

            //INSERT BONUS
            $query = " INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)

	    SELECT b.empID AS empID, bt.name AS description,

	    'Fixed Amount' AS policy,

	    IF((e.unpaid_leave = 0),0,SUM(b.amount)) AS amount,

	    '" . $payroll_date . "' AS payment_date

	    FROM employee e,  bonus b, bonus_tags bt WHERE e.emp_id =  b.empID and bt.id = b.name AND b.state = 1 and e.state != 4 and e.login_user != 1 GROUP BY b.empID, bt.name";
            DB::insert(DB::raw($query));
            //INSERT OVERTIME
            $query = " INSERT INTO temp_allowance_logs(empID, description, policy, amount, payment_date)
	    SELECT o.empID AS empID, 'Overtime' AS description,

	    'Fixed Amount' AS policy,

        IF((e.unpaid_leave = 0),0,SUM(o.amount)) AS amount,

	    '" . $payroll_date . "' AS payment_date

	    FROM  employee e, overtimes o WHERE  o.empID =  e.emp_id and e.state != 4 and e.login_user != 1 GROUP BY o.empID";
            DB::insert(DB::raw($query));

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
            $query = "INSERT into temp_loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID, IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy, IF(((paid+deduction_amount) > amount), amount, deduction_amount) as  paid, (amount - IF(((paid+deduction_amount) >= amount), amount-paid,  ((paid+deduction_amount)))) as remained,  '" . $payroll_date . "' as payment_date FROM loan  WHERE  state = 1 AND NOT type = 3";
            DB::insert(DB::raw($query));
            //INSERT HESLB INTO LOGS
            $query = "INSERT into temp_loan_logs(loanID, policy, paid, remained, payment_date) SELECT id as loanID, IF( (deduction_amount = 0), (SELECT rate_employee FROM deduction where id = 3), deduction_amount ) as policy, IF(((paid+deduction_amount) > amount), amount, ((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1))) as  paid, (amount - IF(((paid+deduction_amount) >= amount), amount-paid,  ((paid+((SELECT rate_employee FROM deduction where id = 3)*(SELECT salary from employee where emp_id=empID and state != 4 and login_user != 1)))))) as remained, '" . $payroll_date . "' as payment_date FROM loan  WHERE  state = 1 AND type = 3";
            DB::insert(DB::raw($query));
            //INSERT DEDUCTION LOGS
            $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT ed.empID as empID, name as description,

	    IF( (d.mode = 1), 'Fixed Amount', CONCAT(100*d.percent,'% ( Basic Salary )') ) as policy,

	    IF((e.unpaid_leave = 0),0,IF( (d.mode = 1), d.amount, (d.percent*IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)) )) as paid,

	    '" . $payroll_date . "' as payment_date

	    FROM emp_deductions ed,  deductions d, employee e WHERE e.emp_id = ed.empID and e.state != 4 and e.login_user != 1 AND ed.deduction = d.id AND  d.state = 1";
            DB::insert(DB::raw($query));
            //DEDUCTION LOGS FROM IMPREST REFUND
            $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    SELECT empID, description, policy, paid, '" . $payroll_date . "'

	    FROM once_off_deduction";
            DB::insert(DB::raw($query));



            // DEDUCTION LOGS FOR EXPATRIATES(HOUSING ALLOWANCE REFUND)
            // Housing Allowance has id = 6
            $query = "INSERT INTO temp_deduction_logs(empID, description, policy, paid, payment_date)

	    	SELECT ea.empID AS empID, 'Housing Allowance Compasation' AS description,

	    IF( (a.mode = 1), 'Fixed Amount', CONCAT(100*a.percent,'% ( Basic Salary )') ) AS policy,

	    IF((e.unpaid_leave = 0),0,IF( (a.mode = 1), ea.amount, (a.percent*IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)) )) AS paid,

	     '" . $payroll_date . "' AS payment_date

	    FROM employee e, emp_allowances ea,  allowances a WHERE e.emp_id = ea.empID AND a.id = ea.allowance AND e.is_expatriate = 1 and e.state != 4 and e.login_user != 1 AND a.id = 6";
            DB::insert(DB::raw($query));
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

        IF((e.unpaid_leave = 0),0, IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)) AS salary,

	    /*Allowances and Bonuses*/ (

        IF((e.unpaid_leave = 0),0,IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	     ))

         /*End Allowances and Bonuses*/ AS  allowances,

         IF((e.unpaid_leave = 0),0,IF(e.retired !=2, IF((pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  )) AS pension_employee,



IF((e.unpaid_leave = 0),0,IF(e.retired !=2,IF((pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employer), (pf.amount_employer*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 And a.pensionable = 'YES' GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  )) AS pension_employer,


IF((e.unpaid_leave = 0),0,((SELECT rate_employee from deduction where id=9 )*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)))) as medical_employee,

IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=9 )*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)))) as medical_employer,

IF((e.unpaid_leave = 0),0,(
	    ( SELECT excess_added FROM paye WHERE maximum >
	    (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/

       /* IF( e.retired !=2,IF((pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),'0'  )
        */


	    IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND  a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND  ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 AND a.taxable = 'YES' GROUP BY ea.empID), 0)))  )
	       /* End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = 'YES' AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = 'YES' AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/


	    IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = 'YES' AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)))  )


         /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) )

	    +

	    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES'  AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = 'YES' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = 'YES' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/))) )



	    )) AS taxdue,



	    IF((e.unpaid_leave = 0),0,IF(((IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/ )<(SELECT minimum_gross FROM meals_deduction WHERE id = 1)), (SELECT minimum_payment FROM meals_deduction WHERE id = 1), (SELECT maximum_payment FROM meals_deduction WHERE id = 1))) AS meals,



	     e.department AS department,

	     e.position AS position,

	     e.branch AS branch,

	     e.pension_fund AS pension_fund,

	     e.pf_membership_no as membership_no,

	     e.bank AS bank,
	     e.bank_branch AS bank_branch,
	     e.account_no AS account_no,

         IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=4 )*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  ))) as sdl,

	    IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=2 )*(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary) +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month('".$payroll_date."')) AND (year(e.hire_date) = year('".$payroll_date."'))
                  ,((".$days."- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  ))) as wcf,

	     '" . $payroll_date . "' as payroll_date
	     FROM employee e, pension_fund pf, bank bn, bank_branch bb WHERE e.pension_fund = pf.id AND  e.bank = bn.id AND bb.id = e.bank_branch AND e.state != 4 and e.login_user != 1";

            DB::insert(DB::raw($query));
        });
        return true;
    }

