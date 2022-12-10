@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')

<?php
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Departments </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Departments</h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                   <div id="feedBackTable"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Cost Center</th>
                          <th>Head Of department</th>

                          <th>Reports To</th>
                          <?php if(session('mng_org')){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($department as $row) { ?> 
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->CostCenterName; ?></td>
                            <td><a title="More Details"  href="<?php echo  url(''); ?>/flex/employee_info/?id=".$row->hod; ?>"><?php echo $row->HOD; ?></a></td>
                            <td><?php echo $row->parentdept; ?></td>

                            <?php if(session('mng_org')){ ?>
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/department_info/?id=".base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                <?php if($row->id!=3){ ?>
                                <a href="javascript:void(0)" onclick="deleteDepartment(<?php echo $row->id; ?>)" title="Delete Department" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                                <?php } ?>
                            </td>
                            <?php } ?>
                           </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="row">
                      <div class="col-sm-10">
                        <h2> Disabled Departments</h2>

                      </div>
                      <div class="col-sm-2">
                        <?php if(session('mng_org')){ ?>
                          <a href="#bottom"><button type="button" id="modal" data-toggle="modal" data-target="#departmentModal" class="btn btn-primary">Add New</button></a>
                          <?php } ?>
                      </div>
                    </div>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                   <div id="feedBackTable2"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Head Of department</th>
                          <th>Reports To</th>
                          <?php if(session('mng_org')){ ?>
                          <th>Option</th>
                          <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($inactive_department as $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><a title="More Details"  href="<?php echo  url(''); ?>/flex/employee_info/?id=".$row->hod; ?>"><?php echo $row->HOD; ?></a></td>
                            <td><?php echo $row->parentdept; ?></td>
                            <?php if(session('mng_org')){ ?>
                            <td class="options-width">
                                <a href="<?php echo  url(''); ?>/flex/department_info/?id=".base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                <?php if($row->id!=3){ ?>
                                <a href="javascript:void(0)" onclick="activateDepartment(<?php echo $row->id; ?>)" title="Activate Department" class="icon-2 info-tooltip"><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i></button> </a>
                                <?php } ?>
                            </td>
                                <?php } ?>
                           </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <?php if(session('mng_org')){ ?>
               <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2><i class="fa fa-tasks"></i> Add Department</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                      <div id="feedBack"></div>
                        <form autocomplete="off" id="departmentAdd" enctype="multipart/form-data"  method="post"  data-parsley-validate class="form-horizontal form-label-left">

                          <!-- START -->
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Department Name</label>
                            </label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                              <textarea required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Department Name" rows="2"></textarea>
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Cost Center</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="cost_center_id" class="select4_single form-control" tabindex="-1">
                            <option></option>
                               <?php  foreach ($cost_center as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Head of Department</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="hod" class="select4_single form-control" tabindex="-1">
                            <option></option>
                               <?php  foreach ($employee as $row) {
                                 # code... ?>
                              <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3  col-xs-6" >Reports To</label>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                            <select required="" name="parent" class="select3_single form-control" tabindex="-1">
                            <option></option>
                               <?php  foreach ($parent_department as $row) {  ?>
                              <option value="<?php echo $row->id."|".$row->department_pattern."|".$row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                            </div>
                          </div>
                          <!-- END -->
                          <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                              <input type="submit"  value="ADD" name="add" class="btn btn-primary"/>
                            </div>
                          </div>
                          </form>

                      </div>
                    </div>
                </div>
               <?php } ?>
            </div>
          </div>
        </div>

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




        <!-- /page content -->



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

<script type="text/javascript">
    $('#departmentAdd').submit(function(e){
        e.preventDefault();

             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/departmentAdd",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             }).done(function(data){

          notify('Department added successfuly!', 'top', 'right', 'success');

         // $('#feedBack').fadeOut('fast', function(){
         //      $('#feedBack').fadeIn('fast').html(data);
         //    });
          setTimeout(function(){// wait for 2 secs(2)
                location.reload(); // then reload the page.(3)
            }, 2000);
    //   $('#updateMiddleName')[0].reset();
            }).fail(function(){
              alert('Request Failed!! ...');
            });
    });
</script>
<script> //For Deleting records without Page Refreshing

    function deleteDepartment(id)
    {
      const message = "Are you sure you want to delete this department?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var id = id;
      $("#yes_delete").click(function(){
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/deleteDepartment');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              // alert("Record Deleted Sussessifully!");
              $('#domain'+id).hide();
              $('#delete').modal('hide');

              notify('Department deleted successfuly!', 'top', 'right', 'success');
              // $('#feedBackTable').fadeOut('fast', function(){
              // $('#feedBackTable').fadeIn('fast').html(data.message);
            // });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
                $('#delete').modal('hide');
                notify('Department not deleted!', 'top', 'right', 'danger');
              // alert("Property Not Deleted, Error In Deleting");
               }

            }

            });
      });
        // if (confirm("Are You Sure You Want To Delete This Department") == true) {
        //
        // }
    }

    function activateDepartment(id)
    {
      const message = "Are you sure you want to activate this department?";
      $('#delete').modal('show');
      $('#delete').find('.modal-body #message').text(message);

      var id = id;
      $('#yes_delete').click(function() {
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/activateDepartment');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              // alert("Record Deleted Sussessifully!");
              $('#domain'+id).hide();
              $('#delete').modal('hide');
              notify('Department activated successfuly!', 'top', 'right', 'success');

            //   $('#feedBackTable2').fadeOut('fast', function(){
            //   $('#feedBackTable2').fadeIn('fast').html(data.message);
            // });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
                $('#delete').modal('hide');
                notify('Department not deleted!', 'top', 'right', 'warning');
              // alert("Property Not Deleted, Error In Deleting");
               }

            // document.location.reload();

            }

            });
      });

    }
</script>

 @endsection