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
                            <h5 class="card-title">Payslip</h5>
                        </div>
@php
    $empID = auth()->user()->emp_id;
@endphp
                        <div class="card-body">
                            <div id="payrollFeedback">
                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                   
                                   @can('print-payslip')
                                       
                                    <form method="post" action="{{ route('reports.payslip') }}" target="_blank">
                                        @csrf
                                        <div class="card border-0 rounded-0">
                                            <div class="m-3">
                                                <label class="form-label text-warning" for="stream">Pay Slip</label>

                                                <input hidden name="employee" value="{{ $empID }}">
                                                <input hidden name="profile" value="1">

                                                <div class="input-group">
                                                    <select required name="payrolldate" class="select_payroll_month form-control select"
                                                        data-width="1%">
                                                        <option>Select Month</option>
                                                        @foreach ($month_list as $row)
                                                            <option value="{{ $row->payroll_date }}">
                                                                {{ date('F, Y', strtotime($row->payroll_date)) }}</option>
                                                        @endforeach
                                                    </select>

                                                    <button type="submit" class="btn btn-main" type="button"><i
                                                            class="ph-printer me-2"></i> Print</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    @endcan

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
