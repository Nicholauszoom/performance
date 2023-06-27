
@extends('layouts.vertical', ['title' => 'Permissions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
    <div class="card-header border-0">
        <h5 class="mb-0 text-warning">Permissions</h5>
        <div class="header-elements">
            <button type="button" class="btn btn-main float-end" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                <i class="ph-plus me-2"></i>Add Permission
            </button>
        </div>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Slug</th>
                <th>Module</th>
                {{-- <th class="text-center">Actions</th> --}}
            </tr>
        </thead>

        <tbody>
            @if(isset($permissions))
                @foreach($permissions as $permission)


                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $permission->slug }}</td>
                            <td>{{ $permission->modules->slug  ?? '' }}</td>
                            {{-- <td align="right">
                                {!! Form::open(['route' => ['permissions.destroy', $permission->id], 'method' => 'delete']) !!}
                                <button type="button" class="btn btn-outline-info btn-xs edit_permission_btn"
                                        data-toggle="modal"
                                        data-id="{{$permission->id}}"
                                        data-name="{{$permission->name}}"
                                        data-slug="{{$permission->slug}}"
                                        data-module="{{ isset($permission->modules->id) ? $permission->modules->id:'' }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                {{ Form::button('<i class="fas fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) }}
                                {{ Form::close() }}
                            </td> --}}
                        </tr>

                @endforeach
            @endif
        </tbody>
    </table>
</div>
@include('access-controll.permission.add')
@endsection



