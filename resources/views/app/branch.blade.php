@extends('layouts.vertical', ['title' => 'Contracts'])

@push('head-script')
    {{-- <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script> --}}
@endpush

@push('head-scriptTwo')
    {{-- <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script> --}}
@endpush

@section('content')
 <div class="right_col" role="main">
     <div class="page-title">
                <div class="title_left">
                    <h3>Organisation</h3>
                </div>
            </div>
  <!-- Basic datatable -->
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-0">Company Branches</h5>
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
            @if(!empty($branch))
            @foreach($branch as $row)
            <tr>
              <td>{{ $row->name }}</td>
              <td></td>
              <td></td>
              <td> </td>

              <td>

            </tr>
            @endforeach
            @endif
          </tbody>
        </table>
      </div>
  <!-- /basic datatable -->


@endsection

@section('modal')

@include('organisation.branch.add')

@endsection


{{-- @section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                     <div class="card-header header-elements-sm-inline">
                <h4 class="card-title"> List of Positions</h4>
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

</div>


@include('access-controll.department.add')
@include('access-controll.department.edit')

@endsection --}}

{{-- @section('scripts')

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
