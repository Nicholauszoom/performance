
@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php

  foreach ($employee as $row) {
      $name = $row->empName;
      $empID = $row->empID;
      $department = $row->department;
      $position = $row->position;
  }
$sum_arrears = $sum_paid = $sum_outstanding = $sum_last_paid=$sum_takehome=$sum_less_takehome = 0;
?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><b>Arrears For: </b>&nbsp;&nbsp;<?php echo $name; ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Arrears Payments<small>Enter The Amount to Pay</small></h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif 
                   if($pendingPayroll > 0){ ?>
                   <p class='alert alert-warning text-center'>No Arrears Payments Can Be Scheduled until the Pending Payoll is Responded</p>
                 <?php } ?>
                   <div id="feedBackSubmission"></div>
                   <form method="post" id="arrearsPayment" >
                    <input name="empID" value="<?php echo $empID; ?>" type="hidden" >
                    <table  class="table table-striped table-bordered">
                      <thead>
                        <tr style="background-color:#14141f;color:#FFFFFF;" align="center">
                          <th><b>S/N</b></th>
                          <th><b>Payroll Month</b></th>
                          <th><b>Expected Takehome</b></th>
                          <th><b>Actual Takehome</b></th>
                          <th><b>Amount</b></th>
                          <th><b>Paid</b></th>
                          <th><b>Outstanding</b></th>
                          <th><b>Last Payment</b></th>
                          <?php if($pendingPayroll== 0 && session('mng_paym')){ ?>
                            <th>&nbsp;&nbsp;<button type="submit" name="submit" value ="submit" class="btn btn-primary">CONFIRM PAYMENT</button></th>
                          <?php }  ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        $counts = count($arrears);
                        foreach($arrears as $row){
                          $payrolMonth = date('d-M-Y', strtotime($row->payroll_date));
                          $amount = $row->amount;
                          $takehome = ($row->less_takehome+$row->amount);
                          $less_takehome = $row->less_takehome;
                          $paid = $row->paid;
                          $outstanding = ($row->amount-$row->paid);
                          $last_paid = $row->amount_last_paid;
                          $last_paid_date = date('d-M-Y', strtotime($row->last_paid_date));
                          

                          $sum_arrears = $sum_arrears + $amount;
                          $sum_paid = $sum_paid + $paid;
                          $sum_last_paid = $sum_last_paid + $last_paid;
                          $sum_outstanding = $sum_outstanding + $outstanding;
                          $sum_takehome = $sum_takehome + $takehome;
                          $sum_less_takehome = $sum_less_takehome + $less_takehome;
                        ?>


                        <tr>
                          <td align="center"><?php echo $row->SNo; ?></td>
                          <td ><?php echo $payrolMonth; ?></td>
                          <td ><?php echo number_format($takehome); ?></td>
                          <td ><?php echo number_format($less_takehome); ?></td>
                          <td ><?php echo number_format($amount); ?></td>
                          <td ><?php echo number_format($paid); ?></td>
                          <td align="center"><?php echo number_format($outstanding); ?></td>
                          <td align="center"><?php echo number_format($last_paid); ?></td>
                          <?php if($pendingPayroll==0 && session('mng_paym')){ ?>
                          <td>
                            <div class="form-group">
                              <div class="col-sm-9">                             
                              <input name="arrearID<?php echo $row->SNo;?>" value="<?php echo $row->id; ?>" type="hidden">                             
                              <input name="amount_already_paid<?php echo $row->SNo;?>" value="<?php echo $row->paid;?>" type="hidden">
                              <input name="amount_pay<?php echo $row->SNo;?>" value="<?php echo $row->pending_amount;?>" min="0" max="<?php echo $outstanding; ?>" type="number" step="0.01" placeholder="Confirmed"   class="form-control">
                              </div>                                    
                            </div>                             
                          </td>
                        <?php } ?>
                        </tr>    
                        <?php } ?>
                        <tr>
                          <td colspan="2" align="center" bgcolor="#FF8C00"><font color="white"><b>TOTAL</b></font></td>
                          <td><?php echo number_format($sum_takehome); ?></td>
                          <td><?php echo number_format($sum_less_takehome); ?></td>
                          <td><?php echo number_format($sum_arrears); ?></td>
                          <td><?php echo number_format($sum_paid); ?></td>
                          <td align="center"><?php echo number_format($sum_outstanding); ?></td>
                          <td align="center"><?php echo number_format($sum_last_paid); ?></td>
                          <td bgcolor="#FF8C00"></td>
                        </tr>
                      </tbody>
                    </table>
                      <input name="arrears_counts" value="<?php echo $counts; ?>" type="hidden" >
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        


        <!-- /page content -->




<script type="text/javascript">
    $('#arrearsPayment').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/payroll/arrearsPayment_schedule",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
          // alert(data);
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 1500); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 
</script>

 @endsection