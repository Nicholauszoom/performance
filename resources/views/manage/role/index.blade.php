@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            @include('layouts.alerts.message')
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">



                        <div class="card-header header-elements-sm-inline">
                            <h4 class="card-title">Roles</h4>
                            <div class="header-elements">
                                <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                    <i class="ph-plus me-2"></i>Add
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
                                                    <th>Role Type</th>
                                                    <th>Price</th>
                                                    <th>Permissions</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($roles as $role)
                                                    @if ($role->added_by == auth()->user()->id)
                                                        <tr>
                                                            <th>{{ $loop->iteration }}</th>
                                                            <td>{{ $role->slug }}</td>

                                                            <td>
                                                                @if ($role->status == 1)
                                                                    <p>Public role</p>
                                                                @else
                                                                    <p>Private Role</p>
                                                                @endif
                                                            </td>

                                                            <td>{{ $role->price }}</td>
                                                            <td>
                                                                <a href="{{ route('roles.show', $role->id) }}"
                                                                    class="btn btn-outline-info btn-xs"><i
                                                                        class="fas fa-plus-circle pr-1"></i> Assign </a>
                                                            </td>
                                                            <td>
                                                                {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                                                                <button type="button"
                                                                    class="btn btn-outline-info btn-xs edit_role_btn mr-1"
                                                                    data-toggle="modal" data-id="{{ $role->id }}"
                                                                    data-name="{{ $role->name }}"
                                                                    data-slug="{{ $role->slug }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </button>
                                                                {{ Form::button('<i class="fas fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                {{ Form::close() }}
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
            </div>

            {{-- @include('manage.role.add') --}}
            {{-- @include('manage.role.edit') --}}
        </div>
    </section>
    <div class="modal fade" id="addRoleModal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">
                {{ Form::open(['route' => 'roles.store']) }}
                @method('POST')
                <div class="modal-header py-2 px-2">
                    <h4 class="modal-title">ADD ROLE</h4>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label class="control-label">Role Name</label>
                        <input type="text" class="form-control" name="slug" id="p-slug_">
                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label class="control-label">Role Status</label>
                        <select class="control-label" name="status">
                            <option value="1">Public Role</option>
                            <option value="0">Private Role</option>
                        </select>

                    </div>
                </div>
                <div class="modal-body p-3">
                    <div class="form-group">
                        <label class="control-label">Price Per Public Role</label>
                        <input type="number" class="form-control" name="price" id="p-slug_">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="p-2">
                        <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i>
                            Close</button>
                        <button class="btn btn-primary" type="submit" id="save"><i
                                class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>
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
        $(document).on('click', '.edit_role_btn', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');
            console.log("here");
            $('#r-id_').val(id);
            $('#r-slug_').val(slug);
            $('#r-name_').val(name);
            $('#editRoleModal').modal('show');
        });
    </script>
@endsection
