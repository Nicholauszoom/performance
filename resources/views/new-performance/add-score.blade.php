<div class="modal-content" id="modal-content">
    {{ Form::open(['route' => 'flex.addScore']) }}
    @method('POST')
    <div class="modal-header p-2 px-2">
        <h4 class="modal-title">Add Info</h6>
    </div>
    <div class="modal-body p-3">
        <div class="form-group">
            <label class="">Key actions to enable delivery of goal</label>
            <textarea name="actions" id="" cols="30" rows="5" class="form-control" required></textarea>
            <input type="nunber" class="form-control" value="{{ $id }}" hidden name="id" required>
        </div>
        <div class="form-group">
            <label class="">Measures</label>
            <textarea name="measures" id="" cols="30" rows="5" class="form-control" required></textarea>
            {{-- <input type="text" class="form-control" name="name" required> --}}
        </div>
        <div class="form-group">
            <label class="">Results</label>
            <textarea name="results" id="" cols="30" rows="5" class="form-control" required></textarea>
            {{-- <input type="text" class="form-control" name="name" required> --}}
        </div>


        <div class="form-group">
            <label class="">Weighting(%)</label>
            <input type="number" class="form-control" name="weighting" step="0.1" required>
        </div>

        <div class="form-group">
            <label class="">Score</label>
            <input type="number" class="form-control" name="score" step="0.1" required>
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
