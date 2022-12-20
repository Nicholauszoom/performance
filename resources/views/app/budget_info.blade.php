@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php   
  foreach($info as $detail){    
  $budgetID = $detail->id;
  $description = $detail->description;
  $date_recommended = $detail->date_recommended;
  $status = $detail->status;  
  $start = $detail->start;  
  $end = $detail->end;  
  $amount = $detail->amount;
  $recommended_by = $detail->primary_personel;
  $approved_by = $detail->approved_by;
  $date_approved = $detail->date_approved;

  } 
  
  ?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Budget</h3>
      </div>
    </div>
    
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body"> 
                    <!-- start project-detail sidebar -->
            <div class="col-md-12 col-sm-3 col-xs-12">
              <section class="panel">
                <div class="panel-body">
                          
                          <!--Start Tabs Content-->
                  <div class="col-md-12 col-sm-6 col-xs-12">
                    <div class="card">
                      <div class="card-head">
                          <h3 class="green"><i class="fa fa-info-circle"></i> <?php echo $description; ?></h3>
                        <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
                        <div id ="resultFeedDes"></div>
    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation"  class="active" ><a href="#description" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Description</a>
                            </li>
                            </li>
                            <li role="presentation" class=""><a href="#updateStrategy" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><font color = "green"><b><i class="fa fa-edit"></i>&nbsp;&nbsp;UPDATE</b></font></a>
                            </li>
                            </li>
                          </ul>
                          <div id="myTabContent" class="tab-content">
                            <div role="tabpanel"  id="description"  class="tab-pane fade active in"  aria-labelledby="home-tab">
                              <p><b><font class="green">Description: </font></b><?php echo $description; ?></p>
                              <p><b><font class="green">Start From: </font></b><?php echo date('d-m-Y', strtotime( $start)); ?></p>
                              <p><b><font class="green">Finish At: </font></b><?php echo date('d-m-Y', strtotime( $end)); ?></p>
                              <p><b><font class="green">Requested By: </font></b><?php echo $recommended_by; ?></p>
                              <p><b><font class="green">Date Requested: </font></b><?php echo date('d-m-Y', strtotime($date_recommended)); ?></p>
                              <p><b><font class="green">Status: </font></b></p>
                              <div>
                              <?php if($status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php } 
                              elseif($status==1){ ?><div class="col-md-12"><span class="label label-success">ACCEPTED</span></div><?php }
                              elseif($status==2){ ?><div class="col-md-12"><span class="label label-danger">REJECTED</span></div><?php } ?>
                            </div>

                            <?php if($status==1 || $status==2 ){ ?> 

                              <p><b><font class="green">Approved By: </font></b><?php echo $approved_by; ?></p>
                              <p><b><font class="green">Date Approved: </font></b><?php echo date('d-m-Y', strtotime( $date_approved)); ?></p>
                              <?php } ?>
                              
                            </div>
                            
                            <!--UPDATE OUTCOME-->
                            <div role="tabpanel" class="tab-pane fade" id="updateStrategy" aria-labelledby="profile-tab">
                              <div class="col-md-12 col-sm-6 col-xs-12">

                                      <!--DESCRIPTION-->
                                <form autocomplete="off" id="update_budgetDescription" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">                                    
                                      
                                  <!--<div id ="resultfeedDes">SWER</div>-->
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description  
                                    </label><br>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                      <textarea required="" class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" rows="3"><?php echo $description;?></textarea>
                                      
                                    </div>
                                  </div>
                                  <input type="text" name="budgetID" value ="<?php echo $budgetID; ?>" hidden >
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button  class="btn btn-info">UPDATE</button> 
                                     <!--<div id ="resultfeedDes">e</div>-->
                                    </div>
                                  </div> 
                                </form>
                                  <!--DESCRIPTION-->

                                      <!--Amount-->
                                <form autocomplete="off" id="update_budgetAmount" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">                                    
                                      
                                  <!--<div id ="resultfeedDes">SWER</div>-->
                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Budget Amount  
                                    </label><br>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                      <input required="" type="number" min="0" max="99999999999" step="1" class="form-control col-md-7 col-xs-12" name="amount" placeholder="Amount" value="<?php echo $amount;?>" />
                                      
                                    </div>
                                  </div>
                                  <input type="text" name="budgetID" value ="<?php echo $budgetID; ?>" hidden >
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button  class="btn btn-info">UPDATE</button> 
                                     <!--<div id ="resultfeedDes">e</div>-->
                                    </div>
                                  </div> 
                                </form>
                                  <!--Amount-->
                                  
                                  <!--START DATE-->
                                <form autocomplete="off" id="update_budgetDateRange" enctype="multipart/form-data"  method="post"   data-parsley-validate class="form-horizontal form-label-left">
                                  

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start Date
                                    </label>
                                       <span class="text-info"><?php echo date('d-m-Y', strtotime( $start)); ?></span> 
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                      <div class="has-feedback">
                                      <input required="" type="text" name="start" placeholder="Start Date" class="form-control col-xs-12 has-feedback-left" id="startDate_update"  aria-describedby="inputSuccess2Status">
                                      <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    </div>
                                  </div>
                                  

                                  <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End Date
                                    </label>
                                       <span class="text-info"><?php echo date('d-m-Y', strtotime( $end)); ?></span> 
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                      <div class="has-feedback">
                                      <input required="" type="text" name="end" placeholder="End Date" class="form-control col-xs-12 has-feedback-left" id="endDate_update"  aria-describedby="inputSuccess2Status">
                                      <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                                    </div>
                                    </div>
                                  </div>
                                  
                                  <input type="text" name="budgetID" value ="<?php echo $budgetID; ?>" hidden >
                                  <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button  class="btn btn-info">UPDATE</button> 
                                    </div>
                                  </div> 
                                </form>
                              </div>  
                            </div>
                            <!-- UPDATE OUTCOME-->                            
                          </div>
                        </div>    
                      </div>
                    </div>
                  </div><!-- End Tabs Content-->
                </div>
              </section>
            </div> <!-- end project-detail sidebar -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->




<?php  
   
  @include("app/includes/training_operations

     <!-- DATE SCRIPTS  -->


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
  $('#startDate_update').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    // minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#startDate_update').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#startDate_update').on('cancel.daterangepicker', function(ev, picker) {
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
  $('#endDate_update').daterangepicker({
    drops: 'up',
    singleDatePicker: true,
    autoUpdateInput: false,
    // minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#endDate_update').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#endDate_update').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>


 @endsection