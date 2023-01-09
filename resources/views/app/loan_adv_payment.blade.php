
        


@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  foreach ($loan_info as $row) {
    $amount=$row->amount;
    $loanID = $row->id;
    $paid = $row->paid;
    $amount_last_paid=$row->amount_last_paid;
    $total_paid=$row->paid;    
    $remained=$row->amount-$row->paid;

  }
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
             
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                  <div class="card-head py-2 px-3">
                    <h2>Advanced Payments</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  <div id="feedback"></div>

                  @if(Session::has('note'))      {{ session('note') }}  @endif  

                    <form id="updateLoan" method="post" data-parsley-validate class="form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount To Pay<span class="required">*</span>
                        </label>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                          <input  type="number" min="1" max="<?php echo $remained; ?>" required="" value="0" name="paid" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                        <input type="hidden" required=""  value="<?php echo $paid; ?>" name="accrued">
                        <input type="hidden" required=""  value="<?php echo $amount; ?>" name="amount">
                        <input type="hidden" required=""  value="<?php echo $loanID; ?>" name="loanID">
                        <input type="hidden" required=""  value="<?php echo $remained; ?>" name="remained" >
                          
                      <!-- <div class="ln_solid"></div> -->
                      <div class="form-group py-3">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                         
                          <button class="btn btn-main">Update</button>
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
  $('#updateLoan').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/adv_loan_pay",
 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
        $('#feedback').fadeOut('fast', function(){
          $('#feedback').fadeIn('fast').html(data.message);
        });
        window.location.href = "<?php echo url('flex/confirmed_loans/');?>";

      } else{
        alert(data.message);
        $('#feedback').fadeOut('fast', function(){
          $('#feedback').fadeIn('fast').html(data.message);
        });
      }
    })
    .fail(function(){
 alert('FAILED Update, Review Your Network Connection...'); 
    });

});
</script>


 @endsection