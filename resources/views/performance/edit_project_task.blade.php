@extends('layouts.vertical', ['title' => 'Edit Project'])

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
            <h5 class="mb-0 text-warning">Edit Task</h5>

                <a href="{{ url('flex/view-project/'.$task->project_id) }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Tasks
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
                            action="{{ route('flex.save-task') }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf

                            <div class="modal-body">
                                <div class="row mb-3">



                                    <input type="hidden" name="id"  class="form-control" value="{{ $task->id }}"  id="oldRate">

                                    <input type="hidden" name="oldSalary"  class="form-control"  id="oldsalary">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Task Name:</label>
                                            <input type="text" name="name" required id="oldLevel"   value="{{ $task->name }}" class="form-control emp_level @error('emp_level') is-invalid @enderror" placeholder="Task Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Assigned To:</label>
                                            <select class="form-control select" name="assigned" id="linemanager">
                                                <option selected disabled> Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->emp_id }}">{{ $employee->fname }}
                                                        {{ $employee->mname }} {{ $employee->lname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6">

                                            <div class="mb-3">
                                                <label class="form-label">Start Date:</label>
                                            <input type="date" required name="start_date" value="{{ $task->start_date }}" class="form-control">
                                            </div>
                                    </div>






                                <div class="col-md-6 col-lg-6 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">End Date:</label>
                                    <input type="date"
                                     name="end_date" value="{{ $task->end_date }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Target:</label>
                                    <input type="text"
                                     name="target" class="form-control" value="{{ $task->target }}" placeholder="Enter Target">
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Target Type:</label>
                                        <select name="target_type" class="form-control">
                                            <option value="1">Money</option>
                                            <option value="2">Quality</option>
                                        </select>
                                    </div>
                                </div>


                                {{-- <div class="col-md-6 col-lg-6 mb-3">
                                    <label class="form-label ">New Salary</label>

                                        <input type="text" name="newSalary" class="form-control" id="" placeholder="Enter New Salary">

                                        @error('name')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div> --}}


                            </div>


                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom  btn-block mb-2 mt-2">Update Task</button>
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


