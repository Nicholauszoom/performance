<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
</head>

<body>

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>

        <div style="margin-top:20px;">
            <div class="col-md-12">

                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">HC-HUB</h5>
                                    </p>
                                    <p class="p-space">5th & 6th Floor, Uhuru Heights</p>
                                    <p class="p-space">Bibi Titi Mohammed Road</p>
                                    <p class="p-space">P.O. Box 31, Dar es salaam </p>

                                    <p class="p-space">+255 22 22119422/2111990 </p>
                                    <p class="p-space"> web:<a href="www.bancabc.co.tz">www.bancabc.co.tz</a></p>

                                </div>
                            </td>
                            <td> </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="box-text text-end">
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="180px"
                                        height="150px" class="image-fluid">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <table class="table" style="background-color: #165384; color:white">
                    <thead>
                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <h5 style="font-weight:bolder;text-align: left;"> Pension Report </h5>
                                </div>
                            </td>
                            <td>
                                <div class="box-text text-end"></div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the month of
                                    {{ date('M-Y', strtotime($payroll_date)) }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>

                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">

                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">


                            <th>S/No</th>
                            <th><b>Pay No</b></th>
                            <th><b>Member No</b></th>
                            <th  style="margin-bottom: 30px;" class="text-center"><b>Full Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Gross Salary</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Contribution</b></th>


                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        $total_contribution = 0;
                        $total_salary = 0;
                        if(!empty($pension)){
                        foreach ($pension as $row){
                            $salary= $row->salary + $row->allowances;
                            if($salary != 0){
                            $name = $row->name;
                            $member_no = $row->pf_membership_no;

                            //if($salary == 0)dd($row->emp_id);
                            $rate1= ($row->pension_employee/$salary);
                            $rate2= ($row->pension_employee/$salary);
                            $amount1= $row->pension_employee;
                            $amount2= $row->pension_employee;
                            $contribution= (2*$row->pension_employee);
                            $total_contribution +=$contribution;
                            $total_salary += $salary

                        ?>

                        <tr>
                            <td>{{ $row->SNo }}</td>
                            <td>{{ $row->emp_id }}</td>
                            <td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
                            <td>{{ $row->name }}</td>
                            <td hidden>{{ $row->mname }}</td>
                            <td hidden>{{ $row->lname }}</td>
                            <td align="right">{{ number_format($salary,2) }}</td>
                            <td align="right">{{ number_format($total_contribution,2) }}</td>


                        </tr>
                        <?php }}} ?>


                        <?php
                        if(!empty($pension_termination)){
                        foreach ($pension_termination as $row2){
                            $salary= $row2->total_gross;
                            if($salary != 0){
                            $name = $row2->name;
                            $member_no = $row2->pf_membership_no;

                            //if($salary == 0)dd($row2->emp_id);
                            $rate1= ($row2->pension_employee/$salary);
                            $rate2= ($row2->pension_employee/$salary);
                            $amount1= $row2->pension_employee;
                            $amount2= $row2->pension_employee;
                            $contribution= ($row2->pension_employee*2);
                            $total_contribution += $contribution;
                            $total_salary +=$salary;

                        ?>

                        <tr>
                            <td>{{ $row2->SNo }}</td>
                            <td>{{ $row2->emp_id }}</td>
                            <td>{{ !empty($member_no)? $member_no : "unknown" }}</td>
                            <td>{{ $row2->name }}</td>
                            <td hidden>{{ $row2->mname }}</td>
                            <td hidden>{{ $row2->lname }}</td>
                            <td align="right">{{ number_format($salary,2) }}</td>
                            <td align="right">{{ number_format($contribution,2) }}</td>


                        </tr>
                        <?php }}} ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><b>TOTAL</b></td>

                            <td align="right"><b>{{ number_format($total_salary,2) }}</b></td>
                            <td align="right"><b>{{ number_format($total_contribution,2) }}</b></td>


                        </tr>
                    </tfoot>

                </table>



            </div>
        </div>




        <div id="logo2" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-right.png') }}" width="100px;" height="50px;">
        </div>
    </main>
    <div class="footer">
        <table class="table footer-font">
            <tfoot>
                <tr>
                    <td class="">
                        <div class="box-text"> {{ date('l, F j, Y') }} </div>
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






    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
