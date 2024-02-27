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

<div class="card  border-top  border-top-width-3 border-top-black rounded-0">
    <div class="card-header border-0">
        <div class="">
            <h6 class="mb-0 text-muted">Approval Level</h6>
            <a href="{{ url('settings/approvals') }}" class=" float-end btn-secondary btn-sm btn mx-1">
            <i class="ph-list"></i>
            All Approval Roles
            </a>
            <button class="float-end btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#approval"> Add Approval Level</button>
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
                        <th>SN</th>
                        <th >Approval Level</th>
                        <th >Approval Role</th>
                        <th >Level Name</th>
                        <th >Rank</th>
                        <th >Status</th>
                        <th >Actions</th>
                    </thead>
                    <tbody>

                        
                        @forelse ($levels as $item )
                            <tr>
                                <td>{{ $i++}}</td>
                                <td >{{ $item->level_name}}</td>
                                <td >{{ $item->roles->name??'N/A'}}</td>
                                <td >{{ $item->label_name}}</td>
                                <td >{{ $item->rank}}</td>
                                <td >{{ $item->escallation=='1'? 'Yes':'No' }}</td>

                                <td>
                                    {{-- <a href="" class="btn btn-secondary btn-sm" aria-label="Edit">
                                        <i class="ph-pen"></i>
                                    </a> --}}
                                    <a href="{{ route('flex.deleteApprovalLevel', $item->id) }}"

                                        class="btn btn-danger btn-sm
                                        @if($item->level_name != $approval->levels)
                                        {{-- disabled --}}
                                        @endif
                                        " aria-label="Edit">
                                        <i class="ph-trash"></i>
                                    </a>
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


{{-- start of add approval modal --}}

<div id="approval" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Level Form</h5>
                <button type="button" class="btn-close btn-danger " data-bs-dismiss="modal">

                </button>
            </div>

            <form
                action="{{ route('flex.saveApprovalLevel') }}"
                method="POST"
                id="add_approval_form"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Level: </label>
                            {{-- <input type="number"   name="level_name"  value="{{ $approval->levels+1 }}" class="form-control @error('process_name') is-invalid @enderror"> --}}
                            <input type="number"  name="level_name"  value="{{ $approval->levels+1 }}" class="form-control @error('process_name') is-invalid @enderror" >
                            <input type="hidden" name="approval_id" value="{{ $approval->id }}">
                            @error('process_name')
                                <p class="text-danger mt-1"> Field Process Name has an error </p>
                            @enderror
                    </div>


                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Level Name </label>
                            <input type="text"  name="label_name"  value="{{ old('process_name') }}" placeholder="Enter Button Label Name" class="form-control @error('process_name') is-invalid @enderror">

                            @error('process_name')
                                <p class="text-danger mt-1"> Field Process Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="col-form-label col-sm-3">Role</label>
                        <select name="role_id" id="role_id" class="select form-control">
                            @foreach ( $roles as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach

                        </select>
                            @error('process_name')
                                <p class="text-danger mt-1"> Field Process Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-9" hidden>
                        <label class="col-form-label col-sm-3">Level Rank </label>
                            <select name="rank" class="form-control ">
                                <option value="Not Final">Not Final</option>
                                <option value="Final">Final</option>
                            </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-3 py-4 " hidden>
                        <label class="col-form-label" for="escallation">Level Status</label>
                            <input type="checkbox" name="escallation" id="escallation">
                            @error('escallation')
                                <p class="text-danger mt-1"> Field Escallation has an error </p>
                            @enderror
                    </div>


                    </div>
                </div>

                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> --}}
                    <button type="submit" id="add_approval_btn" class="btn btn-secondary">Save Approval Level</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- end of add approval modal --}}
<script>

    $(document).ready(function() {
        $('.select').each(function() {
            $(this).select2({ dropdownParent: $(this).parent()});
        })
    });
</script>
    {{--For Assign Driver --}}
    <script>
        $("#add_approval_form").submit(function(e) {
            // e.preventDefault();
            $("#add_approval_btn").html("<i class='ph-spinner spinner me-2'></i> Saving ...").addClass('disabled');

        });
    </script>
@endsection




