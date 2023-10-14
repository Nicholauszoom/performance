@extends('layouts.vertical', ['title' => 'Employee Password'])

@section('content')

<div class="row">
    <div class="col-md-6 offset-3">
        <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <div class="d-flex justify-content-between mb-3">
                    <h4 class="text-main">Update Password</h4>

                    <a href="<?php echo  url('') .'/flex/userprofile/'.auth()->user()->emp_id; ?>" class="btn btn-main btn-xs">Back</a>
                </div>

                @if (session()->has('status'))
                <div class="alert alert-success border-0 alert-dismissible fade show">
                    <span class="fw-semibold">Well done!</span> You successfully <a href="#" class="alert-link">{{ session('status') }}</a> your password.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            </div>

            <div class="card-body">
                <form action="{{ route('password.profile') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="emp_id" value="{{ auth()->user()->emp_id }}">

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>

                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('current_password') }}"
                        >

                        @error('current_password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('password') }}"
                        >

                        @error('password')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control @error('password', 'confirmed') is-invalid @enderror"
                            required
                            autocomplete="off"
                            value="{{ old('password_confirmation') }}"
                        >

                        @error('password', 'confirmed')
                        <p class="text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-main">Update password</button>
                    </div>

                </form>
            </div>
        </div>


    </div>
</div>


@endsection
