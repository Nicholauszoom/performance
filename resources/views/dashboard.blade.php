@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <?php

//    foreach ($appreciated as $row) {
//        $name = $row->NAME;
//        $id = $row->empID;
//        $position = $row->POSITION;
//        $department = $row->DEPARTMENT;
//        $description = $row->description;
//        $date = $row->date_apprd;
//        $photo = $row->photo;
//    }

    foreach ($overview as $row) {
        $employees = $row->emp_count;
        $males = $row->males;
        $females = $row->females;
        $inactive = $row->inactive;
        $expatriate = $row->expatriate;
        $local_employee = $row->local_employee;
    }


    ?>
    @php
    $brandSetting = \App\Models\BrandSetting::first();
@endphp



    <div class="row">
        <div class="@if (session('vw_emp_sum')) col-md-12 @else col-md-12 @endif">
            <div class="card bg-success bg-opacity-10 border-success rounded-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    {{-- <p class="text-main">Welcome to Fléx Performance! <strong> --}}


                        @if ($brandSetting->dashboard_logo)
                        <img src="{{ asset('storage/' . $brandSetting->dashboard_logo) }}" alt="flex logo" height="150px" width="150px" class="img-fluid">

                    @else

                    <img src="{{ asset('assets/images/hc-hub-logo3.png') }}" alt="flex logo" height="150px" width="150px" class="img-fluid">

                    @endif



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
                            <h4 class="panel-footer">Pay Slip <i class="ph-arrow-circle-right"></i></h4>

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




            </section>
        @endcan

        {{-- end of dashboard statistics --}}

    </div>
    {{-- /row --}}

@endsection

@push('footer-script')
    {{-- <script src="<?php echo url(''); ?>style/jquery/jquery.easypiechart.min.js"></script> --}}

    <!-- <script>
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
    </script> -->
@endpush
