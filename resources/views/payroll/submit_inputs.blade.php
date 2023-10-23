@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/form_layouts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <div class="col-lg-12">

        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <h5 class="card-title">Payroll Inputs</h5>
            </div>

            <div class="card-body">
                <div id="payrollFeedback"></div>

                <div class="row">
                    <div class="col-md-12">
                        <form autocomplete="off" id="submitInputs" method="POST">
                            <div class="mb-3 row">
                                @if($pending_payroll == 0)
                                    <div class="col-7 row">
                                        <label class="form-label col-md-3 text-center font-bold">
                                            <h6>Payroll Month:</h6>
                                        </label>

                                        <div class="col-md-9">
                                            <input type="date" required placeholder="Payroll Month" name="date" class="form-control col-md-7 has-feedback-left" id="payrollDate" aria-describedby="inputSuccess2Status">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <button name="init" type="submit" class="btn btn-main">Submit</button>
                                    </div>
                                @else

                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class='alert alert-warning text-center'>Note! There is Pending payroll</p>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end align-items-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div >
@endsection

@push('footer-script')
    <script type="text/javascript">
        $('#submitInputs').submit(function(e) {
            e.preventDefault();
            $('#initPayroll').hide();

            $.ajax({
                url: "{{route('flex.submitInputs')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: true,
            }).done(function(data) {
                $('#payrollDate').prop('disabled', true );

                $('#payrollFeedback').fadeOut('fast', function() {
                    // $('#payrollFeedback').fadeIn('fast').html(data);
                });
                setTimeout(function() {
                    location.reload();
                }, 3000)
            })
            .fail(function(data) {
                new Noty({
                    text: 'Payroll Failed!! ...',
                    type: 'error'
                }).show();
            });

        });
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
