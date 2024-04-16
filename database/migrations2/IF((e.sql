IF((e.unpaid_leave = 0),0,(
    (
        SELECT rate_employee 
        FROM deduction 
        WHERE id=10
    ) * (
        IF(
            (month(e.hire_date) = month('" . $payroll_date . "')) 
            AND (year(e.hire_date) = year('" . $payroll_date . "')),
            ((" . $days . "- day(e.hire_date)+1)*e.salary/" . $days . "),
            e.salary
        ) 
        +
        /* Pensionable Allowances */
        IF (
            (SELECT SUM(ea.amount) 
            FROM emp_allowances ea, allowances a  
            WHERE a.id = ea.allowance 
            AND ea.empID = e.emp_id 
            AND ea.mode=2 
            AND a.state= 1 
            AND a.type = 1 /* Pensionable Allowance */
            GROUP BY ea.empID) >= 0,
            (SELECT SUM(ea.amount) 
            FROM emp_allowances ea, allowances a  
            WHERE a.id = ea.allowance 
            AND ea.empID = e.emp_id 
            AND ea.mode=2 
            AND a.state= 1 
            AND a.type = 1 /* Pensionable Allowance */
            GROUP BY ea.empID),
            0
        )
    ) 
    /* End all Allowances and Bonuses */
)) as nhif,
