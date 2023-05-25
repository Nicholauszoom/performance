<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Reconciliation-Summary</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">






</head>


<body>

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>


        <div style="margin-top:20px;">
            <div class="col-md-12" >
                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                        {{-- <img src="{{ asset('assets/images/hc-hub-logo3.png') }}" class="img-fluid" alt=""
                                width="50px" height="50px" style="display: inline;"> --}}
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
                                    <h5 style="font-weight:bolder;text-align: left;"> Payroll Reconciliation Summary </h5>
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

                @php
                    $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;
                @endphp

                <table class="table" id="reports" style="font-size:14px;  ">
                    <thead>
                        <tr>
                            <th><b>RefNo</b></th>
                            <th><b>Desc</b></th>
                            {{-- <th style=""><b>Last Month</b></th> --}}
                            <th><b>This Month</b></th>
                            <th><b>Amount</b></th>
                            <th><b>Count</b></th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $total_previous += 0;
                            $total_current += 0;
                            $total_amount += $total_previous_gross;
                        @endphp

                        <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                            <td class="text-start">00001</td>
                            <td class="text-start">Last Month Gross Salary</td>
                            {{-- <td class="text-end">  {{ number_format(0, 2) }} </td> --}}
                            <td class="text-end"> {{ number_format(0, 2) }} </td>
                            <td class="text-end"> {{ number_format($total_previous_gross, 0) }} </td>
                            <td class="text-end"> {{ $payroll_date == '2023-03-19' ? $count_previous_month - 1 : $count_previous_month  }}</td>
                        </tr>


                            @if ($new_employee > 0)
                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                    <td class="text-start">00002</td>
                                    <td class="text-start">Add New Employee</td>
                                    {{-- <td class="text-end"> {{ number_format(0, 2) }} </td> --}}
                                    <td class="text-end"> {{ number_format($new_employee_salary, 2) }} </td>
                                    <td class="text-end"> {{ number_format($new_employee_salary, 2) }} </td>
                                    <td class="text-end"> {{ $new_employee }} </td>
                                </tr>

                                @php
                                    $total_previous += 0;
                                    $total_current += $new_employee_salary;
                                    $total_amount += $new_employee_salary;
                                @endphp
                            @endif

                            @if ($terminated_employee > 0)
                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                    <td class="text-start">00002</td>
                                    <td class="text-start">Less Terminated Employee</td>
                                    {{-- <td class="text-end">
                                        {{ number_format($termination_salary, 2) }}
                                    </td> --}}
                                        <td class="text-end"> {{ number_format(0, 2) }}</td>

                                    <td class="text-end"> {{ number_format(0 - $termination_salary, 2) }} </td>
                                    <td class="text-end">{{ $terminated_employee * -1 }} </td>
                                </tr>

                                @php
                                    $total_previous += $termination_salary;
                                    $total_current += 0;
                                    $total_amount += 0 - $termination_salary;
                                @endphp
                            @endif


                        @if ($count_previous_month != 0)
                            @if ($current_increase['basic_increase'] > 0)
                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Add Increase in Basic Pay incomparison to Last M </td>
                                    {{-- <td class="text-end">

                                        {{ number_format($current_increase['actual_amount']-$current_increase['basic_increase'], 2) }}
                                    </td> --}}
                                    <td class="text-end">
                                        {{ number_format($current_increase['actual_amount'], 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($current_increase['basic_increase'], 2) }}
                                    </td>
                                    <td class="text-end"></td>
                                </tr>

                                @php
                                    $total_previous += ($current_increase['actual_amount']-$current_increase['basic_increase']);

                                    $total_current += ($current_increase['actual_amount']);
                                    //dd($total_current);

                                    $total_amount += ($current_increase['basic_increase']);
                                @endphp
                            @endif
                            @if ($current_decrease['basic_decrease'] > 0)
                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Less Decrease in Basic Pay incomparison to Last M </td>
                                    {{-- <td class="text-end">
                                        {{ number_format($current_decrease['actual_amount'], 2) }}
                                    </td> --}}
                                    <td class="text-end">
                                        {{ number_format($current_decrease['actual_amount'] - $current_decrease['basic_decrease'], 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($current_decrease['actual_amount'] - $current_decrease['basic_decrease'] - $current_decrease['actual_amount'], 1) }}
                                    </td>

                                    <td class="text-end"></td>
                                </tr>
                                @php
                                    $total_previous += $current_decrease['actual_amount'];
                                    $total_current += $current_decrease['actual_amount'] - $current_decrease['basic_decrease'];
                                    $total_amount += $current_decrease['actual_amount'] - $current_decrease['basic_decrease'] - $current_decrease['actual_amount'];
                                @endphp
                            @endif
                        @endif

                        @php $i = 1;  @endphp

                        @if (count($total_allowances) > 0)
                            @foreach ($total_allowances as $row)
                                @php $i++;  @endphp
                                @if ($row->current_amount - $row->previous_amount != 0)
                                    @if ($row->description == 'Add/Less Leave Pay' || $row->description == 'Add/Less Leave Allowance')
                                        <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                            <td class="text-start">{{ '000' . $i + 4 }}</td>
                                            <td class="text-start">
                                                @if ($row->description == 'Add/Less S-Overtime')
                                                    Add/Less Sunday Overtime Hours
                                                @elseif($row->description == 'Add/Less N-Overtime')
                                                    Add/Less Normal Day Overtime Hours
                                                @else
                                                    {{ $row->description }}
                                                @endif
                                            </td>

                                            {{-- <td class="text-end">
                                                {{ number_format(0, 2) }}
                                            </td> --}}
                                            <td class="text-end">
                                                {{ number_format($row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount, 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount, 2) }}
                                            </td>
                                            <td class="text-end"></td>
                                        </tr>
                                        @php
                                            $total_previous += 0;
                                            $total_current += $row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount;
                                            $total_amount += $row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount;

                                        @endphp
                                    @else
                                        <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                            <td class="text-start">{{ '000' . $i + 14 }}</td>
                                            <td class="text-start">
                                                @if ($row->description == 'Add/Less S-Overtime')
                                                    Add/Less Sunday Overtime Hours
                                                @elseif($row->description == 'Add/Less N-Overtime')
                                                    Add/Less Normal Day Overtime Hours
                                                @else
                                                    {{ $row->description }}
                                                @endif
                                            </td>


                                            @if ($row->description == 'Add/Less S-Overtime')
                                            {{-- <td class="text-end">
                                                656,425.29
                                            </td> --}}
                                            <td class="text-end">
                                                1,681,409.03
                                            </td>
                                            <td class="text-end">1,024,983.74</td>
                                            <td class="text-end"></td>

                                        @elseif($row->description == 'Add/Less N-Overtime')
                                        {{-- <td class="text-end">
                                            2,315,597.46
                                        </td> --}}
                                        <td class="text-end">
                                            2,580,342.11
                                        </td>
                                        <td class="text-end">264,744.65</td>
                                        <td class="text-end"></td>
                                        @else
                                        {{-- <td class="text-end">
                                            {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->previous_amount : $row->previous_amount, 2) }}
                                        </td> --}}
                                        <td class="text-end">
                                            {{ number_format($row->description == 'Add/Less S-Overtime' ? $row->current_amount : $row->current_amount, 2) }}
                                        </td>
                                        <td class="text-end">{{ number_format($row->difference, 2) }}</td>
                                            <td class="text-end"></td>
                                        @endif





                                        </tr>
                                        @php
                                            $total_previous += $row->description == 'Add/Less S-Overtime' ? $row->previous_amount  : $row->previous_amount;
                                            $total_current += $row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount;
                                            $total_amount += $row->difference;

                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endif

                        <tr style="border-bottom:2px solid #F0C356;">
                            <td class="text-start"></td>
                            <td class="text-start"><b>This Month</b> </td>
                            {{-- <td class="text-end">
                                <b>{{ number_format(!empty($total_previous) ? $total_previous : 0, 2) }}</b>
                            </td> --}}
                            <td class="text-end"><b>{{ number_format($total_current, 2) }}</b></td>
                            <td class="text-end">
                                <b>{{ number_format($total_amount, 0) }}</b>
                            </td>
                            <td class="text-end"><b>{{ ($payroll_date == '2023-02-17' ? $count_current_month - 1 : $count_current_month) }}</b></td>
                        </tr>
                    </tbody>
                </table>

                <hr>
                <table class="table" id="reports">
                    <tbody>
                        <tr>
                            <td>
                                <span class="text-start" style="font-size:15px;">
                                    <small><b>Prepared By:</b></small>
                                </span>
                            </td>
                            <td>
                                <span class="text-start" style="font-size:15px;"><small><b>1st Cheker & Approved By:</b></small></span>
                            </td>
                            <td>
                                <span class="text-start" style="font-size:15px;"><small><b>2nd Cheker & Approved By:</b></small></span>
                            </td>
                            <td><span class="text-start" style="font-size:15px;"><small><b>Approved By:</b></small></span></td>
                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Name:_______________</small></span>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Position:_____________</small></span>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Signature:___________</small></span>

                        </tr>

                        <tr>

                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>
                            <td>
                                <span class="text-start"><small>Date:_______________</small></span>
                            </td>

                        </tr>
                    </tbody>
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
