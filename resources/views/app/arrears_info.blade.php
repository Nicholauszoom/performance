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
                <h3><b>Arrears For: </b>&nbsp;&nbsp;<?php echo date('F, Y',strtotime($payroll_month)); ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <?php if($pendingPayroll > 0){ ?>
                       <p class='alert alert-warning text-center'>No Arrears Payments Can Be Scheduled until the Pending Payoll is Responded</p>
                     <?php } ?>
                    <h2>Arrears Payments <small><?php echo date('F, Y',strtotime($payroll_month)); ?></small> &nbsp;&nbsp;&nbsp;
                      <?php if($pendingPayroll==0 && session('mng_paym')){ ?>
                     <button type="button" onclick="payAll('<?php echo $payroll_month;?>');" class="btn btn-primary btn-md">PAY ALL ARREARS IN THIS MONTH</button>
                   <?php } ?>
                   </h2>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                   <div id="feedBackSubmission"></div>
                    <table id="datatable-task-table" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Total Arrears</th>
                          <th>Paid</th>
                          <th>Outstanding</th>
                          <th>Amount Last Paid</th>
                          <th>Last Payment Date</th>
                          <?php if(session('mng_paym')|| session('recom_paym')||session('appr_paym')){ ?>
                          <th>Option</th>
                        <?php } ?>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                          foreach ($arrears as $row) { ?>
                              <?php if ($row->amount-$row->paid > 0) {?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->empName; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td><?php echo $row->paid; ?></td>
                            <td><?php echo ($row->amount-$row->paid); ?></td>
                            <td><?php echo $row->amount_last_paid; ?></td>
                            
                            <td><?php echo date('d-F-Y', strtotime($row->last_paid_date)); ?></td>
                            <?php if(session('mng_paym')|| session('recom_paym')||session('appr_paym')){ ?>
                              <td>
                              <a href ="<?php echo url(); ?>flex/reports/employee_arrears/?empid=<?php echo base64_encode($row->empID); ?>" target = "blank" title="Print Employee Report" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-file"></i></button> </a>
                              <a  href="<?php echo url(); ?>flex/individual_arrears_info/?id=".base64_encode($row->empID.'@'.$payroll_month); ?>" title="Payments and Info" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                              </td>
                          <?php }  ?>
                            </tr>
                                <?php } ?>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        


        <!-- /page content -->




<script type="text/javascript">
    
    function payAll(payroll_month)
    {
        if (confirm("Are You Sure You Want To Issue Payment for Arrears for All Emloyee in this Month?") == true) {
        $.ajax({
            url:"<?php echo url('flex/payroll/monthlyArrearsPayment_schedule');?>/?payroll_month="+payroll_month,
            success:function(data)
            {
              if(data.status == 'OK'){
                $('#feedBackSubmission').fadeOut('fast', function(){
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
                setTimeout(function(){
                      location.reload();
                  }, 3000); 
              }else{ 
                $('#feedBackSubmission').fadeOut('fast', function(){
                  $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });

              }               
            }               
          });
        }
    } 
</script>

 @endsection