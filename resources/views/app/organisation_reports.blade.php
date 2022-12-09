@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Organisation Financial Reports </h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Organisation Reports</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Volunteer Allowance MWP</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/volunteerAllowanceMWPExport" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!--PANEL-->



                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Bank Payment</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/staffPayrollBankExport" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Payroll Input Journal</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/payrollInputJournalExport" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>

                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Pay Checklist</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/pay_checklist" target="_blank" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Master Payroll</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/employeeCostExport"  data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Employee BioData</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/employeeBioDataExport"  data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="control-label col-md-3  col-xs-6" >Status</label>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <select required="" name="status" class="status form-control" tabindex="-1">
                                                    <option value="" selected disabled>Select Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="4">Inactive</option>
                                                </select>
                                            </div>
                                            <span class="input-group-btn">
                                            <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                                         </span>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Gross Reconciliation</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/grossReconciliation"  data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Net Reconciliation</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/netReconciliation"  data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Loans</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/loanReports"  data-parsley-validate class="form-horizontal form-label-left" target="_blank">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Payroll Input Journal (Time)</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/payrollInputJournalExportTime" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>

                                        <span class="input-group-btn">
                                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Project</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/projectTime" data-parsley-validate class="form-horizontal form-label-left" target="_blank">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Project</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="project" class="select_payroll_project form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($projects as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->code.'~'.$row->name; ?>"><?php echo  $row->name; ?></option> <?php } ?>
                                            </select>
                                        </div>

                                        <span class="input-group-btn">
                                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" for="stream" >Select Date</label>
                                        <div class="has-feedback col-md-4 col-sm-6 col-xs-12">
                                            <input type="text" required name="duration" placeholder="time" autocomplete="off"
                                                   class="form-control col-xs-12 has-feedback-left" id="duration"
                                                   aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Time
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Expense
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php echo form_error("fname");?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Funder</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/reports/funder" data-parsley-validate class="form-horizontal form-label-left" target="_blank">

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" >Project</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="project" class="select_payroll_project form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($projects as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->code.'~'.$row->name; ?>"><?php echo  $row->name; ?></option> <?php } ?>
                                            </select>
                                        </div>

                                        <span class="input-group-btn">
                                          <input type="submit"  value="PRINT" name="run" class="btn btn-primary"/>
                                      </span>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6" for="stream" >Fund Request Date</label>
                                        <div class="has-feedback col-md-4 col-sm-6 col-xs-12">
                                            <input type="text" required name="duration" placeholder="date" autocomplete="off"
                                                   class="form-control col-xs-12 has-feedback-left" id="duration_"
                                                   aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>

                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- /page content -->



<script>
    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear()-18;
        var endYear = today.getFullYear()-60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#duration span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#duration').daterangepicker({
            drops: 'up',
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });

    $(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var startYear = today.getFullYear()-18;
        var endYear = today.getFullYear()-60;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }


        var dateStart = dd + '/' + mm + '/' + startYear;
        var dateEnd = dd + '/' + mm + '/' + endYear;
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#duration_ span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#duration_').daterangepicker({
            drops: 'up',
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>

 @endsection