@extends('layouts.vertical', ['title' => 'Promote Employee'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>

    
	<!-- Theme JS files -->
	<script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('assets/demo/pages/extra_noty.js') }}"></script>
	<!-- /theme JS files -->
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-warning">Promote Employee</h5>

                <a href="{{ route('flex.promotion') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Promotions|Increments
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
                            action="{{ route('flex.savePromotion') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label"> Employee:</label>
                                            <select class="form-control select @error('department') is-invalid @enderror" id="docNo" name="emp_ID">
                                                <option value=""> Select Employee </option>
                                                @foreach ($employees as $depart)
                                                <option value="{{ $depart->emp_id }}">{{ $depart->emp_id }} - {{ $depart->fname }} {{ $depart->mname }} {{ $depart->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Position:</label>
                                            <input type="text" name="oldLevel" id="oldPosition" disabled  value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Current level">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">New Position Position:</label>
                                            <select required     class="form-control select1_single  select @error('newPosition') is-invalid @enderror" id="newPosition" name="newPosition">
                                                <option value=""> Select New Position </option>
                                                @foreach ($pdrop as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="oldRate"  class="form-control"  id="oldRate">

                                    <input type="hidden" name="oldSalary"  class="form-control"  id="oldsalary">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Level:</label>
                                            <input type="text" name="" id="oldLevel" disabled  value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Current level">
                                            <input type="hidden" name="oldLevel" id="oldLevel"   value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Current level">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">

                                            <div class="mb-3">
                                                <label class="form-label">New Job Level:</label>
                                                <select name="newLevel" id="newLevel" required class="form-select select">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="25">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                </select>

                                    </div>
                                </div>






                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">Current Salary</label>

                                        <input disabled name="oldSalary"  class="form-control" id="salary">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror

                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">New Salary</label>

                                        <input type="text" name="newSalary" class="form-control" id="" placeholder="Enter New Salary">

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


