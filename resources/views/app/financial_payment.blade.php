@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')('content')



<!-- Font Awesome -->
<link href="<?php echo url(); ?>style/fstdropdown/fstdropdown.css" rel="stylesheet">
<!-- /top navigation -->

<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="">
        <!-- Tabs -->
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-bars"></i> Pending Payments <small>Need To Be Responded On</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#payrollReportTab" id="home-tab" role="tab"
                                                                      data-toggle="tab" aria-expanded="true">PAYROLL</a>
                            </li>
                            <li role="presentation" class=""><a href="#overtimeTab" id="profile-tab" role="tab"
                                                                data-toggle="tab" aria-expanded="false">OVERTIME</a>
                            </li>
                            <li role="presentation" class=""><a href="#imprestTab" role="tab" id="profile-tab"
                                                                data-toggle="tab" aria-expanded="false">IMPRESTS</a>
                            </li>
                            <li role="presentation" class=""><a href="#salarytab" role="tab" id="profile-tab"
                                                                data-toggle="tab" aria-expanded="false">SALARY
                                    ADVANCE</a>
                            </li>
                            <li role="presentation" class=""><a href="#incentivesTab" role="tab" id="profile-tab"
                                                                data-toggle="tab" aria-expanded="false">INCENTIVES</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsTab" role="tab" id="profile-tab2"
                                                                data-toggle="tab"
                                                                aria-expanded="false">ARREARS(Pending)</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsTabPending" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">ARREARS(All)</a>
                            </li>
                            <li role="presentation" class=""><a href="#arrearsReportTab" role="tab" id="profile-tab2"
                                                                data-toggle="tab" aria-expanded="false">REPORTS</a>
                            </li>

                        </ul>

                        <div id="myTabContent" class="tab-content">

                            <div role="tabpanel" role="tabpanel" class="tab-pane fade active in" id="payrollReportTab"
                                 aria-labelledby="home-tab">
                                <?php if ($pendingPayroll == 0 && session('mng_paym')) { ?>
                                    <!-- <div class="col-md-12 col-sm-6 col-xs-12">
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
                                                  <input type="text" required="" placeholder="Payroll Month" name="payrolldate" class="form-control col-xs-12 has-feedback-left" id="payrollDate"  aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
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
                                    </div> -->
                                <?php } ?>

                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Payslip Mail Delivery List


                                                <?php

                                                if ($pendingPayroll == 1 && $payroll->state == 1 && session('appr_paym')) { ?>&nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:void(0)" onclick="approvePayroll()"
                                                       title="Approve Payroll" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-success"><i
                                                                    class="fa fa-check"></i> APPROVE PENDING PAYROLL
                                                        </button>
                                                    </a>


                                                    <a href="javascript:void(0)" onclick="cancelPayroll()"
                                                       title="Cancel Payroll" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-times"></i> CANCEL PENDING PAYROLL
                                                        </button>
                                                    </a>
                                                    <small><br><b>Payroll
                                                            Month: <?php echo $pendingPayroll_month; ?></b></small>


                                                <?php } ?>
                                                <?php if ($pendingPayroll == 1 && $payroll->state == 2 && session('recom_paym')) { ?>&nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:void(0)" onclick="recomendPayroll()"
                                                       title="Approve Payroll" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-success"><i
                                                                    class="fa fa-check"></i> RECOMMEND PENDING PAYROLL
                                                        </button>
                                                    </a>


                                                    <a href="javascript:void(0)" onclick="cancelPayroll()"
                                                       title="Cancel Payroll" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-danger"><i
                                                                    class="fa fa-times"></i> CANCEL PENDING PAYROLL
                                                        </button>
                                                    </a>
                                                    <small><br><b>Payroll
                                                            Month: <?php echo $pendingPayroll_month; ?></b></small>

                                                <?php } ?>

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
                                                    <?php if ($row->state == 1 || $row->state == 2 && !$row->pay_checklist == 0) { ?>

                                                        <tr id="domain<?php echo $row->id; ?>">
                                                            <td width="1px"><?php echo $row->SNo; ?></td>
                                                            <td><?php //echo $row->payroll_date; ?><?php echo date('F, Y', strtotime($row->payroll_date));; ?></td>
                                                            <td>
                                                                <?php if ($row->state == 1 || $row->state == 2) { ?>
                                                                    <span class="label label-warning">PENDING</span><br>
                                                                <?php } else { ?>
                                                                    <span class="label label-success">APPROVED</span>
                                                                    <br>
                                                                <?php } ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($row->email_status == 0) { ?>
                                                                    <span class="label label-warning">NOT SENT</span>
                                                                    <br>
                                                                <?php } else { ?>
                                                                    <span class="label label-success">SENT</span><br>
                                                                <?php } ?>
                                                            </td>

                                                            <td class="options-width">
                                                                <?php if ($row->state == 1 || $row->state == 2) { ?>
                                                                    <a href="<?php echo url('flex/payroll/temp_payroll_info/?pdate=' . base64_encode($row->payroll_date)); ?>"
                                                                       title="Info and Details"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-info btn-xs"><i
                                                                                    class="fa fa-info-circle"></i>
                                                                        </button>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo url('flex/payroll/payroll_info/?pdate=' . base64_encode($row->payroll_date)); ?>"
                                                                       title="Info and Details"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-info btn-xs"><i
                                                                                    class="fa fa-info-circle"></i>
                                                                        </button>
                                                                    </a>

                                                                    <?php if ($row->state == 0) { ?>
                                                                        <?php if ($row->pay_checklist == 1) { ?>
                                                                            <a href="<?php echo url(); ?>flex/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>"
                                                                               target="blank" title="Print Report"
                                                                               class="icon-2 info-tooltip">
                                                                                <button type="button"
                                                                                        class="btn btn-info btn-xs"><i
                                                                                            class="fa fa-file"></i>
                                                                                </button>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <a title="Checklist Report Not Ready"
                                                                               class="icon-2 info-tooltip">
                                                                                <button type="button"
                                                                                        class="btn btn-warning btn-xs">
                                                                                    <i class="fa fa-file"></i></button>
                                                                            </a>
                                                                        <?php } ?>

                                                                        <?php if ($row->email_status == 0) { ?>
                                                                            <a href="javascript:void(0)"
                                                                               onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                                                               title="Send Pay Slip as Email"
                                                                               class="icon-2 info-tooltip">
                                                                                <button type="button"
                                                                                        class="btn btn-success btn-xs">
                                                                                    <i class="fa fa-envelope"></i>
                                                                                </button>
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <a href="javascript:void(0)"
                                                                               onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                                                               title="Resend Pay Slip as Email"
                                                                               class="icon-2 info-tooltip">
                                                                                <button type="button"
                                                                                        class="btn btn-warning btn-xs">
                                                                                    <i class="fa fa-refresh"></i>&nbsp;&nbsp;<i
                                                                                            class="fa fa-envelope"></i>
                                                                                </button>
                                                                            </a>
                                                                        <?php }
                                                                    } ?>
                                                                <?php } ?>

                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane " id="overtimeTab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Overtime</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            @if(Session::has('note'))      {{ session('note') }}  @endif ?>
                                            <div id="resultfeedOvertime"></div>
                                            <table id="datatable-keytable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Employee Name</th>
                                                    <th>Department</th>
                                                    <th>Total Overtime(in Hrs.)</th>
                                                    <th>Reason(Description)</th>
                                                    <th>Amount(Tsh)</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($adv_overtime as $row) { ?>
                                                    <?php if ($row->status == 2) {
                                                        continue;
                                                    } ?>
                                                    <tr>

                                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td><?php echo "<b>Department: </b>" . $row->DEPARTMENT . "<br><b>Position: </b>" . $row->POSITION; ?></td>

                                                        <td>
                                                            <?php
                                                            echo "<b>On: </b>" . date('d-m-Y', strtotime($row->applicationDATE)) . "<br><b>Duration: </b>" . $row->totoalHOURS . " Hrs.<br><b>From: </b>" . $row->time_in . " <b> To </b>" . $row->time_out;
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row->reason; ?></td>
                                                        <td><?php echo number_format($row->earnings, 2); ?></td>

                                                        <td>
                                                            <div id="record<?php echo $row->eoid; ?>">
                                                                <?php if ($row->status == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-default">REQUESTED</span>
                                                                    </div><?php } elseif ($row->status == 1 && $pendingPayroll == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-info">RECOMENDED BY LINE MANAGER</span>
                                                                    </div><?php } elseif ($row->status == 4 && $pendingPayroll == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">APPROVED BY FINANCE</span>
                                                                    </div><?php } elseif ($row->status == 3 && $pendingPayroll == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">APPROVED BY HR</span>
                                                                    </div><?php } elseif ($row->status == 2) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">APPROVED BY CD</span>
                                                                    </div><?php } elseif ($row->status == 5) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">RETIREMENT CONFIRMED</span>
                                                                    </div><?php } elseif ($row->status == 6) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">DISSAPPROVED</span>
                                                                    </div><?php } elseif ($row->status == 7) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">UNCONFIRMED</span>
                                                                    </div><?php } elseif ($row->status == 8) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">UNCONFIRMED RETIREMENT</span>
                                                                    </div><?php } ?></div>
                                                            <br><br>


                                                            <?php if ($row->status == 1 && session('mng_emp') && $pendingPayroll == 0) { ?>

                                                                <a href="javascript:void(0)" title="Approve"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="hrapproveOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-primary btn-xs"><i
                                                                                class="fa fa-check"></i></button>
                                                                </a>

                                                                <a href="javascript:void(0)" title="Cancel"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="cancelOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-times-circle"></i></button>
                                                                </a>


                                                            <?php }
                                                            if ($row->status == 3 && session('recom_paym')) { ?>
                                                                <a href="javascript:void(0)" title="Recommend"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="fin_approveOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-primary btn-xs"><i
                                                                                class="fa fa-check"></i></button>
                                                                </a>

                                                                <a href="javascript:void(0)" title="Cancel"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="cancelOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-times-circle"></i></button>
                                                                </a>

                                                            <?php }
                                                            if ($row->status == 4 && session('appr_paym')) { ?>
                                                                <a href="javascript:void(0)" title="Approve"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="approveOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-success btn-xs"><i
                                                                                class="fa fa-check"></i></button>
                                                                </a>

                                                                <a href="javascript:void(0)" title="Cancel"
                                                                   class="icon-2 info-tooltip"
                                                                   onclick="cancelOvertime(<?php echo $row->eoid; ?>)">
                                                                    <button class="btn btn-danger btn-xs"><i
                                                                                class="fa fa-times-circle"></i></button>
                                                                </a>
                                                            <?php } ?>


                                                        </td>

                                                    </tr>

                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="salarytab" aria-labelledby="profile-tab">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Others` Salary Advance
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                    </li>
                                                </ul>

                                                <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="resultfeed"></div>
                                            <div id="resultfeedCancel"></div>
                                            @if(Session::has('note'))      {{ session('note') }}  @endif ?>
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Application Date</th>
                                                    <th>Status</th>

                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                foreach ($otherloan as $row) { ?>
                                                    <?php if ($row->status == 2 || !$row->status == 6 && session('recom_paym')) {
                                                        continue;
                                                    } ?>
                                                    <tr id="domain<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->NAME; ?></td>
                                                        <td><?php echo $row->DEPARTMENT; ?><br>
                                                            <?php echo $row->POSITION; ?>
                                                        </td>
                                                        <td><?php echo $row->TYPE; ?></td>
                                                        <td><?php echo $row->amount; ?></td>
                                                        <td><?php $datewell = explode("-", $row->application_date);
                                                            $mm = $datewell[1];
                                                            $dd = $datewell[2];
                                                            $yyyy = $datewell[0];
                                                            $clear_date = $dd . "-" . $mm . "-" . $yyyy;
                                                            echo $clear_date; ?>
                                                        </td>
                                                        <td>
                                                            <div id="status<?php echo $row->id; ?>">
                                                                <?php if ($row->status == 0) { ?>
                                                                    <div class="col-md-12">
                                                                        <span class="label label-default">SENT</span>
                                                                    </div><?php } elseif ($row->status == 6) {
                                                                    ?>
                                                                    <div class="col-md-12">
                                                                        <span class="label label-info">RECOMMENDED BY HR</span>
                                                                    </div><?php } elseif ($row->status == 2) { ?>
                                                                    <div class="col-md-12">
                                                                        <span class="label label-success">APPROVED</span>
                                                                    </div><?php } elseif ($row->status == 1) {
                                                                    ?>
                                                                    <div class="col-md-12">
                                                                        <span class="label label-info">RECOMMENDED BY FINANCE</span>
                                                                    </div><?php } elseif ($row->status == 5) { ?><?php } ?>
                                                            </div>

                                                            <div style="margin: 10px;">
                                                                <?php if (session('mng_emp') && $row->status == 0) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="hrrecommendLoan(<?php echo $row->id; ?>)"
                                                                       title="Recommend">
                                                                        <button class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>

                                                                <?php } else if ($row->status == 6 && session('recom_paym')) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="recommendLoan(<?php echo $row->id; ?>)"
                                                                       title="Recommend">
                                                                        <button class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>
                                                                <?php } ?>

                                                                <?php if (session('appr_paym') && $row->status == 1 && $pendingPayroll == 0) { ?>

                                                                    <a href="javascript:void(0)"
                                                                       onclick="approveLoan(<?php echo $row->id; ?>)">
                                                                        <button class="btn btn-success btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>

                                                                    <a href="javascript:void(0)" title="Cancel"
                                                                       class="icon-2 info-tooltip"
                                                                       onclick="cancelLoan(<?php echo $row->id; ?>)">
                                                                        <button class="btn btn-danger btn-xs"><i
                                                                                    class="fa fa-times-circle"></i>
                                                                        </button>
                                                                    </a>

                                                                <?php } ?>
                                                            </div>

                                                        </td>


                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="imprestTab" aria-labelledby="profile-tab">
                                <div id="resultfeedImprest"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Imprests </h2>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            @if(Session::has('note'))      {{ session('note') }}  @endif ?>
                                            <div id="resultfeedImprest"></div>
                                            <table id="datatable-keytable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Date Requested</th>
                                                    <th>Cost</th>
                                                    <th>Status</th>
                                                    <th>Option</th>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                foreach ($other_imprests as $row) { ?>
                                                    <?php if ($row->status == 5) {
                                                        continue;
                                                    } ?>

                                                    <tr id="recordImprest<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td>
                                                            <a class="panel-heading collapsed" role="tab"
                                                               id="headingTwo" data-toggle="collapse"
                                                               data-parent="#accordion"
                                                               href="#collapseDescription2<?php echo $row->id; ?>"
                                                               aria-expanded="false">
                                                                <span class="label label-default">DESCRIPTION</span>
                                                            </a>
                                                            <div id="collapseDescription2<?php echo $row->id; ?>"
                                                                 class="panel-collapse collapse" role="tabpanel">
                                                                <p><?php echo $row->description; ?> </p>
                                                            </div>
                                                        </td>

                                                        <td><?php echo $row->application_date ?> </td>
                                                        <td><?php echo "<b><font class='green'>REQUESTED: </font></b>" . number_format($row->requested_amount, 2) . "<br><b><font class='green'>APPROVED: </font></b>" . number_format($row->approved_amount, 2) . "<br><b><font class='green'>CONFIRMED: </font></b>" . number_format($row->confirmed_amount, 2); ?></td>


                                                        <td>
                                                            <div id="record<?php echo $row->id; ?>">
                                                                <?php if ($row->status == 0 && !$pendingPayroll == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">PENDING PAYROLL</span>
                                                                    </div><?php } elseif ($row->status == 0) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-default">REQUESTED</span>
                                                                    </div><?php } elseif ($row->status == 1) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-info">RECOMENDED BY FINANCE</span>
                                                                    </div><?php } elseif ($row->status == 9) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-info">RECOMENDED BY HR</span>
                                                                    </div><?php } elseif ($row->status == 2) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">APPROVED NOT RETIRED</span>
                                                                    </div><?php } elseif ($row->status == 3) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">CONFIRMED</span>
                                                                    </div><?php } elseif ($row->status == 4) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">RETIRED</span>
                                                                    </div><?php } elseif ($row->status == 5) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-success">RETIREMENT CONFIRMED</span>
                                                                    </div><?php } elseif ($row->status == 6) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">DISSAPPROVED</span>
                                                                    </div><?php } elseif ($row->status == 7) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">UNCONFIRMED</span>
                                                                    </div><?php } elseif ($row->status == 8) { ?>
                                                                    <div class="col-md-12"><span
                                                                                class="label label-danger">UNCONFIRMED RETIREMENT</span>
                                                                    </div><?php } ?></div>


                                                            <div style="padding: 10px;">
                                                                <?php
                                                                $pendings = $this->imprest_model->notApprovedRequirement($row->id);
                                                                if (session('mng_emp') && $row->status == 0 && $pendingPayroll == 0 && !$pendings > 0){ ?>

                                                                    <a href="javascript:void(0)"
                                                                       onclick="hr_recommendImprest(<?php echo $row->id; ?>)"
                                                                       title="Recommend">
                                                                        <button class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>

                                                                <?php }else if (session('mng_emp') && $pendings > 0){ ?>

                                                                    <a href="javascript:void(0)"
                                                                       onclick="pendingApprovalAlert()" <?php if ($row->status == 0) { ?> title="Recommend" <?php } else { ?> title="Confirm retirement" <?php } ?>>
                                                                        <button class="btn btn-success btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>
                                                                <?php }else{ ?>
                                                                <?php if (session('mng_emp') && $row->status == 2){
                                                                $pending = $this->imprest_model->notRetiredRequirement($row->id);
                                                                if ($pending == 0){
                                                                ?>
                                                                <a href="javascript:void(0)"
                                                                   onclick="confirmImprestRetirement(<?php echo $row->id; ?>)"
                                                                   title="Approve Retirement">
                                                                    <button type="button"
                                                                            class="btn btn-success btn-xs"><i
                                                                                class="fa fa-check"></i></button>
                                                                    <?php }
                                                                    }
                                                                    }

                                                                    if (session('appr_paym') && $pendingPayroll == 0) {
                                                                        if ($row->status == 1 || $row->status == 5) { ?>

                                                                            <a href="javascript:void(0)"
                                                                               onclick="approveImprest(<?php echo $row->id; ?>)"
                                                                               title="Approve">
                                                                                <button class="btn btn-success btn-xs">
                                                                                    <i class="fa fa-check"></i></button>
                                                                            </a>
                                                                        <?php }
                                                                    }
                                                                    if ($row->status == 1 || $row->status == 2) { ?>
                                                                        <!-- <a href="javascript:void(0)" onclick="disapproveImprest(<?php echo $row->id; ?>)">
                                <button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></a> -->
                                                                    <?php }

                                                                    if (session('recom_paym') && $row->status == 9){

                                                                    if ($row->status == 9) {
                                                                        $pendings = $this->imprest_model->notConfirmedRequirement($row->id);
                                                                        if ($pendings > 0) { ?>
                                                                            <a href="javascript:void(0)"
                                                                               onclick="pendingConfirmationAlert()">
                                                                                <button class="btn btn-primary btn-xs">
                                                                                    <i class="fa fa-check"></i></button>
                                                                            </a>
                                                                        <?php } else { ?>

                                                                            <a href="javascript:void(0)"
                                                                               onclick="recommendImprest(<?php echo $row->id; ?>)">
                                                                                <button class="btn btn-primary btn-xs">
                                                                                    <i class="fa fa-check"></i></button>
                                                                            </a>

                                                                        <?php }
                                                                    }
                                                                    if ($row->status == 2 || $row->status == 3) { ?>

                                                                        <a href="javascript:void(0)"
                                                                           onclick="unconfirmImprest(<?php echo $row->id; ?>)">
                                                                            <button class="btn btn-warning btn-xs"><i
                                                                                        class="fa fa-times"></i>
                                                                            </button>
                                                                        </a>

                                                                    <?php }
                                                                    if ($row->status == 4 || $row->status == 3 || $row->status == 8) {
                                                                    $pendings = $this->imprest_model->notRetiredRequirement($row->id);
                                                                    if ($pendings > 0) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="pendingRetireAlert()">
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-xs"><i
                                                                                    class="fa fa-times"></i></button>
                                                                        <?php } else { ?>


                                                                        <?php }
                                                                        }
                                                                        } ?>

                                                            </div>

                                                        </td>


                                                        <td class="options-width">
                                                            <a href="<?php echo url() . "flex/imprest/imprest_info/?id=" . base64_encode($row->id); ?>"
                                                               title="Info and Details" class="icon-2 info-tooltip">
                                                                <button type="button" class="btn btn-info btn-xs"><i
                                                                            class="fa fa-info-circle"></i></button>
                                                            </a>

                                                            <a href="javascript:void(0)"
                                                               onclick="deleteImprest(<?php echo $row->id; ?>)">
                                                                <button type="button" class="btn btn-danger btn-xs"><i
                                                                            class="fa fa-times"></i></button>
                                                            </a>

                                                    </tr>

                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="incentivesTab" aria-labelledby="profile-tab">
                                <div id="resultfeedImprest"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Incentives </h2>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div id="employeeList" class="x_content">
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Employee Name</th>
                                                    <th>Department</th>
                                                    <th>Incentive Name</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <?php if ($pendingPayroll == 0) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($incentives as $row) { ?>
                                                    <?php if ($row->state == 1) {
                                                        continue;
                                                    } ?>
                                                    <tr id="record<?php echo $row->id; ?>">
                                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->name; ?></td>
                                                        <td>Department:<?php echo $row->department; ?><br>
                                                            Position:<?php echo $row->position; ?></td>
                                                        <td><?php echo $row->tag; ?></td>
                                                        <td><?php echo $row->amount; ?></td>
                                                        <td id="status<?php echo $row->id; ?>">
                                                            <?php if ($row->state == 1) { ?>
                                                                <span class="label label-success">APPROVED</span><br>
                                                            <?php } else if ($row->state == 2) { ?>
                                                                <span class="label label-success">RECOMMENDED</span><br>
                                                            <?php } else { ?>
                                                                <span class="label label-warning">NOT APPROVED</span>
                                                                <br>
                                                            <?php } ?>
                                                            <?php if ($row->state == 0 && session('mng_emp')) { ?>
                                                                <a href="javascript:void(0)"
                                                                   onclick="deleteBonus(<?php echo $row->id; ?>)"
                                                                   title="Delete Incentive Incentive"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button" class="btn btn-danger btn-xs">
                                                                        <i class="fa fa-trash"></i></button>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                        <?php if ($pendingPayroll == 0) { ?>
                                                            <td id="option<?php echo $row->id; ?>">
                                                                <?php if (session('appr_paym') && $row->state == 2) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="confirmBonus(<?php echo $row->id; ?>)"
                                                                       title="Approve Incentive"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-success btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>
                                                                <?php } else if (session('recom_paym') && $row->state == 0) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="recommendBonus(<?php echo $row->id; ?>)"
                                                                       title="Recommend Incentive"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <!-- <a href="javascript:void(0)" onclick="cancelBonus(<?php echo $row->id; ?>)" title="Cancel Confirmation" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button> </a> -->
                                                                <?php } ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } //} ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsTab" aria-labelledby="profile-tab">
                                <div id="resultfeedArrears"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Arrears </h2>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table id="datatable-arrears" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Arrear Month</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Outstanding</th>
                                                    <th>Amount Last Paid</th>
                                                    <th>Last Payment Date</th>
                                                    <?php if (session('recom_paym') || session('appr_paym')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                foreach ($pending_arrears as $row) { ?>
                                                    <?php if ($row->status == 1 || session('appr_paym') && !$row->status == 2 ||
                                                        session('recom_paym') && !$row->status == 0) {
                                                        continue;
                                                    } ?>
                                                    <tr>
                                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                                        <td><?php echo $row->empName; ?></td>
                                                        <td><?php echo date('F, Y', strtotime($row->payroll_date)) ?></td>
                                                        <td><?php echo $row->amount; ?></td>
                                                        <td><?php if ($row->status == 0) { ?>
                                                                <span class="label label-warning">REQUESTED</span>
                                                            <?php } else { ?>
                                                                <span class="label label-success">RECOMMENDED</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo($row->arrear_amount - ($row->arrear_paid + $row->amount)); ?></td>
                                                        <td><?php echo $row->amount_last_paid; ?></td>

                                                        <td><?php echo date('d-M-Y', strtotime($row->last_paid_date)); ?>
                                                        </td>
                                                        <?php if (session('recom_paym') || session('appr_paym')) { ?>
                                                            <td>
                                                                <?php if (session('appr_paym') && $row->status == 2) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="confirmArrears(<?php echo $row->id; ?>)"
                                                                       title="Approve Payment"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-success btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>

                                                                    <a href="javascript:void(0)"
                                                                       onclick="cancelArrearsPayment(<?php echo $row->id; ?>)"
                                                                       title="Cancel Payment Confirmation"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-xs"><i
                                                                                    class="fa fa-times"></i></button>
                                                                    </a>

                                                                <?php } else if (session('recom_paym') && $row->status == 0) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="recommendArrearsPayment(<?php echo $row->id; ?>)"
                                                                       title="Recommend Payment"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-check"></i></button>
                                                                    </a>

                                                                    <a href="javascript:void(0)"
                                                                       onclick="cancelArrearsPayment(<?php echo $row->id; ?>)"
                                                                       title="Cancel Payment Confirmation"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-xs"><i
                                                                                    class="fa fa-times"></i></button>
                                                                    </a>
                                                                <?php } ?>
                                                                <a href="<?php echo url() . "flex/cipay/arrears_info/?pdate=" . base64_encode($row->payroll_date); ?>"
                                                                   title="Payments and Info"
                                                                   class="icon-2 info-tooltip">
                                                                    <button type="button" class="btn btn-info btn-xs"><i
                                                                                class="fa fa-info-circle"></i></button>
                                                                </a>
                                                            </td>
                                                        <?php } ?>

                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="arrearsTabPending"
                                 aria-labelledby="profile-tab">
                                <div id="resultfeedArrears"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-list"></i>&nbsp;&nbsp;All Arrears Over a Time </h2>

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <table id="datatable-task-table" class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Payroll Month</th>
                                                    <th>Total Arrears</th>
                                                    <th>Paid</th>
                                                    <th>Outstanding</th>
                                                    <th>Amount Last Paid</th>
                                                    <th>Last Payment Date</th>
                                                    <?php if (session('mng_emp')) { ?>
                                                        <th>Option</th>
                                                    <?php } ?>
                                                </tr>
                                                </thead>


                                                <tbody>
                                                <?php
                                                $SNo = 1;
                                                foreach ($monthly_arrears as $row) { ?>
                                                    <?php if ($row->amount - $row->paid > 0) { ?>
                                                        <tr>
                                                            <td width="1px"><?php echo $SNo; ?></td>
                                                            <td><?php echo date('d-F-Y', strtotime($row->payroll_date)); ?></td>
                                                            <td><?php echo $row->amount; ?></td>
                                                            <td><?php echo $row->paid; ?></td>
                                                            <td><?php echo($row->amount - $row->paid); ?></td>
                                                            <td><?php echo $row->amount_last_paid; ?></td>

                                                            <td><?php echo date('d-F-Y', strtotime($row->last_paid_date)); ?></td>

                                                            <?php if (session('mng_emp')) { ?>
                                                                <td>
                                                                    <a href="<?php echo url() . "flex/cipay/arrears_info/?pdate=" . base64_encode($row->payroll_date); ?>"
                                                                       title="Payments and Info"
                                                                       class="icon-2 info-tooltip">
                                                                        <button type="button"
                                                                                class="btn btn-info btn-xs"><i
                                                                                    class="fa fa-info-circle"></i>
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>

                                                    <?php } ?>
                                                    <?php $SNo++;
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab"
                                 aria-labelledby="profile-tab">

                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2><i class="fa fa-pie-chart"></i>&nbsp;&nbsp;<b>Arrears Reports</b></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div id="feedBackSubmission"></div>
                                            <form method="post" class="form-horizontal form-label-left"
                                                  action="<?php echo url(); ?>flex/reports/all_arrears/"
                                                  target="blank">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">From<span
                                                                class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <select required="" name="start" class='fstdropdown-select'
                                                                id="sixth"
                                                                data-placeholder="Select Start Payroll Month">
                                                            <?php foreach ($month_list as $row) { ?>
                                                                <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">To<span
                                                                class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <select required="" name="finish" class='fstdropdown-select'
                                                                id="sixth" data-placeholder="Select End Payroll Month">
                                                            <?php foreach ($month_list as $row) { ?>
                                                                <option value="<?php echo $row->payroll_date; ?>"><?php echo date('F, Y', strtotime($row->payroll_date)); ?></option> <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div align="right" class="form-group">
                                                    <button type="submit" name="print" class="btn btn-primary">Print
                                                        Report
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Tabs -->

    </div>
</div>
<!-- /page content -->


<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                </div>
                <div class="col-sm-2">

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete1" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete1" class="btn btn-danger btn-sm">Yes</button>
                </div>
                <div class="col-sm-2">

                </div>
            </div>

        </div>
    </div>
</div>


<?php

include_once "app/includes/imprest_operations.php";
include_once "app/includes/overtime_operations.php";
include_once "app/includes/update_allowances.php";
include_once "app/includes/loan_operations

<!-- fstdropdown -->
<script src="<?php echo url(); ?>style/fstdropdown/fstdropdown.js"></script>

<script type="text/javascript">

    function resolveImprest(id) {
        if (confirm("Are You Sure You Want To Resolve This Imprest? (Action is NOT REVERSIBLE)") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({
                url: "<?php echo url('flex/resolveImprest');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedImprest').fadeOut('fast', function () {
                        $('#resultfeedImprest').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }

            });
        }
    }

    function confirmOvertime(id) {
        if (confirm("Are You Sure You Want To Confirm This Overtime?") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({
                url: "<?php echo url('flex/confirmOvertimePayment');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedOvertime').fadeOut('fast', function () {
                        $('#resultfeedOvertime').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);

                }

            });
        }
    }

    function unconfirmOvertime(id) {
        if (confirm("Are You Sure You Want To Unconfirm This Overtime?") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({
                url: "<?php echo url('flex/unconfirmOvertimePayment');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedOvertime').fadeOut('fast', function () {
                        $('#resultfeedOvertime').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);

                }

            });
        }
    }


    function recommendArrearsPayment(id) {
        if (confirm("Are You Sure You Want To Confirm this Payment?") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({
                url: "<?php echo url('flex/payroll/recommendArrearsPayment');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedArrears').fadeOut('fast', function () {
                        $('#resultfeedArrears').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);

                }

            });
        }
    }


    jQuery(document).ready(function ($) {

        $('#policy').change(function () {
            $("#policy option:selected").each(function () {
                var value = $(this).val();
                if (value == "1") {
                    $("#percentf").attr("disabled", "disabled");
                    $("#days").attr("disabled", "disabled");


                } else if (value == "2") {
                    $("#days").attr("disabled", "disabled");
                    $("#percentf").removeAttr("disabled");
                } else if (value == "3") {
                    $("#percentf").attr("disabled", "disabled");
                    $("#days").removeAttr("disabled");
                }
            });
        });
    });

</script>

<script>

    function confirmArrears(id) {
        if (confirm("Are You Sure You Want To Confirm This Arrear?") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({

                url: "<?php echo url('flex/payroll/confirmArrearsPayment');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedArrears').fadeOut('fast', function () {
                        $('#resultfeedArrears').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);

                }

            });
        }
    }

    function cancelArrearsPayment(id) {
        if (confirm("Are You Sure You Want To Cancel this Payment?") == true) {
            var id = id;
            // $('#recordRequirement'+id).show();
            $.ajax({
                url: "<?php echo url('flex/payroll/cancelArrearsPayment');?>/" + id,
                success: function (data) {
                    alert("Sussess!");
                    $('#resultfeedArrears').fadeOut('fast', function () {
                        $('#resultfeedArrears').fadeIn('fast').html(data);
                    });

                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1500);

                }

            });
        }
    }

    function approvePayroll() {

        const message = "Are you sure you want to approve this payroll?";
        const message1 = "Send payslip as email to employees?";

        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        $("#yes_delete").click(function () {
            $('#hideList').hide();
            $.ajax({
                url: "<?php echo url('flex/payroll/runpayroll');?>/<?php echo $pendingPayroll_month; ?>",
                success: function (data) {
                    if (data.status == 'OK') {
                        // alert("Payroll Approved Successifully");

                        $('#delete').modal('hide');
                        notify('Payroll approved successfully!', 'top', 'right', 'success');

                        //$('#delete1').modal('show');
                        //$('#delete1').find('.modal-body #message').text(message1);
                        //
                        //$('#delete1').on('shown.bs.modal', function (e) {
                        //    $("#yes_delete1").click(function () {
                        //        $.ajax({
                        //            url:"<?php //echo url('flex/payroll/send_payslips');?>///<?php //echo $pendingPayroll_month; ?>//",
                        //            success:function(data) {
                        //                $('#delete1').modal('hide');
                        //                setTimeout(function(){// wait for 2 secs(2)
                        //                    location.reload(); // then reload the div to clear the success notification
                        //                }, 1500);
                        //            }
                        //        });
                        //    });
                        //
                        //});


                        // SEND EMAILS
                        // if (confirm("Payroll Approved Successifully!\n Do you want to send The Payslip as Email to All Employees??") == true) {
                        //     $.ajax({
                        //        url:"<?php //echo url('flex/payroll/send_payslips');?>///<?php //echo $pendingPayroll_month; ?>//",
                        //         success:function(data) { }
                        //     });
                        //     SEND EMAILS
                        // }
                        //
                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });

                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);

                    } else {
                        // alert("Payroll Approval FAILED, Try again,  If the Error persists Contact Your System Admin.");
                        //
                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });

                        $('#delete').modal('hide');
                        notify('Payroll approval failed!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    }

                }

            });
        });

    }

    function recomendPayroll() {

        const message = "Are you sure you want to recommend this payroll?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        $("#yes_delete").click(function () {
            $('#hideList').hide();

            $.ajax({
                url: "<?php echo url('flex/payroll/recommendpayroll');?>/<?php echo $pendingPayroll_month; ?>",
                success: function (data) {
                    if (data.status == 'OK') {
                        // alert("Payroll Recommend Successifully");


                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });
                        $('#delete').modal('hide');
                        notify('Payroll recommended successfully!', 'top', 'right', 'success');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        // alert("Payroll Recommendation FAILED, Try again,  If the Error persists Contact Your System Admin.");
                        //
                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });

                        $('#delete').modal('hide');
                        notify('Payroll recommendation failed!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);

                    }

                }

            });


        });

    }

    function cancelPayroll() {

        const message = "Are you sure you want to cancel this payroll?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        $("#yes_delete").click(function () {
            $('#hideList').hide();
            $.ajax({
                url: "<?php echo url('flex/payroll/cancelpayroll');?>",
                success: function (data) {
                    if (data.status == 'OK') {
                        // alert("Payroll was Cancelled Successifully!");
                        //
                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });

                        $('#delete').modal('hide');
                        notify('Payroll cancelled successfully!', 'top', 'right', 'success');

                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);
                    } else {
                        // alert("FAILED to Cancel Payroll, Try again,  If the Error persists Contact Your System Admin.");
                        //
                        // $('#payrollFeedback').fadeOut('fast', function(){
                        //     $('#payrollFeedback').fadeIn('fast').html(data.message);
                        // });
                        $('#delete').modal('hide');
                        notify('Payroll cancellation failed!', 'top', 'right', 'danger');
                        setTimeout(function () {// wait for 2 secs(2)
                            location.reload(); // then reload the div to clear the success notification
                        }, 1500);

                    }

                }

            });
        });

    }


    function sendEmail(payrollDate) {

        if (confirm("Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??") == true) {

            $.ajax({
                url: "<?php echo url('flex/payroll/send_payslips');?>/" + payrollDate,
                success: function (data) {
                }


            });
            $('#feedBackMail').fadeOut('fast', function () {
                $('#feedBackMail').fadeIn('fast').html("<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>");
            });
            setTimeout(function () {// wait for 2 secs(2)
                location.reload(); // then reload the div to clear the success notification
            }, 1500);
        }
    }

</script>

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

</script>

 @endsection