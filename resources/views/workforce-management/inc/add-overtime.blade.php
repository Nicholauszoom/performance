<div id="save_department" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Apply Overtime ⏲</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form
                {{-- action="{{ route('departments.store') }}" --}}
                method="POST"
                class="form-horizontal"
            >
                @csrf

                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Overtime Category :</label>
                        <div class="col-sm-9">

                            <select class="form-control select" name="nationality">
                                <option selected disabled> Select </option>
                                <option value="255">Tanzania</option>
                                <option value="254">Kenya</option>
                            </select>

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Time Start :</label>
                        <div class="col-sm-9">
                            <input type="datetime" name="" class="form-control" id="">

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Time End :</label>
                        <div class="col-sm-9">
                            <input type="datetime" name="" class="form-control" id="">

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-sm-3">Reason for overtime <span class="text-danger">*</span> :</label>
                        <div class="col-sm-9">

                            <textarea name="" id="" cols="30" rows="10"></textarea>

                            @error('name')
                                <p class="text-danger mt-1"> Input field Error </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-perfrom">Send Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
