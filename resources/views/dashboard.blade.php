@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <?php

    foreach ($appreciated as $row) {
        $name = $row->NAME;
        $id = $row->empID;
        $position = $row->POSITION;
        $department = $row->DEPARTMENT;
        $description = $row->description;
        $date = $row->date_apprd;
        $photo = $row->photo;
    }

    foreach ($overview as $row) {
        $employees = $row->emp_count;
        $males = $row->males;
        $females = $row->females;
        $inactive = $row->inactive;
        $expatriate = $row->expatriate;
        $local_employee = $row->local_employee;
    }

    foreach ($taskline as $row) {
        $all = $row->ALL_TASKS;
        $completed = $row->COMPLETED;
    }

    foreach ($taskstaff as $row) {
        $allstaff = $row->ALL_TASKSTAFF;
        $allstaff_completed = $row->COMPLETEDSTAFF;
    }

    foreach ($payroll_totals as $row) {
        $salary = $row->salary;
        $net_less = $row->takehome_less;
        $pension_employee = $row->pension_employee;
        $pension_employer = $row->pension_employer;

        $medical_employee = $row->medical_employee;
        $medical_employer = $row->medical_employer;
        $sdl = $row->sdl;
        $wcf = $row->wcf;
        $allowances = $row->allowances;
        $taxdue = $row->taxdue;
        $meals = $row->meals;
    }
    foreach ($total_loans as $key) {
        $paid = $key->paid;
        $remained = $key->remained;
    }

    foreach ($take_home as $row) {
        $net = $row->takehome - $arrears;
    }

    ?>


    <div class="row">
        <div class="@if (session('vw_emp_sum')) col-md-12 @else col-md-12 @endif">
            <div class="card bg-success bg-opacity-10 border-success rounded-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    {{-- <p class="text-main">Welcome to Fléx Performance! <strong> --}}
                        <img src="{{ asset('assets/images/hc-hub-logo3.png') }}" alt="flex logo" height="150px" width="150px" class="img-fluid">
                          <p class="text-main">Welcome<strong>
                            {{ session('fname') . ' ' . session('lname') }} </strong></p>

                    <p <?php if(session('pass_age') > 84){?> style="color:red" <?php } ?>>Password Expires in <?php echo 90 - session('pass_age'); ?> Days
                    </p>
                </div>
            </div>
        </div>

        @if ($deligate > 0)
            <div class="@if (session('vw_emp_sum')) col-md-12 @else col-md-12 @endif">
                <div class="card bg-danger bg-opacity-10 border-success rounded-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <p class="text-main">You Deligate leave approving authority to someone else! <strong> </strong></p>

                        <p> <a href="{{ route('attendance.revoke_authority') }}">Click here to revoke</a> </p>
                    </div>
                </div>
            </div>
        @endif
        {{-- /col --}}

        {{-- Start of Self Services  --}}
        @if(!auth()->user()->can('view-dashboard'))
        <section>
            <div class="row">
                <div class="col-md-3 col-6">

                    <div class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main">
                        <a href="{{ route('flex.my-overtimes') }}" style="text-decoration:none;"
                            title="Click to here view your Overtimes">
                            <h1 class="text-main"><i class="ph-clock panel-text"></i></h1>
                            <h4 class="panel-footer">Overtimes <i class="ph-arrow-circle-right"></i></h4>
                        </a>
                    </div>

                </div>

                <div class="col-md-3 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout">
                        <a href="{{ route('flex.my-leaves') }}" style="text-decoration:none;"
                            title="Click to here view your Leaves">
                            <h1 class="text-main"><i class="ph-calendar-check panel-text"></i></h1>
                            <h4 class="panel-footer">Leaves <i class="ph-arrow-circle-right"></i></h4>
                        </a>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout ">
                        <a href="{{ route('flex.my-loans') }}" style="text-decoration:none;"
                            title="Click here to view your Loans">
                            <h1 class="text-main"> <i class="ph-bank panel-text"></i></h1>
                            <h4 class="panel-footer">Loans(HESLB) <i class="ph-arrow-circle-right"></i></h4>

                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout ">
                        <a href="{{ route('flex.download_payslip') }}" style="text-decoration:none;"
                            title="Click here to view your Loans">
                            <h1 class="text-main"> <i class="ph-money panel-text"></i></h1>
                            <h4 class="panel-footer">Salary Slip <i class="ph-arrow-circle-right"></i></h4>

                        </a>
                    </div>
                </div>


                <div class="col-md-4 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout">
                        <a href="{{ route('flex.my-pensions') }}" style="text-decoration:none;"
                            title="Click here to view your Pension History">
                            <h1 class="text-main"><i class="ph-wallet panel-text"></i></h1>
                            <h4 class="panel-footer">Pensions <i class="ph-arrow-circle-right"></i></h4>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout">
                        <a href="{{ route('flex.my-grievances') }}" style="text-decoration:none;"
                            title="Click here to view your Pension History">
                            <h1 class="text-main"><i class="ph-scales panel-text"></i></h1>
                            <h4 class="panel-footer">Grievance <i class="ph-arrow-circle-right"></i></h4>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-6">
                    <div
                        class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main card-layout">
                        <a href="{{ route('flex.userdata', base64_encode(auth()->user()->emp_id)) }}" style="text-decoration:none;"
                            title="Click here to view your Pension History">
                            <h1 class="text-main"><i class="ph-user-square panel-text"></i></h1>
                            <h4 class="panel-footer">Biodata <i class="ph-arrow-circle-right"></i></h4>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @endif
        {{-- end  of self-service --}}

        {{-- start of dashboard statistics --}}
        @can('view-dashboard')
            <section>
                @if (session('vw_emp_sum'))
                    <div class="col-xl-12">
                        <div class="card border-top  border-top-width-3 border-top-main rounded-0 card-layout">

                            <ul class="list-group list-group-flush border-top">
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Active Employees:</span>
                                    <div class="ms-auto">{{ $employees }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Males:</span>
                                    <div class="ms-auto">{{ $males }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Females:</span>
                                    <div class="ms-auto">{{ $females }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Local Employees:</span>
                                    <div class="ms-auto">{{ $local_employee }}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span class="fw-semibold">Expatriates:</span>
                                    <div class="ms-auto">{{ $expatriate }}</div>
                                </li>
                            </ul>
                        </div>

                    </div>
                @endif

        {{-- <div class="col-md-6">
            <div
                class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0rounded-0 card-layout">

                <div class="card-body">

                    <select class="sel" name="year">



                        <option value="2022">Year 2022</option>

                        <option value="2021">Year 2021</option>
                        <option value="2023">Year 2023</option>

                    </select>



                    <div style="width: 80%;margin: 0 auto;">

                        {!! $chart->container() !!}

                    </div>







                    {!! $chart->script() !!}



                    <script type="text/javascript">

                        var original_api_url = {{ $chart->id }}_api_url;

                        $(".sel").change(function(){

                            var year = $(this).val();

                            {{ $chart->id }}_refresh(original_api_url + "?year="+year);

                        });

                    </script>
                </div>




            </div>
        </div> --}}


                <div class="col-md-12">
                    <div
                        class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0rounded-0 card-layout">
                        <div class="card-header bg-main text-center">
                            <h5>Payroll Reconciliation Summary for the month of {{ date('F, Y', strtotime($payroll_date)) }}
                            </h5>
                        </div>

                        @php

                            $total_previous = 0;
                            $total_current = 0;
                            $total_amount = 0;

                        @endphp

                        <table class="table">


                            <tbody>

                                <tr style="">
                                    <th><b>RefNo</b></th>
                                    <th><b>Desc</b></th>
                                    <th class="text-end"><b>Last Month</b></th>
                                    <th class="text-end"><b>This Month</b></th>
                                    <th class="text-end"><b>Amount</b></th>
                                    <th class="text-end"><b>Count</b></th>

                                </tr>

                                @php
                                    $total_previous += 0;
                                    $total_current += 0;
                                    $total_amount += $total_previous_gross + ($payroll_date == '2023-03-19' ? 100000 : 0);
                                @endphp

                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                    <td class="text-start">00001</td>
                                    <td class="text-start">Last Month Gross Salary</td>
                                    <td class="text-end"> {{ number_format(0, 2) }} </td>
                                    <td class="text-end"> {{ number_format(0, 2) }} </td>
                                    <td class="text-end">
                                        {{ number_format($total_previous_gross + ($payroll_date == '2023-03-19' ? 100000 : 0), 0) }}
                                    </td>
                                    <td class="text-end">
                                        {{ $payroll_date == '2023-03-19' ? $count_previous_month - 1 : $count_previous_month }}
                                    </td>
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
                                            <td class="text-end"> {{ number_format(0, 2) }}</td>
                                            </td>
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

                                                {{ number_format($current_increase['actual_amount'], 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($current_increase['basic_increase'], 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($current_increase['basic_increase'] - $current_increase['actual_amount'] - $current_increase['actual_amount'], 2) }}
                                            </td>
                                            <td class="text-end"></td>
                                        </tr>

                                        @php
                                            $total_previous += $current_increase['actual_amount'];

                                            $total_current += $current_increase['actual_amount'] - $current_increase['basic_increase'];
                                            //dd($total_current);

                                            $total_amount += $current_increase['basic_increase'] - $current_increase['actual_amount'] - $current_increase['actual_amount'];
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
                                            @if ($row->description == 'Add/Les Leave Pay' || $row->description == 'Add/Les Leave Allowance')
                                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
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
                                                    <td class="text-end">
                                                        {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount, 2) }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount, 2) }}
                                                    </td>
                                                    <td class="text-end"></td>
                                                </tr>
                                                @php
                                                    $total_previous += 0;
                                                    $total_current += $row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount;
                                                    $total_amount += $row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount;

                                                @endphp
                                            @else
                                                <tr style="border-bottom:1px solid rgb(211, 211, 230)">
                                                    <td class="text-start">{{ '000' . $i + 14 }}</td>
                                                    <td class="text-start">
                                                        @if ($row->description == 'Add/Les S-Overtime')
                                                            Add/Less Sunday Overtime Hours
                                                        @elseif($row->description == 'Add/Les N-Overtime')
                                                            Add/Less Normal Day Overtime Hours
                                                        @else
                                                            {{ $row->description }}
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->previous_amount - 236363.64 : $row->previous_amount, 2) }}
                                                    </td>
                                                    <td class="text-end">
                                                        {{ number_format($row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount, 2) }}
                                                    </td>
                                                    <td class="text-end">{{ number_format($row->difference, 2) }}</td>
                                                    <td class="text-end"></td>
                                                </tr>
                                                @php
                                                    $total_previous += $row->description == 'Add/Les S-Overtime' ? $row->previous_amount - 236363.64 : $row->previous_amount;
                                                    $total_current += $row->description == 'Add/Les S-Overtime' ? $row->current_amount - 236363.64 : $row->current_amount;
                                                    $total_amount += $row->difference;

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
                                    <td class="text-end"><b>{{ $count_current_month }}</b></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </section>
        @endcan

        {{-- end of dashboard statistics --}}

    </div>
    {{-- /row --}}

@endsection

@push('footer-script')
    {{-- <script src="<?php echo url(''); ?>style/jquery/jquery.easypiechart.min.js"></script> --}}

    <script>
        $(function() {
            $('.chart').easyPieChart({
                easing: 'easeOutElastic',
                delay: 3000,
                barColor: '#26B99A',
                trackColor: '#fff',
                scaleColor: false,
                lineWidth: 20,
                trackWidth: 16,
                lineCap: 'butt',
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                }
            });
        });
    </script>
@endpush
