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
  $payrollMonth = $payroll_date;
  $payrollState = $payroll_state;
  foreach ($payroll_totals as $row) {
    $salary = $row->salary;
    $pension_employee = $row->pension_employee;
    $pension_employer = $row->pension_employer;
    $medical_employee = $row->medical_employee;
    $medical_employer = $row->medical_employer;
    $sdl = $row->sdl;
    $wcf = $row->wcf;
    $allowances = $row->allowances;
    $taxdue = $row->taxdue;
    $meals = $row->meals;
  }
$paid_heslb = null;
$remained_heslb = null;
$paid = null;
$remained = null;
  foreach ($total_loans as $key) {
      if ($key->description == "HESLB"){
          $paid_heslb = $key->paid;
          $remained_heslb = $key->remained;

      }else{
          $paid = $key->paid;
          $remained = $key->remained;
      }
  }
  foreach ($payroll_month_info as $key) {
    // $paid = $key->payroll_date;
    $cheklist = $key->pay_checklist;
    $state = $key->state;
  }

?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="page-title">
              <div class="title_left">
                <h3>Payroll Info  <?php if($payrollState == 1){ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href ="<?php echo url(); ?>flex/reports/payroll_report/?pdate=<?php echo base64_encode($payrollMonth); ?>" target = "blank"><button type="button" name="print" value ="print" class="btn btn-info">EXPORT INFO</button></a><?php } ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
              
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <h5> Salaries:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($salary,2); ?></b></h5>
                      <h5>Total Allowances:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($allowances,2); ?></b></h5>
                      <h5> Pension(Employer):
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($pension_employer,2); ?></b></h5>
                      <h5> Pension (Employee):
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($pension_employee,2); ?></b></h5>
        
        
                      <?php if ($meals) { ?>
                      <h5> Meals:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($meals,2); ?></b></h5>
                      <?php } ?>
                      <h5> Taxdue (PAYE):
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($taxdue,2); ?></b></h5>
                      <h5> WCF:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($wcf,2); ?></b></h5>
                      <h5> SDL:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($sdl,2); ?></b></h5>                  
                    
                  </div>
                </div>
              </div>              
              
              <?php if($payrollState == 0){ ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                  <div id="resultConfirmation"></div>
                    <div class="x_title">
                      <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>More Details</b></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <?php if($payrollState == 1){ ?>
                        <h5> Normal Allowances:
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format(($total_allowances-$total_overtimes-$total_bonuses),2); ?></b></h5>
                        <h5> Overtime:
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($total_overtimes,2); ?></b></h5>
                        <h5> Incentives:
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($total_bonuses,2); ?></b></h5>
                      <?php } ?>
                        <?php if ($paid_heslb) {?>
                            <h5> HESLB (Total Repayment):
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($paid_heslb,2); ?></b></h5>
                            <?php if ($remained_heslb>0) {?>
                              <h5> HESLB (Total Outstanding):
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($remained_heslb,2); ?></b></h5>
                            <?php }else {?>
                                <h5> HESLB (Total Outstanding):
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format(0,2); ?></b></h5>
                            <?php } ?>
                        <?php }?>
                        <?php if ($paid) {?>
                        <h5> Loans (Total Returns):
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($paid,2); ?></b></h5>
                        <h5> Loans (Total Outstanding):
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo number_format($remained,2); ?></b></h5>
                        <?php }?>
  <!--                      <h5> Other Deductions:-->
  <!--                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>--><?php //echo number_format($total_deductions,2); ?><!--</b></h5> -->

                    </div>

                
                    <div class="x_content">
                    <?php if($payrollState == 0 &&  session('mng_emp')){ ?>
                      <a href="javascript:void(0)" onclick="generate_checklist()"><button type="button"  class="btn btn-success"><b>PAY CHECKLIST<br>
                      <small>Full Payment</b></small></button></a>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php if($state==2 || $state==1){ ?>
                      <a href ="<?php echo url(); ?>flex/payroll/ADVtemp_less_payments/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print" value ="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                      <small>Payment With Arrears</b></small></button></a>
                      <?php } else { ?>
                        <a href ="<?php echo url(); ?>flex/payroll/less_payments/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print" value ="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                      <small>Payment With Arrears</b></small></button></a>
                      <?php } ?>
                      <?php }  else { ?>
                        <a href ="<?php echo url(); ?>flex/payroll/ADVtemp_less_payments/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print" value ="print" class="btn btn-warning"><b>PAY CHECKLIST<br>
                        <small>View</b></small></button></a>
                      <?php } ?>
                        <br>
                        <br>
                        <a target="_blank" href ="<?php echo url(); ?>flex/payroll/less_payments_print/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print_payroll" class="btn btn-primary"><b>PRINT<br></button></a>
                        <?php if($payrollState == 0) {?>
                          <a target="_self" href ="<?php echo url(); ?>flex/payroll/grossReconciliation/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print_payroll" class="btn btn-info"><b>GROSS RECON<br></button></a>
                          <a target="_self" href ="<?php echo url(); ?>flex/payroll/netReconciliation/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print_payroll" class="btn btn-info"><b>NET RECON<br></button></a>
                          <a target="_self" href ="<?php echo url(); ?>flex/payroll/sendReviewEmail/?pdate=<?php echo base64_encode($payrollMonth); ?>" ><button type="button" name="print_payroll" class="btn btn-info"><b>REVIEWED<br></button></a>
                        <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>


            </div>

            <!-- <div class="row">                        
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employees in this Payroll <b>(<?php echo date("F, Y", strtotime($payroll_date));?>)</b>  </h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul> 

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                    <div id ="resultfeedOvertime"></div>
                    <table id="datatable-keytable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Employee ID</th>
                          <th>Employee Name</th>
                          <th>Department</th>
                          <th>Net Salary</th>
                          <th>Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach ($payroll_list as $row) { ?>
                          <tr >
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->empID; ?></td>
                            <td><?php echo $row->empName; ?></td>
                            <td>Department:<?php echo $row->department; ?><br>
                            Position:<?php echo $row->position; ?></td>
                            <td><?php 
                            $amount = $row->salary + $row->allowances-$row->pension-$row->loans-$row->deductions-$row->meals-$row->taxdue;
                            echo number_format($amount,2); ?></td>
                            <td>
                            <?php if($payrollState == 0){ ?>
                              <a href="<?php echo url()."flex/payroll/temp_payroll_review/?id=".base64_encode($row->empID)."&pdate=".base64_encode($payrollMonth); ?>"   title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button> </a>
                              <?php } else { ?>
                              <a href="<?php echo url()."flex/payroll/payroll_review/?id=".base64_encode($row->empID)."&pdate=".base64_encode($payrollMonth); ?>"   title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></button> </a>                              
                              <?php } ?>
                            </td>
                         </tr>
                          <?php }  ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> -->
              <!-- END PENDING PAYROLL DETAILS -->
            <!-- </div>
           -->
          </div>
        </div>
<!-- /page content -->   

<?php

include_once "app/includes/update_allowances

<script>
    function notify(message, from, align, type) {
        $.growl({
            message: message,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            url_target: '_blank',
            mouse_over: false,

            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                '<span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                '<span data-growl="title"></span>' +
                '<span data-growl="message"></span>' +
                '<a href="#!" data-growl="url"></a>' +
                '</div>'
        });
    }

    let check = <?php echo session("email_sent"); ?>;

    if (check){
        <?php unset(session['email_sent']); ?>
        notify('Reviewed added successfuly!', 'top', 'right', 'success');
    }else{
        <?php unset(session['email_sent']); ?>
        notify('Reviewed added successfuly!', 'top', 'right', 'warning');
    }

</script>

<script >    
function generate_checklist() {
        if (confirm("Are You Sure You Want To a Full Payment Cheklist for This Payroll") == true) {
        // var id = id;
        $('#hideList').hide();
        $.ajax({
            url:"<?php echo url('flex/payroll/generate_checklist/?pdate='.base64_encode($payroll_date).'');?>",
            success:function(data)
            {
              if(data.status == 1){
              alert("Pay CheckList Generated Successiful!");

                $('#resultConfirmation').fadeOut('fast', function(){
                  $('#resultConfirmation').fadeIn('fast').html(data.message);
                });
                setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500); 
              } else {
              alert("FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin.");

                $('#resultConfirmation').fadeOut('fast', function(){
                  $('#resultConfirmation').fadeIn('fast').html(data.message);
                });
              }
               
            }
               
            });
        }
    }
</script>

 @endsection