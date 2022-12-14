@extends('layouts.vertical', ['title' => 'Settings'])

@push('head-script')
  <script src="{{ asset('assets/js/components/notifications/bootbox.min.js') }}></script>
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/components_modals.js') }}"></script>
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')


  <div class="col-md-12 col-lg-12 col-sm-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3 class="text-muted lead">
            Financial Groups <br> <small>Allowances, Bonuses and Deductions</small>
          </h3>

          <a>
            <button type="button" id="modal" data-toggle="modal" data-bs-target="#save_department" class="btn btn-main">
              <i class="ph-plus me-2"></i> New Group
            </button>
          </a>
        </div>
      </div>

      <table  class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <?php if($pendingPayroll==0 && session('mng_roles_grp')){ ?>
            <th>Option</th>
            <?php } ?>
          </tr>
        </thead>


        <tbody>
          <?php
            foreach ($financialgroups as $row) { ?>
            <tr id = "recordFinanceGroup<?php echo $row->id; ?>">
              <td width="1px"><?php echo $row->SNo; ?></td>
              <td><?php echo $row->name; ?></td>
              <?php if($pendingPayroll==0 && session('mng_roles_grp')){ ?>
              <td class="options-width">
              <?php if($row->type>0){ ?>

              <a  href="<?php echo  url(''); ?>/flex/groups/?id=<?php echo base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button> </a>

             <a href="javascript:void(0)" onclick="deleteFinanceGroup(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button> </a>
             <?php } ?>
              </td>
               <?php } ?>
              </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  {{-- /col --}}
</div>




 
            
        <!-- Finencial Group Modal -->
        <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Finencial Based-Group of Employees</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Group Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php // echo form_error("fname");?></span>
                          </div>
                      </div>

                            <input type="text" hidden name="type"value = "1">


                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-primary"/>
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

      
        <!-- Modal -->
        <?php if( session('mng_roles_grp')){ ?>
        <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Role</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role Name
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php // echo form_error("fname");?></span>
                          </div>
                      </div>


                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addrole" class="btn btn-primary"/>
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

       


        <!--Roles Group Modal-->
        <div class="modal fade" id="rolesgroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="myModalLabel">Create New Role Based Group of Employees</h4>
                </div>
                  <div class="modal-body">
                          <!-- Modal Form -->
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/role"  data-parsley-validate class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Group Name
                          </label>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                            <span class="text-danger"><?php // echo form_error("fname");?></span>
                          </div>
                      </div>

                            <input type="text" hidden name="type"  value ="2">

                      <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-primary"/>
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
        <?php } ?>
        <!--Roles Group Modal-->

         


        <!-- /page content -->


@endsection


@section('modal')
<div>
  @include('app.modal.add-role-group')
</div>
@include('app.modal.add-role')
@endsection


@push('footer-script')

<script type="text/javascript">

  function deleteRole(id)
    {
          if (confirm("Are You Sure You Want To Delete This Role?") == true) {
          var id = id;

          $.ajax({
              url:"<?php echo url('flex/deleteRole');?>/"+id,
              success:function(data)
              {
                if(data.status == 'OK'){
                alert("DELETED Successifully");
                 $('#feedBackRole').fadeOut('fast', function(){
                    $('#feedBackRole').fadeIn('fast').html(data.message);
                  });
                $('#recordRole'+id).hide();
                }else{
                alert("FAILED: Delete failed Please Try again");
                }



              }

              });
          }
      }



  function deleteRoleGroup(id)
      {
          if (confirm("Are You Sure You Want To Delete This Group?") == true) {
          var id = id;

          $.ajax({
              url:"<?php echo url('flex/deleteGroup');?>/"+id,
              success:function(data)
              {
                if(data.status == 'OK'){
                alert("Group DELETED Successifully");
                 $('#feedBackRoleGroup').fadeOut('fast', function(){
                    $('#feedBackRoleGroup').fadeIn('fast').html(data.message);
                  });
                $('#recordRoleGroup'+id).hide();
                }else{
                alert("FAILED: Delete failed Please Try again");
                }



              }

              });
          }
      }


  function deleteFinanceGroup(id)
      {
          if (confirm("Are You Sure You Want To Delete This Group?") == true) {
          var id = id;

          $.ajax({
              url:"<?php echo url('flex/deleteGroup');?>/"+id,
              success:function(data)
              {
                if(data.status == 'OK'){
                alert("Group DELETED Successifully");
                 $('#feedBackFinanceGroup').fadeOut('fast', function(){
                    $('#feedBackFinanceGroup').fadeIn('fast').html(data.message);
                  });
                $('#recordFinanceGroup'+id).hide();
                }else{
                alert("FAILED: Delete failed Please Try again");
                }



              }

              });
          }
      }


  </script>
@endpush

