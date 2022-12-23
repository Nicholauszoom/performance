@extends('layouts.vertical', ['title' => 'Overtime Comments'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')

<div class="mb-3">
    <h4 class="text-main" align="center">Remarks</h4>
</div>

<div class="row">
    <div class="col-md-6 offset-3">
        <div class="card">
            <div class="card-header">
                <?php if ( $mode == 1 ){ ?>
                    <h4 class="text-main"> Add Remarks(Comments) </h4>
                <?php } if ( $mode == 2 ){ ?>
                    <h4 class="text-main"> Update Overtime </h4>
                <?php } ?>
            </div>

            <div class="card-body">
                <?php if ($mode==1){
                    foreach ($comment as $row) {
                        $id = $row->id;
                        $commentValue = $row->comment;
                        $commit = $row->commit;
                    }
                ?>

                    <form enctype="multipart/form-data"  method="post" action="{{ route('flex.commentOvertime') }}" data-parsley-validate>
                        @csrf

                        <input type="text" name = "overtimeID" hidden value="<?php echo $id; ?>">

                        <div class="mb-3">
                            <label class="form-label" for="last-name">Comment</label>
                            <textarea <?php if($commit ==1){ ?> disabled <?php } ?>  cols="10" class="form-control"  name="comment"  rows="5"><?php echo $commentValue;  ?></textarea>
                        </div>

                        <div class="">
                            <!--<a href="#" class="btn btn-sm btn-main">Add files</a>-->
                            <?php if( $commit ==0 ){ ?>
                                <button type ="submit" name ="apply" class="btn btn-sm btn-main">COMMENT AND COMMIT</button>
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
                    }
                ?>

                    <form id="demo-form2" enctype="multipart/form-data"  method="post" action="<?php echo  url(''); ?>/flex/overtime_info"  data-parsley-validate>
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label" for="time-range">Time Range</label>
                            <div class="input-prepend input-group">
                                <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                <input type="text" name="time_range" id="time_range" value="<?php  echo $completeValue;  ?>" class="form-control" />
                            </div>
                        </div>

                        <input type="text" name="overtimeID"  value="<?php  echo $overtimeID; ?>" hidden />

                        <div class="mb-3">
                            <label class="form-label">Reason For Overtime <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" rows="3" placeholder='Reason'><?php echo $reason; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <input type="submit"  value="UPDATE" name="update_overtime" class="btn btn-main"/>
                        </div>
                    </form>

                <?php } ?>
            </div>
        </div>
    </div>
</div>


@endsection
