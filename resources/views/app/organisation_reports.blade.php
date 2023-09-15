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
        <h4 class="text-main">Organisation Financial Reports</h4>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">Payroll Reconciliation Summary</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.payrollReconciliationSummary') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select" required
                                data-width="1%">
                                <option selected disabled value="">Select Month</option>
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
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Payroll Reconciliation Details</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.payrollReconciliationDetails') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option selected disabled value="">Select Month</option>
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
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Journal Entry Summary  Report</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.journalEntryReport') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option selected disabled value="">Select Month</option>
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
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Payroll Input Changes Approval Report </h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.payrollReportLogs') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option selected disabled value="">Select Month</option>
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
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>
                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                <h5 class="text-warning">Payroll Input Journal</h5>
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
                                <input type="radio" name="type" value="1" id="p9" required>
                                <label class="ms-2" for="p9">PDF</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="type" value="2" id="p9a" required>
                                <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Pay Checklist</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.payroll_report1') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required  name="pdate" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option selected disabled value="">Select Month</option>
                                <?php foreach ($month_list as $row) { ?>
                                <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                        </div>
                        <div class="input-group py-2">
                            <select required name="format" class="select_payroll_month form-control select" data-width="1%">
                                <option selected disabled value="">Select doc format</option>

                                <option value="1">PDF</option>
                                <option value="2">Excel</option>

                            </select>

                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">TZS</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">USD</label>
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
                    <h5 class="text-warning">Employee BioData</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post" action="{{ route('flex.biodata') }}"
                    data-parsley-validate class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="emp_id" class="select_payroll_month form-control select"
                                data-width="1%">
                                <option value="All" selected >All</option>
                                <?php foreach ($employee as $row) { ?>
                                <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . ' ' . $row->mname . ' ' . $row->lname; ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i> Print</button>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Payroll Details</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.payrolldetails') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-10">
                                <div class="input-group">
                                    <select required name="payrolldate" class="select_payroll_month form-control select"
                                        data-width="1%">
                                        <option selected disabled value="">Select Month</option>
                                        <?php foreach ($month_list as $row) { ?>
                                        <option value="<?php echo $row->payroll_date; ?>"> <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                        <?php } ?>
                                    </select>
                                    <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                        Print</button>
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
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Pension History</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.employee_pension') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf


                    <div class="card-body">
                        <div class="row">
                            <label class="col-form-label col-md-2">Employee</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <select required name="emp_id" class="select_payroll_month form-control select"
                                        data-width="1%">
                                        <option selected disabled value="">Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>
                                    <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                        Print</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
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
                    <h5 class="text-warning">Leave Report(monthly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.annualleave') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf


                    <div class="card-body">
                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="">&nbsp;</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department" name="department" required>
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos" name="position" required>
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="leave_employee"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled value=""`>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" placeholder="Select dates" value="{{ date('Y-m-d') }} " required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <div class="d-inline-flex align-items-left px-5">
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
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
                    <h5 class="text-warning">Leave Report(yearly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.annualleave2') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf


                    <div class="card-body">
                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="">&nbsp;</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department1" name="department">
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos1" name="position">
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="leave_employee"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" placeholder="Select dates" required value="{{ date('Y-m-d') }} " required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <div class="d-inline-flex align-items-left px-5">
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
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
                    <h5 class="text-warning">Approved Leave Applications(monthly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.annualleave.data') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="">&nbsp;</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department2" name="department">
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos2" name="position">
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="emp_id"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" required placeholder="Select dates" value="{{ date('Y-m-d') }} ">
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">Approved Leave Applications(yearly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.annualleave.year') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="">&nbsp;</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department3" name="department">
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos3" name="position">
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="emp_id"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" required placeholder="Select dates" value="{{ date('Y-m-d') }} ">
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">Pending Leave Applications(monthly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.leave.pending.monthly') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="">&nbsp;</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department4" name="department">
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos4" name="position">
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="emp_id"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" required placeholder="Select dates" value="{{ date('Y-m-d') }} ">
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">Pending Leave Applications(yearly)</h5>
                </div>

                <form id="demo-form2" enctype="multipart/form-data" method="post"
                    action="{{ route('reports.leave.pending.yearly') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf

                    <div class="card-body">

                        <div class="row">
                            <label class="col-form-label col-md-3">Leave Type</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control form-select required select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature" required>
                                        <option value="All">All</option>
                                          <?php
                                          foreach($leave_type as $key){  ?>

                                         <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?> Leave</option>

                                         <?php  } ?>
                                      </select>

                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Department:</label>
                                    <select class="form-control select @error('department') is-invalid @enderror" id="department5" name="department">
                                        <option value="All"> All </option>
                                        @foreach ($departments as $depart)
                                        <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Position:</label>
                                    <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos5" name="position">
                                        <option value="All"> All </option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row py-3">
                            <label class="col-form-label col-md-3">Employee</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select required name="emp_id"
                                        class="select_payroll_month form-control select" data-width="1%">
                                        <option selected disabled>Select Employee</option>
                                        <option value="All"> All</option>
                                        <?php foreach ($employee as $row) { ?>
                                        <option value="<?php echo $row->emp_id; ?>"> <?php echo $row->fname . '  ' . $row->lname; ?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label class="col-form-label col-md-3">Select Date</label>
                            <div class="col-md-9">
                                <div class="input-group">

                                    <span class="input-group-text"><i class="ph-calendar"></i></span>
                                <input type="date" class="form-control date" name="duration" placeholder="Select dates" value="{{ date('Y-m-d') }} " required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9" required>
                                    <label class="ms-2" for="p9">PDF</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a" required>
                                    <label class="ms-2" for="p9a">Excel</label>
                                </div>
                                <button type="submit" class="btn btn-main"><i class="ph-printer me-2"></i>
                                    Print</button>
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
    $(document).ready(function() {

        $('#department').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos option").remove();

                        $('#pos').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });

        $('#department1').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos1 option").remove();

                        $('#pos1').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos1').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });
        $('#department2').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos2 option").remove();

                        $('#pos2').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos2').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });
        $('#department3').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos3 option").remove();

                        $('#pos3').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos3').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });

        $('#department4').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos4 option").remove();

                        $('#pos4').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos4').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });

        $('#department5').on('change', function() {
            var stateID = $(this).val();

            console.log(stateID);

            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/flex/positionFetcher') }}',
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        console.log(jq_obj);

                        //populate position
                        $("#pos5 option").remove();

                        $('#pos5').append($('<option>', {
                            value: 'All',
                            text: 'All',
                            selected: true,
                            //disabled: true
                        }));


                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos5').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];

                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        // $("#linemanager option").remove();
                        // $('#linemanager').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Line Manager',
                        //     selected: true,
                        //     disabled: true
                        // }));

                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });



    });
</script>

@endpush
