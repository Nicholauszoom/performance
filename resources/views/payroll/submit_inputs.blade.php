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
 
    @endphp
            {{-- start of run payroll --}}
      
        

                <div class="col-lg-12">

                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                        <div class="card-header">
                            <h5 class="card-title">Payroll</h5>
                        </div>

                        <div class="card-body">
                            <div id="payrollFeedback"></div>

                            <div class="row">
                                <div class="col-md-12">
                                    <form autocomplete="off" id="initPayroll" method="POST">
                                        <div class="mb-3 row">
                                            @if($pending_payroll == 0)
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
                                                <button name="init" type="submit" class="btn btn-main">Change Payroll Period</button>
                                            </div>
                                            @else
                                        <div class="d-flex justify-content-center align-items-center">
                                            <p class='alert alert-warning text-center'>Note! There is Pending payroll</p>
                                        </div>
                                            @endif

                                        </div>
                                        <div class="d-flex justify-content-end align-items-center">

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div >
   
       

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
                async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    }

            }).done(function(data) {
                $('#payrollFeedback').fadeOut('fast', function() {
                    $('#payrollFeedback').fadeIn('fast').html(data);
                });
                setTimeout(function() {
                    location.reload();
                }, 5000)
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

            // Advanced initialization
            Swal.fire({
                title: 'Are You Sure You Want To Approve This Payroll?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $('#hideList').hide();

                    $.ajax({
                        url: "{{route('payroll.runpayroll',$pendingPayroll_month)}}",
                        async: true,
                beforeSend: function () {
                    $('.request__spinner').show() },
                    complete: function(){

                    }
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
            });

        }
    </script>



    <script>
       
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


@endpush