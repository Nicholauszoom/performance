
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
  
  ////$CI_Model = get_instance();
  //$CI_Model->load->model('flexperformance_model');
  
  if($mode == 1){
          $header = "Employee Qualifications";}
      else {
          $header = "Training Graduation";
    }
?>


<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><?php echo $header; ?></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
         
     <div class="col-md-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2><button class="btn btn-info">SKILLS NAME: </button> <?php echo $courseTitle; ?></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
            <div id ="resultfeedBackSubmission"></div>
                <form autocomplete="off" enctype="multipart/form-data" <?php if($mode==1){ ?>  id="employeeCertification" <?php } else { ?> id="confirmGraduation" <?php } ?>  class="form-horizontal form-label-left input_mask" method ="POST">

                    <input  hidden name="traineeID" value="<?php echo $traineeID; ?>">
                    <?php if($mode==2){ ?>
                    <input  hidden name="trainingID" value="<?php echo $trainingID; ?>">
                    <?php } ?>
                    <input  hidden name="skillsID" value="<?php echo $skillsID; ?>">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks and Recommendation</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control" placeholder="Recommendations" required=""  name="remarks"  rows="4"></textarea>
                          <!--<input type="text" class="form-control" >-->
                        </div>
                    </div> <br>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Certificate</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input required type='file' name='userfile' />
                        </div>
                    </div>
                        
                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="reset" class="btn btn-default">CANCEL</button>
                      <button class="btn btn-primary">CONFIRM</button>
                    </div>
                  </div>
    
                </form>
              </div>
            </div>
         </div>
    </div> <!--row-->
  </div>
 </div>
</div>
<!-- /page content -->

<?php 
  ?>


<script type="text/javascript">
    $('#confirmGraduation').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/confirmGraduation",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedBackSubmission').fadeOut('fast', function(){
              $('#resultfeedBackSubmission').fadeIn('fast').html(data);
            });
    
      $('#confirmGraduation')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#employeeCertification').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/employeeCertification",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedBackSubmission').fadeOut('fast', function(){
              $('#resultfeedBackSubmission').fadeIn('fast').html(data);
            });
    
      $('#employeeCertification')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
        });
    }); 
</script>
       
       
 @endsection