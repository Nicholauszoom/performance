
        


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
                <h3>Allowance</h3>
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
                    <h2>Edit Allowance</h2>
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

                  @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                     <?php
            if (isset($allowance)){
                      foreach ($allowance as $row) {
                        $name=$row->name;
                        $id=$row->id;
                        $rate=$row->rate;
                      }}

                          ?>

                    <form id="demo-form2" action="<?php echo  url(''); ?>/flex/updateallowance/<?php echo $id; ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input  type="text" size="3"  value="<?php echo $name; ?>" name="name" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Amount 
                        Contributed (in %)<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="text" size="3"  value="<?php echo 100*($rate); ?>" name="rate" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-main">Cancel</button>
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