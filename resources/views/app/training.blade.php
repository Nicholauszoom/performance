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
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>My Application </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
            <!-- My Trainings -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div id ="resultFeedback"></div>
                  <div class="x_title">
                      <h2>My Trainings 
                      <a  href="#bottom" ><button type="button"  class="btn btn-primary">REQUEST TRAINING</button></a></h2>
                        <div class="clearfix"></div>
                      </div>
                    <div class="clearfix"></div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Course</th>
                          <th>Need</th>
                          <th>Estimated Cost</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>          
            
                      <tbody>
                        <?php
                          foreach ($my_applications as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->course_name; ?></td>
                            <td><?php if($row->mandatory == 1){ ?>
                            
                            <div class="col-md-12">
                                <span class="label label-warning">CORE</span></div><?php }
                            else{ ?>
                            <div class="col-md-12">
                                <span class="label label-info">OPTION</span></div><?php } ?></td>
                            <td><?php echo number_format($row->amount, 2);  ?></td>
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
                            <td class="options-width">
                            <?php if($row->status==0 || $row->status==1|| $row->status==4){ ?>
                              <a href="javascript:void(0)" onclick="deleteRequest(<?php echo $row->id ?>)" title="Cancel Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>
                              <?php } ?>
                            </td>
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- End My Trainings -->


              <?php if(session('appr_training')!=0 || session('conf_training')!=0){ ?>
              <!-- Training Budget  -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div id ="resultFeedback"></div>
                  <div class="x_title">
                      <h2>Training Budget
                    <?php  if(session('appr_training')!=0){ // if($isBudgetPresent==0){ ?>
                    <a><button type="button" id="modal" data-toggle="modal" data-target="#budgetModal" class="btn btn-primary">Add Budget for This Year</button></a> <?php //} else { ?>
                    <button type="button" disabled  class="btn btn-default">Budget Already Present</button><?php } ?></h2>
                        <div class="clearfix"></div>
                      </div>
                    <div class="clearfix"></div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable-keytable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th> Budget Name</th>
                          <th>Duration</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th>Date</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($budget as $row) { ?>
                          <tr id="record<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td>
                            From <b><font class="green"><?php echo date('F-Y', strtotime($row->start)); ?></font></b> <br>
                            To <b><font class="green"><?php echo date('F-Y', strtotime($row->end)); ?></font></b></td>
                            <td><?php echo number_format($row->amount, 2); ?></td>
                            <td>
                              <div id ="status<?php echo $row->id; ?>">
                              <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php } 
                              elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-success">ACCEPTED</span></div><?php }
                              elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-danger">REJECTED</span></div><?php } ?>
                            </div>
                            </td>
                            <td><?php $datesValue = date('d-m-Y', strtotime($row->date_recommended));
                                  echo $datesValue; ?></td>

                            <td class="options-width">

                              <a href="<?php echo url(); ?>flex/budget_info/?id=".base64_encode($row->id); ?>" title="Employee Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                             <?php if($row->status==0 || $row->status==2){ 

                                if(session('appr_training')!=0){ ?> 

                            <a href="javascript:void(0)" onclick="deleteBudget(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button> </a>
                            <?php } }
                            if($row->status==0 || $row->status==1){

                              if(session('conf_training')!=0){ ?>
                            <a href="javascript:void(0)" onclick="rejectBudget(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>


                            <a href="javascript:void(0)" onclick="disapproveBudget(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>
                            <?php } }
                            if($row->status==0 || $row->status==2){  

                             if(session('conf_training')!=0){ ?>
                    
                            <a href="javascript:void(0)" onclick="approveBudget(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                            <?php } } ?>

                            
                            </td>
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Training Budget -->
              <?php } ?>
              
              <!--TABS SECTION-->
              <?php if(session('appr_training')!=0 || session('conf_training')!=0 || session('line')!=0){ ?>
                     
                  <!--Start Tabs Content-->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                          <h3 class="green">Training Applications</h3>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div id="feedbackRequest"></div>
    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#recommended" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"><b>RECOMMENDED APPLICATIONS</b></a>
                            </li>
                            <li role="presentation" class=""><a href="#skillgap" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>SKILL GAP </b></a>
                            </li>
                            <?php if( session('conf_training')!=0){  ?>
                            <li role="presentation" class=""><a href="#confirmed" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>CONFIRMED APPLICATIONS </b></a>
                            </li>
                            <?php } ?>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                              
                        <div role="tabpanel" class="tab-pane fade active in" id="recommended" aria-labelledby="home-tab">
                          
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Training Application</h2>        
            
                                 <!-- <ul class="nav navbar-right panel_toolbox">
                                      Total Training Cost
                                <button type="button" id="sumapp" class="btn btn-info"><div class="sum_amount_application">0</div></button>
                                </ul> -->
            
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                               @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                               <form action="<?php echo url(); ?>flex/approve_training/" method="post">
                               @if(Session::has('note'))      {{ session('note_approved') }}  @endif
                                <table id="datatable" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Trainee Name</th>
                                      <th>Course</th>
                                      <th>Estimated Cost</th>
                                      <th>Status</th>
                                      <th>Option</th>
                                    </tr>
                                  </thead>          
                        
                                  <tbody>
                                    <?php
                                      foreach ($other_applications as $row) { ?>
                                      <tr id="domain<?php echo $row->id;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->trainee; ?></td>
                                        <td><?php echo $row->course_name; ?></td>
                                        <td><?php echo number_format($row->amount, 2);  ?></td>
                                        <td>
                                        <?php if($row->mandatory == 1){ ?>
                                        
                                        <div class="col-md-12">
                                            <span class="label label-warning">CORE</span></div><?php }
                                        else{ ?>
                                        <div class="col-md-12">
                                            <span class="label label-info">OPTION</span></div><?php } ?>

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
                                        <td class="options-width">

                                          <?php if(session('line')!=0){ 
                                            if($row->status==0 ||$row->status==4){ ?>
                                         <a href="javascript:void(0)" onclick="recommendRequest(<?php echo $row->id; ?>)" title="Recommend Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs">RECOMMEND</button> </a>
                                         <?php }  if($row->status==0 ||$row->status==1){ ?>

                                          <a href="javascript:void(0)" onclick="suspendRequest(<?php echo $row->id; ?>)" title="Suspend Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-warning btn-xs">HOLD</button> </a>
                                          <?php } }
                                          if(session('appr_training')!=0){ 
                                            if($row->status==1 ||$row->status==5){ ?>
                                          <a href="javascript:void(0)" onclick="approveRequest(<?php echo $row->id; ?>)" title="Approve Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-primary btn-xs">APPROVE</button> </a>

                                          <?php }  if($row->status==1 ||$row->status==2){ ?>
                                          
                                          <a href="javascript:void(0)" onclick="disapproveRequest(<?php echo $row->id; ?>)" title="Cancel Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs">DISAPPROVE</button> </a>
                                          <?php } }
                                          if(session('conf_training')!=0){ 
                                            if($row->status==2 ||$row->status==6){ ?>
                                          
                                          <a href="javascript:void(0)" onclick="confirmRequest(<?php echo $row->id; ?>)" title="Cancel Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs">CONFIRM</button> </a>
                                          <?php }  if($row->status==2 ||$row->status==3){ ?>
                                          
                                          <a href="javascript:void(0)" onclick="unconfirmRequest(<?php echo $row->id; ?>)" title="Cancel Request" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs">UNCONFIRM</button> </a>
                                          <?php }  }?>
                                        </td>
                                        <!-- <td class="options-width">

                                          <label class="containercheckbox">
                                            <input type="checkbox" name="option[]" value="<?php echo $row->empID."|".$row->skillsID."|".$row->amount."|".$row->id; ?>" class="application_amount" id="application_amount<?php echo $row->skillsID; ?>" data-valueappl="<?php echo $row->amount; ?>">
                                            <span class="checkmark"></span>
                                          </label>
                                          </td> -->
                                        </tr>
                                      <?php } ?>
                                  </tbody>
                                </table>                             
                                   
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                                    
                <!--Skill Gap Trainees Tab-->
                        <div role="tabpanel" class="tab-pane fade" id="skillgap" aria-labelledby="profile-tab">
                            
                          <div class="col-md-12 col-sm-12 col-xs-12">  
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Skills Gap Analysis  </h2>                               
            
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Name</th>
                                      <th>Position</th>
                                      <th>Course</th>
                                      <th>Need</th>
                                      <th>Estimated Cost</th>
                                    </tr>
                                  </thead>
            
            
                                  <tbody>
                                    <?php
                                      foreach ($skill_gap as $row) { ?>
                                      <tr id="domain<?php echo $row->courseID;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><a title="More Details"  href="<?php echo url(); ?>flex/userprofile/?id=".$row->emp_id; ?>"><?php echo $row->trainee; ?></a></td>
                                        <td><?php echo "<b>Department: </b>".$row->department."<br><b>Position: </b>".$row->position; ?></td>
                                        <td><?php echo $row->course_name; ?></td>
                                        <td>
                                        <?php if($row->mandatory == 1){ ?>         
                                        <div class="col-md-12">
                                            <span class="label label-warning">CORE</span></div>
                                        <?php } else{ ?>
                                        <div class="col-md-12">
                                            <span class="label label-info">OPTION</span></div>
                                        <?php } ?>
                                        </td>
                                        <td><?php echo number_format($row->amount, 2);  ?></td>
                                        </tr>
                                      <?php }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                            <!--Skill-Gap Trainees Tab END-->

                        <?php if( session('conf_training')!=0){  ?>            
                        <!--Confirmed Trainees Tab-->
                        <div role="tabpanel" class="tab-pane fade" id="confirmed" aria-labelledby="profile-tab">
                            
                          <div class="col-md-12 col-sm-12 col-xs-12">  
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Training Application and Enquires </h2>

                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                <table id="datatable" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Name</th>
                                      <th>Position</th>
                                      <th>Course</th>
                                      <th><b>Status</b></th>
                                      <th>Training Cost</th>
                                      <th>Option</th>
                                    </tr>
                                  </thead>
            
            
                                  <tbody>
                                    <?php
                                      foreach ($trainees_accepted as $row) { ?>
                                      <tr id="domain<?php echo $row->id;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><a title="More Details"  href="<?php echo url(); ?>flex/userprofile/?id=".$row->empID; ?>"><?php echo $row->trainee; ?></a></td>
                                        <td><?php echo "<b>Department: </b>".$row->department."<br><b>Position: </b>".$row->position; ?></td>
                                        <td><?php echo $row->course_name; ?></td>
                                        <td><?php if($row->status == 0){ ?>
                                        
                                        <div class="col-md-12">
                                            <span class="label label-warning">ON TRAINING</span></div>
                                        <?php } else{ ?>
                                        <div class="col-md-12">
                                            <span class="label label-info">GRADUATED</span></div><?php } ?></td>
                                        <td><?php echo number_format($row->cost, 2);  ?></td>
                                        <td class="options-width">
                                        <?php if($row->status == 0){ ?>
                                            <a href = "<?php echo url(); ?>flex/confirm_graduation/?key=".$row->empID."|".$row->skillsID."|".$row->id; ?>"><button type="button" class="btn btn-info btn-xs">CONFIRM<br>GRADUATION</button></a>
                                        <?php } else{ ?>
                                         <a download= '' href ='<?php echo base_url("uploads/graduation/".$row->certificate); ?>'>
                                         <div class='col-md-12'>
                                            <span class='label label-info'>DOWNLOAD</span></div></a>
                                          <?php } ?>
            
                                       </td>
                                        </tr>
                                      <?php }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                            <!--Confirmed Trainees Tab END--> 
                        <?php }  ?>                                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End TABS SECTION-->
              <?php } ?>
              
                <div id="myForm" class="col-md-12 col-sm-12 col-xs-12">
                    <div id="bottom" class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-flag"></i> Request For Training</h2>
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
                      <div class="x_content">            
                      <div id="resultFeedDes"></div>
                        <form autocomplete="off" method="post" id ="applyTraining"  data-parsley-validate class="form-horizontal form-label-left" >   
                          
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Course Name</label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                    <select required="" name="course" class="select_course form-control">
                                    <option></option>
                                       <?php foreach ($course as $row){ ?>
                                      <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                    </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                               <button type="reset" class="btn btn-default" >CANCEL</button>
                               <button class="btn btn-primary" >SEND REQUEST</button>
                              
                            </div>
                          </div> 
                          </form>
            
                      </div>
                    </div>
                </div>
            <!--END EDIT TAB-->      
        
            </div>
          </div>
        </div>

        <!-- Modal -->
                <div class="modal fade" id="budgetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add New Badget</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/addBudget"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" required="" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start Date
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" required="" placeholder="Start Date" name="start" class="form-control col-xs-12 has-feedback-left" id="startDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End Date
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" required="" placeholder="End Date" name="end" class="form-control col-xs-12 has-feedback-left" id="endDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" required="" name="amount" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("fname");?></span>
                        </div>
                      </div> 
                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit"  value="Add" name="request" class="btn btn-primary"/>
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


        <!-- /page content -->

@include( "app/includes/training_operations



<script type="text/javascript">
var $cs_app = $('.application_amount').change(function () {
    var v_app = 0;
    $cs_app.filter(':checked').each(function () {
        v_app += $(this).data('valueappl');
    })
    $('.sum_amount_application').html(v_app.toLocaleString());
});
$('.application_amount:checked').change();



var $cs = $('.chargesg').change(function () {
    var v = 0;
    $cs.filter(':checked').each(function () {
        v += $(this).data('cashsg');
    })
    $('.totalsg').html(v.toLocaleString());
});
$('.chargesg:checked').change();


var $cs_confirmed = $('.charge_confirmed').change(function () {
    var v_confirmed = 0;
    $cs_confirmed.filter(':checked').each(function () {
        v_confirmed += $(this).data('cash');
    })
    $('.total_confirmed').html(v_confirmed.toLocaleString());
});
$('.charge_confirmed:checked').change();
</script>


 @endsection