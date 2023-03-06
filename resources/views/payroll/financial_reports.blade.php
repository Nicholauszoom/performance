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
        <h5 class="text-main">Statutory Reports</h5>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <div class="card-header">
                    <h5 class="text-warning">P9 (P.A.Y.E)</h5>
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
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">PDF </label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Data Table </label>
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
                    <h5 class="text-warning">Workers Compasation Fund:</h5>
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
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">PDF </label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Data Table </label>
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
                    <h5 class="text-warning">Pension Fund</h5>
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
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">PDF </label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Data Table </label>
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
                    <h5 class="text-warning">Skills Development Levy SDL (P10)</h5>
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
                                    <label class="ms-2" for="period2">JULY to DECEMBER</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <label class="form-label">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">PDF </label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Data Table </label>
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
                    <h5 class="text-warning">HESLB:</h5>
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
                            <label class="form-label font-w-semibold">Report Format:</label>

                            <div class="">
                                <div class="d-inline-flex align-items-center me-3">
                                    <input type="radio" name="type" value="1" id="p9">
                                    <label class="ms-2" for="p9">PDF </label>
                                </div>

                                <div class="d-inline-flex align-items-center">
                                    <input type="radio" name="type" value="2" id="p9a">
                                    <label class="ms-2" for="p9a">Data Table </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    
    </div>


@endsection
