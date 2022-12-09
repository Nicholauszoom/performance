@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')


<!-- /top navigation -->

<link href="<?php echo url(); ?>style/fstdropdown/fstdropdown.css" rel="stylesheet">


<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="">
        <!-- Tabs -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Projects, Deliverables and Activities</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#overtimeTab" id="home-tab" role="tab"
                                    data-toggle="tab" aria-expanded="true">Project</a>
                            </li>
                            <?php if (session('vw_proj') || session('mng_proj')) { ?>
                           <!-- <li role="presentation" class=""><a href="#imprestTab" role="tab" id="profile-tab"
                                    data-toggle="tab" aria-expanded="false">Remark</a>
                            </li> -->
                            <!--
                            <?php } ?>
                            <li role="presentation" class=""><a href="#arrearsTab" role="tab" id="profile-tab2"
                                    data-toggle="tab" aria-expanded="false">Activity</a>
                            </li> -->
                            <!--
                            <li role="presentation" class=""><a href="#arrearsReportTab" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Project
                                    Allocation</a>
                            </li>
                            <li role="presentation" class=""><a href="#assignment" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Assignment</a>
                            </li>
                            -->
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="overtimeTab"
                                aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>Projects </h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if (session('mng_proj')) { ?>
                                                    <a href="<?php echo url('flex/project/newProject'); ?>">
                                                        <button class="btn btn-primary btn-md">CREATE NEW PROJECT
                                                        </button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedOvertime"></div>
                                            <table id="datatable-keytable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Name/Code</th>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                $SNo = 1;
                                                foreach ($projects as $row) { ?>
                                                    <tr>
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo $row->code; ?></td>
                                                        <td><?php echo $row->description; ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <td class="options-width">
                                                            <a
                                                                href="<?php echo url('flex/project/projectInfo?code=') . base64_encode($row->id); ?>">
                                                                <button class="btn btn-info btn-xs">INFO</button>
                                                            </a>
                                                            <a
                                                                href="<?php echo url('flex/project/editProject?code=') . base64_encode($row->id); ?>">
                                                                <button class="btn btn-success btn-xs">Edit</button>
                                                            </a>
                                                            <?php if (!($row->code == 'SP008')) { ?>
                                                            <a href="javascript:void(0)"
                                                                onclick="deactivateProject(<?php echo $row->id; ?>)"
                                                                title="Mark This Activity as Inactive"
                                                                class="icon-2 info-tooltip">
                                                                <button type="button" class="btn btn-warning btn-xs"><i
                                                                        class="fa fa-warning"></i></button>
                                                            </a>
                                                            <?php } ?>
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
                            <?php if (session('vw_proj') || session('mng_proj')) { ?>
                            <div role="tabpanel" class="tab-pane fade" id="imprestTab" aria-labelledby="profile-tab">
                                <div id="resultfeedImprest"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>Grants</h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if (session('mng_proj')) { ?>
                                                    <a href="<?php echo url('flex/project/newGrant'); ?>">
                                                        <button class="btn btn-primary btn-md">CREATE NEW
                                                            GRANT
                                                        </button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                    $index = 1;
                                                    foreach ($grants as $row) { ?>
                                                    <tr>
                                                        <td width="1px"><?php echo $index; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo $row->code; ?></td>
                                                        <td><?php echo $row->description; ?></td>

                                                        <td class="options-width">
                                                            <a
                                                                href="<?php echo url('flex/project/grantInfo?grantCode=') . base64_encode($row->id); ?>">
                                                                <button class="btn btn-info btn-xs">INFO</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $index++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsTab" aria-labelledby="profile-tab">
                                <div id="feedBackActivityTable"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>Activities</h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if (session('mng_proj')) { ?>
                                                    <a href="<?php echo url('flex/project/newActivity'); ?>">
                                                        <button class="btn btn-primary btn-md">CREATE NEW ACTIVITY
                                                        </button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table id="datatable-arrears" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Name</th>
                                                        <th>Code</th>
                                                        <th>Description</th>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                $index2 = 1;
                                                foreach ($activities as $row) { ?>
                                                    <tr id="activity<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $index2; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo $row->code; ?></td>
                                                        <td><?php echo $row->description; ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <td class="options-width">
                                                            <a
                                                                href="<?php echo url('flex/project/activityInfo?activityCode=') . base64_encode($row->id); ?>">
                                                                <button class="btn btn-info btn-xs">INFO</button>
                                                            </a>
                                                            <?php if (session('mng_proj')) { ?>
                                                            <?php if (!($row->code == 'AC0018')) { ?>
                                                            <a href="javascript:void(0)"
                                                                onclick="deactivateActivity(<?php echo $row->id; ?>)"
                                                                title="Mark This Activity as Inactive"
                                                                class="icon-2 info-tooltip">
                                                                <button type="button" class="btn btn-warning btn-xs"><i
                                                                        class="fa fa-warning"></i>
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $index2++;
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade active" id="arrearsReportTab"
                                aria-labelledby="profile-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>Activity Allocations</h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if (session('mng_proj')) { ?>
                                                    <a href="#bottom">
                                                        <button type="button" class="btn btn-primary">NEW
                                                            ALLOCATION
                                                        </button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div id="feedBackAllocationTable"></div>
                                        <div class="x_content">
                                            <table id="datatable-task-table" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Employee ID</th>
                                                        <th>Employee Name</th>
                                                        <th>Position</th>
                                                        <th>Project</th>
                                                        <th>Activity</th>
                                                        <th>Grant</th>
                                                        <th>Allocation</th>
                                                        <?php if (session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                $index2 = 1;
                                                foreach ($allocations as $row) { ?>
                                                    <tr id="row<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $index2; ?></td>
                                                        <td><?php echo $row->empID; ?></td>
                                                        <td><?php echo $row->employee_name; ?></td>
                                                        <td>
                                                            <b>Department: </b><?php echo $row->department; ?><br>
                                                            <b>Position: </b><?php echo $row->position; ?><br>
                                                        </td>
                                                        <td>
                                                            <?php echo "<b>" . $row->project_code . "</b>:" . $row->project_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo "<b>" . $row->activity_code . "</b>:" . $row->activity_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo "<b>" . $row->grant_code . "</b>:" . $row->grant_name; ?>
                                                        </td>
                                                        <td><?php echo $row->percent; ?>%</td>
                                                        <?php if (session('mng_proj')) { ?>
                                                        <td class="options-width">
                                                            <!--                                          <a href="javascript:void(0)" onclick="deleteAllocation(<?php echo $row->id; ?>)" title="Delete Allocation" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>-->

                                                            <?php if (!($row->grant_code == 'VSO' || $row->activity_code == 'AC0018')) { ?>
                                                            <a href="javascript:void(0)"
                                                                onclick="deactivateAllocation(<?php echo $row->id; ?>,<?php echo $row->percent; ?>)"
                                                                title="Mark This Allocation as Inactive"
                                                                class="icon-2 info-tooltip">
                                                                <button type="button" class="btn btn-warning btn-xs"><i
                                                                        class="fa fa-warning"></i></button>
                                                            </a>
                                                            <a title="Adjust Allocation" class="icon-2 info-tooltip">
                                                                <button type="button" data-toggle="modal"
                                                                    data-id="<?php echo $row->empID; ?>"
                                                                    data-row_id="<?php echo $row->id; ?>"
                                                                    data-name="<?php echo $row->employee_name; ?>"
                                                                    data-project="<?php echo $row->project_code; ?>"
                                                                    data-grant="<?php echo $row->grant_code; ?>"
                                                                    data-activity="<?php echo $row->activity_code; ?>"
                                                                    data-percent="<?php echo $row->percent; ?>"
                                                                    data-target="#edit"
                                                                    class="btn btn-primary btn-xs"><i
                                                                        class="fa fa-minus-circle"></i>
                                                                </button>
                                                            </a>
                                                            <?php } ?>

                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php $index2++;
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <?php if (session('mng_proj')) { ?>
                                <div id="bottom" class="col-md-12 col-sm-6 col-xs-12">
                                    <!-- PANEL-->
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>New Project Allocation</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="feedbackResult"></div>
                                            <form id="allocateActivity" enctype="multipart/form-data" method="post"
                                                data-parsley-validate class="form-horizontal form-label-left">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Employee
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="employee" name="employee"
                                                            class="select4_single form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                                foreach ($employee as $row) {
                                                                    # code... ?>
                                                            <option value="<?php echo $row->empID; ?>">
                                                                <?php echo $row->NAME; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Project
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="projectSelectList"
                                                            class="select2_project form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                                foreach ($projects as $row) { ?>
                                                            <option value="<?php echo $row->code; ?>">
                                                                <?php echo $row->code; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Activity
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="activitySelectList" name="activity"
                                                            class="select_activity form-control" tabindex="-1">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Grant
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="grantList" name="grant"
                                                            class="select_grant form-control" tabindex="-1">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Percent Contribution</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input required="" type="number" min="0" max="100" step="0.01"
                                                            class="form-control col-md-7 col-xs-12" name="percent"
                                                            placeholder="Contribution" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                        <button id="submitButton" class="btn btn-primary">ALLOCATE
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div role="tabpanel" class="tab-pane fade active" id="assignment"
                                aria-labelledby="profile-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>Activity Assignment</h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if (session('mng_proj')) { ?>
                                                    <a href="#bottom1">
                                                        <button type="button" class="btn btn-primary">New Assignment
                                                        </button>
                                                    </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div id="feedBackAllocationTable"></div>
                                        <div class="x_content">
                                            <table id="datatable1" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>S/N</th>
                                                        <th>Assignment Name</th>
                                                        <th>Project</th>
                                                        <th>Activity</th>
                                                        <th>Due Date</th>
                                                        <th>Progress</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                $index2 = 1;
                                                foreach ($assignments as $row) { ?>
                                                    <tr id="row<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $index2; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo $row->project; ?></td>
                                                        <td><?php echo $row->activity; ?></td>
                                                        <td><?php echo $row->end_date; ?></td>
                                                        <td><?php if ($row->progress){
                                                            echo $row->progress;
                                                            } else{
                                                            echo '0';
                                                            } ?>%</td>
                                                        <td>
                                                            <?php if (session('mng_proj')) { ?>
                                                            <a
                                                                href="<?php echo url('flex/project/assignmentInfo?code=') . base64_encode($row->id); ?>">
                                                                <button class="btn btn-info btn-xs">Info</button>
                                                            </a>
                                                            <a href="#bottom2">
                                                                <button class="btn btn-warning btn-xs"
                                                                    title="Progress"><i
                                                                        class="fa fa-percent"></i></button>
                                                            </a>
                                                            <a href="#">
                                                                <button type="button" data-toggle="modal"
                                                                    data-id="<?php echo $row->id; ?>"
                                                                    data-project="<?php echo $row->project; ?>"
                                                                    data-activity="<?php echo $row->activity; ?>"
                                                                    data-name="<?php echo session('fname')." ".session('lname'); ?>"
                                                                    data-target="#expense"
                                                                    class="btn btn-success btn-xs" title="Expense"> <i
                                                                        class="fa fa-money"></i>
                                                                </button>
                                                            </a>
                                                            <?php } ?>
                                                            <a
                                                                href="<?php echo url('flex/project/timeTrackInfo?code=') . base64_encode($row->id); ?>">
                                                                <button type="button" class="btn btn-primary btn-xs"
                                                                    title="Time Track"><i
                                                                        class="fa fa-clock-o"></i></button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $index2++;
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <?php if (session('mng_proj')) { ?>
                                <div id="bottom1" class="col-md-12 col-sm-6 col-xs-12">
                                    <!-- PANEL-->
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>New Assignment</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="feedbackResult"></div>
                                            <form id="assignActivity" enctype="multipart/form-data" method="post"
                                                data-parsley-validate class="form-horizontal form-label-left">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Name</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input required="" id="assignment_name" type="text"
                                                            class="form-control col-md-7 col-xs-12"
                                                            name="assignment_name" placeholder="Assignment Name" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Project
                                                        Name</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <select required="" id="projectSelectList2"
                                                            name="project_assign" class="select2_project form-control"
                                                            tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                                foreach ($projects as $row) { ?>
                                                            <option value="<?php echo $row->code; ?>">
                                                                <?php echo $row->code; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Activity
                                                        Name</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <select required="" id="activitySelectList2" name="activity"
                                                            class="select_activity form-control" tabindex="-1">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Start
                                                        Date</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input type="text" name="start_date" autocomplete="off"
                                                            placeholder="Start Date"
                                                            class="form-control col-xs-12 has-feedback-left"
                                                            id="start_date_assign"
                                                            aria-describedby="inputSuccess2Status">
                                                        <span class="fa fa-calendar-o form-control-feedback right"
                                                            aria-hidden="true"></span>

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">End Date</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input type="text" name="end_date" autocomplete="off"
                                                            placeholder="End Date"
                                                            class="form-control col-xs-12 has-feedback-left"
                                                            id="end_date_assign" aria-describedby="inputSuccess2Status">
                                                        <span class="fa fa-calendar-o form-control-feedback right"
                                                            aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Employee
                                                        Name</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <select required="" id='employee1' name="employee[]"
                                                            class="select_multiple_employees_ form-control"
                                                            multiple="multiple">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Description </label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <textarea required="" class="form-control col-md-7 col-xs-12"
                                                            name="description" placeholder="Project Description"
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                        <button id="submitButton" class="btn btn-primary">Assign
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div id="bottom2" class="col-md-12 col-sm-6 col-xs-12">
                                    <!-- PANEL-->
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Assignment Progress</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="feedbackResult"></div>
                                            <form id="progressActivity" enctype="multipart/form-data" method="post"
                                                data-parsley-validate class="form-horizontal form-label-left">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Assignment
                                                        Name</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <select required="" id="projectSelectList2"
                                                            name="project_progress"
                                                            class="select2_assignment form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                                foreach ($assignments as $row) { ?>
                                                            <option value="<?php echo $row->id; ?>">
                                                                <?php echo $row->name; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                        for="last-name">Progress</label>
                                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                                        <input required="" id="assignment_name" type="text"
                                                            class="form-control col-md-7 col-xs-12"
                                                            name="assignment_progress"
                                                            placeholder="Assignment Progress" />
                                                    </div>
                                                </div>
                                                <input type="hidden" name="progress_form" value="pf">
                                                <div class="form-group">
                                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                        <button id="submitButton" class="btn btn-primary">Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Tabs -->
    </div>
</div>
<!-- /page content -->

<div class="modal fade" id="edit" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Adjust Allocation</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel-body">
                    <form id="re-allocation" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Employee
                                    Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="name" name="department" maxlength="45"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Project
                                    Name</label>
                                <div class="col-md-8">
                                    <select style="width: 100%" disabled required="" id="projectSelectList1"
                                        class="select2_project form-control" tabindex="-1">
                                        <option></option>
                                        <?php
                                        foreach ($projects as $row) { ?>
                                        <option value="<?php echo $row->code; ?>"><?php echo $row->code; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Activity
                                    Name</label>
                                <div class="col-md-8">
                                    <select style="width: 100%" disabled required="" id="activitySelectList1"
                                        name="activity" class="select_activity form-control" tabindex="-1">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Grant Name</label>
                                <div class="col-md-8">
                                    <select style="width: 100%" disabled required="" id="grantList1" name="grant"
                                        class="select_grant form-control" tabindex="-1">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" hidden>
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Total
                                    Contribution</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly type="text" id="total_percentage">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Previous
                                    Allocation</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly type="text" id="total_percentage_">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">New
                                    Allocation</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" id="percent" name="percent" maxlength="45"
                                        required autocomplete="off">
                                    <p id="error" style="display: none; color: red">Present percent cannot exceed total
                                        contribution</p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="id" name="emp_id">
                        <input type="hidden" id="row_id" name="row_id">
                        <input type="hidden" id="activity_code" name="activity_code">
                        <input type="hidden" id="percentage">
                        <input type="hidden" id="remaining_percent" name="remaining_percent">
                        <input type="hidden" id="default_percentage">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
                        </div>
                    </form>
                </div>


            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="expense" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Expense</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel-body">
                    <form id="addCost" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Employee
                                    Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly type="text" id="name" name="name"
                                        maxlength="45" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Project
                                    Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly type="text" id="project_name_"
                                        name="project_name" maxlength="45" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Activity
                                    Name</label>
                                <div class="col-md-8">
                                    <input class="form-control" readonly type="text" id="activity_name_"
                                        name="activity_name" maxlength="45" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Category</label>
                                <div class="col-md-8">
                                    <select style="width: 100%" required="" id="category" name="category"
                                        class="form-control" tabindex="-1">
                                        <option disabled value="" selected>Select category</option>
                                        <?php
                                            foreach ($categories as $row) {
                                                # code... ?>
                                        <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Cost
                                    Amount</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="number" step="0.01" name="cost_amount">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department"
                                    class="col-md-4 col-form-label text-md-right">Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" type="number" id="cost_description"
                                        name="cost_description" maxlength="200" required autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Documents</label>
                                <div class="col-md-8">
                                    <input type="file" class="form-control col-md-7 col-xs-12" name="file"
                                        placeholder="Select file" />
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="id" name="id">


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
                        </div>
                    </form>
                </div>


            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1"
    role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                </div>
                <div class="col-sm-2">

                </div>
            </div>

        </div>
    </div>
</div>


<?php
 ?>

<!-- fstdropdown -->

<script>
$(".select_multiple_employees_").select2({
    maximumSelectionLength: 10,
    placeholder: "Select Employees",
    allowClear: true
});
</script>

<script>
function notify(message, from, align, type) {
    $.growl({
        message: message,
        url: ''
    }, {
        element: 'body',
        type: type,
        allow_dismiss: true,
        placement: {
            from: from,
            align: align
        },
        offset: {
            x: 30,
            y: 30
        },
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        url_target: '_blank',
        mouse_over: false,

        icon_type: 'class',
        template: '<div data-growl="container" class="alert" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#!" data-growl="url"></a>' +
            '</div>'
    });
}
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
    $('#end_date_assign').daterangepicker({
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
    $('#end_date_assign').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#end_date_assign').on('cancel.daterangepicker', function(ev, picker) {
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
    $('#start_date_assign').daterangepicker({
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
    $('#start_date_assign').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
    });
    $('#start_date_assign').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
});
</script>

<script>
$('#expense').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const modal = $(this);

    modal.find('.modal-body #project_name_').val(button.data('project'));
    modal.find('.modal-body #id').val(button.data('id'));
    modal.find('.modal-body #activity_name_').val(button.data('activity'));
    modal.find('.modal-body #name').val(button.data('name'));


});

$('#edit').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const modal = $(this);

    modal.find('.modal-body #name').val(button.data('name'));
    modal.find('.modal-body #id').val(button.data('id'));
    modal.find('.modal-body #row_id').val(button.data('row_id'));
    modal.find('.modal-body #activity_code').val(button.data('activity'));
    modal.find('.modal-body #percentage').val(button.data('percent'));
    modal.find('.modal-body #total_percentage_').val(button.data('percent'));

    $('#projectSelectList1').val(button.data('project')).change();

    setTimeout(function() { // wait for 2 secs(2)
        $('#activitySelectList1').val(button.data('activity')).change();
    }, 2000);

    setTimeout(function() { // wait for 2 secs(2)
        $('#grantList1').val(button.data('grant')).change();
    }, 3000);

    $.ajax({
        type: 'POST',
        url: '<?php echo url(); ?>flex/project/employeeTotalPercentAllocation',
        data: 'projectCode=' + button.data('id'),
        success: function(html) {
            let jq_json_obj = $.parseJSON(html);
            let jq_obj = eval(jq_json_obj);

            if (jq_obj) {
                document.getElementById('total_percentage').value = jq_obj[0][0].totalPercent;
            }
        }
    });

});


$('#percent').on('change', function() {
    var total_percent = Number(document.getElementById('total_percentage').value);
    var present_percent = Number(document.getElementById('percent').value);
    var previous_percent = Number(document.getElementById('percentage').value);
    var default_percentage = Number(document.getElementById('default_percentage').value);

    var total_contribution = total_percent - default_percentage - previous_percent;
    var remaining = 100 - total_contribution;

    document.getElementById('remaining_percent').value = remaining;

    if (present_percent > remaining) {
        document.getElementById('error').style.display = 'block';
        $('#save_btn').prop("disabled", true);
        return false;
    } else {
        document.getElementById('error').style.display = 'none';
        $('#save_btn').prop("disabled", false);
    }

    // return false;

});

$('#re-allocation').submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: '<?php echo url(); ?>flex/project/employeeRellocation',
        type: "post",
        dataType: "json",
        data: $('#re-allocation').serialize(),
        success: function(data) {
            if (data == 'success') {
                $('#edit').modal('hide');
                notify('Activity adjusted successfully!', 'top', 'right', 'success');
                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            }
        }
    });


});
</script>

<script type="text/javascript">
$('#datatable1').dataTable();

$(".select2_project").select2({
    placeholder: "Select Project",
    allowClear: true
});

$(".select2_assignment").select2({
    placeholder: "Select Assignment",
    allowClear: true
});

$(".select_activity").select2({
    placeholder: "Select Activity",
    allowClear: true
});
$(".select_grant").select2({
    placeholder: "Select Grant",
    allowClear: true
});

$(document).ready(function() {
    $('#datatable-task-table').DataTable();
    $('#datatable-arrears').DataTable();
});
</script>
<script>
$(document).ready(function() {

    $('#projectSelectList').on('change', function() {
        var projectCode = $('#projectSelectList').val();
        if (projectCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchActivity',
                data: 'projectCode=' + projectCode,
                success: function(html) {
                    $('#activitySelectList').html(html);
                }
            });
        } else {
            $('#activitySelectList').html('<option value="">Select Project</option>');
        }
    });

    $('#projectSelectList1').on('change', function() {
        var projectCode = $('#projectSelectList1').val();
        if (projectCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchActivity',
                data: 'projectCode=' + projectCode,
                success: function(html) {
                    $('#activitySelectList1').html(html);
                }
            });
        } else {
            $('#activitySelectList1').html('<option value="">Select Project</option>');
        }
    });

    $('#projectSelectList2').on('change', function() {
        var projectCode = $('#projectSelectList2').val();
        if (projectCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchActivity',
                data: 'projectCode=' + projectCode,
                success: function(html) {
                    $('#activitySelectList2').html(html);
                }
            });
        } else {
            $('#activitySelectList2').html('<option value="">Select Project</option>');
        }
    });

    $('#activitySelectList').on('change', function() {
        var activityCode = $('#activitySelectList').val();
        if (activityCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchGrant',
                data: 'activityCode=' + activityCode,
                success: function(html) {
                    $('#grantList').html(html);
                }
            });
        } else {
            $('#grantList').html('<option value="">Select Activity</option>');
        }
    });

    $('#activitySelectList1').on('change', function() {
        var activityCode = $('#activitySelectList1').val();
        if (activityCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchGrant',
                data: 'activityCode=' + activityCode,
                success: function(html) {
                    $('#grantList1').html(html);
                }
            });
        } else {
            $('#grantList1').html('<option value="">Select Activity</option>');
        }
    });

    $('#activitySelectList2').on('change', function() {
        var activityCode = $('#activitySelectList2').val();
        if (activityCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url(); ?>flex/project/fetchEmployee',
                data: 'activityCode=' + activityCode,
                success: function(html) {
                    let jq_json_obj = $.parseJSON(html);
                    let jq_obj = eval(jq_json_obj);

                    //populate employee
                    $("#employee1 option").remove();

                    $.each(jq_obj, function(detail, name) {
                        $('#employee1').append($('<option>', {
                            value: name.empID,
                            text: name.name
                        }));
                    });
                }
            });
        } else {
            // $('#grantList1').html('<option value="">Select Activity</option>');
        }
    });

});


$('#allocateActivity').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/allocateActivity",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(response) {

            if (response.status == 'OK') {
                notify('Employee allocation successfully!', 'top', 'right', 'success');
                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            } else if (response.status == 'ERR_100') {
                notify('Employee has reached 100% contribution, please adjust allocation!', 'top', 'right',
                    'warning');
            } else if (response.status == 'ERR_DUP') {
                notify('Employee already assigned this activity!', 'top', 'right', 'danger');
            } else if (response.status == 'ERR_EXCEED') {
                notify('Employee is fully allocated!', 'top', 'right', 'danger');
            } else {
                notify('Employee has less available allocation, please reduce percentage', 'top', 'right',
                    'info');
            }
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#assignActivity').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/assignActivity",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(response) {
            let jq_json_obj = $.parseJSON(response);
            let jq_obj = eval(jq_json_obj);
            if (jq_obj.status == 'OK') {
                notify('Assignment successfully!', 'top', 'right', 'success');
                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            } else {
                notify('Assignment error', 'top', 'right', 'danger');
            }
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

$('#progressActivity').submit(function(e) {
    e.preventDefault();
    $.ajax({
            url: "<?php echo url(); ?>flex/project/updateAssignment",
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(response) {
            let jq_json_obj = $.parseJSON(response);
            let jq_obj = eval(jq_json_obj);
            if (jq_obj.status == 'OK') {
                notify('Assignment successfully!', 'top', 'right', 'success');
                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            } else {
                notify('Assignment error', 'top', 'right', 'danger');
            }
        })
        .fail(function() {
            alert('Request Failed!! ...');
        });
});

function deleteAllocation(id) {
    if (confirm("Are You Sure You Want To Delete This Allocation") == true) {
        var id = id;
        $('#row' + id).show();
        $.ajax({
            url: "<?php echo url('flex/project/deleteAllocation');?>/" + id,
            success: function(data) {
                if (data.status == 'OK') {
                    $('#row' + id).hide();
                    $('#feedBackAllocationTable').fadeOut('fast', function() {
                        $('#feedBackAllocationTable').fadeIn('fast').html(data.message);
                    });

                } else {
                    alert("Allocation Deleted Sussessifully!");
                    $('#feedBackAllocationTable').fadeOut('fast', function() {
                        $('#feedBackAllocationTable').fadeIn('fast').html(data.message);
                    });

                }
            }

        });
    }
}

function deleteActivity(id) {
    if (confirm("Are You Sure You Want To Delete This Activity") == true) {
        var id = id;
        $('#activity' + id).show();
        $.ajax({
            url: "<?php echo url('flex/project/deleteActivity');?>/" + id,
            success: function(data) {
                if (data.status == 'OK') {
                    $('#activity' + id).hide();
                    $('#feedBackActivityTable').fadeOut('fast', function() {
                        $('#feedBackActivityTable').fadeIn('fast').html(data.message);
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    alert("Allocation Deleted Sussessifully!");
                    $('#feedBackActivityTable').fadeOut('fast', function() {
                        $('#feedBackActivityTable').fadeIn('fast').html(data.message);
                    });

                }
            }
        });
    }
}


function deactivateAllocation(id, percent) {

    const message = "Are you sure you want this activity inactive?";
    $('#delete').modal('show');
    $('#delete').find('.modal-body #message').text(message);

    var id = id;
    var percent = percent;

    $("#yes_delete").click(function() {
        $('#activity' + id).show();
        $.ajax({
            url: "<?php echo url('flex/project/deactivateAllocation');?>/" + id + "/" +
                percent,
            success: function(data) {
                if (data.status == 'OK') {
                    $('#activity' + id).hide();

                    $('#delete').modal('hide');
                    notify('Activity allocation deactivated successfully!', 'top', 'right',
                        'success');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                    // $('#feedBackAllocationTable').fadeOut('fast', function(){
                    //     $('#feedBackAllocationTable').fadeIn('fast').html(data.message);
                    // });
                    // setTimeout(function(){
                    //     location.reload();
                    // }, 3000);
                } else {
                    //
                    // $('#feedBackAllocationTable').fadeOut('fast', function(){
                    //     $('#feedBackAllocationTable').fadeIn('fast').html(data.message);
                    // });
                    $('#delete').modal('hide');
                    notify('Activity deactivation failed, try again!', 'top', 'right', 'warning');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }
            }
        });
    });

}


function deactivateActivity(id) {

    const message = "Are you sure you want this activity inactive?";
    $('#delete').modal('show');
    $('#delete').find('.modal-body #message').text(message);

    var id = id;

    $("#yes_delete").click(function() {
        $('#activity' + id).show();
        $.ajax({
            url: "<?php echo url('flex/project/deactivateActivity');?>/" + id,
            success: function(data) {
                if (data.status == 'OK') {
                    $('#activity' + id).hide();

                    $('#delete').modal('hide');
                    notify('Activity deactivated successfully!', 'top', 'right', 'success');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    $('#delete').modal('hide');
                    notify('Activity deactivation failed, try again!', 'top', 'right', 'danger');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }
            }
        });
    });

}


function deactivateProject(id) {

    const message = "Are you sure you want this project inactive?";
    $('#delete').modal('show');
    $('#delete').find('.modal-body #message').text(message);

    var id = id;

    $("#yes_delete").click(function() {
        $('#activity' + id).show();
        $.ajax({
            url: "<?php echo url('flex/project/deactivateProject');?>/" + id,
            success: function(data) {
                if (data.status == 'OK') {
                    $('#activity' + id).hide();

                    $('#delete').modal('hide');
                    notify('Project deactivated successfully!', 'top', 'right', 'success');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    $('#delete').modal('hide');
                    notify('Project deactivation failed, try again!', 'top', 'right', 'danger');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }
            }
        });
    });

}

$('#addCost').submit(function(e) {

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
            url: "<?php echo url(); ?>flex/project/addCost",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: false
        })
        .done(function(data) {
            if (data.status == 'OK') {
                $('#expense').modal('hide');
                notify('Cost added successfully!', 'top', 'right', 'success');

                setTimeout(function() { // wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);

            } else {
                $('#expense').modal('hide');
                notify('Cost added error, please try again!', 'top', 'right', 'danger');
            }
        })
        .fail(function() {
            $('#expense').modal('hide');
            alert('Cost Not Added! Please Review Your Network Connection ...');
        });

});
</script>
 @endsection