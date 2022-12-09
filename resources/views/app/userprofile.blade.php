@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php


                foreach ($employee as $row) {

                  $name = $row->fname." ".$row->mname." ".$row->lname;
                  $state = $row->state;
                  $department = $row->deptname;
                  $empID = $row->emp_id;
                  $gender = $row->gender;
                  $merital_status = $row->merital_status;
                  $birthdate = explode("-",$row->birthdate);
                  $hire_date = explode("-",$row->hire_date);
                  $position = $row->pName;
                  $ctype = $row->CONTRACT;
                  $linemanager = $row->LINEMANAGER;
                  $pf_membership_no = $row->pf_membership_no;
                  $account_no = $row->account_no;
                  $mobile = $row->mobile;
                  $salary = $row->salary;
                  $nationality = $row->country;
                  $email = $row->email;
                  $departmentID = $row->department;
                  $nhif = $row->pf_membership_no;
                  $photo = $row->photo;
                  $branch = $row->branch;
                  // $leave_days = $row->leave_days;
                  $postal_address = $row->postal_address;
                  $postal_city = $row->postal_city;
                  $physical_address = $row->physical_address;
                  $home_address = $row->home;
                    $retired = $row->retired;
                    $login_user = $row->login_user;

                  }

                  foreach($active_properties as $rowActive) {
                      $numActive = $rowActive->ACTIVE_PROPERTIES;
                  }


                  $delimeter = "|";
                    ?>
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
                  <div id="resultFeedback"></div>
                  <?php if ($this->session->flashdata("note")){
//                      echo '<script> showMessage("yes"); </script>';
                  } ?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $name; ?> <small>User Details</small></h2><br><br>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <img class="img-responsive avatar-view" src="<?php echo base_url('uploads/userprofile/').$photo; ?>"" alt="<?php echo $name; ?>">
                        </div>
                      </div>
                      <h3><?php echo $name; ?></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $postal_address.", ".$postal_city; ?>
                        </li>

                        <li>
                          <i class="fa fa-phone user-profile-icon"></i> <?php echo $mobile; ?>
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $position; ?>
                        </li>
                      </ul>
                        <?php if(session('mng_emp'))  { ?>
                            <a href="<?php echo url(); ?>flex/updateEmployee/?id=".$empID."|".$departmentID; ?>" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>&nbsp;&nbsp;UPDATE PROFILE</a>

<!--                            --><?php //if ($retired != 2) { ?>
<!--                                <a href="--><?php //echo url()."flex/cipay/retired/?id=".$empID; ?><!--" class="btn btn-warning"><i class="fa fa-minus"></i>&nbsp;&nbsp;RETIRED</a>-->
<!--                            --><?php //} else { ?>
<!--                                <a href="--><?php //echo url()."flex/cipay/retired/?id=".$empID; ?><!--" class="btn btn-warning" disabled=""><i class="fa fa-minus"></i>&nbsp;&nbsp;RETIRED</a>-->
<!--                            --><?php //} ?>

                        <?php }  ?>
                      <br />


                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                                   <!-- Salary Slip -->
                      <?php if( session('mng_emp') || session('emp_id') == $empID ){ ?>
                      <form method="post" action="<?php echo url(); ?>flex/reports/payslip" target="_blank" class="form-horizontal form-label-left">
                          <div class="col-sm-6">
                          <div id ="feedBackMeritalStatus"></div>
                            <div class="form-group">
                              <label for="stream" >Pay Slip</label>
                               <div class="input-group">
                                  <input hidden name ="employee" value="<?php echo $empID; ?>">
                                  <input hidden name ="profile" value="1">
                                  <select required="" name="payrolldate" class="select_payroll_month form-control" tabindex="-1">
                                  <option></option>
                                     <?php
                                    foreach ($month_list as $row) {
                                       # code... ?>
                                    <option value="<?php echo $row->payroll_date; ?>"><?php echo  date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                  </select>
                                  <span class="input-group-btn">
                                    <input type="submit"  value="PRINT" name="print" class="btn btn-primary"/>
                                  </span>
                                </div>
                            </div>
                          </div>
                      </form>
                    <?php } ?>



                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#basicInfo" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">BASIC</a>
                          </li>
                          <li role="presentation" class=""><a href="#workInfo" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">WORK</a>
                          </li>
                          <?php if(session('mng_roles_grp'))  { ?>
                            <li role="presentation" class=""><a href="#permissionInfo" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">PERMISSION</a>
                          </li>
                          <?php } ?>
                          <li role="presentation" class=""><a href="#assetInfo" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">ASSET</a>
                          </li>
                          <li role="presentation" class=""><a href="#learningInfo" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">L &amp; D</a>
                          </li>

                          <li role="presentation" class=""><a href="#exitInfo" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"><font color = "red"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<b>EXIT</b></font></a>
                          </li>

                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="basicInfo" aria-labelledby="home-tab">
                            <!-- start basic Tab -->
                              <table border="0px" >
                                <thead>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><h4>Gender:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $gender; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Email:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $email; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Merital Status:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $merital_status; ?></h4></td>
                                  </tr>
                                  <?php if( session('mng_emp') || session('emp_id') == $empID ){ ?>
                                  <tr>
                                    <td><h4>Date of Birth:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $birthdate[2]."-".$birthdate[1]."-".$birthdate[0]; ?></h4></td>
                                  </tr>
                                  <?php } ?>
                                  <tr>
                                    <td><h4>Nationality:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $nationality; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Physical Address:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $physical_address; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Last Updated:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $hire_date[2]."-".$hire_date[1]."-".$hire_date[0]; ?></h4></td>
                                  </tr>
                                </tbody>
                              </table>

                            <!-- end basic Tab -->
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="workInfo" aria-labelledby="profile-tab">

                            <!-- start Work Tab -->
                            <div class="col-md-8">
                              <table border="0px" >
                                <thead>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><h4>Employee ID:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $empID; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Department:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $department; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Position:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $position; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Branch:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $branch; ?></h4></td>
                                  </tr>
                                  <tr>
                                  <tr>
                                    <td><h4>Line Manager:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $linemanager; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Contract Type:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $ctype; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Account No:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $account_no; ?></h4></td>
                                  </tr>
                                  <?php if( session('mng_emp') || session('appr_paym') || session('mng_paym') || session('emp_id') == $empID ){ ?>
                                  <tr>
                                    <td><h4>Salary:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $salary; ?></h4></td>
                                  </tr>
                                  <?php } ?>
                                  <tr>
                                    <td><h4>Fund Membership No.:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $pf_membership_no; ?></h4></td>
                                  </tr>
                                  <tr>
                                    <td><h4>Member Since:</h4></td>
                                    <td><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo $hire_date[2]."-".$hire_date[1]."-".$hire_date[0]; ?></h4></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div><br><br>
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Next of Kin(s)</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                  <li>
                                  <?php if(session('mng_emp'))  { ?>
                                  <button type="button" id="modal" data-toggle="modal" data-target="#nextkinModal" class="btn btn-primary">Add</button><?php } ?>
                                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                                  </li>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <table  class="table table-striped table-bordered">
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
                                    <?php foreach ($kin as $row) { ?>
                                    <tr>
                                      <td width="1px"><?php echo $row->id; ?></td></td>
                                      <td><?php echo $row->fname." ".$row->mname." ".$row->lname; ?></td>
                                      <td><?php echo $row->relationship; ?></td>
                                      <td><?php echo $row->mobile; ?></td>
                                      <td><?php echo $row->postal_address; ?></td>

                                      <td class="options-width">
                                        <a href="<?php echo url(); ?>flex/deletekin/?id=".$row->id; ?>"   title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="fa fa-trash-o"></i></font></a>&nbsp;&nbsp;
                                      </td>
                                    </tr>
                                    <?php }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <!-- end  Work Tab -->

                            <!-- START NEXT OF KIN MODAL -->
                              <div class="modal fade" id="nextkinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add Next of Kin to <?php echo $name; ?></h4>
                                        </div>
                                        <div class="modal-body">
                                        <!-- Modal Form -->
                                        <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/addkin/?id=<?php echo $empID; ?>"  data-parsley-validate class="form-horizontal form-label-left">
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="fname" id="fname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Middle Name
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="mname" id="fname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="lname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
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
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Postal Address
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="postal_address" id="fname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Physical Address
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="physical_address" id="fname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>
                                      <div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Office Mobile No
                                      </label>
                                      <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="office_no" id="fname"  class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php //echo form_error("fname");?></span>
                                      </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit"  value="Add" name="add" class="btn btn-primary"/>
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

                            <!-- END NEXT OF KIN MODAL -->

                          </div>
                          <?php if(session('mng_roles_grp') || session('emp_id') == $empID)  { ?>
                          <div role="tabpanel" class="tab-pane fade" id="permissionInfo" aria-labelledby="profile-tab">

                            <div class="col-md-6">
                              <div class="x_panel">
                                <div class="x_title">
                                    <h2>Roles Granted</h2>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                  <form action="<?php echo url(); ?>flex/revokerole" method="post">
                                  <input type="text" hidden="hidden" name="empID" value="<?php echo $empID; ?>" />
                                  <table  class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <?php if(session('mng_roles_grp')) { ?>
                                        <th>Option</th><?php } ?>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php  foreach ($role as $row) {   ?>
                                      <tr >
                                        <td><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->NAME; ?></td>
                                        <?php if(session('mng_roles_grp'))  { ?>
                                        <td class="options-width">
                                          <label class="containercheckbox">
                                          <input type="checkbox" name="option[]" value="<?php echo $row->role; ?>">
                                          <span class="checkmark"></span>
                                          </label>
                                          <input type="text" hidden="hidden" name="roleid" value="<?php echo $row->id; ?>" />

                                        </td><?php } ?>
                                      </tr>
                                        <?php }  ?>
                                    </tbody>
                                  </table>
                                  <?php if(session('mng_roles_grp'))  { ?>
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                      <button  type="submit"  name="revoke" class="btn btn-success">REVOKE</button>
                                    </div>
                                  </div>
                                  <?php } ?>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- NOT GRANTED -->

                            <?php if(session('mng_roles_grp'))  { ?>
                            <div class="col-md-6">
                              <div class="x_panel">
                                <div class="x_title">
                                    <h2>Roles Not Granted</h2>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                  <form action="<?php echo url(); ?>flex/assignrole/" method="post">
                                  <input type="text" hidden="hidden" name="empID" value="<?php echo $empID; ?>" />
                                  <table  class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Option</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php foreach ($allrole as $row) {  ?>
                                      <tr >
                                        <td><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->name; ?></td>

                                        <td class="options-width">

                                        <label class="containercheckbox">
                                        <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">
                                        <span class="checkmark"></span>
                                        </label>

                                        </td>
                                      </tr>
                                        <?php }   ?>
                                    </tbody>
                                  </table>
                                  <?php if($rolecount > 0) { ?>
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                      <button  type="submit"  name="assign" class="btn btn-success">GRANT</button>
                                    </div>
                                  </div>
                                  <?php } ?>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                          <?php } ?>
                          <div role="tabpanel" class="tab-pane fade" id="assetInfo" aria-labelledby="profile-tab">
                          <!-- START ASSET -->
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Company Proprty(ies)</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                  <?php if(session('mng_emp'))  { ?>
                                  <button type="button" id="modal" data-toggle="modal" data-target="#propertyModal" class="btn btn-primary">Assign More Property</button><?php } ?>
                                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                                  </li>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                              </div>
                            <div class="x_content">
                              <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th>S/N</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Serial No</th>
                                    <th>Assigned By</th>
                                    <th>Date</th>
                                    <?php if(session('mng_emp'))  { ?>
                                    <th>Option</th><?php }  ?>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($property as $row) { ?>
                                  <tr id="domain<?php echo $row->id;?>">
                                    <td width="1px"><?php echo $row->SNo; ?></td></td>
                                    <td><?php echo $row->prop_type; ?></td>
                                    <td><?php echo $row->prop_name; ?></td>
                                    <td><?php echo $row->serial_no; ?></td>
                                    <td><?php echo $row->PROVIDER; ?></td>
                                    <td><?php echo $row->dated_on; ?></td>
                                    <?php if(session('mng_emp'))  { ?>
                                    <td class="options-width">
                                     <a href="javascript:void(0)" onclick="deleteDomain(<?php echo $row->id;?>)"  title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="fa fa-trash-o"></i></font></a>&nbsp;&nbsp;
                                    </td><?php }  ?>
                                  </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <!-- END ASSET -->


                                    <!--PROPERTY Modal -->
                          <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Assign a Property to <?php echo $name; ?></h4>
                                    </div>
                                    <div class="modal-body">
                                    <!-- Modal Form -->
                                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/addproperty/ ?>"  data-parsley-validate class="form-horizontal form-label-left">

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
                                    <span class="text-danger"><?php //echo form_error("fname");?></span>
                                  </div>
                                </div>
                                  <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Property Name
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="name"  class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php //echo form_error("fname");?></span>
                                  </div>
                                </div>
                                  <div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Serial Number
                                  </label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="serial"  class="form-control col-md-7 col-xs-12">
                                    <span class="text-danger"><?php //echo form_error("fname");?></span>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                <input hidden="hidden"  name="employee" value="<?php echo $empID; ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit"  value="Add" name="add" class="btn btn-primary"/>
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
                    <!-- end ASSET MODAL -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="learningInfo" aria-labelledby="profile-tab">

                            <!-- start Skills Acquired -->
                            <div class="col-md-12">
                              <div class="x_panel">
                                <div class="x_title">
                                  <h2>Skills Acquired </h2>
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
                                <div class="x_content">
                                  <table class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        foreach ($skills_have as $row) {  ?>
                                        <tr >
                                          <td><?php echo $row->SNo; ?></td>
                                          <td><?php echo $row->NAME; ?></td>
                                         </tr>
                                        <?php }  ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <!-- end Skills Acquired -->

                            <!-- SKILLS NOT ACQUIRED -->
                            <?php if(session('mng_emp')) { ?>
                            <div class="col-md-12">
                              <div class="x_panel">
                                <div class="x_title">
                                  <h2>Skills Not Acquired (To be Trained)</h2>

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
                                <div class="x_content">
                                  <table  class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Mandatory</th>
                                        <th>Option</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                      <?php

                                        foreach ($skills_missing as $row) {  ?>
                                        <tr id="recordSkills<?php echo $row->id;?>" >
                                          <td><?php echo $row->SNo; ?></td>
                                          <td><?php echo $row->name; ?></td>
                                          <td><?php if($row->mandatory == 1){ ?>

                                          <div class="col-md-12">
                                              <span class="label label-success">YES</span></div><?php }
                                          else{ ?>
                                          <div class="col-md-12">
                                              <span class="label label-warning">NO</span></div><?php } ?></td>

                                          <td class="options-width">
                                          <?php if($row->status==9 ){ ?>


                                        <a href = "<?php echo url(); ?>flex/employeeCertification/?val=<?php echo $empID."|".$row->id; ?>"><button class="btn btn-success btn-xs">ASSIGN SKILL</button></a>
                                        <?php } else{ ?>
                                        <div class="col-md-12"><span class="label label-default">REQUESTED</span></div>

                                          <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING FOR APPROVAL</span></div><?php }
                                          elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-primary">RECOMMENDED</span></div><?php }
                                          elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-info">APPROVED</span></div><?php }
                                          elseif($row->status==3){ ?><div class="col-md-12"><span class="label label-success">CONFIRMED</span></div><?php }
                                          elseif($row->status==4){ ?><div class="col-md-12"><span class="label label-warning">SUSPENDED</span></div><?php }
                                          elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div><?php }
                                          elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php } ?>


                                          <?php } ?>
                                         </td>
                                         </tr>
                                        <?php }  ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <?php }  ?>
                            <!--  END SKILLS NOT ACQUIRED -->

                            <!--REQUESTED SKILLS FOR TRAINING-->
                            <div class="col-md-12">
                              <div class="x_panel">
                                <div class="x_title">
                                  <h2>Skills Requested For Training</h2>
                                  <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                  <table id="skillsTable" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Mandatory</th>
                                        <th>State</th>
                                      </tr>
                                    </thead>

                                    <tbody>
                                      <?php

                                        foreach ($requested_skills as $row) {  ?>
                                        <tr >
                                          <td><?php echo $row->SNo; ?></td>
                                          <td><?php echo $row->name; ?></td>
                                          <td><?php if($row->mandatory == 1){ ?>

                                          <div class="col-md-12">
                                              <span class="label label-success">YES</span></div><?php }
                                          else{ ?>
                                          <div class="col-md-12">
                                              <span class="label label-warning">NO</span></div><?php } ?></td>

                                          <td>

                                          <div id ="status<?php echo $row->id; ?>">
                                            <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php }
                                            elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-primary">RECOMMENDED</span></div><?php }
                                            elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-info">APPROVED</span></div><?php }
                                            elseif($row->status==3){ ?><div class="col-md-12"><span class="label label-success">CONFIRMED</span></div><?php }
                                            elseif($row->status==4){ ?><div class="col-md-12"><span class="label label-warning">SUSPENDED</span></div><?php }
                                            elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div><?php }
                                            elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php } ?>
                                          </div>

                                          </td>

                                         </tr>
                                        <?php }  ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <!--REQUEST SKILLS FOR TRAINING-->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="exitInfo" aria-labelledby="profile-tab">
                            <!-- EXIT -->
                            <div class="col-lg-12">
                                <form id="upload_form" method = "post" align="center" enctype="multipart/form-data" action="<?php echo url(); ?>flex/employeeDeactivationRequest" data-parsley-validate class="form-horizontal form-label-left">

<!--                                    index.php/cipay/employee_exit-->
                                    <?php if ($state != 3): ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="containercheckbox">Employee Initiated
                                                <input checked type="radio" value="Employee" name="initiator">
                                                <span class="checkmarkradio"></span>
                                            </label>
                                            <label class="containercheckbox">Employer Initiated
                                                <input type="radio" value="Employer" name="initiator">
                                                <span class="checkmarkradio"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stream" >Exit Date</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12 has-feedback">
                                            <input type="text" required name="exit_date" autocomplete="off" placeholder="Exit Date" class="form-control col-md-6 col-sm-6 col-xs-12has-feedback-left" id="exit_date"  aria-describedby="inputSuccess2Status">
                                            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Interview Notes
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea placeholder="Message or Reason  For Exit"  cols="10" class="form-control col-md-7 col-xs-12"  name="reason"  rows="5"></textarea>
                                            <span class="text-danger"><?php ////echo form_error("lname");?></span>
                                        </div>
                                    </div>
                                    <input type ="text" hidden name = "empID" value = "<?php echo $empID; ?>" />
                                    <input type ="text" hidden name = "state" value = "disable" />
                                    <div class="text-center mtop20">

                                      <button  type="submit" name="exit" value = "exit" class="btn btn-danger">Confirm Exit</button>
                                    <?php else: ?>
                                        <input type ="text" hidden name = "empID" value = "<?php echo $empID; ?>" />
                                        <input type ="text" hidden name = "state" value = "enable" />
                                        <button  type="submit" name="exit" disabled value = "exit" class="btn btn-danger">Confirm Exit</button>
                                    <?php endif; ?>
                                    <!-- <?php if($state = 0 ){ ?>
                                        <h5><?php echo number_format($allowances,2); ?></h5> <?php } ?>
                                      <button  type="submit" <?php if($state == 1 || $numActive > 0) { ?> disabled <?php } ?> name="exit" value = "exit" class="btn btn-warning">CONFIRM EXIT</button> -->

                                  </div>
                                </form>
                                <hr>
                                <div style="width:20%; margin:0 auto;">
                                    <?php if ($login_user != 1) { ?>
                                        <a href="<?php echo url(); ?>flex/loginuser/?id=".$empID; ?>" class="btn btn-warning"><i class="fa fa-user"></i>&nbsp;&nbsp;LOGIN USER</a>
                                    <?php } else { ?>
                                        <a href="<?php echo url(); ?>flex/loginuser/?id=".$empID; ?>" class="btn btn-warning" disabled=""><i class="fa fa-user"></i>&nbsp;&nbsp;LOGIN USER</a>
                                    <?php } ?>
                                </div>

                            </div>
                             <!-- END EXIT -->
                          </div>
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


    function run(){
        alert("hello world");
    }

    <?php if ($this->session->flashdata("note")){
        echo "notify('Employee exited successfuly!!', 'top', 'right', 'success');";

    } ?>

    <?php if ($this->session->flashdata("retired")){
        echo "notify('Employee retired successfuly!!', 'top', 'right', 'success');";

    } ?>


    <?php if ($this->session->flashdata("loginuser")){
        echo "notify('Employee login user!!', 'top', 'right', 'success');";

    } ?>

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
        $('#exit_date').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            maxYear: parseInt(moment().format('YYYY'),100),
            minDate:dateEnd,
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_2"
        }, function(start, end, label) {

        });
        $('#exit_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#exit_date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });


</script>
 @endsection