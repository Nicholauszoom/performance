<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Terminal Benefits</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">






</head>


<body>

    <div style="margin-top:20px;">
        <div class="col-md-12">
            <table class="table" id="img">
                <tfoot>
                    <tr>
                        <td class="">
                            <div class="box-text text-right" style="text-align:left;">

                                <p style="font-weight:bolder;">Terminal Benefit</p>

                                <p class="p-space">
                                    Name:{{ $termination->employee->fname . ' ' . $termination->employee->mname . ' ' . $termination->employee->lname }}
                                </p>
                                <p class="p-space">Employment Date : {{ $termination->employee->hire_date }}</p>
                                <p class="p-space">Termination Date :{{ $termination->terminationDate }} </p>

                                <p class="p-space">Department :{{ $employee_info[0]->deptname }} </p>
                                <p class="p-space">Payroll Number : {{ $termination->employee->payroll_no }}</p>
                            </div>
                        </td>
                        <td> </td>
                        <td>
                            <div class="box-text"> </div>
                        </td>

                        <td colspan="4" class="w-50" style="">
                            <div class="box-text text-end">
                                @if ($brandSetting->report_logo)
                                <img src="{{ asset('storage/' . $brandSetting->report_logo) }}" alt="logo here" width="180px" height="150px" class="image-fluid">          
                                @else
                                <img src="{{ public_path('assets/images/logo-dif2.png') }}" alt="logo here" width="180px" height="150px" class="image-fluid">          
                                @endif
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

<hr>
            <table class="table" id="reports" style="font-size:10px;  ">
                <tbody>
                    <tr>
                        <td colspan="2"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            <p class="text-center p-1">
                                PAYMENTS</p>
                        </td>
                    </tr>
                    <tr class="p-1">
                        <td class="w-50">Salary Enrollment</td>
                        <td style="text-align: right;">{{ number_format($termination->salaryEnrollment, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Overtime Normal Days</td>
                        <td style="text-align: right;">{{ number_format($termination->normal_days_overtime_amount, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="w-50">Overtime Public</td>
                        <td style="text-align: right;">{{ number_format($termination->public_overtime_amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="w-50">Notice Payment</td>
                        <td style="text-align: right;">{{ number_format($termination->noticePay, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Outstanding Leave Pay</td>
                        <td style="text-align: right;">{{ number_format($termination->leavePay, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">House Allowance</td>
                        <td style="text-align: right;">{{ number_format($termination->serevanceCost, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Cost of Living</td>
                        <td style="text-align: right;">{{ number_format($termination->livingCost, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Utility Allowance</td>
                        <td style="text-align: right;">{{ number_format($termination->utilityAllowance, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Leave Allowance</td>
                        <td style="text-align: right;">{{ number_format($termination->leaveAllowance, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Serevance Pay</td>
                        <td style="text-align: right;">{{ number_format($termination->serevanceCost, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Leave & 0/stand</td>
                        <td style="text-align: right;">{{ number_format($termination->leaveStand, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Teller Allowance</td>
                        <td style="text-align: right;">{{ number_format($termination->tellerAllowance, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Arrears</td>
                        <td style="text-align: right;">{{ number_format($termination->arrears, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Discr Exgracia</td>
                        <td style="text-align: right;">{{ number_format($termination->exgracia, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Bonus</td>
                        <td style="text-align: right;">{{ number_format($termination->bonus, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Long Serving</td>
                        <td style="text-align: right;">{{ number_format($termination->longServing, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Other Non Taxable Payments </td>
                        <td style="text-align: right;">{{ number_format($termination->otherPayments, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            <p class="text-center p-1">
                                TAXATION</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="w-50"><b>TOTAL GROSS</b></td>
                        <td style="text-align: right;">{{ number_format($termination->total_gross, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="w-50">Pension</td>
                        <td style="text-align: right;">{{ number_format($termination->pension_employee, 2) }}</td>
                    </tr>

                    <tr>

                        <td class="w-50">Taxable Gross Pay</td>
                        <td style="text-align: right;">{{ number_format($termination->taxable, 2) }}</td>
                    </tr>

                    <tr>
                        <td class="w-50">P.A.Y.E</td>
                        <td style="text-align: right;">{{ number_format($termination->paye, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="text-center"
                                style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                                DEDUCTION</p>
                        </td>
                    </tr>
                    <tr>
                        <td>P.A.Y.E</td>
                        <td style="text-align: right;">{{ number_format($termination->paye, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Outstanding Loan Balance</td>
                        <td style="text-align: right;">{{ number_format($termination->loan_balance, 2) }}</td>
                    </tr>

                    <tr>

                        <td>Pension</td>
                        <td style="text-align: right;">{{ number_format($termination->pension_employee, 2) }}</td>
                    </tr>

                    <tr>
                        <td>Salary Advances</td>
                        <td style="text-align: right;">{{ number_format($termination->salaryAdvance, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Any Other Deductions</td>
                        <td style="text-align: right;">{{ number_format($termination->otherDeductions, 2) }}</td>

                    </tr>
                    <tr>
                        <td><b>TOTAL DEDUCTION</b></td>
                        <td style="text-align: right;">
                            {{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}

                    </tr>

                    <tr>
                        <td colspan="2"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            <p class="text-center p-1">
                                SUMMARY</p>
                        </td>
                    </tr>
                    <tr>
                        <td><b>TOTAL GROSS<b></td>
                        <td style="text-align: right;">{{ number_format($termination->total_gross, 2) }}</td>
                    </tr>
                    <tr>
                        <td><b>TOTAL DEDUCTIONS</b></td>
                        <td style="text-align: right;">
                            {{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions, 2) }}
                        </td>
                    </tr>

                    <tr>

                        <td><b>NET PAY </b> </td>
                        <td style="text-align: right;">
                            {{ number_format($termination->taxable - $termination->paye, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td><b>TAKE HOME AFTER LOAN DEDUCTION </b></td>
                        <td style="text-align: right;">
                            {{ number_format($termination->taxable - $termination->paye - $termination->loan_balance, 2) }}
                        </td>

                    </tr>
                    {{-- <tr>
                    <td>Take home</td>
                    <td>{{ number_format($termination->taxable - $termination->paye - $termination->loan_balance, 2) }}
                    </td>


                </tr> --}}



                </tbody>
            </table>
            <hr>
            <table class="table" id="reports">
                <tbody>
                    <tr>

                        <td>
                            <h4 class="mt-3" style="border-bottom: 3px  !important;"><b>Employee
                                    Signature:____________</b></h4>
                        </td>
                        <td>
                            <p class="text-start"><small></small></p>
                        </td>
                        <td>
                            <h4 class="mt-3" style="border-bottom: 3px  !important;"><b>Employer's
                                    Signature:____________</b></h4>
                        </td>

                    </tr>


                </tbody>
            </table>
        </div>
    </div>







</body>

</html>
