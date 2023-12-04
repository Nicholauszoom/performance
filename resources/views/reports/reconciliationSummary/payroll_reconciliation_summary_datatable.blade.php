@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
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
                    @if ($payrollState == 0)
                    <a href="{{ route('reports.payrollReconciliationSummary', ['payrolldate' => $payroll_date,'payrollState'=>$payrollState,'type'=>1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
                    </a>
                    @else
                    <a href="{{ route('reports.payrollReconciliationSummary', ['payrolldate' => $payroll_date,'payrollState'=>$payrollState,'type'=>1]) }}" target="blank">
                        <button type="button" name="print" value="print" class="btn btn-main btn-sm"> PDF</button>
                    </a>
                    @endif

                    <table class="table table datatable-excel-filter" id="reports" style="font-size:14px;  ">
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

                        @include("reports.reconciliationSummary.payroll_reconciliation_summary_calculations")

                    </table>
                </div>
            </div>


            <?php ?>

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
                        url: "{{ route('payroll.generate_checklist', ['pdate' => base64_encode($payroll_date)]) }}",
                        success: function(data) {
                            if (data.status == 1) {
                                alert("Pay CheckList Generated Successiful!");

                                $('#resultConfirmation').fadeOut('fast', function() {
                                    $('#resultConfirmation').fadeIn('fast').html(data.message);
                                });
                                setTimeout(function() { // wait for 2 secs(2)
                                    location
                                        .reload(); // then reload the div to clear the success notification
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
            //         url: "{{ route('payroll.generate_checklist', ['pdate' => base64_encode($payroll_date)]) }}",
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
