@extends('layouts.vertical', ['title' => 'System Role'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <section class="section">
        <div class="section-body">
            @include('layouts.alerts.message')

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                        <div class="card-header header-elements-sm-inline">
                            <h4 class="card-title text-warning">Roles</h4>

                            <div class="header-elements">
                                <button type="button" class="btn btn-main float-end" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                    <i class="ph-plus me-2"></i>Add Role
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped" id="table-1">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    @can('assign-permissions')
                                                        <th>Permissions</th>
                                                    @endcan


                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    <tr>
                                                        <th>{{ $loop->iteration }}</th>
                                                        <td>{{ $role->slug }}</td>

                                                        @can('assign-permissions')
                                                            <td>
                                                                <a href="{{ route('roles.show', $role->id) }}"
                                                                    class="btn btn-main btn-xs"><i
                                                                        class="fas fa-plus-circle pr-1"></i> Assign </a>
                                                            </td>
                                                        @endcan


                                                        <td>
                                                            {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}


                                                            @can('edit-role')
                                                                
                                                            <button type="button" class="btn btn-main btn-sm edit_role_btn mr-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editRoleModal_{{ $role->id }}"
                                                            data-id="{{ $role->id }}"
                                                            data-name="{{ $role->name }}"
                                                            data-slug="{{ $role->slug }}">
                                                        <i class="ph-note-pencil"></i>
                                                    </button>

                                                            {{ Form::button('<i class="ph-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}

                                                            @endcan

                                                        </td>
                                                    </tr>

                                                    @include('access-controll.role.edit')

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end of card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0 --}}
                </div>
                {{-- end of col --}}
            </div>
            {{-- end of row --}}

        </div>
    </section>

    @include('access-controll.role.add')

@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [1]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>

<script>
    $(document).ready(function () {
        $('.edit_role_btn').on('click', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');

            $('#r-id_' + id).val(id);
            $('#r-slug_' + id).val(slug);
            $('#r-name_' + id).val(name);

            $('#editRoleModal_' + id).modal('show');
        });

        // Function to handle the update action (adjust as needed)
        function updateRole(roleId) {
            // Add logic to handle updating the role here
            // You may use Ajax to send the updated data to the server
            $('#editRoleModal_' + roleId).modal('hide');
        }
    });
</script>


@endsection
