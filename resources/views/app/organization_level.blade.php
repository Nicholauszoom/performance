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
                    <div class="card">
                        <div class="card-head">
                            <h2>Organisation Levels</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
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
                                                href="<?php echo url(''); ?>/flex/organization_level_info/".base64_encode($row->id);
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

                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>Organisation Levels</h5>

                            <button type="button" class="btn btn-perfrom" data-bs-toggle="modal"
                                data-bs-target="#add-organizational">
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
                                <th></th>
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
                                    <td align="center">

                                        <a href="{{ route('flex.organization_level_info', [$row->id]) }}"
                                            class="btn btn-main btn-sm" title="Edit {{ $row->name }}">
                                            <i class="ph-note-pencil"></i></a>

                                        <button type="button" onclick="deleteOrganizationLevel({{ $row->id }})"
                                            class="btn btn-danger btn-sm" data-toggle="modal"
                                            title="Delete {{ $row->name }}">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </td>
                                    {{-- <td><a href="{{ route('flex.organization_level_info',base64_encode($row->id))}}" class="btn btn-perfrom">View</a>
                                    </td>  --}}
                                    {{-- href="{{route('temp_payroll_info',['pdate'=>base64_encode($row->payroll_date)])}}" --}}
                                    {{-- <td><a href="/flex/organization_level_info/.base64_encode($row->id)" class="btn btn-perfrom">View</a>
                                    </td> --}}
                                    {{-- <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td> --}}
                                    <td class="text-center">

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



                {{-- <?php if(session('mng_org')){ ?>
                <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-head">
                            <h2><i class="fa fa-tasks"></i> Add Organization Level</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
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
                                        <input type="submit" value="ADD" name="add" class="btn btn-main" />
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php } ?> --}}
            </div>
        </div>
    </div>
    <!-- /page content -->
    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="message"></div>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-4"></div>

                    <div class="col-sm-6">
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">No</button>
                        <button type="button" id="yes_delete" class="btn btn-main btn-sm">Yes</button>
                    </div>

                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-script')
    <script>
        function deleteOrganizationLevel(id) {
            const message = "Are you sure you want to DELETE this level?";
            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            var id = id;
            $("#yes_delete").click(function() {
                $('#hide' + id).show();

                $.ajax({
                    url: "<?php echo url('flex/deleteOrganizationLevel'); ?>/" + id,
                    success: function(data) {
                        // success :function(result){
                        // $('#alert').show();
                        var data = JSON.parse(data);
                        if (data.status == 'OK') {
                            // alert("Record Deleted Sussessifully!");
                            $('#domain' + id).hide();
                            $('#delete').modal('hide');

                            // notify('Department deleted successfuly!', 'top', 'right', 'success');

                            new Noty({
                                text: 'Organization Level is Deleted.',
                                type: 'success'
                            }).show();

                            // $('#feedBackTable').fadeOut('fast', function(){
                            // $('#feedBackTable').fadeIn('fast').html(data.message);
                            // });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);

                        } else if (data.status != 'SUCCESS') {
                            $('#delete').modal('hide');

                            new Noty({
                                text: 'Organization Level not deleted.',
                                type: 'warning'
                            }).show();

                            //   notify('Department not deleted!', 'top', 'right', 'danger');
                            // alert("Property Not Deleted, Error In Deleting");
                        }
                    }

                });
            });
            // if (confirm("Are You Sure You Want To Delete This Department") == true) {
            //
            // }
        }
    </script>
@endpush
@include('organisation.department.inc.add-level')
