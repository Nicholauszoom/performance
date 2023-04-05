@extends('layouts.vertical', ['title' => 'Pending Payments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <!-- notification Js -->



    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush


@section('content')
@php
$id = '';

 $id = $data->id;


@endphp



    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <h5 class="text-main">Company Info<small></small></h5>
        </div>

        <div class="card-body">
            <div class="col-lg-12">

                <div class="border rounded-0 p-3 mb-3">


                    <div class="tab-content" id="myTabContent">
                        <div role="tabpanel" class="tab-pane active show" id="overtimeTab">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Update Company Info</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">
                                        <?php //echo $this->session->flashdata("note");
                                        ?>
                                        <div id="resultfeedOvertime"></div>
                                        <form action="{{route('flex.updatecompanyInfo')}}" method="POST">
                                    @csrf
                                            <input type="hidden" name="id" value="{{$id}}">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Company Name</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="cname" value="{{$data->cname}}" class="form-control"
                                                        placeholder="company name">
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Postal Address</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="postal_address" value="{{$data->postal_address}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Postal City</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="postal_city" value="{{$data->postal_city}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Phone No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="phone_no1" value="{{$data->phone_no1}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Email</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="email" value="{{$data->email}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Plot No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="plot_no" value="{{$data->plot_no}}" class="form-control">
                                                 
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Block No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="block_no" value="{{$data->block_no}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">street</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="street" value="{{$data->street}}" class="form-control"
                                                        >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Branch</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="branch" value="{{$data->branch}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">WCF REG NO</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="wcf_reg_no" value="{{$data->wcf_reg_no}}" class="form-control"
                                                        >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">HESLB CODE NO</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="heslb_code_no" value="{{$data->heslb_code_no}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">NSSF Contorol No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="nssf_control_number" value="{{$data->nssf_control_number}}" class="form-control"
                                                        >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">TIN</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="tin" value="{{$data->tin}}" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">NSSF Reg</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="nssf_reg" value="{{$data->nssf_reg}}" class="form-control"
                                                        >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-1 offset-11">

                                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save</button>
                                            </div>
                                        </div>
                                        
                                   
                                    </form>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->


            


        </div>


    </div>




@endsection

@push('footer-script')
    @include('app.includes.imprest_operations')

    @include('app.includes.overtime_operations')
    @include('app.includes.update_allowances')
    @include('app.includes.loan_operations')



  
@endpush
