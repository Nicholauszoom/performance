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
    {{-- start of leave application --}}

    @if (session('msg'))
        <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0">

        <div class="card-header">
            <h5 class="text-warning">Revoke Leave</h5>
        </div>
        <div class="row">
            <div class=" col-md-10">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="start-date">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start" id="start-date" value="{{ $startDate }}"
                                class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end-date">End Date <span class="text-danger">*</span></label>
                            <input type="date" required id="end-date" value="{{ $endDate }}" name="end"
                                class="form-control" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end-date">Nature<span class="text-danger">*</span></label>
                            <input type="text" value= "{{ $nature }}" class="form-control" disabled>
                        </div>

                        @if ($sub_category > 0)
                            <div class="form-group col-md-6" id="sub" style="display:none">
                                <label for="subs_cat">Sub Category <span class="text-danger">*</span></label>
                                <input name="sub_cat" value="{{ $sub_category }}" class="form-control select custom-select"
                                    id="subs_cat" disabled>
                            </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label for="address">Leave Address <span class="text-danger">*</span></label>
                            <input value="{{ $leaveAddress }}" type="text" id="address" name="address"
                                class="form-control" disabled>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="mobile">Mobile <span class="text-danger">*</span></label>
                            <input required="required" value="{{ $mobile }}" class="form-control" type="tel"
                                maxlength="10" name="mobile" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile">Approved By <span class="text-danger">*</span></label>
                            <input required="required" value="{{ $approvedBy }}" class="form-control" type="tel"
                                maxlength="10" name="mobile" disabled>
                        </div>

                        <div class="form-group col-12 mb-2">
                            <label for="reason">Reason For Leave <span class="text-danger">*</span></label>
                            <input maxlength="256" class="form-control" value="{{ $leaveReason }}" required="required"
                                rows="3" disabled>
                        </div>
                        @if ($revoke_reason !== null)
                            <div class="form-group col-12 mb-2">
                                <label for="reason">Reason For a Leave Revoke <span class="text-danger">*</span></label>
                                <textarea maxlength="256" class="form-control" required="required" rows="3">{{ $revoke_reason }}</textarea>
                            </div>
                            @if($startdate_revoke)
                            <div class="form-group col-md-6">
                                <label for="end-date">Expected New Date <span class="text-danger">*</span></label>
                                <input type="date" id="start-date" value="{{ $startdate_revoke }}" name="end"
                                    class="form-control" required disabled>
                            </div>
                            @endif
                            <div class="form-group col-md-6">
                                <label for="end-date">Expected Date Back <span class="text-danger">*</span></label>
                                <input type="date" id="end-date" value="{{ $expectedDate }}" name="end"
                                    class="form-control" required disabled>
                            </div>

                            @if ($revoke_status != 1 && $revoke_status != 0)
                                <div class="form-group py-2">
                                    <button class="float-end btn btn-warning" type="button" data-bs-toggle="modal"
                                        data-bs-target="#approval">Early Return</button>
                                </div>
                            @endif
                        @endif
                        <div class="form-group py-2">
                            <button class="float-end btn btn-main" type="button" data-bs-toggle="modal" data-bs-target="#approval">
                                Revoke Leave with Adjustment
                            </button>
                        </div>
                        <div class="form-group py-2">
                            <button class="float-end btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#revokecompletely">
                                Revoke this Leave Complete
                            </button>
                        </div>

                        @if($revoke_status = 0)
                        <div id="revokecompletely" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customModalLabel">Are you sure to Approve
                                            this Leave Total Revoke</h5>
                                        <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-main btn-sm px-4"
                                            onclick="approveRevokeCompleteRevokeInitiate(<?php echo $id; ?>)">Yes I am</button>
                                        <button type="button" class="btn bg-danger btn-sm px-4 text-light"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif (Auth()->user()->emp_id == $particularLeave->level1)
                        <div id="revokecompletely" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customModalLabel">Are you sure to approve
                                            this Leave Total Revoke</h5>
                                        <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-main btn-sm px-4"
                                            onclick="approveRevokeCompleteRevokeInitiate(<?php echo $id; ?>)">Yes I am</button>
                                        <button type="button" class="btn bg-danger btn-sm px-4 text-light"
                                            data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="revokecompletely" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="customModalLabel">Are you sure To Revoke this Leave Completely</h5>
                                        <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <label for="reason">State Reason of Leave Revoking<span
                                                class="text-danger">*</span></label>
                                        <textarea id="commentInput" name="commentInput" class="form-control" placeholder="Enter your reason here" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-main btn-sm px-4"
                                            onclick="revokeCompleteRevokeInitiate(<?php echo $id; ?>)">Yes, I do</button>
                                        <button type="button" class="btn bg-danger btn-sm px-4 text-light"
                                            data-bs-dismiss="modal">No, I don't</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif



                            @if($revoke_status = 0)
                                    <div id="approval" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="customModalLabel">Are you sure to approve
                                                        this Leave Revoke</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-main btn-sm px-4"
                                                        onclick="approveLeaveRevoke(<?php echo $id; ?>)">Yes I am</button>
                                                    <button type="button" class="btn bg-danger btn-sm px-4 text-light"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                             @elseif (Auth()->user()->emp_id == $particularLeave->level1)
                                <div id="approval" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="customModalLabel">Are you sure to approve this
                                                    Leave Revoke</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-main btn-sm px-4"
                                                    onclick="approveLeaveRevoke(<?php echo $id; ?>)">Submit</button>
                                                <button type="button" class="btn bg-danger btn-sm px-4 text-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @else
                            <div id="approval" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="customModalLabel">Provide a Reason to Revoke This
                                                Approved Leave</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <label for="reason">State Reason of Leave Revoking<span
                                                    class="text-danger">*</span></label>
                                            <textarea id="commentInput" class="form-control" placeholder="Enter your reason here" required></textarea>
                                            @if ($startDate <= date('Y-m-d'))
                                                <div class="form-group col-md-6">
                                                    <label for="end-date">Date of Return <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="end-date" value="{{ $endDate }}"
                                                        name="new_end" class="form-control" min="{{$startDate}}" max="{{$endDate}}">
                                                </div>
                                            @elseif($startDate > date('Y-m-d'))
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="start-date">New Date of Start <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="start-date" value="{{ $startDate }}"
                                                        name="new_start" class="form-control" min="{{$startDate}}" max="{{$endDate}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="end-date">New Date of Return <span
                                                            class="text-danger">*</span></label>
                                                    <input type="date" id="end-date" value="{{ $endDate }}"
                                                        name="new_end" class="form-control" min="{{$startDate}}" max="{{$endDate}}">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-main btn-sm px-4"
                                                onclick="submitComment(<?php echo $id; ?>)">Submit</button>
                                            <button type="button" class="btn btn-danger btn-sm px-4 text-light"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                </div>

            </div>
        </div>
    @endsection


    @push('footer-script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
        <script>
            function submitComment(id) {
                const comment = $('#commentInput').val();
                const expectedDate = $('#new_end').val();
                const expectedStartDate = $('#new_start').val();
                if (comment) {
                    const terminationid = id;
                    const data = {
                        terminationid: terminationid,
                        comment: comment,
                        expectedDate: expectedDate,
                        newStartDate: expectedStartDate,
                    };

                    $.ajax({
                        url: '{{ url('') }}/flex/attendance/revokeApprovedLeave',
                        type: 'POST',
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            console.log(data);
                            // Close the modal
                            $('#customModal').modal('hide');
                            // Redirect to the specified URL
                            window.history.back();
                        },
                        error: function(err) {
                            console.log(err.responseText);
                        }
                    });
                } else {
                    alert('Please enter a reason before submitting.');
                }
            }
        </script>

        <script>
            function approveLeaveRevoke(id, comment) {
                const terminationid = id;
                var data = terminationid + "|" + comment;
                var url = '{{ url('') }}/flex/attendance/revokeApprovedLeaveAdmin/' + terminationid;
                $.ajax({
                    url: url,
                    type: 'put', // Use 'POST' if you are sending a POST request
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        // Close the modal
                        $('#approval').modal('hide');
                        // Redirect to the specified URL
                        window.history.back();
                    },
                    error: function(err) {
                        console.log(err.responseText);
                    }
                });
            }
        </script>

        <script>
            function revokeCompleteRevokeInitiate(id){
                const comment = $('#commentInput').val();
                const terminationid = id;
                if (comment) {
                    const data = {
                        terminationid: terminationid,
                        comment: comment,
                    };
                var url = '{{ url('') }}/flex/attendance/totalRevokeInitiate';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: JSON.stringify(data),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        // Close the modal
                        $('#approval').modal('hide');
                        // Redirect to the specified URL
                        window.history.back();
                    },
                    error: function(err) {
                        console.log(err.responseText);
                    }
                });
         }
        }
        </script>
        <script>
            function approveRevokeCompleteRevokeInitiate(id){
                const terminationid = id;
                var url = '{{ url('') }}/flex/attendance/approveTotalRevoke/' + terminationid;
                $.ajax({
                    url: url,
                    type: 'put', // Use 'POST' if you are sending a POST request
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        // Close the modal
                        $('#approval').modal('hide');
                        // Redirect to the specified URL
                        window.history.back();
                    },
                    error: function(err) {
                        console.log(err.responseText);
                    }
                });
         }
        </script>
    @endpush
