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

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-warning">Holidays</h5>


        </div>
    <hr>
    </div>
    <div class="row mx-1">
        <div id="save_termination" class="col-12" tabindex="-1">
            <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                <div class="card-header">
                    <h6 class="text-warning">Edit Holiday</h6>
                </div>
                <div class="modal-content">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form  action=" {{ url('flex/update-holiday')}}"
                        method="POST"
                        class="form-horizontal"
                    >
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Name:</label>
                                        <input type="text" name="name" @if($holiday) value="{{ $holiday->name }}" @endif id="" class="form-control" placeholder="Enter Holiday Name">
                                        <input type="hidden" name="id" @if($holiday) value="{{ $holiday->id }} " @endif>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Date:</label>
                                        <input type="date" name="date" @if($holiday) value="{{ $holiday->date }}" @endif class="form-control" placeholder="Enter Date of Charge">
                                    </div>
                                </div>

                                <div class="col-6 col-lg-6">
                                    <div class="mb-1">

                                        <label for="recurring" class="form-label">Holiday Recurring:</label>
                                        <input type="checkbox" name="recurring" id="recurring" class="check">
                                    </div>
                                </div>



                        </div>


                        </div>

                        <div class="modal-footer">
                            <hr>

                            <button type="submit" class="btn btn-perfrom mb-2 mt-2">update Holiday</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                <table class="table  datatable-basic">
                    <thead>
                        <th>SN</th>
                        <th>Holiday</th>
                        <th>Date</th>
                        <th>Recurring</th>
                        <th>Action</th>
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


