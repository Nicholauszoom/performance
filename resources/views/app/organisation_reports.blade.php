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
    <h4 class="text-muted">Organisation Financial Reports</h4>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Payroll Reconciliation Summary</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.payrollReconciliationSummary') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>
                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>
                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Payroll Input Changes Approval Report </h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.payrollReportLogs') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>
                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>
                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Payroll Input Journal</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.payrollInputJournalExport') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Pay Checklist</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.pay_checklist') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Master Payroll</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.employeeCostExport') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Employee BioData</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('flex.biodata') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="emp_id" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Employee</option>
                            <?php foreach ($employee as $row) { ?>
                            <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname.' '.$row->mname.' '.$row->lname; ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Gross Reconciliation</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.grossReconciliation') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Net Reconciliation</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.netReconciliation') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Loans</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.loanReports') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Payroll Input Journal (Time)</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.payrollInputJournalExportTime') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="input-group">
                        <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                            <option selected disabled>Select Month</option>
                            <?php foreach ($month_list as $row) { ?>
                            <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Payroll Details</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.payrolldetails') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-10">
                            <div class="input-group">
                                <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                                    <option selected disabled>Select Month</option>
                                    <?php foreach ($month_list as $row) { ?>
                                    <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                            </div>
                        </div>
                    </div>

{{--
                    <div class="row mt-3">
                        <label class="col-form-label col-md-2">Select Date</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="text" class="form-control daterange-predefined" name="duration" placeholder="Select dates">
                            </div>
                        </div>
                    </div> --}}

                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            <div class="card-header">
                <h5 class="text-muted">Annual Leave</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.annualleave') }}"
                data-parsley-validate class="form-horizontal form-label-left">
                @csrf


                <div class="card-body">
                    <div class="row">
                        <label class="col-form-label col-md-2">Employee</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select required name="leave_employee" class="select_payroll_month form-control select" data-width="1%">
                                    <option selected disabled>Select Employee</option>
                                    <option value="All"> All</option>
                                    <?php foreach ($employee as $row) { ?>
                                    <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname.'  '.$row->lname; ?></option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label class="col-form-label col-md-2">Select Date</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select required name="duration" class="select_payroll_month form-control select" data-width="1%">
                                    <option selected disabled>Select Month</option>
                                    <?php foreach ($month_list as $row) { ?>
                                    <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                    <?php } ?>
                                </select>
                                {{-- <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" placeholder="Select dates" value="{{ date('m/d/Y') }} "> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Annual Leave Report</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.annualleave.data') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">

                    <div class="row mt-3">
                        <label class="col-form-label col-md-2">Select Date</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select required name="duration" class="select_payroll_month form-control select" data-width="1%">
                                    <option selected disabled>Select Month</option>
                                    @foreach ($month_list as $row)
                                    <option value="{{$row->payroll_date}}"> {{date('F, Y', strtotime($row->payroll_date))   }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>   
                                {{-- <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" placeholder="Select dates" value="{{ date('m/d/Y') }} "> --}}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Report Format:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">Data table</label>
                            </div>
                        </div>
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

        var startYear = today.getFullYear()-18;
        var endYear = today.getFullYear()-60;
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
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, cb);

        cb(start, end);

    }); -->

    <!-- $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear()-18;
        var endYear = today.getFullYear()-60;
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
            $('#duration_ span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#duration_').daterangepicker({
            singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  }, cb);

        cb(start, end);

    }); -->
</script>
 @endpush
