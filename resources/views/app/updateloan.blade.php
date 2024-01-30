
        


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
            
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12 offset-3">
                <div class="card">
                  <div class="card-head px-2 py-2">
                    <h2>Update Loan Credentials</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                  <div id="feedBack"></div>
                  
                     <?php
            if (isset($loan)){
                      foreach ($loan as $row) {
                        $id = $row->id;
                        $type=$row->type;
                        $status=$row->status;
                        $amount=$row->amount;
                        $deduction_amount=$row->deduction_amount;
                        $reason=$row->reason;
                      }}

                          ?>

                    <form id="updateLoan" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" >Amount 
                        <span class="required">*</span>
                        </label>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <input type="number" min='1000' max="10000000000000000"  value="<?php echo $amount; ?>" name="amount" class="form-control col-md-7 col-xs-12">
                          <span class="text-danger"><?php // echo form_error("rate_employer");?></span>
                        </div>
                      </div>
                          <input type="number" hidden value="<?php echo $id; ?>" name="loanID">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Deduction Per Month
                        </label>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <input required="required" type="number" min="1" max="1000000000000000" value = "<?php echo  $deduction_amount; ?>" name="deduction" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reason For Application(Optional)
                        </label>
                        <div class="col-md-12 col-sm-6 col-xs-12">
                          <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason(Optional)" rows="3"><?php echo $reason; ?></textarea> 
                          <span class="text-danger"><?php// echo form_error("lname");?></span>
                        </div>
                      </div>
                      {{-- <?php if($status==0 || $status==3 || $status==4){ ?> --}}
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 py-3">
                          
                          <button type="submit" name="update" class="btn btn-main">Update</button>
                        </div>
                      </div>
                      {{-- <?php } ?> --}}

                    </form>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->




<script>
    
    $('#updateLoan').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateloan_info",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBack').fadeOut('fast', function(){
              $('#feedBack').fadeIn('fast').html(data);
            });
    
    //   $('#applyLoan')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! Check Your Network Connection ...'); 
        });
    }); 
</script>


 @endsection