
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
  $adhoc =0;
  $strategyID = session('current_strategy');
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Tasks </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
            <!-- MY TASK -->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2> My <?php echo $tag; if($active>0 && session('line') != 0){ ?> 
                    <a href="<?php echo  url('')."flex/performance/assigntask/?id=".base64_encode($strategyID."|".$adhoc."|".$adhoc); ?>" ><button type="button"  class="btn btn-main">CREATE AD-HOC TASK</button></a> <?php } ?></h2>

                    

                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                  <?php

                     echo session("note");  ?>
                  <div id="resultfeed"></div>
                    <table id="datatable-keytable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th> 
                          <th>Responsible Person</th>
                          <th>Accountable Executive</th>
                          <th>Duration</th>
                          <th><b>RAG Status</b></th>
                          <th><b>Option</b></th>
                          <?php if($active>0){ ?> 
                          <th>Remarks</th>
                          <?php } ?> 
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($mytask as $row) { ?>
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

                            <button type="button" class="btn btn-main btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg<?php echo $row->SNo; ?>">More Description</button>

                            <div class="modal fade bs-example-modal-lg<?php echo $row->SNo; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Task Description</h4>
                                  </div>
                                  <div class="modal-body">
                                    <h4><b>Title: &nbsp;</b><?php echo $row->title; ?></h4>
                                    <p><?php echo $row->description; ?></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>

                                </div>
                              </div>
                            </div>

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
                            <td><?php   echo $row->executive; ?> </td>


                            <td  <?php if($row->end<date('Y-m-d')){ ?> bgcolor="#F5B7B1" <?php } ?>>
                            <?php
                            $date1=date_create($row->start);
                            $date2=date_create($row->end);
                            $diff=date_diff($date1,$date2);
                            echo 1+$diff->format("%a")."  Day(s)";

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
                            <?php  if($active==0){ ?>

                            <a href="javascript:void(0)" onclick="resumeTask(<?php echo $row->id;?>)"   title="PAUSE" class="icon-2 info-tooltip">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">RESUME TASK</button></a>

                          <?php } if($active>0){  ?>

                          <a href="<?php echo  url('')."flex/performance/task_info/?id=".base64_encode($row->id."|".$row->output_ref); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button type="button" name="notdone" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>

                          <?php if($row->status==0){ ?>
                          <a href="javascript:void(0)" onclick="pauseTask(<?php echo $row->id;?>)"   title="PAUSE" class="icon-2 info-tooltip">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">PAUSE</button></a>
                            <?php if($row->progress==0){ ?>
                          <a href="javascript:void(0)" onclick="deleteTask(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>

                          <!-- Line Manager WHO  ASSIGNED The Task -->
                          <?php }  } if($row->status==1 && $row->progress == 100){ ?>
                            <a download= '' href ="<?php echo url('uploads/task/').$row->attachment; ?>"> <button type="submit" name="notdone" class="btn btn-main btn-xs">DOWNLOAD</button></a> 
                            <a href="<?php echo  url('')."flex/performance/comment/?mode=2&id=".$row->id; ?>">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">Disapprove</button></a>

                            <a href="<?php echo  url('')."flex/performance/task_approval/?id=".$row->id; ?>"><button type="button" name="go" class="btn btn-success btn-xs">Approve</button></a>


                            <?php }  if($row->status==0){ ?>
                            <br><a href="javascript:void(0)" onclick="cancelTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"><button class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button> </a>
                          <?php }  } ?> 

                            </td>
                            <?php if($active>0){ ?> 

                            <td>
                                <a href="<?php echo  url('')."flex/performance/comment/?mode=1&id=".$row->id; ?>"><button type="submit" name="go" class="btn btn-main btn-xs">Progress<br>and<br>Comments</button></a>                               

                                <?php if( $row->status!=2 && $row->progress==100 ){ ?>
                                <a href="<?php echo  url('')."flex/performance/comment/?mode=3&id=".$row->id; ?>"><button type="submit" name="go" class="btn btn-main btn-xs">SUBMIT</button></a>
                                <?php }  ?>
                            </td>
                            <?php } ?> 
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <!-- MY TASk -->

              <!-- START ASSIGNED TO OTHERs -->
              <?php  if( session('line') != 0){ ?> 
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2><?php echo $tag; ?> (Others)
                    <?php if($active>0){ ?> 
                    <a href="<?php echo  url('')."flex/performance/assigntask/?id=".base64_encode($strategyID."|".$adhoc."|".$adhoc); ?>" ><button type="button"  class="btn btn-main">CREATE AD-HOC TASK</button></a> <?php } ?></h2>

                    

                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                  <?php

                     echo session("note");  ?>
                  <div id="resultfeed"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th> 
                          <th>Responsible Person</th>
                          <th>Accountable Executive</th>
                          <th>Duration</th>
                          <th><b>RAG Status</b></th>
                          <th><b>Option</b></th>
                          <?php if($active>0){ ?> 
                          <th>Remarks</th>
                          <?php } ?> 
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($othertask as $row) { ?>
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

                            <button type="button" class="btn btn-main btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg<?php echo $row->SNo; ?>">More Description</button>

                            <div class="modal fade bs-example-modal-lg<?php echo $row->SNo; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Task Description</h4>
                                  </div>
                                  <div class="modal-body">
                                    <h4><b>Title: &nbsp;</b><?php echo $row->title; ?></h4>
                                    <p><?php echo $row->description; ?></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>

                                </div>
                              </div>
                            </div>

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
                            <td><?php  
                            echo $row->executive; ?> 
                            </td>


                            <td  <?php if($row->end<date('Y-m-d')){ ?> bgcolor="#F5B7B1" <?php } ?>>
                            <?php
                            $date1=date_create($row->start);
                            $date2=date_create($row->end);
                            $diff=date_diff($date1,$date2);
                            echo 1+$diff->format("%a")."  Day(s)";

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
                            <?php  if($active==0){ ?>

                            <a href="javascript:void(0)" onclick="resumeTask(<?php echo $row->id;?>)"   title="PAUSE" class="icon-2 info-tooltip">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">RESUME TASK</button></a>

                          <?php } if($active>0){ ?> 

                                <a href="<?php echo  url('')."flex/performance/task_info/?id=".base64_encode($row->id."|".$row->output_ref); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button type="button" name="notdone" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>


                                <a href="javascript:void(0)" onclick="pauseTask(<?php echo $row->id;?>)"   title="PAUSE" class="icon-2 info-tooltip">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">PAUSE</button></a>

                          <!-- Line Manager WHO  ASSIGNED The Task -->
                          <?php 
                            if($row->status==1 && $row->progress == 100){ ?>
                            <!-- <a href="javascript:void(0)" onclick="disapproveTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"> -->
                            <a href="<?php echo  url('')."flex/performance/comment/?mode=2&id=".$row->id; ?>">
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">Disapprove</button></a>

                            <a href="<?php echo  url('')."flex/performance/task_approval/?id=".$row->id; ?>"><button type="button" name="go" class="btn btn-success btn-xs">Approve</button></a>


                            <?php } 
                            if($row->status==0){ ?>
                            <br><a href="javascript:void(0)" onclick="cancelTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"><button class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button> </a>
                          <?php } ?>
                            <!--</form>-->
                            
                            <a href="javascript:void(0)" onclick="deleteTask(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>
                            <?php } ?> 

                            </td>
                            <?php if($active>0){ ?> 

                            <td>
                                <a href="<?php echo  url('')."flex/performance/comment/?mode=1&id=".$row->id; ?>"><button type="submit" name="go" class="btn btn-main btn-xs">Progress<br>and<br>Comments</button></a>
                                <?php if( $row->status!=2 && $row->progress==100 ){ ?>
                                <a href="javascript:void(0)" onclick="submitTask(<?php echo $row->id;?>)" ><button  class="btn btn-info btn-xs">Submit</button></a>
                                <?php }  ?>
                            </td>
                            <?php } ?> 
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> <?php } ?>
              <!-- END ASSIGNED TO OTHERS -->

            </div>
          </div>
        </div>

        



        <!-- /page content -->
       


<script>
    function pauseTask(id)
    {
        if (confirm("Are You Sure You Want to Pause This Task?") == true) {
        var taskid = id;
            $.ajax({
                url: "<?php echo url('flex/performance/pauseTask');?>/"+taskid
            })
            .done(function(data){
                var regex = /(<([^>]+)>)/ig
                var body = data
                var result = body.replace(regex, "");
                alert(result);
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#recordTask'+id).hide();
                })
            .fail(function(){
             alert(' Failed!! ...'); 
                });
        }
    }
    

    function resumeTask(id)
    {
        if (confirm("Are You Sure You Want to RESUME This Task ") == true) {
        var taskid = id;
            $.ajax({
                url: "<?php echo url('flex/performance/resumeTask');?>/"+taskid
            })
            .done(function(data){
                var regex = /(<([^>]+)>)/ig
                var body = data
                var result = body.replace(regex, "");
                alert(result);
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#recordTask'+id).hide();
                })
            .fail(function(){
             alert(' Failed!! ...'); 
                });
        }
    }
    
</script>
 @endsection