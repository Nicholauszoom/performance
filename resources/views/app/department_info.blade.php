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
                <h3>Departments </h3>
            </div>

        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Departments Info</h2>


                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        @if(Session::has('note'))      {{ session('note') }}  @endif  
                   
                      foreach ($data as $row) {
                        $id=$row->id;
                        $name = $row->name;
                        $hod = $row->hod;
                        $cost_center_id = $row->cost_center_id;
                        $parent = $row->reports_to;
                        
                        } ?>
                        <div class="col-lg-8">
                            <!--<form id="upload_form" align="center" enctype="multipart/form-data" method="post" action="<?php echo url(); ?>flex/editdepartment/?id=<?php echo $id; ?>"  data-parsley-validate class="form-horizontal form-label-left">-->

                            <form autocomplete="off" id="upload_form" align="center" enctype="multipart/form-data"
                                method="post"
                                action="<?php echo url(); ?>flex/editdepartment/?id=<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Department
                                        Name
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input required="" type="text" value="<?php echo $name; ?>" name="name"
                                                class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatename" class="btn btn-primary">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                                action="<?php echo url(); ?>flex/editdepartment/?id=<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cost Center
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select required="" name="cost_center_id"
                                                class="select4_single form-control" tabindex="-1">
                                                <option></option>
                                                <?php
                              foreach ($cost_center as $row) { ?>
                                                <option <?php  if($cost_center_id==$row->id){ ?> selected="" <?php } ?>
                                                    value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatecenter" class="btn btn-primary">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                                action="<?php echo url(); ?>flex/editdepartment/?id=<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Head of
                                        Department
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select required="" name="hod" class="select4_single form-control"
                                                tabindex="-1">
                                                <option></option>
                                                <?php
                              foreach ($employee as $employee) { ?>
                                                <option <?php  if($hod==$employee->empID){ ?> selected="" <?php } ?>
                                                    value="<?php echo $employee->empID; ?>">
                                                    <?php echo $employee->NAME; ?></option> <?php } ?>
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatehod" class="btn btn-primary">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <?php  if($id!=3){ ?>
                            <!-- If The Department is Not Top Department Allow Updating -->
                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                                action="<?php echo url(); ?>flex/editdepartment/?id=<?php echo $id; ?>">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reports To
                                    </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select required="" name="parent" class="select3_single form-control"
                                                tabindex="-1">
                                                <option></option>
                                                <?php
                              foreach ($parent_department as $row) { if($id==$row->id){ continue;} ?>
                                                <option <?php  if($parent==$row->id){ ?> selected="" <?php } ?>
                                                    value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" name="updateparent" class="btn btn-primary">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php  } ?>
                        </div>

                        <!-- /.col-lg-6 (nested) -->
                        <!--  <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Perfomance and Productivity</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <h5> Total Task Assigned:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $alltask; ?> Tasks</b></h5>
                    <h5> Total Duration to Complete all Tasks:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $duration; ?> SUM Days Worked</b></h5>
                    <h5> EMPLOYMENT COST Per MONTH:&nbsp;&nbsp;<b><?php echo number_format($ALLCOST,2); ?> Tsh </b></h5>
                    <h5> TASK MONETARY VALUE :&nbsp;&nbsp;<b> <?php  echo $monetaryValue; ?> Tsh. </b></h5>
                    <?php
                         $dailyCost = $ALLCOST/30;
                         $inputCost = $dailyCost* $duration;
                         $productivity = $monetaryValue/$inputCost;
                         $profit = $inputCost-$monetaryValue;
                    ?>
                    <h5> INPUT :&nbsp;&nbsp;<b> <?php  echo $inputCost; ?> Tsh. </b></h5>
                    <h5> PRODUCTIVITY :&nbsp;&nbsp;<b> <?php  echo $productivity; ?>  </b></h5>
                    <h5> PROFIT CREATED :&nbsp;&nbsp;<b> <?php  echo $profit; ?>  </b></h5>
                  </div>
                </div>
              </div> -->
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- /page content -->



 @endsection