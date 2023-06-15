<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Annual Leave Report</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">

</head>

<body>

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>

        <div style="margin-top:20px;">
            <div class="col-md-12">

                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">HC-HUB
                                    </h5>
                                    </p>
                                    <p class="p-space">5th & 6th Floor, Uhuru Heights</p>
                                    <p class="p-space">Bibi Titi Mohammed Road</p>
                                    <p class="p-space">P.O. Box 31, Dar es salaam </p>
                                    <p class="p-space">+255 22 22119422/2111990 </p>
                                    <p class="p-space"> web:<a href="www.bancabc.co.tz">www.bancabc.co.tz</a></p>
                                </div>
                            </td>
                            <td> </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="box-text text-end">
                                    <img src="{{ asset('assets/images/logo-dif2.png') }}" alt="logo here" width="180px"
                                        height="150px" class="image-fluid">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <hr>

                <table class="table" style="background-color: #165384; color:white">
                    <thead>
                        <tr>
                            <td class="">
                                <div class="box-text">
                                    <h5 style="font-weight:bolder;text-align: left;">Leave Balance</h5>
                                </div>
                            </td>
                            <td>
                                <div class="box-text text-end"></div>
                            </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the date of
                                    {{ date('d-M-Y') }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>

                <table class="table" id="reports">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>EMP ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Leave Entitled</th>

                            <th>Opening Balance</th>
                            {{-- <th>Rate</th>
                            <th>Amount</th> --}}
                            @if($nature == 1) <th>Accrual Rate</th> @endif
                            <th>Used Days</th>
                            <th>Current Balance</th>
                          @if($nature == 1)  <th>Amount</th> @endif
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                      $i=0;

                        foreach ($employees as $employee) { $i++ ?>
                       <?php
                        $flag = true;
                       if($employee->gender == 'Male' && $nature == 5){
                         $flag = true;
                        }elseif($employee->gender == 'Female' && $nature == 4){
                            $flag  = true;
                        } elseif($nature !=5 && $nature != 4){
                            $flag  = true;
                        }

                        else{
                            $flag = false;
                        }

                        ?>
                        @if($flag)
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $employee->emp_id; ?></td>
                            <td><?php echo $employee->fname; ?></td>
                            <td><?php echo $employee->lname; ?></td>
                            <td><?php echo $employee->days_entitled; ?></td>
                            <td><?php echo number_format($employee->opening_balance, 2); ?></td>
                            {{-- <td><?php echo number_format($employee->accrual_amount, 2); ?></td>
                            <td><?php echo number_format($employee->accrual_amount * $employee->opening_balance, 2); ?></td> --}}
                            @if($nature == 1)<td><?php echo number_format($employee->accrual_days, 2); ?></td> @endif
                            <td><?php echo number_format(($employee->days_spent)) ?></td>
                            <td><?php echo number_format($employee->current_balance, 2); ?></td>
                            @if($nature == 1)   <td><?php echo number_format($employee->current_balance * $employee->accrual_amount, 2); ?></td> @endif

                        </tr>
                        @else
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $employee->emp_id; ?></td>
                            <td><?php echo $employee->fname; ?></td>
                            <td><?php echo $employee->lname; ?></td>
                            <td><?php echo $employee->days_entitled*0; ?></td>
                            <td><?php echo number_format($employee->opening_balance*0, 2); ?></td>
                            {{-- <td><?php echo number_format($employee->accrual_amount*0, 2); ?></td>
                            <td><?php echo number_format($employee->accrual_amount * $employee->opening_balance, 2); ?></td> --}}
                            @if($nature == 1)<td><?php echo number_format($employee->accrual_days*0, 2); ?></td> @endif
                            <td><?php echo number_format(($employee->days_spent*0)) ?></td>
                            <td><?php echo number_format($employee->current_balance*0, 2); ?></td>
                            @if($nature == 1)   <td><?php echo number_format($employee->current_balance * $employee->accrual_amount*0, 2); ?></td> @endif

                        </tr>
                        @endif

                        <?php } ?>
                    </tbody>

                </table>
                <hr>

            </div>

        </div>



        <div id="logo2" style="margin-left: 7px; z-index: -10">
            <img src="{{ asset('assets/images/x-right.png') }}" width="100px;" height="50px;">
        </div>

    </main>
    <div class="footer">
        <table class="table footer-font">
            <tfoot>
                <tr>
                    <td class="">
                        <div class="box-text"> {{ date('l, F j, Y') }} </div>
                    </td>
                    <td>
                        <div class="box-text text-end"> </div>
                    </td>
                    <td>
                        <div class="box-text"> </div>
                    </td>
                    <td colspan="4" class="w-50" style="">
                        <i> Page <span class="pagenum">.</span></i>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ public_path('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
