@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')
    @php

        $payrollMonth = $payroll_date;
        $payrollState = $payroll_state;

        $total_previous = 0;
                    $total_current = 0;
                    $total_amount = 0;

    @endphp


<div class="card border-bottom-main rounded-0 border-0 shadow-none">

            @include('payroll.payroll_info_buttons')
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4 class="me-4 text-center">Payroll Reconciliation Summary</h4>
                   
                    <a href="{{ route('reports.payrollReconciliationSummary', ['payrolldate' => $payroll_date,'payrollState'=>$payrollState,'type'=>2]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> <i class="ph-file-pdf"></i> PDF</button>
                    </a>
                

                    <table class="table" id="reports" style="font-size:14px;  ">
                        <thead>
                            <tr>
                                <th><b>RefNo</b></th>
                                <th><b>Desc</b></th>
                                <th><b>Last Month</b></th>
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
                                <td class="text-end">  {{ number_format(0, 2) }} </td>
                                <td class="text-end"> {{ number_format(0, 2) }} </td>
                                <td class="text-end"> {{ number_format($total_previous_gross, 0) }} </td>
                                <td class="text-end"> {{ $payroll_date == '2023-03-19' ? $count_previous_month - 1 : $count_previous_month  }}</td>
                            </tr>


                                @if ($new_employee > 0)
                                    <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                        <td class="text-start">00002</td>
                                        <td class="text-start">Add New Employee</td>
                                        <td class="text-end"> {{ number_format(0, 2) }} </td>
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
                                        <td class="text-end">
                                            {{ number_format($termination_salary, 2) }}
                                        </td>
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
                                        <td class="text-end">

                                            {{ number_format($current_increase['actual_amount']-$current_increase['basic_increase'], 2) }}
                                        </td>
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
                                        <td class="text-end">
                                            {{ number_format($current_decrease['actual_amount'], 2) }}
                                        </td>
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

                                                <td class="text-end">{{ number_format(0, 2) }}</td>
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

                                              //  $total_amount += $row->difference;


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
                                                <td class="text-end">
                                                    {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->previous_amount : $row->previous_amount, 2) }}
                                                </td>
                                                <td class="text-end">
                                                    {{ number_format($row->description == 'Add/Less S-Overtime' ? $row->current_amount : $row->current_amount, 2) }}
                                                </td>
                                                <td class="text-end">{{ number_format($row->current_amount-$row->previous_amount, 2) }}</td>
                                                <td class="text-end"></td>
                                            </tr>
                                            @php
                                                $total_previous += $row->description == 'Add/Less S-Overtime' ? $row->previous_amount  : $row->previous_amount;
                                                $total_current += $row->description == 'Add/Less S-Overtime' ? $row->current_amount  : $row->current_amount;
                                                $total_amount += $row->current_amount-$row->previous_amount;

                                            @endphp
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                            <tr style="border-bottom:2px solid #F0C356;">
                                <td class="text-start"></td>
                                <td class="text-start"><b>This Month</b> </td>
                                <td class="text-end">
                                    <b>{{ number_format(!empty($total_previous) ? $total_previous : 0, 2) }}</b>
                                </td>
                                <td class="text-end"><b>{{ number_format($total_current, 2) }}</b></td>
                                <td class="text-end">
                                    <b>{{ number_format($total_amount, 0) }}</b>
                                </td>
                                <td class="text-end"><b>{{ ($payroll_date == '2023-02-17' ? $count_current_month - 1 : $count_current_month) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <?php ?>

        </div>


    </div>
@endsection


@include('payroll.payroll_sripts')

