@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
    <?php
    ?>


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3> Organization Level Info</h3>
                </div>
            </div>
            <div class="clearfix"></div>


            <?php
            
            foreach ($category as $row) {
                $levelID = $row->id;
                $name = $row->name;
                $minSalary = $row->minSalary;
                $maxSalary = $row->maxSalary;
                //$state = $row->state;
            }
            
            ?>
            <!--START Overtimes-->
            {{-- <div class="row">
                <!-- Groups -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="feedBackAssignment"></div>
                            <h5> Name:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                            <h5>Minimum Annual Salary: &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $minSalary; ?> Tsh</b>
                                <h5>Maximum Annual Salary: &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $maxSalary; ?> Tsh</b>
                                </h5>
                                <br>
                        </div>
                    </div>
                </div> --}}
            <div class="row">
                <div class="card col-md-6">
                    <div class="card-header">
                        <h5 class="mb-0">Details</h5>
                    </div>

                    <div class="table-responsive">
                        <tbody>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <th>Minimum Salary</th>
                                    <td>{{ number_format($minSalary) }}</td>
                                </tr>
                                <tr>
                                    <th>Maximum Salary</th>
                                    <td>{{ number_format($maxSalary) }}</td>
                                </tr>

                            </table>
                        </tbody>
                    </div>
                </div>
                <!-- Groups -->

                <!--UPDATE-->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Update</h6>
                        </div>

                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            <form action="{{ route('flex.updateOrganizationLevelName') }}" method="POST"
                                class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-md-flex">
                                        <div class="col-sm-8">
                                            <input type="hidden" name='levelID' value="{{ $levelID }}"
                                                class="form-control">
                                            <input type="text" value="{{ $name }}" name="name"
                                                class="form-control">
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit" class="btn btn-perfrom multiselect-order-options-button"
                                                id="updateLevelName">Update Name</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateMinSalary') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-md-flex">
                                        <div class="col-sm-7">
                                            <input type="hidden" name='levelID' value="{{ $levelID }}"
                                                class="form-control">
                                            <input type="number" name="minSalary" value="{{ $minSalary }}"
                                                class="form-control">
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit"
                                                class="btn btn-perfrom multiselect-order-options-button">Update Min
                                                Salary</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('flex.updateMaxSalary') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <div class="d-md-flex">
                                        <div class="col-sm-7">
                                            <input type="hidden" name='levelID' value="{{ $levelID }}"
                                                class="form-control">
                                            <input type="number" name="maxSalary" value="{{ $maxSalary }}"
                                                class="form-control">
                                        </div>
                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="submit"
                                                class="btn btn-perfrom multiselect-order-options-button">Update Max
                                                Salary</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="feedBackSubmission"></div>
                            <form autocomplete="off" id="updateLevelName" class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                            <input required="" type="text" name="name" value="<?php echo $name; ?>"
                                                class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary">Update Name</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>


                            <form autocomplete="off" id="updateMinSalary" class="form-horizontal form-label-left">
                                {{-- <div class="row mb-3">
                                <div class="col-lg-9">
                                    <div class="d-md-flex">
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <label class="">Contract Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>

                                        <div class="btn-group flex-shrink-0 ms-md-3">
                                            <button type="button"
                                                class="btn btn-primary multiselect-order-options-button">Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div}}> 
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                            <input required="" type="number" step="0.01" name="minSalary"
                                                step="1" min="1" max="1000000000" value="<?php echo $minSalary; ?>"
                                                class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary">UPDATE MIN SALARY</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form autocomplete="off" id="updateMaxSalary" class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                            <input required="" type="number" step="1" name="maxSalary"
                                                step="1" min="1" max="1000000000" value="<?php echo $maxSalary; ?>"
                                                class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary">UPDATE MAX SALARY</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!--UPDATE-->
        </div>
        <!--end row Overtimes -->

        <!--END DEDUCTION-->
        <?php //}
        ?>


    </div>
    </div>


    <!-- /page content -->


    @include('app/includes/update_deductions')

    <script type="text/javascript">
        $('#updateLevelName').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/updateOrganizationLevelName",
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#feedBackSubmission').fadeOut('fast', function() {
                        $('#feedBackSubmission').fadeIn('fast').html(data);
                    });


                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 3000);
                })
                .fail(function() {
                    alert('Update Failed!! ...');
                });
        });
    </script>
    <script type="text/javascript">
        $('#updateMinSalary').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/updateMinSalary",
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#feedBackSubmission').fadeOut('fast', function() {
                        $('#feedBackSubmission').fadeIn('fast').html(data);
                    });


                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 3000);
                })
                .fail(function() {
                    alert('Update Failed!! ...');
                });
        });
    </script>
    <script type="text/javascript">
        $('#updateMaxSalary').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/updateMaxSalary",
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    $('#feedBackSubmission').fadeOut('fast', function() {
                        $('#feedBackSubmission').fadeIn('fast').html(data);
                    });


                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 3000);
                })
                .fail(function() {
                    alert('Update Failed!! ...');
                });
        });
    </script>
@endsection
