@extends('layouts.vertical', ['title' => 'Brand Settings'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
    @include('layouts.shared.page-header')
@endsection

@section('content')
    {{-- start of add holiday form --}}

    {{-- start of all holidays table --}}
    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">

        <div id="save_termination" class="col-12 mx-auto">
            {{-- <div class="cardd border-top  border-top-width-3 border-top-main border-bottom-main rounded-0"> --}}
            <div class="card-header">
                <h6 class="text-warning">Brand Settings</h6>
            </div>
            {{-- {{dd($brandSetting->company_logo)}} --}}


            {{-- <img src="{{ asset('storage/' . $brandSetting->company_logo) }}" alt="jhhhhhhhhhhhhh" srcset=""> --}}

            <div class="">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif



                <div class="container">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf

                        <div class="d-flex">
                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="report_system_name">Organization Name</label>
                                    <input type="text" name="organization_name" class="form-control" value="{{ $brandSetting->organization_name }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="report_system_name">Report system Name</label>
                                    <input type="text" name="report_system_name" class="form-control" value="{{ $brandSetting->report_system_name }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="website_url">Website URL</label>
                                    <input type="text" name="website_url" class="form-control" value="{{ $brandSetting->website_url }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="allowed_domain">Website URL</label>
                                    <input type="text" name="allowed_domain" class="form-control" value="{{ $brandSetting->allowed_domain }}">
                                </div>
                            </div>
                            

                        </div>
                        
                        <h4>Logo/Pictures</h4>
                        <div class="d-flex flex-wrap">
                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="company_logo">Company Logo <span>
                                            @if ($brandSetting->company_logo)
                                                <a href="{{ asset('storage/' . $brandSetting->company_logo) }}"> view</a>
                                            @endif
                                        </span></label>
                                    <input type="file" name="company_logo" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group m-2">
                                    <label for="report_logo">Report Logo <span>
                                            @if ($brandSetting->report_logo)
                                                <a href="{{ asset('storage/' . $brandSetting->report_logo) }}"> view</a>
                                            @endif

                                        </span></label>
                                    <input type="file" name="report_logo" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="dashboard_logo">Dashboard Logo <span>
                                            @if ($brandSetting->dashboard_logo)
                                                <a href="{{ asset('storage/' . $brandSetting->dashboard_logo) }}"> view</a>
                                            @endif

                                        </span></label>
                                    <input type="file" name="dashboard_logo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="login_picture">Login Picture</label>
                                    <input type="file" name="login_picture" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="body_background">Body Background Picture  
                                        <span>
                                            @if ($brandSetting->body_background)
                                                <a href="{{ asset('storage/' . $brandSetting->body_background) }}"> view</a>
                                            @endif

                                        </span>
                                    </label>
                                    <input type="file" name="body_background" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="body_background">Report top banner  
                                        <span>
                                            @if ($brandSetting->report_top_banner)
                                                <a href="{{ asset('storage/' . $brandSetting->report_top_banner) }}"> view</a>
                                            @endif

                                        </span>
                                    </label>
                                    <input type="file" name="report_top_banner" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="body_background">Report bottom banner  
                                        <span>
                                            @if ($brandSetting->report_bottom_banner)
                                                <a href="{{ asset('storage/' . $brandSetting->report_bottom_banner) }}"> view</a>
                                            @endif

                                        </span>
                                    </label>
                                    <input type="file" name="report_bottom_banner" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="body_background">Left payslip Logo
                                        {{-- {{ dd($brandSetting) }} --}}
                                        <span>
                                            @if ($brandSetting->left_payslip_logo)
                                                <a href="{{ asset('storage/' . $brandSetting->left_payslip_logo) }}"> view</a>
                                            @endif
                                        </span>
                                    </label>
                                    <input type="file" name="left_payslip_logo" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-2">
                                    <label for="body_background">Right payslip Logo  
                                        <span>
                                            @if ($brandSetting->right_payslip_logo)
                                                <a href="{{ asset('storage/' . $brandSetting->right_payslip_logo) }}"> view</a>
                                            @endif

                                        </span>
                                    </label>
                                    <input type="file" name="right_payslip_logo" class="form-control">
                                </div>
                            </div>


                        </div>

                        <h4>Colors</h4>

                        <div class="d-flex">
                            <div class="col-md-3 m-1">
                                <div class="form-group mb-3">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="color" name="primary_color" class="form-control"
                                        value="{{ $brandSetting->primary_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group mb-3 m-1">
                                    <label for="secondary_color">Secondary Color</label>
                                    <input type="color" name="secondary_color" class="form-control"
                                        value="{{ $brandSetting->secondary_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group mb-3 m-1">
                                    <label for="hover_color">Hover Color</label>
                                    <input type="color" name="hover_color" class="form-control"
                                        value="{{ $brandSetting->hover_color }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3 m-1">
                                    <label for="hover_color">Hover Color 2</label>
                                    <input type="color" name="hover_color_two" class="form-control"
                                        value="{{ $brandSetting->hover_color_two }}">
                                </div>
                            </div>

                        </div>

                        <h4>Loader Colors</h4>
                        <div class="d-flex flex-wrap">
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_one">Loader Color 1</label>
                                    <input type="color" name="loader_color_one" class="form-control" value="{{ $brandSetting->loader_color_one }}">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_two">Loader Color 2</label>
                                    <input type="color" name="loader_color_two" class="form-control" value="{{ $brandSetting->loader_color_two }}">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_three">Loader Color 3</label>
                                    <input type="color" name="loader_color_three" class="form-control" value="{{ $brandSetting->loader_color_three }}">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_four">Loader Color 4</label>
                                    <input type="color" name="loader_color_four" class="form-control" value="{{ $brandSetting->loader_color_four }}">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_five">Loader Color 5</label>
                                    <input type="color" name="loader_color_five" class="form-control" value="{{ $brandSetting->loader_color_five }}">
                                </div>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group mb-3 m-1">
                                    <label for="loader_color_six">Loader Color 6</label>
                                    <input type="color" name="loader_color_six" class="form-control" value="{{ $brandSetting->loader_color_six }}">
                                </div>
                            </div>
                        </div>

                        <h4 class="ml-3">Report Adresses</h4>
                        <div class="d-flex">
                            <div class="col-md-3">
                                <div class="form-group m-2 ">
                                    <label for="address_1">Address 1</label>
                                    <input type="text" name="address_1" class="form-control" value="{{ $brandSetting->address_1 }}">
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="address_2">Address 2</label>
                                    <input type="text" name="address_2" class="form-control" value="{{ $brandSetting->address_2 }}">
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group m-2">
                                    <label for="address_3">Address 3</label>
                                    <input type="text" name="address_3" class="form-control" value="{{ $brandSetting->address_3 }}">
                                </div>
                            </div>
                        
                            <div class="col-md-3">
                                <div class="form-group  m-2">
                                    <label for="address_4">Address 4</label>
                                    <input type="text" name="address_4" class="form-control" value="{{ $brandSetting->address_4 }}">
                                </div>
                            </div>
                        </div>




                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>





            </div>
        </div>
        {{-- </div> --}}




    </div>
@endsection

@push('footer-script')
    <script>
        // Initialize color pickers
        $('.colorpicker').colorpicker();
    </script>



    <script>
        function deleteHoliday(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Delete This Holiday ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var holidayid = id;

                    $.ajax({
                            url: "{{ url('flex/delete-holiday') }}/" + holidayid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                                );
                            });

                            // alert('Request Cancelled Successifully!! ...');

                            Swal.fire(
                                'Cancelled!',
                                'Holiday Deleted Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Holiday Deletion Failed!! ....',
                                'success'
                            )

                            alert('Holiday Deletion Failed!! ...');
                        });
                }
            });

            // if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
            //                     );
            //             });

            //             alert('Request Cancelled Successifully!! ...');

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 1000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Cancellation Failed!! ...');
            //         });
            // }
        }
    </script>
@endpush
