@extends('layouts.vertical', ['title' => 'Pending Payments'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush


@section('content')

    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <h5 class="text-main">Company Info<small></small></h5>
        </div>

        <div class="card-body">
            <div class="card border-0 shadow-none">
                <div class="tab-head py-2 px-2">
                    <h2 class="text-warning">Update Company Info</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="tab-body">
                    <div id="resultfeedOvertime"></div>

                    <form action="{{ route('flex.updatecompanyInfo') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ isset($data) && isset($data->id) ? $data->id : null }}" />

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Company Name</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="cname" @isset($data->cname) value = "{{ $data->cname }}" @endisset class="form-control" placeholder="company name">
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i> </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Postal Address</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="postal_address" @isset($data->postal_address) value = "{{ $data->postal_address }}" @endisset class="form-control" placeholder="postal address" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Postal City</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="postal_city" @isset($data->postal_city) value="{{ $data->postal_city }}" @endisset class="form-control" placeholder="postal city" />
                                    <div class="form-control-feedback-icon"> <i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Phone No</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="phone_no1" @isset($data->phone_no1) value="{{$data->phone_no1}}" @endisset class="form-control" placeholder="phone no" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Email</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="email" @isset($data->email) value=" {{ $data->email }} " @endisset  class="form-control" placeholder="email" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Plot No</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="plot_no" @isset($data->plot_no) value="{{ $data->plot_no }}" @endisset class="form-control" placeholder="plot no" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Block No</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="block_no" @isset($data->block_no) value="{{ $data->block_no }}" @endisset class="form-control" placeholder="block no" />
                                    <div class="form-control-feedback-icon"> <i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">street</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="street" @isset($data->street) value="{{ $data->street }}" @endisset class="form-control" placeholder="street">
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">Branch</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="branch" @isset($data->branch) value="{{ $data->branch }}" @endisset class="form-control" placeholder="branch">
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">WCF REG NO</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="wcf_reg_no" @isset($data->wcf_reg_no) value="{{ $data->wcf_reg_no }}" @endisset class="form-control" placeholder="WCF REG NO">
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">HESLB CODE NO</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="heslb_code_no" @isset($data->heslb_code_no) value="{{ $data->heslb_code_no }}" @endisset class="form-control" placeholder="HESLB CODE NO" />
                                    <div class="form-control-feedback-icon"> <i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">NSSF Contorol No</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="nssf_control_number" @isset($data->nssf_control_number) value="{{$data->nssf_control_number}}" @endisset class="form-control" placeholder="NSSF control no">
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">TIN</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="tin" @isset($data->tin) value="{{$data->tin}}" @endisset class="form-control" placeholder="TIN" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 mb-3">
                                <label class="form-label">NSSF Reg</label>
                                <div class="form-control-feedback form-control-feedback-start">
                                    <input type="text" name="nssf_reg" @isset($data->nssf_reg) value="{{$data->nssf_reg}}" @endisset class="form-control" placeholder="NSSF Reg" />
                                    <div class="form-control-feedback-icon"><i class="ph-user-circle text-muted"></i></div>
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




@endsection

@push('footer-script')
    @include('app.includes.imprest_operations')
    @include('app.includes.overtime_operations')
    @include('app.includes.update_allowances')
    @include('app.includes.loan_operations')
@endpush
