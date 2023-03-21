<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payroll Reconciliation-Summary</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/ltr/all.min.css') }}"> --}}






</head>


<body>

    <main>
        <div class="row my-4">

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
                                        Detail_By Number</h5>
                                    <p class="text-end font-weight-bolder text-primary" style="font-weight:bolder;">
                                        Date:
                                        {{ $payroll_date }}

                                </div>
                            </td>
                        </tr>

                    </tfoot>
                </table>

                <hr style="border: 4px solid rgb(211, 140, 10); border-radius: 2px;">
                @php
                    $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;

                @endphp

                <table class="table" style="font-size:14px;">
                    <thead>
                        <tr style="border-bottom:2px solid rgb(9, 5, 64);">
                            <th><b>RefNo</b></th>
                            <th><b>Desc</b></th>
                            <th class="text-end"><b>Last Month</b></th>
                            <th class="text-end"><b>This Month</b></th>
                            <th class="text-end"><b>Amount</b></th>
                            <th class="text-end"><b>Count</b></th>

                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $total_previous += 0;
                            $total_current += 0;
                            $total_amount += $total_previous_gross+100000;
                        @endphp
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                            <td class="text-start">00001</td>
                            <td class="text-start">Last Month Gross Salary</td>
                            <td class="text-end">
                                {{ number_format(0, 2) }}</td>
                            <td class="text-end">
                                {{ number_format(0, 2) }}</td>
                            <td class="text-end">{{ number_format($total_previous_gross+100000, 0) }}</td>
                            <td class="text-end">{{ $count_previous_month }}</td>
                        </tr>
                        @if ($count_current_month - $count_previous_month != 0)
                            @if ($new_employee > 0)
                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                                    <td class="text-start">00002</td>
                                    <td class="text-start">Add New Employee</td>
                                    <td class="text-end">
                                        {{ number_format(0, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($new_employee_salary, 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($new_employee_salary, 2) }}
                                    </td>
                                    <td class="text-end">{{ $new_employee }}</td>
                                </tr>
                                @php
                                    $total_previous += 0;
                                    $total_current += $new_employee_salary;
                                    $total_amount += $new_employee_salary;
                                @endphp
                                @endif
                                 @if($terminated_employee > 0)
                                                <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                                                    <td class="text-start">00002</td>
                                                    <td class="text-start">Less Terminated Employee</td>
                                                    <td class="text-end">
                                                        {{ number_format($termination_salary, 2) }}

                                                    <td class="text-end">
                                                        {{ number_format(0, 2) }}</td>

                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format(0-($termination_salary), 2) }}
                                                    </td>
                                                    <td class="text-end">{{ $terminated_employee }}
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_previous += ($termination_salary);
                                                    $total_current += 0;
                                                    $total_amount += 0-($termination_salary);
                                                @endphp
                                            @endif
                        @endif
                        @if($count_previous_month != 0)
                        @if ($current_increase['basic_increase'] > 0)
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                            <td class="text-start">00004</td>
                            <td class="text-start">Add Increase in Basic Pay incomparison to Last M </td>
                            <td class="text-end">

                                {{ number_format($current_increase['actual_amount'], 2) }}
                            </td>
                            <td class="text-end">
                                {{ number_format($current_increase['basic_increase'], 2) }}
                            </td>
                            <td class="text-end">
                                {{ number_format(($current_increase['basic_increase'] - $current_increase['actual_amount'])-$current_increase['actual_amount'], 2) }}
                            </td>
                            <td class="text-end"></td>
                        </tr>

                        @php
                            $total_previous += $current_increase['actual_amount'];

                            $total_current += $current_increase['actual_amount'] - $current_increase['basic_increase'];
                            //dd($total_current);

                            $total_amount += ($current_increase['basic_increase'] - $current_increase['actual_amount'])-$current_increase['actual_amount'];
                        @endphp
                        @endif
                        @if ($current_decrease['basic_decrease'] > 0)
                            <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                                <td class="text-start">00004</td>
                                <td class="text-start">Less Decrease in Basic Pay incomparison to Last M </td>
                                <td class="text-end">
                                    {{ number_format($current_decrease['actual_amount'], 2) }}
                                </td>
                                <td class="text-end">
                                    {{ number_format($current_decrease['actual_amount'] - $current_decrease['basic_decrease'], 2) }}
                                </td>
                                <td class="text-end">
                                    {{ number_format(($current_decrease['actual_amount'] - $current_decrease['basic_decrease'])-$current_decrease['actual_amount'], 2) }}
                                </td>

                                <td class="text-end"></td>
                            </tr>
                            @php
                                $total_previous += $current_decrease['actual_amount'];
                                $total_current += $current_decrease['actual_amount'] - $current_decrease['basic_decrease'];
                                $total_amount += ($current_decrease['actual_amount'] - $current_decrease['basic_decrease'])-$current_decrease['actual_amount'];
                            @endphp
                        @endif
                        @endif
                        @php $i = 1;  @endphp
                        @if (count($total_allowances) > 0)
                            @foreach ($total_allowances as $row)
                                @php $i++;  @endphp
                                @if ($row->current_amount - $row->previous_amount != 0)
                                @if ($row->description == 'Add/Les Leave Pay' || $row->description == 'Add/Les Leave Allowance' )
                                    <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                                        <td class="text-start">{{ '000' . $i + 4 }}</td>
                                        <td class="text-start">
                                            @if ($row->description == 'Add/Les S-Overtime')
                                                Add/Less Sunday Overtime Hours
                                            @elseif($row->description == 'Add/Les N-Overtime')
                                                Add/Less Normal Day Overtime Hours
                                            @else
                                                {{ $row->description }}
                                            @endif
                                        </td>
                                        <td class="text-end">{{ number_format(0, 2) }}</td>
                                        <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>
                                        <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>
                                        <td class="text-end"></td>
                                    </tr>
                                    @php
                                        $total_previous += 0;
                                        $total_current += $row->current_amount;
                                        $total_amount += $row->current_amount;

                                    @endphp
                                    @else
                                    <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                                        <td class="text-start">{{ '000' . $i + 4 }}</td>
                                        <td class="text-start">
                                            @if ($row->description == 'Add/Les S-Overtime')
                                                Add/Less Sunday Overtime Hours
                                            @elseif($row->description == 'Add/Les N-Overtime')
                                                Add/Less Normal Day Overtime Hours
                                            @else
                                                {{ $row->description }}
                                            @endif
                                        </td>
                                        <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                        <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>
                                        <td class="text-end">{{ number_format($row->difference, 2) }}</td>
                                        <td class="text-end"></td>
                                    </tr>
                                    @php
                                        $total_previous += $row->previous_amount;
                                        $total_current += $row->current_amount;
                                        $total_amount += $row->difference;

                                    @endphp

                                    @endif
                                @endif
                            @endforeach
                        @endif





                        {{-- </tbody>
                            <tbody> --}}
                        <tr style="border-bottom:2px solid rgb(67, 67, 73)">
                            <td class="text-start"></td>
                            <td class="text-start"><b>This Month</b> </td>
                            <td class="text-end">
                                <b>{{ number_format(!empty($total_previous) ? $total_previous : 0, 2) }}</b>
                            </td>
                            <td class="text-end"><b>{{ number_format($total_current, 2) }}</b></td>
                            <td class="text-end">
                                <b>{{ number_format($total_amount, 0) }}</b>
                            </td>
                            <td class="text-end"><b>{{ $count_current_month }}</b></td>
                        </tr>
                    </tbody>
                </table>
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


        </div>
        </div>
    </main>




    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
</body>

</html>
