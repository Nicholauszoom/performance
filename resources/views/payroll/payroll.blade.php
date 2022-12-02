@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
@include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Payroll</h5>
    </div>

    <div class="card-body">
        Payslip Mail Delivery List
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
