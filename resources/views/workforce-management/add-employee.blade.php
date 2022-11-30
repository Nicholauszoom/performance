@extends('layouts.vertical', ['title' => 'Employee Create'])

@push('head-script')
<script src="{{ asset('tasset/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('tasset/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('tasset/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h6 class="mb-0">
        Employee Registration
    </h6>
    <span class="text-muted d-block">All the required fields need to be filled</span>
</div>

<form action="">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 text-muted">Personal Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">First name:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Middle name:</label>
                        <input type="text" name="fname" class="form-control" placeholder="Middle Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="fname" class="form-control" placeholder="Last Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Gender:</label>

                        <div class="">
                            <div class="d-inline-flex align-items-center me-3">
                                <input type="radio" id="dc_li_c" checked>
                                <label class="ms-2" for="dc_li_c">Male</label>
                            </div>

                            <div class="d-inline-flex align-items-center">
                                <input type="radio" id="dc_li_u">
                                <label class="ms-2" for="dc_li_u">Femal</label>
                            </div>
                        </div>

                        {{-- <input type="text" name="fname" class="form-control" placeholder="First Name"> --}}
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Birthdate:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Nationality:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Maritial Status:</label>
                        <select class="form-control">
                            <option value="MARRIED">Married</option>
                            <option value="SINGLE">Single</option>
                            <option value="Widow">Widow</option>
                        </select>
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
                        <input type="text" name="fname" class="form-control" placeholder="ID : 78609">
                    </div>
                </div>


                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Position:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Line Manager:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Company Branch:</label>
                        <select class="form-control select">
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
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract start:</label>
                        <input type="date" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract End:</label>
                        <input type="date" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Pension Fund:</label>
                        <select class="form-control select">
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
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Code:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Branch:</label>
                        <select class="form-control select">
                            <option value="AZ">Arizona</option>
                            <option value="CO">Colorado</option>
                            <option value="ID">Idaho</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Account No:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee Mobile:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal Address:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal City:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Physical Address:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Home Address:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">National ID:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Tin:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Level:</label>
                        <input type="text" name="fname" class="form-control" placeholder="First Name">
                    </div>
                </div>
            </div>
        </div>


    </div>
</form>


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
