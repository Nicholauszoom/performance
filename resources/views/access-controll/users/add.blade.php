@extends('layouts.vertical', ['title' => 'User Create'])

@push('head-script')
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h6 class="mb-0 text-main">
        User Registration
    </h6>
    <span class="text-muted d-block">All the required fields need to be filled</span>
</div>

<form
    action="{{ route('users.store') }}"
    method="POST"
>
    @csrf
    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
        <div class="card-header">
            <h5 class="mb-0 text-warning">User Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Full name:</label>
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Address:</label>
                        <input type="text" name="address" class="form-control" placeholder="" value="{{ old('address')}}">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Phone Number:</label>
                        <input type="text" name="phone" class="form-control" placeholder="255 xxx xxx xxx">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Role:</label>
                        <select class="form-control select" name="role">
                            <option value="" disabled selected>Choose option</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->slug }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <select class="form-control" name="department_id">
                            <option value="">Select Department</option>
                            @if(!empty($department))
                                @foreach($department as $row)
                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Joining Date:</label>
                        <input type="date" name="joining_date" class="form-control" data-format="yyyy/mm/dd" required>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Password:</label>
                        <input type="text" name="password" class="form-control" placeholder="">
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="mb-3">
                        <label class="form-label">Confirm Password:</label>
                        <input type="text" name="comfirmpassword"class="form-control" placeholder="">
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-main px-5">Save</button>
                </div>
            </div>
        </div>

    </div>
</form>



@endsection
