@extends('layouts.vertical', ['title' => 'Page starter'])

@push('head-script')
    {{-- script top --}}
@endpush

@push('head-scriptTwo')
    {{-- script bottom --}}
@endpush


@section('content')

<div class="card">
    <div class="card-header border-0">
        <h5 class="mb-0 text-muted">Audit Trail</h5>
    </div>


    {{-- content goes herer --}}
</div>

@endsection


