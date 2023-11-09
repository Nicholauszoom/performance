<form autocomplete="off" action="{{ url('flex/attendance/saveLeaveOnBehalf') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label ">Employee Name: </label>
                            <select name="empID" id="empID" class="form-control select">
                                <option value=""> -- Choose Employee Here -- </option>
                                @foreach ($employees as $item)
                                    <option required value="{{ $item->emp_id }}" class="text-center"> {{ $item->fname }}
                                        {{ $item->mname }} {{ $item->lname }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="start-date">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start" id="start-date" class="form-control" required>
                        </div>

                        <input type="text" name="limit" hidden value="<?php echo $totalAccrued; ?>">
                        {{-- <input type="text" name="empId" id="empID" hidden value="{{ Auth::User()->emp_id }}"> --}}

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="end-date"> End Date <span class="text-danger">*</span></label>
                            <input type="date" required id="end-date" name="end" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nature">Nature of Leave <span
                                    class="text-danger">*</span></label>
                            <select class="form-control form-select select @error('emp_ID') is-invalid @enderror"
                                id="docNo" name="nature" required>
                                <option value="" class="text-center"> -- select Leave Type Here -- </option>
                                @foreach ($leave_type as $key)
                                    <option value="{{ $key->id }}" class="text-center"> {{ $key->type }} </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- @if ($days < 336) --}}
                        <div class="col-md-6 mb-3" id="sub" style="display:none">
                            <label class="control-label ">Sub Category <span class="text-danger">*</span></label>
                            <select name="sub_cat" class="form-control select custom-select" id="subs_cat">
                            </select>
                        </div>
                        {{-- @endif --}}

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="last-name">Leave Address <span
                                    class="text-danger">*</span></label>
                            <input required="required" type="text" id="address" name="address" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="middle-name" class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input required="required" class="form-control" type="tel" maxlength="10" name="mobile">
                        </div>

                        {{-- start of attachment --}}

                        <div class="col-md-6 mb-3" style="display:none" id="attachment">
                            <label for="leave-attachment" class="form-label">Attachment<span
                                    class="text-danger">*</span></label></label>
                            <input class="form-control" type="file" name="image" id="leave-attachment">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="control-label" for="reason">Reason For Leave <span
                                    class="text-danger">*</span></label>
                            <textarea maxlength="256" id="reason" class="form-control" name="reason" placeholder="Reason" required="required"
                                rows="3"></textarea>
                        </div>

                        @if ($deligate > 0)
                            <div class="col-md-6">
                                <label for="deligate" class="form-label">Deligate Position To <span
                                        class="text-danger">*</span></label>
                                <select name="deligate" @if ($deligate > 0) required @endif
                                    class="form-control" id="deligate">
                                    <option value="">Select Deligate</option>
                                    @foreach ($employees as $item)
                                        <option value="{{ $item->emp_id }}">{{ $item->fname }} {{ $item->mname }}
                                            {{ $item->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-3 mb-3">
                            <button class="float-end btn btn-main" type="button" data-bs-toggle="modal"
                                data-bs-target="#approval"> Submit </button>
                        </div>
                    </div>

                    <div id="approval" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close " data-bs-dismiss="modal"></button>
                                </div>

                                <modal-body class="p-4">
                                    <h6 class="text-center">Are you Sure ?</h6>
                                    <div class="row ">
                                        <div class="col-4 mx-auto">
                                            <button type="submit" class="btn bg-main btn-sm px-4 ">Yes</button>

                                            <button type="button" class="btn bg-danger btn-sm  px-4 text-light"
                                                data-bs-dismiss="modal">
                                                No
                                            </button>
                                        </div>


                                    </div>
                                </modal-body>

                                <modal-footer></modal-footer>
                            </div>
                        </div>
                    </div>
                </form>
