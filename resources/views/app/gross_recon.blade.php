@extends('layouts.vertical', ['title' => 'Gross Reconciliation'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')

<div class="mb-3">
    <h4 class="text-muted">Gross Reconciliation</h4>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="text-muted">Gross Summary</h4>
    </div>

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

<div class="card">
    <div class="card-header">
        <h4 class="text-muted">Details</h4>

        <div id="feedBack" class="mt-3"></div>
    </div>

    <div id="employeeList">
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

<div class="card">
    <div id="employeeList">
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

<div class="card">
    <div id="employeeList">
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

<div class="card">
    <div id="employeeList" class="card-body">
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

@endsection
