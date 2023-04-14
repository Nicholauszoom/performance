<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style type="text/css">
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

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
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
        font-size: 13px;
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

    @php $name='';
    $pension_number='';
    $contribution_date='';
    $emp_id='';
    $total_salary = 0;
    $total_pension = 0;
    $gland_total_salary = 0;
    $gland_total_pension = 0;

    foreach($employee_pension as $row) {
        $total_salary +=$row->salary;
        $total_pension += $row->pension_employer;
        $name=$row->name;
        $emp_id=$row->emp_id;
        $pension_number=$row->pf_membership_no;
        $contribution_date=$row->hire_date;

    }

    @endphp
</style>

<body>

    <div class="head-title">
        <hr>
        <p class="text-center m-0 p-0">National Social Security Fund</p>
        <p class="text-center m-0 p-0">FORM NSSF/B. 132</p>
        <hr>
    </div>

    <div class="add-detail ">
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tbody>
                <tr>
                    <th class="w-50"></th>
                    <th class="w-50"></th>
                </tr>
                <tr>
                    <td>
                        <div class="box-text">
                            <p> <strong>Employee :{{ $name }}</strong></p>
                            <p> <strong>Membership Number : {{ $pension_number }}</strong></p>
                            <p> <strong>Name Of Employer : African banking Corporation</strong></p>

                            <p> <strong>Contribution Date : {{ $contribution_date }}</strong></p>
                            <p> <strong>Date Of Leaving :______________________</strong></p>
                        </div>
                    </td>
                    <td>
                        <div class="box-text">
                            <p></p>
                            <p></p>
                            <p> <strong>Employer Number :______________</strong></p>
                            <p></p>
                            <p> </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="table-section bill-tbl w-100 mt-10">
        @foreach($years as $year)
        <h5><b>YEAR: {{ $year->years }}</b></h5>
        <table class="table w-100 mt-10" style="font-size: 6px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Month</th>
                    <th>NSSF Number</th>
                    <th>Income</th>
                    <th>Employee Contrib</th>
                    <th>Employer Contrib</th>
                    <th>Total</th>
                    <th>Receipt No</th>
                    <th>Receipt Date</th>
                </tr>
            </thead>
            <tbody>

                @foreach($employee_pension as $row)
                @if($row->years == $year->years)
                <tr>
                    <td>No</td>
                    <td >{{ date('M',strtotime($row->payment_date)) }}</td>
                    <td >{{ $row->pf_membership_no }}</td>
                    <td >{{ number_format($row->salary,2) }}</td>
                    <td >{{ number_format($row->pension_employer,2) }}</td>
                    <td >{{ number_format($row->pension_employer,2) }}</td>
                    <td >{{ number_format($row->pension_employer*2,2) }}</td>
                    <td >{{ $row->receipt_no }}</td>
                    <td >{{ $row->receipt_date }}</td>
                </tr>
                @endif
                @endforeach
                 <?php $gland_total_salary +=$total_salary;  $gland_total_pension +=$total_pension;

                 ?>
                <tr>
                    <td colspan="3">TOTAL</td>

                    <td>{{ number_format($total_salary,2) }}</td>
                    <td>{{ number_format($total_pension,2) }}</td>
                    <td>{{ number_format($total_pension,2) }}</td>
                    <td class="  ">{{ number_format($total_pension*2,2) }}</td>
                    <td class="  "></td>
                    <td class="  "></td>
                </tr>
            </tbody>


        </table>
        @endforeach
        <hr>
        <table class="table w-100 mt-10" style="font-size: 12px;">
            <tbody>
                    <td colspan="3">GRAND TOTAL</td>

                    <td>SALARY::{{ number_format($gland_total_salary,2) }}</td>
                    <td>PENSION EMPLOYEE: {{ number_format($gland_total_pension,2) }}</td>
                    <td>PENSION EMPLOYER: {{ number_format($gland_total_pension,2) }}</td>
                    <td>TOTAL CONTRIBUTION: {{ number_format($gland_total_pension*2,2) }}</td>
                    <td></td>
                    <td></td>
                </tbody>
                </table>
        <table class="table w-100 mt-10">
            <tr>
                <td style="width: 50%;">
                    <div class="left" style="">

                        <div><b><i>Signature</i></b>:_______________________</div>
                        <div><b><i>Employer Stamp<i></b>: ________________________ </div>
                        <div><b><i>Contribution verified by:<i></b>______________________        <b><i>Name:<i></b> _________________________________</div>
                        <div></div>
                        <div></div>
                    </div>
            </tr>



        </table>


    </div>

</body>

</html>
