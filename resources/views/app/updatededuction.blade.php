
        

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
                <h3>Deductions</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Update Deduction</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <div id="feedback"></div>
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                     <?php
            if (isset($deductions)){
                      foreach ($deductions as $row) {
                        $name=$row->name;
                        $deductionID=$row->id;
                        $rate_employer=$row->rate_employer;
                        $rate_employee = $row->rate_employee;
                      }}

                          ?>

                    <form autocomplete="off" id="updateDeductions" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required">*</span>
                        </label>
                        
                          <input hidden name = "deductionID" value="<?php echo $deductionID; ?>">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input  type="text"   value="<?php echo $name; ?>" name="name" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Amount 
                        Contributed by Employer<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate_employer); ?>" name="rate_employer" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Amount 
                        Contributed by Employee <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required=""  type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate_employee); ?>" name="rate_employee"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php //echo form_error("rate_employee");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">Cancel</button>
                          <button type="submit"  class="btn btn-success">Update</button>
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




<script type="text/javascript">
  $('#updateDeductions').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo url(); ?>flex/updateCommonDeductions/",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#feedback').fadeOut('fast', function(){
          $('#feedback').fadeIn('fast').html(data);
        });
     // location.reload();

    })
    .fail(function(){
 alert('Updation Failed!'); 
    });

});
</script>


 @endsection