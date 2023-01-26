@extends('layouts.vertical', ['title' => 'Departments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
    <div class="mb-3">
        <h3 class="text-main">Department Cost</h3>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-main">
                    Adding Department Cost
                </div>

                <div class="card-body">
                    <form id="departmentcost" method="post" autocomplete="off">
                        @csrf

                        {{-- type of cost --}}
                        <div class="mb-3">
                            <label for="type" class="form-label">Cost type</label>
                            <select name="type" id="type" class="form-control select">
                                <option value="1">Transfer</option>
                                <option value="2">Expenses</option>
                                <option value="3">Income</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="project" class="form-label">Project</label>
                            <select name="project" id="project" class="form-control select" required>
                                <option> Select Project </option>
                                @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="department-only" hidden>
                            <label for="department" class="form-label">Department</label>
                            <select name="department" id="department" class="form-control select">
                                <option> Select department </option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="department-from">
                            <label for="from_department" class="form-label">From Department</label>
                            <select name="from_department" id="from_department" class="form-control select">
                                <option> Select department </option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="department-to">
                            <label for="to_department" class="form-label">To Department</label>
                            <select name="to_department" id="to_department" class="form-control select">
                                <option> Select department </option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea required class="form-control" id="description" name="description" placeholder="Description" rows="3"></textarea>
                        </div>

                        <button class="btn btn-main" id="departcost">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $( "#type" ).change(function() {
                expenditure($(this).val());
            });
        });
    </script>

    <script type="text/javascript">
        $('#departmentcost').submit(function(e){
            e.preventDefault();

               $.ajax({
                    url:"{{ route('flex.storedepartmentcost') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    data:new FormData(this),
                    processData:false,
                    contentType:false,
                    cache:false,
                    async:false
                }).done(function(data){

                    new Noty({
                        text: 'Department cost added successfuly.',
                        type: 'success'
                    }).show();

                    setTimeout(function(){
                        location.reload();
                    }, 2000);

                }).fail(function(){

                    new Noty({
                        text: 'Request Failed!! ....',
                        type: 'error'
                    }).show();
                });
      });
    </script>

    <script>
        function expenditure(type) {
            if (type == 1) {
                $("#department-only").prop("hidden", true);
                $("#department-from").prop("hidden", false);
                $("#department-to").prop("hidden", false);

                $("#department").prop("disabled", true);
                $("#to_department").prop("disabled", false);
                $("#from_department").prop("disabled", false);

            } else {
                $("#department-only").prop("hidden", false);
                $("#department-from").prop("hidden", true);
                $("#department-to").prop("hidden", true);

                $("#department").prop("disabled", false);
                $("#to_department").prop("disabled", true);
                $("#from_department").prop("disabled", true);
            }
        }
    </script>
@endpush
