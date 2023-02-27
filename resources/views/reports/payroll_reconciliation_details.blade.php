<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Details </title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

</head>

<body>

    <main class="mb-5">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tfoot>

                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here"
                                        class="image-fluid"> <br>

                                </div>
                            </td>
                            <td>
                                <div class="box-text text-center">
                                    <p style="font-weight:700" class="">
                                        AFRICAN BANKING CORPORATION<br>
                                        P.O. BOX 31 ,DAR ES SALAAM

                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="" style="text-align: right; padding-right:20px">

                                    <h5 class="text-end font-weight-bolder" style="font-weight:bolder;">Payroll
                                        Reconciliation Summary</h5>
                                    <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">
                                        Date:
                                        {{ $payroll_date }}

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>

                <hr style="border: 10px solid rgb(211, 140, 10); border-radius: 2px;">
                @if(isset($employee_increase))
                @if(count($employee_increase) > 0)
                <h4>Add New Employee</h4>
                <table class="table" style="font-size:9px; ">
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
                <table class="table" style="font-size:9px; ">
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
                <table class="table" style="font-size:9px; ">
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
                <table class="table" style="font-size:9px; ">
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
                <h4>{{ $name }}</h4>

                <table class="table" style="font-size:9px; ">
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

                <hr style="border: 4px solid rgb(211, 140, 10); border-radius: 2px;">
                <table class="table">
                    <tfoot>
                        <tr>
                            <td collspan="4">
                                <p class="text-start"><small><b>Prepared By</b></small></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="">


                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                            </td>
                        </tr>
                        <tr>
                            <td collspan="4">
                                <p><small><b>Checked and Approved By</b></small></p>
                            </td>
                        </tr>

                        <tr>
                            <td class="">


                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                            </td>
                        </tr>
                        <tr>
                            <td collspan="4">
                                <b>Checked and Approved By</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="">


                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                            </td>
                        </tr>
                        <tr>
                            <td collspan="4">
                                <p><small><b>Approved By</b></small></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="">


                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Name:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Position:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Signature:________________</div>
                            </td>
                            <td>
                                    <div class="col-md-3 col-sm-3 col-lg-3 mb-3">Date:________________</div>

                            </td>
                        </tr>


                    </tfoot>
                </table>

            </div>
        </div>





    </main>






    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
