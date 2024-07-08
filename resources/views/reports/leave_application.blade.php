<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Annual Leave Report</title>
    <link rel="stylesheet" href="{{ public_path('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/report.css') }}">

</head>

<body>

    @php
        $brandSetting = \App\Models\BrandSetting::first();
    @endphp

    <main class="body-font p-1">
        <div id="logo" style="margin-left: 7px; z-index: -10">
            <img src="{{ public_path('assets/images/x-left.png') }}" width="100px;" height="50px;">
        </div>

        <div style="margin-top:20px;">
            <div class="col-md-12">

                <table class="table" id="img">
                    <tfoot>
                        <tr>
                            <td class="">
                                <div class="box-text text-right" style="text-align:left;">
                                    <p class="p-space">
                                    <h5 style="font-weight:bolder;margin-top:15px;">
                                        @if ($brandSetting->report_system_name)
                                            {{ $brandSetting->report_system_name }}
                                        @else
                                            HC-HUB
                                        @endif

                                    </h5>
                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_1)
                                            {{ $brandSetting->address_1 }}
                                        @else
                                            5th & 6th Floor, Uhuru Heights
                                        @endif

                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_2)
                                            {{ $brandSetting->address_2 }}
                                        @else
                                            Bibi Titi Mohammed Road
                                        @endif
                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_3)
                                            {{ $brandSetting->address_3 }}
                                        @else
                                            P.O. Box 31, Dar es salaam
                                        @endif


                                    </p>
                                    <p class="p-space">
                                        @if ($brandSetting->address_4)
                                            {{ $brandSetting->address_4 }}
                                        @else
                                            +255 22 22119422/2111990
                                        @endif
                                    </p>
                                    <p class="p-space"> web:<a href="www.bancabc.co.tz">
                                            @if ($brandSetting->website_url)
                                                {{ $brandSetting->website_url }}
                                            @else
                                                www.bancabc.co.tz
                                            @endif

                                        </a></p>
                                </div>
                            </td>
                            <td> </td>
                            <td>
                                <div class="box-text"> </div>
                            </td>

                            <td colspan="4" class="w-50" style="">
                                <div class="box-text text-end">
                                    @if ($brandSetting->report_logo)
                                        <img src="{{ asset('storage/' . $brandSetting->report_logo) }}" alt="logo here"
                                            width="180px" height="150px" class="image-fluid">
                                    @else
                                        <img src="{{ public_path('assets/images/logo-dif2.png') }}" alt="logo here"
                                            width="180px" height="150px" class="image-fluid">
                                    @endif
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
                                    <h5 style="font-weight:bolder;text-align: left;">{{ $leave_name ?? 'All' }} Leave
                                        Report</h5>

                                </div>
                            </td>
                            <td>
                                <div class="box-text text-end"></div>
                            </td>
                            <td>
                                <div class="box-text">
                                    @if (isset($department_name))
                                        <h5 style="font-weight:bolder;text-align: center;">Department :
                                            {{ $department_name }}</h5>
                                    @elseif(isset($position_name))
                                        <h5 style="font-weight:bolder;text-align: center;">Position :
                                            {{ $position_name }}</h5>
                                    @endif
                                </div>
                            </td>
                            <td colspan="4" class="w-50" style="">
                                <P class="mt-1" style="text-align: right; "> For the date of
                                    {{ date('d-M-Y', strtotime($date)) }}</p>
                            </td>
                        </tr>
                    </thead>
                </table>

                <hr>

                
                <?php

$natures = [
    1 => 'Annual Leave',
    2 => 'Sick Leave',
    3 => 'Compassionate Leave',
    4 => 'Maternity Leave',
    5 => 'Paternity Leave',
    6 => 'Study Leave'
];

// Convert $leave_data to a collection if it's not already one
$leave_data = is_array($leave_data) ? collect($leave_data) : $leave_data;

foreach ($natures as $natureKey => $natureValue) {
    $natureLeaveData = $leave_data->filter(function ($row) use ($natureKey) {
        return $row->nature == $natureKey;
    });

    if ($natureLeaveData->isNotEmpty()) {
        ?>
        <h3><?= $natureValue ?></h3>
        <table class="table" id="reports">
            <thead>
                <tr>
                    <th>Payroll No</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Position</th>
                    <?php if (isset($employee)) { ?>
                        <th>Approver</th>
                    <?php } ?>
                    <th>Leave Address</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Days</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($natureLeaveData as $row) { ?>
                    <tr>
                        <td><?= $row->emp_id ?></td>
                        <td><?= $row->fname ?> <?= $row->mname ?></td>
                        <td><?= $row->department_name ?></td>
                        <td><?= $row->position_name ?></td>
                        <?php if (isset($employee)) {
                            foreach ($employee as $emp) {
                                if ($emp->emp_id == $row->level1) { ?>
                                    <td><?= $emp->fname . ' ' . $emp->mname . ' ' . $emp->lname ?></td>
                                <?php }
                            }
                        } ?>
                        <td><?= $row->leave_address ?></td>
                        <td><?= $row->start ?></td>
                        <td><?= $row->end ?></td>
                        <td><?= number_format($row->days, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }
}
?>


                <hr>

            </div>

        </div>



        <div id="logo2" style="margin-left: 7px; z-index: -10">
            <img src="{{ public_path('assets/images/x-right.png') }}" width="100px;" height="50px;">
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


    <script src="{{ public_path('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ public_path('assets/js/jquery/jquery.min.js') }}"></script>

</body>

</html>
