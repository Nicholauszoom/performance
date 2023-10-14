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
                <h3>User Profile</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card ">
                  <div class="card-head">
                    <h2><?php echo session('fname')." ".session('mname')." ".session('lname'); ?> <small>User Details</small></h2><br>

                   <?php echo "<br>".session("note");  ?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
                  <div class="card-body">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          
                          <img class="img-responsive avatar-view" src="<?php echo  url('').session('photo'); ?>" alt="<?php echo session('fname')." ".session('lname'); ?>">
                        </div>
                      </div>
                      <h3><?php echo session('fname')." ".session('mname')." ".session('lname'); ?></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo session('postal_address').", ".session('postal_city'); ?>
                        </li>

                        <li>
                          <i class="fa fa-phone user-profile-icon"></i> <?php echo session('mobile'); ?>
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?php echo session('position'); ?>
                        </li>
                      </ul>

                      <a href="<?php echo  url(''); ?>/flex/editemployee/".auth()->user()->emp_id; ?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                      <br />

                      <!-- start skills -->
                      <!-- <h4>Skills</h4>
                      <ul class="list-unstyled user_data">
                        <li>
                          <p>Web Applications</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                        <li>
                          <p>Website Design</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                          </div>
                        </li>
                        <li>
                          <p>Automation & Testing</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                          </div>
                        </li>
                        <li>
                          <p>UI / UX</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                      </ul> -->
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <!-- <div class="profile_title">
                        <div class="col-md-6">
                          <h2>User Activity Report</h2>
                        </div>
                         <div class="col-md-6">
                          <div id="reportrange" class="pull-right" style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                          </div>
                        </div> 
                      </div> -->
                      <!-- start of user-activity-graph -->
                      <!-- <div id="graph_bar" style="width:100%; height:280px;"></div> -->
                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_basic" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">BASIC</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" id="profile-tab" role="tab" data-toggle="tab" aria-expanded="true">WORK</a>
                          </li>
                          <!-- <li role="presentation" class=""><a href="#tab_work" role="tab" id="work-tab" data-toggle="tab" aria-expanded="true">Work</a>
                          </li> -->
                          <li role="presentation" class=""><a href="#tab_role" role="tab" id="role-tab" data-toggle="tab" aria-expanded="true">ROLES AND PERMISSION</a>
                          </li>
                          <li rol

                          <li role="presentation" class=""><a href="#tab_property" role="tab" id="property-tab" data-toggle="tab" aria-expanded="true">PROPERTY</a>
                          </li>
                        </ul>
                        <div class="tab-content">

                        <!-- BASIC -->
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_basic" aria-labelledby="home-tab">

                            <!-- start recent activity -->
                            <ul class="messages">
                            <table border="0px">
                              <thead>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><h4>Gender:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('gender'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Email:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('email'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Merital Status:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('merital_status'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Date of Birth:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php 
                                //   $datewell = explode("-",session('birthdate'));
                                //   $mm = $datewell[1];
                                //   $dd = $datewell[2];
                                //   $yyyy = $datewell[0];  
                                //   $clear_date = $dd."-".$mm."-".$yyyy; 
                                   echo date('d-m-Y', strtotime(session('birthdate')))  ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Nationality:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('nationality'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Physical Address:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('physical_address'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Last Updated:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php 
                                  $datewell = explode("-",session('last_updated'));
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy; 
                                  echo $clear_date; ?></h4></td>
                                </tr>
                              </tbody>
                            </table>
                            </ul>
                            <!-- end recent activity -->
                          </div>
                          <!-- END BASIC -->

    


                          <!-- NEXT OF KIN -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start user projects -->
                      <div class="col-md-8">
                            <table border="0px">
                              <thead>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><h4>Employee ID:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo auth()->user()->emp_id; ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Department:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('department'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Position:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('position'); ?></h4></td>
                                </tr>
                                <tr>
                                <tr>
                                  <td><h4>Line Manager:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('linemanager'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Contract Type:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('ctype'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Account No:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('account_no'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Salary:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('salary'); ?>&nbsp;&nbsp; 
                                   
                            <button type="button" id="modal" data-toggle="modal" data-target="#payslipModal" class="btn btn-success">Print Payslip</button>
                              <!-- </form> -->
                              </h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Form Four Index No.:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('form_four_index_no'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Fund Membership No.:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php echo session('pf_membership_no'); ?></h4></td>
                                </tr>
                                <tr>
                                  <td><h4>Member Since:</h4></td>
                                  <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <?php $datewell = explode("-",session('hire_date'));
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy; 
                                  echo $clear_date; ?></h4></td>
                                </tr>
                              </tbody>
                            </table>                      
                          </div><br><br>
                      <div class="card">
                        <div class="card-head">
                          <h2>Next of Kin(s)</h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li>
                            <?php if(session('regemp')!=0)
                    { ?> 
                            <button type="button" id="modal" data-toggle="modal" data-target="#nextkinModal" class="btn btn-main">Add</button><?php } ?>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Relationship</th>
                                  <th>Mobile</th>
                                  <th>Postal Address</th>
                                  <th>Option</th>
                                </tr>
                              </thead>


                              <tbody>
                                <?php
                                  foreach ($kin as $row) { ?>
                                  <tr>
                                    <td width="1px"><?php echo $row->id; ?></td></td>
                                    <td><?php echo $row->fname." ".$row->mname." ".$row->lname; ?></td>
                                    <td><?php echo $row->relationship; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo $row->postal_address; ?></td>

                                    <td class="options-width">
                                   <a href="<?php echo  url(''); ?>/flex/deletekin/".$row->id; ?>"   title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="ph-trash-o"></i></font></a>&nbsp;&nbsp;
                                   </td>
                                    </tr>
                                  <?php }  ?>
                                </tbody>
                              </table>
                              </div>
                            </div>
                              <!-- end user projects -->
                        </div>
                       <!-- END  NEXT OF KIN -->


                        <!-- ROLES -->
                        <div role="tabpanel" class="tab-pane fade" id="tab_role" aria-labelledby="role-tab">

                            <!-- start user projects -->
                      <div class="col-md-6">
                      <div class="card">
                        <div class="card-head">
                          <h2>Roles Already Granted</h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo  url(''); ?>/flex/revokerole/" method="post">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <?php if(session('managerole')!=0)
                    { ?> 
                          <th>Option</th><?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($role as $row) { 
                          //$arr1 = str_split($permission); ?>
                          <tr >
                            <!-- <td width="1px"><?php echo $row->id; ?></td></td> -->
                            <td><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->NAME; ?></td>
                            <?php if(session('managerole')!=0)
                    { ?> 
                            <td class="options-width">
                           <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">

                           </td><?php } ?>
                           </tr>
                          <?php }  ?>
                      </tbody>
                    </table><?php if(session('managerole')!=0)
                    { ?> 
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  type="submit"  name="revoke" class="btn btn-warning">REVOKE</button>
                        </div><?php } ?>
                      </div>   
                          </form>
                              </div>
                            </div>
                          </div>
                              <!-- end user projects -->
                              <?php if(session('managerole')!=0)
                    { ?> 
                      <div class="col-md-6">
                      <div class="card">
                        <div class="card-head">
                          <h2>Roles Not Granted</h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo  url(''); ?>/flex/assignrole/<?php echo auth()->user()->emp_id; ?>" method="post">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Option</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php

                          foreach ($allrole as $row) { 
                          //$arr1 = str_split($permission); ?>
                          <tr >
                            <!-- <td width="1px"><?php echo $row->id; ?></td></td> -->
                            <td><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>

                            <td class="options-width">
                           <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">

                           </td>
                           </tr>
                          <?php }//}
                          //else echo 'No Records Found';  ?>
                      </tbody>
                    </table><?php if ($rolecount > 0) { ?>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  type="submit"  name="assign" class="btn btn-success">GRANT</button>
                        </div>
                      </div> <?php } else echo "No Role Found Not Granted to this User"; ?>  
                          </form>
                              </div>
                            </div>
                          </div><?php } ?>
                              <!-- end user projects -->

                        </div>
                        <!-- END ROLES --> <div role="tabpanel" class="tab-pane fade" id="tab_property" aria-labelledby="property-tab-tab">
                    <br><br>
                      <div class="card">
                        <div class="card-head">
                          <h2>Company Proprty(ies)</h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li>
                            <?php if(session('regemp')!=0)
                    { ?> 
                            <button type="button" id="modal" data-toggle="modal" data-target="#propertyModal" class="btn btn-main">Assign More Property</button><?php } ?>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>S/N</th>
                                  <th>Type</th>
                                  <th>Name</th>
                                  <th>Serial No</th>
                                  <th>Assigned By</th>
                                  <th>Date</th>
                                  <th>Option</th>
                                </tr>
                              </thead>


                              <tbody>
                                <?php
                                  foreach ($property as $row) { ?>
                                  <tr id="domain<?php echo $row->id;?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td></td>
                                    <td><?php echo $row->prop_type; ?></td>
                                    <td><?php echo $row->prop_name; ?></td>
                                    <td><?php echo $row->serial_no; ?></td>
                                    <td><?php echo $row->PROVIDER; ?></td>
                                    <td><?php echo $row->dated_on; ?></td>

                                    <td class="options-width">
                                   <a href="<?php echo  url(''); ?>/flex/deleteproperty/".$row->id."&employee=".$empID; ?>"    title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="ph-trash-o"></i></font></a>&nbsp;&nbsp;
                                   <a href="javascript:void(0)" onclick="deleteDomain(<?php echo $row->id;?>)"  title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="ph-trash-o"></i></font></a>&nbsp;&nbsp;
                           <a href="javascript:void(0)" class="hide" id="hide<?php echo $row->id;?>">Please wait...</a>
                                   </td>
                                    </tr>
                                  <?php }  ?>
                                </tbody>
                              </table>
                              </div>
                            </div>
                              <!-- end user projects -->
                        </div>
                       <!-- END  NEXT OF KIN -->


                        <!--PROPERTY Modal -->
                <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Assign a Property to <?php echo session('fname')." ".session('mname')." ".session('lname'); ?></h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/addproperty/ ?>"  data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Property Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="type" class="form-control">
                           <option value="Computer">Computer</option>
                            <option value="Printer">Printer</option>
                            <option value="Vehicle">Vehicle</option>
                            <option value="Others">Others</option>
                        </select>
                        </div>
                      </div>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">(Specify if Others)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="type2" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Property Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Serial Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="serial"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                      
                      <div class="modal-footer">
                      <input hidden="hidden"  name="employee" value="<?php echo auth()->user()->emp_id; ?>">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit"  value="Add" name="add" class="btn btn-main"/>
                      </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          <!-- Modal Form -->          
          </div>           
          <!-- /.modal --> 



        <!--Next Kin Modal -->
                <div class="modal fade" id="nextkinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add Next of Kin</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/addkin/<?php echo auth()->user()->emp_id; ?>"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="fname" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="mname" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="lname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Relationships</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="relationship" class="form-control">
                           <option value="Son/Doughter">Son/Doughter</option>
                            <option value="Uncle/Aunt">Uncle/Aunt</option>
                            <option value="Brother/Sister">Brother/Sister</option>
                            <option value="Father/Mother">Father/Mother</option>
                            <option value="Grandfather/GrandMother">Grandfather/GrandMother</option>
                            <option value="Wife/Husband">Wife/Husband</option>
                        </select>
                        </div>
                      </div>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Mobile
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="mobile" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Postal Address
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="postal_address" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Physical Address
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="physical_address" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Office Mobile No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="office_no" id="fname"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit"  value="Add" name="add" class="btn btn-main"/>
                      </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          <!-- Modal Form -->          
          </div>           
          <!-- /.modal --> 


          <!--Payslip Modal -->
                <div class="modal fade" id="payslipModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel"> Payslip</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url('')."flex/reports/payslip/"; ?>"  data-parsley-validate class="form-horizontal form-label-left">
                        
                        <input type="text" hidden="hidden" value="<?php echo auth()->user()->emp_id; ?>" name="employee">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Payslip For The Month Of
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="single_cal1"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div> 

                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <input type="submit"  value="PRINT" name="print" class="btn btn-success"/>
                      </div>
                      </form>
                  </div>
                  <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
          <!-- Modal Form -->          
          </div>           
          <!-- /.modal -->

                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->





 @endsection