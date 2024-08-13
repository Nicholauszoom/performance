    (
        /*Taxable Amount*/
        (
            (
                IF(
                    (
                        month(e.hire_date) = month('" . $payroll_date . "')
                    )
                    AND (
                        year(e.hire_date) = year('" . $payroll_date . "')
                    ),
(
                        (" . $days . " - day(e.hire_date) + 1) * e.salary / " . $days . "
                    ),
                    0
                ) +
                /*pension*/
                IF(
                    (pf.deduction_from = 1),
                    (
                        IF(
                            (
                                month(e.hire_date) = month('" . $payroll_date . "')
                            )
                            AND (
                                year(e.hire_date) = year('" . $payroll_date . "')
                            )
                            /*IF BASIC  */
,
(
                                (" . $days . " - day(e.hire_date) + 1) * e.salary / " . $days . "
                            ),
                            e.salary
                        ) * pf.amount_employee
                    ),
                    /* IF GROSS */
                    (
                        pf.amount_employee *(
                            IF(
                                (
                                    month(e.hire_date) = month('" . $payroll_date . "')
                                )
                                AND (
                                    year(e.hire_date) = year('" . $payroll_date . "')
                                ),
(
                                    (" . $days . " - day(e.hire_date) + 1) * e.salary / " . $days . "
                                ),
                                e.salary
                            ) + IF (
                                (
                                    SELECT SUM(b.amount)
                                    FROM bonus b
                                    WHERE b.state = 1
                                        AND b.empID = e.emp_id
                                    GROUP BY b.empID
                                ) >= 0,
                                (
                                    SELECT SUM(b.amount)
                                    FROM bonus b
                                    WHERE b.state = 1
                                        AND b.empID = e.emp_id
                                    GROUP BY b.empID
                                ),
                                0
                            ) + IF (
                                (
                                    SELECT SUM(o.amount)
                                    FROM overtimes o
                                    WHERE o.empID = e.emp_id
                                    GROUP BY o.empID
                                ) >= 0,
                                (
                                    SELECT SUM(o.amount)
                                    FROM overtimes o
                                    WHERE o.empID = e.emp_id
                                    GROUP BY o.empID
                                ),
                                0
                            ) + IF (
                                (
                                    SELECT SUM(ea.amount)
                                    FROM emp_allowances ea,
                                        allowances a
                                    WHERE a.id = ea.allowance
                                        AND ea.empID = e.emp_id
                                        AND a.taxable = 'YES'
                                        AND a.pensionable = 'YES'
                                        AND ea.mode = 1
                                        AND a.state = 1
                                    GROUP BY ea.empID
                                ) >= 0,
                                (
                                    (
                                        SELECT SUM(ea.amount)
                                        FROM emp_allowances ea,
                                            allowances a
                                        WHERE a.id = ea.allowance
                                            AND ea.empID = e.emp_id
                                            AND a.taxable = 'YES'
                                            AND a.pensionable = 'YES'
                                            AND ea.mode = 1
                                            AND a.state = 1
                                        GROUP BY ea.empID
                                    )
                                ),
                                0
                            )
                            /*end leave allowance to tax */
                            + IF (
                                (
                                    SELECT SUM(
                                            IF(
                                                (
                                                    month(e.hire_date) = month('" . $payroll_date . "')
                                                )
                                                AND (
                                                    year(e.hire_date) = year('" . $payroll_date . "')
                                                ),
(
                                                    (" . $days . " - day(e.hire_date) + 1) * e.salary / " . $days . "
                                                ),
                                                e.salary
                                            ) * ea.percent
                                        )
                                    FROM emp_allowances ea,
                                        allowances a
                                    WHERE a.id = ea.allowance
                                        AND ea.empID = e.emp_id
                                        AND a.taxable = 'YES'
                                        AND a.pensionable = 'YES'
                                        AND ea.mode = 2
                                        AND a.state = 1
                                        AND a.type = 0
                                    GROUP BY ea.empID
                                ) > 0,
                                (
                                    SELECT SUM(
                                            IF(
                                                (
                                                    month(e.hire_date) = month('" . $payroll_date . "')
                                                )
                                                AND (
                                                    year(e.hire_date) = year('" . $payroll_date . "')
                                                ),
(
                                                    (" . $days . " - day(e.hire_date) + 1) * e.salary / " . $days . "
                                                ),
                                                e.salary
                                            ) * ea.percent
                                        )
                                    FROM emp_allowances ea,
                                        allowances a
                                    WHERE a.id = ea.allowance
                                        AND ea.empID = e.emp_id
                                        AND a.taxable = 'YES'
                                        AND a.pensionable = 'YES'
                                        AND ea.mode = 2
                                        AND a.state = 1
                                        AND a.type = 0
                                    GROUP BY ea.empID
                                ),
                                0
                            )
                        )
                    )
                )
            )
            /* END OF PENSION CALCULATION */
            /*END OF TAXABLE AMOUNT CALCULATION */
        )
        /*End Taxable Amount*/
    ) as pension2,