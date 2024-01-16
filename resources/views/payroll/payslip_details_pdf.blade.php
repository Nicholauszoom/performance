<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Salary Slip</title>

    {{-- @include('layouts.shared.head-css') --}}

    {{-- <link rel="stylesheet" href="{{ public_path('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/ltr/all.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ public_path('assets/css/custom.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/b4css/bootstrap.css') }}">


    @php
    $brandSetting = \App\Models\BrandSetting::first();
@endphp


    <style>
        body {
            background-color: #ffff;
            background-position: auto;
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url('{{$brandSetting !=null && $brandSetting->body_background != null ? asset('storage/' . $brandSetting->body_background) : asset('img/bg2.png') }}');

            /* background: url({{ public_path('img/bg2.png') }}); */
        }

        table {
            font-size: 9px;
        }

        .thead-bg {
            padding: 0;
            border: none !important;
            color: #fff;
            text-transform: uppercase;
            border-radius: 0px !important;
            /* background-repeat: no-repeat;
            background-size: auto;
            background-position: 0;
            background: url( {{ asset('img/bg2.png') }}); */
            background-color: blue !important;
        }

        .list-group-item {
            text-align: justify;
            padding: 10px;
        }

        .list-group-item::after {
            content: '';
            display: inline-block;
            width: 100%;
        }

        .text-muted {
            display: inline-block;
            text-align: left;
        }

        .font-weight-bold {
            display: inline-block;
            text-align: right;
        }

        .header,
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;

        }

        .header {
            top: 0px;
        }

        .footer {
            bottom: 0px;
        }

        .pagenum:before {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <main>
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

        <table class="table border-0">
            <thead style="border: none">
                <tr>
                    <th style="text-align: left; padding: 0">
                        <div style="display: inline-block; vertical-align: middle;">
                            <img src="{{ public_path('assets/images/hc-hub-logo3.png') }}" class="img-fluid" alt=""
                                width="150px" height="150px" style="display: inline;">
                            <h5 class="text-main" style="display: inline; margin: 0; vertical-align: middle;">Payslip
                            </h5>
                        </div>
                    </th>


                    <th style="text-align: right;">
                        <p><img src="{{ public_path('img/logo.png') }}" class="img-fluid" alt="" width="180px"
                                height="150px"></p>
                    </th>
                </tr>
            </thead>
        </table>

        <table class="table table-bordered" style="border-radius: 10px !important">
            <thead class="thead-bg">
                <tr style="background-color:#00204e;">
                    <th style="width: 33%" colspan="2">Employee Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 33%">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted text-left">Month</span>
                                <span
                                    class="font-weight-bold text-right">{{ date('M-Y', strtotime($payroll_date)) }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted text-left">Full Name</span>
                                <span class="font-weight-bold text-right">{{ $name }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Department</span>
                                <span class="font-weight-bold">{{ $department }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Position</span>
                                <span class="font-weight-bold">{{ $position }}</span>
                            </li>

                        </ul>
                    </td>

                    <td style="width: 33%">
                        <ul class="list-group list-group-flush ">

                            <li class="list-group-item d-flex">
                                <span class="text-muted">Branch</span>
                                <span class="font-weight-bold"> {{ $branch }} </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Payroll Number</span>
                                <span class="font-weight-bold"> {{ $employeeID }} </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">NSSF Number:</span>
                                <span class="font-weight-bold">{{ $membership_no }}</span>
                            </li>

                            <li class="list-group-item d-flex">
                                <span class="text-muted">Annual leave remaining</span>
                                <span class="font-weight-bold">
                                    {{ number_format($leaveBalance, 2) }} </span>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered" style="border-radius: 10px !important">
            <thead class="thead-bg">
                <tr style="background-color:#00204e;">

                    <th style="width: 50%">Earning</th>
                    <th style="width: 50%">Deduction</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                    <td style="width: 50%">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Basic Pay</span>
                                <span class="font-weight-bold"> {{ number_format($salary, 2) }} </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Net Basic</span>
                                <span class="font-weight-bold">{{ number_format($salary, 2) }} </span>
                            </li>
                            <?php foreach($allowances as $row){
                            ?>

                            <li class="list-group-item d-flex">
                                @if ($row->description == 'N-Overtime')
                                    <span class="text-muted">Normal Days Overtime</span>
                                @elseif($row->description == 'S-Overtime')
                                    <span class="text-muted">Sunday Overtime</span>
                                @else
                                    <span class="text-muted">{{ $row->description }}</span>
                                @endif
                                <span class="font-weight-bold"> {{ number_format($row->amount / $rate, 2) }} </span>
                            </li>

                            <?php } ?>

                            <li class="list-group-item bg-light mt-5 d-flex">
                                <span class="text-muted">Total Gross</span>
                                <span class="font-weight-bold"> {{ number_format($sum_allowances + $salary, 2) }}
                                </span>
                            </li>
                        </ul>
                    </td>

                    <td class="cell" style="width: 50%">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Net Tax</span>
                                <span class="font-weight-bold"> {{ number_format($taxdue, 2) }} </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">NSSF</span>
                                <span class="font-weight-bold"> {{ number_format($pension_employee, 2) }} </span>
                            </li>
                            @foreach ($deductions as $row)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">{{ $row->description }}</span>
                                    <span class="font-weight-bold"> {{ number_format($row->paid / $rate, 2) }} </span>
                                </li>
                            @endforeach
                            @foreach ($loans as $row)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">{{ $row->description }}</span>
                                    <span class="font-weight-bold">{{ number_format($row->paid / $rate, 2) }}</span>
                                </li>
                            @endforeach

                            <li class="list-group-item mt-5 bg-light">
                                <span class="text-muted">Total Deduction</span>
                                <span
                                    class="font-weight-bold">{{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}</span>
                            </li>
                        </ul>
                    </td>

                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" style="border-radius: 10px !important">
            <thead class="thead-bg">
                <tr style="background-color:#00204e;">

                    <th style="width: 50%">Taxation</th>
                    <th style="width: 50%">Summary</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                    <td style="width: 50%">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Gross pay</span>
                                <span class="font-weight-bold">
                                    {{ number_format($sum_allowances + $salary, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Less: Tax free Pension</span>
                                <span class="font-weight-bold">
                                    {{ number_format($pension_employee, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Taxable Gross</span>
                                <span class="font-weight-bold">
                                    {{ number_format($sum_allowances + $salary - $pension_employee, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">PAYE</span>
                                <span class="font-weight-bold"> {{ number_format($taxdue, 2) }}
                                </span>
                            </li>

                        </ul>
                    </td>

                    <td style="width: 50%">
                        @if ($total_bank_loan > 0)

                <li class="list-group-item d-flex">
                    <span class="font-weight-bold">Bank Loans</span>
                    <span class="font-weight-bold">.
                    </span>
                </li>

                @foreach ($bank_loan as $row)
                <li class="list-group-item d-flex">
                    <span class="text-muted">{{ $row->product }}</span>
                    <span class="font-weight-bold">{{ number_format($row->amount / $rate, 2) }}
                    </span>
                </li>

                @endforeach
                <li class="list-group-item d-flex">
                    <span class="text-muted">Total</span>
                    <span class="font-weight-bold"><?php echo number_format($total_bank_loan, 2); ?>
                    </span>
                </li>

                @endif

                <ul class="list-group list-group-flush ">
                    <li class="list-group-item d-flex">
                        <span class="text-muted">Total Income</span>
                        <span class="font-weight-bold">{{ number_format($sum_allowances + $salary, 2) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="text-muted">Total Deduction</span>
                        <span class="font-weight-bold">
                            {{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex">
                        <span class="text-muted">Net pay</span>
                        <span class="font-weight-bold">{{ number_format($amount_takehome, 2) }}</span>
                    </li>
                    @if ($total_bank_loan > 0)
                        <tr class="headers text-center">
                            <td colspan="2"> Bank Loans</td>
                        </tr>
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Bank Loans</span>
                            <span class="font-weight-bold">.</span>
                        </li>
                        @foreach ($bank_loan as $row)
                            <li class="list-group-item d-flex">
                                <span class="text-muted">{{ $row->product }}</span>
                                <span class="font-weight-bold">
                                    {{ number_format($row->amount / $rate, 2) }}
                                </span>
                            </li>
                        @endforeach
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Total Bank Loan</span>
                            <span class="font-weight-bold">
                                {{ number_format($total_bank_loan / $rate, 2) }}
                            </span>
                        </li>
                    @endif

                </ul>
                </td>
                </tr>
            </tbody>
        </table>


        <div class="footer" style="background-color: #fff">
            <table class="table footer-font">
                <tfoot>
                    <tr>
                        <td class="">
                            <div class="box-text"> {{ date('l jS \of F Y') }} </div>
                        </td>
                        <td>
                            <div class="box-text text-end"> </div>
                        </td>
                        <td>
                            <div class="box-text"> </div>
                        </td>
                        <td colspan="4" class="w-50" style="">
                            <i> Page <span class="pagenum">.</span></i>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </main>
</body>

</html>
