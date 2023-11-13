@extends('layouts.vertical', ['title' => 'Leave'])

@push('head-script')
        <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
        <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
        <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    @php
        $totalAccrued = number_format($leaveBalance, 2);
    @endphp

    @if (session('mng_emp') || session('appr_leave') || 1)
        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
                {{ session('msg') }}
            </div>
        @endif

        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 col-lg-12 ">
            <div class="card-body">
                <div class="col-6 tex-mdt-sucess text-secondary" id="remaining" style="display:none">
                    <code class="text-success">
                        <span id="remain" class="text-success"></span>
                    </code>
                </div>


                {{-- include  apply for behalf leave form --}}
                @include('app.apply_leave_behalf')

                {{-- include  new leave applications table  --}}
                @include('app.newleave_applications')

                {{-- include  approved leave applications table  --}}
                @include('app.approvedleave_applications')

                {{-- include  revoked leave applications table  --}}
                @include('app.revokedleave_applications')
                @endif

    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content py-3">
                <div class="modal-body">
                    <div id="message"></div>
                    <div class="row py-2">
                        <div class="col-sm-12 col-lg-12 px-5">
                            <label>Enter Your Comment Here!</label>
                            <textarea id="comment" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-default btn-sm" onclick="hidemodel()"
                            data-dismiss="modal">No</button>
                        <button type="button" id="yes_delete" class="btn btn-main btn-sm" onclick="hidemodel()"
                            data-dismiss="modal">Yes</button>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection





@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

        <script>
           function hidemodel() {

            $('#delete').hide();
            // location.reload();
        }

        // function cancelLeave(id) {
        //     $('#delete').hide();
        //     location.reload();
        // }

        function cancelLeave(id) {

            const message = "Are You Sure That You Want to Reject This Leave Request?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            $("#yes_delete").click(function() {
                $('#hideList').hide();
                const message = document.getElementById('comment').value;
                const terminationid = id;

                var data = terminationid + "|" + message;

                var url = "{{ route('attendance.cancelLeave', ':data') }}";
                url = url.replace(':data', data);

                if (message != "") {
                    $.ajax({
                        // url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        // body:['']
                        async: true,
                        // beforeSend: function() {
                        //     $('.request__spinner').show()
                        // },
                        // complete: function() {

                        // },
                        success: function(data) {

                            var data = JSON.parse(data);
                            console.log(data)
                            if (data.status == 'OK') {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Leave Approved  successfully!',
                                    type: 'success'
                                }).show();
                                setTimeout(function(){location.reload();},3000);
                            } else {
                                $('#delete').modal('hide');
                                new Noty({
                                    text: 'Leave Approve failed!',
                                    type: 'error'
                                }).show();


                            }

                        },
                        error: function(){
                            $('#delete').modal('hide');
                            new Noty({
                        text: 'Failed to cancel',
                        type: 'error'
                    }).show();
                        }

                    });
                } else {
                    $('#delete').modal('hide');

                    new Noty({
                        text: 'Failed, Comment should not be empty',
                        type: 'error'
                    }).show();
                }

            });

        }

        function approveRequest(id) {

            Swal.fire({
                title: 'Are You Sure That You Want to Approve This Leave Request ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url: "{{ url('flex/attendance/approveLeave') }}/" + terminationid
                        })
                        .done(function(data) {
                            $('#resultfeedOvertime').fadeOut('fast', function() {
                                $('#resultfeedOvertime').fadeIn('fast').html(data);
                            });

                            $('#status' + id).fadeOut('fast', function() {
                                $('#status' + id).fadeIn('fast').html(
                                    '<div class="col-md-12"><span class="label label-warning">Approved</span></div>'
                                );
                            });

                            // alert('Request Cancelled Successifully!! ...');

                            Swal.fire(
                                'Cancelled!',
                                'Leave Request Approved Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Leave Request Cancellation Failed!! ....',
                                'success'
                            )

                            alert('Leave Request Cancellation Failed!! ...');
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


        function cancelRequest(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Leave Request ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                            url: "{{ url('flex/attendance/cancelLeave') }}/" + terminationid
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
                                'Leave Request Cancelled Successifully!!.',
                                'success'
                            )

                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        })
                        .fail(function() {
                            Swal.fire(
                                'Failed!',
                                'Leave Request Cancellation Failed!! ....',
                                'success'
                            )

                            alert('Leave Request Cancellation Failed!! ...');
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






    @include('app.includes.leave_operations')

    <script>
        $(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var dateToday = dd + '/' + mm + '/' + yyyy;
            $('#leave_startDate').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleClasses: "picker_1"
            }, function(start, end, label) {
                var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");

            });
            $('#leave_startDate').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
            $('#leave_startDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script>
        $(function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!

            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            var dateToday = dd + '/' + mm + '/' + yyyy;
            $('#leave_endDate').daterangepicker({
                drops: 'down',
                singleDatePicker: true,
                autoUpdateInput: false,
                startDate: dateToday,
                minDate: dateToday,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                singleClasses: "picker_1"
            }, function(start, end, label) {
                // var years = moment().diff(start, 'years');
                // alert("The Employee is " + years+ " Years Old!");

            });
            $('#leave_endDate').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
            });
            $('#leave_endDate').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>

    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            const start = document.getElementById("start-date").value;
            const end = document.getElementById("end-date").value;
            const empID = document.getElementById("empID").value;
            var par = id + '|' + start + '|' + end + '|' + empID;
            var url = '{{ route('getSubs', ':id') }}';
            url = url.replace(':id', par);


                $('#subs_cat').find('option').remove();
            // $('#subs_cat').find('option').not(':first').remove();
            let days = 0;
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',

                success: function(response) {

                    days = response.days;
                    let subs = response.data;
                    var status = "<span>" + response.days + " Days</span>"
                    $("#remaining").empty(status);
                    $("#remaining").append(status);
                    $("#remaining").show()
                    $("#sub").hide();

                    for (var i = 0; i < response.data.length; i++) {

                        var id = subs[i].id;
                        var name = subs[i].name;
                        var option = "<option value='" + id + "'>" + name + "</option>";


                        $("#subs_cat").append(option);

                        $("#sub").show();

                    }


                    processAttachmentDisplay(days)

                }
            });

            function processAttachmentDisplay(_days) {

                if (id == 1 || id == 3 || id == 5 ) {
                    $("#attachment").hide();
                } else if (id == 2) {
                    if (_days == 1) {

                        var validateUrl = '{{ route('attendance.validateSickLeave', ':date') }}'
                        validateUrl = validateUrl.replace(':date', start)
                        $.ajax({
                            url: validateUrl,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                if (response.status) {
                                    $('#attachment').show()
                                } else {
                                    $('#attachment').hide()
                                }
                            }
                        })
                    } else {
                        $('#attachment').hide()

                    }

                } else {
                    $("#attachment").show();
                }
            }

        });
    </script>

    {{-- <script>
        var date = new Date();
        var tdate = date.getDate();
        var month = date.getMonth() + 1;
        if(tdate<10){
            month =  '0' + month;
        }
        if(month < 10){
            month = '0' + month;
        }
        var year  = date.getFullYear();
        var minDate = year + "-" + month + "-" + tdate;
        document.getElementById("start-date").setAttribute('min', minDate)
        document.getElementById("end-date").setAttribute('min', minDate)
        console.log(date);
    </script> --}}
@endpush
