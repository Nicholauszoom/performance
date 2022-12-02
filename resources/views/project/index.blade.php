@extends('layouts.vertical', ['title' => 'Projects'])

@push('head-script')
    <script src="{{ asset('tasset/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('tasset/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Audit Trail</h5>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Action</th>
                <th>IP Adress</th>
                <th>Time performed</th>
                <th>Risk</th>
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
