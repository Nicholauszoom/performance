@extends('layouts.vertical', ['title' => 'Increment Salary'])

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
            <h5 class="mb-0 text-warning">Employee Salary Increment</h5>

                <a href="{{ route('flex.promotion') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Promotions|Increments
                </a>
        </div>
    <hr class="text-warning">
    </div>


            <div id="save_termination" class="" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form
                            action="{{ route('flex.saveIncrement') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label"> Employee:</label>
                                            <select class="form-control select @error('emp_ID') is-invalid @enderror" id="docNo" name="emp_ID">
                                                <option value=""> Select Employee </option>
                                                @foreach ($employees as $depart)
                                                <option value="{{ $depart->emp_id }}">{{ $depart->emp_id }} - {{ $depart->fname }} {{ $depart->mname }} {{ $depart->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">Old Salary</label>

                                    <input type="hidden" name="oldRate"  class="form-control"  id="oldRate">

                                    <input type="hidden" name="oldSalary"  class="form-control"  id="oldsalary">

                                        <input disabled name=""  class="form-control"  id="salary">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror

                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">New Salary</label>

                                        <input type="text" name="newSalary" class="form-control" id="newSalary" placeholder="Enter New Salary" required>

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div>


                            </div>


                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


</div>

<div class="card border-top  border-top-width-3 border-top-main rounded-0">

    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-warning"> Add Salary Increment and Arrears By Uploading File</h5>

                {{-- <a href="{{ route('flex.promotion') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Promotions|Increments
                </a> --}}
        </div>
    <hr class="text-warning">
    </div>


            <div  class="" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form
                            action="{{ route('flex.addBulkIncrement') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">



                                <div class="col-md-12 col-lg-12 mb-3">
                                    <label class="form-label ">Add File</label>



                                        <input  name="file" type="file"  class="form-control"  id="file">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror

                                </div>




                            </div>


                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


</div>




@endsection

@push('footer-script')

<script>

$('#docNo').change(function(){
    var id = $(this).val();
    var url = '{{ route("getDetails", ":id") }}';
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        success: function(response){
            if(response != null){

                document.getElementById("oldsalary").value = response.salary;
                document.getElementById("oldRate").value = response.rate;

                $('#salary').val(response.salary+' '+response.currency);
                $('#oldLevel').val(response.emp_level);
                $('#oldPosition').val(response.position.name);
            }
        }
    });
});


</script>


@endpush


