
@extends('layouts.vertical', ['title' => 'Workforce Management'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

{{-- Deactivated Employess --}}
<div class="card">
  <div class="card-header">
    <h5 class="text-muted mb-0">Employee</h5>
  </div>

  <div class="card-body">
    Deactiveted Employees
  </div>

  <table id="datatable" class="table table-striped table-bordered datatable-basic">
    <thead>
      <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Gender</th>
          <th hidden>empID</th>
          <th>Position</th>
        <th>Linemanager</th>
        <th>Contacts</th>
        <th>Inactive Since</th>
        <th>Options</th>
      </tr>
    </thead>


    <tbody>
      <?php
        foreach ($employee1 as $row) {
          $empid= $row->emp_id; ?>
        <tr id="emp<?php echo $empid; ?>">
          <td width="1px"><?php echo $row->SNo; ?></td>
          <td><a title="More Details"  href="<?php echo  url(''); ?>/flex/userprofile/?id=".$row->emp_id; ?>">
          <font color="blue"><?php echo $row->NAME; ?></font></a></td>
          <td ><?php echo $row->gender; ?></td>
            <td hidden><?php echo $row->emp_id; ?></td>
            <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
          <td><?php echo $row->LINEMANAGER; ?></td>
          <td><?php echo "<b>Email: </b>".$row->email."<br><b>Mobile: </b>".$row->mobile; ?></td>
          <td ><?php echo $row->dated;  ?></td>


          <td class="options-width">
          <?php if($row->isRequested==0){
            if( session('mng_emp')){ ?>
                <a href="javascript:void(0)" title="Request Activation" class="icon-2 info-tooltip" id="reactivate"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
          <?php } } else { ?>
          <div class="col-md-12">
              <span class="label label-primary"> ACTIVATION&nbsp;<br>&nbsp;REQUESTED
              </span></div>
          <?php } ?>

          </td>
          </tr>
        <?php } //} ?>
    </tbody>
  </table>

</div>
{{-- /Deativated Employees --}}

{{-- exit employee --}}
<div class="card">
  <div class="card-body">Exit Employee List</div>

  <table id="datatable-keytable" class="table table-striped table-bordered datatable-basic">
    <thead>
      <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Position</th>
        <th>Linemanager</th>
        <th>Contacts</th>
        <th>Status</th>
        <th>Options</th>
      </tr>
    </thead>

    <tbody>
      <?php
      //if ($employee->num_rows() > 0){
        foreach ($employee2 as $row) {
          $empid= $row->emp_id; ?>
        <tr id="activeRecord<?php echo $row->logID; ?>">
          <td width="1px"><?php echo $row->SNo; ?></td>
          <td><a title="More Details"  href="<?php echo  url('') .'/flex/userprofile/?id='.$row->emp_id; ?>">
          <font color="blue"><?php echo $row->NAME; ?></font></a></td>
          <td ><?php echo $row->gender; ?></td>
          <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
          <td><?php echo $row->LINEMANAGER; ?></td>
          <td><?php echo "<b>Email: </b>".$row->email."<br><b>Mobile: </b>".$row->mobile; ?></td>
          <td >
          <?php if ($row->current_state==1 && $row->log_state==1){  ?>
          <div class="col-md-12">
              <span class="badge bg-success">ACTIVE
              </span></div>
            <?php } elseif($row->current_state==1 && $row->log_state==0){ ?>
          <div class="col-md-12">
              <span class="badge bg-danger">INACTIVE
              </span></div>

            <?php }  if ($row->log_state==2){ ?>
              <div class="col-md-12">
              <span class="badge bg-danger">INACTIVE
              </span></div>
              <?php  } if ($row->log_state=="3"){ ?>
              <div class="col-md-12">
              <span class="badge bg-danger">Exit
              </span></div><?php  } if ($row->log_state=="4"){   } ?>
          </td>


          <td class="options-width">


          <?php if ($row->current_state==0){

          if( session('appr_emp')){

          if ($row->log_state==2){  ?>
          <a href="javascript:void(0)" onclick="activateEmployee(<?php echo $row->logID.','.$row->emp_id; ?>)"  title="Confirm and Activate Employee" class="me-2 text-body">
              <div class="col-md-12">
              <span class="badge bg-success">ACTIVATE
              </span></div></a> <?php }

              if ($row->log_state==3 && ($row->initiator != session('emp_id'))){ ?>
          <a href="javascript:void(0)" onclick="deactivateEmployee(<?php echo $row->logID; ?>,'<?php echo $row->emp_id; ?>')"  title="Confirm exit employee" class="me-2 text-body">
              <button type="button" class="btn btn-success btn-xs"><i class="ph-check"></i></button>
          </a> <?php } }

              if( session('mng_emp')){ ?>
          <a href="javascript:void(0)" onclick="cancelRequest(<?php echo $row->logID; ?>,'<?php echo $row->emp_id; ?>')"  title="Cancel exit" class="me-2 text-body">
              <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
          </a>
          <?php } }  else { ?>
          <div class="col-md-12">
          <span class="label label-primary">comitted
          </span></div><?php  } ?>

              </td>
          </tr>
        <?php } //} ?>
    </tbody>
  </table>
</div>
{{-- /exit employee --}}


{{-- pop up modal --}}
<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content py-4 px-2">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                </div>
                <div class="col-sm-2">

                </div>
            </div>

        </div>
    </div>
</div>
{{-- pop up modal --}}







 @endsection

@push('footer-script')


<script>
  $('#datatable tbody').on('click', '#reactivate', function () {
      let row_data = $('#datatable').DataTable().row($(this).parents('tr')).data();
      requestActivation(row_data[3]);
  });

  function requestActivation(id) {

      const message = "Are you sure you want to activate this employee?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var id = id;

      $("#yes_delete").click(function () {
          $.ajax({
              url:"<?php echo url('flex/employeeActivationRequest');?>/"+id,
              success:function(data)
              {
                  // if(data.status == 'OK'){
                  // alert("SUCCESS");
                  // $('#feedBack').fadeOut('fast', function(){
                  //     $('#feedBack').fadeIn('fast').html(data.message);
                  // });
                  $('#emp'+id).hide();
                  $('#delete').modal('hide');
                  // }else{ }
                  notify('Employee activated successfully!', 'top', 'right', 'success');

                  setTimeout(function() {
                      location.reload();
                  }, 1000);

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  $('#delete').modal('hide');
                  notify('FAILED: Request failed please try again!', 'top', 'right', 'danger');
                  // alert("FAILED: Request failed Please Try again");
                  // alert("Status: " + textStatus); alert("Error: " + errorThrown);
                  setTimeout(function() {
                      location.reload();
                  }, 1000);
              }

          });
      });

  }

  function cancelRequest(id,empID) {

      const message = "Are you sure you want to cancel employee exit?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var id = id;
      var empID = empID;

      $("#yes_delete").click(function () {
          $.ajax({
              url:"<?php echo url('flex/cancelRequest');?>/"+id+"/"+empID,
              success:function(data)
              {
                  if(data.status == 'OK'){
                      // alert("SUCCESS");
                      // $('#feedBackActiveList').fadeOut('fast', function(){
                      //     $('#feedBackActiveList').fadeIn('fast').html(data.message);
                      // });
                      $('#activeRecord'+id).hide();

                      $('#delete').modal('hide');
                      notify('Employee exit cancelled successfully!', 'top', 'right', 'success');

                      setTimeout(function() {
                          location.reload();
                      }, 1000);

                  }else{
                      // alert("FAILED");
                      // $('#feedBackActiveList').fadeOut('fast', function(){
                      //     $('#feedBackActiveList').fadeIn('fast').html(data.message);
                      // });
                      $('#delete').modal('hide');
                      notify('Employee exit cancelled failed!', 'top', 'right', 'danger');
                      setTimeout(function() {
                          location.reload();
                      }, 1000);
                  }

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  alert("FAILED: Request failed Please Try again");
                  // alert("Status: " + textStatus); alert("Error: " + errorThrown);
              }

          });
      });

  }

  function activateEmployee(logID, empID) {
    if (confirm("Are You Sure You Want To Activate This Employee?") == true) {
      // var id = id;

      $.ajax({
          url:"<?php echo url('flex/activateEmployee');?>/"+logID+"/"+empID,
          success:function(data)
          {
            if(data.status == 'OK'){
            alert("SUCCESS");
            $('#feedBackActiveList').fadeOut('fast', function(){
                $('#feedBackActiveList').fadeIn('fast').html(data.message);
              });
            $('#activeRecord'+id).hide();
            }else{
            alert("FAILED");
            $('#feedBackActiveList').fadeOut('fast', function(){
                $('#feedBackActiveList').fadeIn('fast').html(data.message);
              });
            }

          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("FAILED: Activation failed Please Try again");
            // alert("Status: " + textStatus); alert("Error: " + errorThrown);
          }

      });
    }
  }

  function deactivateEmployee(logID, empID) {

      const message = "Are you sure you want to exit this employee?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var logID = logID;
      var empID = empID;

      $("#yes_delete").click(function () {
          $.ajax({
              url:"<?php echo url('flex/deactivateEmployee');?>/"+logID+"/"+empID,
              success:function(data)
              {
                  if(data.status == 'OK'){
                      // alert("SUCCESS");
                      // $('#feedBackActiveList').fadeOut('fast', function(){
                      //     $('#feedBackActiveList').fadeIn('fast').html(data.message);
                      // });
                      // $('#activeRecord'+id).hide();

                      $('#delete').modal('hide');
                      notify('Employee exited successfully!', 'top', 'right', 'success');
                      setTimeout(function() {
                          location.reload();
                      }, 1000);

                  }else{
                      // alert("FAILED");
                      // $('#feedBackActiveList').fadeOut('fast', function(){
                      //     $('#feedBackActiveList').fadeIn('fast').html(data.message);
                      // });

                      $('#delete').modal('hide');
                      notify('Employee exit failed!', 'top', 'right', 'danger');
                      setTimeout(function() {
                          location.reload();
                      }, 1000);
                  }

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  alert("FAILED: Deactivation failed Please Try again");
                  // alert("Status: " + textStatus); alert("Error: " + errorThrown);
              }

          });
      });

  }
</script>

<script>
  function notify(message, from, align, type) {
      $.growl({
          message: message,
          url: ''
      }, {
          element: 'body',
          type: type,
          allow_dismiss: true,
          placement: {
              from: from,
              align: align
          },
          offset: {
              x: 30,
              y: 30
          },
          spacing: 10,
          z_index: 1031,
          delay: 5000,
          timer: 1000,
          animate: {
              enter: 'animated fadeInDown',
              exit: 'animated fadeOutUp'
          },
          url_target: '_blank',
          mouse_over: false,

          icon_type: 'class',
          template: '<div data-growl="container" class="alert" role="alert">' +
              '<button type="button" class="close" data-growl="dismiss">' +
              '<span aria-hidden="true">&times;</span>' +
              '<span class="sr-only">Close</span>' +
              '</button>' +
              '<span data-growl="icon"></span>' +
              '<span data-growl="title"></span>' +
              '<span data-growl="message"></span>' +
              '<a href="#!" data-growl="url"></a>' +
              '</div>'
      });
  }

</script>
@endpush
