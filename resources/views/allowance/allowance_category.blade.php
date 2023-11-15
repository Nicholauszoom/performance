@extends('layouts.vertical', ['title' => 'Allowance Category'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')

        <div class="card border-top  border-top-width-3 border-top-main rounded-0 ">
            @include('app.headers_payroll_input')

        <div class="row">
            <div class="col-md-7">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                    <div class="card-header">
                            <h5 class="h5 text-warning">Allowance Categories</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Allowance Category Name</th>

                                @if ($pendingPayroll == 0)
                                    <th>Option</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($allowanceCategory as $row) { ?>
                            <tr  id=" {{ 'domain'.  $row->id }}">
                                <td width="1px"><?php echo $row->SNo; ?></td>
                                <td><?php echo $row->name; ?></td>


                                <?php if($pendingPayroll == 0){ ?>
                                <td class="options-width">
                                    <a href="{{ route('flex.allowance_category_info', base64_encode($row->id)) }}"
                                        title="Info and Details" class="icon-2 info-tooltip">
                                        <button type="button" class="btn btn-main btn-xs"><i
                                                class="ph-info"></i></button>
                                    </a>

                                    <?php if($row->state ==1){ ?>
                                    <a href="javascript:void(0)" onclick="deleteAllowanceCategory(<?php echo $row->id; ?>)"
                                        title="Delete Allowance Category" class="icon-2 info-tooltip">
                                        <button type="button" class="btn btn-danger btn-xs"><i
                                                class="ph-trash"></i></button>
                                    </a>
                                    <?php } else{ ?>

                                    <a href="javascript:void(0)" onclick="activateAllowance(<?php echo $row->id; ?>)"
                                        title="Activate Allowance" class="icon-2 info-tooltip">
                                        <button type="button" class="btn btn-success btn-xs"><i
                                                class="ph-check"></i></button>
                                    </a><?php } ?>
                                </td><?php } ?>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>

            <div class="col-md-5">
                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">

                    <div class="card-body">
                        <h4 class="text-main">Add Allowance Category</h4>

                        <div id="resultSubmission"></div>
                        <form id="addAllowanceCategory" method="post" autocomplete="off" class="form-horizontal form-label-left">
                                <div class=" mb-3">
                                    <label class="form-label">Allowance Category Name:</label>
                                    <input type="text"  name="name" class="form-control" required>
                                </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-main">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
    </div>
    @include('app.includes.update_allowances')
@endsection

@push('footer-script')
    <script>
        jQuery(document).ready(function($) {

            $('#policy').change(function() {

                $("#policy option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        // $('#amount').show();
                        // $('#percent').hide();
                        $("#percentf").attr("disabled", "disabled");
                        $("#amountf").removeAttr("disabled");

                    } else if (value == "2") {
                        // $('#percent').show();
                        // $('#amount').hide();
                        $("#amountf").attr("disabled", "disabled");
                        $("#percentf").removeAttr("disabled");

                    }
                });
            });

        });
    </script>


    <script>
        jQuery(document).ready(function($) {

            $('#deduction_policy').change(function() {

                $("#deduction_policy option:selected").each(function() {
                    var value = $(this).val();
                    if (value == "1") {
                        $("#deduction_percentf").attr("disabled", "disabled");
                        $("#deduction_amountf").removeAttr("disabled");

                    } else if (value == "2") {
                        $("#deduction_amountf").attr("disabled", "disabled");
                        $("#deduction_percentf").removeAttr("disabled");

                    } else if (value == "3") {
                        $("#deduction_amountf").attr("disabled", "disabled");
                        $("#deduction_percentf").removeAttr("disabled");

                    }

                });
            });


        });
    </script>
    <script type="text/javascript">

    function deleteAllowanceCategory(id)
    {
        Swal.fire({
            title: 'Are You Sure You Want To Delete This Allowance?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = id;

                $.ajax({
                    url:"<?php echo url('flex/deleteAllowance');?>/"+id,
                    success:function(data)
                    {
                        var data  = JSON.parse(data);
                        if(data.status == 'OK'){
                            alert("Allowance Deactivated Successifully!");
                            $("#allowanceList").load(" #allowanceList");
                            // $('#record'+id).hide();
                        } else{
                            alert("Allowance Not Deactivated, Some Error Occured In Deleting");
                        }
                        $('#deleteFeedback').fadeOut('fast', function(){
                            $('#deleteFeedback').fadeIn('fast').html(data.message);
                        });
                    }
                });
            }
        });
    }

    </scrip>



    <script>
        $('#addAllowanceCategory').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addAllowanceCategory') }}',
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

                    new Noty({
                                    text: 'Alloance Category Added successfully!',
                                    type: 'success'
                                }).show();

                    // $('#addAllowance')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>

    <script>
        $('#addOvertime').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addOvertimeCategory') }}',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    // $('#resultOvertimeSubmission').fadeOut('fast', function() {
                    //     $('#resultOvertimeSubmission').fadeIn('fast').html(data);
                    // });

                    // $('#addOvertime')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>


    <script>
        $('#addDeduction').submit(function(e) {
            e.preventDefault();
            $.ajax({
                    url: '{{ url('/flex/addDeduction') }}',
                    type: "post",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false
                })
                .done(function(data) {
                    // $('#resultSubmissionDeduction').fadeOut('fast', function() {
                    //     $('#resultSubmissionDeduction').fadeIn('fast').html(data);
                    // });

                    // $('#addDeduction')[0].reset();
                    setTimeout(function() { // wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                })
                .fail(function() {
                    alert('FAILED, Check Your Network Connection and Try Again! ...');
                });
        });
    </script>
@endpush
