<div role="tabpanel" class="tab-pane " id="page5" aria-labelledby="exit-tab">
    <div class="card rounded-0 border-0 shadow-none">

        <div class="card-header">
            <h5 class="text-main">EDUCATIONAL BACKGROUND: </h5>
        </div>
        <div class="row p-2">
            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                    <form action="{{ route('flex.saveEducationDetails') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                  <div class="card-body">
                    <h5>Add Academic Qualification</h5>
                    <hr>
                    <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="">Name of University</label>
                                <input type="text" name="institute" id="institute"  placeholder="Enter University Name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="">Qualification Obtained </label>
                                <select name="level" id="level" class="select custom-select form-control">
                                    <option value="Certificate">Certificate </option>
                                    <option value="Diploma">Diploma </option>
                                    <option value="Degree">Degree </option>
                                    <option value="Masters">Masters </option>
                                    <option value="PhD">PhD </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="">Discpline of Study </label>
                                <input type="text" name="course" id="course"  placeholder="Enter Discpline of Study e.g Accounting/Marketing Law/Business etc" class="form-control" >
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="">Start Year</label>
                                <input type="number" name="start_year" min="1900" max="2099" id="start_year"  placeholder="Start Year" class="form-control" >
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">Finish Year</label>
                                <input type="number" name="finish_year" min="1900" max="2099" id="finish_year"  placeholder="Finish Year" class="form-control" >
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="">Location of Study</label>
                                <input type="text" name="study_location"  id="study_location"  placeholder="Location of Study" class="form-control" >
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="">Final Score & Grades</label>
                                <input type="text" name="final_score"  id="final_score"  placeholder="Final Score & Grades" class="form-control" required >
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="">Education Certificate</label>
                                <input type="file" name="certificate"  id="final_score"  placeholder="Final Score & Grades" class="form-control" >
                            </div>
                            <div class="card-footer ">
                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                            </div>
                        </form>
                    </div>
                    <hr>

                    <table class="table table-border-none" id="dynamicAddRemove">
                        <tr>
                        <th class="text-center">From /To(Month & Year)</th>
                        <th class="text-center">University/College/School (From highest level of education)</th>
                        <th class="text-center">Qualification Obtained </th>
                        <th class="text-center">Disciplinary of Study </th>
                        <th class="text-center">Location </th>
                        <th class="text-center">Final Score & Grades</th>
                        <th class="text-center">Action</th>
                        @forelse ( $qualifications as $item )
                      <tr>

                        <td class="text-center">{{ $item->start_year}} - {{ $item->end_year}} </td>
                        <td class="text-center">{{ $item->institute }} </td>
                        <td class="text-center">{{ $item->level }}</td>
                        <td class="text-center">{{ $item->course }}</td>
                        <td class="text-center">{{ $item->study_location }} </td>
                        <td class="text-center">{{ $item->final_score }} </td>
                        <td class="text-center">
                        <a href="{{asset('storage/certificates/' . $item->certificate) }}" download="{{$item->institute.'-Certificate'}}" class="text-main btn btn-sm" title="Download Attachment">
                                <i class="ph ph-download"></i> &nbsp;
                        </a>
                        <a href="{{ url('flex/delete-qualification/'.$item->id) }}" class="btn btn-sm btn text-danger">
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
            <div class="col-md-12">
                <div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 p-2">
                    <form action="{{ route('flex.saveProfessionalCertifications') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employeeID"  value="<?php echo $empID; ?>" id="">
                      <div class="card-body">
                    <h5>Add Professional Certifications/License</h5>
                    <hr>
                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <label for="">Name of Certification/License</label>
                            <input type="text" name="cert_name" id="institute"  placeholder="Enter Name of Certification/License" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Qualification Obtained </label>
                            <input type="text" name="cert_qualification" id="cert_qualification"  placeholder="Enter Qualification Obtained " class="form-control" >

                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Membership Number</label>
                            <input type="text" name="cert_number" id="cert_number" placeholder="Enter Membership Number" class="form-control" >
                        </div>

                            <div class="col-md-3 mb-2">
                                <label for="">Start Year</label>
                                <input type="number" name="cert_start" id="cert_start" min="1900" max="2099"  placeholder="Start Year" class="form-control" >
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="">Finish Year</label>
                                <input type="number" name="cert_end"  id="cert_end" min="1900" max="2099" placeholder="Finish Year" class="form-control" >
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="">Upload Certification</label>
                                <input type="file" name="certificate2"  id="final_score"  placeholder="Final Score & Grades" class="form-control" >
                            </div>
                            <div class="col-4 mb-2">
                                <label for="">Status </label><br>
                                <input type="radio" id="active" name="cert_status" value="Active"> <label for="active">Active</label>
                                <input type="radio" id="inactive" name="cert_status" value="Active"> <label for="inactive">Inactive</label>
                            </div>


                            <div class="card-footer ">
                                <button type="submit" class="btn btn-main float-end"> Save Details</button>
                            </div>
                        </form>
                    </div>
                    <hr>


                      <table class="table table-border-none" id="dynamicAddRemoveParent">
                      <tr>
                      <th class="text-center">From/To (Month & Year)</th>
                      <th class="text-center">Name of Professional Certification/License If any</th>
                      <th class="text-center">Qualification Obtained </th>
                      <th class="text-center">Membership Number</th>
                      <th class="text-center">Status Active/ Inactive</th>
                      <th class="text-center">Action</th>
                      </tr>
                      @forelse ( $certifications as $item )
                      <tr>

                        <td class="text-center" >{{ $item->cert_start}} - {{ $item->cert_end }}</td>
                        <td class="text-center" >{{ $item->cert_name }} </td>
                        <td class="text-center">{{ $item->cert_qualification }}</td>
                        <td class="text-center">{{ $item->cert_number }}</td>
                        <td class="text-center">{{ $item->cert_status }} </td>
                        <td>
                            <a href="{{asset('storage/certifications/' . $item->certificate) }}" download="{{ $item->cert_name.'-certificate' }}" class="text-main btn btn-sm" title="Download Attachment">
                                <i class="ph ph-download"></i> &nbsp;

                              </a>
                             <a href="{{ url('flex/delete-certification/'.$item->id) }}" class="btn btn-sm btn text-danger">
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
