@extends('layouts.vertical', ['title' => 'Allowance'])

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
    {{-- <div class="card">
        <div class="card-header">
                    <i class="ph-plus me-2"></i> Allowance

                </button>
            </div>

        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th align="center">Action</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $SN = 1;
                @endphp
                @if (isset($data['allowance']))
                    @foreach ($data['allowance'] as $row)
                        <tr>
                            <td>{{ $SN++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->amount }}</td>
                            </td>
                            <td align="center">


                                <button type="button" class="btn btn-outline-info btn-xs edit_permission_btn"
                                    data-toggle="modal" data-id="" data-name="">
                                    <i class="ph-note-pencil"></i> Edit
                                </button>

                                {{ Form::button('<i class="ph-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}

                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div> --}}


    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Allowances</h5>
                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#save_allowance">
                    <i class="ph-plus me-2"></i> Allowance
                </button>
            </div>
            @if (Session::has('success'))
                <div class="alert alert-success" role="alert">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </tr>
            </thead>

            <tbody>
                @php
                    $SN = 1;
                @endphp
                @if (isset($data['allowance']))
                    @foreach ($data['allowance'] as $row)
                        <tr>
                            <td>{{ $SN++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->amount }}</td>
                            {{-- <td>
                                <a href="{{ route('flex.organization_level_info', [$row->id]) }}"
                                    class="btn btn-perfrom">View</a>
                            </td> --}}
                            <td>

                                {{-- <a href="{{ route('flex.allowance_info', [$row->id]) }}"
                                    class="btn btn-outline-info btn-xs">
                                    <i class="ph-note-pencil"></i>Edit</a> --}}

                                <button type="button" id="edit" onclick="editOvertime({{ $row->id }})"
                                    class="btn btn-outline-danger btn-xs edit_permission_btn" data-toggle="modal"
                                    {{-- data-id="{{ $row->id }}"
                                    data-name="{{ $row->name }}" --}}>
                                    <i class="ph-trash"></i> Delete
                                </button>
                        </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->



@endsection

@section('modal')
    @include('setting.allowance.add')
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
