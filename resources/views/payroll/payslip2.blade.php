<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary Slip</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <style>
        .headers {
            border-bottom: 2px solid rgb(9, 5, 64);
            font-weight: 600 !important;
            background-color: rgb(140, 193, 210)
        }

        .contents {
            text-align: right;
        }

        .table-body {
            border-bottom: 2px;
        }
    </style>
</head>

<body>

    <main>



                <table class="table">
                    <tfoot>

                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here"
                                        class="image-fluid"> <br>

                                </div>
                            </td>
                            <td>
                                <div class="box-text text-center">
                                    <p style="font-weight:700" class="">
                                        AFRICAN BANKING CORPORATION<br>
                                        P.O. BOX 31 ,DAR ES SALAAM

                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="" style="text-align: right; padding-right:20px">

                                    <div>
                                        <h2>Salary Slip</h2>
                                        <h6>For month : {{ date('M-Y', strtotime($payroll_date)) }}</h6>
                                    </div>

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>




                {{-- <p class="text-end text-primary"><i>For month</i> &nbsp; <i class="text-end">August,2022</i></p> --}}
                <div class="row" style="border-bottom: 10px solid rgb(71, 105, 116) !important; ">



                    <?php

                    foreach ($slipinfo as $row) {
                        $rate = $row->rate;
                        $id = $row->empID;
                        $old_id = $row->oldID;
                        if ($row->oldID == 0) {
                            $employeeID = $row->empID;
                        } else {
                            $employeeID = $row->oldID;
                        }
                        $hiredate = $row->hire_date;
                        $name = $row->name;
                        $position = $row->position_name;
                        $department = $row->department_name;
                        $branch = $row->branch_name;
                        $salary = $row->salary / $row->rate;
                        $pension_fund = $row->pension_fund_name;
                        $pension_fund_abbrv = $row->pension_fund_abbrv;
                        $membership_no = $row->membership_no;
                        $bank = $row->bank_name;
                        $account_no = $row->account_no;
                        $hiredate = $row->hire_date;
                        $payroll_month = $row->payroll_date;
                        $pension_employee = $row->pension_employee / $row->rate;
                        $meals = $row->meals / $row->rate;
                        $taxdue = $row->taxdue / $row->rate;
                    }

                    foreach ($companyinfo as $row) {
                        $companyname = $row->cname;
                    }

                    foreach ($total_pensions as $row) {
                        $uptodate_pension_employee = $row->total_pension_employee / $row->rate;
                        $uptodate_pension_employer = $row->total_pension_employer / $row->rate;
                    }

                    $sum_allowances = $total_allowances / $rate;
                    $sum_deductions = $total_deductions / $rate;
                    $sum_loans = 0;

                    // DATE MANIPULATION
                    $hire = date_create($hiredate);
                    $today = date_create($payroll_month);
                    $diff = date_diff($hire, $today);
                    $accrued = (37 * $diff->format('%a%')) / 365;
                    $totalAccrued = number_format((float) $accrued, 2, '.', ''); //3,04days

                    $balance = $totalAccrued - $annualLeaveSpent; //days
                    if ($balance < 0) {
                        $balance = 0;
                    }

                    foreach ($loans as $row) {
                        $paid = $row->paid;
                        if ($row->remained == 0) {
                            $get_remainder = $row->paid / $row->policy;
                            $array = explode('.', $get_remainder);
                            if (isset($array[1])) {
                                $num = '0' . '.' . $array[1];
                            } else {
                                $num = '0';
                            }
                            //        $paid = $num*$row->policy;
                            $paid = $salary_advance_loan_remained;
                        }
                        $sum_loans = $sum_loans + $paid;
                    }

                    // START TAKE HOME
                    $amount_takehome = $sum_allowances + $salary - ($sum_loans + $pension_employee + $taxdue + $sum_deductions + $meals);

                    $paid_salary = $amount_takehome;
                    foreach ($paid_with_arrears as $paid_with_arrear) {
                        if ($paid_with_arrear->with_arrears) {
                            $with_arr = $paid_with_arrear->with_arrears; //with held
                            $paid_salary = $amount_takehome - $with_arr; //paid amount
                        } else {
                            $with_arr = 0; //with held
                        }
                    }

                    foreach ($arrears_paid as $arrear_paid) {
                        if ($arrear_paid->arrears_paid) {
                            $paid_salary = $amount_takehome + $arrear_paid->arrears_paid - $with_arr;
                            $paid_arr = $arrear_paid->arrears_paid;
                        } else {
                            $paid_arr = 0;
                        }
                    }

                    foreach ($paid_with_arrears_d as $paid_with_arrear_d) {
                        if ($paid_with_arrear_d->arrears_paid) {
                            $paid_arr_all = $paid_with_arrear_d->arrears_paid;
                        } else {
                            $paid_arr_all = 0;
                        }
                    }

                    if ($with_arr > 0) {
                        foreach ($arrears_all as $arrear_all) {
                            if ($arrear_all->arrears_all) {
                                $due_arr = $arrear_all->arrears_all - $paid_arr_all;
                            } else {
                                $due_arr = 0;
                            }
                        }
                    } else {
                        foreach ($arrears_all as $arrear_all) {
                            if ($arrear_all->arrears_all) {
                                $due_arr = $arrear_all->arrears_all - $paid_arr_all;
                            } else {
                                $due_arr = 0;
                            }
                        }
                    }

                    $sum_allowances = $total_allowances / $rate;
                    $sum_deductions = $total_deductions / $rate;

                    ?>
                    <table class="table">
                        <tfoot>

                            <tr class="">
                                <td class="">
                                    <div class="logo-wrapper">
                                        <h6 style="font-weight:600 !important; ">Name: <?php echo $name; ?> </h6>
                                        <h6 style="font-weight:600 !important; ">Job Title: <?php echo $position; ?></h6>
                                        <h6 style="font-weight:600 !important; ">Location: <?php echo $branch; ?></h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="box-text text-center">
                                        <p style="font-weight:700" class="">


                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="box-text"> </div>
                                </td>

                                <td colspan="4" class="w-50" style="">
                                    <div class="" style="text-align: right; padding-right:20px">

                                        <div>
                                            <h6 class="" style="font-weight:600 !important; ">Payroll Number:
                                                <?php echo $employeeID; ?></h6>
                                            <h6 style="font-weight:600 !important; ">Department: <?php echo $department; ?>
                                            </h6>
                                            <h6 style="font-weight:600 !important; ">Employment Date:
                                                {{ date('d-M-Y', strtotime($hiredate)) }}</h6>
                                        </div>

                                    </div>
                                </td>
                            </tr>

                        </tfoot>
                    </table>


                </div>

                <div class="row">

                    <table class="table">
                        <tr class="headers text-center">
                            <td colspan="2">Net Basic Calculations</td>
                        </tr>
                        <tr class="table-body">
                            <td>Basic Pay</td>
                            <td class="contents"><?php echo number_format($salary, 2); ?></td>
                        </tr>
                        <tr class="headers text-center">
                            <td colspan="2">Payments</td>
                        </tr>
                        <tr class="table-body">
                            <td>Net Basic</td>
                            <td class="contents"><?php echo number_format($salary, 2); ?></td>
                        </tr>
                        <?php foreach($allowances as $row){
                            ?>
                        <tr class="table-body">
                            <td><?php echo $row->description; ?></td>
                            <td class="contents"><?php echo number_format($row->amount / $rate, 2); ?></td>
                        </tr>
                        <?php } ?>
                        <tr class="headers text-center">
                            <td colspan="2">Taxation</td>
                        </tr>
                        <tr class="table-body">
                            <td>Gross pay</td>
                            <td class="contents"><?php echo number_format($sum_allowances + $salary, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>Less: Tax free Pension</td>
                            <td class="contents"><?php echo number_format($pension_employee, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>Taxable Gross</td>
                            <td class="contents"><?php echo number_format($sum_allowances + $salary - $pension_employee, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>PAYE</td>
                            <td class="contents"><?php echo number_format($taxdue, 2); ?></td>
                        </tr>

                        <tr class="headers text-center">
                            <td colspan="2">Deduction</td>
                        </tr>
                        <tr class="table-body">
                            <td>Net Tax</td>
                            <td class="contents"><?php echo number_format($taxdue, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>NSSF</td>
                            <td class="contents"><?php echo number_format($pension_employee, 2); ?></td>
                        </tr>
                        @foreach ($deductions as $row)
                            <tr class="table-body">
                                <td>{{ $row->description }}</td>
                                <td class="contents">{{ number_format($row->paid / $rate, 2) }}</td>
                            </tr>
                        @endforeach
                        @foreach ($loans as $row)
                            <tr class="table-body">
                                <td>{{ $row->description }}</td>
                                <td class="contents">{{ number_format($row->paid / $rate, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="table-body">
                            <td>Total Deduction</td>
                            <td class="contents"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?></td>
                        </tr>
                        <tr class="headers text-center">
                            <td colspan="2"> Summary</td>
                        </tr>
                        <tr class="table-body">
                            <td>Total Income</td>
                            <td class="contents"><?php echo number_format($salary, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>Total Deduction</td>
                            <td class="contents"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?></td>
                        </tr>
                        <tr class="table-body">
                            <td>Net pay</td>
                            <td class="contents"><?php echo number_format($amount_takehome, 2); ?></td>
                        </tr>

                        @if ($total_bank_loan > 0)
                            <tr class="headers text-center">
                                <td colspan="2"> Bank Loans</td>
                            </tr>
                            @foreach ($bank_loan as $row)
                                <tr class="table-body">
                                    <td>{{ $row->product }}</td>
                                    <td class="contents">{{ number_format($row->amount / $rate, 2) }}</td>
                                </tr>
                            @endforeach

                            <tr class="table-body">
                                <td>Total</td>
                                <td class="contents"><?php echo number_format($total_bank_loan, 2); ?></td>
                            </tr>
                        @endif
                        <tr class="headers text-center">
                            <td colspan="2"> Take Home</td>
                        </tr>
                        <tr class="table-body">
                            <td>Take home</td>
                            <td class="contents"><?php echo number_format($amount_takehome, 2); ?></td>
                        </tr>
                        @if ($total_bank_loan > 0)
                            <tr class="headers text-center">
                                <td colspan="2">Take Home After Loan Deductions</td>
                            </tr>
                            <tr class="table-body">
                                <td>Take home</td>
                                <td class="contents"><?php echo number_format($amount_takehome - $total_bank_loan, 2); ?></td>
                            </tr>
                        @endif
                        <tfoot>
                            <tr>
                                <td>NSSF Number:</td>
                                <td class="contents"><?php echo $membership_no; ?></td>
                            </tr>
                            <tr>
                                <td>Method of Payment:</td>
                                <td class="contents">Bank</td>
                            </tr>
                            <tr>
                                <td>Account No:</td>
                                <td class="contents"><?php echo $account_no; ?></td>
                            </tr>
                        </tfoot>

                    </table>

                     <hr style="border-top: 10px solid rgb(71, 105, 116) !important; ">

                    <div class="text-center mt-2">
                        <p class="fw-bold font-italic">
                            "Use your BancABC Mobi to pay for your <br>
                            bills such as LUKU,WATER BILLS, SUBSCRIPTION, GEPG <br>
                            and many more by simply dialing *150*34#
                        </p>
                    </div>
                </div>

    </main>


    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>
</html>
