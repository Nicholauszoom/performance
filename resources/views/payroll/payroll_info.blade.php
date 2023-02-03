@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')

@endpush

@push('head-scriptTwo')

@endpush

@section('content')
@php
    $payroll_details = $data['payroll_details'];
    $payroll_month_info =$data['payroll_month_info'];
    $payroll_list = $data['payroll_list'];
    $payroll_date = $data['payroll_date'];
    $payroll_totals = $data['payroll_totals'];

    $total_allowances = $data['total_allowances'];
    $total_bonuses = $data['total_bonuses'];
    $total_loans = $data['total_loans'];
    $total_overtimes = $data['total_overtimes'];
    $total_deductions = $data['total_deductions'];
    $payroll_state = $data['payroll_state'];

    $payrollMonth = $payroll_date;
    $payrollState = $payroll_state;

    foreach ($payroll_totals as $row) {
        $salary = $row->salary;
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

    $paid_heslb = null;
    $remained_heslb = null;
    $paid = null;
    $remained = null;

    foreach ($total_loans as $key) {
        if ($key->description == "HESLB"){
            $paid_heslb = $key->paid;
            $remained_heslb = $key->remained;
        }else{
            $paid = $key->paid;
            $remained = $key->remained;
        }
    }

    foreach ($payroll_month_info as $key) {
        // $paid = $key->payroll_date;
        $cheklist = $key->pay_checklist;
        $state = $key->state;
    }

@endphp

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex">

            <h3 class="me-4">Payroll Details For : {{ $payrollMonth }}</h3>
            {{-- export info button --}}
            @if($payrollState == 1)
            <a href="{{route('reports.payroll_report',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> EXPORT INFO</button>
            </a>
            @endif
            {{-- / --}}

            {{-- payroll summary button 1--}}
            @if($payrollState != 1)
            <a href="{{route('reports.get_payroll_temp_summary',$payrollMonth)}}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> Payroll Summary</button>
            @endif
            {{-- / --}}

            {{-- payroll summary button 2 --}}
            @if($payrollState == 1)
            <a class="px-4" href="{{route('reports.get_payroll_temp_summary1',$payrollMonth)}}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> Payroll Summary</button>
            @endif
            {{-- / --}}

            {{-- input change approval button  --}}
            @can('download-approval')
            @if($payrollState != 1)
            <a class="btn btn-main btn-sm ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth]) }}" target="blank">
                Input Changes Approval
            </a>
            @endif
            @endcan
            {{-- / --}}

            {{-- paycheck list button --}}
            @if($payrollState == 1)
            <a class="px-4" href="{{route('reports.payroll_report1',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> Pay Checklist</button>
            </a>
            @endif
            {{-- / --}}
        </div>

    </div>


    <div class="card-body">

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="card border-0 shadow-none">
                <div class="mb-2 ms-auto">
                    <h4 class="text-muted">Payloll Details:</h4>
                    <div class="d-flex flex-wrap wmin-lg-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h5 class="my-2">Salaries:</h5></li>
                            <li>Total Allowances:</li>
                            <li>Pension(Employer):</li>
                            <li>Pension (Employee):</li>

                            <li>Taxdue (PAYE):</li>
                            <li>WCF:</li>
                            <li>SDL:</li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h5 class="my-2">{{ number_format($salary,2) }}</h5></li>
                            <li><span class="fw-semibold">{{ number_format($allowances,2) }}</span></li>
                            <li>{{ number_format($pension_employer,2) }}</li>
                            <li>{{ number_format($pension_employee,2) }}</li>

                            <li>{{ number_format($taxdue,2) }}</li>
                            <li><span class="fw-semibold">{{ number_format($wcf,2) }}</span></li>
                            <li><span class="fw-semibold">{{ number_format($sdl,2) }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <hr>

        <?php if($payrollState == 0){ ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="card border-0 shadow-none">
                <div id="resultConfirmation"></div>

                <div class="mb-2 ms-auto">
                  <!--  <h4 class="text-muted">More Details:</h4> -->

                    @if ($payrollState == 1)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-2">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">Normal Allowances:</h6></li>
                            <li><h6 class="my-2">Overtime:</h6></li>
                            <li><h6 class="my-2">Incentives:</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format(($total_allowances-$total_overtimes-$total_bonuses),2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($total_overtimes,2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($total_bonuses,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($paid_heslb)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-2">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Repayment):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($paid_heslb,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($remained_heslb > 0)
                    <div class="d-flex flex-wrap wmin-lg-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($remained_heslb,2) }}</h6></li>
                        </ul>
                    </div>
                    @elseif($remained_heslb < 0)
                    <div class="d-flex flex-wrap wmin-lg-400 mb-3">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">HESLB (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format(0,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif

                    @if ($paid)
                    <div class="d-flex flex-wrap wmin-lg-400">
                        <ul class="list list-unstyled mb-0">
                            <li><h6 class="my-2">Loans (Total Returns):</h6></li>
                            <li><h6 class="my-2">Loans (Total Outstanding):</h6></li>
                        </ul>

                        <ul class="list list-unstyled text-end mb-0 ms-auto">
                            <li><h6 class="fw-semibold">{{ number_format($paid,2) }}</h6></li>
                            <li><h6 class="fw-semibold">{{ number_format($remained,2) }}</h6></li>
                        </ul>
                    </div>
                    @endif
                </div>

                <div class="mb-2 ms-auto d-flex justify-content-around">
                    <?php if($payrollState == 0 /*&&  session('mng_emp')*/){ ?>

                        {{-- cancel payroll button --}}
                        @can('cancel-payroll')
                        <a href="{{route('payroll.cancelpayroll','none')}}" class="m-3">
                            <button type="button" class="btn btn-warning">Cancel Payroll </button>
                        </a>
                        @endcan
                        {{-- / --}}

                        {{-- confrm payroll button --}}
                        @can('approve-payroll')
                        <a href="javascript:void(0)" onclick="generate_checklist()" class="m-3">
                            <button type="button" class="btn btn-main">Confirm Payroll </button>
                        </a>
                        @endcan
                        {{-- / --}}


                    <?php }  else { ?>
                    
                    {{-- paylist button  --}}
                    <a href="{{route('ADVtemp_less_payments',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print" value="print" class="btn btn-warning">PAY CHECKLIST</button>
                    </a>
                    {{-- / --}}

                    <?php } ?>

                    {{-- print checklist button --}}
                    <a class="my-3" target="_blank" href="{{route('payroll.less_payments_print',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-main">Print Checklist</button>
                    </a>
                    {{-- / --}}

                    <?php if($payrollState == 0) {?>

                    {{-- gross recon button --}}
                    @can('view-gross')
                    <a class="m-3" target="_self" href="{{route('payroll.grossReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Gross Recon</button>
                    </a>
                    @endcan
                    {{-- / --}}

                    {{-- view net button --}}
                    @can('view-net')
                    <a class="m-3" target="_self" href="{{route('payroll.netReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Net Recon</button>
                    </a>
                    @endcan
                    {{-- / --}}

                    <!-- <a class="m-3" target="_self" href="{{route('payroll.sendReviewEmail',['pdate'=>base64_encode($payrollMonth)])}}"><button
                            type="button" name="print_payroll" class="btn btn-info"><b>REVIEWED<br></button></a> -->
                    
                    <?php } ?>
                </div>

            </div>

        </div>
        <?php } ?>

    </div>


</div>

@endsection
@push('footer-script')
<script>
function notify(message, from, align, type) {
    $.growl({
        message: message,
        url: ''
    }, {
        element: 'body',
        type: type,
        allow_dismiss: true,
        placement: {
            from: from,
            align: align
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        url_target: '_blank',
        mouse_over: false,

        icon_type: 'class',
        template: '<div data-growl="container" class="alert" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#!" data-growl="url"></a>' +
            '</div>'
    });
}

let check = <?php /*echo session("email_sent"); */ ?>;

if (check) {
    <?php /*unset(session['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'success');
} else {
    <?php/* unset(session['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'warning');
}
</script>

<script>
function generate_checklist() {
    if (confirm("Are you sure? you whant to confirm payroll") == true) {
        // var id = id;
        $('#hideList').hide();
        $.ajax({
            url: "{{route('payroll.generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
            success: function(data) {
                if (data.status == 1) {
                    alert("Pay CheckList Generated Successiful!");

                    $('#resultConfirmation').fadeOut('fast', function() {
                        $('#resultConfirmation').fadeIn('fast').html(data.message);
                    });
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the div to clear the success notification
                    }, 1500);
                } else {
                    alert(
                        "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
                    );

                    $('#resultConfirmation').fadeOut('fast', function() {
                        $('#resultConfirmation').fadeIn('fast').html(data.message);
                    });
                }

            }

        });
    }
}
</script>
@endpush
