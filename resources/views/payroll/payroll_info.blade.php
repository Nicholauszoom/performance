@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')
    @php



        // $payrollMonth = $payroll_date;
         $payrollState = $payroll_state;









        $total_previous = 0;
        $total_current = 0;
        $total_amount = 0;

    @endphp

    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
        <div class="card-header border-0">
            @include('payroll.payroll_info_buttons')

        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <table class="table table-stripped " style="font-size:14px;">
                        <thead>
                            <tr class="">
                                <th><b>RefNo</b></th>
                                <th><b>Desc</b></th>
                                <th class="text-end"><b>Last Month</b></th>
                                <th class="text-end"><b>This Month</b></th>
                                <th class="text-end"><b>Amount</b></th>
                                <th class="text-end"><b>Count</b></th>

                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $total_previous += 0;
                                $total_current += 0;
                                $total_amount += $total_previous_gross;
                            @endphp
                            <tr>
                                <td class="text-start">00001</td>
                                <td class="text-start">Last Month Gross Salary</td>
                                <td class="text-end">
                                    {{ number_format(0, 2) }}</td>
                                <td class="text-end">
                                    {{ number_format(0, 2) }}</td>
                                <td class="text-end">{{ number_format($total_previous_gross, 2) }}</td>
                                <td class="text-end">{{ $count_previous_month }}</td>
                            </tr>
                            @if ($total_current_basic - $total_previous_basic != 0)
                                @if ($total_current_basic > $total_previous_basic != 0)
                                    <tr>
                                        <td class="text-start">00002</td>
                                        <td class="text-start">Add New Employee</td>
                                        <td class="text-end">
                                            {{ number_format(0, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($total_current_basic - $total_previous_basic, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($total_current_basic - $total_previous_basic, 2) }}</td>
                                        <td class="text-end">{{ $count_current_month - $count_previous_month }}</td>
                                    </tr>
                                    @php
                                        $total_previous += 0;
                                        $total_current += $total_current_basic - $total_previous_basic;
                                        $total_amount += $total_current_basic - $total_previous_basic;
                                    @endphp
                                @else
                                    <tr>
                                        <td class="text-start">00002</td>
                                        <td class="text-start">Less Terminated Employee</td>
                                        <td class="text-end">
                                            {{ number_format(0, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($total_previous_basic - $total_current_basic, 2) }}</td>
                                        <td class="text-end">
                                            {{ number_format($total_previous_basic - $total_current_basic, 2) }}</td>
                                        <td class="text-end">{{ $count_previous_month - $count_current_month }}</td>
                                    </tr>
                                    @php
                                        $total_previous += 0;
                                        $total_current += $total_current_basic - $total_previous_basic;
                                        $total_amount += $total_current_basic - $total_previous_basic;
                                    @endphp
                                @endif
                            @endif
                            @if ($current_increase - $previous_increase != 0)
                                <tr>
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Add Increase in Basic Pay incomparison to Last M </td>
                                    <td class="text-end">
                                        {{ number_format($previous_increase, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($current_increase, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($current_increase - $previous_increase, 2) }}</td>
                                    <td class="text-end"></td>
                                </tr>
                                @php
                                    $total_previous += $previous_increase;
                                    $total_current += $current_increase;
                                    $total_amount += $current_increase - $previous_increase;
                                @endphp
                            @endif
                            @if ($current_decrease - $previous_decrease != 0)
                                <tr>
                                    <td class="text-start">00004</td>
                                    <td class="text-start">Less Decrease in Basic Pay incomparison to Last M </td>
                                    <td class="text-end">
                                        {{ number_format($previous_decrease, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($current_decrease, 2) }}</td>
                                    <td class="text-end">
                                        {{ number_format($current_decrease - $previous_decrease, 2) }}</td>
                                    <td class="text-end"></td>
                                </tr>
                                @php
                                    $total_previous -= $previous_decrease;
                                    $total_current -= $current_decrease;
                                    $total_amount -= $current_decrease - $previous_decrease;
                                @endphp
                            @endif
                            @php $i = 1;  @endphp
                            @if (count($total_allowances) > 0)
                                @foreach ($total_allowances as $row)
                                    @php $i++;  @endphp
                                    @if ($row->current_amount - $row->previous_amount != 0)
                                        <tr>
                                            <td class="text-start">{{ '000' . $i + 4 }}</td>
                                            <td class="text-start">{{ $row->description }} </td>
                                            <td class="text-end">{{ number_format($row->previous_amount, 2) }}</td>
                                            <td class="text-end">{{ number_format($row->current_amount, 2) }}</td>
                                            <td class="text-end">{{ number_format($row->difference, 2) }}</td>
                                            <td class="text-end"></td>
                                        </tr>
                                        @php
                                            $total_previous += $row->previous_amount;
                                            $total_current += $row->current_amount;
                                            $total_amount = $total_amount + $row->difference;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif


                            {{-- </tbody>
                        <tbody> --}}
                            <tr style="border-top: 2px solid rgb(18, 93, 54) !important; ">
                                <td class="text-start"></td>
                                <td class="text-start"><b>This Month</b> </td>
                                <td class="text-end">
                                    <b>{{ number_format(!empty($total_previous) ? $total_previous : 0, 2) }}</b>
                                </td>
                                <td class="text-end"><b>{{ number_format($total_current, 2) }}</b></td>
                                <td class="text-end">
                                    <b>{{ number_format($total_amount, 2) }}</b>
                                </td>
                                <td class="text-end"><b>{{ $count_current_month }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <hr>


            <?php  ?>

        </div>


    </div>

@endsection
@push('footer-script')
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

        let check = <?php /*echo session("email_sent"); */ ?>;

        if (check) {
            <?php /*unset(session['email_sent']); */ ?>
            notify('Reviewed added successfuly!', 'top', 'right', 'success');
        } else {
            <?php/* unset(session['email_sent']); */ ?>
            notify('Reviewed added successfuly!', 'top', 'right', 'warning');
        }
    </script>

    <script>
        function generate_checklist() {

            // Advanced initialization
            Swal.fire({
                title: 'Are you sure? you whant to confirm payroll',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $('#hideList').hide();

                    $.ajax({
                        url: "{{ route('payroll.generate_checklist', ['pdate' => base64_encode($payroll_date)]) }}",
                        success: function(data) {
                            if (data.status == 1) {
                                alert("Pay CheckList Generated Successiful!");

                                $('#resultConfirmation').fadeOut('fast', function() {
                                    $('#resultConfirmation').fadeIn('fast').html(data.message);
                                });
                                setTimeout(function() { // wait for 2 secs(2)
                                    location
                                .reload(); // then reload the div to clear the success notification
                                }, 1500);
                            } else {
                                alert(
                                    "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
                                );

                                $('#resultConfirmation').fadeOut('fast', function() {
                                    $('#resultConfirmation').fadeIn('fast').html(data.message);
                                });
                            }

                        }

                    });

                }
            });

            // if (confirm("Are you sure? you whant to confirm payroll") == true) {
            //     // var id = id;
            //     $('#hideList').hide();
            //     $.ajax({
            //         url: "{{ route('payroll.generate_checklist', ['pdate' => base64_encode($payroll_date)]) }}",
            //         success: function(data) {
            //             if (data.status == 1) {
            //                 alert("Pay CheckList Generated Successiful!");

            //                 $('#resultConfirmation').fadeOut('fast', function() {
            //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
            //                 });
            //                 setTimeout(function() { // wait for 2 secs(2)
            //                     location.reload(); // then reload the div to clear the success notification
            //                 }, 1500);
            //             } else {
            //                 alert(
            //                     "FAILED to Generate Pay Checklist, Try again, If the Error persists Contact Your System Admin."
            //                 );

            //                 $('#resultConfirmation').fadeOut('fast', function() {
            //                     $('#resultConfirmation').fadeIn('fast').html(data.message);
            //                 });
            //             }

            //         }

            //     });
            // }
        }
    </script>
@endpush
