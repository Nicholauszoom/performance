@extends('layouts.vertical', ['title' => 'My Loans'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">


            <div class="clearfix"></div>

            <div class="row">
                <!--MY APPLICATIONS -->



                <div class="col-md-12 col-sm-12 col-xs-12">
                    @can('view-my-loans')

                        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                            <div class="card-head px-3 py-1">
                                <h2>My Loans
                                </h2>

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
                                @if (Session::has('note'))
                                    {{ session('note') }}
                                @endif
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Application Date</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                          @foreach ($myloan as $row)
                                        <tr id="domain<?php echo $row->id; ?>">
                                            <td width="1px"><?php echo $row->sno; ?></td>
                                            <td><?php echo $row->TYPE; ?></td>
                                            <td><?php echo $row->amount; ?></td>
                                            <td><?php $datewell = explode('-', $row->application_date);
                                            $mm = $datewell[1];
                                            $dd = $datewell[2];
                                            $yyyy = $datewell[0];
                                            $clear_date = $dd . '-' . $mm . '-' . $yyyy;
                                            echo $clear_date; ?>
                                            </td>
                                            <td>
                                                <div id ="status<?php echo $row->id; ?>">
                                                    <?php if ($row->status==0){ ?>
                                                    <div class="col-md-12">
                                                        <span class="label label-default">SENT</span>
                                                    </div><?php }
                                    elseif($row->status==1){?>
                                                    <div class="col-md-12">
                                                        <span class="label label-info">RECOMMENDED</span>
                                                    </div><?php }
                                    elseif($row->status==2){  ?>
                                                    <div class="col-md-12">
                                                        <span class="label label-success">APPROVED</span>
                                                    </div><?php }
                                    elseif($row->status==3){?>
                                                    <div class="col-md-12">
                                                        <span class="label label-warning">HELD</span>
                                                    </div><?php }
                                    elseif($row->status==5){?>
                                                    <div class="col-md-12">
                                                        <span class="label label-danger">DISAPPROVED</span>
                                                    </div><?php }  ?>
                                                </div>
                                            </td>

                                            <td>

                                                <?php   if($row->status==0 || $row->status==3){ ?>

                                                <a href="javascript:void(0)" onclick="cancelLoan(<?php echo $row->id; ?>)">
                                                    <button class="btn btn-warning btn-xs">CANCEL</button></a>
                                                <?php }  ?>

                                                <a href="<?php echo url(''); ?>/flex/updateloan/{{ $row->id }}"
                                                    title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                                        class="btn btn-main btn-xs"><i class="ph-info"></i> | <i
                                                            class="ph-pencil"></i></button> </a>

                                            </td>

                                            <td>
                                                <?php echo '<b>HR: </b>' . $row->reason_hr . '<br><b>Finance: </b>' . $row->reason_finance; ?>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @endcan

                </div>


                <div class="col-md-12 col-sm-12 col-xs-12">

                    @can('view-my-aproved-loans')

                        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                            <div class="card-head px-2">
                                <h5 class="text-main mt-2"> My Approved Loans </h5>

                                <div class="clearfix"></div>
                            </div>

                            <div id="feedBack"></div>
                            <div id="loanList" class="card-body">

                                <table id="datatable" class="table datatable-basic table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Type</th>
                                            <th>Amount(Debt)</th>
                                            <th>Paid</th>
                                            <th>Remained</th>
                                            <th>Last Paid</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                    @foreach ($my_loans as $row)
                                        <tr>
                                            <td width="1px"><?php echo $row->SNo;?></td>
                                            <td><?php echo $row->description; ?></td>
                                            <td><?php echo number_format($row->amount, 2); ?></td>
                                            <td><?php echo number_format($row->paid, 2); ?></td>
                                            <td><?php echo number_format($row->amount - $row->paid, 2); ?></td>
                                            <td><?php echo number_format($row->amount_last_paid, 2); ?>
                                                <?php if($row->state==1){ ?> <div class="col-md-12"><span
                                                        class="label label-danger">ACTIVE</span></div><?php } elseif($row->state==0){ ?><div
                                                    class="col-md-12"><span class="label label-success">COMPLETED</span></div>
                                                <?php } elseif($row->state==2){ ?><div class="col-md-12"><span
                                                        class="label label-warning">PAUSED</span></div><?php } ?>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @endcan

                </div>
            </div>


        </div>

        {{-- </[object Object]> --}}
        <script>
            jQuery(document).ready(function($) {

                $('#advance_type').change(function() {

                    $("#advance_type option:selected").each(function() {
                        var value = $(this).val();
                        if (value == "1") {
                            $('#amount_mid').show();
                            $("#amount_midf").removeAttr("disabled");
                            $('#monthly_deduction').hide();
                            $("#monthly_deductionf").attr("disabled", "disabled");

                        } else if (value == "2") {
                            $('#amount').show();
                            $('#monthly_deduction').show();
                            $("#amountf").removeAttr("disabled");
                            $("#monthly_deductionf").removeAttr("disabled");
                            $('#amount_mid').hide();
                            $("#amount_midf").attr("disabled", "disabled");

                        }

                    });
                });


                $('#type').change(function() {

                    $("#type option:selected").each(function() {
                        var value = $(this).val();
                        if (value == "1") {
                            $('#deduction').show();
                            $('#index_no').hide();
                            $("#index_nof").attr("disabled", "disabled");
                            $("#deductionf").removeAttr("disabled");

                        } else if (value == "2") {
                            $('#index_no').show();
                            $('#deduction').hide();
                            $("#deductionf").attr("disabled", "disabled");
                            $("#index_nof").removeAttr("disabled");

                        }

                    });
                });


            });
        </script>
    @endsection
