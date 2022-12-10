@extends('layouts.vertical', ['title' => 'Organisation'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

    @endpush

    @push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    @endpush

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Account Coding </h3>
    </div>
    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Code</th>
                <th>Name</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>

                @foreach ($accounting_coding as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->code }}</td>
                <td>{{ $row->name }}</td>
                <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                <td>Actino</td>
                <td></td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>




 @endsection
