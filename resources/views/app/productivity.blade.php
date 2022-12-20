
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
  //$CI_Model = get_instance();
  $CI_Model->load->model('performance_model');
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Performance and Productivity </h3>
                <h4>From <b><?php echo $date_from; ?></b> To <b><?php echo $date_to; ?></b> </h4>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

              <!-- Chart -->
                <div class="card">
                  <div class="card-head">
                    <h2>Performance &nbsp;&nbsp;&nbsp;&nbsp;
                    <a><button type="button" id="modal" data-toggle="modal" data-target="#performanceModal" class="btn btn-success">Custom Performance</button></a>
                     &nbsp;&nbsp;&nbsp;&nbsp;</a></h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                    <!-- <div id="mainb" style="height:450px;"></div> -->

                  </div>
                </div>
              <!-- Chart -->
                   <!-- PANEL-->
                <div class="card">
                  <div class="card-head">
                    <h2>Employee Key Performance Indicator(KPI)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                    
                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/reports/kpi"  data-parsley-validate class="form-horizontal form-label-left" target="_blank">
                      <div class="form-group">
                        <label class="control-label col-md-3  col-xs-6" >Select Employee</label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                 <select name="empID" required="" class="select4_single form-control" tabindex="-1">
                                 <option></option>
                                   <?php
                                  foreach ($employee as $row) {
                                     # code... ?>
                                  <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                                 </select>
                                <span class="input-group-btn">
                                  <button  class="btn btn-main">SHOW KPI</button>
                                </span>
                            </div>
                        </div>
                      </div>
                    </form>

                  </div>
                </div>
                <!--PANEL-->
                
                <div class="card">
                  <div class="card-head">
                    <h2>Individual Performance <button type="button" id="modal" data-toggle="modal" data-target="#indProdModal" class="btn btn-main">PRINT REPORT</button>
                    </h2>
                    

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>

                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Employee No.</th>
                          <th>Department</th>
                          <th>Number Of Tasks</th>
                          <th>Average Score</th>
                          <th>Performance and Rating</th>
                          <th>Employment Cost</th>
                          <th>Productivity</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($emp_prod as $row) { ?>
                          <tr id="domain<?php echo $row->name;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td width="1px"><?php echo $row->empID; ?></td>
                            <td><a title="More Details"  href="<?php echo  url('')."flex/performance/userprofile/?id=".$row->empID; ?>"><?php echo $row->name; ?></a></td>
                            <td>Department:  <b> <?php echo $row->department."</b><br>Position: <b> ".$row->position;?></b></td>
                            <td><?php echo $row->number_of_tasks; ?></td>

                            <td><?php echo $row->scores; ?></td> 


                            <td><?php                            
                            $avgScore = number_format($row->scores,1);
                            $category_rating = $CI_Model->performance_model->category_rating($avgScore);
                            foreach ($category_rating as $value) {
                              $category = $value->id;
                              $rating = $value->title;
                            }


                              if ($category==1 ) { ?>
                              <div class="col-md-12"> <span class="label label-success">
                                
                              <?php }  if ( $category==2) { ?>
                              <div class="col-md-12"> <span class="label label-primary">

                                <?php   }  if ( $category==3) { ?>
                              <div class="col-md-12"> <span class="label label-info">

                                <?php } if ( $category==4) { ?>
                              <div class="col-md-12"> <span class="label label-warning">

                                <?php  } if ($category==5) { ?>
                              <div class="col-md-12"> <span class="label label-danger">

                                <?php  }  
                                echo $rating ?> </span> </div>
                          </td>
                            <td><?php echo number_format($row->employment_cost,2); ?></td>

                            <td> <?php 
                            $allDays = $row->payroll_days;
                            $all_employment_cost = $row->employment_cost;

                            $daily_cost = $all_employment_cost/$allDays;
                            $total_input_cost = $row->duration_time * $daily_cost;
                            $total_output_cost = $row->monetary_value;
                            $productivity =  $total_output_cost-$total_input_cost;

                            echo number_format($productivity,2);


                            ?></td>

                            <td  class="options-width">
                            <?php
                            $selected = $this->performance_model->selectedTalents($row->empID);
                              if ($selected==0) { ?>

                              <a href="javascript:void(0)" onclick="selectValue(<?php echo $row->empID; ?>, <?php echo $row->scores; ?> );" title="Delete" >
                            <button type="button"  class="btn btn-info btn-xs">SELECT</button></a>
                                
                              <?php  }  ?>

                            </td> 
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>Department Level Performance </h2>

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
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Department Name</th>
                          <th>Employment Cost</th>
                          <th>Number Of Tasks</th>
                          <th>Productivity</th>

                          <th>Productivity to WorkForce Ratio</th>
                          <th>Avg Score</th>
                          <th>Avg Performance Rating</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($dept_prod as $row) { ?>
                          <tr id="">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><b> <?php echo $row->department."</b>";?></b></td>
                            <td width="1px"><?php echo number_format($row->employment_cost,2); ?></td>
                            <td><?php echo $row->task_counts;?></td>

                            <td> <?php 
                            $allDays = $row->payroll_days;
                            $all_employment_cost = $row->employment_cost;

                            $daily_cost = $all_employment_cost/$allDays;
                            $total_input_cost = $row->duration * $daily_cost;
                            $total_output_cost = $row->time_cost;
                            $productivity =  $total_output_cost-$total_input_cost;

                            echo number_format($productivity,2);
                            ?>
                            </td>
                            <td> <?php echo number_format(($productivity/$row->headcounts),2); ?></td>
                            <td> <?php echo number_format(($row->score/$row->headcounts),1); ?> </td>
                            <td><?php
                            $avgScore = number_format(($row->score/$row->headcounts),1);
                            $category_rating = $CI_Model->performance_model->category_rating($avgScore);
                            foreach ($category_rating as $value) {
                              $category = $value->id;
                              $rating = $value->title;
                            }

                            
                            // echo "CATEGORY:= ".$category ."<br>RATING:= ".$rating;


                              if ($category==1 ) { ?>
                              <div class="col-md-12"> <span class="label label-success">
                                
                              <?php }  if ( $category==2) { ?>
                              <div class="col-md-12"> <span class="label label-primary">

                                <?php   }  if ( $category==3) { ?>
                              <div class="col-md-12"> <span class="label label-info">

                                <?php   }  if ( $category==4) { ?>
                              <div class="col-md-12"> <span class="label label-warning">

                                <?php  } if ($category==5) { ?>
                              <div class="col-md-12"> <span class="label label-danger">

                                <?php  }  
                                echo $rating ?> </span> </div>
                          </td>
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>Organization Level Performance</h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Employment Cost</th>
                          <th>Number Of Tasks</th>
                          <th>Productivity</th>
                          <th>Productivity to WorkForce Ratio</th>
                          <th>Avg Score</th>
                          <th>Avg Performance Rating</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php

                          foreach ($org_prod as $row) { ?>
                          <tr id="">
                            <td width="1px"><?php echo number_format($row->employment_cost,2); ?></td>
                            <td><?php echo $row->task_counts;?></td>

                            <td> <?php 
                            $allDays = $row->payroll_days;
                            $all_employment_cost = $row->employment_cost;

                            $daily_cost = $all_employment_cost/$allDays;
                            $total_input_cost = $row->duration * $daily_cost;
                            $total_output_cost = $row->time_cost;
                            $productivity =  $total_output_cost-$total_input_cost;

                            echo number_format($productivity,2);
                            ?>
                            </td>
                            <td> <?php echo number_format(($productivity/$row->headcounts),2); ?></td>
                            <td> <?php echo number_format(($row->score/$row->headcounts),1); ?> </td>
                            <td><?php
                            $avgScore = number_format(($row->score/$row->headcounts),1);
                            $category_rating = $CI_Model->performance_model->category_rating($avgScore);
                            foreach ($category_rating as $value) {
                              $category = $value->id;
                              $rating = $value->title;
                            }

                            

                              if ($category==1 ) { ?>
                              <div class="col-md-12"> <span class="label label-success">
                                
                              <?php }  if ( $category==2) { ?>
                              <div class="col-md-12"> <span class="label label-primary">

                                <?php   }  if ( $category==3) { ?>
                              <div class="col-md-12"> <span class="label label-info">

                                <?php   }  if ( $category==4) { ?>
                              <div class="col-md-12"> <span class="label label-warning">

                                <?php  } if ($category==5) { ?>
                              <div class="col-md-12"> <span class="label label-danger">

                                <?php  }  
                                echo $rating ?> </span> </div>
                          </td>
                            </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- General Modal -->
                <div class="modal fade" id="performanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Performance and Productivity Report</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" autocomplete="off" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/performance/productivity"  data-parsley-validate class="form-horizontal form-label-left">
                        

                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" name="start" class="form-control col-xs-12 has-feedback-left" id="single_cal1"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="has-feedback">
                          <input type="text" name="end" class="form-control col-xs-12 has-feedback-left" id="single_cal2"  aria-describedby="inputSuccess2Status">
                          <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                        </div>
                      </div> 

                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <input type="submit"  value="SHOW" name="show" class="btn btn-main"/>
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



        <!-- General Modal -->
                <div class="modal fade" id="indProdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Performance and Productivity Report</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" autocomplete="off" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/performance/productivity_report" target="_blank" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From
                            </label>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                              <div class="has-feedback">
                              <input type="text" name="start" placeholder="From Date" class="form-control col-xs-12 has-feedback-left" required="" id="ind_startDate"  aria-describedby="inputSuccess2Status">
                              <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </div>
                          </div> 
    
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="has-feedback">
                              <input type="text" name="end" required="" placeholder="To Date" class="form-control col-xs-12 has-feedback-left" id="ind_endDate"  aria-describedby="inputSuccess2Status">
                              <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </div>
                          </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Department
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="has-feedback">
                                <select required=""  name="deptID" class="form-control">
                            <option value="0">All Department</option>
                               <?php foreach ($departments as $key){ ?>
                              <option value="<?php echo $key->deptID; ?>"><?php echo $key->name; ?></option> <?php } ?>
                            </select>
                            </div>
                            </div>
                          </div>   
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="containercheckbox"> Employee Report 
                               <input checked="" type="checkbox" name="employee" value="1">
                                <span class="checkmark"></span>
                              </label>
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="containercheckbox"> Department Report  
                               <input checked="" type="checkbox" name="department" value="1">
                                <span class="checkmark"></span>
                              </label>
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                               <label class="containercheckbox"> Organization Report 
                               <input checked="" type="checkbox" name="organization" value="1">
                                <span class="checkmark"></span>
                              </label>
                            </div>
                          </div>                    
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                              <input type="submit"  value="PRINT" name="print" class="btn btn-main"/>
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

<?php  ?>
<script type="text/javascript">
  function selectValue(empID, score)
{
  // if (document.getElementById('choose').checked) 
  // {
    $.ajax({
        url:"<?php echo url('flex/performance/selectTalent');?>/"+empID+"/"+score,
        success:function(data)
        {
          // success :function(result){
          // $('#alert').show();

          if(data.status == 1){
          alert("SECCESS :"+data.message);
          location.reload()
          }else{
          alert("Error: "+data.message);
           }
       
        // $('#domain'+id).hide();
        // document.location.reload();
           
        }
               
      });
      // alert("The SELECTED IS "+empID);//document.getElementById('totalCost').value = 10;
  //} 
  /*else {
      alert("Unselected "+empID);//calculate();
  }*/
}
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
  $('#ind_startDate').daterangepicker({
    drops: 'down',
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
    $('#ind_startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#ind_startDate').on('cancel.daterangepicker', function(ev, picker) {
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
  $('#ind_endDate').daterangepicker({
    drops: 'down',
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
    $('#ind_endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#ind_endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>
 @endsection