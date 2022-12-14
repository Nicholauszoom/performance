<div id="add_overtime" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Allowance Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                action="{{ route('flex.addOvertimeCategory') }}"
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Overtime Name: </label>
                            <input type="text" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                   
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Day Payment Per Hour(In Percent)</label>
                            <input type="number" placeholder="Payment Per Hour(Day)" name="day_percent"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3">Night Payment Per Hour(In Percent)</label>
                            <input type="number" name="night_percent" placeholder="Payment Per Hour(Night)"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <p class="text-danger mt-1"> Field Name has an error </p>
                            @enderror
                    </div>
                   
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Save Overtime</button>
                </div>
            </form>
        </div>
    </div>
</div>
