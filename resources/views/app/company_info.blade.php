@extends('layouts.vertical', ['title' => 'Pending Payments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <!-- notification Js -->



    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush


@section('content')



    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <h5 class="text-main">Company Info<small></small></h5>
        </div>

        <div class="card-body">
            <div class="col-lg-12">

                <div class="border rounded-0 p-3 mb-3">
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                 
                        <li class="nav-item" role="presentation">
                            <a href="#overtimeTab" class="nav-link active show" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Overtime
                            </a>
                        </li>
       

                        {{-- start of payroll tab link --}}
                        <li class="nav-item" role="presentation">
                            <a href="#payrollReportTab" class="nav-link " data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2 "></i>
                                Payroll
                            </a>
                        </li>
                  
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div role="tabpanel" role="tabpanel" class="tab-pane fade " id="payrollReportTab"
                            aria-labelledby="home-tab">
             

                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="card  rounded-0 border-0 shadow-none">
                                  


                                    {{-- table --}}
                                    <table id="datatable" class="table datatable-basic table-bordered">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Payroll Month</th>
                                                <th>Status</th>
                                                {{-- <th>Mail Status</th> --}}
                                                <th>Option</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                    {{-- /table --}}
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane active show" id="overtimeTab">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Add Company Info</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">
                                        <?php //echo $this->session->flashdata("note");
                                        ?>
                                        <div id="resultfeedOvertime"></div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->


            


        </div>


    </div>




@endsection

@push('footer-script')
    @include('app.includes.imprest_operations')

    @include('app.includes.overtime_operations')
    @include('app.includes.update_allowances')
    @include('app.includes.loan_operations')



    <script type="text/javascript">
        function resolveImprest(id) {
            if (confirm("Are You Sure You Want To Resolve This Imprest? (Action is NOT REVERSIBLE)") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({
                    url: "<?php echo url('flex/resolveImprest'); ?>/" + id,
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedImprest').fadeOut('fast', function() {
                            $('#resultfeedImprest').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }

                });
            }
        }

        function confirmOvertime(id) {
            if (confirm("Are You Sure You Want To Confirm This Overtime?") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({
                    url: "<?php echo url('flex/confirmOvertimePayment'); ?>/" + id,
                    async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);

                    }

                });
            }
        }

        function unconfirmOvertime(id) {
            if (confirm("Are You Sure You Want To Unconfirm This Overtime?") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({
                    url: "<?php echo url('flex/unconfirmOvertimePayment'); ?>/" + id,
                    async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);

                    }

                });
            }
        }


        function recommendArrearsPayment(id) {
            if (confirm("Are You Sure You Want To Confirm this Payment?") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({
                    url: "<?php echo url('flex/payroll/recommendArrearsPayment'); ?>/" + id,
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedArrears').fadeOut('fast', function() {
                            $('#resultfeedArrears').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1500);

                    }

                });
            }
        }


        jQuery(document).ready(function($) {

            $('#policy').change(function() {
                $("#policy option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        $("#percentf").attr("disabled", "disabled");
                        $("#days").attr("disabled", "disabled");


                    } else if (value == "2") {
                        $("#days").attr("disabled", "disabled");
                        $("#percentf").removeAttr("disabled");
                    } else if (value == "3") {
                        $("#percentf").attr("disabled", "disabled");
                        $("#days").removeAttr("disabled");
                    }
                });
            });
        });
    </script>

    <script>
        function confirmArrears(id) {
            if (confirm("Are You Sure You Want To Confirm This Arrear?") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({

                    url: "<?php echo url('flex/payroll/confirmArrearsPayment'); ?>/" + id,
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedArrears').fadeOut('fast', function() {
                            $('#resultfeedArrears').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);

                    }

                });
            }
        }

        function cancelArrearsPayment(id) {
            if (confirm("Are You Sure You Want To Cancel this Payment?") == true) {
                var id = id;
                // $('#recordRequirement'+id).show();
                $.ajax({
                    url: "<?php echo url('flex/payroll/cancelArrearsPayment'); ?>/" + id,
                    success: function(data) {
                        alert("Sussess!");
                        $('#resultfeedArrears').fadeOut('fast', function() {
                            $('#resultfeedArrears').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1500);

                    }

                });
            }
        }

        function approvePayroll() {

            const message = "Are you sure you want to approve this payroll?";
            const message1 = "Send payslip as email to employees?";

            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                $.ajax({
                    url: "<?php echo url('flex/payroll/runpayroll'); ?>/<?php echo $pendingPayroll_month; ?>",
                    async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.status == 'OK') {

                            $('#delete').modal('hide');
                            new Noty({
                                text: 'Payroll approved successfully!',
                                type: 'success'
                            }).show();



                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);

                        } else {

                            $('#delete').modal('hide');
                            notify('Payroll approval failed!', 'top', 'right', 'danger');
                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);
                        }

                    }

                });
            });

        }

        function recomendPayrollByHr() {

            const message = "Are you sure you want to recommend this payroll?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                var message = document.getElementById('comment').value;
                var url =
                    "{{ route('payroll.recommendpayrollByHr', ['pdate' => $pendingPayroll_month, 'message' => ':msg']) }}";
                url = url.replace(':msg', message);
                if (message != "") {
                    $.ajax({
                        url: url,
                        async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                        success: function(data) {
                            var data = JSON.parse(data);
                            if (data.status == 'OK') {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Payroll recommended successfully!',
                                    type: 'success'
                                }).show();
                                location.reload();
                            } else {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Payroll recommendation failed!',
                                    type: 'error'
                                }).show();


                            }

                        }

                    });
                } else {
                    $('#delete').modal('hide');

                    new Noty({
                        text: 'Failed, Comment should not be empty',
                        type: 'error'
                    }).show();
                }

            });

        }

        function viewComment(date) {

            var url = "{{ route('payroll.getComment', ':date') }}";
            url = url.replace(':date', date);
            $.ajax({
                url: url,
                async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                success: function(data) {
                    var data = JSON.parse(data);

                    const message = data;
                    $('#delete1').modal('show');
                    $('#delete1').find('.modal-body #message').text(message);

                }

            });




        }

        function recomendPayrollByFinance() {

            const message = "Are you sure you want to recommend this payroll?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                var message = document.getElementById('comment').value;

                var url =
                    "{{ route('payroll.recommendpayrollByFinance', ['pdate' => $pendingPayroll_month, 'message' => ':msg']) }}";
                url = url.replace(':msg', message);
                if (message != "") {
                    $.ajax({
                        url: url,
                        async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                        success: function(data) {
                            var data = JSON.parse(data);
                            if (data.status == 'OK') {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Payroll recommended successfully!',
                                    type: 'success'
                                }).show();
                                location.reload();
                            } else {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Payroll recommendation failed!',
                                    type: 'error'
                                }).show();


                            }

                        }

                    });
                } else {
                    $('#delete').modal('hide');

                    new Noty({
                        text: 'Failed, Comment should not be empty',
                        type: 'error'
                    }).show();
                }

            });

        }

        function hidemodel() {

            $('#delete').hide();
            location.reload();
        }

        function cancelPayroll(type) {

            const message = "Are you sure you want to cancel this payroll?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                $.ajax({
                    url: "<?php echo url('flex/payroll/cancelpayroll'); ?>/" + +type,
                    async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.status == 'OK') {
                            $('#delete').modal('hide');
                            notify('Payroll cancelled successfully!', 'top', 'right', 'success');

                            setTimeout(function() { // wait for 2 secs(2)
                                location
                                    .reload(); // then reload the div to clear the success notification
                            }, 1500);
                        } else {
                            $('#delete').modal('hide');
                            notify('Payroll cancellation failed!', 'top', 'right', 'danger');
                            setTimeout(function() { // wait for 2 secs(2)
                                location
                                    .reload(); // then reload the div to clear the success notification
                            }, 1500);

                        }

                    }

                });
            });

        }


        function sendEmail(payrollDate) {

            if (confirm(
                    "Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??"
                ) == true) {

                $.ajax({
                    url: "<?php echo url('flex/payroll/send_payslips'); ?>/" + payrollDate,
                    async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    },
                    success: function(data) {}


                });
                $('#feedBackMail').fadeOut('fast', function() {
                    $('#feedBackMail').fadeIn('fast').html(
                        "<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>");
                });
                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the div to clear the success notification
                }, 1500);
            }
        }
    </script>

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
                template: '<div data-growl="container" class="alert" role="alert" style="padding-bottom:20px;">' +
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
    </script>
@endpush
