@extends('layouts.master')

@section('title')
    <h2><i class="fas fa-th-large pr-2 text-info"></i>User access-controllment</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <strong>Home</strong>
        </li>
        <li class="breadcrumb-item active">
            <strong>Employees</strong>
        </li>
    </ol>
@endsection

@section('content')
<section class="section">
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                   <div class="card-header header-elements-sm-inline">
                        <h4 class="card-title"> Users</h4>
                 
                  <div class="header-elements">                           
                         <a href="{{route('users.create')}}" class="btn btn-outline-info btn-xs edit_user_btn">
                        <i class="fa fa-plus-circle"></i> Add
                    </a>

   </div></div>

                        </ul>
                          <div class="card-body">
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                   <table class="table datatable-basic table-striped" id="table-1">
                                    <thead>
                                    <tr>
                        <th>S/N</th>
                        <th>Full Name</th>
                        
                        <th>Phone Number</th>
                        <th>User Name</th>
                        <th>Role</th>
                   <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($users))
                    @foreach($users as $user)
                    @php $role = "";  @endphp
                    @foreach($user->roles as $value2)
                    @php $role = $value2->id  @endphp
                    @endforeach
                   
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $user->name }}</td>
                            
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $value2)
                                {{ $value2->slug }}
                            @endforeach
                            </td>

                           <td>
                                                    @if($user->disabled == 1)
                                                    <div class="badge badge-danger badge-shadow">Disabled</div>
                                                    @else
                                            <div class="badge badge-success badge-shadow">Available</span>
                                                    @endif
                                                </td>
                            <td>
                         <div class="form-inline">
                        @if($user->disabled == 0)
                     
                       <a class="list-icons-item text-primary" title="Edit" href="{{ route('users.edit', $user->id)}}" onclick="return confirm('Are you sure? you want to Edit')"><i class="icon-pencil7"></i></a>&nbsp&nbsp
                          <a class="list-icons-item text-danger"  title="Disable" onclick="return confirm('Are you sure? you want to disable the user')"  href="{{ route('user.disable', $user->id)}}"><i class="icon-user-cancel"></i></a>&nbsp                               
                                
                                              @endif

                                
                            </div>
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



@endsection

@section('scripts')
<script>
        $(document).on('click', '.edit_user_btn', function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var slug = $(this).data('slug');
            var module = $(this).data('module');
            $('#id').val(id);
            $('#p-name_').val(name);
            $('#p-slug_').val(slug);
            $('#p-module_').val(module);
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
