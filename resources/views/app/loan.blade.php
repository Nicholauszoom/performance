@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Loan </h3>
                </div>

                <!-- <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">Go!</button>
                        </span>
                      </div>
                    </div>
                  </div> -->

            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
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
                                    <?php
                          foreach ($my_loans as $row) { ?>
                                    <tr>
                                        <td width="1px"><?php echo $row->SNo; ?></td>
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
                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if(session('appr_loan')!=''){ ?>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                        <div class="card-head px-3">
                            <h2 class="text-warning mt-2"> Approved Loans &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <button type="button" data-bs-toggle="modal" data-bs-target="#loanModal"
                                    class="btn btn-main float-end">Print Report</button></a>
                            </h2>

                        </div>

                        <div id="feedBack"></div>
                        <div id="loanList" class="card-body">

                            <table id="datatable" class="table datatable-basic table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Employeee ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Type</th>
                                        <th>Amount(Debt)</th>
                                        <th>Paid</th>
                                        <th>Remained</th>
                                        <th>Last Paid</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                            foreach ($other_loans as $row) { ?>
                                    <tr>
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->empID; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><b>Department: </b><?php echo $row->department; ?><br><b>Position: </b><?php echo $row->position; ?>
                                        </td>
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
                                        <td>
                                            <?php if($row->state==1){ ?>

                                            <a href="javascript:void(0)" onclick="pauseLoan(<?php echo $row->id; ?>)">
                                                <button class="btn btn-warning btn-sm m-1">PAUSE</button></a>

                                            <a href="<?php echo url(''); ?>/flex/loan_advanced_payments/?key=<?php echo base64_encode($row->id); ?>"
                                                title="Advanced Loan Payment">
                                                <button class="btn btn-success btn-sm m-1">ADV PAYMENT</button></a>
                                            <?php }
                               if($row->state==2){ ?>

                                            <a href="javascript:void(0)" onclick="resumeLoan(<?php echo $row->id; ?>)">
                                                <button class="btn btn-info btn-sm m-1">RESUME</button></a>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>


                <!-- Modal -->
                <div class="modal fade" id="loanModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Show Custom Task Report</h4>
                            </div>
                            <div class="modal-body">
                                <!-- Modal Form -->
                                <form id="demo-form2" enctype="multipart/form-data" target="_blank" method="post"
                                    action="<?php echo url(''); ?>/flex/reports/loanreport" data-parsley-validate
                                    class="form-horizontal form-label-left">
@csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"
                                            for="stream">Type</label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="type" class="form-control">
                                                <option value="3"> All Loans</option>
                                                <option value="0">Completed</option>
                                                <option value="1">On Progress</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">From
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="has-feedback">
                                                <input type="text" name="from"
                                                    class="form-control col-xs-12 has-feedback-left" id="single_cal1"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="has-feedback">
                                                <input type="text" name="to"
                                                    class="form-control col-xs-12 has-feedback-left" id="single_cal2"
                                                    aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback right"
                                                    aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Cancel</button>

                                        <input type="submit" value="PRINT" name="print" class="btn btn-success" />
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- Modal Form -->
                </div>
                <!-- /.modal -->

            </div>
        </div>
    </div>



    <!-- /page content -->


    <script type="text/javascript">
        function pauseLoan(id) {
            if (confirm("Are You Sure You Want to Pause This Loan") == true) {
                var loanid = id;

                $.ajax({
                        url: "<?php echo url('flex/pauseLoan'); ?>/" + loanid
                    })
                    .done(function(data) {
                        alert('SUCCESS');
                        $('#feedBack').fadeOut('fast', function() {
                            $('#feedBack').fadeIn('fast').html(data);
                        });
                        // $("#loanList").load(" #loanList");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                        /*$('#status'+id).fadeOut('fast', function(){
                             $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                           });*/
                    })
                    .fail(function() {
                        alert('Request Failed Failed!! ...');
                    });
            }
        }




        function resumeLoan(id) {
            if (confirm("Are You Sure You Want to Resume This Loan") == true) {
                var loanid = id;

                $.ajax({
                        url: "<?php echo url('flex/resumeLoan'); ?>/" + loanid
                    })
                    .done(function(data) {
                        alert('SUCCESS');
                        $('#feedBack').fadeOut('fast', function() {
                            $('#feedBack').fadeIn('fast').html(data);
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);

                    })
                    .fail(function() {
                        alert('Loan Disapproval Failed!! ...');
                    });
            }
        }
    </script>
@endsection
