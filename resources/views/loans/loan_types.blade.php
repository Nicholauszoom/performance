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

<div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
    <div class="card-header border-0">
        <div class="">
            <h6 class="mb-0 text-warning">Loan Types</h6>

@can('add-loan-type')
            <button class="float-end btn btn-main" data-bs-toggle="modal" data-bs-target="#approval"> Add New Loan Type</button>
            @endcan
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

                @can('view-loan-type')
                <table class="table datatable-basic">
                    <thead>
                        <th>SN</th>
                        <th class="text-center">Loan Name</th>
                        <th class="text-center">Code</th>
                        <th >Actions</th>
                    </thead>
                    <tbody>
                        @forelse ($loan_types as $item )
                            <tr>
                                <td>{{ $loop-> index+1}}</td>
                                <td class="text-center">{{ $item->name}}</td>
                                <td class="text-center">{{ $item->code}}</td>
                                <td>
                                    <a href="{{ route('flex.approval-levels', base64_encode($item->id)) }}" class="btn btn-main btn-sm" aria-label="Edit">
                                        <i class="ph-info"></i>
                                    </a>
                                    {{-- <a href="{{ route('flex.deleteApproval', $item->id) }}" class="btn btn-danger btn-sm" >
                                        <i class="ph-trash"></i>
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endcan
            </div>

        </div>


    </div>



</div>


{{-- start of add approval modal --}}

<div id="approval" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loan Type Form</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal">

                </button>
            </div>

            <form
                action="{{ route('flex.saveLoanType') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">

                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Loan Name: </label>
                            <input type="text"  name="name"  value="{{ old('name') }}" placeholder="Enter Loan Type Name" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Loan Type Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Loan Code</label>
                            <input type="number" name="code" placeholder="Enter Escallation Time"  value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror">

                            @error('code')
                                <p class="text-danger mt-1"> Field Loan has an error </p>
                            @enderror
                    </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Approval</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- end of add approval modal --}}

@endsection

@push('footer-script')


@endpush


