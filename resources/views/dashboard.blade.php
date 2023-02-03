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

    // if (session('pass_age') > 89 || 90 - session('pass_age') == 0 || 90 - session('pass_age') < 0) {
    //     redirect('cipay/login_info');
    // }

    ?>


    <div class="row">
        <div class="@if (session('vw_emp_sum')) col-md-12 @else col-md-12 @endif">
            <div class="card">
                <div class="card-head bg-warning text-white">hhh</div>
                <div class="card-body">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="text-muted">
                        Welcome to Fléx Performance! <strong> {{ session('fname') . ' ' . session('lname') }} </strong>
                    </h3>

                    <p  <?php if(session('pass_age') > 84){?> style="color:red" <?php } ?>>Password Expires in <?php echo 90 - session('pass_age'); ?> Days</p>
                </div>
            </div>
            </div>
        </div>
        {{-- /col --}}

        @if (session('vw_emp_sum'))
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="col-md-6 text-muted">Active Employess :</h4>
                            <h4 class="col-md-6 text-muted">{{ $employees }}</h4>
                        </div>

                        <div class="row">
                            <h4 class="col-md-6 text-muted">Males :</h4>
                            <h4 class="col-md-6 text-muted">{{ $males }}</h4>
                        </div>

                        <div class="row">
                            <h4 class="col-md-6 text-muted">Females :</h4>
                            <h4 class="col-md-6 text-muted">{{ $females }}</h4>
                        </div>

                        <div class="row">
                            <h4 class="col-md-6 text-muted">Local Employees :</h4>
                            <h4 class="col-md-6 text-muted">{{ $local_employee }}</h4>
                        </div>

                        <div class="row">
                            <h4 class="col-md-6 text-muted">Expatriates :</h4>
                            <h4 class="col-md-6 text-muted">{{ $expatriate }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- /col --}}

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Current Payroll Summary ({{ date('F, Y', strtotime($payroll_date)) }})</h5>
                </div>

                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Basic Salaries</th>
                            <td>{{ number_format($salary, 2) }}</td>
                        </tr>
                        <tr>
                            @if ($allowances > 0)
                                <th>Allowances</th>
                                <td>{{ number_format($allowances, 2) }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Gross Salaries (Total)</th>
                            <td>{{ number_format($salary + $allowances, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Net Salary</th>
                            <td>{{ number_format($net_total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Pension</th>
                            <td>{{ number_format($pension_employer + $pension_employee, 2) }}</td>
                        </tr>
                        @if ($arrears > 0)
                            <tr>
                                <th>Arrears</th>
                                <td>{{ number_format($arrears, 2) }}</td>
                            </tr>
                        @endif
                        @if ($medical_employer + $medical_employee > 0)
                            <tr>
                                <th>Total Medical</th>
                                <td>{{ number_format($medical_employer + $medical_employee) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Taxdue (PAYE)</th>
                            <td>{{ number_format($taxdue, 2) }}</td>
                        </tr>
                        <tr>
                            <th>WCF</th>
                            <td>{{ number_format(($salary + $allowances) * 0.01, 2) }}</td>
                        </tr>
                        <tr>
                            <th>SDL</th>
                            <td>{{ number_format($taxdue, 2) }}</td>
                        </tr>
                        @if ($total_heslb > 0)
                            <tr>
                                <th>HESLB</th>
                                <td>{{ number_format($total_heslb, 2) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Total Employees Cost</th>
                            <th>{{ number_format($salary + $allowances + $sdl + ($salary + $allowances) * 0.01 + $pension_employer + $medical_employer, 2) }}
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-muted">Payroll Reconciliation Summary (Current & Previous)</h4>
                </div>


                @foreach ($s_net_c as $c)
                    @php
                        $s_net_c_ = $c->takehome;
                    @endphp
                @endforeach

                @foreach ($s_net_p as $p)
                    @php
                        $s_net_p_ = $p->takehome;
                    @endphp
                @endforeach

                @foreach ($v_net_c as $vc)
                    @php
                    $v_net_c_ = $vc->takehome; @endphp
                @endforeach

                @foreach ($v_net_p as $vp)
                    @php
                        $v_net_p_ = $vp->takehome;
                    @endphp
                @endforeach

                @php
                    $staff = 0;
                    $volunteer = 0;

                    $staff_p = 0;
                    $volunteer_p = 0;
                @endphp

                @foreach ($s_staff as $s)
                    @php $staff++; @endphp
                @endforeach

                @foreach ($s_staff_p as $sp)
                    @php  $staff_p++; @endphp
                @endforeach

                @foreach ($v_staff as $v)
                    @php  $volunteer++; @endphp
                @endforeach

                @foreach ($v_staff_p as $vp)
                    @php $volunteer_p++; @endphp
                @endforeach

                <table class="table table-striped table-bordered" style="width:100%">
                    <tr>
                        <th></th>
                        <th><b>Contract type</b></th>
                        <th class="text-center"><b>Current</b></th>
                        <th class="text-center"><b>Previous</b></th>
                        <th class="text-center"><b>Movement</b></th>
                    </tr>
                    <tr>
                        <td rowspan="2"><b>Gross Salary</b></td>
                        <td><b>Staff</b></td>
                        <td align="right">{{ number_format($s_gross_c, 2) }}</td>
                        <td align="right">{{ number_format($s_gross_p, 2) }}</td>
                        <td align="right">{{ number_format($s_gross_c - $s_gross_p, 2) }} </td>
                    </tr>
                    <tr>
                        <td><b>Temporary</b></td>
                        <td align="right">{{ number_format($v_gross_c, 2) }}</td>
                        <td align="right">{{ number_format($v_gross_p, 2) }}</td>
                        <td align="right">{{ number_format($v_gross_c - $v_gross_p, 2) }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><b>Net Salary</b></td>
                        <td><b>Staff</b></td>
                        <td align="right">{{ number_format($s_net_c_, 2) }}</td>
                        <td align="right">{{ number_format($s_net_p_, 2) }}</td>
                        <td align="right">{{ number_format($s_net_c_ - $s_net_p_, 2) }}</td>
                    </tr>
                    <tr>
                        <td><b>Temporary</b></td>
                        <td align="right">{{ number_format($v_net_c_, 2) }}</td>
                        <td align="right">{{ number_format($v_net_p_, 2) }}</td>
                        <td align="right">{{ number_format($v_net_c_ - $v_net_p_, 2) }}</td>
                    </tr>
                    <tr>
                        <td rowspan="2"><b>Head Count</b></td>
                        <td><b>Staff</b></td>
                        <td align="right">{{ $staff }}</td>
                        <td align="right">{{ $staff_p }}</td>
                        <td align="right">{{ $staff - $staff_p }}</td>
                    </tr>
                    <tr>
                        <td><b>Temporary</b></td>
                        <td align="right">{{ $volunteer }}</td>
                        <td align="right">{{ $volunteer_p }} </td>
                        <td align="right">{{ $volunteer - $volunteer_p }}</td>
                    </tr>
                </table>

            </div>
        </div>

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
