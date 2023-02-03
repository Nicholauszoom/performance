@extends('layouts.vertical', ['title' => 'Add Complain'])

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
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">Add Disciplinary Action</h5>

                <a href="{{ route('flex.grievancesCompain') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Disciplinary Actions
                </a>
        </div>
    <hr>
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
                            action="{{ route('flex.saveDisciplinary') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Accussed Employee:</label>
                                            <select class="form-control select @error('emp_ID') is-invalid @enderror" id="docNo" name="employeeID">
                                                <option value=""> -- Select Accused Employee -- </option>
                                                @foreach ($employees as $item)
                                                <option value="{{ $item->emp_id }}">{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Suspension:</label>
                                            <input type="text" name="suspension" id="" class="form-control" placeholder="Enter Suspension">
                                        </div>
                                    </div>
                                    <div class="col-3 col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Charge:</label>
                                            <input type="date" name="date_of_charge" id="" class="form-control" placeholder="Enter Date of Charge">
                                        </div>
                                    </div>

                                    <div class="col-9 col-lg-9">
                                        <div class="mb-3">
                                            <label class="form-label">Charge Description:</label>
                                            <textarea name="charge_description" id="" class="form-control" rows="6" placeholder="Enter Charge Description.."></textarea>
                                        </div>
                                    </div>

                                    <div class="col-3 col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Hearing:</label>
                                            <input type="date" name="date_of_hearing" id="" class="form-control" placeholder="Enter Date of Hearing">
                                        </div>
                                    </div>

                                    <div class="col-9 col-lg-9">
                                        <div class="mb-3">
                                            <label class="form-label">Hearing Description:</label>
                                            <textarea name="hearing_description" id="" class="form-control" placeholder="Enter Hearing details here.." rows="6"></textarea>
                                        </div>
                                    </div>
                                <div class="col-md-12 col-lg-12 mb-3">
                                    <label class="form-label ">Findings</label>

                                    <textarea name="findings"  class="form-control" placeholder="Enter Case Findings Here.." rows="4"></textarea>
                                        @error('findings')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Recommended Sanctum:</label>
                                        <input type="text" name="recommended_sanctum" id="" class="form-control" placeholder="Enter Recommended Sanctum">
                                    </div>
                                </div>


                                <div class="col-md-12 col-lg-12 mb-3">
                                    <label class="form-label ">Final Decission</label>

                                    <textarea name="final_decission"  class="form-control" placeholder="Enter Final Decission Here.." rows="4"></textarea>
                                        @error('description')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div>


                            </div>


                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save Case</button>
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
                $('#salary').val(response.salary+' '+response.currency);
                $('#oldLevel').val(response.emp_level);
                $('#oldPosition').val(response.position.name);
            }
        }
    });
});


</script>


@endpush


