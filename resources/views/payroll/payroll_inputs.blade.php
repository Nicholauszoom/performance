@extends('layouts.vertical', ['title' => 'Payroll Input Changes'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_buttons_excel.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    @php

        // $payroll_date = $data['payroll_date'];

        $payrollMonth = $payroll_date;
        $payrollState = 0;

    @endphp

    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
        <div class="card-header border-0">

            @include('payroll.payroll_info_buttons')

        </div>


        <div class="card-body">

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <hr>
                    <div class="row offset-2">
                        <div class="col-lg-3 ">
                            <h5 class="px-3">Find Employee<h5>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <select class="form-control select @error('emp_ID') is-invalid @enderror" id="emp_id"
                                    name="emp_ID">
                                    <option value=""> Select Employee </option>
                                    @if (!empty($employees))
                                        @foreach ($employees as $depart)
                                            <option value="{{ $depart->emp_id }}">{{ $depart->fname }} {{ $depart->mname }}
                                                {{ $depart->lname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        {{--  <div class="px-4">
                            <div class="mb-3">
                                <select class="form-control select @error('emp_ID') is-invalid @enderror" id="payroll_no"
                                    name="emp_ID">
                                    <option value=""> Select Payroll umber </option>
                                    @if (!empty($employees))
                                        @foreach ($employees as $depart)
                                            <option value="{{ $depart->emp_id }}">{{ $depart->fname }}
                                                {{ $depart->mname }}
                                                {{ $depart->lname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        --}}
                    </div>
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" style="font-size: 8px; font-weight:600;"
                        id="tabs-target-right" role="tablist">

                        <li class="nav-item" role="presentation">
                            <a href="#basic_details" class="nav-link active show" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Basic Info
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#permanent_payments" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Permanent Payments
                            </a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a href="#temporary_payments" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Temporary Payments
                            </a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a href="#deductions" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                                tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Deductions
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#company_pf" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab"
                                tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Company PF
                            </a>
                        </li>

                        {{-- start of payroll tab link --}}
                        <li class="nav-item" role="presentation">
                            <a href="#tax_no_pension" class="nav-link " data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2 "></i>
                                Taxable but Not Pensionable
                            </a>
                        </li>
                        {{-- / --}}



                        <li class="nav-item" role="presentation">
                            <a href="#pension_no_tax" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Pensionable but Not Taxable
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#no_tax_no_pension" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                NotTaxable Not Pensionable
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div role="tabpanel" class="tab-pane active show" id="basic_details">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Basic Details</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="permanent_payments">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Permanent Payments</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="temporary_payments">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Tenporary Payments</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="deductions">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Deductions</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="company_pf">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Company PF</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="tax_no_pension">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Taxable Not Pensionable</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="pension_no_tax">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Pensionable Not Taxable</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="no_tax_no_pension">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div
                                    class="card border-top  border-top-width-3 border-top-main  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Not Taxable Not Pentionable</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>






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

    <script type="text/javascript">
        $('#emp_id').change(function(e) {

            var empID = document.getElementById("emp_id").value;

            //e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/reports/get_payroll_inputs",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    data: {

                        "empID": empID,
                    },

                })
                .done(function(data) {
                      var data = JSON.parse(data);
              //alert(data.deductions.length);
                    //alert(data);
                    setBasics(data.employee);
                    setDeduction(data.deductions);
                    setAllowance(data.allowances)







                })
                .fail(function() {
                    alert(' Failed!! ...');

                });
        });

        function setBasics(data){

            var htmlString = "";
           // htmlString += '<div class="row">';
            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Payroll Number:</label><div class="col-lg-4"><input type="text" value="'+data.emp_id+'" class="form-control" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Basic Pay:</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data.salary +'" placeholder="0"></div></div>';
            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">First Name:</label><div class="col-lg-4"><input type="text" value="'+data.fname+'" class="form-control" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Transport:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Last Name:</label><div class="col-lg-4"><input type="text" value="'+data.lname+'" class="form-control" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">House Allowance:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Category:</label><div class="col-lg-4"><input type="text" class="form-control"  placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Acting Allowance:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Date of Emp:</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data.hire_date+'" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Other Payments:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Department:</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data.department+'" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Company House:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Cost Center:</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data.cost_center+'" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Company Hse Rent Amt:</label><div class="col-lg-4"><input type="text" class="form-control" placeholder="0"></div></div>';

            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">Job Title:</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data.position +'" placeholder="0"></div><label class="col-lg-2 col-form-label text-lg-end">Employment Status:</label><div class="col-lg-4"><input type="text" value="'+data.status +'" class="form-control" placeholder="0"></div></div>';
            document.getElementById("basic_details").innerHTML = htmlString;

        }
        function setAllowance(data){
            //parmanent payments
            var htmlString = "";
            htmlString += '<div class="row mb-3">';
            for(i = 0; i < data.length; i++) {
            htmlString += '<label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div>';

            }
            htmlString +='</div>';

            document.getElementById("permanent_payments").innerHTML = htmlString;
            //temporary payments
            var htmlString = "";
            htmlString += '<div class="row mb-3">';
            for(i = 0; i < data.length; i++) {
            htmlString += '<label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div>';

            }
            htmlString +='</div>';

            document.getElementById("temporary_payments").innerHTML = htmlString;

            //taxable no pension
            var htmlString = "";
            htmlString += '<div class="row mb-3">';
            for(i = 0; i < data.length; i++) {
                if(data[i].taxable == "YES" && data[i].pensionable == "NO"){
            htmlString += '<label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div>';
             }
            }
            htmlString +='</div>';

            document.getElementById("tax_no_pension").innerHTML = htmlString;

             //pension no tax
             var htmlString = "";
            htmlString += '<div class="row mb-3">';
            for(i = 0; i < data.length; i++) {
                if(data[i].taxable == "NO" && data[i].pensionable == "YES"){
            htmlString += '<label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div>';
             }
            }
            htmlString +='</div>';

            document.getElementById("pension_no_tax").innerHTML = htmlString;

             //no pension no tax
             var htmlString = "";
            htmlString += '<div class="row mb-3">';
            for(i = 0; i < data.length; i++) {
                if(data[i].taxable == "NO" && data[i].pensionable == "NO"){
            htmlString += '<label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div>';
             }
            }
            htmlString +='</div>';

            document.getElementById("no_tax_no_pension").innerHTML = htmlString;

        }

        function setDeduction(data){
             var htmlString = "";
           //  htmlString = "<div class="row mb-3">";
            for(i = 0; i < data.length; i++) {
            htmlString += '<div class="row mb-3"><label class="col-lg-2 col-form-label text-lg-end">'+data[i].NAME+':</label><div class="col-lg-4"><input type="text" class="form-control" value="'+data[i].amount+'" placeholder="0"></div></div>';
            // if(i < (data.length -1)){
            // htmlString +='<label class="col-lg-2 col-form-label text-lg-end">"'+data[i+1].NAME+'":</label><div class="col-lg-4"><input type="text" value="'+data[i+1].amount+'" class="form-control" placeholder="0"></div>';

            // }
          //  htmlString += '</div>';
           //htmlString += '<label class="col-lg-2 col-form-label text-lg-end">"'+data[i].NAME+'":</label><div class="col-lg-4"><input type="text" value="'+data["amount"]+'" class="form-control" placeholder="0"></div>';
           }
          // htmlString = "";



        document.getElementById("deductions").innerHTML = htmlString;
        }


    </script>
@endpush
