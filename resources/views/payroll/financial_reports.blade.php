@extends('layouts.vertical', ['title' => 'Financial Reports'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush


@section('content')
    @php
        $month_list = $data['month_list'];
        $year_list = $data['year_list'];
    @endphp

    <div class="mb-3">
        <h5 class="text-muted">Statutory Reports</h5>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">P9 (P.A.Y.E)</h5>
                </div>

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('reports.p9')}}" target="_blank"
                    data-parsley-validate
                    class="form-horizontal form-label-left"
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
                                    <label class="ms-2" for="p9">Staff Payroll</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Volunteer Payroll</label>
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
                    <h5 class="text-muted">Workers Compasation Fund:</h5>
                </div>

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('reports.wcf')}}"
                    target="_blank"
                    data-parsley-validate
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
                            <button type="submit" class="btn btn-main" type="button"><i class="ph-printer me-2"></i> Print</button>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Type:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">Staff Payroll</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Volunteer Payroll</label>
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
                    <h5 class="text-muted">Skills Development Levy SDL (P10)</h5>
                </div>

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('reports.p10')}}"
                    target="_blank"
                    data-parsley-validate
                >
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                                <option selected disabled>Select Month</option>
                                <?php foreach ($month_list as $row) {?>
                                <option value="<?php echo $row->payroll_date; ?>"> <?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-main" type="button"><i class="ph-printer me-2"></i> Print</button>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">For Period:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="period" value="1" id="period1">
                                    <label class="ms-2" for="period1">JANUARY to JUNE</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="period" value="2" id="period2">
                                    <label class="ms-2" for="period2">JULY to DECEMBERl</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Type:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">Staff Payroll</label>
                                </div>

        <div class="row offset-2">
            <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Statutory Reports</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">

                </form>



                        <!-- PANEL-->
                        <div class="card">
                            <div class="card-header">
                                <h2>P9 (P.A.Y.E)</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="card-body py-3">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                    action="{{ route('reports.p9')}}" target="_blank"
                                    data-parsley-validate class="form-horizontal form-label-left">
                                    @csrf

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate"
                                                class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                        foreach ($month_list as $row) {
                                            # code... ?>
                                                <option value="<?php echo $row->payroll_date; ?>">
                                                    <?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                                            <input type="submit" value="PRINT" name="run" class="btn btn-primary" />
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php //echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                </form>

        <div class="col-md-6">

            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">Pension Fund</h5>
                </div>

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('reports.pension')}}"
                    target="_blank"
                    data-parsley-validate
                >
                    @csrf

                    <div class="card-body">
                        <div class="input-group">
                            <select required name="payrolldate" class="select_payroll_month form-control select" data-width="1%">
                                <option selected disabled>Select Month</option>
                                <?php foreach ($month_list as $row) { ?>
                                <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option>
                                <?php } ?>
                            </select>
                            <button type="submit" class="btn btn-main" type="button"><i class="ph-printer me-2"></i> Print</button>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Select Fund:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="fund" value="2">
                                    <label class="ms-2" for="period1">NSSF</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Type:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">Staff Payroll</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Volunteer Payroll</label>
                                </div>
                            </div>
                        </div>

                </form>



            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-muted">HESLB:</h5>
                </div>

                <form
                    id="demo-form2"
                    enctype="multipart/form-data"
                    method="post"
                    action="{{ route('reports.heslb')}}"
                    target="_blank"
                    data-parsley-validate
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
                            <button type="submit" class="btn btn-main" type="button"><i class="ph-printer me-2"></i> Print</button>
                        </div>

                        <div class="mt-2">
                            <label class="form-label font-w-semibold">Report Type:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">Staff Payroll</label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Volunteer Payroll</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


@endsection
