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

<div class="card">
    <div class="card-header border-0">
        <div class="">
            <h5 class="mb-0 text-muted">Approval Level</h5>

            <button class="float-end btn btn-main" data-bs-toggle="modal" data-bs-target="#approval"> Add Approval Level</button>
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
                        <th class="text-center">Approval Level</th>
                        <th class="text-center">Approval Role</th>
                        <th class="text-center">Label Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Status</th>
                        <th >Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($levels as $item )
                            <tr>
                                <td>{{ $i++}}</td>
                                <td class="text-center">{{ $item->level_name}}</td>
                                <td class="text-center">{{ $item->role}}</td>
                                <td class="text-center">{{ $item->label_name}}</td>
                                <td class="text-center">{{ $item->rank}}</td>
                                <td class="text-center">{{ $item->escallation=='1'? 'Yes':'No' }}</td>

                                <td>
                                    <a href="" class="btn btn-main btn-sm" aria-label="Edit">
                                        <i class="ph-info"></i>
                                    </a>
                                    <a href="" class="btn btn-main btn-sm" aria-label="Edit">
                                        <i class="ph-pen"></i>
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Level Form</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal">

                </button>
            </div>

            <form
                action="{{ route('flex.saveApprovals') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Level: </label>
                            <input type="text"  name="level_name"  value="{{ old('process_name') }}" placeholder="Enter Process Name" class="form-control @error('process_name') is-invalid @enderror">

                            @error('process_name')
                                <p class="text-danger mt-1"> Field Process Name has an error </p>
                            @enderror
                    </div>


                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Label Name </label>
                            <input type="text"  name="label_name"  value="{{ old('process_name') }}" placeholder="Enter Label Name" class="form-control @error('process_name') is-invalid @enderror">

                            @error('process_name')
                                <p class="text-danger mt-1"> Field Process Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6">
                        <label class="col-form-label col-sm-3"> </label>
                            <select name="rank" class="form-control select">
                                <option value="Not Final">Not Final</option>
                                <option value="Final">Final</option>
                            </select>
                            @error('escallation_time')
                                <p class="text-danger mt-1"> Field Escallation Time has an error </p>
                            @enderror
                    </div>
                    <div class="form-group col-6 py-3">
                        <label class="col-form-label" for="escallation">Status</label>
                            <input type="checkbox" name="escallation" id="escallation">
                            @error('escallation')
                                <p class="text-danger mt-1"> Field Escallation has an error </p>
                            @enderror
                    </div>


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Approval Level</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- end of add approval modal --}}

@endsection

@push('footer-script')


@endpush


