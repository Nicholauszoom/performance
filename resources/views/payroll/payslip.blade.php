@extends('layouts.vertical', ['title' => 'Payslip'])

@push('head-script')
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
@include('layouts.shared.page-header')
@endsection

@section('content')
<div class="card">

    <div class="card-header">
        Employee
    </div>

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Employee Type hjjj:</label>
            <select class="form-control select">
                <option value="AZ">Active</option>
                <option value="CO">Exited</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Employee Name:</label>
            <select class="form-control select">
                <option value="AZ">Name 01</option>
                <option value="CO">Name 02</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Payroll Month:</label>
            <select class="form-control select">
                <option value="AZ">October, 2022</option>
                <option value="CO">November, 2022</option>
                <option value="AZ">October, 2022</option>
                <option value="CO">November, 2022</option>
            </select>
        </div>

        <div class="d-flex">
            <button class="btn btn-success btn-md" style="margin-right: 10px">CANCEL</button>
            <button class="btn btn-primary btn-md">PRINT</button>
        </div>

        <hr>

        <div class="mb-3">
            <label class="form-label">Payslip Type:</label>

            <div class="">
                <div class="d-inline-flex align-items-center me-3">
                    <input type="checkbox" id="dc_li_c">
                    <label class="ms-2" for="dc_li_c">Staff</label>
                </div>

                <div class="d-inline-flex align-items-center">
                    <input type="checkbox" id="dc_li_u">
                    <label class="ms-2" for="dc_li_u">Volunteer</label>
                </div>
            </div>
        </div>

        <button class="btn btn-success btn-md" style="margin-right: 10px">Print all</button>

    </div>


</div>

<div class="card">

    <div class="card-body">
        <div class="card-header">
            <div class="d-flex justify-content-center align-items-center">
                <h5>Payslip Mail Delivery List</h5>

                <button class="btn btn-main">
                    <i class="ph-plus me-2"></i> Apply Overtime
                </button>
            </div>
        </div>

    </div>

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
            <tr>
                <td> 1 </td>
                <td> November, 2022 </td>
                <td>
                    <span class="badge bg-warning bg-opacity-10 text-warning">Pending</span>
                </td>
                <td>
                    <span class="badge bg-warning bg-opacity-10 text-warning">Not sent</span>
                </td>
                <td>
                    <div class="d-flex">
                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-danger bg-opacity-20 text-danger btn-xs">
                                        <i class="ph-x"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Resend Pay Slip as Email"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                        <i class="ph-repeat"></i>
                                        <i class="ph-envelope"></i>
                                    </button>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td> 2 </td>
                <td> July, 2022 </td>
                <td>
                    <span class="badge bg-success bg-opacity-20 text-success">Approved</span>
                </td>
                <td>
                    <span class="badge bg-warning bg-opacity-10 text-warning">Not sent</span>
                </td>
                <td>
                    <div class="d-flex">
                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-danger bg-opacity-20 text-danger btn-xs">
                                        <i class="ph-x"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Info and Details"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-info bg-opacity-20 text-info btn-xs">
                                        <i class="ph-info"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Checklist Report Not Ready"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                        <i class="ph-file-text"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Send Pay Slip as Email"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-success bg-opacity-20 text-success btn-xs">
                                        <i class="ph-envelope"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Resend Pay Slip as Email"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                        <i class="ph-repeat"></i>
                                        <i class="ph-envelope"></i>
                                    </button>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td> 3 </td>
                <td> October, 2022 </td>
                <td>
                    <span class="badge bg-success bg-opacity-20 text-success">Approved</span>
                </td>
                <td>
                    <span class="badge bg-success bg-opacity-20 text-success">Sent</span>
                </td>
                <td>
                    <div class="d-flex">
                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-danger bg-opacity-20 text-danger btn-xs">
                                        <i class="ph-x"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Info and Details"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-info bg-opacity-20 text-info btn-xs">
                                        <i class="ph-info"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Checklist Report Not Ready"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                        <i class="ph-file-text"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Send Pay Slip as Email"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn bg-success bg-opacity-20 text-success btn-xs">
                                        <i class="ph-envelope"></i>
                                    </button>
                            </a>
                        </span>

                        <span style="margin-right: 4px">
                            <a href="javascript:void(0)" onclick="cancelPayroll()" title="Resend Pay Slip as Email"
                                    class="icon-2 info-tooltip">
                                    <button type="button" class="btn  bg-warning bg-opacity-20 text-warning btn-xs">
                                        <i class="ph-repeat"></i>
                                        <i class="ph-envelope"></i>
                                    </button>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>

@endsection
