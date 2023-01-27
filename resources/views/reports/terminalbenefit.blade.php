<!DOCTYPE html>
<html>

<head>
    <title>ABC Bank</title>
</head>
<style type="text/css">
    * {

        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {

        padding-top: 5px;
    }

    .mt-5 {
        margin-top: -5px;
    }

    .mt-10 {
        margin-top: -1px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .h-70 {
        height: 70%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
        height: 100px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tbody tr,
    table thead th,
    table tbody td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 9px;

    }

    table tr {
        height: 2px;

    }




    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .float-right {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 30px;
    }

    footer {
        color: #777777;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: -20px;
        border-top: 1px solid #aaaaaa;
        padding: 8px 0;
        text-align: center;
    }

    table tfoot tr:first-child td {
        border-top: none;
    }

    table tfoot tr td {
        padding: 7px 8px;
    }


    table tfoot tr td:first-child {
        border: none;
    }

    .grid-container-element {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 50px;
        border: 1px solid black;
        width: 100%;
    }

    .grid-child-element1 {
        margin: 10px;
        width: 100%;
        border: 1px solid red;
    }

    .grid-child-element2 {
        margin: 10px;
        width: 100%;
        border: 1px solid red;
    }
</style>

<body>
    <div class="mt-5">
        <table class="table w-100 mt-5">
            <tfoot>

                <tr>
                    <td class="w-50">
                        <div class="box-text">
                            <img class="pl-lg" style="width: 133px;height:120px;"
                                src="https://www.bancabc.co.tz/images/banc_abc_logo.png">
                                <br>

                        </div>
                    </td>

                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td>
                        <div class="box-text">
                            <p style="text-align: center; font-weight:700">
                                AFRICAN BANKING CORPORATION<br>
                                P.O. BOX 31 ,DAR ES SALAAM
                                <br><br><br><br>
                              Name:{{ $termination->employee->fname . ' ' . $termination->employee->mname . ' ' . $termination->employee->lname }}  </p>

                        </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>


                    <td colspan="2" class="w-50" style="">
                        <div class="" style="text-align: right; padding-right:20px">

                            <p> <strong>Terminal Benefit</strong></p>

                            <p> <strong>Employment Date : {{ $termination->employee->hire_date }}</strong></p>
                            <p> <strong>Termination Date :{{ $termination->terminationDate }} </strong></p>

                            <p> <strong>Department :{{ $employee_info[0]->deptname }} </strong></p>
                            <p><strong>Payroll Number : {{ $termination->employee->payroll_no }}</strong></p>

                        </div>
                    </td>
                </tr>

            </tfoot>
        </table>



        {{-- <div style="clear: both;"></div> --}}
    </div>
    <div class="table-section bill-tbl w-100 mt-10">

        <table class="table w-100  mt-10">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            PAYMENTS</h5>
                    </td>
                </tr>
                <tr class="p-1">
                    <td class="w-50">Salary Enrollment</td>
                    <td style="text-align: right;">{{ number_format($termination->salaryEnrollment, 2) }}</td>
                </tr>
                <tr>
                    <td class="w-50">Overtime Normal Days</td>
                    <td style="text-align: right;">{{ number_format($termination->normal_days_overtime_amount, 2) }}</td>
                </tr>

                <tr>
                    <td class="w-50">Overtime Public</td>
                    <td style="text-align: right;">{{ number_format($termination->public_overtime_amount, 2) }}</td>
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
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            TAXATION</h5>
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
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            DEDUCTION</h5>
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
                    <td style="text-align: right;">{{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}

                </tr>

                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            SUMMARY</h5>
                    </td>
                </tr>
                <tr>
                    <td><b>TOTAL GROSS<b></td>
                    <td style="text-align: right;">{{ number_format($termination->total_gross, 2) }}</td>
                </tr>
                <tr>
                    <td><b>Total DEDUCTIONS</b></td>
                    <td style="text-align: right;">{{ number_format($termination->pension_employee + $termination->paye + $termination->otherDeductions + $termination->loan_balance, 2) }}
                    </td>
                </tr>

                <tr>

                    <td><b>NET PAY </b> </td>
                    <td style="text-align: right;">{{ number_format($termination->taxable - $termination->paye, 2) }}
                    </td>
                </tr>

                <tr>
                    <td><b>TAKE HOME AFTER LOAN DEDUCTION </b></td>
                    <td style="text-align: right;">{{ number_format($termination->taxable - $termination->paye - $termination->loan_balance, 2) }}
                    </td>

                </tr>
                {{-- <tr>
                    <td>Take home</td>
                    <td>{{ number_format($termination->taxable - $termination->paye - $termination->loan_balance, 2) }}
                    </td>


                </tr> --}}



            </tbody>
        </table>
    </div>




    <div class="table-section bill-tbl w-100 mt-10">


        <table class="table w-100 mt-10">
            <tr>

                <td style="width: 50%;">
                    <div class="left" style="padding:1px 0px;">

                        <div>
                            <h4 class="mt-3" style="border-bottom: 3px  !important;"><b>Employee
                                    Signature:_______________________________________________</b></h4>
                        </div>


                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="left" style="padding:1px 0px;">
                        <div>
                            <h4 class="mt-3" style="border-bottom: 3px  !important;"><b>Employer's
                                    Signature:_______________________________________________</b></h4>
                        </div>

                    </div>
                </td>
            </tr>



        </table>


    </div>


</body>

</html>
