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
                                        <h5 style="font-weight:bolder;margin-top:15px;">Human Capital Information System</h5>
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
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="180px" height="150px" class="image-fluid">
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
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Reconciliation Details </h5>
                                </div>
                            </td>
                            <td> <div class="box-text text-end"></div> </td>
                            <td> <div class="box-text"> </div> </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the month of {{ date('M-Y', strtotime($payroll_date)) }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>
                @if(isset($employee_increase))
                @if(count($employee_increase) > 0)
                <h4>Add New Employee</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_increase))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($employee_increase as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif

                @if(isset($employee_decrease))
                @if(count($employee_decrease) > 0)
                <h4>Less Terminated Employee</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($employee_decrease))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($employee_decrease as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @if(isset($basic_increase))
                @if(count($basic_increase) > 0)
                <h4>Add Increase in Basic Pay Comparison to Last M</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($basic_increase))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($basic_increase as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @if(isset($basic_decrease))
                @if(count($basic_decrease) > 0)
                <h4>Less Decrease in Basic Pay Comparison to Last M</h4>
                <table class="table" id="reports" style="font-size:9px; ">
                    <thead style="font-size:8px;">
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($basic_decrease))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($basic_decrease as $row)

                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>

                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endif
                @endif
                @foreach($names as $name)
                <h4>{{ $name == 'Add/Les N-Overtime'? 'Add/Les Normal Day Overtime':($name == 'Add/Les S-Overtime' ? 'Add/Les Sunday Overtime':$name) }}</h4>

                <table class="table" id="reports" style="font-size:9px; ">
                    <thead>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">

                            <th><b>Number</b></th>

                            <th colspan="" style="margin-bottom: 30px;" class="text-center"><b>First Name</b><br>
                            </th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Name</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Last Month</b></th>

                            <th class="text-end" style="margin-bottom: 30px;"><b>This Month</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Effect Amount</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Empl.Date</b></th>
                            <th class="text-end" style="margin-bottom: 30px;"><b>Date Of Leaving</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($allowances))
                            @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                            @endphp
                             @endphp
                            @foreach ($allowances as $row)
                            @if($row->description == $name)
                            @if($row->description == "Add/Les S-Overtime")
                            @if($row->previous_amount != $row->current_amount)
                                @php
                                    $total_previous += $row->previous_amount;
                                    $total_current += $row->current_amount;
                                    $total_amount += ($row->current_amount - $row->previous_amount);
                                @endphp
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                    <td class="text-end">{{ $row->emp_id }}</td>



                                    <td class="text-end">{{ $row->fname }}</td>

                                    <td class="text-end">{{ $row->lname }}</td>


                                    <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                    <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                                    <td class="text-end">
                                        {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                                    <td class="text-end">{{ $row->hire_date }}</td>

                                    <td class="text-end">{{ number_format(0, 0) }}
                                    </td>


                                </tr>
                            @endif
                            @else
                            @php
                            $total_previous += $row->previous_amount;
                            $total_current += $row->current_amount;
                            $total_amount += ($row->current_amount - $row->previous_amount);
                             @endphp
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                            <td class="text-end">{{ $row->emp_id }}</td>



                            <td class="text-end">{{ $row->fname }}</td>

                            <td class="text-end">{{ $row->lname }}</td>


                            <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                            <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>

                            <td class="text-end">
                                {{ number_format($row->current_amount - $row->previous_amount, 2) }}</td>

                            <td class="text-end">{{ $row->hire_date }}</td>

                            <td class="text-end">{{ number_format(0, 0) }}
                            </td>


                        </tr>

                            @endif
                            @endif
                            @endforeach
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">

                                <td class="text-end" colspan="2"><b>TOTAL</b></td>
                                <td></td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_previous, 2) }}</td>
                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_current, 2) }}</td>

                                <td class="text-end" style="background-color:rgb(157, 157, 197); ">{{ number_format($total_amount, 2) }}</td>

                                <td class="text-end"></td>
                                <td class="text-end"></td>


                            </tr>
                        @endif
                    </tbody>

                </table>
                @endforeach

                <table class="table" id="reports">
                    <tbody>
                        <tr>
                            <td>
                                <p class="text-start" style="font-size:15px;">
                                    <small><b>HUMAN CAPITAL DEPARTMENT:</b></small>
                                </p>
                            </td>
                            <td>
                                <p class="text-start" style="font-size:15px;"><small><b>FINANCE DEPARTMENT:</b></small></p>
                            </td>
                            <td>.</td>
                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Reviewed By:</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Checked By:</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Approved By:</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Name______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name______________________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Name______________________</small></p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p class="text-start"><small>Signature and Date___________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature and Date___________</small></p>
                            </td>
                            <td>
                                <p class="text-start"><small>Signature and Date___________</small></p>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <div id="logo2" style="margin-left: 7px; z-index: -10">
                    <img src="{{ asset('assets/images/x-right.png') }}" width="100px;" height="50px;">
                </div>
            </div>
        </div>





    </main>


    <div class="footer">
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



    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
