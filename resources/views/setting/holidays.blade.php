@extends('layouts.vertical', ['title' => 'Holidays'])

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
        <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0">
            <div class="card-header">
                <h6 class="text-warning">Add Holiday</h6>
            </div>
            <div class="">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form
                    action="{{ route('flex.saveHoliday') }}"
                    method="POST"
                >
                    @csrf

                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-6 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Holiday Name:</label>
                                    <input type="text" name="name" id="" class="form-control" placeholder="Enter Holiday Name">
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="mb-1">
                                    <label class="form-label">Holiday Date:</label>
                                    <input type="date" name="date" id="" class="form-control" placeholder="Enter Date of Charge">
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <div class="mb-1">

                                    <label for="recurring" class="form-label">Holiday Recurring:</label>
                                    <input type="checkbox" name="recurring" id="recurring" class="check">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-perfrom mb-1 float-end">Save Holiday</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card border-top border-top-width-3 border-top-main rounded-0 p-2">
        <div class="card-header">
            <h5 class="text-warning">Holidays from excel</h5>



<a  href="{{ asset('uploads/templates/holidays_templates.xlsx') }}" >
    Click here to download holiday excel template
</a>
        </div>
        <div class="card-body">
            <form id="demo-form2" enctype="multipart/form-data" method="post" action="{{ route('flex.addHolidayFromExcel')}}" data-parsley-validate class="form-horizontal form-label-left">
                @csrf
                <div class="mb-3">
                    <div class="form-group row align-items-center">
                        <div class="col-md-12 col-lg-12 col-xs-12 d-flex justify-content-between ">
                            <div class="col-8 d-flex justify-content-start">
                                <label for="attachment" class="control-label col-md-2">Attachment <span class="text-danger">*</span></label>
                                <div class="col-9"> <!-- Reduce the column width and adjust the margin to the right -->
                                    <input class="form-control col-md-12 col-xs-12" type="file" name="file" requiredes accept=".xls, .xlsx">
                                </div>
                            </div>

                            <div class="col-1 d-flex justify-content-end"> <!-- Adjust the column width, no need to adjust the margin -->
                                <button type="submit" class="btn btn-main w-75">Upload</button>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger"><?php // echo form_error("mname"); ?></span>
                </div>
                <p>
                    <small>
                        <i>Note:</i> Please note that this action of uploading bulk remaining leaves for balancing and clearing is performed only once in the system, especially at the end of the year, right before entering another new year.
                    </small>
                </p>
            </form>
        </div>
    </div>

    <div class="row ">
        <div class="col-12">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                <div class="card-header border-0">
                    <div class="">
                        <h6 class="mb-0 text-warning">Holidays</h6>

                        <a href="{{ route('flex.updateHolidayYear') }}" class="btn btn-main btn-sm float-end">Update All Holidays</a>
            <br>

                    </div>
                <hr>
                </div>
                <table class="table datatable-basic">
                    <thead>
                        <th>SN</th>
                        <th>Holiday</th>
                        <th>Date</th>
                        <th>Recurring</th>
                        <th>Actions</th>
                        <th hidden></th>
                    </thead>
                    <tbody>
                        @forelse ($holidays as $item )
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->date}}</td>
                                <td>{{ $item->recurring=='1'? 'Yes':'No' }}</td>
                                <td>
                                    <a href="{{ route('flex.editholiday', base64_encode($item->id)) }}" class="btn btn-sm btn-main">
                                        <i class="ph-pen"></i>
                                    </a>

                                    <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                                    onclick="deleteHoliday(<?php echo $item->id; ?>)">
                                    <button class="btn btn-danger btn-sm"><i class="ph-trash"></i> </button>
                                     </a>

                                </td>
                                <td hidden>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>



    </div>



</div>




@endsection

@push('footer-script')



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


