@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/form_layouts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>

    <script src="{{ asset('assets/date-picker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/date-picker/daterangepicker.js') }}"></script>
@endpush

@section('content')
    @php
        $pendingPayroll_month = $data['pendingPayroll_month'];
        $payroll = $data['payroll'];
        $payrollList = $data['payrollList'];
        $pendingPayroll = $data['pendingPayroll'];
    @endphp

    <div class="card">
        <div class="card-header border-0">
            <h5 class="mb-0 text-muted">Payroll</h5>
        </div>

        <div class="card-body">

            {{-- start of run payroll --}}
            @can('add-payroll')
            @if ($pendingPayroll == 0 && session('mng_paym'))
            
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Run Payroll</h5>
                        </div>

                        <div class="card-body">
                            <div id="payrollFeedback"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <form autocomplete="off" id="initPayroll" method="POST">
                                        <div class="mb-3 row">
                                            <div class="col-7 row">
                                                <label class="form-label col-md-3 text-center font-bold">
                                                    <h6>Payroll Month:</h6>
                                                </label>

                                                <div class="col-md-9">
                                                    <input type="text" required placeholder="Payroll Month" name="payrolldate" class="form-control col-md-7 has-feedback-left" id="payrollDate" aria-describedby="inputSuccess2Status">
                                                    <span class="ph-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <button name="init" type="submit" class="btn btn-main">RUN PAYROLL</button>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
            @endcan
            {{-- / --}}


            {{-- start of payslip mail list --}}
            @can('view-payroll')
            <div class="col-lg-12 col-md-12 col-sm-6" id="hideList">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Payslip Mail Delivery List</h5>
                    </div>

                    <div class="card-body">
                        <table class="table datatable-basic">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Payroll Month</th>
                                    <th>Status</th>
                                    <th>Mail status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach ($payrollList as $row) { ?>

                                <tr id="domain<?php echo $row->id;?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                    <td><?php echo date('F, Y', strtotime($row->payroll_date));; ?>
                                    </td>
                                    <td>
                                        <?php if($row->state==1 || $row->state==2 ){   ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning">PENDING</span>


                                        <?php if(!$row->pay_checklist==1){ ?>
                                        <script>
                                        setTimeout(function() {
                                            var url =
                                                "{{route('payroll.temp_payroll_info',['pdate'=>base64_encode($payrollList[0]->payroll_date)])}}"
                                            window.location.href = url;
                                        }, 1000)
                                        </script>
                                        <?php  }?>

                                        <?php } else { ?>
                                        <span class="badge bg-success bg-opacity-20 text-success">APPROVED</span>
                                        <br>
                                        <?php  } ?>
                                    </td>
                                    <td>
                                        <?php if($row->email_status==0){ ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning">NOT SENT</span>
                                        <br>
                                        <?php } else { ?>
                                        <span class="badge bg-success bg-opacity-20 text-success">SENT</span>

                                        <?php  } ?>
                                    </td>

                                    <td class="options-width">
                                        <?php if($row->state==1 || $row->state==2){ ?>
                                        <div class="d-flex">
                                            {{-- start of cancel payroll button --}}
                                            <span style="margin-right: 4px">
                                                <a href="javascript:void(0)" onclick="cancelPayroll()"
                                                    title="Cancel Payroll" class="icon-2 info-tooltip">
                                                    <button type="button"
                                                        class="btn bg-danger bg-opacity-20 text-danger btn-xs">
                                                        <i class="ph-x"></i>
                                                    </button>
                                                </a>
                                            </span>
                                            {{-- / --}}

                                            {{-- start of resend payslip button --}}
                                            <span style="margin-right: 4px">
                                                <a href="{{route('payroll.temp_payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url('index.php/payroll/temp_payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                                    onclick="cancelPayroll()" title="Resend Pay Slip as Email"
                                                    class="icon-2 info-tooltip">
                                                    <button type="button"
                                                        class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                                        <i class="ph-repeat"></i>
                                                        <i class="ph-envelope"></i>
                                                    </button>
                                                </a>
                                            </span>
                                            {{-- / --}}
                                        </div>

                                        <?php } else {  ?>

                                        {{-- start of view email detail button --}}
                                        <a href="{{route('payroll.payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url('index.php/payroll/payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                            title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-info btn-xs"><i class="ph-circle"></i></button> 
                                        </a>
                                        {{-- / --}}
                                        <?php if($row->state==0){ ?>
                                        <?php if($row->pay_checklist==1){ ?>

                                        {{-- start of print report button --}}
                                        <a href="{{route('reports.payroll_report',['pdate'=>base64_encode($row->payroll_date)])}}<?php //echo base_url(); ?>index.php/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>"
                                            target="blank" title="Print Report" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-info btn-xs">
                                                <i class="ph-printer"></i>
                                            </button> 
                                        </a>
                                        {{-- / --}}
                                        <?php } else {  ?>
                                        <a title="Checklist Report Not Ready" class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-warning btn-xs"><i
                                                    class="ph-file"></i></button> </a>
                                        <?php } ?>

                                        <?php if($row->email_status==0){ ?>

                                        {{-- start of send payslip mail button --}}
                                        <a href="javascript:void(0)"
                                            onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                            title="Send Pay Slip as Email" class="icon-2 info-tooltip"><button type="button"
                                                class="btn btn-success btn-xs"><i class="ph-envelope"></i></button> 
                                        </a>
                                        {{-- / --}}

                                        <?php } else { ?>

                                        {{-- start of re-send payslip mail button  --}}
                                        <a href="javascript:void(0)"
                                            onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                            title="Resend Pay Slip as Email" class="icon-2 info-tooltip"><button
                                                type="button" class="btn btn-warning btn-xs"><i
                                                    class="ph-repeat"></i>&nbsp;&nbsp;<i class="ph-envelope"></i></button>
                                        </a>
                                        {{-- / --}}
                                        
                                        <?php } } ?>
                                        <?php } ?>

                                    </td>
                                    <td></td>
                                </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /basic layout -->
            </div>
            @endcan
            {{-- / --}}

        </div>


    </div>
@endsection

@push('footer-script')
    <script type="text/javascript">
        $('#initPayroll').submit(function(e) {
            e.preventDefault();
            $('#initPayroll').hide();

            $.ajax({
                url: "{{route('payroll.initPayroll')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false
            })
            .done(function(data) {
                $('#payrollFeedback').fadeOut('fast', function() {
                    $('#payrollFeedback').fadeIn('fast').html(data);
                });
                setTimeout(function() {
                    location.reload();
                }, 1000)
            })
            .fail(function() {
                // alert('Payroll Failed!! ...');
                // Basic initialization
                new Noty({
                    text: 'Payroll Failed!! ...',
                    type: 'error'
                }).show();
            });
        });
    </script>

    <script>
        function approvePayroll() {
            if (confirm("Are You Sure You Want To Approve This Payroll") == true) {
                // var id = id;
                $('#hideList').hide();
                $.ajax({
                    url: "{{route('payroll.runpayroll',$pendingPayroll_month)}}",
                    success: function(data) {
                        if (data.status == 'OK') {
                            alert("Payroll Approved Successifully");

                            // SEND EMAILS
                            if (confirm(
                                    "Payroll Approved Successifully!\n Do you want to send The Payslip as Email to All Employees??"
                                ) == true) {
                                $.ajax({
                                    url: "{{route('payroll.send_payslips',['pendingPayroll_month'=>$pendingPayroll_month])}}",
                                    success: function(data) {}
                                });
                                // SEND EMAILS
                            }

                            $('#payrollFeedback').fadeOut('fast', function() {
                                $('#payrollFeedback').fadeIn('fast').html(data.message);
                            });
                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);
                        } else {
                            alert(
                                "Payroll Approval FAILED, Try again,  If the Error persists Contact Your System Admin."
                                );

                            $('#payrollFeedback').fadeOut('fast', function() {
                                $('#payrollFeedback').fadeIn('fast').html(data.message);
                            });
                        }

                    }

                });
            }
        }
    </script>

    <script>

    </script>


    <script>
        function cancelPayroll() {
            if (confirm("Are You Sure You Want To Cancel This Payroll") == true) {
                // var id = id;
                $('#hideList').hide();
                $.ajax({
                    url: "{{route('payroll.cancelpayroll','none')}}",
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.status == 'OK') {
                            alert("Payroll was Cancelled Successifully!");

                            $('#payrollFeedback').fadeOut('fast', function() {
                                $('#payrollFeedback').fadeIn('fast').html(data.message);
                            });
                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);
                        } else {
                            alert(
                                "FAILED to Cancel Payroll, Try again,  If the Error persists Contact Your System Admin."
                                );

                            $('#payrollFeedback').fadeOut('fast', function() {
                                $('#payrollFeedback').fadeIn('fast').html(data.message);
                            });
                        }

                    }

                });
            }
        }
    </script>

    <script>
        $(function() {
            var minStartDate = "<?php echo date("d/m/Y", strtotime("-1 month") ); ?>";
            var dateToday = "<?php echo date("d/m/Y"); ?>";
            var maxEndDate = "<?php echo date("d/m/Y", strtotime("+1 month") ); ?>";
            $('#payrollDate').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                startDate: dateToday,
                // minDate:minStartDate,
                maxDate: maxEndDate,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleClasses: "picker_1"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");

            });
            $('#payrollDate').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
            $('#payrollDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

    <script>
        function sendEmail(payrollDate) {

            if (confirm(
                    "Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??"
                ) == true) {

                $.ajax({
                    url: "{{route('payroll.send_payslips',['payrollDate'=>" + payrollDate + "])}}",
                    success: function(data) {
                        let jq_json_obj = $.parseJSON(data);
                        let jq_obj = eval(jq_json_obj);
                        if (jq_obj.status === 'SENT') {
                            $('#feedBackMail').fadeOut('fast', function() {
                                $('#feedBackMail').fadeIn('fast').html(
                                    "<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>"
                                );
                            });
                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);
                        } else {
                            $('#feedBackMail').fadeOut('fast', function() {
                                $('#feedBackMail').fadeIn('fast').html(
                                    "<p class='alert alert-danger text-center'>Emails sent error</p>");
                            });
                            setTimeout(function() { // wait for 2 secs(2)
                                location.reload(); // then reload the div to clear the success notification
                            }, 1500);
                        }
                    }
                });
            }
        }
    </script>
@endpush
