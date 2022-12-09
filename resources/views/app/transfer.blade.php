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
   $CI_Model = $this->load->model('flexperformance_model');
  ?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Approvals </h3>
              </div>
            </div>
            <div class="clearfix"></div>
              <div class="">
                  <!-- Tabs -->
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                          <div class="x_title">
                              <h2><i class="fa fa-bars"></i> Pending Approval <small></small></h2>
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
                                      <li role="presentation" class="active"><a href="#transferTab"  id="home-tab" role="tab"  data-toggle="tab" aria-expanded="true">Changes</a>
                                      </li>
                                      <li role="presentation" class=""><a href="#registrationTab" id="profile-tab" role="tab" data-toggle="tab" aria-expanded="false">Registration</a>
                                      </li>

                                  </ul>

                                  <div id="myTabContent" class="tab-content">
                                      <div role="tabpanel" role="tabpanel" class="tab-pane fade active in" id="transferTab" aria-labelledby="home-tab">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                              <div class="x_panel">
                                                  <div class="x_title">
                                                      <h2>Current Employee Tranfer
                                                      </h2>

                                                      <div class="clearfix"></div>
                                                  </div>
                                                  <div class="x_content">

                                                      @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                                      <div id="resultFeedback"></div>
                                                      <table id="datatable" class="table table-striped table-bordered">
                                                          <thead>
                                                          <tr>
                                                              <th>S/N</th>
                                                              <th>Name</th>
                                                              <th>Department</th>
                                                              <th>Transfer Attribute</th>
                                                              <th>Destination</th>
                                                              <th>Status</th>
                                                              <th>Option</th>

                                                          </tr>
                                                          </thead>


                                                          <tbody>
                                                          <?php
                                                          foreach ($transfers as $row) {
                                                              if($row->status==1 || $row->status>=5) continue; ?>
                                                              <tr>
                                                                  <td width="1px"><?php echo $row->SNo; ?></td>
                                                                  <td><?php  echo $row->empName; ?></td>
                                                                  <td><?php echo "<b>DEPARTMENT:</b> ".$row->department_name."<br><b>POSITION: </b>".$row->position_name; ?></td>

                                                                  <td><?php echo $row->parameter; ?></td>

                                                                  <td> <?php
                                                                      if($row->parameterID==1){
                                                                          if(session('mng_paym') ){
                                                                              echo "<b>FROM: </b> ".number_format($row->old,2)."/=<br><b>TO: </b>".number_format($row->new,2)."/=";
                                                                          }
                                                                      }elseif ($row->parameterID==2) {
                                                                          echo $this->flexperformance_model->newPositionTransfer($row->new);
                                                                      }elseif ($row->parameterID==3) {
                                                                          echo "<b>DEPARTMENT:</b> ".$this->flexperformance_model->newDepartmentTransfer($row->new)."<br><b>POSITION: </b>".$this->flexperformance_model->newPositionTransfer($row->new_position);
                                                                      }elseif ($row->parameterID==4) {
                                                                          echo "<b>BRANCH:</b> ".$this->flexperformance_model->newBranchTransfer($row->new_department)."<br><b>DEPARTMENT:</b> ".$this->flexperformance_model->newDepartmentTransfer($row->new_department)."<br><b>POSITION: </b>".$this->flexperformance_model->newPositionTransfer($row->new_position);
                                                                      } ?>

                                                                  </td>
                                                                  <td>

                                                                      <div id ="status<?php echo $row->id; ?>">
                                                                          <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php }
                                                                          elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-success">ACCEPTED</span></div><?php }
                                                                          elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-danger">REJECTED</span></div><?php } ?>
                                                                      </div>

                                                                  </td>

                                                                  <td class="options-width">
                                                                      <a href="<?php echo url(); ?>flex/userprofile/?id=".$row->empID; ?>" title="Employee Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                                                                      <?php if($row->status==0){ ?>

                                                                          <a href="javascript:void(0)" onclick="disapproveRequest(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>

                                                                          <?php if($row->parameterID==1){
                                                                              if(session('mng_paym')){  ?>
                                                                                  <a href="javascript:void(0)" onclick="approveSalaryTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                                              <?php } } elseif($row->parameterID==2){ ?>
                                                                              <a href="javascript:void(0)" onclick="approvePositionTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                                          <?php }elseif($row->parameterID==3){ ?>
                                                                              <a href="javascript:void(0)" onclick="approveDeptPosTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>

                                                                          <?php }elseif($row->parameterID==4){ ?>
                                                                              <a href="javascript:void(0)" onclick="approveBranchTransfer(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                                          <?php } } ?>
                                                                  </td>

                                                              </tr>

                                                          <?php } //} ?>
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div role="tabpanel" role="tabpanel" class="tab-pane fade" id="registrationTab" aria-labelledby="home-tab">
                                          <div class="col-md-12 col-sm-12 col-xs-12">
                                              <div class="x_panel">
                                                  <div class="x_title">
                                                      <h2>Current Employee Registered
                                                      </h2>

                                                      <div class="clearfix"></div>
                                                  </div>
                                                  <div class="x_content">

                                                      @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                                                      <div id="resultFeedback"></div>
                                                      <table id="datatable1" class="table table-striped table-bordered">
                                                          <thead>
                                                          <tr>
                                                              <th>S/N</th>
                                                              <th>Name</th>
                                                              <th>Department</th>
                                                              <th>Description</th>
                                                              <th>Status</th>
                                                              <th>Option</th>

                                                          </tr>
                                                          </thead>
                                                          <tbody>
                                                          <!--status 7 = cancelled, status 6 = accepted-->
                                                          <?php
                                                          foreach ($transfers as $row) {
                                                              if($row->status<5 || $row->status > 5 ) continue; ?>
                                                              <tr>
                                                                  <td width="1px"><?php echo $row->SNo; ?></td>
                                                                  <td><?php  echo $row->empName; ?></td>
                                                                  <td><?php echo "<b>DEPARTMENT:</b> ".$row->department_name."<br><b>POSITION: </b>".$row->position_name; ?></td>
                                                                    <td><?php echo $row->parameter; ?></td>
                                                                  <td>
                                                                      <div id ="status<?php echo $row->id; ?>">
                                                                          <?php if($row->status==5){ ?> <div class="col-md-12"><span class="label label-default">WAITING</span></div><?php }
                                                                          elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-success">ACCEPTED</span></div><?php }
                                                                          elseif($row->status==7){ ?><div class="col-md-12"><span class="label label-danger">REJECTED</span></div><?php } ?>
                                                                      </div>
                                                                  </td>
                                                                  <td class="options-width">
                                                                      <a href="<?php echo url(); ?>flex/userprofile/?id=".$row->empID; ?>" title="Employee Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                                                                      <?php if($row->status==5){ ?>

                                                                          <a href="javascript:void(0)" onclick="disapproveRegistration(<?php echo $row->id; ?>)" title="Reject" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a>

                                                                          <?php if($row->parameterID==5){
                                                                              if(session('mng_paym')){  ?>
                                                                                  <a href="javascript:void(0)" onclick="approveRegistration(<?php echo $row->id; ?>)" title="Accept" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                                                              <?php } } }?>
                                                                  </td>
                                                              </tr>

                                                          <?php } //} ?>
                                                          </tbody>
                                                      </table>
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
        </div>
        <!-- /page content -->






<script>

    $('#datatable1').DataTable();

  function approveDeptPosTransfer(id){
    if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
    var id = id;
    $.ajax({
        url:"<?php echo url('flex/approveDeptPosTransfer');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);


        }

        });
    }
  }
  function approveSalaryTransfer(id){
    if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
    var id = id;
    $.ajax({
        url:"<?php echo url('flex/approveSalaryTransfer');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);


        }

        });
    }
  }
  function approvePositionTransfer(id){
    if (confirm("Are You Sure You Want To Approve This Transfer(The Action may be Irreversible) ?Requirement") == true) {
    var id = id;
    $.ajax({
        url:"<?php echo url('flex/approvePositionTransfer');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);


        }

        });
    }
  }
  function disapproveRequest(id){
    if (confirm("Are You Sure You Want To CANCEL/DELETE This Transfer(The Action may be Irreversible) ?Requirement") == true) {
    var id = id;
    $.ajax({
        url:"<?php echo url('flex/cancelTransfer');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);


        }

        });
    }
  }

  function disapproveRegistration(id) {
      if (confirm("Are you sure you want to disapprove this registration ") == true) {
          var id = id;
          $.ajax({
              url:"<?php echo url('flex/disapproveRegistration');?>/"+id,
              success:function(data)
              {
                  $('#resultFeedback').fadeOut('fast', function(){
                      $('#resultFeedback').fadeIn('fast').html(data);
                  });
                  setTimeout(function(){// wait for 5 secs(2)
                      location.reload(); // then reload the page.(3)
                  }, 1000);


              }

          });
      }

  }

  function approveRegistration(id) {
      if (confirm("Are you sure you want to confirm this registration ") == true) {
          var id = id;
          $.ajax({
              url:"<?php echo url('flex/approveRegistration');?>/"+id,
              success:function(data)
              {
                  $('#resultFeedback').fadeOut('fast', function(){
                      $('#resultFeedback').fadeIn('fast').html(data);
                  });
                  setTimeout(function(){// wait for 5 secs(2)
                      location.reload(); // then reload the page.(3)
                  }, 1000);


              }

          });
      }
  }

</script>
 @endsection