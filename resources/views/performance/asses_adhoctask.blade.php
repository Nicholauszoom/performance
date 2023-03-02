@extends('layouts.vertical', ['title' => 'Assess Task'])

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
            <h5 class="mb-0 text-warning">Asses Adhoc Task</h5>

                <a href="{{ url('flex/tasks'); }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Adhoc Tasks
                </a>
        </div>
    <hr>
    </div>
    <div class="m-2">
        <h6 style="font-size: 14px !important">Task Name:  <span class="float-end text-muted">{{ $task->name}}</span></h6>
        <h6 style="font-size: 14px !important">Assigned To: <span class="float-end text-muted">{{ $task->employee->fname }} {{ $task->employee->mname }} {{ $task->employee->lname }}</span></h6>
        <h6 style="font-size: 14px !important">Task Target: <span class="float-end text-muted">{{ $task->target}}</span></h6>
        <h6 style="font-size: 14px !important">Start Date: <span class="float-end text-muted">{{ $task->start_date}}</span></h6>
        <h6 style="font-size: 14px !important">End Date: <span class="float-end text-muted">{{ $task->end_date}}</span></h6>
    </div>

     
    <hr>
            <div id="save_termination" class="" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form
                            action="{{ route('flex.save_adhoctask_assessment') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">
                          
                                 
                                
                                    <input type="hidden" name="oldRate"  class="form-control"  id="oldRate">

                                    <input type="hidden" name="oldSalary"  class="form-control"  id="oldsalary">
                                    <div class="col-4 col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Task Achievemnt :</label>
                                            <input type="text" name="achievement" id="oldLevel"   value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Task Achievement">
                                            <input type="hidden" name="id" id="oldLevel"   value="{{ $task->id }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Task Achievement">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Behaviour Ratio <small class="text-main">(0-100)</small> :</label>
                                            <input type="text" name="behaviour" id="oldLevel"   value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Behaviour Ratio">
                                        </div>
                                    </div>
                                    <div class="col-4 col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Time Ratio <small class="text-main">(0-100)</small> :</label>
                                            <input type="text" name="time" id="oldLevel"   value="{{ old('emp_level') }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Time Ratio">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Remark :</label>
                                           <textarea name="" id="" class="form-control" rows="5" placeholder="Enter Task Remark"></textarea>
                                        </div>
                                    </div>



                            </div>


                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom  btn-block mb-2 mt-2">Save Assessment</button>
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


