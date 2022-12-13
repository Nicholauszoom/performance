@extends('layouts.vertical', ['title' => 'Overtime'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script> --}}
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script> --}}
@endpush

@section('content')
    <!-- Basic datatable -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5>Overtime</h5>

                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#add_overtime">
                    <i class="ph-plus me-2"></i> Overtime
                </button>
            </div>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success center" align='center' role="alert">
                <p class="text-center" >{{ Session::get('success') }}</p>
            </div>
        @endif
        <table class="table datatable-save-state">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Percent Amount(Day)</th>
                    <th>Percent Amount(Night)</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                   $SN=1
                @endphp
                @if (isset($data['overtimes']))
                    @foreach ($data['overtimes'] as $row)
                        <tr>
                            <td>{{ $SN++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->day_percent }}</td>
                            <td>{{ $row->night_percent }}</td>
                            <td align="center">
                                

                                <button
                                    type="button"
                                    id="edit"
                                    class="btn btn-outline-info btn-xs edit_permission_btn"
                                     data-toggle="modal" 
                                    {{-- data-id="{{ $row->id }}"
                                    data-name="{{ $row->name }}" --}}
                                >
                                    <i class="ph-note-pencil"></i> Edit
                                </button>
                                <button
                                    type="button"
                                    id="edit"
                                    onclick="editOvertime({{$row->id}})"
                                    class="btn btn-outline-danger btn-xs edit_permission_btn"
                                     data-toggle="modal" 
                                    {{-- data-id="{{ $row->id }}"
                                    data-name="{{ $row->name }}" --}}
                                >
                                    <i class="ph-trash"></i> Delete
                                </button>

                                {{-- {{ Form::button('<i class="ph-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}
                                {{ Form::close() }} --}}
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
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
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>


    {{--Modal section--}}
    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="editt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content py-4 px-2">
                <div class="modal-body">
                    <div id="message"></div>
                </div>
    
                <div class="row">
                    <div class="col-sm-4">
    
                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                        <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                    </div>
                    <div class="col-sm-2">
    
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    <!-- /basic datatable -->
@endsection

@section('modal')
    @include('setting.overtime.add')
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
                            <div class="tab-pane fade @if (empty($id)) active show @endif" id="home2" role="tabpanel"
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
                    @if (isset($departments))
                    @foreach ($departments as $departments)

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




@endsection --}}
<script>
    function editOvertime(id) {
        const message = "Are you sure you want to delete?";
      $('#editt').modal('show');
      $('#editt').find('.modal-body #message').text(message);
    }
 </script>
 @section('scripts')
 
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
@endsection 
