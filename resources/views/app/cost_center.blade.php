@extends('layouts.vertical', ['title' => 'Contracts'])

@push('head-script')
    {{-- <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script> --}}
@endpush

@push('head-scriptTwo')
    {{-- <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script> --}}
@endpush

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">

            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                   
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                        <div class="card-head py-3 px-3">
                            <h2>Cost Center

                            </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            @can('view-department-cost')


                            <table id="datatable" class="table table-striped table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>

                                        <th>Option</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                  foreach ($cost_center as $row) { ?>
                                    <tr id="domain<?php echo $row->id; ?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->name; ?></td>


                                        <?php ?>
                                        <td class="options-width">
                                            <button type="button" class="btn btn-main" data-bs-toggle="modal"
                                                data-bs-target="#updateModal<?php echo $row->id; ?>">
                                                <i class="ph-pen me-2"></i>
                                            </button>



                                            <a href="javascript:void(0)" onclick="closeBranch(<?php echo $row->id; ?>)"
                                                title="Delete Deduction" class="icon-2 info-tooltip"><button type="button"
                                                    class="btn btn-danger btn-xs"><i class="ph-x"></i></button> </a>


                                            <!--update Modal -->
                                            <div id="updateModal<?php echo $row->id; ?>" class="modal fade" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">UPDATE</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <form id="demo-form2" enctype="multipart/form-data" method="post"
                                                            action="{{ route('flex.updateCostCenter') }}"
                                                            data-parsley-validate class="form-horizontal form-label-left">
                                                            @csrf

                                                            <input type="text" name="costCenterID" hidden=""
                                                                value="<?php echo $row->id; ?>">
                                                                <div class="modal-body p-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name</label>
                                                                        <input type="text" class="form-control" name="name" value="<?php echo $row->name; ?>" >
                                                                    </div>
                                                                </div>






                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <input type="submit" value="UPDATE" name="update"
                                                                    class="btn btn-main" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /.modal -->
                                            <!-- Update Modal-->
                                            <!--ACTIONS-->
                                        </td>
                                        <?php //}
                                        ?>
                                    </tr>
                                    <?php } //} ?>
                                </tbody>
                            </table>
                            @endcan
                        </div>
                    </div>
                </div>


                <?php ?>
                <div id="bottom" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0">
                        <div class="card-head py-3 px-3">
                            <h2><i class="fa fa-tasks"></i> Add Cost Center</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="card-body">
                            <div id="feedBack"></div>
                           @can('add-department-cost')
                            <form autocomplete="off" id="addCostCenter" enctype="multipart/form-data" method="post"
                                data-parsley-validate class="form-horizontal form-label-left">
                                <div class="row">
                                    <!-- START -->
                                    <div class="form-group col-6 mb-3">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                            for="last-name">Name</label>
                                        </label>
                                        <input type="text" class="form-control col-md-7 col-xs-12" required
                                            name="name" placeholder="Name">
                                    </div>


                                    <div class="col-8"></div>
                                    <div class="col-4 ">
                                        <button class="btn btn-main btn-block float-end" width="100%">Save
                                            Center</button>
                                    </div>
                                </div>
                                <!-- END -->

                        </div>
                        </form>
@endcan
                    </div>
                </div>
                <?php //}
                ?>

            </div>

        </div>
    </div>
    </div>
@endsection


@push('footer-script')
    <script type="text/javascript">
        $('#addCostCenter').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "{{ route('flex.addCostCenter') }}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#feedBack').fadeOut('fast', function() {
                        $('#feedBack').fadeIn('fast').html(data);
                    });
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);
                    //   $('#updateMiddleName')[0].reset();
                })
                .fail(function() {
                    alert('Request Failed!! ...');
                });
        });
    </script>
@endpush
