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
                    <h3>Contracts </h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                {{-- <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>List of Current Contract

                                &nbsp;&nbsp;&nbsp;<a><button type="button" id="insertContract" data-toggle="modal"
                                        class="btn btn-primary">Add New Contract</button></a></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="resultFeedback"></div>
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Duration(Years)</th>
                                        <th>Remind Me(Months)</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                        // if ($department->num_rows() > 0){
                          foreach ($contract as $row) { ?>
                                    <tr id="record<?php echo $row->id; ?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo $row->duration; ?></td>
                                        <td><?php echo $row->reminder; ?></td>

                                        <td class="options-width">
                                            <a href="<?php echo url(''); ?>/flex/updatecontract/?id=".$row->id; ?>"
                                                title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                                    class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button>
                                            </a>

                                            <a href="javascript:void(0)" onclick="deletecontract(<?php echo $row->id; ?>)"
                                                title="Delete" class="icon-2 info-tooltip"><button type="button"
                                                    class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php } //} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}

                <div class="card">

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>List of Current Contract</h5>

                            <button type="button" class="btn btn-perfrom" data-bs-toggle="modal"
                                data-bs-target="#add-contract">
                                <i class="ph-plus me-2"></i> Add New Contract
                            </button>
                        </div>
                    </div>
                    <table class="table datatable-basic table-striped">
                        <thead>
                            <tr>
                              <th>S/N</th>
                              <th>Name</th>
                              <th>Duration(Years)</th>
                              <th>Remind Me(Months)</th>
                              <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $SNo = 1;
                            @endphp


                            @foreach ($contract as $row)
                                <tr>
                                    <td>{{ $row->SNo }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->duration }}</td>
                                    <td>{{ $row->reminder }}</td>
                                    <td><a href="{{ route('flex.updatecontract', $row->id) }}" class="btn btn-info" title="Info and Details">Update</a>
                                        
                                    </td>
                                    <td >
                                      {{-- <a href="<?php echo url(''); ?>/flex/updatecontract/?id=".$row->id; ?>"
                                          title="Info and Details" class="icon-2 info-tooltip"><button type="button"
                                              class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button>
                                      </a> --}}

                                      <a onclick="sweet()" href=""
                                        class="btn btn-danger btn-sm">Delete</a>
                                        
                                      {{-- <a href="javascript:void(0)" onclick="deletecontract(<?php echo $row->id; ?>)"
                                          title="Delete" class="icon-2 info-tooltip"><button type="button"
                                              class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                                      </a> --}}

                                  </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- <div id="insertContract" class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Add New Contracte </h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="feedBack"></div>
                            <form autocomplete="off" id="addContract" enctype="multipart/form-data" method="post"
                                action="<?php echo url(''); ?>/flex/contractAdd" data-parsley-validate
                                class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Contract Name
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" required="" name="name"
                                            class="form-control col-md-7 col-xs-12">
                                        <span class="text-danger"><?php // echo form_error("fname");
                                        ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Duration
                                        (Years)
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="number" min="0.5" step="0.5" required="" max="100"
                                            name="duration" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Notify Me
                                        (Months before Contract Expiration)
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input required="" type="number" min="1" step="1" required=""
                                            max="36" name="alert" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="reset" class="btn btn-warning">Cancel</button>
                                    <button class="btn btn-primary">ADD</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>


    <!-- /page content -->






    <?php
    ?>
    <script>
        //For Deleting records without Page Refreshing

        function deletecontract(id) {
            if (confirm("Are You Sure You Want To Delete This Contract") == true) {
                var id = id;
                $('#hide' + id).show();
                $.ajax({
                    url: "<?php echo url('flex/deletecontract'); ?>/" + id,
                    success: function(data) {
                        // success :function(result){
                        // $('#alert').show();

                        if (data.status == 'OK') {
                            alert("Contract Deleted Sussessifully!");
                            $('#record' + id).hide();
                            $('#resultFeedback').fadeOut('fast', function() {
                                $('#resultFeedback').fadeIn('fast').html(data.message);
                            });
                        } else if (data.status != 'SUCCESS') {
                            alert("Not Deleted, Error In Deleting");
                        }


                    }

                });
            }
        }
    </script>



    <script type="text/javascript">
        $('#addContract').submit(function(e) {

            e.preventDefault(); // Prevent Default Submission

            $.ajax({
                    url: "<?php echo url(''); ?>/flex/addContract",
                    type: 'POST',
                    data: $(this).serialize(), // it will serialize the form data
                    dataType: 'json'
                })
                .done(function(data) {
                    alert(data.title);
                    if (data.status == 'OK') {
                        $('#feedBack').fadeOut('fast', function() {
                            $('#feedBack').fadeIn('fast').html(data.message);
                        });
                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload() // then reload the page.(3)
                        }, 2000);

                    } else {
                        // alert(data.title);
                        $('#feedBack').fadeOut('fast', function() {
                            $('#feedBack').fadeIn('fast').html(data.message);
                        });
                    }
                })
                .fail(function() {
                    alert('Contract Registration Failed, Review Your Network Connection...');
                });

        });


        $("#insertContract").click(function() {
            $('html,body').animate({
                    scrollTop: $("#insertContract").offset().top
                },
                'slow');
        });
    </script>
    @include('organisation.department.inc.add-contract')
@endsection
