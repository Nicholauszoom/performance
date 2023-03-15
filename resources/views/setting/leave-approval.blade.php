@extends('layouts.vertical', ['title' => 'Approvals'])

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


{{-- start of add approval modal --}}

<div id="approval" class="col-12" tabindex="-1">
    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Leave Approval</h5>
            </div>

            <form
                action="{{ route('flex.save-leave-approval') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group col-6">
                        <label class="col-form-label ">Employee Name: </label>
                            <select name="empID" class="form-control select">
                                <option value=""> -- Choose Employee Here -- </option>
                                @foreach($employees as $item)
                                <option value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                                @endforeach
                            </select>
                           
                    </div>

                    <div class="form-group col-6">
                        <label class="col-form-label ">Escallation Time ( <small class="text-danger">*days</small> ) </label>
                            <input type="number" required name="escallation_time" placeholder="Enter Escallation Time"  value="{{ old('escallation_time') }}" class="form-control @error('escallation_time') is-invalid @enderror">

                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label col-sm-3">Level 1 Approval</label>
                           <select name="level_1" class="form-control select">
                            <option value="" class="text-center"> -- select Level 1 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label ">Level 2 Approval</label>
                           <select name="level_2" class="form-control select text-center">
                            <option value="" class="text-center"> -- select Level 2 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label ">Level 3 Approval</label>
                        <select name="level_3" class="form-control select text-center">
                            <option value="" class="text-center"> -- select Level 3 Approver -- </option>
                            @foreach($employees as $item)
                            <option value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }} {{ $item->mname }} {{ $item->lname }} </option>
                            @endforeach
                           </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>

                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                  
                    <button type="submit" class="btn btn-perfrom">Save Leave Approval</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- end of add approval modal --}}
<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
    <div class="card-header border-0">
        <div class="">
            <h6 class="mb-0 text-warning">Leave Approvals</h6>

        </div>

    </div>
    <div class="row mx-1">
        <div class="col-12">
            @if (session('msg'))
            <div class="alert alert-success mx-auto" role="alert">
            {{ session('msg') }}
            </div>
            @endif
            <div class="">
                <table class="table datatable-basic">
                    <thead>
                        <th>EmpID</th>
                        <th >Employee Name</th>
                        <th >Level-1</th>
                        <th >Level-2</th>
                        <th >Level-3</th>
                        <th >Escallation Time</th>
                        <th >Actions</th>
                    </thead>
                    <tbody>
                        @foreach( $approvals as $item)
                        <tr>
                            <td>{{ $item->empID}}</td>
                            <td>{{ $item->employee->fname }} {{ $item->employee->mname }} {{ $item->employee->lname }}</td>
                           <td> {{ $item->levelOne->fname }} {{ $item->levelOne->mname }} {{ $item->levelOne->lname }} </td> 
                           <td>@if( $item->levelTwo != null){{ $item->levelTwo->fname }} {{ $item->levelTwo->mname }} {{ $item->levelTwo->lname }} @else - @endif </td>
                           <td>@if( $item->levelThree != null){{ $item->levelThree->fname }} {{ $item->levelThree->mname }} {{ $item->levelThree->lname }} @else -@endif</td>
                            <td>{{ $item->escallation_time }}</td>
                            <td>
                                <a href="{{ route('flex.editLeaveApproval', $item->id) }}" class="btn btn-sm bg-main" title="Edit This Leave Approval">
                                    <i class="ph-note-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" title="Delete This Approval"  class="icon-2 info-tooltip btn btn-sm btn-danger"
                                    onclick="deleteApproval(<?php echo $item->id; ?>)">
                                    <i class="ph-trash"></i>
                                </a>
                            </td>
                        </tr>

                        @endforeach
                 
                    </tbody>
                </table>
            </div>

        </div>


    </div>



</div>



@endsection

@push('footer-script')
    <script>
      
   

        function deleteApproval(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Delete This Leave Approval?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                        url: "{{ url('flex/delete-leave-approval') }}/" + terminationid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">Deleted</span></div>'
                                );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Cancelled!',
                            'Leave Approval Was Deleted Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Leave Approval Deletion Failed!! ....',
                            'success'
                        )

                        alert('Leave Approval Deletion Failed !! ...');
                    });
                }
            });

       
        }
    </script>
@endpush
