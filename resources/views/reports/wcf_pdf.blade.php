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
                                    <h5 style="font-weight:bolder;text-align: left;"> WCF Report </h5>
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
                            <th  style="margin-bottom: 30px;" class="text-center"><b>Employee Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Tin</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>National Id</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>Basic Saary</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Gross Salary</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>WCF</b></th>


                        </tr>

                    </thead>
                    <tbody>
                        @php
                            $total_salary = 0;
                            $total_gross = 0;
                            $total_wcf = 0;
                        @endphp
                        @foreach ($wcf as $row)
                        @php
                            $emp_id= $row->emp_id;
                            $name= $row->name;
                            $salary= $row->salary;
                            $gross= ($row->allowances+$row->salary);
                            $tin = $row->tin;
                            $national_id = $row->national_id;

                            $total_salary += $salary;
                            $total_gross += $gross;
                            $total_wcf += $row->wcf;
                        @endphp

                          <tr align="right">
                            <td width="50" align="center">{{$row->SNo}}</td>
                            <td width="60" align="center">{{$emp_id}}</td>
                            <td width="150" align ="left">{{$name}}</td>
                             <td align="left">{{$tin}}</td>
                             <td align="left">{{$national_id}}</td>
                            <td align="right">{{number_format($salary,2)}}</td>
                            <td align="right">{{number_format($gross,2)}}</td>
                            <td align="right">{{number_format($row->wcf,2)}}</td>
                            </tr>
                            @endforeach

                            @if(!empty($wcf_termination))
                            @foreach ($wcf_termination as $row)
                        @php
                            $emp_id= $row->emp_id;
                            $name= $row->name;
                            $salary= $row->salary;
                            $gross= ($row->total_gross);
                            $tin = $row->tin;
                            $national_id = $row->national_id;

                            $total_salary += $salary;
                            $total_gross += $gross;
                            $total_wcf += $row->wcf;
                        @endphp

                          <tr align="right">
                            <td width="50" align="center">{{$row->SNo}}</td>
                            <td width="60" align="center">{{$emp_id}}</td>
                            <td width="150" align ="left">{{$name}}</td>
                             <td align="left">{{$tin}}</td>
                             <td align="left">{{$national_id}}</td>
                            <td align="right">{{number_format($salary,2)}}</td>
                            <td align="right">{{number_format($gross,2)}}</td>
                            <td align="right">{{number_format($row->wcf,2)}}</td>
                            </tr>
                            @endforeach
                            @endif

                    </tbody>
                    <tfoot>
                        <tr align="right">
                            <td width="50" style="text-align:center;" colspan="5" align="center">TOTAL</td>

                            <td align="right">{{number_format($total_salary,2)}}</td>
                            <td align="right">{{number_format($total_gross,2)}}</td>
                            <td align="right">{{number_format($total_wcf,2)}}</td>
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
