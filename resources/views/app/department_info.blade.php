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


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 offset-3">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0 mx-2">
                    <div class="card-head">
                        <h2>Departments Info</h2>


                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">

                        @if(Session::has('note'))      {{ session('note') }}  @endif
                   <?php
                      foreach ($data as $row) {
                        $id=$row->id;
                        $name = $row->name;
                        $hod = $row->hod;
                        $cost_center_id = $row->cost_center_id;
                        $parent = $row->reports_to;

                        } ?>
                        <div class="col-lg-12">
                            <!--<form id="upload_form" align="center" enctype="multipart/form-data" method="post" action="<?php echo  url(''); ?>/flex/editdepartment/<?php echo $id; ?>"  data-parsley-validate class="form-horizontal form-label-left">-->

                            <form autocomplete="off" id="upload_form" align="center" enctype="multipart/form-data"
                                method="post"
                                action="{{ route('flex.editdepartment',['id'=>$id]) }}">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Department
                                        Name
                                    </label>
                                    <div class="col-sm-6 class col-lg-12">
                                        <div class="input-group">
                                            <input required="" type="text" value="<?php echo $name; ?>" name="name"
                                                class="form-control">
                                                <input type="hidden" name="type" value="updatename" id="">
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatename" class="btn btn-main">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                            action="{{ route('flex.editdepartment',['id'=>$id]) }}">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cost Center
                                    </label>
                                    <div class="col-sm-6 class col-lg-12">
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
                                            <input type="hidden" name="type" value="updatecenter" id="">
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatecenter" class="btn btn-main">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                            action="{{ route('flex.editdepartment',['id'=>$id]) }}">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Head of
                                        Department
                                    </label>
                                    <div class="col-sm-6 class col-lg-12">
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
                                            <input type="hidden" name="type" value="updatehod" id="">
                                            <span class="input-group-btn">
                                                <button type="submit" name="updatehod" class="btn btn-main">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <?php  if($id!=3){ ?>
                            <!-- If The Department is Not Top Department Allow Updating -->
                            <form id="upload_form" align="center" enctype="multipart/form-data" method="post"
                            action="{{ route('flex.editdepartment',['id'=>$id]) }}">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reports To
                                    </label>
                                    <div class="col-sm-6 class col-lg-12">
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
                                            <input type="hidden" name="type" value="updateparent" id="">
                                            <span class="input-group-btn">
                                                <button type="submit" name="updateparent" class="btn btn-main">Update
                                                    Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php  } ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- /page content -->



 @endsection
