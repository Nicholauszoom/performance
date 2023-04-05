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
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <div class="">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="mb-0 text-muted text-start">Disciplinary Action</h5>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('flex/grievancesCompain') }}" class="btn btn-perfrom ">
                            <i class="ph-list me-2"></i> All Disciplinary Actions
                        </a>
                    </div>
                </div>



            </div>
        </div>


        @foreach ($actions as $item)
            <div class="col-12">
                @if (session('msg'))
                    <div class="alert alert-success col-md-8 mx-auto" role="alert">
                        {{ session('msg') }}
                    </div>
                @endif
                <div class="row mx-2">
                    <div class="col-12">
                        <h6 class="text-main">Employee Name:

                            <span class="text-muted font-weight-light">
                                {{ $item->employee->fname }} {{ $item->employee->mname }} {{ $item->employee->lname }}
                            </span>
                        </h6>

                    </div>
                    <div class="col-12">
                        <h6 class="text-main"> Department Name:

                            <span class="text-muted font-weight-light">
                                {{ $item->departments->name }}
                            </span>
                        </h6>
                    </div>
                    <div class="col-12">
                        <h6 class="text-main"> Suspension:

                            <span class="text-danger font-weight-light">
                                {{ $item->suspension }}
                            </span>
                        </h6>
                        <hr>

                    </div>



                    <div class="col-12">
                        <h6 class="text-main">
                            Date of Charge sheet:

                            <span class="text-muted font-weight-light">
                                {{ $item->date_of_charge }}
                            </span>
                        </h6>
                        <hr>

                        <h6 class="text-main">
                            Details of the Charge:
                        </h6>
                        <p>
                            {!! $item->detail_of_charge !!}
                        </p>

                        <hr>
                    </div>


                    <div class="col-12">
                        <h6 class="text-main">
                            Findings & Sanction-Recommendations <small> (from the disciplinary Committee)</small>
                        </h6>
                        <h6 class="text-main">Date of Hearing:

                            <span class="text-muted font-weight-light">
                                {{ $item->date_of_hearing }}
                            </span>
                        </h6>



                        <table class="table table-bordered">
                            <thead>
                                <th>Findings <small> (from the disciplinary Committee)</small></th>
                                {{-- <th>Findings  <small> (from the disciplinary Committee)</small></th> --}}
                                <th>Sanction-Recommendations</th>
                            </thead>
                            <tr>
                                <td>
                                    <p class="text-muted font-weight-light">
                                        {!! $item->detail_of_hearing !!}
                                    </p>
                                </td>
                                {{-- <td>
                        <p>
                            {!!$item->findings !!}

                        </p>

                    </td> --}}
                                <td>
                                    <p>{{ $item->recommended_sanctum }}</p>
                                </td>
                            </tr>
                        </table>
                        <hr>
                    </div>



                    <div class="col-12 mx-1">
                        <h6 class="text-main">
                            Final Decision/Sanction Imposed
                        </h6>
                        <p>
                            {!! $item->final_decission !!}
                        </p>

                    </div>

                    @if (!empty($item->date_of_receiving_appeal))
                        <table class="table table-bordered">
                            <thead>
                                <th>Appeal Received By</th>
                                <th>Date</th>
                                <th>Reasons</th>
                            </thead>
                            <tr>
                                <td>
                                    <p class="text-muted font-weight-light">
                                        {!! $item->detail_of_hearing !!}
                                    </p>
                                </td>
                                <td>
                                    <p>{{ $item->date_of_receiving_appeal }}</p>
                                </td>
                                <td>
                                    <p>{{ $item->appeal_reasons }}</p>
                                </td>
                            </tr>
                        </table>


                        <div class="col-12 mx-1">
                            <h6 class="text-main">
                                Findings of the Appeal
                            </h6>
                            <p>
                                {!! $item->appeal_findings !!}
                            </p>

                        </div>


                        <div class="col-12 mx-1">
                            <h6 class="text-main">
                                Outcome of the appeal
                            </h6>
                            <p>
                                {!! $item->appeal_outcomes !!}
                            </p>

                        </div>
                    @endif
                    <hr>
                    <div class="col-9"></div>
                    <div class="col-3 mb-2">
                        {{-- start of edit button --}}
                        @can('edit-grivance')
                            <a href="{{ route('flex.editDisciplinary', base64_encode($item->id)) }}" class="btn btn-main">
                                <i class="ph-pen"></i>
                                Edit Disciplinary Action
                            </a>
                        @endcan
                        {{-- / --}}
                    </div>

                </div>
            </div>
        @endforeach

    </div>
@endsection
