@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
<!-- /top navigation -->
      
        <!-- page content -->
        <div class="right_col" role="main">


            <div class="clearfix"></div>

            <div class="">
                
                <!--MY OVERTIMES-->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Overtime   
                    <a  href="#bottom"><button type="button" id="modal" data-toggle="modal" data-target="#departmentModal" class="btn btn-primary">APPLY OVERTIME</button></a></h2>

                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> 

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <div id ="myResultfeedOvertime"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Date</th>
                          <th>Total Overtime(in Hrs.)</th>
                          <th>Reason(Description)</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($my_overtimes as $row) { ?>
                           <?php if(!$row->status==2) { ?>
                          <tr id="domain<?php //echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row->applicationDATE)); ?></td>
                            <td>
                                <?php
                                
                                echo "<b>Duration: </b>".$row->totoalHOURS." Hrs.<br><b>From: </b>".$row->time_in." <b> To </b>".$row->time_out; 
                                ?>
                            </td>
                            
                            <td><?php echo $row->reason; ?></td>
                            
                            <td>
                            <div id ="status<?php echo $row->eoid; ?>">
                            <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">REQUESTED</span></div><?php } 
                            elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED</span></div><?php }
                            elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-success">APPROVED</span></div><?php } 
                            elseif($row->status==3){ ?><div class="col-md-12"><i style="color:red" class="fa fa-hand-paper-o"></i></div><?php }  ?></div>
                            
                            </td>
                            
                            
                            <td class="options-width">
                            <?php if($row->status==0 || $row->status==3){ ?>
                            <a href="javascript:void(0)" onclick="cancelOvertime(<?php echo $row->eoid;?>)"  title="Cancel overtime">
                            <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></a>
                            
                            <?php } ?>
                            </td>
                            </tr>
                            <?php }  ?>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
                
                <!--OTHERS OVERTIMES-->
                <?php if(count($line_overtime)>0) { ?>
                <div role="tabpanel" class="tab-pane " id="overtimeTab" >
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                              <div class="x_title">
                                <h2>Others Overtime</h2>
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">
                                @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                  <div id ="resultfeedOvertime"></div>
                                  <table id="datatable-keytable" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>S/N</th>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Total Overtime(in Hrs.)</th>
                                        <th>Reason(Description)</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                        foreach ($line_overtime as $row) { ?>
                                          <?php  if ($row->status==2) {  continue; } ?>
                                        <tr >
                        
                                          <td width="1px"><?php echo $row->SNo; ?></td>
                                          <td><?php echo $row->name; ?></td>
                                          <td><?php echo  "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                                          
                                          <td>
                                          <?php                                
                                            echo "<b>On: </b>".date('d-m-Y', strtotime($row->applicationDATE))."<br><b>Duration: </b>".$row->totoalHOURS." Hrs.<br><b>From: </b>".$row->time_in." <b> To </b>".$row->time_out; 
                                          ?>
                                          </td>
                                          <td><?php echo $row->reason; ?></td>
                                          
                                          <td>
                                          <div id ="record<?php echo $row->eoid; ?>">
                                          <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">REQUESTED</span></div><?php } 
                                          elseif($row->status==1 && $pendingPayroll==0){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED BY LINE MANAGER</span></div><?php }
                                          elseif($row->status==4 && $pendingPayroll==0){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY FINANCE</span></div><?php }
                                          elseif($row->status==3 && $pendingPayroll==0 ){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY HR</span></div><?php }
                                          elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY CD</span></div><?php } 
                                          elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-success">RETIREMENT CONFIRMED</span></div><?php }
                                          elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-danger">DISSAPPROVED</span></div><?php }
                                          elseif($row->status==7){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php }
                                          elseif($row->status==8){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED RETIREMENT</span></div><?php } ?></div> <br><br>
                                          
                    
                                        <?php  if ($row->status==0) {   ?>
                                          <a href="javascript:void(0)" title="Approve" class="icon-2 info-tooltip" onclick="lineapproveOvertime(<?php echo $row->eoid;?>)">
                                          <button class="btn btn-success" ><i class="fa fa-check-circle"></i></button></a>  
                                        
                                          <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip" onclick="cancelOvertime(<?php echo $row->eoid;?>)">
                                              <button class="btn btn-danger"><i class="fa fa-times-circle"></i></button></a>  
                                        
                                        <?php }?> 
           
                                        </td>
                                        
                                          
                                          <td class="options-width">
                                          <?php //if($row->status==1 || session('line') !=0 ){ ?> <?php //} ?>
                                          <?php //if ($row->status==2) {   ?>
                                          <a href="<?php echo  url(''); ?>/flex/fetchOvertimeComment/".$row->eoid; ?>"><button  class='btn btn-primary btn-xs'>Comment</i></button></a>
                                          <?php //}  ?>
                                          </td>
                                          </tr>
                                          
                                        <?php }  ?>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        
               <?php } ?>
              
              
              <div id="bottom" class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-time"></i>Apply Overtime </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <div id="resultfeedSubmission"></div>
                    <form id="applyOvertime" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                       
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Overtime Category</label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <select required="" name="category" class="select_category form-control" tabindex="-1">
                        <option></option>
                           <?php  foreach ($overtimeCategory as $row) {
                             # code... ?>
                          <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Start
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" required="" placeholder="Start Time" name="time_start" id="time_start" class="form-control" />
                            </div>
                        </div>
                      </div>
                       
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time End
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" required="" placeholder="Finish Time" name="time_finish" id="time_end" class="form-control" />
                            </div>
                        </div>
                      </div>
                       
                      <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Range
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="time_range" id="time_range" class="form-control" />
                            </div>
                        </div>
                      </div> -->
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason For Overtime <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <textarea required="" class="form-control" name="reason" rows="3" placeholder='Reason'></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary">SEND REQUEST</button>
                          <!-- <input type="submit"  value="SEND REQUEST" name="apply" class="btn btn-primary"/> -->
                        </div>
                      </div> 
                      </form><br><br><br><br><br><br><br><br>

                  </div>
                </div>
              </div>


          </div>
        </div>
      <!-- /page content -->

       
       @include("app/includes/overtime_operations")
<script type="text/javascript">
  $(".select_category").select2({
          placeholder: "Select Category",
          allowClear: true
        });

$(function() {

  $('#time_range').daterangepicker({
      autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 30,
            singleClasses: "picker_1",
      locale: {
          cancelLabel: 'Clear',
          format: 'DD/MM/YYYY H:mm'
      }
  });

  $('#time_range').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY H:mm') + ' - ' + picker.endDate.format('DD/MM/YYYY H:mm'));
  });

  $('#time_range').on('cancel.daterangepicker', function(ev, picker) {
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
    var dateToday = dd + '-' + mm + '-' + yyyy;
    $('#time_start').daterangepicker({
      drops: 'down',
      singleDatePicker: true,
      autoUpdateInput: false,
      timePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 30,
      startDate:dateToday,
      minDate:dateToday,
      locale: {      
        format: 'DD-MM-YYYY H:mm'
      },
      singleClasses: "picker_4"
    }, function(start, end, label) {
      // var years = moment().diff(start, 'years');
      // alert("The Employee is " + years+ " Years Old!");

    });
      $('#time_start').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY')+'  at  '+picker.startDate.format('H:mm'));
    });
      $('#time_start').on('cancel.daterangepicker', function(ev, picker) {
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
  var dateToday = dd + '-' + mm + '-' + yyyy;
  $('#time_end').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    timePicker: true,
    timePicker24Hour: true,
    timePickerIncrement: 30,
    startDate:dateToday,
    minDate:dateToday,
    locale: {      
      format: 'DD-MM-YYYY H:mm'
    },
    singleClasses: "picker_4"
  }, function(start, end, label) {
    // var years = moment().diff(start, 'years');
    // alert("The Employee is " + years+ " Years Old!");

  });
    $('#time_end').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY')+'  at  '+picker.startDate.format('H:mm'));
  });
    $('#time_end').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script type="text/javascript">
  

    $('#applyOvertime').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/applyOvertime",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedSubmission').fadeOut('fast', function(){
              $('#resultfeedSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000); 
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

</script>
 @endsection