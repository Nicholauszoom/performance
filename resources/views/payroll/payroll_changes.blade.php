@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')

@endpush

@push('head-scriptTwo')

@endpush

@section('content')
@php

    $payroll_date = $data['payroll_date'];



    $payrollMonth = $payroll_date;
    $payrollState = $payroll_state;





@endphp

<div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
    <div class="card-header border-0">
        <h3 class="me-4 text-center">Payroll Review For : {{ date('F, Y',strtotime($payrollMonth)) }}</h3>
        <div class="d-flex">


            {{-- export info button --}}
            @if($payrollState == 1)
            <a href="{{route('reports.payroll_report',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> EXPORT INFO</button>
            </a>
            @endif
            {{-- / --}}

            {{-- payroll summary button 1--}}
            @if($payrollState != 1)
            @can('download-summary')
            <a href="{{route('reports.get_payroll_temp_summary',$payrollMonth)}}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main btn-sm"> Payroll Summary</button>
            </a>
            @endcan
            @endif
            {{-- / --}}

            {{-- payroll summary button 2 --}}
            @can('download-summary')
            @if($payrollState == 1)
            <a class="px-4" href="{{route('reports.get_payroll_temp_summary1',$payrollMonth)}}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> Payroll Summary</button>
            </a>
            @endif
            @endcan
            {{-- / --}}

            {{-- input change approval button  --}}

            @if($payrollState != 1)
            @can('download-summary')
            <a class="ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth,'type'=>1]) }}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                    Payroll Changes
                </button>
            </a>
            <a class="ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth,'type'=>1]) }}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                    Payroll Inputs
                </button>
            </a>
            <a class="ms-3" href="{{ route('reports.payrollReportLogs',['payrolldate'=>$payrollMonth,'type'=>1]) }}" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main btn-sm">
                    Payroll Details
                </button>
            </a>
            <a href="javascript:void(0)" onclick="generate_checklist()" class="ms-3">
                <button type="button" class="btn btn-main">Perform Calculation </button>
            </a>
            <a href="{{route('payroll.cancelpayroll','none')}}" class="ms-3">
                <button type="button" class="btn btn-warning">Cancel Payroll </button>
            </a>
            @endcan
            @endif
            {{-- / --}}

            @if($payrollState == 1)
            <a class="px-4" href="{{route('reports.payroll_report1',['pdate'=>base64_encode($payrollMonth)])}}>" target="blank">
                <button type="button" name="print" value="print" class="btn btn-main"> <i class="ph-download-simple me-2"></i> Pay Checklist</button>
            </a>
            @endif
        </div>

    </div>


    <div class="card-body">
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

        <table class="table datatable-excel-filter">
            <thead>
                <tr>
                  <th>Payrollno</th>
                  <th>Name</th>
                  <th>Time Stamp</th>
                  <th>Change Made By</th>
                  <th>FieldName</th>
                  <th>From</th>
                  <th>To</th>
                  <th>InputScreen</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($logs as $row)
                    <tr id="{{ 'domain'.$row->id }}">
                        <td>{{ $row->payrollno }}</td>

                        <td> {{ $row->empName }} </td>

                        <td>
                            @php
                                $temp = explode(' ',$row->created_at);
                            @endphp

                            <p> <strong>Date </strong> : {{ $temp[0] }} </p>
                            <p> <strong>Time </strong> : {{ $temp[1] }} </p>
                        </td>

                        <td> {{ $row->authName }} </td>

                        <td>{{ $row->field_name }}</td>

                        <td>{{ $row->action_from }}</td>

                        <td>{{ $row->action_to }}</td>

                        <td>{{ $row->input_screen }}</td>
                    </tr>
                @endforeach
              </tbody>
        </table>

        </div>

       </div>
        <hr>

         <?php if($payrollState == 9){ ?> {{-- was 0 --}}
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="card border-top border-bottom border-bottom-width-3 border-bottom-main rounded-0 border-0 shadow-none">
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

                        @can('approve-payroll')
                        <a href="{{route('payroll.cancelpayroll','none')}}" class="m-3">
                            <button type="button" class="btn btn-warning">Cancel Payroll </button>
                        </a>


                        <a href="javascript:void(0)" onclick="generate_checklist()" class="m-3">
                            <button type="button" class="btn btn-main">Perform Calculation </button>
                        </a>
                        @endcan
                    <?php }  else { ?>
                    <a href="{{route('ADVtemp_less_payments',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print" value="print" class="btn btn-warning">PAY CHECKLIST</button>
                    </a>
                    <?php } ?>

                    <a class="my-3" target="_blank" href="{{route('payroll.less_payments_print',['pdate',base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-main">Print Checklist</button>
                    </a>

                    <?php if($payrollState == 0) {?>
                    @can('view-gross')
                    <a class="m-3" target="_self" href="{{route('payroll.grossReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Gross Recon</button>
                    </a>
                    <a class="m-3" target="_self" href="{{route('payroll.netReconciliation',['pdate'=>base64_encode($payrollMonth)])}}">
                        <button type="button" name="print_payroll" class="btn btn-info">Net Recon</button>
                    </a>
                    @endcan
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

    // Advanced initialization
    Swal.fire({
        title: 'Are you sure? you whant to confirm payroll',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!'
    }).then((result) => {
        if (result.isConfirmed) {

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
    });

    // if (confirm("Are you sure? you whant to confirm payroll") == true) {
    //     // var id = id;
    //     $('#hideList').hide();
    //     $.ajax({
    //         url: "{{route('payroll.generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
    //         success: function(data) {
    //             if (data.status == 1) {
    //                 alert("Pay CheckList Generated Successiful!");

    //                 $('#resultConfirmation').fadeOut('fast', function() {
    //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
    //                 });
    //                 setTimeout(function() { // wait for 2 secs(2)
    //                     location.reload(); // then reload the div to clear the success notification
    //                 }, 1500);
    //             } else {
    //                 alert(
    //                     "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
    //                 );

    //                 $('#resultConfirmation').fadeOut('fast', function() {
    //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
    //                 });
    //             }

    //         }

    //     });
    // }
}
</script>
@endpush
