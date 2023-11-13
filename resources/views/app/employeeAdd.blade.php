@extends('layouts.vertical', ['title' => 'Employee Add'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/form_validation_styles.js') }}"></script>
@endpush

@section('content')
    <div class="mb-3">
        <h6 class="mb-0 text-main">Employee Registration</h6>
        <span class="text-muted d-block">All the required fields need to be filled</span>
    </div>

    <form id="addEmployee" enctype="multipart/form-data" autocomplete="off" method="post" data-parsley-validate>

        <div class="card  border-top  border-top-width-3 border-top-main rounded-0">
            {{-- Personal details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Personal Details</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="fname">First name  <span class="text-danger">*<span></label>
                            <input type="text" id="fname" pattern="[a-zA-Z]+" maxlength="15" title="Only enter letters" name="fname" id="name" value="{{ old('fname') }}" class="form-control" placeholder="First Name" required>
                            <span id="fname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="mname">Middle name</label>
                            <input type="text" id="mname" name="mname" value="{{ old('mname') }}" class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters" placeholder="Middle Name">
                            <span id="mname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="lname">Last name <span class="text-danger">*<span> </label>
                            <input type="text" id="lname" name="lname" value="{{ old('lname') }}" class="form-control" maxlength="15" pattern="[a-zA-Z]+" title="Only enter letters" placeholder="Last Name" required>
                            <span id="lname-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Gender <span class="text-danger">*<span></label>

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
                            <label for="email" class="form-label">Email <span class="text-danger">*<span></label>
                            <input id="email" type="email" maxlength="30" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="example@email.com" required>
                            <span id="email-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="nationality">Nationality <span class="text-danger">*<span></label>
                            <select class="form-control select_country select" name="nationality" id="nationality" required>
                                <option selected disabled> Select </option>
                                @foreach ($countrydrop as $row)
                                <option value="{{ $row->code }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <span id="nationality-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="status">Maritial Status <span class="text-danger">*<span></label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                            <span id="status-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="bithdate">Birthdate <span class="text-danger">*<span></label>
                            <input type="date" placeholder="Date of Birth" class="form-control" name="bithdate" value="{{ old('bithdate') }}" id="bithdate" required>
                            <span id="age" class="text-danger"></span>
                            <span id="bithdate-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- /Personal details section --}}

            <hr>

            {{-- Work Details section --}}
            <div class="card-header">
                <h5 class="mb-0 text-warning">Work Details</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="department">Department <span class="text-danger">*<span></label>
                            <select class="form-control select" id="department" name="department" required>
                                <option value=""> Select Department </option>
                                @foreach ($ddrop as $depart)
                                <option value="{{ $depart->id }}">{{ $depart->name }}</option>
                                @endforeach
                            </select>
                            <span id="department-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="position">Position <span class="text-danger">*<span></label>
                            <div class="mb-3 form-control-feedback" id="position-loader">
                                <select class="form-control select1_single select" id="position" name="position" required>
                                    <option value=""> Select Position </option>
                                </select>
                                <div class="form-control-feedback-icon d-flex align-items-center justify-content-end text-end px-3 d-none" id="pos-loader" style="width: 100% !important; background: transparent">
                                    <i class="ph-spinner spinner me-2"></i>
                                </div>
                            </div>
                            <span id="position-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="linemanager">Line Manager <span class="text-danger">*<span></label>
                            <select name="linemanager" id="linemanager" class="form-control select2_single select" required>
                                <option selected disabled>Select line Manager</option>
                                @foreach ($ldrop as $row)
                                <option value="{{ $row->empID }}"> {{ $row->empID }} - {{ $row->NAME }}</option>
                                @endforeach
                            </select>
                            <span id="linemanager-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="branch">Company Branch <span class="text-danger">*<span></label>
                            <select class="form-control select_branch select" name="branch" required id="branch">
                                <option value=""> Select </option>
                                @foreach ($branch as $row)
                                <option value="{{ $row->code }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <span id="branch-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="ctype">Contract Type <span class="text-danger">*<span></label>
                            <select class="form-select select" name="ctype" id="ctype" required>
                                <option value="" selected disabled>Select type</option>
                                @foreach ($contract as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <span id="ctype-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="salary">Basic Salary <span class="text-danger">*<span></label>
                            <div id="salaryField"></div>
                            <span id="salary-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="currency">Currency <span class="text-danger">*<span></label>
                            <div class="input-group">
                                <select required id="currency" name="currency" class="select_group form-control select" data-width="1%">
                                    <option selected disabled>Select Currency</option>
                                    @foreach ($currencies as $row)
                                    <option value="<?php echo $row->currency; ?>"><?php echo $row->currency; ?></option>
                                    @endforeach
                                </select>
                            </div>
                            <span id="currency-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="cost_center">Cost Center <span class="text-danger">*<span></label>
                            <div class="input-group">
                                <select required name="cost_center" class="select_group form-control select" id="cost_center" data-width="1%">
                                    <option selected disabled>Select Cost Center</option>
                                    <option value="Management">Management</option>
                                    <option value="Non Management">Non Management</option>
                                </select>
                            </div>
                            <span id="cost_center-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="contract_start">Contract start <span class="text-danger">*<span></label>
                            <input type="date" class="form-control daterange-single" name="contract_start" id="contract_start">
                            <span id="contract_start-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="contract_end">Contract End <span class="text-danger">*<span></label>
                            <input type="date" class="form-control daterange-single" name="contract_end" id="contract_end">
                            <span id="contract_end-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="leave_day">Leave Days Etitled <span class="text-danger">*<span></label>
                            <input type="number" class="form-control daterange-single" name="leave_day" id="leave_day">
                            <span id="leave_day-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" id="pension_fund">Pension Fund</label>
                            <select class="form-select select_pension select" name="pension_fund" id="pension_fund">
                                <option value="">Select Pension Fund</option>
                                @foreach ($pensiondrop as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <span id="pension_fund-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="pf_membership_no">Membership No</label>
                            <input type="text" maxlength="30" name="pf_membership_no" id="pf_membership_no" id="pf_membership_no" value="{{ old('pf_membership_no') }}" class="form-control" placeholder="Membership No">
                            <span id="pf_membership_no-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="emp_id">Payroll Number <span class="text-danger">*<span></label>
                            <input type="text" id="emp_id" name="emp_id" class="form-control" placeholder="Payroll number" required />
                            <span id="emp_id-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="bank">Bank <span class="text-danger">*<span></label>
                            <select class="form-control select_bank select" id='bank' name="bank">
                                <option value="">Select Employee Bank</option>
                                @foreach ($bankdrop as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                            <span id="bank-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <label class="form-label" for="bank_branch">Bank Branch <span class="text-danger">*<span></label>
                        <div class="mb-3 form-control-feedback" id="br-loader">
                            <select class="form-control select_bank_branch select" id="bank_branch" name="bank_branch" required style="padding-left: 20px !important"></select>
                            <div class="form-control-feedback-icon d-flex align-items-center justify-content-end text-end d-none px-3" id="select-loader" style="width: 100% !important; background: transparent">
                                <i class="ph-spinner spinner me-2"></i>
                            </div>
                        </div>
                        <span id="bank_branch-error" class="text-danger error-message"></span>
                    </div>

                    <div id="accountNo" class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" id="accno">Bank Account No <span class="text-danger">*<span></label>
                            <input type="text" maxlength="15" name="accno" value="{{ old('accno') }}" class="form-control" id="accno" required />
                            <span id="accno-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="mobile">Employee Mobile</label>
                            <input type="number" id="mobile" name="mobile" value="{{ old('mobile') }}" class="form-control" maxlength="14" />
                            <span id="mobile-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="postaddress">Postal Address</label>
                            <input type="text" name="postaddress" value="{{ old('postaddress') }}" class="form-control" maxlength="15" id="postaddress" />
                            <span id="postaddress-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="postalcity">Postal City</label>
                            <input type="text" name="postalcity" value="{{ old('postalcity') }}" class="form-control" maxlength="15" id="postalcity" />
                            <span id="postalcity-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="phyaddress">Physical Address</label>
                            <input type="text" name="phyaddress" value="{{ old('phyaddress') }}" class="form-control" id="phyaddress" maxlength="25">
                            <span id="phyaddress-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="haddress">Home Address</label>
                            <input type="text" name="haddress" value="{{ old('haddress') }}" class="form-control" maxlength="25" id="haddress">
                            <span id="haddress-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="nationalid">National ID <span class="text-danger">*<span></label>
                            <input type="text" id="nationalid" name="nationalid" value="{{ old('nationalid') }}" class="form-control" maxlength="150" required>
                            <span id="nationalid-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="tin">TIN <span class="text-danger">*<span></label>
                            <input type="text" name="tin" value="{{ old('tin') }}" class="form-control" maxlength="100" id="tin" required>
                            <span id="tin-error" class="text-danger error-message"></span>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label" for="emp_level">Job Level <span class="text-danger">*<span></label>

                            <select name="emp_level" id="emp_level" class="form-select select">
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

                            <span id="emp_level-error" class="text-danger error-message"></span>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-main" id="save-loader">
                        <i class="ph-circle-notch spinner me-2 d-none"></i>
                        Register Employee
                    </button>
                </div>
            </div>
            {{-- /Work details section --}}

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
                            <label class="form-label">Upload Employees In Batch</label>
                            <input type="file" requiredes accept=".xls, .xlsx"
                                class="form-control @error('file') is-invalid @enderror" name="file">
                            <div class="form-text text-muted">Accepted formats xls, xlsx. Max file size 2Mb</div>
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

                var $bselect = $('.select_bank_branch');
                var $bloader = $('#br-loader');

                if (bankID) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/flex/bankBranchFetcher/") }}',
                        data: 'bank=' + bankID,
                        beforeSend: function(){
                            $bselect.attr('disabled', 'disabled');
                            $bloader.find('#select-loader').removeClass('d-none'); // Remove the 'd-none' class to display the spinner
                            // $myButton.html('<i class="ph-circle-notch spinner me-2"></i>Loading...'); // Update button text
                        },
                        success: function(html) {
                            $('#bank_branch').html(html);
                        },
                        complete: function() {
                            setTimeout(function() {
                            // Your code here
                            $bselect.removeAttr('disabled');
                            $bloader.find('#select-loader').addClass('d-none'); // Add the 'd-none' class to hide the spinner
                            // $myButton.html('<i class="ph-circle-notch spinner me-2 d-none"></i>Submit'); // Restore button text
                            }, 1000); // 1000 milliseconds (1 second) delay
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
            $('#position').on('change', function() {
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

                if (stateID) {

                    var $bselect = $('#position');
                    var $bloader = $('#position-loader');

                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/flex/positionFetcher") }}',
                        data: 'dept_id=' + stateID,
                        beforeSend: function(){
                            $bselect.attr('disabled', 'disabled');
                            $bloader.find('#pos-loader').removeClass('d-none'); // Remove the 'd-none' class to display the spinner
                            // $myButton.html('<i class="ph-circle-notch spinner me-2"></i>Loading...'); // Update button text
                        },
                        success: function(html) {
                            let jq_json_obj = $.parseJSON(html);
                            let jq_obj = eval(jq_json_obj);

                            //populate position
                            $("#position option").remove();

                            $('#position').append($('<option>', {
                                value: '',
                                text: 'Select Position',
                                selected: true,
                                disabled: true
                            }));

                            $.each(jq_obj.position, function(detail, name) {
                                $('#position').append($('<option>', {
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
                            // $("#linemanager option").remove();
                            // $('#linemanager').append($('<option>', {
                            //     value: '',
                            //     text: 'Select Line Manager',
                            //     selected: true,
                            //     disabled: true
                            // }));

                            $.each(output, function(detail, name) {
                                $('#linemanager').append($('<option>', {
                                    value: name.id,
                                    text: name.name
                                }));
                            });

                        },
                        complete: function() {
                            setTimeout(function() {
                                $bselect.removeAttr('disabled');
                                $bloader.find('#pos-loader').addClass('d-none');
                            }, 1000); // 1000 milliseconds (1 second) delay
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
            e.preventDefault();

            var $myButton = $('#save-loader');

            $.ajax({
                url: '{{ url("/flex/registerEmployee") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: $(this).serialize(), // it will serialize the form data
                dataType: 'json',
                beforeSend: function(){
                    $myButton.attr('disabled', 'disabled');
                    $myButton.find('.spinner').removeClass('d-none'); // Remove the 'd-none' class to display the spinner
                    $myButton.html('<i class="ph-circle-notch spinner me-2"></i>Loading...'); // Update button text
                },
                success: function(data) {
                    console.log(data)
                    if(data.status == 400){
                        const item = data.errors;
                        const listItems = Object.keys(item).map(key => `<p>${item[key]}</p>`);
                        new Noty({
                            layout: 'top',
                            text: listItems,
                            type: 'error'
                        }).show();

                    }else{
                        new Noty({
                            layout: 'top',
                            text: 'We have sent an email to ' + document.getElementById("email").value,
                            type: 'success'
                        }).show();
                    }

                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                },
                error: function (xhr, status, error) {

                    $myButton.removeAttr('disabled');
                    $myButton.find('.spinner').addClass('d-none'); // Add the 'd-none' class to hide the spinner
                    $myButton.html('<i class="ph-circle-notch spinner me-2 d-none"></i>Register Employee'); // Restore button text

                    var responseJson = xhr.responseJSON;
                    if (responseJson.errors) {
                        var errors = responseJson.errors;
                        console.log(errors)
                        $('.error-message').empty();

                        $.each(errors, function (field, errorMessage) {
                            $('#' + field + '-error').html(errorMessage);
                            $('#' + field).addClass('is-invalid');
                            new Noty({
                            layout: 'topRight',
                            text: errorMessage,
                            type: 'error'
                        }).show();
                        });

                        var firstErrorField = Object.keys(errors)[0];

                        $('#' + firstErrorField).focus();
                    }
                }
            })
        });


        $('#import_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                //url '{{ url('/flex/import') }}',
                url: '{{ route("import.employee") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.request__spinner').show()
                },
                complete: function(){},
                success: function(data) {
                    $('#file').val('');
                    //load_data();
                    alert(' Employees Succefully Imported');
                    setTimeout(function() {
                        // wait for 2 secs(2)
                        location.reload(); // then reload the div to clear the success notification
                    }, 1500);
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
                    format 'DD/MM/YYYY'
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
                    format 'DD/MM/YYYY'
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
                    format 'DD/MM/YYYY'
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
