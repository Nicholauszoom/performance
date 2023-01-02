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

<div class="row">

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
            <h3 class="text-muted">Roles and Permission Groups</h3>

            @if (session('mng_roles_grp'))
            <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#add-role-group">
              <i class="ph-plus me-2"></i>New Group
          </button>
            @endif
        </div>
      </div>

      <table  class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            @if( session('mng_roles_grp'))
            <th>Option</th>
            @endif
          </tr>
        </thead>

        <tbody>
          <?php foreach ($rolesgroups as $row) { ?>
            <tr id = "recordRoleGroup<?php echo $row->id; ?>">
              <td width="1px"><?php echo $row->SNo; ?></td>
              <td>{{ $row->name}}</td>
              <?php if( session('mng_roles_grp')){ ?>
                <td class="options-width">
                  <?php if($row->type>0){ ?>
                    <a  href="<?php echo  url('').'/flex/groups/?id='.base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip">
                      <button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button>
                    </a>

                    <a href="javascript:void(0)" onclick="deleteRoleGroup(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip">
                      <button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button>
                    </a>
                  <?php }  ?>
                </td>
              <?php }  ?>
            </tr>
          <?php }  ?>
        </tbody>
      </table>

    </div>
  </div>
  {{-- /col --}}

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <h3 class="text-muted">Roles </h3>

          @if (session('mng_roles_grp'))
          <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#add-role">
            <i class="ph-plus me-2"></i>New Role
        </button>
          @endif
        </div>
      </div>

      <table  class="table table-bordered">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <?php if( session('mng_roles_grp')){ ?>
            <th>Option</th>
          <?php } ?>
          </tr>
        </thead>


        <tbody>
          <?php
          // if ($department->num_rows() > 0){
            foreach ($role as $row) { ?>
            <tr id = "recordRole<?php echo $row->id; ?>">
              <td width="1px"><?php echo $row->SNo; ?></td>
              <td><?php echo $row->name; ?></td>


                @if ( session('mng_roles_grp') )
                <td class="options-width">
                  <a  href="<?php echo  url('') .'/flex/role_info/?id='.base64_encode($row->id); ?>"  title="Info and Details" class="icon-2 info-tooltip">
                    <button type="button" class="btn btn-info btn-xs"><i class="ph-info"></i></button>
                  </a>

                  <a href="javascript:void(0)" onclick="deleteRole(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip">
                    <button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button>
                  </a>
              </td>
                @endif


              </tr>
            <?php } //} ?>
        </tbody>
      </table>
    </div>
  </div>
  {{-- /col --}}





  {{-- /col --}}
</div>









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
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="{{ route('flex.role') }}"  data-parsley-validate class="form-horizontal form-label-left">
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
                            <input type="submit"  value="Add" name="addrole" class="btn btn-main"/>
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
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="{{ route('flex.role') }}"  data-parsley-validate class="form-horizontal form-label-left">
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
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-main"/>
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
                    <form autocomplete="off" id="demo-form2" enctype="multipart/form-data"  method="post" action="{{ route('flex.role') }}"  data-parsley-validate class="form-horizontal form-label-left">
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
                            <input type="submit"  value="Add" name="addgroup" class="btn btn-main"/>
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

  <div>
    @include('app.modal.add-role')
  </div>

  <div>
    @include('app.modal.finance-group')
  </div>
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
                var data = JSON.parse(data);
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

