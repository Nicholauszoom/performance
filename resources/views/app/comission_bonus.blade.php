@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<div class="card">
  <div class="card-body">
 <!-- page content -->
 <div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card">
        <div id="payrollFeedback"></div>
          <div class="card-header"><br>
            <h2>Employee Incentivees</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              
        <!-- PANEL-->
        <div class="card">   
          <?php if($pendingPayroll > 0){ ?>
             <p class='alert alert-warning text-center'>No Incentive Payments Can Be Scheduled until the Pending Payoll is Responded</p>
           <?php } ?>             
          <?php if($pendingPayroll==0 && session('mng_paym')){ ?>
          <div class="x_title offset-3">
            <h2> Incentives Tag</h2>
            <form autocomplete="off" id="addBonusTag" class="form-horizontal form-label-left">
              @csrf
              <div class="form-group">
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="text" required="" name ="name" placeholder="Incentive Name" class="form-control">
                    <span class="input-group-btn">
                      <button  class="btn btn-main">Add Incentive Name</button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <div id ="feedBackSubmission"></div>
          </div>
                 <form id="addToBonus"  class="form-horizontal offset-3 form-label-left input_mask" method ="POST">
                    @csrf
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Incentive Name</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <select  required name="bonus" class="select_Incentive form-control" tabindex="-1">
                        <option></option>
                        
                           <?php foreach ($bonus as $row){ ?>
                          <option  value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Employee</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <select required name="employee" class="select4_single form-control" tabindex="-1">
                        <option></option>
                           <?php foreach ($employee as $row){ ?>
                          <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>
                        </div>
                          <span class="text-danger"><?php// echo form_error("linemanager");?></span>
                      </div>

                      <div class="form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12">Payment Policy</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                           <select name="policy" class="select_type form-control" required tabindex="-1" id="policy">
                            <option></option>
                            <option value=1>Fixed Amount</option>
                            <option value=2>Percent From Basic Salary</option>
                           </select>
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Number of days</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input id="days" name="days" type="number" min="1" max="99" step="1"  class="form-control"  placeholder="Days for leave">
                          </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Percent</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input id="percentf" name="percent" type="number" min="1" max="99" step="1"  class="form-control"  placeholder="Percent (Less than 100)">
                            
                          </div>
                      </div>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Amount</label>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input name="amount" type="number" min="1" max="100000000" step="0.01"  id="amount" required="" class="form-control"  placeholder="Amount (Tsh)">
                            <span class="fa fa-money form-control-feedback right" aria-hidden="true"></span>
                          </div>
                      </div>
                      <div class="form-group">
                       <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                       <?php if($pendingPayroll==0 && session('mng_paym')){ ?>
                       <button type="reset" class="btn btn-default">Cancel</button>
                       <button  class="btn btn-main">Add To Incentive</button>
                       <?php }else { ?>                            
                       <button type="button"  class="btn btn-warning">Incentivees Not Allowed Until the Current Pending Payroll is Confirmed</button>
                       <?php } ?>
                       </div>
                      </div>
                  <div class="ln_solid"></div>            
                </form>
                <?php } ?>
          <div class="x_title">
            <h2>List Of Employees Entitled For Incentive This Month</h2>
            <div class="clearfix"></div>
            <div id ="feedBack"></div>
          </div>
          <div class="card">
          <div id="employeeList" class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>S/N</th>
                  <th>Employee Name</th>
                  <th>Department</th>
                  <th>Incentive Name</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($incentives as $row) { ?>
                  <tr id="record<?php echo $row->id;?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td>Department:<?php echo $row->department; ?><br>
                    Position:<?php echo $row->position; ?></td>
                    <td><?php echo $row->tag; ?></td>
                    <td><?php echo $row->amount; ?></td>
                    <td id="status<?php echo $row->id;?>">
                        <?php if($row->state==1){ ?>
                        <span class="label label-success">APPROVED</span><br>
                        <?php  } else { ?>
                        <span class="label label-warning">NOT APPROVED</span><br>
                        <?php  } ?>
                      <?php if($row->state==0 && session('mng_paym')){ ?>
                        <a href="javascript:void(0)" onclick="deleteBonus(<?php echo $row->id; ?>)"  title="Delete Incentive" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button> </a>
                        <?php }  ?>  
                    </td>
                 </tr>
                  <?php }  ?>
              </tbody>
            </table>
          </div>
        </div>
        </div>
          </div>
        </div>
      </div>              
      <!--Employee Incentive List for this Montyh-->
    </div>
  </div>
</div>
    

  </div>


</div>


       
        <!-- /page content -->   

@include ('app/includes/update_allowances')


<script>

jQuery(document).ready(function($){
  
    $('#policy').change(function () {
    $("#policy option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $("#percentf").attr("disabled", "disabled");
            $("#days").attr("disabled", "disabled");
            

          } else if(value == "2") {
            $("#days").attr("disabled", "disabled");
            $("#percentf").removeAttr("disabled");
        }
        else if(value == "3") {
            $("#percentf").attr("disabled", "disabled");
            $("#days").removeAttr("disabled");
        }
    });
  }); 
});

</script>



 @endsection