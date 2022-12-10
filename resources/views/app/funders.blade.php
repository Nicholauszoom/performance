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
    <div class="clearfix"></div>
    <div class="">

        <!-- Tabs -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Funders</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
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
                                                                      data-toggle="tab" aria-expanded="true">Funder</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsReportTab" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Project
                                    Segment</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsReportTab1" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Expense
                                    Category</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsReportTab2" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Exception
                                    Type</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsReportTab3" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">Request Fund</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="overtimeTab"
                                 aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Funders</h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#bottom">
                                                    <button type="button" class="btn btn-primary">New Funder</button>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="x_content">
                                            <div id="resultfeedbackGet"></div>
                                            <table id="datatable-keytable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Funder Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Date Registered</th>
                                                    <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($funders as $row) { ?>
                                                    <tr id="domain<?php //echo $row->id;?>">
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td width="1px"><?php echo $row->name; ?></td>
                                                        <td width="1px"><?php echo $row->email; ?></td>
                                                        <td width="1px"><?php echo $row->phone; ?></td>
                                                        <td width="1px"><?php echo date('Y-m-d', strtotime($row->createdOn)); ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                            <td width="1px">
                                                                <a href="<?php echo url('flex/performance/funderInfo/?id=') . base64_encode($row->id); ?>">
                                                                    <button class="btn btn-info btn-xs">Info</button>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                   onclick="deactivateFunder(<?php echo $row->id; ?>)"
                                                                   title="Mark This Funder as Inactive"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button"
                                                                            class="btn btn-warning btn-xs"><i
                                                                                class="fa fa-warning"></i></button>
                                                                </a>
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
                                <div id="bottom" class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Funder</b></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedback"></div>
                                            <form method="post" class="form-horizontal form-label-left" id="addFunder">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="required" required type="text"
                                                               placeholder="Funder Name" id="address" name="name"
                                                               class="form-control col-md-7 col-xs-12">
                                                        <span class="text-danger"><?php// echo form_error("lname"); ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Email
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="required" placeholder="Email" type="email"
                                                               id="email" name="email"
                                                               class="form-control col-md-7 col-xs-12">
                                                        <span class="text-danger"><?php// echo form_error("lname"); ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Country
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required name="nationality" class="select_country form-control" tabindex="-1">
                                                            <option></option>
                                                            <?php foreach ($country as $row){ ?>
                                                                <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Client Type
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required type="text"
                                                               placeholder="Funder Type" id="type" name="type"
                                                               class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Phone
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required="required" placeholder="Mobile Phone"
                                                               type="text" id="phone" name="phone"
                                                               class="form-control col-md-7 col-xs-12">
                                                        <span class="text-danger"><?php// echo form_error("lname"); ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">More Info
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea type="text" id="more" name="description"
                                                                  placeholder="Description"
                                                                  class="form-control col-md-7 col-xs-12"></textarea>
                                                        <span class="text-danger"><?php// echo form_error("lname"); ?></span>
                                                    </div>
                                                </div>
                                                <div align="right" class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab" aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Project Segment</h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#bottom1">
                                                    <button type="button" class="btn btn-primary">New Segment</button>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="x_content">
                                            <div id="resultfeedbackGet"></div>
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($segments as $row) { ?>
                                                    <tr id="domain<?php //echo $row->id;?>">
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td width="1px"><?php echo $row->name; ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                            <td width="1px">
                                                                <a href="javascript:void(0)"
                                                                   onclick="deleteSegment(<?php echo $row->id; ?>)"
                                                                   title="Delete Segment"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-trash"></i></button>
                                                                </a>
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
                                <div id="bottom1" class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Project Segment</b>
                                            </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedback"></div>
                                            <form method="post" class="form-horizontal form-label-left" id="addSegment">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required type="text" placeholder="Project segment name"
                                                               id="name" name="name"
                                                               class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>

                                                <div align="right" class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab1" aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Expense Category</h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#bottom2">
                                                    <button type="button" class="btn btn-primary">New Category</button>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="x_content">
                                            <div id="resultfeedbackGet"></div>
                                            <table id="datatable1" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($categories as $row) { ?>
                                                    <tr id="domain<?php //echo $row->id;?>">
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td width="1px"><?php echo $row->name; ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                            <td width="1px">
                                                                <a href="javascript:void(0)"
                                                                   onclick="deleteCategory(<?php echo $row->id; ?>)"
                                                                   title="Delete Segment"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-trash"></i></button>
                                                                </a>
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
                                <div id="bottom2" class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Expense Category</b>
                                            </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedback"></div>
                                            <form method="post" class="form-horizontal form-label-left" id="addCategory">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required type="text" placeholder="Expense category"
                                                               id="category_name" name="category_name"
                                                               class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>

                                                <div align="right" class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab2" aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Exception Type</h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#bottom3">
                                                    <button type="button" class="btn btn-primary">New Exception</button>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="x_content">
                                            <div id="resultfeedbackGet"></div>
                                            <table id="datatable2" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($exceptions as $row) { ?>
                                                    <tr id="domain<?php //echo $row->id;?>">
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td width="1px"><?php echo $row->name; ?></td>
                                                        <?php if (session('vw_proj') || session('mng_proj')) { ?>
                                                            <td width="1px">
                                                                <a href="javascript:void(0)"
                                                                   onclick="deleteException(<?php echo $row->id; ?>)"
                                                                   title="Delete Segment"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button"
                                                                            class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-trash"></i></button>
                                                                </a>
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
                                <div id="bottom3" class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Exception Type Category</b>
                                            </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedback"></div>
                                            <form method="post" class="form-horizontal form-label-left" id="addException">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Name
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required type="text" placeholder="Exception name"
                                                               id="exception_name" name="exception_name"
                                                               class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>

                                                <div align="right" class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab3" aria-labelledby="home-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Request Fund</h2>
                                            <div class="clearfix"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#bottom4">
                                                    <button type="button" class="btn btn-primary">New Request</button>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="x_content">
                                            <div id="resultfeedbackGet"></div>
                                            <table id="datatable3" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Funder</th>
                                                    <th>Project</th>
                                                    <th>Activity</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($requests as $row) { ?>
                                                    <tr id="domain<?php //echo $row->id;?>">
                                                        <td width="1px"><?php echo $SNo; ?></td>
                                                        <td width="1px"><?php echo $row->name; ?></td>
                                                        <td width="1px"><?php echo $row->project; ?></td>
                                                        <td width="1px"><?php echo $row->activity; ?></td>
                                                        <td width="1px"><?php echo number_format($row->amount,2); ?></td>
                                                    </tr>
                                                    <?php $SNo++;
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="bottom4" class="col-md-8 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Request Fund</b>
                                            </h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeedback"></div>
                                            <form method="post" class="form-horizontal form-label-left" id="addRequest">

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Funder</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="" style="width: 100%"
                                                                class="select2_funder form-control" name="funder" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                            foreach ($funders as $row) { ?>
                                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Project
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="projectSelectList" style="width: 100%"
                                                                class="select2_project form-control" name="project" tabindex="-1">
                                                            <option></option>
                                                            <?php
                                                            foreach ($projects as $row) { ?>
                                                                <option value="<?php echo $row->code; ?>"><?php echo $row->code; ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3  col-xs-6">Activity
                                                        Name</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <select required="" id="activitySelectList" name="activity" style="width: 100%"
                                                                class="select_activity form-control" tabindex="-1">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                                           for="last-name">Amount
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input required type="number" step="0.01" placeholder="Amount"
                                                               id="amount" name="amount"
                                                               class="form-control col-md-7 col-xs-12">
                                                    </div>
                                                </div>

                                                <div align="right" class="form-group">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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
        <!-- End Tabs -->

        <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete"
             tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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


    </div>
</div>
<!-- /page content -->

<?php
 ?>

<!-- fstdropdown -->
<script src="<?php echo  url(''); ?>style/fstdropdown/fstdropdown.js"></script>

<script>
    $(document).ready(function(){
        $('#datatable1').DataTable( {
            responsive: true
        } );

        $('#datatable2').DataTable( {
            responsive: true
        } );

        $('#datatable3').DataTable( {
            responsive: true
        } );

        $(".select2_funder").select2({
            placeholder: "Select Project",
            allowClear: true
        });

        $(".select2_project").select2({
            placeholder: "Select Project",
            allowClear: true
        });

        $(".select_activity").select2({
            placeholder: "Select Activity",
            allowClear: true
        });

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

<script type="text/javascript">
    function deactivateFunder(id) {

        const message = "Are you sure you want this funder inactive?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;

        $("#yes_delete").click(function () {
            $('#activity' + id).show();
            $.ajax({
                url: "<?php echo url('flex/performance/deactivateFunder');?>/" + id,
                success: function (data) {
                    if (data.status == 'OK') {

                        $('#delete').modal('hide');
                        notify('Funder deactivated successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        $('#delete').modal('hide');
                        notify('Funder deactivation failed, try again!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }
                }
            });
        });

    }

    function deleteSegment(id) {

        const message = "Are you sure you want this segment deleted?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;

        $("#yes_delete").click(function () {
            $('#activity' + id).show();
            $.ajax({
                url: "<?php echo url('flex/performance/deleteSegment');?>/" + id,
                success: function (data) {
                    if (data.status == 'OK') {

                        $('#delete').modal('hide');
                        notify('Project segment deleted successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        $('#delete').modal('hide');
                        notify('Project segment deletion failed, try again!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }
                }
            });
        });

    }

    function deleteCategory(id) {

        const message = "Are you sure you want this category deleted?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;

        $("#yes_delete").click(function () {
            $('#activity' + id).show();
            $.ajax({
                url: "<?php echo url('flex/performance/deleteCategory');?>/" + id,
                success: function (data) {
                    if (data.status == 'OK') {

                        $('#delete').modal('hide');
                        notify('Category deleted successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        $('#delete').modal('hide');
                        notify('Category deletion failed, try again!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }
                }
            });
        });

    }

    function deleteException(id) {

        const message = "Are you sure you want this exception deleted?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;

        $("#yes_delete").click(function () {
            $('#activity' + id).show();
            $.ajax({
                url: "<?php echo url('flex/performance/deleteException');?>/" + id,
                success: function (data) {
                    if (data.status == 'OK') {

                        $('#delete').modal('hide');
                        notify('Exception deleted successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    } else {
                        $('#delete').modal('hide');
                        notify('Exception deletion failed, try again!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);

                    }
                }
            });
        });

    }


</script>
<script type="text/javascript">
    $('#addFunder').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/performance/addFunder",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Funder added successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                    $('#addFunder')[0].reset();

                } else {
                    notify('Funder added error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Funder Not Added! Please Review Your Network Connection ...');
            });

    });

    $('#addSegment').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/performance/addSegment",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Project segment added successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                    $('#addFunder')[0].reset();

                } else {
                    notify('Project segment added error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Project segment  Not Added! Please Review Your Network Connection ...');
            });

    });

    $('#addCategory').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/performance/addCategory",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Expense category added successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                } else {
                    notify('Expense category added error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Expense category Not Added! Please Review Your Network Connection ...');
            });

    });

    $('#addException').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/performance/addException",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Exception added successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                } else {
                    notify('Exception added error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Exception Not Added! Please Review Your Network Connection ...');
            });

    });

    $('#addRequest').submit(function (e) {

        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: "<?php echo  url(''); ?>/flex/performance/addRequest",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
            .done(function (data) {
                if (data.status == 'OK') {
                    notify('Request added successfully!', 'top', 'right', 'success');

                    setTimeout(function () {// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                } else {
                    notify('Request added error, please try again!', 'top', 'right', 'danger');
                }
            })
            .fail(function () {
                alert('Request Not Added! Please Review Your Network Connection ...');
            });

    });

    $('#projectSelectList').on('change', function () {
        var projectCode = $('#projectSelectList').val();
        if (projectCode) {
            $.ajax({
                type: 'POST',
                url: '<?php echo  url(''); ?>/flex/project/fetchActivity',
                data: 'projectCode=' + projectCode,
                success: function (html) {
                    $('#activitySelectList').html(html);
                }
            });
        } else {
            $('#activitySelectList').html('<option value="">Select Project</option>');
        }
    });

</script>


 @endsection