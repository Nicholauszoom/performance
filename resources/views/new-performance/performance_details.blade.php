@extends('layouts.vertical', ['title' => 'Add Pillar'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>

    <style>
        .table-responsive {
          overflow-x: auto;
          max-width: 100%;
          -ms-overflow-style: -ms-autohiding-scrollbar;
        }
      </style>
@endpush

@section('page-header')
    @include('layouts.shared.page-header')
@endsection

@section('content')
    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 text-warning card-tirle"> {{ $employee->fname }} {{ $employee->lname }} </h5>
            </div>

            <div class="d-flex justify-content-between mt-2">
                <a href="{{ url('flex/add-evaluation/'.$evaluation->id) }}" class="btn btn-main btn-sm float-end"> <i
                    class="ph-list me-2"></i> Add Evaluations</a>

                    <a href="{{ url(Request::url()) }}" class="btn btn-main btn-sm float-end"> <i
                        class="ph-list me-2"></i> Back</a>
            </div>

            {{-- <a href="{{ url(Request::url()) }}" class="btn btn-main btn-sm float-end"> <i
                    class="ph-list me-2"></i> Back</a> --}}
        </div>

        @if (session('msg'))
            <div class="alert alert-success col-md-8 mx-auto" role="alert"> {{ session('msg') }} </div>
        @endif

        <form action="{{ route('flex.submit_performance') }}" method="POST">
            @csrf
<input type="number" hidden value="{{ $id }}" name="evaluation_id">
            <div class="card-body">
                <p class="text-muted"><b> 1. COMPLETE KPA/KPI: The What (90%)</b></p>
            </div>

            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <th style="width: 70px">#</th>
                        <th>Strategic Pillar</th>
                        <th style="width: 70px">Key action </th>
                        <th>Measure</th>
                        <th>Result</th>
                        <th>Rating(1-5)</th>
                        <th>W/ting(%)</th>
                        <th>Score</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($strategy as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <label class="form-label">{{ $item->performance->name }}:</label>
                                </td>
                                <td>
                                    {{ $item->actions }}
                                </td>

                                <td>
                                    {{ $item->measures }}
                                </td>
                                <td>
                                    {{ $item->results }}
                                </td>
                                <td>
                                    {{ $item->rating }}
                                </td>
                                <td>
                                    {{ $item->weighting }}
                                </td>
                                <td>
                                    {{ $item->score }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-perfrom" data-bs-toggle="modal"
                                        data-bs-target="#addScoreModal" onclick="model({{ $item->id }},'overhead')">
                                        <i class="ph-plus me-2"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <div class="card-body mt-4">
                <p class="text-muted"><b>BEHAVIOURAL COMPETENCES - BancABC Values (10%)</b></p>
            </div>

            <div class="table-responsive">
                <table class="table datatable-basic">
                    <thead>
                        <th>#</th>
                        <th>Strategic Pillar</th>
                        <th>Values drive our culture, commitment and performance </th>

                        <th>Rating(1-5)</th>
                        <th>W/ting(%)</th>
                        <th>Score</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($behaviour as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <label class="form-label">{{ $item->performance->name }}:</label>
                            </td>
                            <td>
                                {{ $item->performance->notes }}
                            </td>



                            <td>
                                {{ $item->rating }}
                            </td>
                            <td>
                                {{ $item->weighting }}
                            </td>
                            <td>
                                {{ $item->score }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal"
                                    data-bs-target="#addScoreModal" onclick="model({{ $item->id }},'behaviour')">
                                    <i class="ph-plus me-2"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-perfrom mb-1 float-end">Submit</button>
            </div>
        </form>
    </div>



    <div class="modal fade" role="dialog" id="addScoreModal" aria-labelledby="addScoreModal" data-backdrop="static">
        <div class="modal-dialog" role="document"> </div>
    </div>
@endsection
@section('modal')
    {{-- @include('new-performance.add-score') --}}
@endsection
@push('footer-script')
    <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ route('flex.modal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {

                    $('.modal-dialog').html(data);
                },
                error: function(error) {
                    $('#addScoreModal').modal('toggle');

                }
            });

        }
    </script>
@endpush
 