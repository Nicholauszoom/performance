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
                <h3>Salary Advances and Loans</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
                <!--MY APPLICATIONS -->
                
              
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Salary Advance Applications &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="apply"  class="btn btn-primary">Apply Salary Advance</button>
                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id="resultfeed"></div>
                      <div id="resultfeedCancel"></div>
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Application Date</th>
                          <th>Status</th>
                          <th>Option</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($myloan as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->TYPE; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td><?php $datewell = explode("-",$row->application_date);
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy;
                                  echo $clear_date;  ?>
                            </td>
                            <td>
                                <div id ="status<?php echo $row->id; ?>" >
                                    <?php if ($row->status==0){ ?>
                                    <div class="col-md-12">
                                    <span class="label label-default">SENT</span></div><?php } 
                                    elseif($row->status==1){?>
                                    <div class="col-md-12">
                                    <span class="label label-info">RECOMMENDED</span></div><?php }
                                    elseif($row->status==2){  ?>
                                    <div class="col-md-12">
                                    <span class="label label-success">APPROVED</span></div><?php }
                                    elseif($row->status==3){?>
                                    <div class="col-md-12">
                                    <span class="label label-warning">HELD</span></div><?php }
                                    elseif($row->status==5){?>
                                    <div class="col-md-12">
                                    <span class="label label-danger">DISAPPROVED</span></div><?php }  ?>
                                </div>
                               </td>

                            <td> 
                            
                            <?php   if($row->status==0 || $row->status==3){ ?>
                                
                                <a href="javascript:void(0)" onclick="cancelLoan(<?php echo $row->id;?>)">
                                <button  class="btn btn-warning btn-xs">CANCEL</button></a>  <?php }  ?>
                                
                                <a href="<?php echo url(); ?>flex/updateloan/?id=".$row->id; ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                            
                            </td>

                            <td>
                                <?php echo "<b>HR: </b>".$row->reason_hr."<br><b>Finance: </b>".$row->reason_finance; ?>
                              
                            </td>
                            </tr>
                          <?php }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              
              <!--END MY APPLICATION-->               
                
              <?php if(session('recom_paym') || session('appr_paym')){ ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Others` Salary Advance Applications(Need To Respond)
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                 
                    <a href="#bottom2"><button type="button" id="insertDirect"  class="btn btn-success">Insert Direct Loan</button></a>  </h2>
              
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div id="resultfeed"></div>
                      <div id="resultfeedCancel"></div>
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Position</th> 
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Application Date</th>
                          <th>Status</th>
                          <th>Option</th> 
                          <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($otherloan as $row) { ?>
                          <?php if($row->status == 2){ continue; } ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->NAME; ?></td>
                            <td><?php echo $row->DEPARTMENT; ?><br>
                            <?php echo $row->POSITION; ?>
                            </td>
                            <td><?php echo $row->TYPE; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td><?php $datewell = explode("-",$row->application_date);
                                  $mm = $datewell[1];
                                  $dd = $datewell[2];
                                  $yyyy = $datewell[0];  
                                  $clear_date = $dd."-".$mm."-".$yyyy;
                                  echo $clear_date;  ?>
                            </td>
                            <td>
                              <div id ="status<?php echo $row->id; ?>" >
                                    <?php if ($row->status==0){ ?>
                                    <div class="col-md-12">
                                    <span class="label label-default">SENT</span></div><?php } 
                                    elseif($row->status==6){?>
                                    <div class="col-md-12">
                                    <span class="label label-info">RECOMMENDED BY HR</span></div><?php }
                                    elseif($row->status==2){  ?>
                                    <div class="col-md-12">
                                    <span class="label label-success">APPROVED</span></div><?php }
                                    elseif($row->status==1){?>
                                    <div class="col-md-12">
                                    <span class="label label-info">RECOMMENDED BY FINANCE</span></div><?php }
                                    elseif($row->status==5){ ?><?php }  ?>
                                </div>
                            </td>
                             
                            <!--Line Manager and HR -->
                            <td>
                                
                                <a href="<?php echo url(); ?>flex/updateloan/?id=".$row->id; ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                            
                            
                            <?php if(session('mng_emp') && $row->status==0){ ?>
                            <a href="javascript:void(0)" onclick="hrrecommendLoan(<?php echo $row->id;?>)" title="Recommend">
                            <button  class="btn btn-primary"><i class="fa fa-check-circle"></i></button></a>

                            <?php }else if($row->status==6 && session('recom_paym')) {  ?>
                           <a href="javascript:void(0)" onclick="recommendLoan(<?php echo $row->id;?>)" title="Recommend">
                           <button  class="btn btn-primary"><i class="fa fa-check-circle"></i></button></a>

                            <?php  }  ?>
                            
                            <?php if(session('appr_paym') && $row->status==1 && $pendingPayroll==0){ ?>
                      
                            <a href="javascript:void(0)" onclick="approveLoan(<?php echo $row->id;?>)">
                            <button  class="btn btn-success"><i class="fa fa-check-circle"></i></button></a>
                            <?php }  ?>
                            </td>

                            <td>
                                <?php echo "<b>HR: </b>".$row->reason_hr."<br><b>Finance: </b>".$row->reason_finance; ?>
                              <a href="<?php echo url(); ?>flex/loan_application_info/?id=".$row->id; ?>">
                              <br>
                              <button type="submit" name="go" class="btn btn-info btn-xs">Add Remark</button></a> <?php //} ?>
                            </td>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
             <?php }?>
              <!--END SALARY ADVANCES TO BE PROVED/RECOMMENDED-->
              
              
              <!--APPLY SALARY ADVANCE-->
               <div id="applyForm" class="col-md-12 col-sm-12 col-xs-12">
                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Apply Salary Advance</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id ="resultfeedSubmission"></div>
                        <form id="applyLoan" autocomplete=""  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <!-- START -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="advance_type" class="select2_type form-control" required tabindex="-1" id="advance_type">
                            <option value="">Select Type</option>
                            <option value=1>Middle of The Month Advance</option>
                           <option value=2>Normal Salary Advance</option>
                        </select>
                        </div>
                      </div>
                      <!-- <div  class="form-group"  id="amount_mid">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Amount
                        </label>
                        <span class="badge bg-orange">Not More Than <?php echo number_format($max_amount,0);?></span>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required type="number" min="1" max="<?php echo $max_amount; ?>" name="amount_mid" id="amount_midf" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> -->
                      <div class="form-group" id="amount">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="required" type="number" min="1" max="10000001" name="amount" id="amountf" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div  class="form-group" id="monthly_deduction">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deduction Per Month
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="required" type="number" min="1" max="10000001"  name="deduction" id="monthly_deductionf" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reason For Application
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason" required rows="3"></textarea> 
                          <span class="text-danger"><?php echo form_error("lname");?></span>
                        </div>
                      </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button  class="btn btn-primary" >APPLY</button>
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>
                
                <!--END APPLY SALARY ADVANCE-->
                
                
                
                <!--INSERT DIRECT LOAN-->
                <?php if(session('mng_emp')){ ?>
               <div id="insertDirectForm"  class="col-md-12 col-sm-12 col-xs-12">
                            
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Insert Direct Deduction (HESLB, Custom Deductions, etc..)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div id ="resultfeedSubmissionDirect"></div>
                        <form id="directLoan" autocomplete="off"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                          <!-- START -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Type</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="type" class="select_type form-control" required tabindex="-1" id="type">
                            <option value="">Select Loan</option>
                           <option value=1>Other Company Debt</option>
                            <option value=2>HESLB</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Employee</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                        <select name="employee" class="select4_single form-control" required tabindex="-1">
                        <option></option>
                           <?php
                          foreach ($employee as $row) {
                             # code... ?>
                          <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div> 
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Amount
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required="required" type="number" min="1" max="100000001" step="0.01" name="amount" placeholder="Amount" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group"  id="index_no">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Form Four Index No.
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="index_nof" required min="1" max="100000001" placeholder="Form Four Index Number" name="index_no" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div  class="form-group"  id="deduction">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deduction Per Month
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input required type="number" id="deductionf" min="1" max="100000001" name="deduction" placeholder="Deduction Per Month" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Other Remarks
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason(Optional)" rows="3"></textarea> 
                          <span class="text-danger"><?php echo form_error("lname");?></span>
                        </div>
                      </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button  class="btn btn-primary" >INSERT</button>
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



        <!-- /page content -->

@include   ("app/includes/loan_operations")


<script>

jQuery(document).ready(function($){
  
    $('#advance_type').change(function () {
        
    $("#advance_type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#amount_mid').show();
            $("#amount_midf").removeAttr("disabled");
            $('#monthly_deduction').hide();
            $("#monthly_deductionf").attr("disabled", "disabled");
           
        } else if(value == "2") {
            $('#amount').show();
            $('#monthly_deduction').show();
            $("#amountf").removeAttr("disabled");
            $("#monthly_deductionf").removeAttr("disabled");
            $('#amount_mid').hide();
            $("#amount_midf").attr("disabled", "disabled");
           
        }

    });
  }); 

  
    $('#type').change(function () {
        
    $("#type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#deduction').show();
            $('#index_no').hide();
            $("#index_nof").attr("disabled", "disabled");
            $("#deductionf").removeAttr("disabled");
           
        } else if(value == "2") {
            $('#index_no').show();
            $('#deduction').hide();
            $("#deductionf").attr("disabled", "disabled");
            $("#index_nof").removeAttr("disabled");
           
        }

    });
  }); 


});
</script>
 @endsection