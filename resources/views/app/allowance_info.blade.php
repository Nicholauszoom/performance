@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php 
  foreach ($allowance as $key) {
    $name = $key->name;
    $allowanceID = $key->id;
    $pentionable = $key->pentionable;
    $taxable = $key->taxable;
    $amount = $key->amount;
    $percent = $key->percent;
    $mode = $key->mode;
    $apply_to = $key->apply_to;
  } 
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Allowances </h3>
              </div>

              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <!-- Groups -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id ="feedBackAssignment"></div>
                      <h5> Name:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                    <h5> Amount: <?php if($mode ==1){ ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($amount,2); ?> Tsh</b> <?php } else{ ?> 
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo 100*$percent; ?>% Of Salary</b><?php }  ?>
                    </h5>
                    <!--<h5> Beneficiaries(Individual):&nbsp;&nbsp;<b> 2 Employees </b></h5>
                    <h5> Beneficiaries(Groups):&nbsp;&nbsp;<b> 2 Groups (23 Employees) </b></h5>-->
                    <h5> Total Beneficiaries:&nbsp;&nbsp;<b> <?php echo $membersCount; ?>  Employees </b></h5>
                    
                    <br><br>
                    <h2><i class="fa fa-plus"></i>&nbsp;&nbsp;<b>Add Members</b></h2>
                    <!--<div id="details">-->
                    <form autocomplete="off" id="assignIndividual" enctype="multipart/form-data"   method="post"  data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" ><i class="fa fa-user"></i>&nbsp; Employee</label>
                        <div  class="col-md-6 col-sm-6 col-xs-12">
                        <select required="" name="empID" class="select4_single form-control" tabindex="-1">
                        <option></option>
                           <?php
                          foreach ($employee as $row) {
                             # code... ?>
                          <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                      <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-primary">ADD</button>
                        </div>
                      </div> 
                    </form>


                    <form autocomplete="off" id="assignGroup"  data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" ><i class="fa fa-users"></i>Group</label>
                        <div  class="col-md-6 col-sm-6 col-xs-12">
                        <select required="" name="group" class="select_group form-control" tabindex="-1">

                        <option></option>
                           <?php
                          foreach ($group as $row) {
                             # code... ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                      <input type="text" hidden="hidden" name="allowance" value="<?php echo $allowanceID?>">
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-primary">ADD</button>
                        </div>
                      </div> 
                    </form>
                    <!--</div><!-- details DIV for Refresh -->
                  </div>
                </div>
              </div>
              <!-- Groups -->
              
              <!--UPDATE-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id ="feedBackSubmission"></div>
                      <form autocomplete="off" id="updateName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off" id="updateTaxable" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <label  for="first-name" for="stream" >Is Taxable?</label>
                            <select name="taxable" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value="YES" <?php if($taxable == 'YES') echo "selected";   ?>>YES</option>
                           <option value="NO" <?php if($taxable == 'NO') echo "selected";   ?>>NO</option>
                        </select>
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off" id="updatePentionable" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <label  for="first-name" for="stream" >Is Pentionable?</label>
                            <select name="pentionable" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value="YES" <?php if($pentionable == 'YES') echo "selected";   ?>>YES</option>
                           <option value="NO" <?php if($pentionable == 'NO') echo "selected";   ?>>NO</option>
                        </select>
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                    
                      <div id ="policy">
                       <?php if($mode ==1){ ?>
                      <form autocomplete="off"  id="updateAmount" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <input required="" type="number" name="amount" step ="1" min="1" max="10000000" value="<?php echo $amount; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                        <?php }  if($mode ==2){ ?> 
                      <form autocomplete="off" id="updatePercent" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                            <input type="number" name="percent" min="0" max="99" step ="0.1" value="<?php echo 100*$percent; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button class="btn btn-primary">% Update Percent</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <?php } ?>
                      </div>
                      <form autocomplete="off" id="updatePolicy" method = "post" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Change Policy
                        </label>
                        <input hidden name ="allowanceID" value="<?php echo $allowanceID; ?>">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="containercheckbox">Fixed Amout
                            <input <?php if($mode ==1){ ?> checked=""  <?php } ?>  type="radio" value="1" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                          <label class="containercheckbox">Percent(From Basic Salary)
                            <input <?php if($mode ==2){ ?> checked=""  <?php } ?>  type="radio" value="2" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  name="updatename" class="btn btn-success">Update</button>
                        </div>
                      </div>
                      </form>
                      
                      
                      
                      
                      <!--<form autocomplete="off" id="upload_form" align="center" enctype="multipart/form-data" method="post" action="<?php echo  url(''); ?>/flex/updaterole/?id=<?php //echo $id; ?>"  data-parsley-validate class="form-horizontal form-label-left">
                          
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Role Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  value="<?php //echo $row->name; ?>" name="name" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("lname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Permission Tag
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input disabled="disabled"  value="<?php //echo $row->activity; ?>" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  type="submit"  name="updatename" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>-->
                  </div>
              </div>
              </div>
              <!--UPDATE-->
            </div> <!--end row-->

            <div class="row">              
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;&nbsp;<b>Allowance Beneficiaries in Details</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Groups(s)</h2>
    
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div id ="feedBackRemoveGroup"></div>
                        <form autocomplete="off" id = "removeGroup" method="post"  >
                            <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
                        <table class="table  table-bordered" >
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Mark &nbsp;&nbsp;&nbsp;<a  title="Remove Selected"><button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs"><i class="fa fa-trash"></i></button></a></th>
                            </tr>
                          </thead>
    
    
                          <tbody>
    
                            <?php
                              foreach ($groupin as $row) { ?>
                              <tr>
                                <td><?php echo $row->NAME; ?></td>
                                <td>
                               <label class="containercheckbox">
                               <input type="checkbox" name="option[]" value="<?php echo $row->id; ?>">
                                <span class="checkmark"></span>
                              </label></td>
                                </tr>
                              <?php } //} ?>
                          
                          </tbody>
                        </table>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">                          
                        <h2>Individual Employees </h2>    
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div id ="feedBackRemove"></div>
                        <form autocomplete="off" id = "removeIndividual" method="post"  >
                            <input type="text" hidden="hidden" name="allowanceID" value="<?php echo $allowanceID; ?>">
    
                        <table  id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>S/N</th>
                              <th>Name</th>
                              <th>Mark &nbsp;&nbsp;&nbsp;<a  title="Remove Selected"><button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs"><i class="fa fa-trash"></i></button></a></th>
                            </tr>
                          </thead>
                          <tbody>
                              
                            <?php
                              foreach ($employeein as $row) { ?>
                              <tr>
                                <td><?php echo $row->SNo; ?></td>
                                <td><?php echo $row->NAME; ?></td>
                                <td>
                               <label class="containercheckbox">
                               <input type="checkbox" name="option[]" value="<?php echo $row->empID; ?>">
                                <span class="checkmark"></span>
                              </label></td>
                                </tr>
                              <?php }  ?>
                          </tbody>
                        </table>  
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


        <!-- /page content -->   

@include('app/includes/update_allowances')
 @endsection