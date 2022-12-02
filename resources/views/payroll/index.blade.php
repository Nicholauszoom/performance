@extends('layouts.vertical', ['title' => 'Audit-trail'])

@push('head-script')
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
@include('layouts.shared.page-header')
@endsection

@section('content')

<!-- Basic datatable -->
<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Audit Trail</h5>
    </div>

    <div class="row">
        <?php //if($pendingPayroll==0 && $this->session->userdata('mng_paym')){ ?>
        <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Run Payroll</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="payrollFeedback"></div>
                    <form autocomplete="off" id="initPayroll" method="POST" class="form-horizontal form-label-left">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Payroll Month</label>
                        <div class="form-group">
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <div class="has-feedback">
                                        <input type="text" required="" placeholder="Payroll Month" name="payrolldate"
                                            class="form-control col-xs-12 has-feedback-left" id="payrollDate"
                                            aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback right"
                                            aria-hidden="true"></span>
                                    </div>
                                    <span class="input-group-btn">
                                        <button name="init" class="btn btn-success">RUN PAYROLL</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php //} ?>

        <div id="hideList" class="col-md-12 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Payslip Mail Delivery List


                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="feedBackMail"></div>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Payroll Month</th>
                                <th>Status</th>
                                <th>Mail Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                        foreach ($payrollList as $row) { ?>

                            <tr id="domain<?php echo $row->id;?>">
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php //echo $row->payroll_date; ?><?php echo date('F, Y', strtotime($row->payroll_date));; ?>
                                </td>
                                <td>
                                    <?php if($row->state==1 || $row->state==2 ){   ?>

                                    <span class="label label-warning">PENDING</span><br>

                                    <?php if(!$row->pay_checklist==1){ ?>
                                    <script>
                                    setTimeout(function() {
                                        var url =
                                            "<?php echo base_url('index.php/payroll/temp_payroll_info/?pdate='.base64_encode($payrollList[0]->payroll_date))?>"
                                        window.location.href = url;
                                    }, 1000)
                                    </script>
                                    <?php  }?>

                                    <?php } else { ?>
                                    <span class="label label-success">APPROVED</span><br>
                                    <?php  } ?>
                                </td>
                                <td>
                                    <?php if($row->email_status==0){ ?>
                                    <span class="label label-warning">NOT SENT</span><br>
                                    <?php } else { ?>
                                    <span class="label label-success">SENT</span><br>
                                    <?php  } ?>
                                </td>

                                <td class="options-width">
                                    <?php if($row->state==1 || $row->state==2){ ?>

                                    <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                        class="icon-2 info-tooltip">
                                        <button type="button" class="btn btn-danger btn-xs"> <i
                                                class="fa fa-times"></i></button></a>

                                    <a href="<?php echo base_url('index.php/payroll/temp_payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                        title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                            class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
                                    <?php } else {  ?>
                                    <a href="<?php echo base_url('index.php/payroll/payroll_info/?pdate='.base64_encode($row->payroll_date));?>"
                                        title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                            class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>

                                    <?php if($row->state==0){ ?>
                                    <?php if($row->pay_checklist==1){ ?>
                                    <a href="<?php echo base_url(); ?>index.php/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>"
                                        target="blank" title="Print Report" class="icon-2 info-tooltip"><button
                                            type="button" class="btn btn-info btn-xs"><i
                                                class="fa fa-file"></i></button> </a>
                                    <?php } else {  ?>
                                    <a title="Checklist Report Not Ready" class="icon-2 info-tooltip"><button
                                            type="button" class="btn btn-warning btn-xs"><i
                                                class="fa fa-file"></i></button> </a>
                                    <?php } ?>

                                    <?php if($row->email_status==0){ ?>
                                    <a href="javascript:void(0)"
                                        onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                        title="Send Pay Slip as Email" class="icon-2 info-tooltip"><button type="button"
                                            class="btn btn-success btn-xs"><i class="fa fa-envelope"></i></button> </a>
                                    <?php } else { ?>
                                    <a href="javascript:void(0)"
                                        onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                        title="Resend Pay Slip as Email" class="icon-2 info-tooltip"><button
                                            type="button" class="btn btn-warning btn-xs"><i
                                                class="fa fa-refresh"></i>&nbsp;&nbsp;<i
                                                class="fa fa-envelope"></i></button> </a>
                                    <?php } } ?>
                                    <?php } ?>

                                </td>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /basic datatable -->

@endsection
