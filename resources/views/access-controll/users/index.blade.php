@extends('layouts.vertical', ['title' => 'User'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_advanced.js') }}"></script>
@endpush


@section('content')

<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">

    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="text-warning"> User Management</h5>

            <a href="{{ route('users.create') }}" class="btn btn-main">ADD</a>
        </div>
    </div>

    <table class="table datatable-show-all">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @if(isset($users))
                @foreach($users as $user)
                    {{-- @php $role = ";  @endphp --}}

                    @foreach($user->roles as $value2)
                        @php $role = $value2->id  @endphp
                    @endforeach

                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $user->fname }}  {{ $user->mname }}  {{ $user->lname }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $value2)
                                {{ $value2->slug }}
                            @endforeach
                        </td>
                        <td>
                            @if($user->disabled == 1)
                                <span class="badge bg-danger bg-opacity-10 text-danger">Disabled</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success">Available</span>
                            @endif
                        </td>

                        <td>
                            <div class="form-inline">

                                    <a class="list-icons-item text-primary" title="Edit" href="{{ route('users.edit', $user->id)}}" onclick="return confirm('Are you sure? you want to Edit')"><i class="ph-pen"></i></a>&nbsp&nbsp
                                    <a class="list-icons-item text-danger"  title="Disable" onclick="return confirm('Are you sure? you want to disable the user')"  href="{{ route('user.disable', $user->id)}}"><i class="ph-x"></i></a>&nbsp

                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection



