<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary Slip</title>
    @include('layouts.shared.head-css')
    <script src="{{ asset('assets/notification/js/bootstrap-growl.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notification.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">
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
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 px-0 pt-0 pb-5">
            <div class="card-header border-0">
                <h5 class="text-main">Payslip<small></small></h5>
            </div>

            <div class="card rounded-0" style="background: #fff !important;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Payslip For the month : {{ date('M-Y', strtotime($payroll_date)) }}</h5>

                    <p> <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="" width="100px"
                            height="100px"></p>
                </div>

                <div class="card-body bg-light p-2">
                    <div class="row row-cols-sm-3">



                        <table>
                            <tr>
                                <td>
                                    <div class="col-sm">
                                        <div class="card h-sm-100 mb-sm-0" style="background: #fff !important">


                                            <div class="card-header bg-white p-0 px-2 pt-2">
                                                <h5 class="card-title">Employee Details</h5>
                                            </div>

                                            <ul class="list-group list-group-flush ">
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Full Name</span>
                                                    <div class="ms-auto fw-semibold">{{ $name }}</div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Department</span>
                                                    <div class="ms-auto fw-semibold">{{ $department }}</div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Position</span>
                                                    <div class="ms-auto fw-semibold">{{ $position }}</div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Branch</span>
                                                    <div class="ms-auto fw-semibold"> {{ $branch }} </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Payroll Number</span>
                                                    <div class="ms-auto fw-semibold"> {{ $employeeID }} </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">NSSF Number:</span>
                                                    <div class="ms-auto fw-semibold">{{ $membership_no }}</div>
                                                </li>

                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Annual leave remaining</span>
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($leaveBalance, 2) }} </div>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm">

                                        <div class="card h-sm-100 mb-sm-0" style="background: #fff !important">

                                            <div class="card-header bg-white p-0 px-2 pt-2">
                                                <h5 class="card-title">Earnings</h5>
                                            </div>


                                            <ul class="list-group list-group-flush ">
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Basic Pay</span>
                                                    <div class="ms-auto fw-semibold">{{ number_format($salary, 2) }}
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Net Basic</span>
                                                    <div class="ms-auto fw-semibold">{{ number_format($salary, 2) }}
                                                    </div>
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
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($row->amount / $rate, 2) }}</div>
                                                </li>

                                                <?php } ?>
                                            </ul>

                                            <div class="card-footer d-flex justify-content-between border-top bg-white">
                                                <span class="text-muted">Total</span>
                                                <span class="hstack gap-1">
                                                    <span
                                                        class="text-muted ms-1">{{ number_format($sum_allowances + $salary, 2) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm">
                                        <div class="card  h-sm-100 mb-sm-0" style="background: #fff !important">

                                            <div class="card-header bg-white p-0 px-2 pt-2">
                                                <h5 class="card-title">Deductions</h5>
                                            </div>

                                            <ul class="list-group list-group-flush ">
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Net Tax</span>
                                                    <div class="ms-auto fw-semibold">{{ number_format($taxdue, 2) }}
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">NSSF</span>
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($pension_employee, 2) }}</div>
                                                </li>
                                                @foreach ($deductions as $row)
                                                    <li class="list-group-item d-flex">
                                                        <span class="text-muted">{{ $row->description }}</span>
                                                        <div class="ms-auto fw-semibold">
                                                            {{ number_format($row->paid / $rate, 2) }}</div>
                                                    </li>
                                                @endforeach
                                                @foreach ($loans as $row)
                                                    <li class="list-group-item d-flex">
                                                        <span class="text-muted">{{ $row->description }}</span>
                                                        <div class="ms-auto fw-semibold">
                                                            {{ number_format($row->paid / $rate, 2) }}</div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="card-footer d-flex justify-content-between border-top bg-white">
                                                <span class="text-muted">Total Deduction</span>
                                                <span class="hstack gap-1">
                                                    <span
                                                        class="text-muted ms-1">{{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>




                    </div>
                </div>

                <div class="card-body p-2">
                    <div class="row row-cols-sm-3">


                        <table>
                            <tr>
                                <td>
                                    <div class="col-sm">
                                        <div class="card h-sm-100 mb-sm-0">
                                            <div class="card-header bg-white p-0 px-2 pt-2">
                                                <h5 class="card-title">Taxation</h5>
                                            </div>

                                            <ul class="list-group list-group-flush ">
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Gross pay</span>
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($sum_allowances + $salary, 2) }}
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Less: Tax free Pension</span>
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($pension_employee, 2) }}</div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">Taxable Gross</span>
                                                    <div class="ms-auto fw-semibold">
                                                        {{ number_format($sum_allowances + $salary - $pension_employee, 2) }}
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex">
                                                    <span class="text-muted">PAYE</span>
                                                    <div class="ms-auto fw-semibold"> {{ number_format($taxdue, 2) }}
                                                    </div>
                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm">

                                        <div class="card  h-sm-100 mb-sm-0">

                                            <div class="card-header bg-white p-0 px-2 pt-2">
                                                <h5 class="card-title">Summary</h5>
                                            </div>


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


                            <ul class="list-group list-group-flush ">
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Total Income</span>
                                    <div class="ms-auto fw-semibold">{{ number_format($sum_allowances + $salary, 2) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Total Deduction</span>
                                    <div class="ms-auto fw-semibold">
                                        {{ number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2) }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Net pay</span>
                                    <div class="ms-auto fw-semibold">{{ number_format($amount_takehome, 2) }}</div>
                                </li>
                                @if ($total_bank_loan > 0)
                                    <tr class="headers text-center">
                                        <td colspan="2"> Bank Loans</td>
                                    </tr>
                                    <li class="list-group-item d-flex">
                                        <span class="text-muted">Bank Loans</span>
                                        <div class="ms-auto fw-semibold">.</div>
                                    </li>
                                    @foreach ($bank_loan as $row)
                                        <li class="list-group-item d-flex">
                                            <span class="text-muted">{{ $row->product }}</span>
                                            <div class="ms-auto fw-semibold">
                                                {{ number_format($row->amount / $rate, 2) }}
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item d-flex">
                                        <span class="text-muted">Total Bank Loan</span>
                                        <div class="ms-auto fw-semibold">
                                            {{ number_format($total_bank_loan / $rate, 2) }}
                                        </div>
                                    </li>
                                @endif

                            </ul>

                            {{-- <div class="card-footer d-flex justify-content-between border-top" >
                    <span class="text-muted">Total Deduction</span>
                    <span class="hstack gap-1">
                    <span class="text-muted ms-1">ff</span>
                    </span>
                </div> --}}
                    </div>
                </div>
                </td>
                <td>
                    {{-- <div class="col-sm">
                <div class="card  h-sm-100 mb-sm-0">

                    <div class="card-header bg-white p-0 px-2 pt-2">
                        <h5 class="card-title">Take Home</h5>
                    </div>

                    <ul class="list-group list-group-flush ">
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Take home</span>
                            <div class="ms-auto fw-semibold">{{ number_format($amount_takehome, 2) }}</div>
                        </li>
                        @if ($total_bank_loan > 0)
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Take Home After Loan Deductions</span>
                            <div class="ms-auto fw-semibold">{{ number_format($amount_takehome - $total_bank_loan, 2) }}</div>
                        </li>

                    @endif

                        <li class="list-group-item d-flex">
                            <span class="text-muted">Method of Payment:</span>
                            <div class="ms-auto fw-semibold">Bank</div>
                        </li>
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Account No:</span>
                            <div class="ms-auto fw-semibold">{{ $account_no }}</div>
                        </li>

                    </ul>
                </div>
            </div> --}}

                    <div class="col-sm">
                        <div class="card  h-sm-100 mb-sm-0">

                            <div class="card-header bg-white p-0 px-2 pt-2">
                                <h5 class="card-title">Take Home</h5>
                            </div>

                            <div class="card-body d-flex text-center align-items-center justify-content-center">
                                <b>{{ number_format($amount_takehome, 2) }} /=
                                    @if ($rate == 1)
                                        Tsh
                                    @else
                                        USD
                                    @endif <br />
                                    {{ date('d-M-Y', strtotime($payroll_date)) }}
                                </b>
                            </div>
                        </div>
                    </div>
                </td>
                </tr>
                </table>







            </div>
        </div>
        </div>


        </div>


    </main>


    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
