@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Roles and Activities </h3>
              </div>

              <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div> -->

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Activities   <a><button type="button" id="modal" data-toggle="modal" data-target="#departmentModal" class="btn btn-primary">Add New</button></a></h2>

                    <!-- <ul class="nav navbar-right panel_toolbox">
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
                    </ul> -->

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/No</th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Date Created</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($activity as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->id2; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo date('d/m/Y'); ?></td>
<!-- $this->encrypt->encode($this->input->get("id")) -->

                            <td class="options-width">
                           <a href="<?php echo url(); ?>flex/desletedepartment/?id=".$row->id; ?>"   title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="fa fa-trash-o"></i></font></a>&nbsp;&nbsp;

                            <a class="tooltip-demo" data-placement="top" title="Edit"  href="<?php echo url()."flex/deepartment_info/?id=".base64_encode($row->id); ?>"><font color="#5cb85c"> <i class="fa fa-edit"></i></font></a></td>
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

        <!-- Modal -->
                <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title" id="myModalLabel">Add New Activity</h4>
                          </div>
                          <div class="modal-body">
                          <!-- Modal Form -->
                          <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/addactivity"  data-parsley-validate class="form-horizontal form-label-left">
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Activity Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("fname");?></span>
                        </div>
                      </div>                      
                      
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <input type="submit"  value="Add" name="add" class="btn btn-primary"/>
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
        <script>
    $(document).ready(function(){
        $('.hide').hide();
           $('.myTable').DataTable();
        });
    function deleteDomain(id)
    {
        if (confirm("Are you sure!") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/Main_controller/deleteDomain');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();
           
            $('#domain'+id).hide();
               
            }
               
            });
        }
    }
   
    function cancel()
    {
        alert("hello");
        Location.reload();
    }
</script>    


 @endsection