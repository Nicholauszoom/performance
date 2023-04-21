@extends('layouts.vertical', ['title' => 'Organisatin Reports'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>

    <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/picker_date.js') }}"></script>
@endpush

@section('content')
    <div class="mb-3">
        <h4 class="text-main">Password Reset</h4>
    </div>

    <div class="row">

        <div class="col-md-12">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">

                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="POST" action="{{ route('flex.passwordAutogenerate') }}"
                    data-parsley-validate class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="emp_id" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option selected disabled>Select Employee</option>
                                <option value="all" >All </option>
                                <?php foreach ($employee as $row) { ?>
                                <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . ' ' . $row->mname . ' ' . $row->lname; ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Reset</button>
                        </div>


                    </div>
                </form>
            </div>
        </div>









    </div>
@endsection

@push('footer-script')
    
    <!-- <script>
        $(function() {
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth() + 1; //January is 0!

                    var startYear = today.getFullYear() - 18;
                    var endYear = today.getFullYear() - 60;
                    if (dd < 10) {
                        dd = '0' + dd;
                    }
                    if (mm < 10) {
                        mm = '0' + mm;
                    }


                    var dateStart = dd + '/' + mm + '/' + startYear;
                    var dateEnd = dd + '/' + mm + '/' + endYear;
                    var start = moment().subtract(29, 'days');
                    var end = moment();

                    function cb(start, end) {
                        $('#duration span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    }

                    $('#duration').daterangepicker({
                        singleDatePicker: true,
                    });
                    -- >

                    <
                    !--$(function() {
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!

                        var startYear = today.getFullYear() - 18;
                        var endYear = today.getFullYear() - 60;
                        if (dd < 10) {
                            dd = '0' + dd;
                        }
                        if (mm < 10) {
                            mm = '0' + mm;
                        }


                        var dateStart = dd + '/' + mm + '/' + startYear;
                        var dateEnd = dd + '/' + mm + '/' + endYear;
                        var start = moment().subtract(29, 'days');
                        var end = moment();

                        function cb(start, end) {
                            $('#duration_ span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                                'MMMM D, YYYY'));
                        }

                        $('#duration_').daterangepicker({
                            singleDatePicker: true,
                            showDropdowns: true,
                            minYear: 1901,
                            maxYear: parseInt(moment().format('YYYY'), 10)
                        }, cb);

                        cb(start, end);

                    });
                    -- >
    </script>
@endpush
