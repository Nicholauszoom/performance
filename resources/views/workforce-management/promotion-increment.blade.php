@extends('layouts.vertical', ['title' => 'Promotion/Increment'])

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

<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header border-0">
        <div class="">
            <div class="row  py-2">
                <div class="col-md-7">
                    <h6 class="mb-0 text-warning text-start">Promotion| Increment</h6>
                </div>
                <div class="col-md-5">
           
                        {{-- start of increment salary button --}}
                        @can('add-increment')
                        <a href="{{ route('flex.addIncrement') }}" class="btn btn-perfrom btn-xs text-end mx-1 float-end">
                        <i class="ph-plus me-2"></i> Increment Salary
                        </a>
                        @endcan
                        {{-- / --}}

                        {{--  start of perform promotion button --}}
                        @can('add-promotion')
                        <a href="{{ route('flex.addPromotion') }}" class="btn btn-perfrom btn-xs mx-1 float-end">
                            <i class="ph-plus me-2"></i> Peform Promotion
                        </a>
                        @endcan
                        {{-- / --}}
                </div>
            </div>
            <hr class="text-warning">
    


        </div>
    </div>
    @if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto" role="alert">
    {{ session('msg') }}
    </div>
    @endif


    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Position</th>
                <th>Old Salary</th>
                <th>New Salary</th>
                <th>Activity</th>
                <th>Status</th>
                @can('edit-promotion')
                <th>Action</th>
                @endcan
            </tr>
        </thead>

        <tbody>
               @foreach ($promotions as $item)
            <tr>
            <td>{{$i++}}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->position->name}}</td>
             <td>{{ number_format($item->oldSalary,2)}} </td>
             <td>{{ number_format($item->newSalary,2)}} </td>
             <td>
                @if($item->action=="incremented")
                    <span class="badge bg-main  bg-opacity-40 text-light">{{ $item->action}}</span>
                    <br>
                @else
                    <span class="badge bg-main bg-opacity-60 text-light">{{ $item->action}}</span>

                @endif
            </td>
            <td>
                <span class="badge bg-success bg-opacity-30 text-light">{{ $item->status}}</span>
            </td>
            @can('edit-promotion')
            <td>
            @if($level)
            @if($item->status!='Successful')
            @if ($item->status!=$check)
           
                {{-- start of termination confirm button --}}
         
                <a href="javascript:void(0)" title="Approve" class="me-2"
                onclick="approvePromotion(<?php echo $item->id; ?>)">
                <button class="btn btn-main btn-sm"><i class="ph-check"></i> Confirm</button>
            </a>
                {{-- / --}}

                {{-- start of termination confirm button --}}
                <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                onclick="cancelPromotion(<?php echo $item->id; ?>)">
                <button class="btn btn-danger btn-sm"><i class="ph-x"></i>  Cancel</button>
                 </a>
                {{-- / --}}
           
                @endif
                @endif
                @endif
                </td>
                @endcan
    
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
      
        function approvePromotion(id) {


            Swal.fire({
                title: 'Are You Sure You Want to Promote This Employee?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var overtimeid = id;

                    $.ajax({
                        url: "{{ url('flex/approve-promotion') }}/" + overtimeid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });
                        /*$('#status'+id).fadeOut('fast', function(){
                             $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                           });
                        $('#record'+id).fadeOut('fast', function(){
                             $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                           });*/
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Promotion Approval Failed!! ...');
                    });
                }
            });

        }



        function cancelPromotion(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Employee Promotion ?',
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
                        url: "{{ url('flex/cancel-promotion') }}/" + terminationid
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
                            'Employee Termination Cancelled Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Employee Termination Cancellation Failed!! ....',
                            'success'
                        )

                        alert('Employee Termination Cancellation Failed!! ...');
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