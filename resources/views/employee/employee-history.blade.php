<div role="tabpanel" class="tab-pane " id="page6" aria-labelledby="exit-tab">
    <div class="card rounded-0 border-0 shadow-none">

        <div class="card-header">
            <h5 class="text-main">EMPLOYMENT HISTORY: </h5>
        </div>
        <div class="row p-2">


            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                    <form action="{{ route('flex.saveEmployeeHistory') }}" method="post">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                  <div class="card-body">
                    <h5>Add Employment History</h5>
                    <hr>
                    <p class="text-muted"><b> Previous Employer(s) Details:</b></p>
                    <p>
                       <small><i>
                        Kindly declare your previous employers
                        (up to a period of 5 years to the date of joining BancABC)
                    </i></small>

                    </p>
                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <label for="">Name of Employer</label>
                            <input type="text" name="hist_employer" id="hist_employer"  placeholder="Enter Name of Employer" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="">Industry</label>
                            <input type="text" name="hist_industry" id="hist_industry"  placeholder="Enter Industry Auditing/Telecom Financial/Mining etc" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="">Position Held at the time of exit</label>
                            <input type="text" name="hist_position" id="hist_position"  placeholder="Enter Position Held at the time of exit" class="form-control" required>
                        </div>

                            <div class="col-md-3 mb-2">
                                <label for="">Start Year</label>
                                <input type="number"  name="hist_start" id="hist_start"   placeholder="Start Year" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">Finish Year</label>
                                <input type="number" name="hist_end"  id="hist_end"  placeholder="Finish Year" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="">Reason for Leaving</label>
                                <textarea name="hist_reason" id="" class="form-control" placeholder="Enter Reason for Leaving Here" rows="4"></textarea>
                            </div>

                            <div class="col-6">
                                <label for="hist_status">Employment Status</label>
                                <select name="hist_status" id="hist_status" class="select form-control">
                                    <option value="Permanent">Permanent</option>
                                    <option value="Fixed Term">Fixed Term</option>
                                    <option value="Internship">Internship</option>
                                </select>
                            </div>
                            <div class="card-footer mt-2">
                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                            </div>
                        </form>
                    </div>
                    <hr>

                    <table class="table table-border-none" id="dynamicAddRemove">
                        <tr>
                        <th class="text-center">From /To(Month & Year)</th>
                        <th class="text-center">Employer</th>
                        <th class="text-center">Industry Auditing/Telecom Financial/Mining etc </th>
                        <th class="text-center">Position Held at the time of exit</th>
                        <th class="text-center">Employment Status</th>
                        <th class="text-center">Reason for Leaving</th>
                        <th class="text-center">Action</th>
                        @forelse ( $histories as $item )
                      <tr>

                        <td class="text-center">{{ $item->hist_start}} - {{ $item->hist_end}} </td>
                        <td class="text-center">{{ $item->hist_employer }} </td>
                        <td class="text-center">{{ $item->hist_industry }} </td>
                        <td class="text-center">{{ $item->hist_position }}</td>
                        <td class="text-center">{{ $item->hist_status }}</td>
                        <td class="text-center">{{ $item->hist_reason }} </td>
                        <td class="text-center">
                            <a href="{{ url('flex/delete-history/'.$item->id) }}" class="btn btn-sm btn danger">
                                <i class="ph-trash"></i>
                            </a>
                        </td>
                      </tr>

                      @empty

                      @endforelse

                        </table>

                  </div>
                </div>
              </div>

        </div>
    </div>
 </div>
{{-- / --}}
