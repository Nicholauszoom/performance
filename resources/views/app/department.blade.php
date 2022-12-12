@extends('layouts.vertical', ['title' => 'Departments'])

@push('head-script')
    {{-- <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    {{-- <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
@php
$employee = $data['employee'];
@endphp



  <!-- Basic datatable -->
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
          <h5 class="mb-0">Departments</h5>
          <button   type="button"
                    class="btn btn-perfrom"
                    data-bs-toggle="modal"
                    data-bs-target="#save_department">
                    <i class="ph-plus me-2"></i> Department
          </button>
          </div>
          
        </div>
       <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>HOD</th>
                    <th>Reports To</th>
                    <th>State</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @if(isset($data['departments']))
                    @foreach($data['departments'] as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td> HOD </td>
                            <td> Upper level </td>
                            <td> Active </td>

                            <td align="center">
                                {!! Form::open(['route' => ['departments.destroy', $department->id], 'method' => 'delete']) !!}

                                <button
                                    type="button"
                                    class="btn btn-outline-info btn-xs edit_permission_btn"
                                    data-toggle="modal"
                                    data-id="{{ $department->id }}"
                                    data-name="{{ $department->name }}"
                                >
                                    <i class="ph-note-pencil"></i> Edit
                                </button>

                                {{ Form::button('<i class="ph-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}
                                {{ Form::close() }}
                            </td>
                        </tr>

                    @endforeach
                    @endif
            </tbody>
        </table>
      </div>
  <!-- /basic datatable -->

    <!-- Basic datatable -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Disabled Departments</h5>
        </div>
        <table class="table datatable-basic">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Job Title</th>
              <th>DOB</th>
              <th>Status</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Marth</td>
              <td><a href="#">Enright</a></td>
              <td>Traffic Court Referee</td>
              <td>22 Jun 1972</td>
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

@include('organisation.department.inc.add')

@endsection


{{-- @section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                     <div class="card-header header-elements-sm-inline">
                <h4 class="card-title"> Departments</h4>
                <div class="header-elements">


                       <button type="button" class="btn btn-outline-info btn-xs px-4 pull-right"
                            data-toggle="modal" data-target="#addPermissionModal">
                        <i class="fa fa-plus-circle"></i>
                        Add
                    </button>

                          </div>

              </div>


                    <div class="card-body">


                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">





                                    <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($departments))
                    @foreach($departments as $departments)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $permission->name }}</td>

                            <td align="center">
                                {!! Form::open(['route' => ['departments.destroy', $permission->id], 'method' => 'delete']) !!}
                                <button type="button" class="btn btn-outline-info btn-xs edit_permission_btn"
                                        data-toggle="modal"
                                        data-id="{{$permission->id}}"
                                 data-name="{{$permission->name}}"
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                {{ Form::button('<i class="fas fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}
                                {{ Form::close() }}
                            </td>
                        </tr>

                    @endforeach
                    @endif
                    </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@include('access-controll.department.add')
@include('access-controll.department.edit')

@endsection --}}

{{-- @section('scripts')
<script>
        $(document).on('click', '.edit_permission_btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#id').val(id);
            $('#p-name_').val(name);
            $('#editPermissionModal').modal('show');
        });
    </script>
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },

        });
    </script>
@endsection --}}
