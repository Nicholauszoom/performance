
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
  
  
    if (isset($details)){
              foreach ($details as $row) {
                $name = $row->name; 
                $dpt=$row->DEPARTMENT;
                $file = $row->attachment;
                 $datesValue = str_replace('-', '/', $row->dated);
                $timed = date('d-m-Y', strtotime($datesValue));
                $description = $row->description;
                $position = $row->POSITION;
                $title = $row->title;
                $attachment = $row->attachment;
                $support_document = $row->support_document;
                $status = $row->status;
                $gID = $row->id;
                $remarks = $row->remarks;
                  
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
                <div class="card">
                  <div class="card-head">
                    {{-- <h2>Grievance Info</h2> --}}


                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  
                   @if(Session::has('note'))      {{ session('note') }}  @endif  
                  
                    <!-- <table id="datatable" class="table table-striped table-bordered"> -->
                    
                  
                  
                  
              <div class="col-md-12 col-sm-6 col-xs-12">
             
                  <div class="card-head">
                    <h2><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<b>Details and Description</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body"> 


                    <h6>Author:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h6>
                    <h6> Department:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $dpt; ?></b></h6>
                    <h6> Position:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $position; ?></b></h6>
                    <h6> Submitted On:
                    &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $timed; ?></b></h6>
                    <h6> Title:<b> <?php echo $title; ?> </b></h6>
                    <hr>
                    <h6> <b> Description </b>:</h6>
                    <p> <?php echo $description; ?> </p>
                    <?php if($attachment != "N/A"){ ?>
                    <br>
                    <h6> <b> Attachment </b>: &nbsp;  <a download= '' href ='<?php echo  url('').$attachment; ?>'>
                      <span class='btn btn-sm btn-main '>DOWNLOAD Attached Evidence File</span></a>
         <?php } ?></h6>
                 <?php if($remarks!= null) { ?>
                    <h6> <b> Remarks </b>:</h6>
                    <p> <?php echo $remarks; ?> </p>

                  <?php } ?>
                    
                    <?php if($support_document != "N/A") { ?>
                    
                    <h5> <b> ADDITIONAL Attachment </b>:<br></h5>
                    <p>

                      <a download= '' href ='<?php echo  url('').$support_document; ?>'><div class='col-md-12'>
                                <span class='btn bg-main'>DOWNLOAD Attached Evidence File</span></div></a>
                    </p> <?php } ?>
                    

                  </div>
          
              </div>
              @can('confirm-transfer')
              <?php if($status == 0){  ?>
              <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head p-2">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Grievance Conclusion</b></h2>
                    <hr>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <p>Additional Details</p>

                    <form  enctype="multipart/form-data" action="{{ route('flex.update-grievances') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
                      @csrf
                      @method('PUT')
                     <div class="row">
                      <div class="form-group col-12">
                        <input  name="id" value="<?php echo $gID ?>" type="hidden">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Remarks
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <textarea placeholder="Remarks" required="" cols="15" class="form-control col-md-7 col-xs-12"  name="remarks"  rows="5"></textarea>
                        </div>
                      </div> <br>
                      
                      <div class="form-group mb-2">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="first-name"> Support Document  If Any <small class="text-danger">( eg. pdf, Picture etc..)</small>  
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type='file' name='attachment'  />
                        </div>
                      </div> <br>
                      <hr>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" name="solve" class="btn btn-success">MARK AS SOLVED</button>
                          
                          {{-- <?php if(session('griev_hr')!='') { ?>
                          <button type="submit" name="submit" class="btn btn-warning brn">SUBMIT TO THE BOARD</button>
                          <?php } ?> --}}
                        </div>
                      </div>
                      
                      
                     </div>
                   
                      </form><br><br> 
                  </div>
              </div>
              </div> <?php }  ?>
                  
              @endcan
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