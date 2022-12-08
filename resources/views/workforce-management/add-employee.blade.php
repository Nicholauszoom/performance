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
                                <input type="radio" name="gender" value="Male" id="dc_li_c">
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
                        <select class="form-control" name="status">
                            <option selected disabled> Select </option>
                            <option value="Married">Married</option>
                            <option value="Single">Single</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                </div>

                {{-- <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Photo:</label>
                        <input type="file" class="form-control" name="photo">
                        <div class="form-text text-muted">Accepted formats: png, jpg. Max file size 2Mb</div>
                    </div>
                </div> --}}
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
                        <select class="form-control select" id="department" name="department">
                            <option value=""> Select Department </option>
                            @foreach ($departments as $depart)
                            <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Position:</label>
                        <select class="form-control select1_single select" id="pos" name="position">
                            <option value=""> Select Position </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Line Manager:</label>
                        <select class="form-control select" id="linemanager" name="linemanager">
                            <option selected disabled> Select </option>
                            <option value="DOUGLAS FORTUNATUS">Douglas Fortunatus</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Company Branch:</label>
                        <select class="form-control select" name="branch" required>
                            <option value=""> Select </option>
                            @foreach ($company_branch as $row)
                            <option value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract Type:</label>
                        <select class="form-control select" name="ctype" required>
                            <option value="" selected disabled>Select type</option>
                            @foreach ($contract as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Basic Salary:</label>
                        <div id="salaryField"></div>
                        {{-- <input type="number" min="0" name="salary" class="form-control" placeholder="100,000"> --}}
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
                            <option value="">Select Pension Fund</option>
                            @foreach ($pensiondrop as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Membership No:</label>
                        <input type="text" maxlength="30" name="pf_membership_no" value="{{ old('pf_membership_no') }}" class="form-control" placeholder="Membership No">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Code:</label>
                        <input type="text" name="emp_code" maxlength="30" class="form-control" placeholder="First Name">
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank:</label>
                        <select class="form-control select_bank select" id='bank' name="bank">
                            <option value="">Select Employee Bank</option>
                            @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Branch:</label>
                        <select class="form-control select_bank_branch select" id="bank_branch" name="banck_branch"></select>
                    </div>
                </div>

                <div id="accountNo" class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Account No:</label>
                        <input type="text" maxlength="15" name="accno" value="{{ old('account_no') }}" class="form-control" placeholder="01J85784784785">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee Mobile:</label>
                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="687 205 600">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal Address:</label>
                        <input type="text" name="postaddress" value="{{ old('postal_address') }}" class="form-control" placeholder="P O BOX 1865">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal City:</label>
                        <input type="text" name="postalcity" value="{{ old('postal_city') }}" class="form-control" placeholder="Dar Es Salaam">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Physical Address:</label>
                        <input type="text" name="phyaddress" value="{{ old('physical_address') }}" class="form-control" placeholder="Physical Address">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Home Address:</label>
                        <input type="text" name="haddress" value="{{ old('haddress') }}" class="form-control" placeholder=" Home Address ">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">National ID:</label>
                        <input type="text" name="nationalid" value="{{ old('nationalid') }}" class="form-control" placeholder="National ID">
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
                        <input type="text" name="emp_level" value="{{ old('emp_level') }}" class="form-control" placeholder="level">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-sm btn-primary" type="submit">Register Employee</button>
        </div>
    </div>
</form>

@endsection

@push('footer-script')

<script>
    $(document).ready(function() {
        $('#accountNo').show();

        $('#bank').on('change', function() {
            var bankID = $(this).val();
            if (bankID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('bankBranchFetcher') }}",
                    data: 'bank=' + bankID,
                    success: function(html) {
                        $('#bank_branch').html(html);
                    }
                });
                if (bankID == "5") {
                    $('#accountNo').hide();
                } else {
                    $('#accountNo').show();
                }
            } else {
                $('#bank_branch').html('<option >Select Bank First</option>');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#pos').on('change', function() {
            var positionID = $(this).val();
            if (positionID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('getPositionSalaryRange') }}",
                    data: 'positionID=' + positionID,
                    success: function(response) {
                        $('#salaryField').fadeOut('fast', function() {
                            $('#salaryField').fadeIn('fast').html(response.salary);
                        });
                    }
                });
            } else {

            }
        });
    });
</script>

<script>
    $(document).ready(function() {

        $('#department').on('change', function() {
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('positionFetcher') }}",
                    data: 'dept_id=' + stateID,
                    success: function(html) {
                        let jq_json_obj = $.parseJSON(html);
                        let jq_obj = eval(jq_json_obj);

                        //populate position
                        $("#pos option").remove();
                        $('#pos').append($('<option>', {
                            value: '',
                            text: 'Select Position',
                            selected: true,
                            disabled: true
                        }));
                        $.each(jq_obj.position, function(detail, name) {
                            $('#pos').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                        var x = [];
                        $.each(jq_obj.linemanager, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);
                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });
                        $.each(jq_obj.director, function(detail, name) {
                            var y = {};
                            y.name = name.NAME;
                            y.id = name.empID;
                            x.push(y);

                            // $('#linemanager').append($('<option>', {value: name.empID, text: name.NAME}));
                        });

                        var flags = [];
                        var output = [];
                        for (var i = 0; i < x.length; i++) {
                            var y = {};
                            if (flags[x[i].id]) continue;
                            flags[x[i].id] = true;
                            y.id = x[i].id;
                            y.name = x[i].name;
                            output.push(y);
                        }

                        //populate linemanager
                        $("#linemanager option").remove();
                        $('#linemanager').append($('<option>', {
                            value: '',
                            text: 'Select Line Manager',
                            selected: true,
                            disabled: true
                        }));
                        $.each(output, function(detail, name) {
                            $('#linemanager').append($('<option>', {
                                value: name.id,
                                text: name.name
                            }));
                        });

                    }
                });
            } else {
                // $('#pos').html('<option value="">Select state first</option>');
            }
        });
    });
</script>

@endpush


