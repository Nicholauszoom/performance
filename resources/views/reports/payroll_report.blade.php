@extends('layouts.vertical', ['title' => 'Payroll'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="../../../../global_assets/js/plugins/forms/selects/select2.min.js"></script>
@endpush

@push('head-scriptTwo')

<script src="{{ asset('assets/js/form_layouts.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
@include('layouts.shared.page-header')
@endsection

@section('content')
@php
$payroll_details = $data['payroll_details'];
$payroll_month_info =$data['payroll_month_info'];
$payroll_list = $data['payroll_list'];
$payroll_date = $data['payroll_date'];
$payroll_totals = $data['payroll_totals'];

$total_allowances = $data['total_allowances'];
$total_bonuses = $data['total_bonuses'];
$total_loans = $data['total_loans'];
$total_overtimes = $data['total_overtimes'];
$total_deductions = $data['total_deductions'];
$payroll_state = $data['payroll_state'];

$payrollMonth = $payroll_date;
$payrollState = $payroll_state;
foreach ($payroll_totals as $row) {
$salary = $row->salary;
$pension_employee = $row->pension_employee;
$pension_employer = $row->pension_employer;
$medical_employee = $row->medical_employee;
$medical_employer = $row->medical_employer;
$sdl = $row->sdl;
$wcf = $row->wcf;
$allowances = $row->allowances;
$taxdue = $row->taxdue;
$meals = $row->meals;
}
$paid_heslb = null;
$remained_heslb = null;
$paid = null;
$remained = null;
foreach ($total_loans as $key) {
if ($key->description == "HESLB"){
$paid_heslb = $key->paid;
$remained_heslb = $key->remained;

}else{
$paid = $key->paid;
$remained = $key->remained;
}
}
foreach ($payroll_month_info as $key) {
// $paid = $key->payroll_date;
$cheklist = $key->pay_checklist;
$state = $key->state;
}

@endphp



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

let check = <?php /*echo $this->session->userdata("email_sent"); */ ?>;

if (check) {
    <?php /*unset($this->session->userdata['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'success');
} else {
    <?php/* unset($this->session->userdata['email_sent']); */ ?>
    notify('Reviewed added successfuly!', 'top', 'right', 'warning');
}
</script>

<script>
function generate_checklist() {
    if (confirm("Are You Sure You Want To a Full Payment Cheklist for This Payroll") == true) {
        // var id = id;
        $('#hideList').hide();
        $.ajax({
            url: "{{route('generate_checklist',['pdate'=>base64_encode($payroll_date)])}}",
            success: function(data) {
                if (data.status == 1) {
                    alert("Pay CheckList Generated Successiful!");

                    $('#resultConfirmation').fadeOut('fast', function() {
                        $('#resultConfirmation').fadeIn('fast').html(data.message);
                    });
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the div to clear the success notification
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
}
</script>
@endpush