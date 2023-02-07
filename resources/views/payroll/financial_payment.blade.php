@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')

<script src="{{ asset('assets/js/form_layouts.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
<!-- bootstrap-daterangepicker -->
<script src="{{ asset('assets/date-picker/moment.min.js') }}"></script>
<script src="{{ asset('assets/date-picker/daterangepicker.js') }}"></script>
@endpush


@section('content')
@php
    $imprest_model = new App\Models\Payroll\ImprestModel;
    $overtime = $data['overtime'];
    $imprests = $data['imprests'];
    $pending_arrears = $data['pending_arrears'];
    $monthly_arrears = $data['monthly_arrears'];
    $month_list = $data['month_list'];
    $bonus = $data['bonus'];
    $pendingPayroll = $data['pendingPayroll'];
    $incentives = $data['incentives'];
    $employee = $data['employee'];
    $otherloan = $data['otherloan'];

    $pendingPayroll_month = $data['pendingPayroll_month'];
    $pendingPayroll = $data['pendingPayroll'];
    $payroll = $data['payroll'];
    $payrollList = $data['payrollList'];
    $other_imprests = $data['other_imprests'];
    $adv_overtime = $data['adv_overtime'];
@endphp

<div class="card">
    <div class="card-header border-0">
        <h4 class="text-main">Pending Payments <small>Need To Be Responded On</small></h4>
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




    <div class="card-body">
        <div class="col-lg-12">

            <div class="border rounded p-3 mb-3">
                <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#payrollReportTab" class="nav-link active show" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Payroll
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#overtimeTab" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                            tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Overtime
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#imprestTab" class="nav-link" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Imprest
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#salarytab" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                            tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Salary Advance
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#incentivesTab" class="nav-link" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Incentives
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#arrearsTab" class="nav-link" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Arrears
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#arrearsTabPending" class="nav-link" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            (pending)Arrears
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#arrearsReportTab" class="nav-link" data-bs-toggle="tab"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            (all)Arrears
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div role="tabpanel" role="tabpanel" class="tab-pane fade active show" id="payrollReportTab"
                        aria-labelledby="home-tab">
                        <?php if ($pendingPayroll == 0 && session('mng_paym')) { ?>
                        <?php } ?>

                        <div class="col-md-12 col-sm-6 col-xs-12">
                            <div class="card">
                                <div class="card-head">
                                    <h2>Payslip Mail Delivery List


                                        <?php

                                        if ($pendingPayroll == 1 && $payroll->state == 1 && session('appr_paym')) { ?>&nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="approvePayroll()" title="Approve Payroll"
                                            class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-success"><i class="fa fa-check"></i>
                                                APPROVE PENDING PAYROLL
                                            </button>
                                        </a>


                                        <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                            class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-danger"><i class="fa fa-times"></i>
                                                CANCEL PENDING PAYROLL
                                            </button>
                                        </a>
                                        <small><br><b>Payroll
                                                Month: <?php echo $pendingPayroll_month; ?></b></small>


                                        <?php } ?>
                                        <?php if ($pendingPayroll == 1 && $payroll->state == 2 /* && session('recom_paym')*/) { ?>&nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="recomendPayroll()" title="Approve Payroll"
                                            class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-success"><i class="fa fa-check"></i>
                                                RECOMMEND PENDING PAYROLL
                                            </button>
                                        </a>


                                        <a href="javascript:void(0)" onclick="cancelPayroll()" title="Cancel Payroll"
                                            class="icon-2 info-tooltip">
                                            <button type="button" class="btn btn-danger"><i class="fa fa-times"></i>
                                                CANCEL PENDING PAYROLL
                                            </button>
                                        </a>
                                        <small><br><b>Payroll
                                                Month: <?php echo $pendingPayroll_month; ?></b></small>

                                        <?php } ?>

                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="card-body">
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
                                                <td><?php //echo $row->payroll_date; ?><?php echo date('F, Y', strtotime($row->payroll_date));; ?>
                                                </td>
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
                                                    <a href="{{route('temp_payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}"
                                                        title="Info and Details" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-info btn-xs"><i
                                                                class="fa fa-info-circle"></i>
                                                        </button>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="<?php echo base_url('index.php/payroll/payroll_info/?pdate=' . base64_encode($row->payroll_date)); ?>"
                                                        title="Info and Details" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-info btn-xs"><i
                                                                class="fa fa-info-circle"></i>
                                                        </button>
                                                    </a>

                                                    <?php if ($row->state == 0) { ?>
                                                    <?php if ($row->pay_checklist == 1) { ?>
                                                    <a href="<?php echo base_url(); ?>index.php/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>"
                                                        target="blank" title="Print Report" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-info btn-xs"><i
                                                                class="fa fa-file"></i>
                                                        </button>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a title="Checklist Report Not Ready" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-warning btn-xs">
                                                            <i class="fa fa-file"></i></button>
                                                    </a>
                                                    <?php } ?>

                                                    <?php if ($row->email_status == 0) { ?>
                                                    <a href="javascript:void(0)"
                                                        onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                                        title="Send Pay Slip as Email" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-success btn-xs">
                                                            <i class="fa fa-envelope"></i>
                                                        </button>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="javascript:void(0)"
                                                        onclick="sendEmail('<?php echo $row->payroll_date; ?>')"
                                                        title="Resend Pay Slip as Email" class="icon-2 info-tooltip">
                                                        <button type="button" class="btn btn-warning btn-xs">
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
                            <div class="card">
                                <div class="card-head">
                                    <h2>Overtime</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="card-body">
                                    <?php //echo $this->session->flashdata("note"); ?>
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
                                                <td><?php echo "<b>Department: </b>" . $row->DEPARTMENT . "<br><b>Position: </b>" . $row->POSITION; ?>
                                                </td>

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
                                                        </div>
                                                        <?php } elseif ($row->status == 1 && $pendingPayroll == 0) { ?>
                                                        <div class="col-md-12"><span class="label label-info">RECOMENDED
                                                                BY
                                                                LINE
                                                                MANAGER</span>
                                                        </div>
                                                        <?php } elseif ($row->status == 4 && $pendingPayroll == 0) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-success">APPROVED BY
                                                                FINANCE</span>
                                                        </div>
                                                        <?php } elseif ($row->status == 3 && $pendingPayroll == 0) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-success">APPROVED BY
                                                                HR</span>
                                                        </div><?php } elseif ($row->status == 2) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-success">APPROVED BY
                                                                CD</span>
                                                        </div><?php } elseif ($row->status == 5) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-success">RETIREMENT
                                                                CONFIRMED</span>
                                                        </div><?php } elseif ($row->status == 6) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-danger">DISSAPPROVED</span>
                                                        </div><?php } elseif ($row->status == 7) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-danger">UNCONFIRMED</span>
                                                        </div><?php } elseif ($row->status == 8) { ?>
                                                        <div class="col-md-12"><span
                                                                class="label label-danger">UNCONFIRMED
                                                                RETIREMENT</span>
                                                        </div><?php } ?>
                                                    </div>
                                                    <br><br>


                                                    <?php if ($row->status == 1 && /*session('mng_emp') &&*/ $pendingPayroll == 0) { ?>

                                                    <a href="javascript:void(0)" title="Approve"
                                                        class="icon-2 info-tooltip"
                                                        onclick="hrapproveOvertime(<?php echo $row->eoid; ?>)">
                                                        <button class="btn btn-main btn-xs"><i
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
                                                        <button class="btn btn-main btn-xs"><i
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
                            <div class="card">
                                <div class="card-head">
                                    <h2>Others` Salary Advance
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>

                                        <div class="clearfix"></div>
                                </div>
                                <div class="card-body">
                                    <div id="resultfeed"></div>
                                    <div id="resultfeedCancel"></div>
                                    <?php //echo $this->session->flashdata("note"); ?>
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
                                                            <span class="label label-info">RECOMMENDED
                                                                BY
                                                                HR</span>
                                                        </div><?php } elseif ($row->status == 2) { ?>
                                                        <div class="col-md-12">
                                                            <span class="label label-success">APPROVED</span>
                                                        </div><?php } elseif ($row->status == 1) {
                                                                    ?>
                                                        <div class="col-md-12">
                                                            <span class="label label-info">RECOMMENDED
                                                                BY
                                                                FINANCE</span>
                                                        </div>
                                                        <?php } elseif ($row->status == 5) { ?><?php } ?>
                                                    </div>

                                                    <div style="margin: 10px;">
                                                        <?php if (/*session('mng_emp') &&*/ $row->status == 0) { ?>
                                                        <a href="javascript:void(0)"
                                                            onclick="hrrecommendLoan(<?php echo $row->id; ?>)"
                                                            title="Recommend">
                                                            <button class="btn btn-main btn-xs"><i
                                                                    class="fa fa-check"></i></button>
                                                        </a>

                                                        <?php } else if ($row->status == 6 && session('recom_paym')) { ?>
                                                        <a href="javascript:void(0)"
                                                            onclick="recommendLoan(<?php echo $row->id; ?>)"
                                                            title="Recommend">
                                                            <button class="btn btn-main btn-xs"><i
                                                                    class="fa fa-check"></i></button>
                                                        </a>
                                                        <?php } ?>

                                                        <?php if (/*session('appr_paym') &&*/ $row->status == 1 && $pendingPayroll == 0) { ?>

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
                    <div role="tabpanel" class="tab-pane fade" id="imprestTab"
                    aria-labelledby="profile-tab">
                    <div id="resultfeedImprest"></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-head">
                                <h2>Imprests </h2>

                                <div class="clearfix"></div>
                            </div>
                            <div class="card-body">
                                <?php //echo $this->session->flashdata("note"); ?>
                                <div id="resultfeedImprest"></div>
                                <table id="datatable-keytable"
                                    class="table table-striped table-bordered">
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
                                                    <span
                                                        class="label label-default">DESCRIPTION</span>
                                                </a>
                                                <div id="collapseDescription2<?php echo $row->id; ?>"
                                                    class="panel-collapse collapse" role="tabpanel">
                                                    <p><?php echo $row->description; ?> </p>
                                                </div>
                                            </td>

                                            <td><?php echo $row->application_date ?> </td>
                                            <td><?php echo "<b><font class='green'>REQUESTED: </font></b>" . number_format($row->requested_amount, 2) . "<br><b><font class='green'>APPROVED: </font></b>" . number_format($row->approved_amount, 2) . "<br><b><font class='green'>CONFIRMED: </font></b>" . number_format($row->confirmed_amount, 2); ?>
                                            </td>


                                            <td>
                                                <div id="record<?php echo $row->id; ?>">
                                                    <?php if ($row->status == 0 && !$pendingPayroll == 0) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-danger">PENDING
                                                            PAYROLL</span>
                                                    </div><?php } elseif ($row->status == 0) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-default">REQUESTED</span>
                                                    </div><?php } elseif ($row->status == 1) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-info">RECOMENDED BY
                                                            FINANCE</span>
                                                    </div><?php } elseif ($row->status == 9) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-info">RECOMENDED BY
                                                            HR</span>
                                                    </div><?php } elseif ($row->status == 2) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-success">APPROVED NOT
                                                            RETIRED</span>
                                                    </div><?php } elseif ($row->status == 3) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-success">CONFIRMED</span>
                                                    </div><?php } elseif ($row->status == 4) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-success">RETIRED</span>
                                                    </div><?php } elseif ($row->status == 5) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-success">RETIREMENT
                                                            CONFIRMED</span>
                                                    </div><?php } elseif ($row->status == 6) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-danger">DISSAPPROVED</span>
                                                    </div><?php } elseif ($row->status == 7) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-danger">UNCONFIRMED</span>
                                                    </div><?php } elseif ($row->status == 8) { ?>
                                                    <div class="col-md-12"><span
                                                            class="label label-danger">UNCONFIRMED
                                                            RETIREMENT</span>
                                                    </div><?php } ?>
                                                </div>


                                                <div style="padding: 10px;">
                                                    <?php
                                            $pendings = $imprest_model->notApprovedRequirement($row->id);
                                            if (/*session('mng_emp') &&*/ $row->status == 0 && $pendingPayroll == 0 && !$pendings > 0){ ?>

                                                    <a href="javascript:void(0)"
                                                        onclick="hr_recommendImprest(<?php echo $row->id; ?>)"
                                                        title="Recommend">
                                                        <button class="btn btn-main btn-xs"><i
                                                                class="fa fa-check"></i></button>
                                                    </a>

                                                    <?php }else if (/*session('mng_emp') &&*/ $pendings > 0){ ?>

                                                    <a href="javascript:void(0)"
                                                        onclick="pendingApprovalAlert()"
                                                        <?php if ($row->status == 0) { ?>
                                                        title="Recommend" <?php } else { ?>
                                                        title="Confirm retirement" <?php } ?>>
                                                        <button class="btn btn-success btn-xs"><i
                                                                class="fa fa-check"></i></button>
                                                    </a>
                                                    <?php }else{ ?>
                                                    <?php if (/*session('mng_emp') &&*/ $row->status == 2){
                                            $pending = $imprest_model->notRetiredRequirement($row->id);
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

                                                if (/*session('appr_paym') &&*/ $pendingPayroll == 0) {
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

                                                if (/*session('recom_paym') && */ $row->status == 9){

                                                if ($row->status == 9) {
                                                    $pendings = $imprest_model->notConfirmedRequirement($row->id);
                                                    if ($pendings > 0) { ?>
                                                        <a href="javascript:void(0)"
                                                            onclick="pendingConfirmationAlert()">
                                                            <button class="btn btn-main btn-xs">
                                                                <i class="fa fa-check"></i></button>
                                                        </a>
                                                        <?php } else { ?>

                                                        <a href="javascript:void(0)"
                                                            onclick="recommendImprest(<?php echo $row->id; ?>)">
                                                            <button class="btn btn-main btn-xs">
                                                                <i class="fa fa-check"></i></button>
                                                        </a>

                                                        <?php }
                                                }
                                                if ($row->status == 2 || $row->status == 3) { ?>

                                                        <a href="javascript:void(0)"
                                                            onclick="unconfirmImprest(<?php echo $row->id; ?>)">
                                                            <button
                                                                class="btn btn-warning btn-xs"><i
                                                                    class="fa fa-times"></i>
                                                            </button>
                                                        </a>

                                                        <?php }
                                                if ($row->status == 4 || $row->status == 3 || $row->status == 8) {
                                                $pendings = $imprest_model->notRetiredRequirement($row->id);
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
                                                <a href="{{route('imprest.imprest_info',['id'=>base64_encode($row->id)])}}"
                                                    title="Info and Details"
                                                    class="icon-2 info-tooltip">
                                                    <button type="button"
                                                        class="btn btn-info btn-xs"><i
                                                            class="fa fa-info-circle"></i></button>
                                                </a>

                                                <a href="javascript:void(0)"
                                                    onclick="deleteImprest(<?php echo $row->id; ?>)">
                                                    <button type="button"
                                                        class="btn btn-danger btn-xs"><i
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



            <div role="tabpanel" class="tab-pane fade" id="arrearsTab"
                aria-labelledby="profile-tab">
                <div id="resultfeedArrears"></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-head">
                            <h2>Arrears </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-arrears"
                                class="table table-striped table-bordered">
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
                                        <?php //if (session('recom_paym') || session('appr_paym')) { ?>
                                        <th>Option</th>
                                        <?php //} ?>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                        foreach ($pending_arrears as $row) { ?>
                                    <?php if ($row->status == 1 || /*session('appr_paym') &&*/ !$row->status == 2 ||
                                /*session('recom_paym') && */ !$row->status == 0) {
                                continue;
                            } ?>
                                    <tr>
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->empName; ?></td>
                                        <td><?php echo date('F, Y', strtotime($row->payroll_date)) ?>
                                        </td>
                                        <td><?php echo $row->amount; ?></td>
                                        <td><?php if ($row->status == 0) { ?>
                                            <span class="label label-warning">REQUESTED</span>
                                            <?php } else { ?>
                                            <span class="label label-success">RECOMMENDED</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo($row->arrear_amount - ($row->arrear_paid + $row->amount)); ?>
                                        </td>
                                        <td><?php echo $row->amount_last_paid; ?></td>

                                        <td><?php echo date('d-M-Y', strtotime($row->last_paid_date)); ?>
                                        </td>
                                        <?php// if (session('recom_paym') || session('appr_paym')) { ?>
                                        <td>
                                            <?php if (/*session('appr_paym') &&*/ $row->status == 2) { ?>
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

                                            <?php } else if (/*session('recom_paym') && */ $row->status == 0) { ?>
                                            <a href="javascript:void(0)"
                                                onclick="recommendArrearsPayment(<?php echo $row->id; ?>)"
                                                title="Recommend Payment"
                                                class="icon-2 info-tooltip">
                                                <button type="button"
                                                    class="btn btn-main btn-xs"><i
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
                                            <a href="{{route('cipay.arrears_info',['pdate'=> base64_encode($row->payroll_date)])}}"
                                                title="Payments and Info"
                                                class="icon-2 info-tooltip">
                                                <button type="button"
                                                    class="btn btn-info btn-xs"><i
                                                        class="fa fa-info-circle"></i></button>
                                            </a>
                                        </td>
                                        <?php } ?>

                                    </tr>
                                    <?php// } ?>
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
                <div class="card">
                    <div class="card-head">
                        <h2><i class="fa fa-list"></i>&nbsp;&nbsp;All Arrears Over a Time
                        </h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="card-body">
                        <table id="datatable-task-table"
                            class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Payroll Month</th>
                                    <th>Total Arrears</th>
                                    <th>Paid</th>
                                    <th>Outstanding</th>
                                    <th>Amount Last Paid</th>
                                    <th>Last Payment Date</th>
                                    <?php //if (session('mng_emp')) { ?>
                                    <th>Option</th>
                                    <?php //} ?>
                                </tr>
                            </thead>


                            <tbody>
                                <?php
                    $SNo = 1;
                    foreach ($monthly_arrears as $row) { ?>
                                <?php if ($row->amount - $row->paid > 0) { ?>
                                <tr>
                                    <td width="1px"><?php echo $SNo; ?></td>
                                    <td><?php echo date('d-F-Y', strtotime($row->payroll_date)); ?>
                                    </td>
                                    <td><?php echo $row->amount; ?></td>
                                    <td><?php echo $row->paid; ?></td>
                                    <td><?php echo($row->amount - $row->paid); ?></td>
                                    <td><?php echo $row->amount_last_paid; ?></td>

                                    <td><?php echo date('d-F-Y', strtotime($row->last_paid_date)); ?>
                                    </td>

                                    <?php //if (session('mng_emp')) { ?>
                                    <td>
                                        <a href="<?php echo base_url() . "index.php/cipay/arrears_info/?pdate=" . base64_encode($row->payroll_date); ?>"
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
                    //} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="arrearsReportTab"
        aria-labelledby="profile-tab">

        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="card">
                <div class="card-head">
                    <h2><i class="fa fa-pie-chart"></i>&nbsp;&nbsp;<b>Arrears
                            Reports</b></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <div id="feedBackSubmission"></div>
                    <form method="post" class="form-horizontal form-label-left"
                        action="{route('reports.all_arrears')}}" target="blank">
                        <div class="form-group">
                            <label
                                class="control-label col-md-3 col-sm-3 col-xs-12">From<span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select required="" name="start"
                                    class='fstdropdown-select' id="sixth"
                                    data-placeholder="Select Start Payroll Month">
                                    <?php foreach ($month_list as $row) { ?>
                                    <option value="<?php echo $row->payroll_date; ?>">
                                        <?php echo date('F, Y', strtotime($row->payroll_date)); ?>
                                    </option> <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label
                                class="control-label col-md-3 col-sm-3 col-xs-12">To<span
                                    class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select required="" name="finish"
                                    class='fstdropdown-select' id="sixth"
                                    data-placeholder="Select End Payroll Month">
                                    <?php foreach ($month_list as $row) { ?>
                                    <option value="<?php echo $row->payroll_date; ?>">
                                        <?php echo date('F, Y', strtotime($row->payroll_date)); ?>
                                    </option> <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div align="right" class="form-group">
                            <button type="submit" name="print"
                                class="btn btn-main">Print
                                Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div role="tabpanel" class="tab-pane fade" id="incentivesTab"
    aria-labelledby="profile-tab">
    <div id="resultfeedImprest"></div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-head">
                <h2>Incentives </h2>

                <div class="clearfix"></div>
            </div>
            <div id="employeeList" class="card-body">
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
                                <span
                                    class="label label-success">APPROVED</span><br>
                                <?php } else if ($row->state == 2) { ?>
                                <span
                                    class="label label-success">RECOMMENDED</span><br>
                                <?php } else { ?>
                                <span class="label label-warning">NOT
                                    APPROVED</span>
                                <br>
                                <?php } ?>
                                <?php if ($row->state == 0 && session('mng_emp')) { ?>
                                <a href="javascript:void(0)"
                                    onclick="deleteBonus(<?php echo $row->id; ?>)"
                                    title="Delete Incentive Incentive"
                                    class="icon-2 info-tooltip">
                                    <button type="button"
                                        class="btn btn-danger btn-xs">
                                        <i class="ph-trash"></i></button>
                                </a>
                                <?php } ?>
                            </td>
                            <?php if ($pendingPayroll == 0) { ?>
                            <td id="option<?php echo $row->id; ?>">
                                <?php if (/*session('appr_paym') &&*/ $row->state == 2) { ?>
                                <a href="javascript:void(0)"
                                    onclick="confirmBonus(<?php echo $row->id; ?>)"
                                    title="Approve Incentive"
                                    class="icon-2 info-tooltip">
                                    <button type="button"
                                        class="btn btn-success btn-xs"><i
                                            class="fa fa-check"></i></button>
                                </a>
                                <?php } else if (/*session('recom_paym') && */ $row->state == 0) { ?>
                                <a href="javascript:void(0)"
                                    onclick="recommendBonus(<?php echo $row->id; ?>)"
                                    title="Recommend Incentive"
                                    class="icon-2 info-tooltip">
                                    <button type="button"
                                        class="btn btn-main btn-xs"><i
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

                </div>
            </div>
        </div>
        <!-- /page content -->


        <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="message"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-main btn-sm" data-dismiss="modal">No</button>
                            <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                        </div>
                        <div class="col-sm-2">

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete1"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="message"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-main btn-sm" data-dismiss="modal">No</button>
                            <button type="button" id="yes_delete1" class="btn btn-danger btn-sm">Yes</button>
                        </div>
                        <div class="col-sm-2">

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


</div>

@endsection

