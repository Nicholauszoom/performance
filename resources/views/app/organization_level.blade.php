@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Organisation</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                {{-- <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Organisation Levels</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if (Session::has('note'))
                                {{ session('note') }}
                            @endif
                            <div id="feedBackTable"></div>
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Minimum Annual Salar</th>
                                        <th>Maximum Annual Salar</th>
                                        <?php if(session('mng_org')){ ?>
                                        <th>Option</th>
                                        <?php } ?>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                        $SNo = 1;
                          foreach ($level as $row) { ?>
                                    <tr id="domain {{ $row->id }}">
                                        <td width="1px">{{ $SNo }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->minSalary }}</td>
                                        <td>{{ $row->maxSalary }}</td>
                                        <?php if(session('mng_org')){ ?>
                                        <td class="options-width">
                                            <a
                                                href="<?php echo url(''); ?>/flex/organization_level_info/?id=".base64_encode($row->id);
                                                ?>" title="Info and Details" class="icon-2 info-tooltip"><button
                                                    type="button" class="btn btn-info btn-xs"><i
                                                        class="fa fa-info-circle"></i></button> </a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $SNo++; } //} 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}

                <div class="card">
                  {{-- <div class="card-header">
                    <h5 class="mb-0">Organization Levels</h5>
                </div> --}}
                   
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                          <h5>List of employees</h5>
          
                          <button
                    type="button"
                    class="btn btn-perfrom"
                    data-bs-toggle="modal"
                    data-bs-target="#save_department"
                >
                    <i class="ph-plus me-2"></i> Organization Level
                </button>
                      </div>
                  </div>
                    @if (Session::has('note'))
                        {{ session('note') }}
                    @endif
                    <table class="table datatable-basic table-striped">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Minimum Annual Salary</th>
                                <th>Maximum Annual Salary</th>
                                @php if(session('mng_org')) @endphp
                                <th>Option</th>
                                <?php ?>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $SNo = 1;
                            @endphp


                            @foreach ($level as $row)
                                <tr>
                                    <td>{{ $SNo++ }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ number_format($row->minSalary) }}</td>
                                    <td>{{ number_format($row->maxSalary) }}</td>
                                    <td><a href="{{ route('flex.organization_level_info', $row->id) }}" class=""></a>
                                        View
                                    </td>
                                    {{-- <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td> --}}
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <div class="dropdown">
                                                <a href="#" class="text-body" data-bs-toggle="dropdown">
                                                    <i class="ph-list"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="#" class="dropdown-item">
                                                        <i class="ph-file-pdf me-2"></i>
                                                        Export to .pdf
                                                    </a>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="ph-file-xls me-2"></i>
                                                        Export to .csv
                                                    </a>
                                                    <a href="#" class="dropdown-item">
                                                        <i class="ph-file-doc me-2"></i>
                                                        Export to .doc
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                <?php if(session('mng_org')){ ?>
                <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-tasks"></i> Add Organization Levels</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="orgAddFeedBack"></div>
                            <form autocomplete="off" id="organizationLevelAdd" enctype="multipart/form-data" method="post"
                                data-parsley-validate class="form-horizontal form-label-left">

                                <!-- START -->
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Organization
                                        Level Name</label>
                                    </label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <textarea required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Organization Level Name"
                                            rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Minimum Annual
                                        Basic Salary Range</label>
                                    </label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input required="" id="minSalary" type="number" min="100" max="10000000000"
                                            step="0.01" class="form-control col-md-7 col-xs-12" name="minSalary"
                                            placeholder="Minimum Salary" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Maximum Annual
                                        Basic Salary Range</label>
                                    </label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input required="" id="maxSalary" type="number" min="100" max="10000000000"
                                            step="0.01" class="form-control col-md-7 col-xs-12" name="maxSalary"
                                            placeholder="Maximum Salary" />
                                    </div>
                                </div>
                                <!-- END -->
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <input type="submit" value="ADD" name="add" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>




    <!-- /page content -->
@endsection
