@extends('layouts.vertical', ['title' => 'Employee Approval'])

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
        <h5 class="mb-0 text-muted">Pending Approval</h5>
    </div>

    <div class="card-body">
        <!-- Highlighted tabs -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card card-primary card-outline card-outline-tabs border-0 shadow-none">

                    <div class="card-header border-0 shadow-none">
                        <ul class="nav nav-tabs nav-tabs-highlight">
                            @include('workforce-management.approve.inc.tab')
                        </ul>
                    </div>

                    <div class="card-body border-0 shadow-none">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="{{ route('approve.register') }}" role="tabpanel">
                                <div class="card border-0 shadow-none">
                                    <div class="card-header border-0 shadow-none">
                                        <h5 class="text-muted">Current Employee Register</h5>
                                    </div>
                                </div>

                                <table class="table datatable-basic">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($transfer as $row )
                                            @if ( $row->status<5 || $row->status > 5 )
                                                <tr>
                                                    <td width="1px"> {{ $row->SNo }}</td>
                                                    <td> {{ $row->empName }} </td>
                                                    <td>
                                                        <p><strong>Department :</strong> {{ $row->department_name }}</p>
                                                        <p><strong>Position :</strong> {{ $row->position_name }}</p>
                                                    </td>
                                                    <td> {{ $row->parameter }} </td>
                                                    <td>
                                                        <div id="{{ 'status'.$row->id }}">
                                                            @if ( $row->status == 5 )
                                                                <div class="col-md-12"><span class="label label-default">WAITING</span></div>
                                                            @elseif ( $row->status == 6 )
                                                                <div class="col-md-12"><span class="label label-success">ACCEPTED</span></div>
                                                            @elseif ( $row->status == 7 )
                                                                <div class="col-md-12"><span class="label label-danger">REJECTED</span></div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="options-width">
                                                        <a
                                                            href="#"
                                                            title="Employee Info and Details"
                                                            class="icon-2 info-tooltip"
                                                        >
                                                            <button
                                                                type="button"
                                                                class="btn btn-info btn-xs"
                                                            >
                                                                <i class="fa fa-info-circle"></i>
                                                            </button>
                                                        </a>

                                                        @if ( $row->status == 5 )
                                                            <a href="javascript:void(0)" onclick="disapproveRegistration(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>
                                                        @elseif ($row->parameterID==5)
                                                            <a href="javascript:void(0)" onclick="approveRegistration(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /highlighted tabs -->
    </div>

</div>

@endsection


