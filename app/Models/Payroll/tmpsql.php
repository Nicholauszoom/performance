<?php

namespace App\Models\Payroll;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use RexShijaku\SQLToLaravelBuilder\SQLToLaravelBuilder;

class Payroll extends Model
{


    function tmp()
    {
        DB::table(DB::raw('employee e'))
            ->select('e.emp_id AS empID', DB::raw('IF((e.unpaid_leave = 0),0,IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)) AS salary'), DB::raw(''), DB::raw(''), DB::raw('(

        IF((e.unpaid_leave = 0),0,IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	     )) AS  allowances'), DB::raw('IF((e.unpaid_leave = 0),0,IF(e.retired !=2,IF((pf.deduction_from = 1),(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee),(pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0))))\'0\')) AS pension_employee'), DB::raw('IF((e.unpaid_leave = 0),0,IF(e.retired !=2,IF((pf.deduction_from = 1),(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employer),(pf.amount_employer*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 And a.pensionable = \'YES\' GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 And a.pensionable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0))))\'0\')) AS pension_employer'), DB::raw('IF((e.unpaid_leave = 0),0,((SELECT rate_employee from deduction where id=9 )*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)))) as medical_employee'), DB::raw('IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=9 )*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)))) as medical_employer'), DB::raw('IF((e.unpaid_leave = 0),0,(
	    ( SELECT excess_added FROM paye WHERE maximum >
	    (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/

       /* IF( e.retired !=2,IF((pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

        IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

        IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))),\'0\'  )
        */


	    IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND  a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND  ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 AND a.taxable = \'YES\' GROUP BY ea.empID), 0)))  )
	       /* End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = \'YES\' AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = \'YES\' AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/


	    IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND a.taxable = \'YES\' AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)))  )


         /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) )

	    +

	    ( (SELECT rate FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)  AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/)) * ((/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\'  AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) - (SELECT minimum FROM paye WHERE maximum > (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.taxable = \'YES\' AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/) AND minimum <= (/*Taxable Amount*/ (
	    ( IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) -

	     /*pension*/
	     IF(  (pf.deduction_from = 1), (IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*pf.amount_employee), (pf.amount_employee*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)+ IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)))  )
	     /*End pension*/

	    ) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.taxable = \'YES\' AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/
	     )/*End Taxable Amount*/))) )



	    )) AS taxdue'), DB::raw('IF((e.unpaid_leave = 0),0,IF(((IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) +
	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/ )<(SELECT minimum_gross FROM meals_deduction WHERE id = 1)),(SELECT minimum_payment FROM meals_deduction WHERE id = 1),(SELECT maximum_payment FROM meals_deduction WHERE id = 1))) AS meals'), DB::raw('e.department AS department'), DB::raw('e.position AS position'), DB::raw('e.branch AS branch'), DB::raw('e.pension_fund AS pension_fund'), DB::raw('e.pf_membership_no as membership_no'), DB::raw('e.bank AS bank'), 'e.bank_branch AS bank_branch', 'e.account_no AS account_no', 'IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=4 )*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  ))) as sdl', 'IF((e.unpaid_leave = 0),0,((SELECT rate_employer from deduction where id=2 )*(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary) +

	    /*all Allowances and Bonuses*/
	    IF ((SELECT SUM(b.amount) FROM bonus b WHERE  b.state =  1 AND b.empID =  e.emp_id GROUP BY b.empID)>=0, (SELECT SUM(b.amount) FROM bonus b WHERE  b.state = 1 AND b.empID =  e.emp_id GROUP BY b.empID), 0) +

	    IF ((SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID)>=0, (SELECT SUM(o.amount) FROM overtimes o WHERE  o.empID =  e.emp_id GROUP BY o.empID), 0) +

	    IF ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)>=0, ((SELECT SUM(ea.amount) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=1 AND a.state= 1 GROUP BY ea.empID)),0) + IF ((SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID)>0, (SELECT SUM(IF((month(e.hire_date) = month(\'\" . $payroll_date . \"\')) AND (year(e.hire_date) = year(\'\" . $payroll_date . \"\'))
                  ,((\" . $days . \"- day(e.hire_date)+1)*e.salary/30),e.salary)*a.percent) FROM emp_allowances ea, allowances a  WHERE  a.id = ea.allowance AND ea.empID =  e.emp_id AND a.mode=2 AND a.state= 1 GROUP BY ea.empID), 0)

	    /*End all Allowances and Bonuses*/  ))) as wcf', '\" . $payroll_date . \"\' as payroll_date')
            ->crossJoin(DB::raw('pension_fund pf'))
            ->crossJoin(DB::raw('bank bn'))
            ->crossJoin(DB::raw('bank_branch bb'))
            ->Join('temp_payroll_logs')
            ->where([['e.pension_fund', 'pf.id'], ['e.bank', 'bn.id'], ['bb.id', 'e.bank_branch'], ['e.state', '!=', 4], ['e.login_user', '!=', 1]])
            ->get();
    }
}
