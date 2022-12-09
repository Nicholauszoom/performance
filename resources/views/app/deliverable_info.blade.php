@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Deliverables</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php if ($action == 0 && session('mng_proj')) { ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Create New Project</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="feedBack"></div>
                        <form autocomplete="off" id="addProject" enctype="multipart/form-data" method="post"
                            data-parsley-validate class="form-horizontal form-label-left">

                            <!-- START -->
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Name</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input required="" class="form-control col-md-7 col-xs-12" name="name"
                                        placeholder="Project Name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Code</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input required="" type="text" class="form-control col-md-7 col-xs-12" name="code"
                                        placeholder="Project Code" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Segment</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required name="segment" class="select_segment form-control" tabindex="-1">
                                        <option></option>
                                        <?php foreach ($segments as $row) { ?>
                                        <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Accountable
                                    Person</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <select required name="managed_by" class="select_employee form-control"
                                        tabindex="-1">
                                        <option></option>
                                        <?php foreach ($employees as $row) { ?>
                                        <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Target</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="target"
                                        placeholder="expected target to be achieved" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Estimated Cost</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" class="form-control col-md-7 col-xs-12" name="cost"
                                        placeholder="estimated cost" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                                </label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <textarea required="" class="form-control col-md-7 col-xs-12" name="description"
                                        placeholder="Project Description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Project
                                    Document</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="file" class="form-control col-md-7 col-xs-12" name="file"
                                        placeholder="Select file" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Start
                                    Date</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" name="start_date" placeholder="Start Date"
                                        class="form-control col-xs-12 has-feedback-left" id="start_date"
                                        aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback right"
                                        aria-hidden="true"></span>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">End
                                    Date</label>
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <input type="text" name="end_date" placeholder="End Date"
                                        class="form-control col-xs-12 has-feedback-left" id="end_date"
                                        aria-describedby="inputSuccess2Status">
                                    <span class="fa fa-calendar-o form-control-feedback right"
                                        aria-hidden="true"></span>

                                </div>
                            </div>
                            <!-- END -->
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-primary">CREATE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php }
        if ($action == 1 && !empty($deliverable_info)) {

            foreach ($deliverable_info as $row) {

                $deliverableID = $row->id;
                $name = $row->name;
                $description = $row->description;

                $target = $row->target;
                $cost = $row->cost;
                $document = $row->document;
              

            }

            ?>

        <!-- UPDATE INFO AND SECTION -->
        <div class="row">
            <!-- Groups -->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="feedBackAssignment"></div>
                        <h5> Name:
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                        
                       
                        <?php if ($employee) { ?>
                        <h5> Managed By:
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $employee->name; ?></b></h5>
                        <?php }?>
                        <?php if ($document) { ?>
                        <h5> Document:
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                                href="<?php echo base_url() . 'uploads/' . $document; ?>">Document
                                link</a> </b></h5>
                        <?php } ?>
                        <h5>Description: &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $description; ?></b>
                        </h5>
                        <br>
                    </div>
                </div>
            </div>
            <!-- Groups -->

            <!--UPDATE-->
            <?php if (session('mng_proj')) { ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Activities</b></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#overtimeTab" id="home-tab" role="tab"
                                        data-toggle="tab" aria-expanded="true">Activities</a>
                                </li>

                                <li role="presentation" class=""><a href="#imprestTab" role="tab" id="profile-tab"
                                        data-toggle="tab" aria-expanded="false">New Activity</a>
                                </li>

                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="overtimeTab"
                                    aria-labelledby="home-tab">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <h2>Activities </h2>
                                                    </div>
                                                    <div class="col-sm-3">

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div id="resultfeedOvertime"></div>
                                                <table id="datatable-keytable"
                                                    class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Name/Code</th>
                                                            <th>Cost</th>
                                                            <th>Target</th>
                                                            
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                           
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                        <?php
                                                $SNo = 1;
                                                foreach ($activities as $row) { ?>
                                                        <tr>
                                                            <td width="1px"><?php echo $SNo; ?></td>
                                                            <td><?php echo $row->name; ?></td>
                                                            <td><?php echo $row->cost; ?></td>
                                                            <td><?php echo $row->target; ?></td>
                                                            <td><?php echo $row->description; ?></td>
                                                            <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                            <td class="options-width">
                                                              <!--  <a
                                                                    href="<?php echo url('flex/project/projectInfo?code=') . base64_encode($row->id); ?>">
                                                                    <button class="btn btn-info btn-xs">INFO</button>
                                                                </a>
                                                                <a
                                                                    href="<?php echo url('flex/project/editProject?code=') . base64_encode($row->id); ?>">
                                                                    <button class="btn btn-success btn-xs">Edit</button>
                                                                </a> -->
                                                              
                                                            </td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php $SNo++;
                                                } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="imprestTab"
                                    aria-labelledby="profile-tab">
                                    <div id="resultfeedImprest"></div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <h2>Add Activity</h2>
                                                    </div>
                                                    <div class="col-sm-3">

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <form autocomplete="off" id="saveActivity"
                                                    enctype="multipart/form-data" method="post"  data-parsley-validate
                                                    class="form-horizontal form-label-left">

                                                    <!-- START -->
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Activity
                                                            Name</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input required="" class="form-control col-md-7 col-xs-12"
                                                                name="name" placeholder="Activity Name"
                                                                value="<?php if(!empty($data)) echo $name; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Accountable
                                                            Person if Exist</label>
                                                        <div class="col-md-8  col-sm-6 col-xs-12">
                                                            <select required name="managed_by"
                                                                class="form-control col-md-7 col-xs-12" tabindex="-1">
                                                                <option></option>
                                                                <?php foreach ($employees as $row) { ?>
                                                                <option value="<?php echo $row->empID; ?>"
                                                                    <?php if (isset($employee)) {if ($employee->emp_id == $row->empID) echo ' selected="selected"';} ?>>
                                                                    <?php echo $row->NAME; ?></option> <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">
                                                            Target</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                name="target" value="<?php echo $target; ?>"
                                                                placeholder="expected target to be achieved" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">
                                                            Estimated Cost</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" class="form-control col-md-7 col-xs-12"
                                                                name="cost" value="<?php echo $cost; ?>"
                                                                placeholder="estimated cost" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Description
                                                        </label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <textarea required=""
                                                                class="form-control col-md-7 col-xs-12"
                                                                name="description" placeholder="Project Description"
                                                                rows="3"><?php echo $description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Project
                                                            Document</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="file" class="form-control col-md-7 col-xs-12"
                                                                name="file" placeholder="Select file" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">Start
                                                            Date</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" name="start_date"
                                                                placeholder="Start Date"
                                                                class="form-control col-xs-12 has-feedback-left"
                                                                id="start_date" aria-describedby="inputSuccess2Status">
                                                            <span class="fa fa-calendar-o form-control-feedback right"
                                                                aria-hidden="true"></span>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                            for="last-name">End
                                                            Date</label>
                                                        <div class="col-md-8 col-sm-6 col-xs-12">
                                                            <input type="text" name="end_date" placeholder="End Date"
                                                                class="form-control col-xs-12 has-feedback-left"
                                                                id="end_date" aria-describedby="inputSuccess2Status">
                                                            <span class="fa fa-calendar-o form-control-feedback right"
                                                                aria-hidden="true"></span>

                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="deliverableID"
                                                        value="<?php echo $deliverableID; ?>">
                                                    <!-- END -->
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                            <button class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- END UPDATE SECTION  -->
        <?php } ?>

    </div>
</div>


<!-- /page content -->




<script type="text/javascript">
$('#saveActivity').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/saveActivity",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBack').fadeOut('fast', function() {
                $('#feedBack').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
            // $('#addProject')[0].reset();
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#addProject').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/addProject",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBack').fadeOut('fast', function() {
                $('#feedBack').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
            $('#addProject')[0].reset();
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#updateName').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectName",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});


$('#updateCode').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectCode",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#updateDescription').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateProjectDescription",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            $('#feedBackSubmission').fadeOut('fast', function() {
                $('#feedBackSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() { // wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 1000);
        })
        .fail(function() {
            alert('Request Failed!! ...');
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
    $('#end_date').daterangepicker({
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
    $('#end_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#end_date').on('cancel.daterangepicker', function(ev, picker) {
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
    $('#start_date').daterangepicker({
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
    $('#start_date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#start_date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>
 @endsection