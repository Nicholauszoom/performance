@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<!-- /top navigation -->

<?php
        foreach ($appreciated as $row) {
        $name = $row->NAME;
        $id = $row->empID;
        $position = $row->POSITION;
        $department = $row->DEPARTMENT;
        $description = $row->description;
        $date = $row->date_apprd;
        $photo = $row->photo;
          }       
      ?>
      
        <!-- page content -->
        <div class="right_col" role="main">

                 

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-user"></i> Employee Of The Month </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <?php if (session('manage_strat') !='') { ?>

                    <form id="demo-form2"  enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/add_apprec"  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">                        
                      
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Employee</label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <select required="" name="empID" class="select4_single form-control" tabindex="-1">
                        <option></option>
                           <?php
                          foreach ($employee as $row) {
                             # code... ?>
                          <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description Of Task Perfomed
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <textarea placeholder="Description" cols="10" class="form-control col-md-7 col-xs-12"  name="description"  rows="5"></textarea>
                          <span class="text-danger"><?php ////echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">Cancel</button>
                          <input type="submit"  value="UPDATE" name="update" class="btn btn-success"/>
                        </div>
                      </div> 
                      </form><br><br> <?php } ?>

                      <!-- Whole View -->
               <div class="col-md-12 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Current Employee Of the Month</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- Appreciation  -->
                      <div class="col-lg-12 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Event Date: <?php $datewell = explode("-",$date);
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy; 
                                  echo $clear_date; ?></i></h4>
                            <div class="left col-xs-7">
                              <h2><?php echo $name; ?></h2>
                              <p><strong>Appreciated On: </strong><?php $datewell = explode("-",$date);
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy; 
                                  echo $clear_date; ?> </p>
                              <p><strong>Position: </strong><?php echo $position; ?> </p>
                              <p><strong>Department: </strong><?php echo $department; ?> </p>
                  <?php if (session('regemp') !='') { ?>
                              <a href="<?php echo url(); ?>flex/userprofile/?id=".$id; ?>"><button type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-user"> </i> View Profile
                              </button></a> <?php } ?>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img  src="<?php echo base_url('uploads/userprofile/').$photo; ?>"  class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <p><strong>Task Description</strong></p>
                            <p><?php echo $description; ?></p>
                          </div>
                        </div>
                      </div>
                      <!-- Appreciation -->
                  </div>
                </div>
              </div>
              <!-- Whole View -->

                  </div>
                </div>
              </div>
          </div>
        </div>
        <!-- /page content -->

       <?php
       include_once "app/includes/customtask.php"; 
        ?>


 @endsection