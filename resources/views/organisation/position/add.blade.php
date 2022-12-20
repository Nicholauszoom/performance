<div class="modal fade" role="dialog" id="addPermissionModal" aria-labelledby="addPermissionModal"
     data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-content">
            {{ Form::open(['route' => 'designations.store']) }}
            @method('POST')
            <div class="modal-header p-2 px-2">
                <h4 class="modal-title">Add Position</h6>
            </div>
            <div class="modal-body p-3">
                <div class="form-group">
                    <label class="">Position Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

               <div class="form-group">
                    <label class="">Organization Level</label>
                    <select name="department_id" class="form-control m-b"  required>
                   <option value="">Select Organizaion Level</option>
                     @if(!empty($department))
                     @foreach($department as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                     @endforeach
                     @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="">Position Code</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group">
                    <label class="">Minimum Qualification</label>
                    <textarea rows="3" cols="3" class="form-control" placeholder="Default textarea"></textarea>
                </div>

                <div class="form-group">
                    <label class="">Department</label>
                    <select name="department_id" class="form-control m-b"  required>
                   <option value="">Select Department</option>
                     @if(!empty($department))
                     @foreach($department as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                     @endforeach
                     @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="">Reports To</label>
                    <select name="department_id" class="form-control m-b"  required>
                   <option value="">Select Position</option>
                     @if(!empty($department))
                     @foreach($department as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                     @endforeach
                     @endif
                    </select>
                </div>

                <div class="form-group">
                    <label class="">Purpose of This Position</label>
                    <textarea rows="3" cols="3" class="form-control" ></textarea>
                </div>

            </div>
            <div class="modal-footer p-0">
                <div class="p-2">
                   <button class="btn btn-main"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
