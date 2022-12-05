@extends('layouts.vertical', ['title' => 'Active Employees'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>


	{{-- <script src="../../../assets/js/vendor/tables/datatables/datatables.min.js"></script> --}}
	<script src="{{ asset('assets/js/components/tables/datatables/extensions/responsive.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    {{-- <script src="{{ asset('assets/js/pages/datatables_advanced.js') }}"></script> --}}

    <script src="{{ asset('assets/js/pages/datatables_extension_responsive.js') }}"></script>

@endpush


@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Employee</h5>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5>List of employees</h5>

            <a href="{{ route('employee.create') }}" class="btn btn-primary">Register Employee</a>
        </div>
    </div>

    <table class="table datatable-responsive-column-controlled">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Line Manager</th>
                <th>Contacts</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>

        <tbody>
            {{-- @foreach ($audits as $audit) --}}
            <tr>
                <td></td>
                <td><a href="#">Douglas Fortunatus Mkonyi</a></td>
                <td>Male</td>
                <td>Software Developer</td>
                <td>Laison Marko</td>
                <td>0656 206 600</td>
                <td class="text-center">
                    <div class="d-inline-flex">
                      <div class="dropdown">
                        <a
                          href="#"
                          class="text-body"
                          data-bs-toggle="dropdown"
                        >
                          <i class="ph-list"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                          <a href="#" class="dropdown-item">
                            <i class="ph-info me-2"></i>
                            Info
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="ph-file-xls me-2"></i>
                            Disable
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="ph-file-doc me-2"></i>
                            Update
                          </a>
                          <a href="#" class="dropdown-item">
                            <i class="ph-file-doc me-2"></i>
                            Evaluate
                          </a>
                        </div>
                      </div>
                    </div>
                  </td>

            </tr>


            {{-- @endforeach --}}
        </tbody>
    </table>
</div>

@endsection



