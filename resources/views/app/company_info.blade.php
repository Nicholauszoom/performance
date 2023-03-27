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
foreach($data as $row2){
 $id = $row2->id;
}

@endphp



    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
        <div class="card-header border-0">
            <h5 class="text-main">Company Info<small></small></h5>
        </div>

        <div class="card-body">
            <div class="col-lg-12">

                <div class="border rounded-0 p-3 mb-3">
                    <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#payrollReportTab" class="nav-link active show" data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2 "></i>
                                List
                            </a>
                        </li>
                  
                        <li class="nav-item" role="presentation">
                            <a href="#overtimeTab" class="nav-link " data-bs-toggle="tab" aria-selected="false"
                                role="tab" tabindex="-1">
                                <i class="ph-list me-2"></i>
                                Add Info
                            </a>
                        </li>
       

                        {{-- start of payroll tab link --}}
                   
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div role="tabpanel" role="tabpanel" class="tab-pane active show " id="payrollReportTab"
                            aria-labelledby="home-tab">
             

                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <div class="card  rounded-0 border-0 shadow-none">
                                  


                                    {{-- table --}}
                                    <table id="datatable" class="table datatable-basic table-bordered">
                                        <thead>
                                            <tr>
                                                
                                                <th>Company Name</th>
                                                <th>Email</th>
                                                <th>TIN</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if(!empty($data))
                                            @foreach($data as $row)
                                             <tr>
                                                <td>{{$row->cname}}</td>
                                                <td>{{$row->email}}</td>
                                                <td>{{$row->tin}}</td>
                                                <td>-</td>
                                             </tr>
                                        @endforeach
                                        @endif
                                           
                                        </tbody>
                                    </table>
                                    {{-- /table --}}
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="overtimeTab">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="card  rounded-0 border-0 shadow-none">
                                    <div class="tab-head py-2 px-2">
                                        <h2 class="text-warning">Add Company Info</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="tab-body">
                                        <?php //echo $this->session->flashdata("note");
                                        ?>
                                        <div id="resultfeedOvertime"></div>
                                        <form action="{{route('flex.updatecompanyInfo',$id)}}" method="PUT">
                                    @csrf
                                            <input type="hidden" name="id" value="{{$id}}">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Company Name</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="cname" class="form-control"
                                                        placeholder="company name">
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Postal Address</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="postal_address" class="form-control"
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
                                                    <input type="text" name="postal_city" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Phone No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="phone_no1" class="form-control"
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
                                                    <input type="text" name="email" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">Plot No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="plot_no" class="form-control">
                                                 
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
                                                    <input type="text" name="block_no" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">street</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="street" class="form-control"
                                                        placeholder="JohnDoe">
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
                                                    <input type="text" name="branch" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">WCF REG NO</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="wcf_reg_no" class="form-control"
                                                        placeholder="JohnDoe">
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
                                                    <input type="text" name="heslb_code_no" class="form-control"
                                                       >
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                <label class="form-label">NSSF Contorol No</label>
                                                <div class="form-control-feedback form-control-feedback-start">
                                                    <input type="text" name="nssf_control_number" class="form-control"
                                                        placeholder="JohnDoe">
                                                    <div class="form-control-feedback-icon">
                                                        <i class="ph-user-circle text-muted"></i>
                                                    </div>
                                                </div>
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
