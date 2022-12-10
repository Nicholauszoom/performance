
        


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
                <h3>P.A.Y.E</h3>
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
                    <h2>Update PAYE </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <div id="feedBackSubmission"></div>
                  
                     <?php
            if (isset($paye)){
                      foreach ($paye as $row) {
                        $minimum=$row->minimum;
                        $maximum=$row->maximum;
                        $id=$row->id;
                        $rate=$row->rate;
                        $excess=$row->excess_added;
                      }}

                          ?>

                    <form autocomplete="off" id="updatePAYE"  method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <input type="text" name="payeID" value="<?php echo $id; ?>" hidden >

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Minimum Aomunt<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1"  value="<?php echo $minimum; ?>" name="minimum"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Maximum Amount 
                        <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1" value="<?php echo $maximum; ?>" name="maximum" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Excess Amount Added<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="100000000" step="1" value="<?php echo $excess; ?>" name="excess"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employee");?></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Percent Contribution with Respect to the Amount that Exceed Minimum Range<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input required="" type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate); ?>" name="rate"  class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employee");?></span>
                        </div>
                      </div>
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button class="btn btn-success">Update</button>
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
  $('#updatePAYE').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updatepaye",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){      
        alert(data.title);

      if(data.status == 'OK'){
        // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                  $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
              setTimeout(function(){// wait for 5 secs(2)
             location.reload()// then reload the page.(3)
          }, 2000);

              } else{
                // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                  $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('UPDATION Failed, Review Your Network Connection...'); 
    });

});
</script>


 @endsection