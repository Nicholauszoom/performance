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

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">Increment Employee Salary</h5>

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
                            action="{{ route('flex.saveIncrement') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf
            
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Incremented Employee:</label>
                                            <select class="form-control select @error('emp_ID') is-invalid @enderror" id="docNo" name="emp_ID">
                                                <option value=""> Select Employee </option>
                                                @foreach ($employees as $depart)
                                                <option value="{{ $depart->id }}">{{ $depart->fname }} {{ $depart->mname }} {{ $depart->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                 

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">Old Salary</label>
                                  
                                        <input disabled name="oldSalary"  class="form-control" id="salary">
            
                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                   
                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">Incremented Salary</label>
                                    
                                        <input type="text" name="newSalary" class="form-control" id="newSalary" placeholder="Enter New Salary" required>
            
                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div>
            
            
                            </div>
                                
                                  
                            </div>
            
                            <div class="modal-footer">
                                <hr>
                              
                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Send Request</button>
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


