@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')

<?php
?>


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Employee Registration </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        
                    </div>
                    <div class="x_content">

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <div id="feedBackSubmission"></div>
                            </div>
                            <form id="addEmployee" enctype="multipart/form-data" autocomplete="off" method="post"
                                data-parsley-validate class="form-horizontal form-label-left">
                                <!-- action="<?php echo  url(''); ?>/flex/registerEmployee" -->
                                <div class="col-lg-12">
                                    <div class="col-lg-4">

                                        <div class="form-group">
                                            <label for="middle-name">First Name</label>
                                            <div>
                                                <input placeholder="First Name" required
                                                    class="form-control col-md-7 col-xs-12" type="text" maxlength="15"
                                                    pattern="[a-zA-Z]+" title="Only enter letters" name="fname">
                                                <span class="text-danger"><?php// echo form_error("fname");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle-name">Middle Name</label>
                                            <div>
                                                <input maxlength="15" placeholder="Middle Name"
                                                    class="form-control col-md-7 col-xs-12" maxlength="15"
                                                    pattern="[a-zA-Z]+" title="Only enter letters" type="text"
                                                    name="mname">
                                                <!-- <span class="text-danger"><?php// echo form_error("mname");?></span> -->
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="middle-name">Last Name</label>
                                            <div>
                                                <input required id="class" placeholder="Last Name(Surname)"
                                                    class="form-control col-md-7 col-xs-12" maxlength="15"
                                                    pattern="[a-zA-Z]+" title="Only enter letters" type="text"
                                                    name="lname">
                                                <span class="text-danger"><?php// echo form_error("lname");?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <label class="containercheckbox">Male
                                                <input type="radio" checked="" value="Male" name="gender">
                                                <span class="checkmarkradio"></span>
                                            </label>
                                            <label class="containercheckbox">Female
                                                <input type="radio" value="Female" name="gender">
                                                <span class="checkmarkradio"></span>
                                            </label>
                                            <span class="text-danger"><?php// echo form_error("gender");?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Birthdate</label>
                                            <div class="has-feedback">
                                                <input type="text" required name="birthdate" placeholder="Date of Birth"
                                                    class="form-control col-xs-12 has-feedback-left" id="birthdate"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>
                                                <span id="age" class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nationality</label>
                                            <select required name="nationality" class="select_country form-control"
                                                tabindex="-1">
                                                <option></option>
                                                <?php foreach ($countrydrop as $row){ ?>
                                                <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Merital Status</label>
                                            <select required name="status" class="form-control">
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Email</label>
                                            <div>
                                                <input required id="email" maxlength="30"
                                                    class="form-control col-md-7 col-xs-12" type="email" name="email">
                                                <span class="text-danger"><?php// echo form_error("email");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Employee ID</label>
                                            <div>
                                                <input required id="emp_id" maxlength="30"
                                                    class="form-control col-md-7 col-xs-12" type="text" name="emp_id">

                                            </div>
                                        </div>
    

                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="stream">Department</label>
                                            <select required id='department' name="department"
                                                class="select3_single form-control">
                                                <option value="">Select Department</option>
                                                <?php foreach ($ddrop as $row){ ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Position</label>
                                            <select required id="pos" name="position"
                                                class="select1_single form-control" tabindex="-1">
                                                <option value="">Select Position</option>
                                            </select>
                                            <span class="text-danger"><?php// echo form_error("position");?></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Line Manager</label>
                                            <select required id="linemanager" name="linemanager"
                                                class="select2_single form-control" tabindex="-1">
                                                <!--                        <option></option>-->
                                                <!--                           --><?php //foreach ($ldrop as $row){ ?>
                                                <!--                          <option value="--><?php //echo $row->empID; ?>
                                                <!--">--><?php //echo $row->NAME; ?>
                                                <!--</option> --><?php //} ?>
                                            </select>
                                            <span class="text-danger"><?php// echo form_error("linemanager");?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="stream">Company Branch</label>
                                            <select required name="branch" class="select_branch form-control">
                                                <option value="">Select Branch</option>
                                                <?php foreach ($branch as $row){ ?>
                                                <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="stream">Contract type</label>
                                            <select required name="ctype" class="form-control">
                                                <option value="" selected disabled>Select type</option>
                                                <?php foreach ($contract as $row){ ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Basic Salary</label>
                                            <div id="salaryField">
                                                <span class="text-danger"><?php// echo form_error("salary");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Contract Start</label>
                                            <div class="has-feedback">
                                                <input type="text" required name="contract_start"
                                                    placeholder="Contract Start Date"
                                                    class="form-control col-xs-12 has-feedback-left" id="contract_start"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Contract End</label>
                                            <div class="has-feedback">
                                                <input type="text" required name="contract_end"
                                                    placeholder="Contract End Date"
                                                    class="form-control col-xs-12 has-feedback-left" id="contract_end"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Pension Fund</label>
                                            <select required name="pension_fund" class="select_pension form-control">
                                                <option value="">Select Pension Fund</option>
                                                <?php foreach ($pensiondrop as $row){ ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Membership No.</label>
                                            <div>
                                                <input required maxlength="30" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="pf_membership_no">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Code</label>
                                            <div>
                                                <input required id="emp_code" maxlength="30"
                                                    class="form-control col-md-7 col-xs-12" type="text" name="emp_code">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="form-group">
                                            <label for="stream">Bank</label>
                                            <select required id='bank' name="bank" class="select_bank form-control">
                                                <option value="">Select Employee Bank</option>
                                                <?php foreach ($bankdrop as $row){ ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?>
                                                </option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Bank Branch</label>
                                            <select required id="bank_branch" name="bank_branch"
                                                class="select_bank_branch form-control" tabindex="-1">
                                            </select>
                                        </div>
                                        <div id="accountNo" class="form-group">
                                            <label for="stream">Bank Account No</label>
                                            <div>
                                                <input id="email" maxlength="15" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="accno">
                                                <span class="text-danger"><?php// echo form_error("accno");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Employee Mobile</label>
                                            <div>
                                                <input required id="stream" maxlength="14"
                                                    class="form-control col-md-7 col-xs-12" type="text" name="mobile">
                                                <span class="text-danger"><?php// echo form_error("mobile");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Postal Address</label>
                                            <div>
                                                <input class="form-control col-md-7 col-xs-12" type="text"
                                                    maxlength="15" name="postaddress">
                                                <span class="text-danger"><?php// echo form_error("postaddress");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Postal City</label>
                                            <div>
                                                <input maxlength="15" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="postalcity">
                                                <span
                                                    class="text-danger"><?php // echo form_error("postaddress");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle-name">Physical Address</label>
                                            <div>
                                                <input id="class" maxlength="25" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="phyaddress">
                                                <span class="text-danger"><?php// echo form_error("phyaddress");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Home Address</label>
                                            <div>
                                                <input maxlength="25" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="haddress">
                                                <span class="text-danger"><?php// echo form_error("haddress");?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="stream">National ID</label>
                                            <div>
                                                <input maxlength="150" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="nationalid">
                                                <span class="text-danger"><?php// echo form_error("nationalid");?></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="stream">TIN</label>
                                            <div>
                                                <input maxlength="100" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="tin">
                                                <span class="text-danger"><?php// echo form_error("tin");?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stream">Level.</label>
                                            <div>
                                                <input required maxlength="30" id="emp_level" class="form-control col-md-7 col-xs-12"
                                                    type="text" name="emp_level">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- test -->
                                <div class="form-group">
                                    <div class="pull-left col-md-6 col-sm-6 col-xs-12">
                                        <button type="reset" class="btn btn-primary">Cancel</button>
                                        <button class="btn btn-success">Register Employee</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <form id="import_form" method="post">
                            <div class="row col-lg-12" style="margin-top:50px;">
                                <a href="<?php echo  url(''); ?>template/employee_upload_template.xls">Click here to
                                    download employees template</a>
                                <div class="col-lg-2">

                                    <label>Upload Employees In Batch </label>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div>
                                            <input type="file" required accept=".xls, .xlsx" name="file">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="pull-right btn btn-success">Upload Employee</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!--Employee Bonus List for this Montyh-->

            <!--Employee Bonus list For This month-->
        </div>
    </div>
</div>

<!-- /page content -->




<?php

?>

<script>
$(document).ready(function() {
    $('#accountNo').show();
    $('#bank').on('change', function() {
        var bankID = $(this).val();
        if (bankID) {
            $.ajax({
                type: 'POST',
                url: '<?php echo  url(''); ?>/flex/bankBranchFetcher/',
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
                url: '<?php echo  url(''); ?>/flex/getPositionSalaryRange/',
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
                type: 'POST',
                url: '<?php echo  url(''); ?>/flex/positionFetcher/',
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


<script type="text/javascript">
$('#addEmployee').submit(function(e) {

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
            url: "<?php echo  url(''); ?>/flex/registerEmployee",
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
        url: "<?php echo  url(''); ?>/flex/import",
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
 @endsection