@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Deductions </h3>
              </div>
            </div>
            <div class="clearfix"></div>
            
            <!-- PARAMETERS:
                1 For Pension,
                2 For Deductions,
                3 For Meals deductions 
            -->
            
            <!--START PENSION-->
            <?php  if($parameter == 1 ){ 
            
            foreach($pension as $row){
                $fundID = $row->id;
                $name = $row->name;
                $abbrv = $row->abbrv;
                $employee_percent = $row->amount_employee;
                $employer_percent = $row->amount_employer;
                $mode = $row->deduction_from;
                if($mode ==1){
                    $from = "Basic Salary";
                } else {  $from = "Gross Salary"; }
            }
            
            ?>
            
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
                      <h5> Abbrev:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $abbrv; ?></b></h5>
                    <h5> Employee Amount:
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo 100*$employee_percent."% Of ".$from; ?></b>
                    </h5>
                    <h5> Employer Amount:
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo 100*$employer_percent."% Of ".$from; ?></b>
                    </h5>
                    <h5> Deduction From:  &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $from; ?></b> 
                    </h5>
                    
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
                            <input hidden name ="fundID" value="<?php echo $fundID; ?>">
                            <textarea required="" name ="name"><?php echo $name; ?></textarea>
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      
                      <form autocomplete="off"  id="percentAbbrv" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="fundID" value="<?php echo $fundID; ?>">
                            <input required="" type="textr" name="abbrv"  value="<?php echo $abbrv; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Abbreviation</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <div id ="policy">
                      <form autocomplete="off"  id="percentEmployee" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="fundID" value="<?php echo $fundID; ?>">
                            <input required="" type="number" name="employee_amount" step ="0.1" min="0" max="99" value="<?php echo 100*$employee_percent; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount Employee</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      </div>
                      <form autocomplete="off"  id="percentEmployer" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="fundID" value="<?php echo $fundID; ?>">
                            <input required="" type="number" name="employer_amount" step ="0.1" min="0" max="99" value="<?php echo 100*$employer_percent; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount Employer</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      </div>
                      <form autocomplete="off" id="deductionFrom" method = "post" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Deduction From
                        </label>
                        <input hidden name ="fundID" value="<?php echo $fundID; ?>">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="containercheckbox">Basic Salary
                            <input <?php if($mode ==1){ ?> checked=""  <?php } ?>  type="radio" value="1" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                          <label class="containercheckbox">Gross Salary
                            <input <?php if($mode ==2){ ?> checked=""  <?php } ?>  type="radio" value="2" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-success">Update</button>
                        </div>
                      </div>
                      </form>
                  </div>
              </div>
              </div>
              <!--UPDATE-->
            </div> <!--end row-->
            <!--END PENSION-->
            
            <?php } if($parameter == 2 ){ 
            
            foreach($deduction as $row){
                $deductionID = $row->id;
                $id = $row->id;
                $name = $row->name;
                $percent = $row->percent;
                $amount = $row->amount;
                $mode = $row->mode;
                if($mode ==1){
                    $deductionAmount = number_format($amount,2)." (Fixed Amount)";
                } else {  $deductionAmount = 100*$percent."% (From Basic Salary)"; }
            }
            
            ?>
            
            
            <!--START DEDUCTION-->
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
                    <h5> Amount:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $deductionAmount; ?> </b>
                    </h5>
                    <?php if($deduction_type== 2){ ?>
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
                      <input type="text" hidden="hidden" name="deduction" value="<?php echo $deductionID; ?>">
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
                      <input type="text" hidden="hidden" name="deduction" value="<?php echo $deductionID?>">
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-primary">ADD</button>
                        </div>
                      </div> 
                    </form>
                    <br>
                  </div>
                </div>
              </div>
              <!-- Groups -->
              <?php } ?>
              
              <!--UPDATE-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id ="feedBackSubmission"></div>
                      <form autocomplete="off" id="updateDeductionName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="deductionID" value="<?php echo $id; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <div id ="policy">
                       <?php if($mode ==1){ ?>
                      <form autocomplete="off"  id="updateDeductionAmount" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="number" name="amount" step ="1" min="1" max="10000000" value="<?php echo $amount; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                        <?php }  if($mode ==2 || $mode ==3){ ?> 
                      <form autocomplete="off" id="updateDeductionPercent" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="number" name="percent" min="0" max="99" step ="0.1" value="<?php echo 100*$percent; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button class="btn btn-primary">% Update Percent</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <?php } ?>
                      </div>
                      <form autocomplete="off" id="updateDeductionPolicy" method = "post" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Change Policy
                        </label>
                        <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="containercheckbox">Fixed Amout
                            <input <?php if($mode ==1){ ?> checked=""  <?php } ?>  type="radio" value="1" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                          <label class="containercheckbox">Percent(From Basic Salary)
                            <input <?php if($mode ==2){ ?> checked=""  <?php } ?>  type="radio" value="2" name="policy">
                            <span class="checkmarkradio"></span>
                          </label>
                          <label class="containercheckbox">Percent(From Gross)
                            <input <?php if($mode ==3){ ?> checked=""  <?php } ?>  type="radio" value="3" name="policy">
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
                            <input type="text" hidden="hidden" name="deductionID" value="<?php echo $deductionID; ?>">
                        <table class="table  table-bordered" >
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Mark &nbsp;&nbsp;&nbsp;<a  title="Remove Selected"><button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs">REMOVE SELECTED</button></a></th>
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
                            <input type="text" hidden="hidden" name="deductionID" value="<?php echo $deductionID; ?>">
    
                        <table  id="datatable" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>S/N</th>
                              <th>Name</th>
                              <th>Mark &nbsp;&nbsp;&nbsp;<a  title="Remove Selected"><button type="submit"  name="removeSelected"  class="btn  btn-danger btn-xs">REMOVE SELECTED</button></a></th>
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
            <!--END DEDUCTION-->
            
            <?php } if($parameter == 3 ){
                
             foreach($meals as $row){
                $deductionID = $row->id;
                $name = $row->name;
                $margin = $row->minimum_gross;
                $max = $row->maximum_payment;
                $min = $row->minimum_payment;
            }
            
            ?>
            
            
            <!--START Meals-->
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
                    <h5> Margin:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $margin; ?> Tsh</b>
                    <h5>Lower Amount (Gross Below Margin ):   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $min; ?> Tsh</b>
                    <h5>Upper Amount (Gross Above Margin ):   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $max; ?> Tsh</b>
                    </h5>
                    <br>
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
                      <form autocomplete="off" id="updateMealsName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateMealsMargin" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="number" name="margin" step ="1" min="0" max="10000000" value="<?php echo $margin; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Margin</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateMealsLowerAmount" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="number" name="amount_lower" step ="1" min="0" max="10000000" value="<?php echo $min; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount(Lower)</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateMealsUpperAmount" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="deductionID" value="<?php echo $deductionID; ?>">
                            <input required="" type="number" name="amount_upper" step ="1" min="0" max="10000000" value="<?php echo $max; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-primary">Update Amount(Upper)</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                  </div>
              </div>
              </div>
              <!--UPDATE-->
            </div> <!--end row-->
            <!--END DEDUCTION-->            
            <?php  } ?>
            
            
          </div>
        </div>


        <!-- /page content -->   

@include  ("app/includes/update_deductions")

<script type="text/javascript">
    $('#removeIndividual').submit(function(e){
        if (confirm("Are You Sure You Want To Delete The selected Employee(s) From  This Deduction?") == true ) {
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/remove_individual_deduction",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackRemove').fadeOut('fast', function(){
              $('#feedBackRemove').fadeIn('fast').html(data);
            });
    
     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    } 
    }); 
</script>

<script type="text/javascript">
    $('#removeGroup').submit(function(e){
        if (confirm("Are You Sure You Want To Delete The selected Group(s) From This Deduction?") == true) {
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/remove_group_deduction",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackRemoveGroup').fadeOut('fast', function(){
              $('#feedBackRemoveGroup').fadeIn('fast').html(data);
            });
    
     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    } 
    }); 
</script>

<script type="text/javascript">
    $('#assignIndividual').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/assign_deduction_individual",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAssignment').fadeOut('fast', function(){
              $('#feedBackAssignment').fadeIn('fast').html(data);
            });
    
    
        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#assignGroup').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/assign_deduction_group",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAssignment').fadeOut('fast', function(){
              $('#feedBackAssignment').fadeIn('fast').html(data);
            });
     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>
 @endsection