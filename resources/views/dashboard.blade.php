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
            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main  rounded-0 rounded-0">

                <div class="row p-1 border-0 round-0">

                    <div class="col-12 col-md-3">
                        <div class="card p-2 rounded-0 rounded-0">
                            <div class="sidebar-section-body text-center">
                                <div class="card-img-actions d-inline-block my-3">
                                    {{-- rounded-circle --}}
                                    <img class="img "
                                        src="{{ Auth()->user()->photo == 'user.png' ? 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=00204e&color=fff' : asset('storage/profile/' . Auth()->user()->photo) }}"
                                        width="150" height="150" alt="">
                                </div>
                                @php
                                    $name=Auth()->user()->fname.' '.Auth()->user()->mname.' '.Auth()->user()->lname;
                                @endphp 
                                <h6 class="text-main  mb-0">{{ $name }}</h6>
                                <span class="text-secondary mb-3">{{ Auth()->user()->positions->name }}</span>


                            </div>
                        </div>
                    </div>
                  
                    <div class="col-12 col-md-9">
                        <div class="row mx-auto">
                            <div class=" border-top  bordered-0 rounded-0">
                                <div class="card-body border-0">
                                    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#my-overtimes" class="nav-link active show" data-bs-toggle="tab" aria-selected="true" role="tab" tabindex="-1">
                                                My Overtime
                                            </a>
                                        </li> 
                                        <li class="nav-item" role="presentation">
                                            <a href="#register-approve" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                                My Leaves
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#register-approve" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                                My Loans
                                            </a>
                                        </li>  
                                        
                                        <li class="nav-item" role="presentation">
                                            <a href="#register-approve" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                                My Pensions
                                            </a>
                                        </li>  
                                    </ul>
                                </div>
                            
                                <div class="tab-content" id="myTabContent">
                                    {{-- start of my Overtimes --}}
                                    <div role="tabpanel" class="tab-pane fade active show " id="my-overtimes" aria-labelledby="transfer-tab">
                                        {{-- Apply overtime --}}
                                        <div id="apply_overtime">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                                                        <div class="card-header border-0 shadow-none">
                                                            <h5 class="text-warning">Apply Overtime</h5>
                                                        </div>
                                    
                                                        <div class="card-body">
                                    
                                                            <form id="applyOvertime" enctype="multipart/form-data" method="post" data-parsley-validate
                                                                autocomplete="off">
                                                                @csrf
                                    
                                                                <div class="modal-body">
                                                                    <div class="row">
                                    
                                                                
                                                                    <div class="col-12 col-md-6 mb-3">
                                                                      
                                                                        <div class="col-sm-12">
                                                                            <label class="col-form-label    ">Overtime Category <span
                                                                                class="text-danger">*</span> :</label>
                                                                            <select class="form-control select_category select" name="category" required>
                                                                                <option selected disabled> Select </option>
                                                                                @foreach ($overtimeCategory as $overtimeCategorie)
                                                                                    <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <div class="col-6 col-md-3 mb-3">
                                                                        <label class="col-form-label">Time Start <span class="text-danger">*</span>
                                                                            :</label>
                                                                        <div class="col-sm-12">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                                                <input type="text" required placeholder="Start Time" name="time_start"
                                                                                    id="time_start" class="form-control daterange-single">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                    
                                                                    <div class="col-6 col-md-3 mb-3">
                                                                        <label class="col-form-label ">Time End <span class="text-danger">*</span>
                                                                            :</label>
                                                                        <div class="col-sm-9">
                                                                            <div class="input-group">
                                                                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                                                                <input type="text" required placeholder="Finish Time" name="time_finish"
                                                                                    id="time_end" class="form-control daterange-single">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                    
{{--                                     
                                    
                                                                    <div class="row mb-3">
                                                                        <label class="col-form-label col-sm-3">Select Aprover <span
                                                                                class="text-danger">*</span> :</label>
                                                                        <div class="col-sm-9">
                                                                            <select class="form-control select" name="linemanager" id="linemanager">
                                                                                <option selected disabled> Select Approver</option>
                                                                                @php
                                                                                $employees=App\Models\EMPL::all();
                                                                                @endphp
                                                                                @foreach ($employees as $employee)
                                                                                    <option value="{{ $employee->emp_id }}">{{ $employee->fname }}
                                                                                        {{ $employee->mname }} {{ $employee->lname }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div> --}}
                                    
                                                                    <div class="row mb-3">
                                                                        <label class="col-form-label ">Reason for overtime <span
                                                                                class="text-danger">*</span> :</label>
                                                                        <div class="col-sm-12">
                                                                            <textarea rows="3" cols="3" required class="form-control" name="reason" placeholder='Reason'></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                    
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-perfrom">Send Request</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- / --}}


                                        <h6 class="mb-3 text-warning">My Overtimes</h6>
                            
                                        <table id="datatable" class="table table-striped table-bordered datatable-basic">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Date</th>
                                                    <th>Total Overtime(in Hrs.)</th>
                                                    <th>Reason(Description)</th>
                                                    <th>Status</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                            
                                        </table>
                            
                                    </div>
                                    {{-- / --}}
                            
                                    {{-- Approve registered employee --}}
                                    <div role="tabpanel" class="tab-pane  " id="register-approve" aria-labelledby="approve-tab">
                            
                                        <h6 class="text-warning mb-3 mx-3">Current Employee Registered</h6>
                            
                                        <?php echo session("note");  ?>
                                        <div id="resultFeedback"></div>
                            
                                        
                                    </div>
                                    {{-- / --}}
                                </div>
                            </div>
                        </div>
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
