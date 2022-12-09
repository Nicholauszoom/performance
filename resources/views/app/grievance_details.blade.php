<?php 
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')

<?php
  
  
    if (isset($details)){
              foreach ($details as $row) {
                $name = $row->NAME; 
                $dpt=$row->DEPARTMENT;
                $file = $row->attachment;
                 $datesValue = str_replace('-', '/', $row->DATED);
                $timed = date('d-m-Y', strtotime($datesValue));
                $description = $row->description;
                $position = $row->POSITION;
                $title = $row->title;
                $attachment = $row->attachment;
                $support_document = $row->support_document;
                $status = $row->status;
                $gID = $row->id;
                  
              } 
    }
    
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Grievances </h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Grievance Info</h2>


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                    
                  
                  
                  
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<b>Details and Description</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 


                    <h5> Author:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                    <h5> Department:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $dpt; ?></b></h5>
                    <h5> Position:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $position; ?></b></h5>
                    <h5> Submitted On:
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $timed; ?></b></h5>
                    <h5> Title:<b> <?php echo $title; ?> </b></h5><br><br>
                    <h5> <b> Description </b>:<br></h5>
                    <p> <?php echo $description; ?> </p>
                    <?php if($attachment != "N/A"){ ?>
                    <br><br>
                    <h5> <b> ATTACHMENT </b>:<br></h5>
                    <p>
                      <a download= '' href ='<?php echo base_url().$attachment; ?>'><div class='col-md-12'>
                                <span class='label label-info'>DOWNLOAD Attached Evidence File</span></div></a>
                    </p><br> <?php } ?>
                    
                    <?php if($support_document != "N/A") { ?>
                    
                    <h5> <b> ADDITIONAL Attachment </b>:<br></h5>
                    <p>

                      <a download= '' href ='<?php echo base_url().$support_document; ?>'><div class='col-md-12'>
                                <span class='label label-info'>DOWNLOAD Attached Evidence File</span></div></a>
                    </p> <?php } ?>
                    

                  </div>
              </div>
              </div>
              <?php if( session('griev_hr')!='' || session('griev_board')!='') { ?> 
              <?php if($status == 0){  ?>
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Grievance Conclusion</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <p>Additional Details</p>

                    <form id="demo-form2" enctype="multipart/form-data" action="<?php echo base_url().'flex/grievance_details/?id='.$gID; ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">

                     
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Remarks
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <textarea placeholder="Remarks" required="" cols="15" class="form-control col-md-7 col-xs-12"  name="remarks"  rows="5"></textarea>
                        </div>
                      </div> <br>
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Support Document  If Any<br> ( eg. pdf, Picture etc..) 
                        </label>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type='file' name='userfile'  />
                        </div>
                      </div> <br>
                      
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" name="solve" class="btn btn-success">MARK AS SOLVED</button>
                          
                          <?php if(session('griev_hr')!='') { ?>
                          <button type="submit" name="submit" class="btn btn-warning">SUBMIT TO THE BOARD</button>
                          <?php } ?>
                        </div>
                      </div>
                      
                      
                      </form><br><br> 
                  </div>
              </div>
              </div> <?php } } ?>
                  
                  <!-- /.col-lg-6 (nested) -->
                   <!-- /.col-lg-6 (nested) -->

                                  
                    <!-- </table> -->
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

          <!-- /.modal -->


            <?php //} }    ?>

        <!-- /page content -->



 @endsection