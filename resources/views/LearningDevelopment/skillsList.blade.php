@extends('layouts.vertical', ['title' => 'Learning and Development'])

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
        <h5 class="mb-0 text-muted">Learning and development</h5>
    </div>

    <div class="card-body">
     List of skills
    </div>
<table class="table datatable-basic">
<thead>
<tr>
<td>Skill</td>
<td>Budget</td>
<td>Action</td>
</tr>
</thead>
@foreach ($users as $user)
<tr>
<td>{{ $user->skill }}</td>
<td>{{ $user->budget }}</td>
<td></td>
</tr>
@endforeach
</table>
</div>

@endsection
