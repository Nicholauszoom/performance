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
            <h5 class="mb-0 text-muted">Imprest</h5>

            <button
                type="button"
                class="btn btn-perfrom"
                data-bs-toggle="modal"
                data-bs-target="#save_department"
            >
                <i class="ph-paper-plane-tilt me-2"></i> Request Imprest
            </button>
        </div>
    </div>


    <table class="table datatable-basic">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Description</th>
                <th>Date Requested</th>
                <th>Cost</th>
                <th>Status</th>
                {{-- <th>Option</th> --}}
            </tr>
        </thead>

        <tbody>
            @foreach ($my_imprests as $row)
                <tr id="{{ "recordImprest".$row->id }}">
                    <td width="1px"> {{ $row->SNo }} </td>
                    <td> {{ $row->title }}</td>
                    <td>
                        <a
                            class="panel-heading collapsed"
                            role="tab"
                            id="headingTwo"
                            data-toggle="collapse"
                            data-parent="#accordion"
                            href="{{ '#collapseDescription'.$row->id  }}"
                            aria-expanded="false"
                        >
                          <span class="label label-default">DESCRIPTION</span>
                        </a>
                        <div id="{{ "collapseDescription" .$row->id }}" class="panel-collapse collapse" role="tabpanel" >
                            <p>{{ $row->description }}</p>
                        </div>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($row->application_date)) }}</td>

                    <td>
                        <strong class="text-success">REQUESTED : </strong>{{ number_format($row->requested_amount, 2) }}
                    </td>

                    <td>
                        <div id ="{{ "status".$row->id }}">
                            @if($row->status==0)
                                <span class="badge bg-default">REQUESTED</span>
                            @elseif($row->status==1)
                                <span class="badge bg-info">RECOMENDED BY FINANCE</span>
                            @elseif($row->status==9)
                                <span class="badge bg-info">RECOMENDED BY HR</span>
                            @elseif($row->status==2)
                                <span class="badge bg-success">APPROVED</span>
                            @elseif($row->status==3)
                                <span class="badge bg-success">CONFIRMED</span>
                            @elseif($row->status==4)
                                <span class="badge bg-success">RETIRED</span>
                            @elseif($row->status==5)
                                <span class="badge bg-success">RETIREMENT CONFIRMED</span>
                            @elseif($row->status==6)
                                <span class="badge bg-danger">DISSAPPROVED</span>
                            @elseif($row->status==7)
                                <span class="badge bg-danger">UNCONFIRMED</span>
                            @elseif($row->status==8)
                                <span class="badge bg-danger">UNCONFIRMED RETIREMENT</span>
                            @endif
                        </div>

                    </td>

                    {{-- options comes here --}}
                </tr>
            @endforeach

          </tbody>
    </table>
</div>

@endsection

@section('modal')

   @include('workforce-management.inc.add-imprest')

@endsection

