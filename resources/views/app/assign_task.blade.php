
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  $referenceOutputID = $outputID;
  $referenceoutcomeID = $outcomeID;
  $referencestrategyID = $strategyID;

  // if ($referenceOutputID>=1 && $referenceoutcomeID>=1 && $referencestrategyID>=1) {
    foreach($taskDateRange as $row){
    
    $startLimit = $row->start;
    $endLimit = $row->end; 
    }
  // }

?>
<!-- /top navigation -->

      
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="clearfix"></div>

                  <?php  echo session("note");  ?>

            <div class="">
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2><i class="fa fa-tasks"></i>
                    <?php if($referenceOutputID==0) { ?> Create Adhoc Task <?php } else { ?>Add Task to an Output <?php } ?></h2>
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
                  <div class="card-body">
                    <div id ="resultfeedDes"></div>
                    <form id="createNewTask" enctype="multipart/form-data"  autocomplete="off" method="post"  data-parsley-validate class="form-horizontal form-label-left">

                      <!-- START -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Task Name
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <textarea required="" class="form-control col-md-7 col-xs-12" id="title" name="title" placeholder="Name of the Task" rows="2"></textarea> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <textarea required="" class="form-control col-md-7 col-xs-12" id="textdescription" name="description" placeholder="Description" rows="3"></textarea> 
                        </div>
                      </div>
                      <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Target Type</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="containercheckbox"> Financial Target 
                              <input type="radio" checked name="quantity_type" value="1">
                              <span class="checkmark"></span>
                            </label>
                            
                            <label class="containercheckbox">Numerical Target 
                              <input type="radio" name="quantity_type" value="2">
                              <span class="checkmark"></span>
                            </label>
                            </div>
                        </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Target
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" class="form-control col-md-7 col-xs-12" id="quantity" name="quantity" type="number" min="1" max="99999999999" step="1" placeholder="Amount or Quantity" /> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Time Cost
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" class="form-control col-md-7 col-xs-12" id="monetary_value" name="monetary_value" type="number" min="0" max="100000000" step="1" placeholder="Time Cost" /> 
                        </div>
                      </div>
                      <input type="text" name="outputID" value ="<?php echo $referenceOutputID; ?>" hidden >
                      <input type="text" name="outcomeID" value ="<?php echo $referenceoutcomeID; ?>" hidden >
                      <?php if($referenceOutputID==0) { ?>
                      <input type="text" name="strategyID" value ="0" hidden > 
                      <?php } else { ?>
                      <input type="text" name="strategyID" value ="<?php echo $referencestrategyID; ?>" hidden >
                      <?php } ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start Date
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" placeholder="Select Date" required="" name="start" class="form-control col-xs-12 has-feedback-left" id="task_startDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End Date
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" required="" placeholder="Select Date" name="end" class="form-control col-xs-12 has-feedback-left" id="task_endDate"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 
                      <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Assign To</label>
                            
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select name="employee" class="select4_single form-control" tabindex="-1"><option></option>
                               <?php
                              foreach ($employee as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                            </select>
                            </div>
                      </div>
                          
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           <button type="reset" class="btn btn-default" >CANCEL</button>
                           <button  class="btn btn-main">ADD</button>
                        </div>
                      </div> 
                      </form>

                  </div>
                </div>
                <!-- Task List-->
                <div class="card">
                  <div class="card-body">
                  <div class="card-head">
                    <h2><i class="fa fa-tasks"></i>
                    <?php //if($referenceOutputID==0) { ?> Task List <?php // } else { ?> <?php //} ?> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                     <!--@if(Session::has('note'))      {{ session('note') }}  @endif  ?>-->
                    <div id = "taskList">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th> 
                          <th>Assigned To</th>
                          <th>Duration</th>
                          <!--<th>Option</th>-->
                          <th><b>RAG Status</b></th>
                          <!--<th><b>RAG Status</b></th>-->
                          <th><b>Option</b></th>
                          <th>Remarks</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($tasks as $row) { ?>
                          <tr id="recordTask<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><p><b><?php echo $row->title; ?></b></p>

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

                            <?php //echo $row->description; ?></td>
                            <td><?php  if($row->isAssigned == 0){ ?> 
                            <div class="col-md-12">
                                <span class="label label-warning"><b>Not Assigned</b></span></div>
                            <?php  }  else echo $row->NAME; ?> 
                            </td>


                            <td>
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
                                <?php if($row->output_ref==0) { ?>
                                <a href="<?php echo  url('')."flex/performance/adhoc_task_info/".base64_encode($row->id); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                                <?php } else { ?>
                                <a href="<?php echo  url('')."flex/performance/task_info".base64_encode($row->id."|".$row->output_ref); ?>"   title="Outcome Info and Details" class="icon-2 info-tooltip"><button  class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i> | <i class="fa fa-edit"></i></button> </a>
                                <?php }  ?>

                          <!-- Line Manager WHO  ASSIGNED The Task -->
                          <?php 
                            if($row->status==1){ ?>
                            <button type="submit" name="notdone" class="btn btn-warning btn-xs">Disapprove</button>

                            <a href="<?php echo  url('')."/flex/performance/task_approval".$row->id; ?>"><button type="button" name="go" class="btn btn-success btn-xs">Approve</button></a>


                            <?php } if($row->status==0){ ?>
                                <!--<button type="submit" name="cancel" class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button>-->
                            <br><a href="javascript:void(0)" onclick="cancelTask(<?php echo $row->id;?>)"   title="Cancel" class="icon-2 info-tooltip"><button class="btn btn-warning btn-xs"><i class="fa fa-times"></i></button> </a>
                          <?php } ?>
                            <!--</form>-->
                            
                            <a href="javascript:void(0)" onclick="deleteTask(<?php echo $row->id;?>)"   title="Delete" class="icon-2 info-tooltip"><button class="btn btn-danger btn-xs"><i class="ph-trash-o"></i></button> </a>

                                <!--ACTIONS-->
                                </td>

                            <td><a href="<?php echo  url('')."flex/performance/comment".$row->id; ?>"><button type="submit" name="go" class="btn btn-main btn-xs">Progress<br>and<br>Comments</button></a>


                            
                            </td>
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
                <!--Task List-->
              </div>
              <!-- Tabs -->

          </div>
        </div>
        <!-- /page content -->



       <?php
       
       @include("app/includes/unrefresh_form_submit")

      <?php if ($referenceOutputID>=1 ) { ?>
      <script>
      $(function() {
        var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
        var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
        $('#task_startDate').daterangepicker({
          drops: 'up',
          singleDatePicker: true,
          autoUpdateInput: false,
          startDate: "<?php echo date('d/m/Y', strtotime($startLimit)); ?>",
          minDate:minStartDate,
          maxDate:maxEndDate,
          locale: {      
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          // var years = moment().diff(start, 'years');
          // alert("The Employee is " + years+ " Years Old!");

        });
          $('#task_startDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
          $('#task_startDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
      });
      </script>

      <script>
      $(function() {
        var minStartDate = "<?php echo date('d/m/Y', strtotime($startLimit)); ?>";
        var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
        $('#task_endDate').daterangepicker({
          drops: 'up',
          singleDatePicker: true,
          autoUpdateInput: false,
          startDate: "<?php echo date('d/m/Y', strtotime($startLimit)); ?>",
          minDate:minStartDate,
          maxDate:maxEndDate,
          locale: {      
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          // var years = moment().diff(start, 'years');
          // alert("The Employee is " + years+ " Years Old!");

        });
          $('#task_endDate').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
          $('#task_endDate').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
      });
      </script>

      <?php } else { ?>

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
          var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
          $('#task_startDate').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate:dateToday,
            minDate:dateToday,
            locale: {      
              format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
          }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

          });
            $('#task_startDate').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD/MM/YYYY'));
          });
            $('#task_startDate').on('cancel.daterangepicker', function(ev, picker) {
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
          var maxEndDate = "<?php echo date('d/m/Y', strtotime($endLimit)); ?>";
          $('#task_endDate').daterangepicker({
            drops: 'up',
            singleDatePicker: true,
            autoUpdateInput: false,
            startDate:dateToday,
            minDate:dateToday,
            locale: {      
              format: 'DD/MM/YYYY'
            },
            singleClasses: "picker_1"
          }, function(start, end, label) {
            // var years = moment().diff(start, 'years');
            // alert("The Employee is " + years+ " Years Old!");

          });
            $('#task_endDate').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD/MM/YYYY'));
          });
            $('#task_endDate').on('cancel.daterangepicker', function(ev, picker) {
              $(this).val('');
          });
        });
        </script>
      <?php } ?>









<script>
$(function() {
  $('#birthdate').daterangepicker({
    opens: 'left',
    singleDatePicker: true,
    autoUpdateInput: false,
    maxDate:dateStart,
    minDate:dateEnd,
    startDate:dateStart,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_2"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');
    alert("The Employee is " + years+ " Years Old!");

  });
    $('#birthdate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#birthdate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>
      
 @endsection