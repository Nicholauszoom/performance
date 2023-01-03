@extends('layouts.vertical', ['title' => 'Dashboard'])

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
    <h6 class="mb-0">Employee Registration</h6>
    <span class="text-muted d-block">All the required fields need to be filled</span>
</div>

<form
    id="addEmployee"
    enctype="multipart/form-data"
    autocomplete="off"
    method="post"
    data-parsley-validate
>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 text-muted">Personal Details</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="firstName">First name:</label>
                        <input type="text" id="firstName" pattern="[a-zA-Z]+" maxlength="15" title="Only enter letters" name="fname" id="name" value="{{ old('fname') }}" class="form-control @error('fname') is-invalid @enderror" placeholder="First Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="middleName">Middle name:</label>
                        <input type="text" id="middleName" name="mname" value="{{ old('mname') }}" class="form-control @error('mname') is-invalid @enderror" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters" placeholder="Middle Name">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Last name:</label>
                        <input type="text" name="lname" value="{{ old('lname') }}" class="form-control @error('lname') is-invalid @enderror" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters" placeholder="Last Name">
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
                                <label class="ms-2" for="dc_li_u">Female</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" maxlength="30" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" placeholder="example@email.com">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Nationality:</label>
                        <select class="form-control select_country select @error('nationality') is-invalid @enderror" name="nationality">
                            <option selected disabled> Select </option>
                            @foreach ($countrydrop as $row)
                            <option value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Maritial Status:</label>
                        <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Birthdate:</label>
                        <div class="input-group">
							<span class="input-group-text"><i class="ph-calendar"></i></span>
							<input type="text" placeholder="Date of Birth" class="form-control daterange-single @error('birthdate') is-invalid @enderror" name="bithdate" value="{{ old('birthdate') }}" id="birthdate">
						</div>
                        <span id="age" class="text-danger"></span>
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
                        <input type="text" maxlength="30" name="emp_id" value="{{ old('emp_id') }}" class="form-control @error('emp_id') is-invalid @enderror" placeholder="ID : 78609">
                    </div>
                </div>


                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Department:</label>
                        <select class="form-control select @error('department') is-invalid @enderror" id="department" name="department">
                            <option value=""> Select Department </option>
                            @foreach ($ddrop as $depart)
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
                        <select class="form-control select2_single select" id="linemanager" name="linemanager">
                            <option selected disabled> Select Line manager </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Company Branch:</label>
                        <select class="form-control select_branch select @error('branch') is-invalid @enderror" name="branch" required>
                            <option value=""> Select </option>
                            @foreach ($branch as $row)
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
                        <select class="form-control select_pension select @error('pension_fund') is-invalid @enderror" name="pension_fund">
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
                        <input type="text" name="emp_code" maxlength="30" class="form-control @error('emp_code') is-invalid @enderror" placeholder="code" required>
                    </div>
                </div>

                <hr class="my-4">

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank:</label>
                        <select class="form-control select_bank select @error('bank') is-invalid @enderror" id='bank' name="bank">
                            <option value="">Select Employee Bank</option>
                            @foreach ($bankdrop as $bank)
                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Branch:</label>
                        <select class="form-control select_bank_branch select" id="bank_branch" name="bank_branch"></select>
                    </div>
                </div>

                <div id="accountNo" class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Bank Account No:</label>
                        <input type="text" maxlength="15" name="accno" value="{{ old('accno') }}" class="form-control @error('accno') is-invalid @enderror">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Employee Mobile:</label>
                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" maxlength="14">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal Address:</label>
                        <input type="text" name="postaddress" value="{{ old('postal_address') }}" class="form-control @error('postal_address') is-invalid @enderror" maxlength="15">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Postal City:</label>
                        <input type="text" name="postalcity" value="{{ old('postal_city') }}" class="form-control @error('postal_city') is-invalid @enderror" maxlength="15">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Physical Address:</label>
                        <input type="text" name="phyaddress" value="{{ old('physical_address') }}" class="form-control @error('physical_address') is-invalid @enderror" maxlength="25">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Home Address:</label>
                        <input type="text" name="haddress" value="{{ old('haddress') }}" class="form-control @error('haddress') is-invalid @enderror" maxlength="25">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">National ID:</label>
                        <input type="text" name="nationalid" value="{{ old('nationalid') }}" class="form-control @error('nationalid') is-invalid @enderror" maxlength="150">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">TIN:</label>
                        <input type="text" name="tin" value="{{ old('tin') }}" class="form-control @error('tin') is-invalid @enderror" maxlength="100">
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">
                    <div class="mb-3">
                        <label class="form-label">Job Level:</label>

                        <select name="emp_level" id="" class="form-select select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="25">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                        </select>

                        {{-- <input type="text" name="emp_level" value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" maxlength="30" required> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-white">
            <button class="btn btn-sm btn-main" type="submit">Register Employee</button>
        </div>
    </div>

</form>


<form id="import_form" class="mt-2" method="post">
    <div class="card">
        <div class="card-header">
            <a href="{{ url('template/employee_upload_template.xls') }}">
                Click here to download employees template
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Upload Employees In Batch:</label>
                        <input type="file" required accept=".xls, .xlsx" class="form-control @error('file') is-invalid @enderror" name="file">
                        <div class="form-text text-muted">Accepted formats: xls, xlsx. Max file size 2Mb</div>
                    </div>

                    <button type="submit" class="pull-right btn btn-main">Upload Employee</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('footer-script')
    {{-- Populating banches according to the bank selected --}}
    <script>
        $(document).ready(function() {
            $('#accountNo').show();
            $('#bank').on('change', function() {
                var bankID = $(this).val();
                if (bankID) {

                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/flex/bankBranchFetcher/") }}',
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
    {{-- / --}}

    {{-- getting salaries according to the position selected --}}
    <script>
        $(document).ready(function() {
            $('#pos').on('change', function() {
                var positionID = $(this).val();
                if (positionID) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/flex/getPositionSalaryRange/") }}',
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
    {{-- / --}}

    <script>
        $(document).ready(function() {

            $('#department').on('change', function() {
                var stateID = $(this).val();

                console.log(stateID);

                if (stateID) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/flex/positionFetcher") }}',
                        data: 'dept_id=' + stateID,
                        success: function(html) {
                            let jq_json_obj = $.parseJSON(html);
                            let jq_obj = eval(jq_json_obj);

                            console.log(jq_obj);

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


    <script type="text/javascript">

        $('#addEmployee').submit(function(e) {

            e.preventDefault(); // Prevent Default Submission

            // alert(document.getElementById("name"));

            $.ajax({
                    url: '{{ url("/flex/registerEmployee") }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    data: $(this).serialize(), // it will serialize the form data
                    dataType: 'json'
                })
                .done(function(data) {
                    alert(data.title);

                    if (data.status == 'OK') {
                        $('#feedBackSubmission').fadeOut('fast', function() {
                            $('#feedBackSubmission').fadeIn('fast').html(data.message);
                        });
                        setTimeout(function() { // wait for 5 secs(2)
                            window.location.href =
                                "<?php echo url('flex/userprofile/?id=');?>" + data
                                .empID; // then reload the page.(3)
                        }, 2000);
                        $('#addEmployee').trigger("reset");
                    } else {
                        $('#feedBackSubmission').fadeOut('fast', function() {
                            $('#feedBackSubmission').fadeIn('fast').html(data.message);
                        });
                        $('#addEmployee').trigger("reset");

                    }
                })
                .fail(function() {
                    alert('Registration Failed, Review Your Network Connection...');
                });
        });


        $('#import_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                //url: '{{ url("/flex/import") }}',
                url: '{{ route("import.employee") }}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#file').val('');
                    load_data();
                    alert(' Employees Succefully Imported');
                }
            })
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
