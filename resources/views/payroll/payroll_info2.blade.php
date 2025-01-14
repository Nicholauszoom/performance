@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')
    @php
        $payroll_details = $data['payroll_details'];
        $payroll_month_info = $data['payroll_month_info'];
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
            if ($key->description == 'HESLB') {
                $paid_heslb = $key->paid;
                $remained_heslb = $key->remained;
            } else {
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

    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
        <div class="card-header border-0">
            @include('payroll.payroll_info_buttons')

        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div
                        class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                        <div class="mb-2 ms-auto">
                            <h4 class="text-muted">Payloll Details:</h4>
                            <div class="d-flex flex-wrap wmin-lg-400">
                                <ul class="list list-unstyled mb-0">
                                    <li>
                                        <h5 class="my-2">Salaries:</h5>
                                    </li>
                                    <li>Total Allowances:</li>
                                    <li>Pension(Employer):</li>
                                    <li>Pension (Employee):</li>

                                    <li>Taxdue (PAYE):</li>
                                    <li>WCF:</li>
                                    <li>SDL:</li>
                                </ul>

                                <ul class="list list-unstyled text-end mb-0 ms-auto">
                                    <li>
                                        <h5 class="my-2">{{ number_format($salary, 2) }}</h5>
                                    </li>
                                    <li><span class="fw-semibold">{{ number_format($allowances, 2) }}</span></li>
                                    <li>{{ number_format($pension_employer, 2) }}</li>
                                    <li>{{ number_format($pension_employee, 2) }}</li>

                                    <li>{{ number_format($taxdue, 2) }}</li>
                                    <li><span class="fw-semibold">{{ number_format($wcf, 2) }}</span></li>
                                    <li><span class="fw-semibold">{{ number_format($sdl, 2) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div
                        class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
                        <div class="mb-2 ms-auto">
                            <h4 class="text-muted">Payloll Details:</h4>
                            <div class="d-flex flex-wrap wmin-lg-400">
                                <ul class="list list-unstyled mb-0">
                                    <li>
                                        <h5 class="my-2">Salaries:</h5>
                                    </li>
                                    <li>Total Allowances:</li>
                                    <li>Pension(Employer):</li>
                                    <li>Pension (Employee):</li>

                                    <li>Taxdue (PAYE):</li>
                                    <li>WCF:</li>
                                    <li>SDL:</li>
                                </ul>

                                <ul class="list list-unstyled text-end mb-0 ms-auto">
                                    <li>
                                        <h5 class="my-2">{{ number_format($salary, 2) }}</h5>
                                    </li>
                                    <li><span class="fw-semibold">{{ number_format($allowances, 2) }}</span></li>
                                    <li>{{ number_format($pension_employer, 2) }}</li>
                                    <li>{{ number_format($pension_employee, 2) }}</li>

                                    <li>{{ number_format($taxdue, 2) }}</li>
                                    <li><span class="fw-semibold">{{ number_format($wcf, 2) }}</span></li>
                                    <li><span class="fw-semibold">{{ number_format($sdl, 2) }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr>


            <?php  ?>

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
