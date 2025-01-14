



@extends('layouts.vertical', ['title' => 'Configaration'])

@push('head-script')
    <script src="{{ asset('tasset/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0card-outline card-outline-tabs">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
                <a
                    class="nav-link
                    @if(empty($id)) active show @endif"
                    id="home-tab2"
                    data-toggle="tab"
                    href="#home2"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                >System Settings List</a>
            </li>

            <li class="nav-item">
                <a
                    class="nav-link
                    @if(!empty($id)) active show @endif"
                    id="profile-tab2"
                    data-toggle="tab"
                    href="#profile2"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                >New System Settings</a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content tab-bordered" id="myTab3Content">
            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                <div class="table-responsive">
                    <table class="table datatable-basic">
                        <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Browser: activate to sort column ascending"
                                    style="width: 28.531px;">#</th>

                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 186.484px;">Systam Name</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 126.484px;">Email</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 126.484px;">Phone</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 186.484px;">Address</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 126.484px;">VAT</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 186.484px;">TIN</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 126.484px;">System Logo</th>

                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                    rowspan="1" colspan="1"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 98.1094px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!@empty($system))
                            @foreach ($system as $row)
                            <tr class="gradeA even" role="row">
                                <th>{{ $loop->iteration }}</th>
                                <td>{{$row->name}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->address}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->vat}}</td>
                                <td>{{$row->tin}}</td>
                                <td><img src="{{url('public/assets/img/logo')}}/{{$row->picture}}" alt="{{$row->name}}" width="50"></td>



                                <td>
                                   <div class="form-inline">


                                    <a class="list-icons-item text-primary"  title="Edit" onclick="return confirm('Are you sure?')"   href="{{ route("system.edit", $row->id)}}"><i class="icon-pencil7"></i></a>&nbsp

                                            {!! Form::open(['route' => ['system.destroy',$row->id], 'method' => 'delete']) !!}
                                       {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                    {{ Form::close() }}
                                            &nbsp

                                    </div>




                                </td>
                            </tr>
                            @endforeach

                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                <div class="card">
                    <div class="card-header">
                        @if(empty($id))
                        <h5>Create System Settings</h5>
                        @else
                        <h5>Edit System Settings</h5>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                @if(isset($id))
                                {{ Form::model($id, array('route' => array('system.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data")) }}
                                @else
                                {!! Form::open(array('route' => 'system.store',"enctype"=>"multipart/form-data")) !!}
                                @method('POST')
                                @endif

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">System Name</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="name" required
                                            value="{{ isset($data) ? $data->name : ''}}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">VAT</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="vat" required
                                            value="{{ isset($data) ? $data->vat : ''}}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">TIN</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="tin" required
                                            value="{{ isset($data) ? $data->tin : ''}}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Email</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="email" required
                                                value="{{ isset($data) ? $data->email : ''}}"
                                                class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Phone</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="phone" required
                                            value="{{ isset($data) ? $data->phone : ''}}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Address</label>
                                    <div class="col-lg-8">
                                        <input type="text" name="address" required
                                            value="{{ isset($data) ? $data->address : ''}}"
                                            class="form-control">
                                    </div>
                                </div>

                               <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">System Logo</label>
                                    <div class="col-lg-8">
                                        @if (!@empty($data->picture))
                                            <img src="{{url('public/assets/img/logo')}}/{{$data->picture}}" alt="{{$data->name}}" width="100">
                                            <input  type="file" name="picture" required value="{{$data->picture }}" class="form-control" onchange="loadBigFile(event)">
                                        @else
                                            <input  type="file" name="picture" required  class="form-control" onchange="loadBigFile(event)">
                                        @endif

                                        <br>
                                        <img id="big_output" width="100">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                        @if(!@empty($id))
                                        <button class="btn btn-sm btn-main float-right m-t-n-xs"
                                            data-toggle="modal" data-target="#myModal"
                                            type="submit">Update</button>
                                        @else
                                        <button class="btn btn-sm btn-main float-right m-t-n-xs"
                                            type="submit">Save</button>
                                        @endif
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <table class="table datatable-basic">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Action</th>
                <th>IP Adress</th>
                <th>Time performed</th>
                <th>Risk</th>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table> --}}
</div>

@endsection


