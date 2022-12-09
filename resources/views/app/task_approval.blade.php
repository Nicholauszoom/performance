@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section

        <!-- page content -->
        <?php
            if ($task_details){

              foreach ($task_details as $row) {
                $id = $row->id;
                $remarks = $row->remarks; 
                $title = $row->title; 
                $start = $row->start; 
                $monetary_value = $row->monetaryValue; 
                $end = $row->end;  
                $qualityass = $row->quality; 
                $initial_quantity = $row->initial_quantity; 
                $complete = $row->date_completed; 
                $progress = $row->progress; 
                
                }              

                foreach ($marking as $row_marking) {
                $percent_quantity = $row_marking->quantity; 
                $percent_behavior = $row_marking->behaviour;                                 
                }
                  
                $date1=date_create($start);
                $date2=date_create($end);
                $date3=date_create($complete);

                $durationdiff=date_diff($date1, $date2);
                $duration = $durationdiff->format("%R%a");

                $duration_taken=date_diff($date1,$date3);
                $submitted_duration = $duration_taken->format("%R%a");
 

                  ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Task Marking and Approval </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Fill The Task Approval Parameters Below </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <h2><b>Task Title: </b></h2>
                  <p ><?php echo $title; ?></p>
                       <?php if($end < date('Y-m-d')){ ?>
                    <p class='alert alert-warning text-center'>This Task Is Overdue (Late Submission).</p>
                    <?php } 
                     if($progress < 100){ ?>
                    <p class='alert alert-warning text-center'>This Task Is Incomplete Can Not Be Approved.</p>
                    <?php } ?>
                      
                      <!--RESOURCES USED-->
                  <div class="col-lg-12"> 
                    <form  id="taskResources" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Resources Used(Optional)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id ="resultfeedDes"></div> 

                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                Total Cost: <button  class="btn btn-primary" disabled=""> <div id="totalCost"><b><?php echo number_format($totalResourceCost,2); ?> </b></div></button> 
                              </div>
                            <input name="taskID" hidden value="<?php echo $id; ?>">
                            <table  class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Resource Name</th>
                                  <th>Cost</th>
                                  <th></th>
                                </tr>
                              </thead>

                              <tbody>
                                  <tr>
                                    <td> 
                                    <div class="form-group">
                                      <textarea   cols="10"  required=""  name="name"  rows="1"></textarea>
                                    </div>
                                    </td> 
                                    <td> 
                                    <div class="form-group">
                                      <input name="cost" min="1"  type="number" step="1" required=""  placeholder="Cost"   class="form-control">                                     
                                    </div>
                                    </td>                          
                                    <td> <button <?php if($progress<100){ ?> disabled="" <?php } ?>   class="btn btn-primary">ADD</button>
                                     </td>
                                    </tr>
                              </tbody>
                            </table>
                        </div>
                      </div>
                      </form>
                  </div>
                      <!--RESOURCES USED--> 
                  
                  <div class="col-lg-12"> 

                    <form id="approveTask" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">

                      <!-- START -->      

                      <input hidden="hidden" name="taskID" value="<?php echo $id;  ?>" />
                                            
                      <input hidden="hidden" name="marks_behaviour" value="<?php echo number_format($percent_behavior, 2);  ?>" />
                      <input hidden="hidden" name="required_duration" value="<?php echo $duration; ?>" />                      
                      <input hidden="hidden" name="submitted_duration" value="<?php echo $submitted_duration; ?>" />
                      <input hidden="hidden" name="required_quantity" value="<?php echo $initial_quantity; ?>" />
                      <input hidden="hidden" name="percent_quantity" value="<?php echo $percent_quantity; ?>" />
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="last-name">Target: 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" value="<?php echo number_format($initial_quantity,2); ?>" disabled /> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="last-name">Quantity/Amount Submitted
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" name="submitted_quantity" type="number" required="" min="0" max="999000000" step="1" placeholder="Submitted Quantity" /> 
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Time Cost
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input 
                          ="" class="form-control col-md-7 col-xs-12" name="monetary_value" type="number" min="0" max="100000000" step="1" disabled="" value="<?php echo $monetary_value; ?>" placeholder="Time Cost" /> 
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Behaviour
                        </label>
                        <div class="col-md-8 col-sm-6 col-xs-12">
                        <div class="x_panel">
                          <div class="x_content">
                            <table  class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>S/N</th>
                                  <th>Title</th>
                                  <th>Option</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  foreach ($behaviour as $row) { ?>
                                  <tr>
                                    <td width="1px"><?php echo $row->SNo; ?></td>
                                    <td><?php echo $row->title; ?></td>
                                    
                                    <td class="options-width">
                                   <div class="col-md-6 col-sm-8 col-xs-12">

                                      <?php foreach ($ratings as $key) { ?>
                                        <label class="containercheckbox"><?php echo $key->title; ?>
                                        <input type="radio" <?php if ($key->id==4){ ?> checked="" <?php } ?> value="<?php echo ($key->contribution)*($row->marks); ?>" name="behaviour<?php echo $row->SNo; ?>">
                                        <span class="checkmarkradio"></span>
                                      </label>
                                      <?php  } ?>
                                    </div>

                                    </td>
                                    </tr>
                                  <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>

                      <!-- RATING -->
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Remarks(Optional)
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea   cols="10" class="form-control col-md-7 col-xs-12"  name="remarks"  rows="5"><?php echo $remarks;  ?></textarea>
                        </div>
                      </div>

                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>"> <br>
                      <div class="form-group">
                        <div class="text-center mtop20">
                           <button type="reset" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                          <button  type="submit" <?php if($progress<100){ ?> 
                          ="" <?php } ?>   name="approve" class="btn btn-success">Approve</button>
                        </div>
                      </div> 
                      </form>
                  </div>
                  <!--  -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <?php } ?>
                <!-- /.col-lg-10 -->
                    <!-- END COMMENT -->

        <!-- /page content -->
        

<?php 
//include_once "app/includes/unrefresh_form_submit")



<script type="text/javascript">
  $('#approveTask').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo url(); ?>flex/performance/task_marking",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
  $('#taskResources')[0].reset();
    })
    .fail(function(){
 alert('Task Approval Failed, Please Review Your Network Connection! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#taskResources').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo url(); ?>flex/performance/addTaskResources",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data.message
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data.message);
        });

     $('#totalCost').fadeOut('fast', function(){
          $('#totalCost').fadeIn('fast').html(data.resourceCost);
        });

  // $('#totalCost').load('#totalCost');
  $('#taskResources')[0].reset();
    })
    .fail(function(){
 alert('Resource Not Added! ...'); 
    });

});
</script>
 @endsection