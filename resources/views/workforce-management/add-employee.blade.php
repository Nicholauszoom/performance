@extends('layouts.vertical', ['title' => 'Employee Create'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
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
    method="POST"
    id="addEmployee"
    enctype="multipart/form-data"
    autocomplete="off"
>
    @csrf

    <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header">
            <h5 class="mb-0 text-main">Personal Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="firstName">First name:</label>
                        <input type="text" id="firstName" name="fname" value="{{ old('fname') }}" class="form-control @error('fname') is-invalid @enderror" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="middleName">Middle name:</label>
                        <input type="text" id="middleName" name="mname" value="{{ old('mname') }}" class="form-control @error('mname') is-invalid @enderror" placeholder="Middle Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="lname" value="{{ old('lname') }}" class="form-control @error('lname') is-invalid @enderror" placeholder="Last Name">
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
                        <div class="input-group">
							<span class="input-group-text"><i class="ph-calendar"></i></span>
							<input type="text" class="form-control daterange-single @error('birthdate') is-invalid @enderror" name="bithdate" value="{{ old('birthdate') }}" id="birthdate">
						</div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" placeholder="example@email.com">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Nationality:</label>
                        <select class="form-control select @error('nationality') is-invalid @enderror" name="nationality">
                            <option selected disabled> Select </option>
                            @foreach ($countryDrop as $row)
                            <option value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Maritial Status:</label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status">
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
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
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
                        <input type="text" name="emp_id" value="{{ old('emp_id') }}" class="form-control @error('emp_id') is-invalid @enderror" placeholder="ID : 78609">
                    </div>
                </div>


                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <select class="form-control select @error('department') is-invalid @enderror" id="department" name="department">
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
                        <select class="form-control select1_single select @error('position') is-invalid @enderror" id="pos" name="position">
                            <option value=""> Select Position </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Line Manager:</label>
                        <select class="form-control select @error('linemanager') is-invalid @enderror" id="linemanager" name="linemanager">
                            <option selected disabled> Select </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Company Branch:</label>
                        <select class="form-control select @error('branch') is-invalid @enderror" name="branch" required>
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
                        <select class="form-control select @error('ctype') is-invalid @enderror" name="ctype" required>
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
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract start:</label>

                        <div class="input-group">
							<span class="input-group-text"><i class="ph-calendar"></i></span>
							<input type="text" class="form-control daterange-single @error('contract_start') is-invalid @enderror" name="contract_start" id="contract_start">
						</div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Contract End:</label>

                        <div class="input-group">
							<span class="input-group-text"><i class="ph-calendar"></i></span>
							<input type="text" class="form-control daterange-single @error('contract_end') is-invalid @enderror" name="contract_end" id="contract_end">
						</div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Pension Fund:</label>
                        <select class="form-control select @error('pension_fund') is-invalid @enderror" name="pension_fund">
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
                        <input type="text" maxlength="30" name="pf_membership_no" value="{{ old('pf_membership_no') }}" class="form-control @error('pf_membership_no') is-invalid @enderror" placeholder="Membership No">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Code:</label>
                        <input type="text" name="emp_code" maxlength="30" class="form-control @error('emp_code') is-invalid @enderror" placeholder="code">
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank:</label>
                        <select class="form-control select_bank select @error('bank') is-invalid @enderror" id='bank' name="bank">
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
                        <select class="form-control select_bank_branch select @error('bank_branch') is-invalid @enderror" id="bank_branch" name="banck_branch"></select>
                    </div>
                </div>

                <div id="accountNo" class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Account No:</label>
                        <input type="text" maxlength="15" name="accno" value="{{ old('accno') }}" class="form-control @error('accno') is-invalid @enderror" placeholder="075168023994">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee Mobile:</label>
                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="687 205 600">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal Address:</label>
                        <input type="text" name="postaddress" value="{{ old('postal_address') }}" class="form-control @error('postal_address') is-invalid @enderror" placeholder="P O BOX 1865">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal City:</label>
                        <input type="text" name="postalcity" value="{{ old('postal_city') }}" class="form-control @error('postal_city') is-invalid @enderror" placeholder="Dar Es Salaam">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Physical Address:</label>
                        <input type="text" name="phyaddress" value="{{ old('physical_address') }}" class="form-control @error('physical_address') is-invalid @enderror" placeholder="Physical Address">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Home Address:</label>
                        <input type="text" name="haddress" value="{{ old('haddress') }}" class="form-control @error('haddress') is-invalid @enderror" placeholder=" Home Address ">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">National ID:</label>
                        <input type="text" name="nationalid" value="{{ old('nationalid') }}" class="form-control @error('nationalid') is-invalid @enderror" placeholder="National ID">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Tin:</label>
                        <input type="text" name="tin" value="{{ old('tin') }}" class="form-control @error('tin') is-invalid @enderror" placeholder="tin">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Level:</label>
                        <input type="text" name="emp_level" value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="level">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button class="btn btn-sm btn-main" type="submit">Register Employee</button>
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
                    type: 'POST',
                    url: "{{ route('getPositionSalaryRange') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'positionID=' + positionID,
                    success: function(response) {

                        var response = JSON.parse(response);
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
                        console.log(html);

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

<script>
    $('#addEmployee').submit(function(e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            type: 'POST',
            url: "{{ route('employee.store') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
        .done(function (data) {
            alert(data.tile);

            if (data.status == 'OK'){
                $('#feedBackSubmission').fadeOut('fast', function() {
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });

            }else{
                $('#feedBackSubmission').fadeOut('fast', function() {
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
                $('#addEmployee').trigger("reset");
            }
        })
        .fail(function () {
            alert('Registration Failed');
        });

    });
</script>

<script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }

        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;

        $('#birthdate').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxDate: dateStart,
            minDate: dateEnd,
            startDate: dateStart,
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
            var message = "The Employee is " + years + " Years Old!";
            $('#age').fadeOut('fast', function() {
                $('#age').fadeIn('fast').html(message);
            });

        });
        $('#birthdate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#birthdate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>

<script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#contract_end').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {

        });
        $('#contract_end').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#contract_end').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });

    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear() - 18;
        var endYear = today.getFullYear() - 60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        $('#contract_start').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'), 100),
            minDate: dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {

        });
        $('#contract_start').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#contract_start').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    </script>

@endpush


