<?php 
  @include("app/includes/header")

    <!-- Font Awesome -->
    <link href="<?php echo  url('');?>style/fstdropdown/fstdropdown.css" rel="stylesheet">
  <?php
  @include("app/includes/sidebar")
  @include("app/includes/top_navbar")
?><!-- /top navigation -->

        <!-- page content -->
        <?php
           foreach ($data as $row) {
                $taskID = $row->id;
                $responsible = $row->assigned_to;
                $status = $row->status; 
              }
              $commentMode = $mode;
        ?>
      
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="clearfix"></div>
            <div class="">

              <!-- Tabs -->
              <div class="col-md-12 col-sm-12 col-xs-12">                
                <div class="card">
                  <div class="card-head">
                    <h2>Task Description</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                    <?php echo $row->description; ?>                
                  </div>
                </div>
                <div class="card">
                  <div class="card-head">
                    <h3><?php if($commentMode == 2){ ?> Reject Task with Comments <?php } elseif($commentMode == 1){ ?>Add Remarks(Comments) <?php }elseif($commentMode == 3){ ?>Submit Task <?php } else{  ?>Add Remarks(Comments)<?php } ?></h3>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#commentTab" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true"> COMMENTS & SUBMISSION</a>
                        </li>
                        <li role="presentation" class=""><a href="#activityTab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"> ACTIVITIES</a>
                        </li>
                        <li role="presentation" class=""><a href="#newActivityTab" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false"> NEW ACTIVITY</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="commentTab" aria-labelledby="home-tab">

                          
                    
                <!-- /.col-lg-10 -->

                        <div id="refreshComment" class="col-lg-12">
                            <!-- /.panel -->
                            <div class="chat-panel panel panel-default">
                              <div class="card-head">
                                <h2><i class="fa fa-comments fa-fw"></i>&nbsp;&nbsp;<b>Comments and Submissions</b></h2>
                                <div class="clearfix"></div>
                              </div>

                                <!-- end of user messages -->
                                <ul id="commentsList" class="messages">

                                  <?php foreach ($comment as $row) { 
                                    if ($row->staff==session('emp_id')) { ?>

                                  <li class="me"><br>
                                    <img class="avatar" src="<?php echo url('uploads/userprofile/').$row->photo; ?>" alt="">
                                    <div class="message_wrapper">
                                        <small class="pull-right text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i>
                                          <?php $splitTimeStamp = explode(" ",$row->timesent); 
                                              $calendar = $splitTimeStamp[0];
                                              $time = $splitTimeStamp[1];
                                              $datewell = explode("-",$calendar);
                                              $date = $datewell[2];
                                              $month = $datewell[1];
                                              $year = $datewell[0];  echo $date."-".$month."-".$year."&nbsp;&nbsp;".$time;
                                               ; ?>
                                        </small>
                                      <h4 class="heading">&nbsp;</h4>
                                      <blockquote class="message">
                                      <?php if($row->comment_type ==1){ ?>
                                      <div class="alert alert-info"><?php echo $row->comment; ?>
                                      </div>
                                      <?php } else { ?>
                                      <div class="alert alert-danger"><?php echo $row->comment; ?>
                                      </div>
                                      <?php } ?>
                                      </blockquote>
                                    </div>
                                  </li> 

                                  <?php } else { ?>

                                  <li class="him"><br>
                                    <img class="avatar" src="<?php echo url('uploads/userprofile/').$row->photo; ?>" alt="">
                                    <div class="message_wrapper">
                                        <small class="pull-right text-muted">
                                          <i class="fa fa-clock-o fa-fw"></i>
                                          <?php $splitTimeStamp = explode(" ",$row->timesent); 
                                              $calendar = $splitTimeStamp[0];
                                              $time = $splitTimeStamp[1];
                                              $datewell = explode("-",$calendar);
                                              $date = $datewell[2];
                                              $month = $datewell[1];
                                              $year = $datewell[0];  echo $date."-".$month."-".$year."&nbsp;&nbsp;".$time;
                                               ; ?>
                                        </small>
                                      <h4 class="heading"><?php  echo $row->NAME;?></h4>
                                      <blockquote class="message">
                                      <?php if($row->comment_type ==1){ ?>
                                      <div class="alert alert-success"><?php echo $row->comment; ?>
                                      </div>
                                      <?php } else { ?>
                                      <div class="alert alert-danger"><?php echo $row->comment; ?>
                                      </div>
                                      <?php } ?>
                                      </blockquote>
                                    </div>
                                  </li> 

                                  <?php }  } ?>


                                </ul>
                                <?php if($status !=2 && $commentMode != 3){ ?>
                              <!-- <form id="submitComment" action="<?php echo  url(''); ?>/flex/performance/sendComment" method="post"  > -->
                              <form id="submitComment"  method="post"  >
                                      <input  name="taskID" value="<?php echo $taskID;?>" hidden="" /> 

                                <div class="panel-footer">
                                        <?php if($commentMode == 1) { ?>
                                        <div class="col-md-2 col-sm-6 col-xs-12">
                                          <input class="form-control col-md-7 col-xs-12" name="progress" type="number" min="0" max="100" step="25" placeholder="Progress" /> 
                                        </div>
                                        <?php } ?>
                                    <!--</div>-->
                                    <div class="input-group">
                                      <textarea id="btn-input" rows="2" name="comment" required type="text" class="form-control input-sm" placeholder="Type Your Comment Here..." ></textarea>

                                        <span class="input-group-btn">
                                        <?php if($commentMode == 1) { ?>
                                        <!-- Comment ACTION -->
                                        <input name="action" type="text" value="1" hidden="" />
                                            <button class="btn btn-main btn-sm" id="btn-chat">
                                                Send Comment
                                            </button>
                                        <?php } elseif($commentMode == 2) { ?>
                                        <!-- REJECT ACTION -->
                                        <input name="action" type="text" value="2" hidden="" /> 
                                            <button class="btn btn-danger btn-sm"  id="btn-chat">
                                                REJECT TASK
                                            </button>
                                        <?php } ?>
                                        </span>
                                    </div>
                                </div> 
                              </form> 
                                <?php } if($commentMode == 3){ ?>
                              <form id="submitTask" method="post" >
                                      <input  name="taskID" value="<?php echo $taskID;?>" hidden="" /> 

                                <div class="panel-footer">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                          <input class="form-control col-md-7 col-xs-12" name="userfile" type="file" required="" /> 
                                        </div>
                                    <!--</div>-->
                                    <div class="input-group">
                                        <textarea id="btn-input" rows="3" name="comment" required type="text" class="form-control input-sm" placeholder="Type Your Submission Remarks Here..." ></textarea>
                                        <span class="input-group-btn">
                                            <button class="btn btn-main btn-sm"  id="btn-chat">
                                                SUBMIT TASK
                                            </button>
                                        </span>
                                    </div>
                                </div> 
                              </form>
                                <?php }  ?>
                                <!-- /.panel-footer -->
                            </div>
                                <!-- /.panel-body -->                        
                            </div>
                        <!-- /.col-lg-10 -->
                            <!-- END COMMENT -->

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="activityTab" aria-labelledby="profile-tab">                          
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card">
                              <div class="card-head">
                                <h2>Funders</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="card-body">
                                <div id ="resultfeedbackGet"></div>
                                <table id="datatable-keytable" class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>S/N</th>
                                      <th>Activity Name</th>
                                      <th>Due Date</th>
                                      <th>Start Time</th>
                                      <th>Finish Time</th>
                                      <th>Added By</th>
                                      <th>Created</th>
                                      <th>Option</th>
                                    </tr>
                                  </thead>


                                  <tbody>
                                    <?php
                                      $SNo = 1;
                                      foreach ($activities as $row) { ?>
                                      <tr id="domain<?php //echo $row->id;?>">
                                        <td width="1px"><?php echo $SNo; ?></td>
                                        <td width="1px"><?php echo $row->name; ?></td>
                                        <td width="1px"><?php echo $row->activityDate; ?></td>
                                        <td width="1px"><?php echo $row->startTime; ?></td>
                                        <td width="1px"><?php echo $row->finishTime; ?></td>
                                        <td width="1px"><?php echo $row->employee; ?></td>
                                        <td width="1px"><?php echo $row->dateCreated; ?></td>
                                        <td width="1px"></td>
                                        </tr>
                                      <?php $SNo++; }  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="newActivityTab" aria-labelledby="profile-tab">

                          <div class="col-md-12 col-sm-6 col-xs-6">
                            <div class="card">
                              <div class="card-head">
                                <h2><i class="fa fa-pie-plus"></i>&nbsp;&nbsp;<b>New Activity</b></h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="card-body">
                              <div id="resultfeedSubmission"></div>
                                <form id="addActivity" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                                   
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <div class="input-prepend input-group">
                                          <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                          <input type="text" required="" placeholder="Start Time" name="activityDate" id="activityDate"  class="form-control" />
                                        </div>
                                    </div>
                                  </div>
                                  <input  name="taskID" value="<?php echo $taskID;?>" hidden="" /> 
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Started
                                    </label>
                                    <div class="col-md-2 col-sm-12  form-group">
                                      <select name="startTimeH" required="" class="form-control" tabindex="-1">
                                        <option value="" selected="">--</option>
                                        <?php for ($i=0; $i < 24; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                      <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12  form-group">
                                      <select name="startTimeM" required="" class="form-control" tabindex="-1">
                                        <option value="00" selected="">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>  

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Finished
                                    </label>
                                    <div class="col-md-2 col-sm-12  form-group">
                                      <select name="finishTimeH" required="" class="form-control" tabindex="-1">
                                        <option value="" selected="">--</option>
                                        <?php for ($i=0; $i < 24; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                      <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-2 col-sm-12  form-group">
                                      <select name="finishTimeM" required="" class="form-control" tabindex="-1">
                                        <option value="00" selected="">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>  

                                  
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Description <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-9 col-xs-12">
                                      <textarea required="" class="form-control" name="description" rows="3" placeholder='Activity Description'></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                      <button type="reset" class="btn btn-warning">Cancel</button>
                                      <button type="submit" class="btn btn-main">ADD ACTIVITY</button>
                                      <!-- <input type="submit"  value="SEND REQUEST" name="apply" class="btn btn-main"/> -->
                                    </div>
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
              </div>
              <!-- End Tabs -->
            
          </div>
        </div>
        <!-- /page content -->
<?php   ?>
<script type="text/javascript">
    $('#submitTask').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/performance/submitTask",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
          alert("Task Submitted Successifully");
         $('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });
          $('#submitTask')[0].reset();
        })
        .fail(function(){
     alert('Failed To Add!! ...'); 
        });
    }); 
</script>
<script >
    $('#submitComment').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/performance/sendComment",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         /*$('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });*/
          $("#commentsList").load(" #commentsList");
          $('#submitComment')[0].reset();
    
        })
        .fail(function(){
     alert('Failed To Add!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
$(document).ready(function() {
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
  var dateToday = dd + '-' + mm + '-' + yyyy;

  $('#activityDate').daterangepicker({
    singleDatePicker: true,
    locale: {
      format: 'DD-MM-YYYY'
    },
    singleClasses: "picker_1",
    maxDate: dateToday
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
</script>
<script type="text/javascript"> 

    $('#addActivity').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/performance/addActivity",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){

         $('#resultfeedSubmission').fadeOut('fast', function(){
              $('#resultfeedSubmission').fadeIn('fast').html(data.message);
            });
    
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! Please Review Your Network setup...'); 
        });
    }); 

</script>


 @endsection