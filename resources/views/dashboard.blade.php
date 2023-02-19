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
                    <p class="text-main">Welcome to Fléx Performance! <strong> {{ session('fname') . ' ' . session('lname') }} </strong></p>

                    <p  <?php if(session('pass_age') > 84){?> style="color:red" <?php } ?>>Password Expires in <?php echo 90 - session('pass_age'); ?> Days</p>
                </div>
            </div>
        </div>
        {{-- /col --}}

        {{-- Start of Self Services  --}}
        <section>
            <div class="row">
                <div class="col-md-3 col-6">
                   
                    <div class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main ">
                        <a href="{{ route('flex.my-overtimes') }}" style="text-decoration:none;"  title="Click to view your Overtimes">
                        <h1 class="text-main"><i class="ph-clock panel-text"></i></h1>
                        <h4 class="panel-footer">My Overtimes <i class="ph-arrow-circle-right"></i></h4>
                    </a>
                    </div>
              
                </div>

                <div class="col-md-3 col-6">
                    <div class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main ">
                        <a href="{{ route('flex.my-leaves') }}" style="text-decoration:none;"  title="Click to view your Overtimes">
                        <h1 class="text-main"><i class="ph-calendar-check panel-text"></i></h1>
                        <h4 class="panel-footer">My Leaves <i class="ph-arrow-circle-right"></i></h4>
                    </a>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main  ">
                        <a href="{{ route('flex.my-loans') }}" style="text-decoration:none;"  title="Click to view your Overtimes">
                        <h1 class="text-main"> <i class="ph-bank panel-text"></i></h1>
                            <h4 class="panel-footer">My Loans <i class="ph-arrow-circle-right"></i></h4>
                    
                    </a>
                    </div>
                </div>
                

                <div class="col-md-3 col-6">
                    <div class="card p-2 text-center bordered-0 rounded-0 border-top  border-top-width-3 border-top-main ">
                        <a href="{{ route('flex.my-overtimes') }}" style="text-decoration:none;"  title="Click to view your Overtimes">
                        <h1 class="text-main"><i class="ph-scales panel-text"></i></h1>
                        <h4 class="panel-footer">My Complains <i class="ph-arrow-circle-right"></i></h4>
                    </a>
                    </div>
                </div>
            </div>
        </section>
        {{-- end  of self-service --}}
    
        {{-- start of dashboard statistics --}}
        @can('view-dashboard')

        <section>
            @if (session('vw_emp_sum'))
            <div class="col-xl-12">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0">

                    <ul class="list-group list-group-flush border-top">
                        <li class="list-group-item d-flex">
                            <span class="fw-semibold">Active Employess:</span>
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
        {{-- /col --}}

        <div class="col-xl-12">
            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0rounded-0">
                <div class="card-header bg-main text-center">
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
            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0rounded-0">
                <div class="card-header bg-main text-center">
                    <h5 class="">Payroll Reconciliation Summary (Current & Previous)</h5>
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
                        <td><b>Employee</b></td>
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
                        <td><b>Employee</b></td>
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
                        <td><b>Employee</b></td>
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
