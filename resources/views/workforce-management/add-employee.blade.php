@extends('layouts.vertical', ['title' => 'Employee Create'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h6 class="mb-0">
        Employee Registration
    </h6>
    <span class="text-muted d-block">All the required fields need to be filled</span>
</div>

<form
    action="{{ route('employee.store') }}"
    method="POST"
>
    @csrf

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 text-muted">Personal Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="firstName">First name:</label>
                        <input type="text" id="firstName" name="fname" value="{{ old('fname') }}" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="middleName">Middle name:</label>
                        <input type="text" id="middleName" name="mname" value="{{ old('mname') }}" class="form-control" placeholder="Middle Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="lname" value="{{ old('lname') }}" class="form-control" placeholder="Last Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Gender:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" name="gender" value="MALE" id="dc_li_c">
                                <label class="ms-2" for="dc_li_c">Male</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" name="gender" value="Female" id="dc_li_u">
                                <label class="ms-2" for="dc_li_u">Femal</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Birthdate:</label>
                        <input type="date" name="birthdate" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="example@email.com">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Nationality:</label>
                        <select class="form-control select" name="nationality">
                            <option selected disabled> Select </option>
                            <option value="255">Tanzania</option>
                            <option value="254">Kenya</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Maritial Status:</label>
                        <select class="form-control" name="merital_status">
                            <option selected disabled> Select </option>
                            <option value="MARRIED">Married</option>
                            <option value="SINGLE">Single</option>
                            <option value="WIDOW">Widow</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Photo:</label>
                        <input type="file" class="form-control" name="photo">
                        <div class="form-text text-muted">Accepted formats: png, jpg. Max file size 2Mb</div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="card-header">
            <h5 class="mb-0 text-muted">Work Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee ID:</label>
                        <input type="text" name="emp_id" value="{{ old('emp_id') }}" class="form-control" placeholder="ID : 78609">
                    </div>
                </div>


                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <select class="form-control select" name="department">
                            <option selected disabled> Select </option>
                            <option value="1">Finance</option>
                            <option value="2">Information Technology</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Position:</label>
                        <select class="form-control select" name="position">
                            <option selected disabled> Select </option>
                            <option value="1">Manager</option>
                            <option value="2">Position 2</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Line Manager:</label>
                        <select class="form-control select" name="line_manager">
                            <option selected disabled> Select </option>
                            <option value="DOUGLAS FORTUNATUS">Douglas Fortunatus</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Company Branch:</label>
                        <select class="form-control select" name="branch" required>
                            <option selected disabled> Select </option>
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Basic Salary:</label>
                        <input type="number" min="0" name="salary" class="form-control" placeholder="100,000">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract start:</label>
                        <input type="date" name="contract_start" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract End:</label>
                        <input type="date" name="contract_end" value="{{ old('contract_end') }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Pension Fund:</label>
                        <select class="form-control select" name="pension_fund">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Membership No:</label>
                        <input type="text" name="pf_membership_no" value="{{ old('pf_membership_no') }}" class="form-control" placeholder="Membership No">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Code:</label>
                        <input type="text" name="" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank:</label>
                        <select class="form-control select" name="bank">
                            <option value="1">CRDB</option>
                            <option value="2">NMB</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Branch:</label>
                        <select class="form-control select" name="banck_branch">
                            <option value="1">Arizona</option>
                            <option value="2">Colorado</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Account No:</label>
                        <input type="text" name="account_no" value="{{ old('account_no') }}" class="form-control" placeholder="01J85784784785">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee Mobile:</label>
                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="656 205 600">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal Address:</label>
                        <input type="text" name="postal_address" value="{{ old('postal_address') }}" class="form-control" placeholder="P O BOX 1865">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal City:</label>
                        <input type="text" name="postal_city" value="{{ old('postal_city') }}" class="form-control" placeholder="Dar Es Salaam">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Physical Address:</label>
                        <input type="text" name="physical_address" value="{{ old('physical_address') }}" class="form-control" placeholder="Physical Address">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Home Address:</label>
                        <input type="text" name="home" value="{{ old('home') }}" class="form-control" placeholder=" Home Address ">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">National ID:</label>
                        <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control" placeholder="National ID">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Tin:</label>
                        <input type="text" name="tin" value="{{ old('tin') }}" class="form-control" placeholder="tin">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Level:</label>
                        <input type="text" name="level" value="{{ old('level') }}" class="form-control" placeholder="level">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-sm btn-primary" type="submit">Register Employee</button>
        </div>
    </div>
</form>


{{--
    - We need to be able to upload employee as a bacth
    - We will shift this on top as part of a dropdown link
    --}}
<form action="">
    <div class="card">
        <div class="card-body">
            <div class="row">
                upload all employees from here
            </div>
        </div>
    </div>
</form>


@endsection
