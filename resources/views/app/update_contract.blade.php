
        

<?php 
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Contracts</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Update Contracts</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                     <?php
            if (isset($contract)){
                      foreach ($contract as $row) {
                        $name=$row->name;
                        $id=$row->id;
                        $reminder=$row->reminder;
                        $duration=$row->duration;
                      }}

                          ?>

                    <form autocomplete="off" id="demo-form2" action="<?php echo url(); ?>flex/updatecontract/?id=<?php echo $id; ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Name<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="text" size="3"  value="<?php echo $name; ?>" name="name" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > 
                        Duration(Years) <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0.5" max="100" step="0.5" value="<?php echo $duration; ?>" name="duration"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employee");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > 
                        Notify Me (Months before Contract Expiration) <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="1" max="12" step="1" value="<?php echo $reminder; ?>" name="alert"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employee");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button type="submit" name="update" class="btn btn-success">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->






 @endsection