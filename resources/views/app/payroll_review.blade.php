<?php 
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  foreach($overall_review as $row) {
    $empName = $row->empName;
    $salary = $row->salary;
    $wcf = $row->wcf;
    $sdl = $row->sdl;
    $pension_employee = $row->pension_employee;
    $pension_employer = $row->pension_employer;
    $pensionFund = $row->pensionFundName;
    $pensionAbbrv = $row->abbrv;
    $meals = $row->meals;
    $pf_amount_employee = $row->amount_employee;
    $pf_amount_employer = $row->amount_employer;
    if($row->deduction_from == 1) $pf_policy = "Basic Salary"; else $pf_policy = "Gross Salary";
  }

  foreach ($total_loans as $row) {    
    $total_last_paid = $row->total_last_paid;
    $total_paid_currently = $row->total_paid_currently;
    $total_loans = $row->total_loans;
    $total_remained = $row->total_remained;
  }
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h2>Payroll Review For: <b> <?php echo $empName; ?></b></h2>
              </div>
              

            </div>

            <div class="clearfix"></div>

            <div class="row">

              <!-- Roles and Permission Groups -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>EARNINGS AND ALLOWANCES</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Amount</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($allowances_review as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo $row->amount; ?></td>                
                            
                            </tr>
                          <?php } ?>
                          <tr>
                            <td width="1px">#</td>
                            <td>Salary</td>
                            <td><?php echo $salary; ?></td>
                          </tr>
                          <tr align="center">
                            <td colspan="2" bgcolor="#FF8C00"><font color="white"><b>TOTAL</b></font></td>
                            <td><?php echo number_format(($salary+$total_allowances),2); ?></td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- allowances -->

              <!-- deductions -->
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>DEDUCTIONS</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Deduction Policy</th>
                          <th>Amount</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($deductions_review as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo $row->policy; ?></td>
                            <td><?php echo $row->paid; ?></td>                
                            
                            </tr>
                          <?php } ?>
                          <tr>
                            <td width="1px">#</td>
                            <td>Pension Fund (<?php echo $pensionAbbrv; ?>)</td>
                            <td><?php echo number_format(100*$pf_amount_employee,2); ?>%(<?php echo $pf_policy; ?>)</td>
                            <td><?php echo number_format($pension_employee,2); ?></td>
                          </tr>
                          <tr>
                            <td width="1px">#</td>
                            <td>Meals </td>
                            <td><?php echo number_format($meals,2); ?></td>
                            <td><?php echo $meals; ?></td>
                          </tr>
                          <tr>
                            <td width="1px">#</td>
                            <td>SDL</td>
                            <td><?php echo number_format(100*($sdl_contribution),2); ?>% (Gross)</td>
                            <td><?php echo $sdl; ?></td>
                          </tr>
                          <tr>
                            <td width="1px">#</td>
                            <td>WCF</td>
                            <td><?php echo number_format(100*($wcf_contribution),2); ?>% (Gross)</td>
                            <td><?php echo $wcf; ?></td>
                          </tr>
                           <tr align="center">
                            <td colspan="3" bgcolor="#FF8C00"><font color="white"><b>TOTAL</b></font></td>
                            <td><?php echo number_format(($total_deductions+$wcf+$sdl+$meals+$pension_employee),2); ?></td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- deductionss -->
              
              <!-- loans-->             
              
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LOANS</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Deduction Policy</th>
                          <th>Paid Currently</th>
                          <th>Last Paid</th>
                          <th>Outstanding</th>
                          <th>Amount Loan</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($loans_review as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php if($row->policy<1) echo $row->policy."%"; else echo number_format($row->policy, 2); ?>
                              
                            </td>
                            <td><?php echo number_format($row->pre_paid,2); ?></td> 
                            <td><?php echo number_format($row->amount_last_paid,2); ?></td> 
                            <td><?php echo number_format($row->remained,2); ?></td>  
                            <td><?php echo number_format($row->amount,2); ?></td>                
                            
                            </tr>
                          <?php } ?>
                           <tr align="center">
                            <td colspan="3" bgcolor="#FF8C00"><font color="white"><b>TOTAL</b></font></td>  
                            <td><?php echo number_format($total_paid_currently,2); ?></td>   
                            <td><?php echo number_format($total_last_paid,2); ?></td> 
                            <td><?php echo number_format($total_remained,2); ?></td>   
                            <td><?php echo number_format($total_loans,2); ?></td>   
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
              <!--Roles-->
            </div>

        <!-- Modal -->
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Role</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role Name 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php //echo form_error("fname");?></span>
                          </div>
                      </div> 

                                           
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addrole" class="btn btn-primary"/>
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

        <!-- Finencial Group Modal -->
        <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Finencial Based-Group of Employees</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Group Name 
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php //echo form_error("fname");?></span>
                          </div>
                      </div>
                      
                            <input type="text" hidden name="type"value = "1">

                                           
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-primary"/>
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
         
         
        <!--Roles Group Modal-->
        <div class="modal fade" id="rolesgroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Role Based Group of Employees</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Group Name 
                          </label>
                          
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php //echo form_error("fname");?></span>
                          </div>
                      </div> 
                      
                            <input type="text" hidden name="type"  value ="2">
                                           
                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-primary"/>
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
         
        <!--Roles Group Modal-->

          </div>
        </div>


        <!-- /page content -->   


 @endsection