<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style type="text/css">
            @media print {
                #printbtn {
                    display :  none;
                }
            }
            </style>
            <style media="print">
                @page {
                 size: auto;
                 margin: 0;
                      }
               </style>

</head>

<body>

    <main>
        <div class="row">

            <div class="col-md-12">


                <div class="d-flex justify-content-between align-items-center px-3 mt-2 mb-3">
                    <div class="logo-wrapper">
                        <img src="https://www.bancabc.co.tz/images/banc_abc_logo.png" alt="logo here" class="image-fluid">
                    </div>


                    <div>
                        <h5><center>AFRICAN BANKING CORPORATION</center></h5>
                        <h5><center>P.O. BOX 31</center></h5>
                        <h5><center>DAR ES SALAAM</center></h5>
                    </div>
                    <button id="printbtn" onclick="window.print()">Print this page</button>
                    <div>
                        <h2>Salary Slip</h2>
                        <h6>For month : {{ date('M-Y',strtotime($payroll_date)) }}</h6>
                    </div>
                </div>




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
                        $sum_loans = ($sum_loans+$paid);
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

                    $sum_allowances = $total_allowances/$rate;
                    $sum_deductions = $total_deductions/$rate;

                    ?>

                    <div class="row mx-auto mt-2">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center px-3 mt-2">
                                <div class="logo-wrapper">
                                    <h6 style="font-weight:600 !important; ">Name:  <?php echo $name; ?> </h6>
                                    <h6 style="font-weight:600 !important; ">Job Title: <?php echo $position; ?></h6>
                                    <h6 style="font-weight:600 !important; ">Location:  <?php echo $branch; ?></h6>
                                </div>


                                <div>
                                    <h6 class="" style="font-weight:600 !important; ">Payroll Number:  <?php echo $employeeID; ?></h6>
                                    <h6 style="font-weight:600 !important; ">Department:  <?php echo $department; ?></h6>
                                    <h6 style="font-weight:600 !important; ">Employment Date: {{ date('d-M-Y',strtotime($hiredate)) }}</h6>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>

                <div class="row">

                    <div class="col-md-9 col-9 mx-auto my-2" style="border:1px solid rgb(75, 75, 75)">
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Net Basic Calculations
                        </button>
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Basic Pay</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($salary, 2); ?></div>
                        </div>
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Payments
                        </button>
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Net Basic </div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($salary, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            <?php foreach($allowances as $row){
                            ?>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6"><?php echo $row->description; ?></div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"> <?php echo number_format($row->amount / $rate, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            <?php } ?>

                        </div>

                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Taxation
                        </button>
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Gross pay</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($sum_allowances + $salary, 2); ?></div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Less: Tax free Pension</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($pension_employee, 2); ?></div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Taxable Gross</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($sum_allowances + $salary - $pension_employee, 2); ?></div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">PAYE</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($taxdue, 2); ?></div>
                        </div>
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Deduction
                        </button>
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Net Tax </div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($taxdue, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">NSSF</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($pension_employee, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            @foreach($deductions as $row)
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">{{ $row->description }}</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end">{{ number_format($row->paid/$rate, 2) }}</div>


                            @endforeach
                            @foreach($loans as $row)

                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">{{ $row->description }}</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end">{{ number_format($row->paid/$rate, 2) }}</div>


                            @endforeach
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Total Deduction</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                        </div>
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Summary
                        </button>
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Total Income</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($salary, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Total Deduction</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Net pay</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($amount_takehome, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                        </div>
                         @if($total_bank_loan > 0)
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Bank Loans
                        </button>
                        <div class="row">
                            @foreach($bank_loan as $row)
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">{{ $row->product }}</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end">{{ number_format($row->amount/$rate, 2) }}</div>


                            @endforeach
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Total</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($total_bank_loan, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                        </div>
                        @endif
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                            disabled>
                            Take Home
                        </button>
                        <div class="row" style="border-bottom: 4px solid rgb(71, 105, 116) !important; ">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Take home</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($amount_takehome, 2); ?></div>
                            {{-- <div class="col-md-12"><hr></div> --}}
                        </div>
                        @if($total_bank_loan > 0)
                        <button class="col-md-12 col-12 mt-2 text-dark" style="font-weight:bolder !important; "
                        disabled>
                        Take Home After Loan Deductions
                    </button>
                    <div class="row" style="border-bottom: 4px solid rgb(71, 105, 116) !important; ">
                        <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Take home</div>
                        <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo number_format($amount_takehome - $total_bank_loan, 2); ?></div>
                        {{-- <div class="col-md-12"><hr></div> --}}
                    </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">NSSF Number:</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo $membership_no; ?></div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Method of Payment: </div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end">Bank</div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6">Account No: </div>
                            <div class="col-md-6 col-6 col-sm-6 col-lg-6 col-xs-6 text-end"><?php echo $account_no; ?></div>
                        </div>


                    </div>

                    <div class="row" style="border-top: 10px solid rgb(71, 105, 116) !important; ">

                    </div>

                    <div class="text-center mt-2">
                        <p class="fw-bold font-italic">
                            "Use your BancABC Mobi to pay for your <br>
                            bills such as LUKU,WATER BILLS, SUBSCRIPTION, GEPG <br>
                            and many more by simply dialing *150*34#
                        </p>
                    </div>
                </div>




            </div>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>
<script>
    window.onload= function(){
        window.print();
    }
</script>

</html>
