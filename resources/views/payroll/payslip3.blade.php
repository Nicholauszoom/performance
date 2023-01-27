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

                            <p> <strong>Slary Slip</strong></p>
                            <p>For month : {{ date('M-Y',strtotime($payroll_date)) }}</p>
                            <p> <strong>Name:  <?php echo $name; ?></strong></p>
                            <p><strong>Employment Date: {{ date('d-M-Y',strtotime($hiredate)) }}</strong></p>
                            <p> <strong>Job Title: <?php echo $position; ?> </strong></p>
                            <p> Location:  <?php echo $branch; ?></p>

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
                            Net Basic Calculations</h5>
                    </td>
                </tr>
                <tr class="p-1">
                    <td class="w-50">Basic Pay</td>
                    <td style="text-align: right;"><?php echo number_format($salary, 2); ?></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            Payments</h5>
                    </td>
                </tr>
                <tr>
                    <td class="w-50"><b>Net Basic</b></td>
                    <td style="text-align: right;"><?php echo number_format($salary, 2); ?></td>
                </tr>
                <?php foreach($allowances as $row){
                    ?>
                     <tr>
                        <td class="w-50"><?php echo $row->description; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row->amount / $rate, 2); ?></td>
                    </tr>

                    <?php } ?>

                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            Taxation</h5>
                    </td>
                </tr>

                <tr>
                    <td>Gross pay</td>
                    <td style="text-align: right;"><?php echo number_format($sum_allowances + $salary, 2); ?></td>
                </tr>
                <tr>
                    <td>Less: Tax free Pension</td>
                    <td style="text-align: right;"><?php echo number_format($pension_employee, 2); ?></td>
                </tr>

                <tr>

                    <td>Taxable Gross</td>
                    <td style="text-align: right;"><?php echo number_format($sum_allowances + $salary - $pension_employee, 2); ?></td>
                </tr>

                <tr>
                    <td>PAYE</td>
                    <td style="text-align: right;"><?php echo number_format($taxdue, 2); ?></td>
                </tr>


                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            Deduction</h5>
                    </td>
                </tr>
                <tr>
                    <td><b>Net Tax<b></td>
                    <td style="text-align: right;"><?php echo number_format($taxdue, 2); ?></td>
                </tr>
                <tr>
                    <td><b>NSSF</b></td>
                    <td style="text-align: right;"><?php echo number_format($pension_employee, 2); ?>
                    </td>
                </tr>


                @foreach($deductions as $row)
                <tr>

                    <td><b>{{ $row->description }} </b> </td>
                    <td style="text-align: right;">{{ number_format($row->paid/$rate, 2) }}
                    </td>
                </tr>

                @endforeach
                @foreach($loans as $row)
                <tr>

                    <td><b>{{ $row->description }} </b> </td>
                    <td style="text-align: right;">{{ number_format($row->paid/$rate, 2) }}
                    </td>
                </tr>

                @endforeach

                <tr>

                    <td><b>Total Deduction </b> </td>
                    <td style="text-align: right;"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            Summary</h5>
                    </td>
                </tr>
                <tr>
                    <td><b>Total Income<b></td>
                    <td style="text-align: right;"><?php echo number_format($salary, 2); ?></td>
                </tr>
                <tr>
                    <td><b>Total Deduction</b></td>
                    <td style="text-align: right;"><?php echo number_format($pension_employee + $taxdue + $sum_deductions + $sum_loans + $meals, 2); ?>
                    </td>
                </tr>

                <tr>

                    <td><b>Net pay </b> </td>
                    <td style="text-align: right;"><?php echo number_format($amount_takehome, 2); ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h5 class="text-center p-1"
                            style="background-color:  rgb(64, 190, 199) !important;font-weight:bolder !important; ">
                            Take Home</h5>
                    </td>
                </tr>
                <tr>
                    <td><b>Take home<b></td>
                    <td style="text-align: right;"><?php echo number_format($amount_takehome, 2); ?></td>
                </tr>
                <tr>
                    <td><b>NSSF Number:</b></td>
                    <td style="text-align: right;"><?php echo $membership_no; ?>
                    </td>
                </tr>

                <tr>

                    <td><b>Method of Payment:  </b> </td>
                    <td style="text-align: right;">Bank
                    </td>
                </tr>
                <tr>

                    <td><b>Account No:  </b> </td>
                    <td style="text-align: right;"><?php echo $account_no; ?>
                    </td>
                </tr>





            </tbody>
        </table>
    </div>




    <div class="table-section bill-tbl w-100 mt-10">


        <table class="table w-100 mt-10">
            <tr>

                <td style="width: 100%;">
                    <div class="left" style="padding:1px 0px;">

                        <div>
                            <p class="fw-bold font-italic">
                                "Use your BancABC Mobi to pay for your <br>
                                bills such as LUKU,WATER BILLS, SUBSCRIPTION, GEPG <br>
                                and many more by simply dialing *150*34#
                            </p>
                        </div>


                    </div>
                </td>

            </tr>



        </table>


    </div>


</body>

</html>
