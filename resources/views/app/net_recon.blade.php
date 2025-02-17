@extends('layouts.vertical', ['title' => 'Net Reconciliation'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')

<div class="mb-3">
    <h4 class="text-muted">Net Reconciliation</h4>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="text-muteed">Net Summary</h4>
    </div>

    <?php
        foreach ($total_previous_net as $prev){
            $total_previous_net_ = $prev->takehome;
        }

        foreach ($total_current_net as $curr){
            $total_current_net_ = $curr->takehome;
        }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><b>Previous Month</b></th>
                <td align="right"><?php echo number_format($total_previous_net_,2); ?></td>
            </tr>
            <tr>
                <th><b>Movement</b></th>
                <td align="right">
                    <?php
                        $diff = number_format($total_current_net_ - $total_previous_net_,2);

                        $num_check = intval($diff);
                        if($num_check == 0){
                            echo number_format(0,2);
                        }else{
                            echo number_format($total_current_net_ - $total_previous_net_,2);
                        }

                    ?>
                </td>
            </tr>
            <tr>
                <th><b>Current Month</b></th>
                <td align="right">
                    <?php
                        $diff = number_format($total_current_net_ - $total_previous_net_,2);
                        $num_check = intval($diff);

                        if($num_check == 0){
                            $total_current_net_ = $total_previous_net_;
                            echo number_format($total_previous_net_,2);
                        }else{
                            echo number_format($total_current_net_,2);
                        }

                    ?>
                </td>
            </tr>
        </thead>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="text-muted">Details</h4>
    </div>

    <div id="employeeList" class="card-body">
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
                    if ($current_payroll[$row->empID]){
                        foreach ($current_payroll[$row->empID] as $current){
                            if (isset($current->salary)){
                                $current_staff++;
                                $current_net_salary = ($current->salary+$current->allowances+$current->overtimes)-
                                    ($current->pension+$current->taxdue+$current->loans+$current->deductions);
                            }else{
                                $current_net_salary = 0;
                                $remarks = 'Employee Exit';
                            }
                        }
                    }else{
                        $current_net_salary = 0;
                        $remarks = 'Employee Exit';
                    }

                    if ($previous_payroll[$row->empID]){
                        foreach ($previous_payroll[$row->empID] as $previous){
                            if (isset($previous->salary)){
                                $previous_staff++;
                                $previous_net_salary = ($previous->salary+$previous->allowances+$previous->overtimes)-
                                    ($previous->pension+$previous->taxdue+$previous->loans+$previous->deductions);
                            }else{
                                $previous_net_salary = 0;
                                $remarks = 'Employee Hired';
                            }
                        }
                    }else{
                        $previous_net_salary = 0;
                        $remarks = 'Employee Hired';
                    }

                ?>
                <tr id="record<?php echo $row->empID; ?>">
                    <td width="1px"><?php echo $i?></td>
                    <td><?php echo $row->name; ?></td>
                    <td align="right">
                        <?php

                            $diff  = $current_net_salary - $previous_net_salary;

                            $num_check = intval($diff);
                            if($num_check == 0){
                                echo number_format($previous_net_salary,2);
                            }else{
                                echo number_format($current_net_salary,2);
                            }
                        ?>
                    </td>
                    <td align="right"><?php echo number_format($previous_net_salary,2); ?></td>
                    <td align="right"><?php
                        $diff  = $current_net_salary - $previous_net_salary;
                        $i_move += $diff;

                        $num_check = intval($diff);
                        if($num_check == 0){
                            echo number_format(0,2);
                        }else{
                            echo number_format($diff,2);
                        }

                        ?>
                    </td>
                    <td><?php echo $remarks; ?></td>

                </tr>
                <?php $i++; ?>
            <?php } ?>
            <tr>
                <th colspan="2" align="center"><b>Total</b></th>
                <td align="right"><?php echo number_format($total_current_net_,2); ?></td>
                <td align="right"><?php echo number_format($total_previous_net_,2); ?></td>
                <td align="right"><?php echo number_format($total_current_net_ - $total_previous_net_,2); ?></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div id="employeeList" class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
            <th><b>Employee changes</b></th>
            <th><b>Number of Employee</b></th>
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
    <div id="employeeList" class="card-body">
        <table class="table table-striped table-bordered">
            <thead>
            <th><b>Staff Exit</b></th>
            </thead>
            <tbody>
            <?php

            foreach ($emp_ids as $row) { ?>
                <?php
                $name_exit = '';
                if ($current_payroll[$row->empID]){
                    foreach ($current_payroll[$row->empID] as $current){
                        if (isset($current->salary)){
                            //
                        }else{
                            $name_exit = $row->name;
                        }
                    }
                }else{
                    $name_exit = $row->name;
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
            <th><b>Employee Joining</b></th>
            </thead>
            <tbody>
            <?php

            foreach ($emp_ids as $row) { ?>
                <?php
                $name_join = '';
                if ($previous_payroll[$row->empID]){
                    foreach ($previous_payroll[$row->empID] as $previous){
                        if (isset($previous->salary)){
                            //
                        }else{
                            $name_join = $row->name;
                        }
                    }
                }else{
                    $name_join = $row->name;
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
