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
                <h3>Remarks</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                     <?php if ($mode==1){ ?>
                    <h2>Add Remarks(Comments) </h2>
                    <?php } if ($mode==2){ ?>
                    <h2>Update Overtime </h2> <?php } ?>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                     
            <div class="col-lg-12">
                <?php if ($mode==1){
                foreach ($comment as $row) {
                        $id = $row->id;
                        $commentValue = $row->comment; 
                        $commit = $row->commit; 
                      }
                ?>
                    <form  align="center" enctype="multipart/form-data"  method="post" action="<?php echo base_url().'flex/commentOvertime/'; ?>"     data-parsley-validate class="form-horizontal form-label-left">
                    <input type="text" name = "overtimeID" hidden value = "<?php echo $id; ?>">
                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Comment 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea <?php if($commit ==1){ ?> disabled <?php } ?>  cols="10" class="form-control col-md-7 col-xs-12"  name="comment"  rows="5"><?php echo $commentValue;  ?></textarea>
                          <span class="text-danger"><?php ////echo form_error("lname");?></span>
                        </div>
                      </div>
                      <div class="text-center mtop20">
                        <!--<a href="#" class="btn btn-sm btn-primary">Add files</a>-->
                        <?php if($commit ==0){ ?>
                        <button type ="submit" name ="apply" class="btn btn-sm btn-primary">COMMENT AND COMMIT</button>
                        <?php } ?>
                      </div>

                    </form>
                     <?php } if ($mode==2){
                      foreach ($overtime as $row) {
                        $overtimeID = $row->id;
                        $reason = $row->reason; 
                        $timeframe = $row->timeframe; 
                        // $end = $row->time_end; 
                        
                        
                        // Separate between Start Time-Date and End Time-Date
                        $datetime = explode(" - ", $timeframe);
                        $stime = $datetime[0];
                        $etime = $datetime[1];
                        
                        // Separate Time and Date
                        $starttime = explode(" ",$stime);
                        $endtime = explode(" ",$etime);
                        
                        
                        $startDate = explode("-",$starttime[0]);
                        $endDate = explode("-",$endtime[0]);
                        
                        $finalStartDate = $startDate[2]."/".$startDate[1]."/".$startDate[0];
                        $finalEndDate = $endDate[2]."/".$endDate[1]."/".$endDate[0];
                        
                        
                        $start = $finalStartDate." ".$starttime[1];
                        $end = $finalEndDate." ".$endtime[1];
                        $completeValue = $start." - ".$end;
                      }?>
                    <!--UPDATE OVERTIME-->
                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo url(); ?>flex/overtime_info"  data-parsley-validate class="form-horizontal form-label-left">
                       
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Time Range
                        </label>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="input-prepend input-group">
                              <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                              <input type="text" name="time_range" id="time_range" value="<?php  echo $completeValue;  ?>" class="form-control" />
                            </div>
                        </div>
                      </div>
                        <input type="text" name="overtimeID"  value="<?php  echo $overtimeID; ?>" hidden />
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Reason For Overtime <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <textarea class="form-control" name="reason" rows="3" placeholder='Reason'><?php echo $reason; ?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="reset" class="btn btn-warning">Cancel</button>
                          <input type="submit"  value="UPDATE" name="update_overtime" class="btn btn-primary"/>
                        </div>
                      </div> 
                      </form>  <?php } ?>
                    <!--UPDATE OVERTIME-->
                  </div>  
                  
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
                <!-- /.col-lg-10 -->
                    <!-- END COMMENT -->




        <!-- /page content -->
        


 @endsection