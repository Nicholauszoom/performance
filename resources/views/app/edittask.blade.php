@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



        <!-- page content -->
        <?php
            if (isset($data)){
                      foreach ($data as $row) {
                        $id = $row->id; 
                          ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Task No: <?php echo $id; ?> </h3>
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
                <div class="card">
                  <div class="card-head">
                    <h2>Edit Task:   Current Duration: <?php
                            $date1=date_create($row->start);
                            $date2=date_create($row->end);
                            $diff=date_diff($date1,$date2);
                            echo " ".$diff->format("%R%a Days");?></h2>

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
                  <div class="card-body">
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                     
            <div class="col-lg-6">
                    <form id="upload_form" align="center" enctype="multipart/form-data" method="post"  action="<?php echo  url(''); ?>/flex/performance/edittask<?php echo $id;?>"   data-parsley-validate class="form-horizontal form-label-left">
                            

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Start 
                        </label>
                        <span class="badge bg-green"><b><?php echo " ".$row->start; ?></font></b></span>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input  value="<?php echo $row->start; ?>" name="start" id="single_cal2"   class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">End 
                        </label>
                        <span class="badge bg-green"><b><?php echo " ".$row->end; ?></font></b></span>
                        <!-- <small>Current Date: <b><font color="green"><?php echo " ".$row->end; ?></font></b></small> -->
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <input  value="<?php echo $row->end; ?>" name="end" id="single_cal1"   class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("fname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>">
                          <button  type="submit"  name="editdate" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>
                    <form id="upload_form" align="center" enctype="multipart/form-data" method="post"  action="<?php echo  url(''); ?>/flex/performance/edittask<?php echo $id;?>"   data-parsley-validate class="form-horizontal form-label-left"> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea  cols="3" class="form-control col-md-7 col-xs-12"  name="description"  rows="5"><?php echo $row->description; ?></textarea>
                          <!-- <input  value="<?php echo $row->description; ?>" id="last-name" name="lname" class="form-control col-md-7 col-xs-12"> -->
                          <span class="text-danger"><?php // echo form_error("lname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>">
                          <button  type="submit"  name="editdesc" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>

                    <form id="upload_form" align="center" enctype="multipart/form-data" method="post"  action="<?php echo  url(''); ?>/flex/performance/edittask<?php echo $id;?>"   data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group"><br><span class="badge bg-green"><b><?php echo " ".$row->NAME; ?></font></b></span>
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Assigned To</label>
                        <div class="col-md-6 col-sm-6 col-xs-12"><Br>
                         <select name="assigned_to" class="form-control">
                          <?php
                          foreach ($subordinate as $row) {
                             # code... ?>
                          <option value="<?php echo $row->ID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>  
                          <span class="text-danger"><?php // echo form_error("mname");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>">
                          <button  type="submit"  name="editsubordinate" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>
                  <!-- /.col-lg-6 (nested) -->
                  <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>Positions for this Department</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li>
                      <button type="button" id="modal" data-toggle="modal" data-target="#positionModal" class="btn btn-main">New Position</button>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                    <table class="table">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Position Name</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td class="options-width">
                           <a href="javascript:void(0)" onclick="deleteDomain(<?php //echo $row->id;?>)"  title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="ph-trash-o"></i></font></a>&nbsp;&nbsp;
                           <a href="javascript:void(0)" class="hide" id="hide<?php //echo $row->id;?>">Please wait...</a>
                            <a class="tooltip-demo" data-placement="top" title="Edit"  href="<?php //echo  url('')."/flex/main_controller/fetch_single_user".$row->id; ?>"><font color="#5cb85c"> <i class="fa fa-edit"></i></font></a></td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Otto</td>
                          <td class="options-width">
                           <a href="javascript:void(0)" onclick="deleteDomain(<?php //echo $row->id;?>)"  title="Delete" class="icon-2 info-tooltip"><font color="red"> <i class="ph-trash-o"></i></font></a>&nbsp;&nbsp;
                           <a href="javascript:void(0)" class="hide" id="hide<?php //echo $row->id;?>">Please wait...</a>
                            <a class="tooltip-demo" data-placement="top" title="Edit"  href="<?php //echo  url('')."/flex/main_controller/fetch_single_user".$row->id; ?>"><font color="#5cb85c"> <i class="fa fa-edit"></i></font></a></td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div> -->
                   <!-- /.col-lg-6 (nested) -->

                  
                
            <?php } }    ?>
                    <!-- </table> -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>




        <!-- /page content -->
        


 @endsection