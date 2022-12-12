<div id="save_department" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Department Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                action="{{ route('departments.store') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Department Name</label>
                            <input type="text" name="name" placeholder="Department Name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="">Head os Department</label>
                        <select name="department_id" class="form-control m-b"  required>
                            @foreach($employee as $key => $row)
                                <option value="{{$row->empID}}">{{$row->NAME}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="">Reports To</label>
                        <select name="department_id" class="form-control m-b"  required>
                            <option value="">Select Department</option>
                            @foreach($departments as $key => $row)
                                <option value="{{$row->id}}"> {{$row->name}} </option>
                            @endforeach
                            
                        </select>
                    </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
