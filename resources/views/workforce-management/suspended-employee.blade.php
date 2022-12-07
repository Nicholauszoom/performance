@extends('layouts.vertical', ['title' => 'Suspended Employees'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/tables/datatables/extensions/responsive.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_responsive.js') }}"></script>
@endpush


@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Deactivated Employees</h5>
    </div>

    <div class="card-body">
        <table class="table datatable-responsive-column-controlled">
            <thead>
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Gender</th>
                    {{-- <th hidden>empID</th> --}}
                    <th>Position</th>
                    <th>Linemanager</th>
                    <th>Contacts</th>
                    <th>Inactive Since</th>
                    <th>Options</th>
                  </tr>
            </thead>

            <tbody>
                @foreach ($employee1 as $row)
                   <tr>
                        <td></td>
                        <td>{{ $row->SNo }}</td>
                        <td><a href="{{ route('employee.profile') }}">{{ $row->NAME }}</a></td>
                        <td>{{ $row->gender }}</td>
                        {{-- <td hidden>{{ $row->emp_id }}</td> --}}
                        <td>
                            <p><strong>Department :</strong> {{ $row->DEPARTMENT }}</p>
                            <p><strong>Position :</strong> {{ $row->POSITION }}</p>
                        </td>
                        <td>{{ $row->LINEMANAGER }}</td>
                        <td>
                            <p><strong>Email :</strong> {{ $row->email }}</p>
                            <p><strong>Mobile :</strong> {{ $row->mobile }}</p>
                        </td>
                        <td>{{ $row->dated }}</td>
                        <td>
                            @if ( $row->isRequested == 0 )
                                <a
                                    href="javascript:void(0)"
                                    title="Request Activation"
                                    class="icon-2 info-tooltip btn btn-success text-white btn-xs"
                                    id="reactivate"
                                >
                                    <i class="ph-check-square"></i>
                                </a>
                            @else
                                <span class="badge bg-primary"> <small> ACTIVATION &nbsp; <br> &nbsp;REQUESTED</small> </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
              </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Exit Employee List</h5>
    </div>

    <div class="card-body">
        <table class="table datatable-responsive-column-controlled">
            <thead>
                <tr>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Position</th>
                        <th>Linemanager</th>
                        <th>Contacts</th>
                        <th>Status</th>
                        <th>Options</th>
                      </tr>
                </tr>
            </thead>

            <tbody>
                @foreach ($employee1 as $row)
                   <tr>
                        <td></td>
                        <td>{{ $row->SNo }}</td>
                        <td><a href="{{ route('employee.profile') }}">{{ $row->NAME }}</a></td>
                        <td>{{ $row->gender }}</td>
                        {{-- <td hidden>{{ $row->emp_id }}</td> --}}
                        <td>
                            <p><strong>Department :</strong> {{ $row->DEPARTMENT }}</p>
                            <p><strong>Position :</strong> {{ $row->POSITION }}</p>
                        </td>
                        <td>{{ $row->LINEMANAGER }}</td>
                        <td>
                            <p><strong>Email :</strong> {{ $row->email }}</p>
                            <p><strong>Mobile :</strong> {{ $row->mobile }}</p>
                        </td>
                        <td>{{ $row->dated }}</td>
                        <td>
                            @if ( $row->isRequested == 0 )
                                <a
                                    href="javascript:void(0)"
                                    title="Request Activation"
                                    class="icon-2 info-tooltip btn btn-success text-white btn-xs"
                                    id="reactivate"
                                >
                                    <i class="ph-check-square"></i>
                                </a>
                            @else
                                <span class="badge bg-primary"> <small> ACTIVATION &nbsp; <br> &nbsp;REQUESTED</small> </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
              </tbody>

        </table>
    </div>
</div>

@endsection



