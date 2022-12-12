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
                <h3>Payroll and Financial Reports </h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Statutory Reports</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">


                        <!--PANEL-->


                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>P9 (P.A.Y.E)</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                      action="<?php echo  url(''); ?>/flex/reports/p9" target="_blank"
                                      data-parsley-validate class="form-horizontal form-label-left">

                                        @csrf
                                      <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate"
                                                    class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit" value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Skills Development Levy SDL (P10)</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                      action="<?php echo  url(''); ?>/flex/reports/p10" target="_blank"
                                      data-parsley-validate class="form-horizontal form-label-left">

    @csrf
                                      <!--                                    <div class="form-group">-->
<!--                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>-->
<!--                                        <div class="col-md-3 col-sm-6 col-xs-12">-->
<!--                                            <select required="" name="payrolldate"-->
<!--                                                    class="select_payroll_year form-control" tabindex="-1">-->
<!--                                                <option></option>-->
<!--                                                --><?php
//                                                foreach ($year_list as $row) {
//                                                    # code... ?>
<!--                                                    <option value="--><?php //echo $row->year; ?><!--">--><?php //echo $row->year; ?><!--</option> --><?php //} ?>
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <span class="input-group-btn">-->
<!--                          <input type="submit" value="PRINT" name="run" class="btn btn-primary"/>-->
<!--                      </span>-->
<!--                                    </div>-->
    @csrf                                    
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
                                    <br>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">For
                                            Period</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> JANUARY to JUNE
                                                <input type="radio" checked name="period" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">JULY to DECEMBER
                                                <input type="radio" name="period" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Pension Fund</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                      action="<?php echo  url(''); ?>/flex/reports/pension" target="_blank"
                                      data-parsley-validate class="form-horizontal form-label-left">

                                        @csrf
                                      <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate"
                                                    class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                                                foreach ($month_list as $row) {
                                                    # code... ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit" value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>
                                    <br>
                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select
                                            Fund</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">

                                            <label class="containercheckbox">NSSF
                                                <input type="radio" checked name="fund" value="2">
                                                <span class="checkmark"></span>
                                            </label>

                                            <!-- <label class="containercheckbox"> PSSSF
                                              <input type="radio" name="fund" value="1">
                                              <span class="checkmark"></span>
                                            </label> -->

                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Workers Compasation Fund</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                      action="<?php echo  url(''); ?>/flex/reports/wcf" target="_blank"
                                      data-parsley-validate class="form-horizontal form-label-left">

                                        @csrf
                                      <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate"
                                                    class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php foreach ($month_list as $row) { ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit" value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!--PANEL-->

                        <!-- PANEL-->
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>HESLB</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form id="demo-form2" enctype="multipart/form-data" method="post"
                                      action="<?php echo  url(''); ?>/flex/reports/heslb" target="_blank"
                                      data-parsley-validate class="form-horizontal form-label-left">


                                        @csrf
                                      <div class="form-group">
                                        <label class="control-label col-md-3  col-xs-6">Payroll Month</label>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <select required="" name="payrolldate"
                                                    class="select_payroll_month form-control" tabindex="-1">
                                                <option></option>
                                                <?php foreach ($month_list as $row) { ?>
                                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <span class="input-group-btn">
                          <input type="submit" value="PRINT" name="run" class="btn btn-primary"/>
                      </span>
                                    </div>

                                        @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Report
                                            Type</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox"> Staff Payroll
                                                <input type="radio" checked name="type" value="1">
                                                <span class="checkmark"></span>
                                            </label>

                                            <label class="containercheckbox">Volunteer Payroll
                                                <input type="radio" name="type" value="2">
                                                <span class="checkmark"></span>
                                            </label>
                                            <span class="text-danger"><?php// // echo form_error("fname"); ?></span>
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



 @endsection