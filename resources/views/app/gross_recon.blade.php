@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Gross Reconciliation</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div id="payrollFeedback"></div>
                    <div class="x_title"><br>
<!--                        <h2>Partial Payment</h2>-->
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Gross Summary</h2>
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th><b>Previous Month</b></th>
                                        <td align="right"><?php echo number_format($total_previous_gross,2); ?></td>
                                    </tr>
                                    <tr>
                                        <th><b>Movement</b></th>
                                        <td align="right"><?php echo number_format($total_current_gross - $total_previous_gross,2); ?></td>
                                    </tr>
                                    <tr>
                                        <th><b>Current Month</b></th>
                                        <td align="right"><?php echo number_format($total_current_gross,2); ?></td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>

                        <!-- PANEL-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Details</h2>
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th><b>S/N</b></th>
                                        <th><b>Employee Name</b></th>
                                        <th><b>Current</b></th>
                                        <th><b>Previous</b></th>
                                        <th><b>Movement</b></th>
                                        <th><b>Remarks</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $i_move=0;
                                    $current_staff = 0;
                                    $previous_staff = 0;
                                    foreach ($emp_ids as $row) { ?>
                                    <?php
                                        $remarks = '';
                                        foreach ($current_payroll[$row->empID] as $current){
                                            if (isset($current->gross)){
                                                $current_staff++;
                                                $current_gross = $current->gross;
                                            }else{
                                                $current_gross = 0;
                                                $remarks = 'Employee Exit';
                                            }
                                        }

                                        foreach ($previous_payroll[$row->empID] as $previous){
                                            if (isset($previous->gross)){
                                                $previous_staff++;
                                                $previous_gross = $previous->gross;
                                            }else{
                                                $previous_gross = 0;
                                                $remarks = 'Employee Hired';
                                            }
                                        }


                                        ?>
                                        <tr id="record<?php echo $row->empID; ?>">
                                            <td width="1px"><?php echo $i?></td>
                                            <td><?php echo $row->name; ?></td>
                                            <td align="right"><?php echo number_format($current_gross,2); ?></td>
                                            <td align="right"><?php echo number_format($previous_gross,2); ?></td>
                                            <td align="right"><?php
                                                $diff  = $current_gross - $previous_gross;
                                                $i_move += $diff;
                                                echo number_format($diff,2);
                                                ?></td>
                                            <td><?php echo $remarks; ?></td>

                                        </tr>
                                        <?php $i++; ?>
                                    <?php } ?>
                                    <tr>
                                        <th colspan="2" align="center"><b>Total</b></th>
                                        <td align="right"><?php echo number_format($total_current_gross,2); ?></td>
                                        <td align="right"><?php echo number_format($total_previous_gross,2); ?></td>
                                        <td align="right"><?php echo number_format($i_move,2); ?></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="x_panel">

                            <div class="x_title">
                                <!--                                <h2>Notes</h2>-->
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <th><b>Staff changes</b></th>
                                    <th><b>Number of staff</b></th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Last month</td>
                                        <td align="right"><?php echo $previous_staff; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Current month</td>
                                        <td align="right"><?php echo $current_staff; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="x_panel">

                            <div class="x_title">
                                <!--                                <h2>Notes</h2>-->
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <th><b>Staff Exit</b></th>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach ($emp_ids as $row) { ?>
                                        <?php
                                        $name_exit = '';
                                        foreach ($current_payroll[$row->empID] as $current){
                                            if (isset($current->gross)){
                                               //
                                            }else{
                                                $name_exit = $row->name;
                                            }
                                        }
                                        ?>
                                        <?php if ($name_exit != '') {?>
                                            <tr>
                                                <td><?php echo $name_exit; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="x_panel">

                            <div class="x_title">
                                <!--                                <h2>Notes</h2>-->
                                <div class="clearfix"></div>
                                <div id="feedBack"></div>
                            </div>

                            <div id="employeeList" class="x_content">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <th><b>Staff Joining</b></th>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach ($emp_ids as $row) { ?>
                                        <?php
                                        $name_join = '';
                                        foreach ($previous_payroll[$row->empID] as $previous){
                                            if (isset($previous->gross)){
                                                //
                                            }else{
                                                $name_join = $row->name;
                                            }
                                        }
                                        ?>
                                        <?php if ($name_join != '') {?>
                                            <tr>
                                                <td><?php echo $name_join; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!--Employee Incentive List for this Montyh-->
        </div>
    </div>
</div>
<!-- /page content -->

<?php 
?>



 @endsection