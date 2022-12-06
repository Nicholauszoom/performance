@extends('layouts.vertical', ['title' => 'Imprest'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">My Overtime</h5>

            <button
                    type="button"
                    class="btn btn-perfrom"
                    data-bs-toggle="modal"
                    data-bs-target="#save_department"
                >
                    <i class="ph-paper-plane-tilt me-2"></i> Apply Overtime
                </button>
        </div>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Date</th>
                <th>Total Overtime(in Hrs.)</th>
                <th>Reason(Description)</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>
            {{-- @foreach ($audits as $audit)
            <tr>
                <td>{{ $audit->user_id }}</td>
                <td><a href="#">{{ $audit->user_name }}</a></td>
                <td>{{ $audit->action_performed }}</td>
                <td>{{ $audit->ip_address }}</td>
                <td>{{ $audit->created_at }}</td>
                <td>
                    @isset($audit->risk)
                        @if ($audit->risk == 1)
                        <span class="badge bg-success bg-opacity-10 text-success">Low</span>
                        @elseif ($audit->risk == 2)
                        <span class="badge bg-info bg-opacity-10 text-info">Medium</span>
                        @elseif ($audit->risk == 3)
                        <span class="badge bg-danger bg-opacity-10 text-danger">High</span>
                        @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">Unrecognized</span>
                        @endif
                    @endisset
                </td>

            </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>

@endsection

@section('modal')

   @include('workforce-management.inc.add-imprest')

@endsection
