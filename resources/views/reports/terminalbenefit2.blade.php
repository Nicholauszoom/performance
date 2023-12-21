<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Terminal Benefit</title>

    {{-- @include('layouts.shared.head-css') --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/b4css/bootstrap.css') }}">

    <style>
        body {
            background-color: #ffff;
            background-position: auto;
            background-repeat: no-repeat;
            background-size: cover;
            background: url({{ public_path('img/bg2.png') }});
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

        ?>

<table class="table border-0">
    <thead style="border: none">
        <tr>
            <th style="text-align: left; padding: 0">
                <div style="display: inline-block; vertical-align: middle;">
                  <img src="{{ public_path('assets/images/hc-hub-logo3.png') }}" class="img-fluid" alt="" width="150px" height="150px" style="display: inline;">
                  <h5 class="text-main" style="display: inline; margin: 0; vertical-align: middle;">Terminal Benefit Slip</h5>
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
                    <th colspan="2">Employee Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:50%">


                        <ul class="list-group ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted text-left">Full Name</span>
                                <span
                                    class="font-weight-bold text-right">{{ $termination->employee->fname . ' ' . $termination->employee->mname . ' ' . $termination->employee->lname }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Department</span>
                                <span class="font-weight-bold">{{ $employee_info[0]->deptname }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Employment Date</span>
                                <span class="font-weight-bold">{{ $termination->employee->hire_date }}</span>
                            </li>



                        </ul>
                    </td>

                    <td style="width:50%">


                        <ul class="list-group ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Termination Date</span>
                                <span class="font-weight-bold"> {{ $termination->terminationDate }} </span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Payroll Number</span>
                                <span class="font-weight-bold"> {{ $termination->employeeID }} </span>
                            </li>
                            @if ($termination->leaveStand != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Leave & 0/stand</span>
                                    <span
                                        class="font-weight-bold">{{ number_format($termination->leaveStand, 2) }}</span>
                                </li>
                            @endif

                        </ul>
                    </td>


                </tr>
            </tbody>
        </table>

        <table class="table table-bordered" style="border-radius: 10px !important">
            <thead class="thead-bg">
                <tr style="background-color:#00204e;">
                    <th style="width: 50%">Payments</th>
                    <th style="width: 50%">Taxation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 33%">
                        <ul class="list-group">
                            @if ($termination->salaryEnrollment != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Salary Emoluments</span>
                                    <span class="font-weight-bold">{{ number_format($termination->salaryEnrollment, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->normal_days_overtime_amount != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Overtime Normal Days</span>
                                    <span
                                        class="font-weight-bold">{{ number_format($termination->normal_days_overtime_amount, 2) }}  </span>
                                </li>
                            @endif
                            @if ($termination->public_overtime_amount != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Overtime Public</span>
                                    <span class="font-weight-bold">{{ number_format($termination->public_overtime_amount, 2) }} </span>
                                </li>
                            @endif
                            @if ($termination->noticePay != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Notice Payment</span>
                                    <span class="font-weight-bold">{{ number_format($termination->noticePay, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->leavePay != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Outstanding Leave Pay</span>
                                    <span class="font-weight-bold">{{ number_format($termination->leavePay, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->serevanceCost != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">House Allowance</span>
                                    <span class="font-weight-bold">{{ number_format($termination->serevanceCost, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->livingCost != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Cost of Living</span>
                                    <span class="font-weight-bold">{{ number_format($termination->livingCost, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->utilityAlloacance != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Utility Allowance</span>
                                    <span class="font-weight-bold">{{ number_format($termination->utilityAllowance, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->leaveAllowance != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Leave Allowance</span>
                                    <span class="font-weight-bold">{{ number_format($termination->leaveAllowance, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->severanceCost != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Serevance Pay</span>
                                    <span class="font-weight-bold">{{ number_format($termination->serevanceCost, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->tellerAllowance != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Teller Allowance</span>
                                    <span class="font-weight-bold">{{ number_format($termination->tellerAllowance, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->arrears != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Arrears</span>
                                    <span class="font-weight-bold">{{ number_format($termination->arrears, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->exgracia != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Discr Exgracia</span>
                                    <span class="font-weight-bold">{{ number_format($termination->exgracia, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->bonus != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Bonus</span>
                                    <span class="font-weight-bold">{{ number_format($termination->bonus, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->transport_allowance != 0)
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Transport Allowance</span>
                                <span class="font-weight-bold">{{ number_format($termination->transport_allowance, 2) }}</span>
                            </li>
                        @endif
                        @if ($termination->nightshift_allowance != 0)
                        <li class="list-group-item d-flex">
                            <span class="text-muted">Night Shift Allowance</span>
                            <span class="font-weight-bold">{{ number_format($termination->nightshift_allowance, 2) }}</span>
                        </li>
                    @endif
                            @if ($termination->longServing != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Long Serving</span>
                                    <span class="font-weight-bold">{{ number_format($termination->longServing, 2) }}</span>
                                </li>
                            @endif
                            @if ($termination->otherPayments != 0)
                                <li class="list-group-item d-flex">
                                    <span class="text-muted">Other Non Taxable Payments </span>
                                    <span
                                        class="font-weight-bold">{{ number_format($termination->otherPayments, 2) }}</span>
                                </li>
                            @endif
                        </ul>

                    </td>

                    <td class="cell" style="width: 33%">
                        <ul class="list-group ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted"><b>TOTAL GROSS</b></span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->total_gross, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Pension</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->pension_employee, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex">

                                <span class="text-muted">Taxable Gross Pay</span>
                                <span class="font-weight-bold">{{ number_format($termination->taxable, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex">
                                <span class="text-muted">P.A.Y.E</span>
                                <span class="font-weight-bold">{{ number_format($termination->paye, 2) }}</span>
                            </li>


                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered" style="border-radius: 10px !important">
            <thead class="thead-bg">
                <tr style="background-color:#00204e;">
                    <th style="width: 50%">Deduction</th>
                    <th style="width: 50%">Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <td style="width: 50%">
                        <ul class="list-group ">

                            <li class="list-group-item d-flex">
                                <span class="text-muted">P.A.Y.E</span>
                                <span class="font-weight-bold">{{ number_format($termination->paye, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Outstanding Loan Balance</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->loan_balance, 2) }}</span>
                            </li>

                            <li class="list-group-item d-flex">

                                <span class="text-muted">Pension</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->pension_employee, 2) }}</span>
                            </li>
                             @if($termination->salaryAdvance != 0)
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Salary Advances</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->salaryAdvance, 2) }}</span>
                            </li>
                            @endif
                            @if($termination->otherDeductions != 0)
                            <li class="list-group-item d-flex">
                                <span class="text-muted">Any Other Deductions</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->otherDeductions, 2) }}</span>

                            </li>
                            @endif
                            <li class="list-group-item d-flex">
                                <span class="text-muted"><b>TOTAL DEDUCTION</b></span>
                                <span class="font-weight-bold">
                                    {{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}
                                </span>
                            </li>


                        </ul>
                    </td>
                    <td style="width: 50%">


                        <ul class="list-group ">
                            <li class="list-group-item d-flex">
                                <span class="text-muted">TOTAL GROSS</span>
                                <span
                                    class="font-weight-bold">{{ number_format($termination->total_gross, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex">
                                <span class="text-muted">TOTAL DEDUCTIONS</span>
                                <span class="font-weight-bold">
                                    {{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions, 2) }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex">

                                <span class="text-muted">NET PAY </span>
                                <span class="font-weight-bold">
                                    {{ number_format($termination->total_gross - ($termination->pension_employee + $termination->paye + $termination->otherDeductions), 2) }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex">
                                <span class="text-muted">TAKE HOME </span>
                                <span class="font-weight-bold">
                                    {{ number_format($termination->taxable - $termination->paye - $termination->loan_balance-$termination->otherDeductions, 2) }}
                                </span>

                            </li>

                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>





        <table class="table border-0 mt-2"class="table border-0 mt-2" style="border: 0px !important">
            <thead class="border-0" style="border: 0px !important">
                <tr class="border-0" style="border: 0px !important">
                    <td class="pt-3">
                        <div class="text-muted">Employee Signature </div>
                        <div class="font-weight-bold">
                            __________________
                        </div>

                    </td>

                    <td class="text-right pt-3">
                        <div class="text-muted">Employer Signature </div>
                        <div class="font-weight-bold">
                            __________________
                        </div>

                    </td>

                </tr>
            </thead>
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
