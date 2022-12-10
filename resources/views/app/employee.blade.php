
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


        <?php if(session('mng_emp') || session('vw_emp') || session('appr_emp')){  ?> 

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Employees </h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                      <div class="row">
                          <div class="col-md-9">
                              <h2>List of Employees </h2>
                          </div>
                          <div class="col-md-3">
                              <?php  if( session('mng_emp')){ ?>

                                  <a href="<?php echo  url(''); ?>/flex/addEmployee"><button type="button" class="btn btn-primary">Register New Employee</button></a>

                                  <!-- <a href="<?php echo  url(''); ?>/flex/appreciation"><button type="button" class="btn btn-success"><i class="fa fa-user"></i>&nbsp; Employee Of The Month</button></a> <?php //} ?>
                    -->
                              <?php } ?>
                          </div>
                      </div>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
<!--                   --><?php //echo $this->session->flashdata("note");  ?>
                   <div id="feedBack"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Name</th>
                          <th>Gender</th>
                          <th>Position</th>
                          <th>Linemanager</th>
                          <th>Contacts</th>
                          <th>Options</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($employee as $row) { 
                            $empid= $row->emp_id; ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><a title="More Details"  href="<?php echo  url(''); ?>/flex/userprofile/?id=".$row->emp_id; ?>">
                            <font color="blue"><?php echo $row->NAME; ?></font></a></td>
                            <td ><?php echo $row->gender; ?></td>
                            <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                            <td><?php echo $row->LINEMANAGER; ?></td>
                            <td><?php echo "<b>Email: </b>".$row->email."<br><b>Mobile: </b>".$row->mobile; ?></td>
                            

                            <td class="options-width">
                                <a  href="<?php echo  url(''); ?>/flex/userprofile/?id=".$row->emp_id; ?>"  title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                
                                <?php if( session('mng_emp')){ ?>
                                <a href="javascript:void(0)" onclick="requestDeactivation('<?php echo $row->emp_id; ?>')"  title="Deactivate" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i></button> </a>

                                <a href="<?php echo  url(''); ?>/flex/updateEmployee/?id=".$row->emp_id."|".$row->department; ?>" title="Update" class="icon-2 info-tooltip"><button type="button" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button> </a>
                                <a href="<?php echo  url('')."flex/project/evaluateEmployee/?id=".$row->emp_id."|".$row->department; ?>" title="Update" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="">Evaluate</i></button> </a>
                                <?php } ?>
                            </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->
        <?php } ?>


    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
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



<script>

  function requestDeactivation(id) {

      const message = "Are you sure you want to deactivate this employee?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var id = id;

      $("#yes_delete").click(function () {
          $.ajax({
              url:"<?php echo url('flex/employee_exit');?>/"+id,
              success:function(data)
              {
                  // console.log(data);
                  // if(data.status == 'OK'){
                  // alert("SUCCESS");
                  // $('#feedBack').fadeOut('fast', function(){
                  //     $('#feedBack').fadeIn('fast').html(data.message);
                  // });
                  // }else{ }

                  $('#delete').modal('hide');
                  notify('Employee deactivated successfully!', 'top', 'right', 'success');
                  setTimeout(function() {
                      location.reload();
                  }, 1000);

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  // alert("FAILED: Delete failed Please Try again");
                  // alert("Status: " + textStatus); alert("Error: " + errorThrown);

                  $('#delete').modal('hide');
                  notify('Department not deleted!', 'top', 'right', 'danger');
                  setTimeout(function() {
                      location.reload();
                  }, 1000);

              }

          });
      });
    // if (confirm("Are You Sure You Want To Delete This Employee?") == true) {
    //   var id = id;
    //
    //     //index.php/cipay/employeeDeactivationRequest
    //     // index.php/cipay/employee_exit
    //
    // }
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


    function run(){
        alert("hello world");
    }

    <?php if ($this->session->flashdata("note")){
        echo "notify('Employee state changed successfuly!!', 'top', 'right', 'success');";

    } ?>


</script>

 @endsection