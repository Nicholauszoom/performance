@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')
    <!-- page content -->
    <div class="right_col " role="main">

        @include('app.headers_payroll_input')

        <?php

        foreach ($category as $row) {
            $categoryID = $row->id;
            $name = $row->name;
        }

        ?>


        <div class="row">
            <div
                class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0col-md-6">
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
                    </tbody>
                    </table>
                </div>
            </div>

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
                        <form action="{{ route('flex.updateAllowanceCategory') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="mb-3">
                                <div class="d-md-flex">
                                    <div class="col-sm-8">
                                        <input type="hidden" name='categoryID' value="{{ $categoryID }}"
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
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $('#updateAllowanceCategory').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: "<?php echo url(''); ?>/flex/updateAllowanceCategory",
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
