@extends('layouts.vertical', ['title' => 'Contracts'])

@push('head-script')
    {{-- <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script> --}}
@endpush

@push('head-scriptTwo')
    {{-- <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script> --}}
@endpush

@section('content')

  <!-- Basic datatable -->
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-0">Cost Center</h5>
            <button   type="button"
                    class="btn btn-perfrom"
                    data-bs-toggle="modal"
                    data-bs-target="#addPermissionModal">
                    <i class="ph-plus me-2"></i>Add New
            </button>
          </div>
          
        </div>
        <table class="table datatable-basic">
          <thead>
            <tr>
              <th>Name</th>
              <th>Department</th>
              <th>Location</th>
              <th class="text-center">Option</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Marth</td>
              <td>Enright</td>
              
              <td>
                <span class="badge bg-success bg-opacity-10 text-success"
                  >Active</span
                >
              </td>
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
                        <i class="ph-file-pdf me-2"></i>
                        Export to .pdf
                      </a>
                      <a href="#" class="dropdown-item">
                        <i class="ph-file-xls me-2"></i>
                        Export to .csv
                      </a>
                      <a href="#" class="dropdown-item">
                        <i class="ph-file-doc me-2"></i>
                        Export to .doc
                      </a>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  <!-- /basic datatable -->


@endsection

@section('modal')

@include('organisation.branch.add')

@endsection


