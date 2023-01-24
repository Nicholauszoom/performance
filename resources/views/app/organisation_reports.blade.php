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
        <div class="card">
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
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-muted">Bank Payment</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.staffPayrollBankExport') }}"
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                <h5 class="text-muted">Employee BioData</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.employeeBioDataExport') }}"
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                        <label class="form-label">Report Type:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="type" value="1" id="p9">
                                <label class="ms-2" for="p9">Staff</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a">
                                <label class="ms-2" for="p9a">temporary</label>
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
                <h5 class="text-muted">Funder</h5>
            </div>

            <form
                id="demo-form2"
                enctype="multipart/form-data"
                method="post"
                action="{{ route('reports.funder') }}"
                data-parsley-validate class="form-horizontal form-label-left"
            >
                @csrf

                <div class="card-body">
                    <div class="row">
                        <label class="col-form-label col-md-2">Project</label>
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


                    <div class="row mt-3">
                        <label class="col-form-label col-md-2">Select Date</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="text" class="form-control daterange-predefined" name="duration" placeholder="Select dates">
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
 <script>
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
            drops: 'up',
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

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
            $('#duration_ span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#duration_').daterangepicker({
            drops: 'up',
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>
 @endpush
