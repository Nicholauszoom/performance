@extends('layouts.vertical', ['title' => 'Employee List'])

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
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 text-warning">Employee List</h5>


            </div>
            <hr>
        </div>

        <div id="save_termination" class="" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    @if (session('msg'))
                        <div class="alert alert-success col-md-8 mx-auto" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif

                    <form action="{{ route('flex.employee-performance') }}" method="POST" class="form-horizontal">
                        @csrf

                        <div class="modal-body">
                            <div class="row mb-3">



                                <input type="hidden" name="oldRate" class="form-control" id="oldRate">

                                <input type="hidden" name="oldSalary" class="form-control" id="oldsalary">
                                <div class="col-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Employee :</label>
                                        <select name="empID"  class="select form-control">
                                            @foreach ($employees as $item)
                                            <option value="{{ $item->emp_id }}">{{ $item->emp_id  }} | {{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</option>
                                            @endforeach
                                        </select>




                                    </div>
                                </div>
                         


                            </div>


                        </div>

                        <div class="modal-footer">
                            <hr>

                            <button type="submit" class="btn btn-perfrom  btn-block mb-2 mt-2">View Performance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('footer-script')
    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route('getDetails', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {

                        document.getElementById("oldsalary").value = response.salary;
                        document.getElementById("oldRate").value = response.rate;

                        $('#salary').val(response.salary + ' ' + response.currency);
                        $('#oldLevel').val(response.emp_level);
                        $('#oldPosition').val(response.position.name);
                    }
                }
            });
        });
    </script>
@endpush
