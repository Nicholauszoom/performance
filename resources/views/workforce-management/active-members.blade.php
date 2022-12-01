@extends('layouts.vertical', ['title' => 'Page starter'])

@push('head-script')
    <script src="{{ asset('tasset/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tasset/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_advanced.js') }}"></script>
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

    <table class="table datatable-show-all">
        <thead>
            <tr>
                <th>S\No</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Line Manager</th>
                <th>Contacts</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            {{-- @foreach ($audits as $audit) --}}
            <tr>
                <td>01</td>
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



