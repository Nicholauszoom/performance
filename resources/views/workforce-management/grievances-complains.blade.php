@extends('layouts.vertical', ['title' => 'Grievances/Complains'])

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
            <div class="row">
                <div class="col-md-9">
                    <h5 class="mb-0 text-muted text-start">Grievances | Disciplinary Action</h5>
                </div>
                <div class="col-md-3">
                        <a href="{{ route('flex.addDisciplinary') }}" class="btn btn-perfrom ">
                            <i class="ph-plus me-2"></i> Add Disciplinary Action
                        </a>
                </div>
            </div>



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
                <th>Department</th>
                <th>Suspension</th>
                <th>Date of Charge</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
               @foreach ($actions as $item)
            <tr>
            <td>{{$i++}}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->departments->name}}</td>
             <td>  {{ $item->suspension}}  </td>
             <td> {{ $item->date_of_charge}}</td>
             <td>
                <a  href="{{ route('flex.viewDisciplinary', base64_encode($item->id)) }}"  title="Info and Details">
                    <button type="button" class="btn btn-sm btn-info btn-xs"><i class="ph-info"></i></button>
                </a>
                <a href="{{ route('flex.editDisciplinary', base64_encode($item->id)) }}" class="btn btn-info btn-sm">
                    <i class="ph-pen"></i>
                </a>
             </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

