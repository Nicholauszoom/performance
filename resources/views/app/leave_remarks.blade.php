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


            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head px-4">
                    <h2>Add Remarks </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  
                     
            <div class="col-lg-6 offset-3">
                    <form id="upload_form" align="center" enctype="multipart/form-data" method="post"  action="{{ route('attendance.leave_remarks',$id) }}"   data-parsley-validate class="form-horizontal form-label-left">
                      
                      @csrf
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Remarks 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea  cols="7" class="form-control col-md-7 col-xs-12"  name="remarks"  rows="5"><?php echo $row->remarks; ?></textarea>
                          <span class="text-danger"><?php // echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 py-2">
                        <input type="hidden" name="sid" value="<?php //echo $data[0]->id; ?>">
                          <button  type="submit"  name="edit_remarks" class="btn btn-success">Edit</button>
                        </div>
                      </div>

                    </form>
                  </div>

                  
                
            <?php } }    ?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>




        <!-- /page content -->
        


 @endsection