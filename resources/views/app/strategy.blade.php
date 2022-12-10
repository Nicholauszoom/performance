

@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php 
  
  $CI_Model = get_instance();
  $CI_Model->load->model('performance_model');
  $adhoc = 0;
  $strategyID = session('current_strategy');
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Strategies</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
             
              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-6 col-xs-12">

                   <!-- PANEL-->
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Strategy Report</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">               

                    <form  enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/performance/strategy_report"  data-parsley-validate class="form-horizontal form-label-left" target="_blank">
                    <input type="text"  hidden="" value="<?php echo $strategyID;?>" name="strategyID" />
                    <div class="col-lg-12">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label > Status</label> 
                              <select name="status" required="" class="select4_single form-control" tabindex="-1">
                                <option value="1"> ALL </option>
                                <option value="2"> PROGRESS </option>
                                <option value="3"> COMPLETED </option>
                                <option value="4"> OVERDUE </option>
                                <option value="5"> NOT STARTED </option>
                              </select> 
                        </div> 
                      </div>
                      <div class="col-lg-4">     
                        <div class="form-group">
                          <label  >Target</label>
                              <select name="target" required="" class="select4_single form-control" tabindex="-1">
                                <option value="1"> ALL TARGET </option>
                                <option value="2"> FINANCIAL TARGET </option>
                                <option value="3"> QUANTITY TARGET </option>                         
                              </select>                            
                        </div> 
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="col-md-4 col-sm-6 col-xs-12 col-md-offset-3"><br>
                            <button type="submit" name="print" class="btn btn-info">PRINT REPORT</button>
                          </div>
                        </div> 
                      </div>
                    </div> 
                    </div>
                  </form>

                  </div>
                </div>
                <!--PANEL-->
                <div class="x_panel">
                  <div class="x_title">
                      <div id ="resultFeedback"></div>
                    <!--<h2><i class="fa fa-bars"></i> Tabs <small>Float left</small></h2>-->
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


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">STRATEGIES</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">OUTCOME</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_output" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">OUTPUT</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_task" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">TASKS</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">


                                  <div class="x_title">
                                    <h2>Strategy &nbsp;&nbsp;&nbsp;<a><button type="button" id="modal" data-toggle="modal" data-target="#strategyModal" class="btn btn-primary">Add New Strategy or Project </button></a></h2>
                                              
                
                                    <div class="clearfix"></div>
                                  </div>
                                  <div class="x_content">
                
                
                                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                  
                                    <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th>S/N</th>
                                          <th>Name </th>
                                          <th>Type</th>
                                          <th>Description</th>
                                          <th>Funder</th>
                                          <th>Duration</th>
                                          <th>Progress</th>
                                          <th>Option</th>
                                        </tr>
                                      </thead>
                
                
                                      <tbody>
                                        <?php
                                        //if ($employee->num_rows() > 0){
                                          foreach ($strategy as $row) { ?>
                                          <tr  id="record<?php echo $row->id;?>"  >
                                            <td width="1px"><?php echo $row->SNo; ?></td>
                                            <?php if($row->id==$strategyID){ ?>
                                            <td  bgcolor="#348e5e" > <font color="white"><?php echo $row->id.": ".$row->title; ?></font></td>
                                            <?php } else { ?>

                                            <td > <?php echo $row->id.": ".$row->title; ?></td>
                                            <?php } ?>
                                            <td><?php if($row->type==1){ ?> <button type="button" class="btn btn-success btn-xs">STRATEGY</button>
                                            <?php } else { ?>
                                            <button type="button" class="btn btn-info btn-xs">PROJECT</button><?php } ?></td>
                                            <td><?php echo $row->description; ?><br>
                                            <td><?php echo strtoupper($row->funder); ?><br>
                                            </td>
                                            
                                            <td><?php 
                                                $startd=date_create($row->start);
                                                $endd=date_create($row->end);
                                                $diff=date_diff($startd, $endd);
                                                $DURATION = $diff->format("%a"); ?>
                                                <p><b><font class="green"><?php  echo $DURATION+1; ?>   Day(s)</font></b><br>
                                                From <b><font class="green"><?php echo date('d-m-Y', strtotime($row->start)); ?></font></b> <br>
                                                To <b><font class="green"><?php echo date('d-m-Y', strtotime($row->end)); ?></font></b></p>
                                                
                                            </td>
                                            <td>
                                                <ul class="list-inline prod_color">
                                                  <li>
                                                      <?php 
                                                      $totalTaskProgress = $row->sumProgress;
                                                      $taskCount = $row->countOutcome;
                                                      if($taskCount==0) $progress = 0; else $progress = number_format(($totalTaskProgress/$taskCount),1);
                                                      
                                                      $todayDate=date('Y-m-d');
                                                      $endd=$row->end;
                                                        
                                                      
                                                      if($todayDate>$endd) {
                                                
                                                if($progress==100){ ?>
                                                    <p><b>Completed</b></p>
                                                        <div class="color bg-green"></div> 
                                                        <?php } elseif($progress<100) { ?>
                                                        <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                        <div class="color bg-red"></div> <?php } 
                                                } else { 
                                                    if($progress==0){ ?>
                                                    <p><b>Not Started</b></p>
                                                        <div class="color bg-orange"></div>
                                                        <?php } elseif($progress>0 && $progress<100) { ?>
                                                    <p><b>
                                                        In Progress (<?php echo $progress; ?>%) </b></p>
                                                        <div class="color bg-blue-sky"></div>
                                                    <?php } elseif($progress==100){ ?>
                                                        <p><b>Completed</b></p>
                                                        <div class="color bg-green"></div>
                                                    <?php } elseif($progress>75){ ?>
                                                    <p><b>About to Complete(<?php echo $progress; ?>%)</b></p>
                                                        <div class="color bg-purple"></div>
                                                        <?php }  }  ?> 
                                                    </li>
                                                </ul>
                                            </td>
                                            <td class="options-width">
                                            <a href="<?php echo  url('')."flex/performance/strategy_info/?id=".base64_encode($row->id); ?>"   title="Strategy Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                            
                                            <?php if($strategyID == $row->id) { ?>
                                            <a title="Current Selected Strategy Can Not Be Deleted, Change Selection and Try to Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>  NOT ALLOWED</button> </a>
                                            <?php } else { ?>
                                            <a href="javascript:void(0)" onclick="deleteStrategy(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                            <?php } ?>

                                             <a href="javascript:void(0)" onclick="selectStrategy(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs">MAKE DEFAULT</button> </a>


                                           </td>

                                          </tr>
                                          <?php }  ?>
                                      </tbody>
                                    </table>
                                    
                                    
                                  </div>
                                </div>
                            </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Outcome
                                <a href ="<?php echo  url(''); ?>/flex/performance/outcome_report" target = "blank"><button type="button" name="print" value ="print" class="btn btn-info">EXPORT</button></a>
                                </h2>
            
                                <div class="clearfix"></div>
                              </div>
                              <div id = "loadTable-outcome" class="x_content">
                                 @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                <table  id="datatable" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th><b>S/N</b></th>
                                      <th><b>Outcome Name</b></th>
                                      <th><b>Accountable Executive</b></th>
                                      <th><b>Duration</b></th>
                                      <th><b>RAG Status</b></th>
                                      <th><b>Option</b></th>
                                    </tr>
                                  </thead>
            
            
                                  <tbody>
                                  <?php
                                  foreach ($activeOutcomes as $rowOutcome) { ?>
                                      <tr id="record<?php echo $rowOutcome->id;?>">
                                          <td><?php echo $rowOutcome->SNo; ?></td>
                                          <td><p><b><?php echo $row->id.".".$rowOutcome->id.".".$rowOutcome->title; ?></b></p></p>
                                              <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-outcome-modal-lg<?php echo $rowOutcome->id; ?>">View More...</button>
              
                                              <div class="modal fade bs-outcome-modal-lg<?php echo $rowOutcome->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                  <div class="modal-content">
              
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                      </button>
                                                      <h4 class="modal-title" id="myModalLabel">Outcome Description</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                      <h4><b>Name: &nbsp;</b><?php echo $rowOutcome->title; ?></h4>
                                                      <p><?php echo $rowOutcome->description; ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
              
                                                  </div>
                                                </div>
                                              </div>
                                          </td>
                                          <td><?php  if($rowOutcome->isAssigned == 0){ ?> 
                                              <div class="col-md-12">
                                                  <span class="label label-warning"><b>Not Assigned</b></span></div>
                                              <?php  }  else echo $rowOutcome->executive; ?> 
                                          </td>
                                          <td><?php 
                          
                                              $startd=date_create($rowOutcome->start);
                                              $endd=date_create($rowOutcome->end);
                                              $diff=date_diff($startd, $endd);
                                              $DURATION = $diff->format("%a"); ?>
                                              <p><b><font class="green"><?php  echo $DURATION+1; ?>  Day(s)</font></b><br>
                                              From <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutcome->start)); ?></font></b> <br>
                                              To <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutcome->end)); ?></font></b></p>
                                              
                                          </td>
                                          
                                          <td>
                                              <ul class="list-inline prod_color">
                                                <li>
                                                    <?php 
                                                    $totalTaskProgress = $rowOutcome->sumProgress;
                                                    $taskCount = $rowOutcome->countOutput;
                                                    if($taskCount==0) $progress = 0; else $progress = number_format(($totalTaskProgress/$taskCount),1);
                                                    
                                                    $todayDate=date('Y-m-d');
                                                    $endd=$rowOutcome->end;
                                                      
                                                    
                                            if($todayDate>$endd) {
                                  
                                              if($progress==100){ ?>
                                                  <p><b>Completed</b></p>
                                                      <div class="color bg-green"></div> 
                                                      <?php } elseif($progress<100) { ?>
                                                      <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                      <div class="color bg-red"></div> <?php } 
                                              } else { 
                                                  if($progress==0){ ?>
                                                  <p><b>Not Started</b></p>
                                                      <div class="color bg-orange"></div>
                                                      <?php } elseif($progress>0 && $progress<100) { ?>
                                                  <p><b>
                                                      In Progress (<?php echo $progress; ?>%) </b></p>
                                                      <div class="color bg-blue-sky"></div>
                                                  <?php } elseif($progress==100){ ?>
                                                      <p><b>Completed</b></p>
                                                      <div class="color bg-green"></div>
                                                  <?php }  }  ?> 
                                                  </li>
                                              </ul>
                                          </td>
                                          <td class="options-width">
                                              <a href="<?php echo  url('')."flex/performance/outcome_info/?id=".base64_encode($rowOutcome->strategy_ref."|".$rowOutcome->id); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                              <a href="javascript:void(0)" onclick="deleteOutcome(<?php echo $rowOutcome->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                              <!-- <a href = "<?php echo  url('')."flex/performance/output/".$rowOutcome->id."/".$rowOutcome->strategy_ref; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button></a> -->
                                              
                                              </td>
                                      </tr> 
                                  <?php  }  ?>
                                  </tbody>
                                </table>
                                
                              </div>
                            </div>
                          </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_output" aria-labelledby="profile-tab">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>Output 
                                    <a href ="<?php echo  url(''); ?>/flex/performance/output_report" target = "blank"><button type="button" name="print" value ="print" class="btn btn-info">EXPORT</button></a>
                                    </h2>
                
                                    <div class="clearfix"></div>
                                  </div>
                                  <div id="loadTable-output" class="x_content">
                                     @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                    <table   id="datatable-keytable" class="table table-striped table-bordered">
                                      <thead>
                                        <tr>
                                          <th>S/N</th>
                                          <th>Outcome Reference </th>
                                          <th>Outputs </th>
                                        </tr>
                                      </thead>
                
                
                                      <tbody>
                                        <?php
                                          foreach ($outcomes as $row) {  ?>
                                          <tr>
                                            <td width="1px"><?php echo $row->SNo; ?></td>
                                            <td><?php echo $row->strategy_ref.".".$row->id.".".$row->title; ?></td>
                                            <td> <?php
                                                $output = $CI_Model->performance_model->outputs($row->id);
                                                   if (count($output)>0){ ?>
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th><b>S/N</b></th>
                                                            <th><b>Output Name</b></th>
                                                            <th><b>Accountable Executive</b></th>
                                                            <th><b>Duration</b></th>
                                                            <th><b>RAG Status</b></th>
                                                            <th><b>Option</b></th>
                                                            
                                                        </tr>
                                                    <?php
                                                    foreach ($output as $rowOutput) { ?>
                                                        <tr id="recordOutput<?php echo $row->id;?>">
                                                            <td><?php echo $rowOutput->SNo; ?></td>
                                                            <td><p><b><?php echo $rowOutput->strategy_ref.".".$rowOutput->outcome_ref.".".$rowOutput->id.".".$rowOutput->title; ?></b></p></p>
                                                                <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target=".bs-output-modal-lg<?php echo $rowOutput->id; ?>">View More...</button>
                                
                                                                <div class="modal fade bs-output-modal-lg<?php echo $rowOutput->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                  <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                
                                                                      <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                                        </button>
                                                                        <h4 class="modal-title" id="myModalLabel">Outcome Description</h4>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                        <h4><b>Name: &nbsp;</b><?php echo $rowOutput->title; ?></h4>
                                                                        <p><?php echo $rowOutput->description; ?></p>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                      </div>
                                
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                            </td>
                                                            <td><?php  if($rowOutput->isAssigned == 0){ ?> 
                                                                <div class="col-md-12">
                                                                    <span class="label label-warning"><b>Not Assigned</b></span></div>
                                                                <?php  }  else echo $rowOutput->executive; ?> 
                                                            </td>
                                                            <td><?php 
                                            
                                                                $startd=date_create($rowOutput->start);
                                                                $endd=date_create($rowOutput->end);
                                                                $diff=date_diff($startd, $endd);
                                                                $DURATION = $diff->format("%a"); ?>
                                                                <p><b><font class="green"><?php  echo $DURATION+1; ?>   Day(s)</font></b><br>
                                                                From <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutput->start)); ?></font></b> <br>
                                                                To <b><font class="green"><?php echo date('d-m-Y', strtotime($rowOutput->end)); ?></font></b></p>
                                                                
                                                            </td>
                                                            <td>
                                                                <ul class="list-inline prod_color">
                                                                  <li>
                                                                      <?php 
                                                                      $totalTaskProgress = $rowOutput->sumProgress;
                                                                      $taskCount = $rowOutput->countTask;
                                                                      if($taskCount==0) $progress = 0; else $progress = ($totalTaskProgress/$taskCount);
                                                                      
                                                                      $todayDate=date('Y-m-d');
                                                                      $endd=$rowOutput->end;
                                                                      
                                                            if($todayDate>$endd) {
                                                
                                                                if($progress==100){ ?>
                                                                    <p><b>Completed</b></p>
                                                                        <div class="color bg-green"></div> 
                                                                        <?php } elseif($progress<100) { ?>
                                                                        <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                                        <div class="color bg-red"></div> <?php } 
                                                                } else { 
                                                                    if($progress==0){ ?>
                                                                    <p><b>Not Started</b></p>
                                                                        <div class="color bg-orange"></div>
                                                                        <?php } elseif($progress>0 && $progress<100) { ?>
                                                                    <p><b>
                                                                        In Progress (<?php echo $progress; ?>%) </b></p>
                                                                        <div class="color bg-blue-sky"></div>
                                                                    <?php } elseif($progress==100){ ?>
                                                                        <p><b>Completed</b></p>
                                                                        <div class="color bg-green"></div>
                                                                    <?php }  }  ?> 
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                            <td class="options-width">
                                                                <a href="<?php echo  url('')."flex/performance/output_info/?id=".base64_encode($rowOutput->strategy_ref."|".$rowOutput->outcome_ref."|".$rowOutput->id); ?>"   title="Output Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                                                <a href="javascript:void(0)" onclick="deleteOutput(<?php echo $rowOutput->id;?>)"    title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                                                <a href="<?php echo  url('')."flex/performance/assigntask/?id=".base64_encode($rowOutput->strategy_ref."|".$rowOutput->outcome_ref."|".$rowOutput->id); ?>" ><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button></a>
                                                            </td>
                                                        </tr> 
                                                    <?php  }  ?>
                                                    </table>
                                            </td> <?php } ?>
                                          </tr>
                                          <?php }  ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                            </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_task" aria-labelledby="profile-tab">
                            <!-- START ASSIGNED TO OTHERs -->
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Tasks
            
                                <a href="<?php echo  url('')."flex/performance/assigntask/?id=".base64_encode($currentStrategy."|".$adhoc."|".$adhoc); ?>" ><button type="button"  class="btn btn-primary">CREATE AD-HOC TASK</button></a>
            
                                <a href ="<?php echo  url(''); ?>/flex/performance/task_report" target = "blank"><button type="button" name="print" value ="print" class="btn btn-info">EXPORT</button></a>
                                </h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
            
                              <?php
            
                                 echo session("note");  ?>
                              
                                <table id="datatable-task-table" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Name</th> 
                                      <th>Responsible Person</th>
                                      <th>Accountable Executive</th>
                                      <th>Duration</th>
                                      <th><b>RAG Status</b></th>
                                      <th><b>Option</b></th>
                                      <th>Remarks</th>
                                    </tr>
                                  </thead>
            
            
                                  <tbody>
                                    <?php
                                      foreach ($task as $row) { ?>
                                      <tr id="recordTask<?php echo $row->id;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td>
                                        <?php if($row->output_ref==0) { ?>
                                          <p><b><?php echo $row->id.".".$row->title; ?></b>
                                            </p>
                                        <?php } else { ?>
                                          <p><b><?php echo $row->strategy_ref.".".$row->outcome_ref.".".$row->output_ref.".".$row->id.".".$row->title; ?></b>
                                          </p>
                                          <?php }  ?>
            
                                        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg<?php echo $row->SNo; ?>">More Description</button>
            
                                        <div class="modal fade bs-example-modal-lg<?php echo $row->SNo; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
            
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Task Description</h4>
                                              </div>
                                              <div class="modal-body">
                                                <h4><b>Name: &nbsp;</b><?php echo $row->title; ?></h4>
                                                <p><?php echo $row->description; ?></p>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              </div>
            
                                            </div>
                                          </div>
                                        </div>
            
                                        </td>
                                        <td><?php  if($row->isAssigned == 0){ ?> 
                                        <div class="col-md-12">
                                            <span class="label label-warning"><b>Not Assigned</b></span></div>
                                        <?php  }  else { echo $row->NAME; 
                                        
                                        if($row->status==1){ ?> 
                                        <div class="col-md-12">
                                            <span class="label label-primary"><b>Submitted</b></span></div>
                                        <?php  } else if($row->status==2) { ?>
                                        <div class="col-md-12">
                                            <span class="label label-success"><b>Approved</b></span></div>
                                        <?php } else if($row->status==3) { ?>
                                        <div class="col-md-12">
                                            <span class="label label-warning"><b>Cancelled</b></span></div>
                                        <?php } else if($row->status==5) { ?>
                                        <div class="col-md-12">
                                            <span class="label label-danger"><b>Dissapproved</b></span></div>
                                        
                                        <?php }  } ?> 
                                        </td>
                                        <td>  <?php   echo $row->executive; ?>  </td>
                                        <td>
                                        <?php
                                        $date1=date_create($row->start);
                                        $date2=date_create($row->end);
                                        $diff=date_diff($date1,$date2);
                                        echo $diff->format("%a Day(s)");
            
                                        $dates = date('d-m-Y', strtotime($row->start));
                                        $datee = date('d-m-Y', strtotime($row->end));
                                        
                                        echo "<br>From <b>".$dates."</b><br> To <b>".$datee."</b>"; ?>
                                        </td>                                        
                                        <td>
                                            <ul class="list-inline prod_color">
                                              <li>
                                                  <?php 
                                                  $progress = $row->progress;
                                                  
                                                  $todayDate=date('Y-m-d');
                                                  $endd=$row->end;
                                                    
                                                  
                                        if($todayDate>$endd) {
                            
                                            if($row->status==2){ ?>
                                                <p><b>Completed</b></p>
                                                    <div class="color bg-green"></div> 
                                                    <?php } else{ ?>
                                                    <p><b>Overdue(<?php echo $progress; ?>%)</b></p>
                                                    <div class="color bg-red"></div> <?php } 
                                            } else { 
                                                if($row->status==2){ ?>
                                                <p><b>Completed</b></p>
                                                    <div class="color bg-green"></div> 
                                                    <?php } else {
                                                      if($progress==0){ ?>
                                                <p><b>Not Started</b></p>
                                                    <div class="color bg-orange"></div>
                                                    <?php } elseif($progress>0) { ?>
                                                <p><b>
                                                    In Progress (<?php echo $progress; ?>%) </b></p>
                                                    <div class="color bg-blue-sky"></div>
                                                <?php }  } }  ?> 
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="options-width">
                                            <a href="<?php echo  url('')."flex/performance/task_info/?id=".base64_encode($row->id."|".$row->output_ref); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
            
                                      <!-- Line Manager WHO  ASSIGNED The Task -->
                                      <?php 
                                        if($row->status==1){ ?>
                                        <button type="submit" name="notdone" class="btn btn-warning btn-xs">Disapprove</button>
            
                                        <a href="<?php echo  url('')."/flex/performance/task_approval/?id=".$row->id; ?>"><button type="button" name="go" class="btn btn-success btn-xs">Approve</button></a>
            
            
                                        <?php } if($row->status==0){ ?>
                                            <!--<button type="submit" name="cancel" class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button>-->
                                        <br><a href="javascript:void(0)" onclick="cancelTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"><button class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button> </a>
                                      <?php } ?>
                                        <!--</form>-->
                                        
                                        <a href="javascript:void(0)" onclick="deleteTask(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
            
                                            <!--ACTIONS-->
                                            </td>
            
                                        <td><a href="<?php echo  url('')."flex/performance/comment/?id=".$row->id; ?>"><button type="submit" name="go" class="btn btn-primary btn-xs">Progress<br>and<br>Comments</button></a>
            
            
                                        
                                        </td>
                                        </tr>
                                      <?php }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div> <?php //} ?>
                          <!-- END ASSIGNED TO OTHERS -->
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
          
          <!--Styrategy Modal -->
                <div class="modal fade" id="strategyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add New Strategy</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/performance/strategy"  data-parsley-validate class="form-horizontal form-label-left">
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Type</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="type" class="form-control" tabindex="-1">
                            <option></option>
                            <option value="1"> STRATEGY</option>
                            <option value="2"> PROJECT</option>
                            </select>
                            </div>
                          </div>
                      
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Statergy/Project Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input required="required" required type="text" id="address" name="name" class="form-control col-md-7 col-xs-12">
                              <span class="text-danger"><?php// echo form_error("lname");?></span>
                            </div>
                          </div>

                      
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Statergy/Project Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <select required="" name="funder" class="form-control" tabindex="-1">
                                <option></option>
                                   <?php
                                  foreach ($funders as $row) { ?>
                                  <option value="<?php echo $row->id; ?>"><?php echo strtoupper($row->name); ?></option> <?php } ?>
                                </select>
                            </div>
                          </div>
                           
                          
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea required="" maxlength="256" class="form-control col-md-7 col-xs-12" required name="description" placeholder="Description" rows="3"></textarea> 
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                        
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to Start 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input required="" placeholder="Start Date" type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="strategy_startDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to End
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input required="" placeholder="End Date" type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="strategy_endDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                          <span class="text-danger"><?php// echo form_error("fname");?></span>
                        </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit"  value="ADD" name="addstrategy" class="btn btn-primary"/>
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
          <!-- Stratergy Modal-->




          
          

        <!-- /page content -->  





<script>
$(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!

  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  } 
  if (mm < 10) {
    mm = '0' + mm;
  } 
  var dateToday = dd + '/' + mm + '/' + yyyy;
  $('#strategy_startDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#strategy_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#strategy_startDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script>
$(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!

  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  } 
  if (mm < 10) {
    mm = '0' + mm;
  } 
  var dateToday = dd + '/' + mm + '/' + yyyy;
  $('#strategy_endDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#strategy_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#strategy_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>


 @endsection