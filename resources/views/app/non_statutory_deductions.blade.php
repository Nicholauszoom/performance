@extends('layouts.vertical', ['title' => 'non-statutory'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

    <div class="right_col" role="main">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
            @include('app.headers_payroll_input')


            <div class="clearfix"></div>

            <div class="row">
                {{-- Non statutory deduction table --}}
                <div class="col-md-8">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                        <div class="card-header">
                            <h2>Deductions</h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>

                            <div class="clearfix"></div>
                        </div>

                        <div class="card-body">
                            <?php //echo $this->session->flashdata("notepack");  ?>
                            <table  class="table ">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        @if ($pendingPayroll == 0)

                                        <th>Option</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($deduction as $row) { //if($row->id==0) continue; // Skip the default group ?>
                                    <tr id="domain<?php echo $row->id;?>">
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td>
                                            <?php if($row->mode==1){ ?>
                                            <span class="label label-success">Fixed Amount</span><br>
                                            <?php echo $row->amount/$row->rate."".$row->currency; } else { ?>
                                            <span class="label label-success">Salary dependent</span><br>
                                            <?php echo 100*($row->percent)."%"; } ?>
                                        </td>
                                        @if ($pendingPayroll == 0)

                                        <td class="options-width">
                                            <?php  $par = $row->id."|2"; ?>
                                            <a  href="{{ route('flex.deduction_info',$par) }}" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-main btn-xs"><i class="ph-info"></i></button> </a>
                                            <a href="javascript:void(0)" onclick="deletededuction(<?php echo $row->id; ?>)" title="Delete Deduction" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button> </a>
                                        </td>
                                        @endif
                                    </tr>
                                    <?php } //} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- / Non statutory deduction table --}}

                {{-- Non statutory deduction Form --}}
                <div class="col-md-4 col-xs-12">
                    <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                        <div class="card-header">
                            <h2>Add Deduction</h2>
                        </div>

                        <div class="card-body">
                            <div id="resultSubmissionDeduction"></div>

                            <form id="addDeduction" method="post" autocomplete="off" class="form-horizontal form-label-left">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Deduction Name</label>
                                    <textarea required type="text" name="name" class="form-control"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="deduction_policy">Deduction Policy</label>
                                    <select name="policy" class="select_type form-control" required tabindex="-1" id="deduction_policy">
                                        <option>Select policy</option>
                                        <option value=1>Fixed Amount</option>
                                        <option value=2>Percent From Basic Salary</option>
                                        <option value=3>Percent From Gross</option>
                                    </select>
                                </div>

                                <div id="percent" class="mb-3">
                                    <label class="form-label" for="deduction_percentf">Percent</label>
                                    <input required id="deduction_percentf" type="number" name="rate" min="0" max="99" step="0.1" placeholder="Percent (Less Than 100)" class="form-control">
                                </div>

                                <div id="amount" class="mb-3">
                                    <label class="form-label" for="deduction_amountf">Amount</label>
                                    <input required id="deduction_amountf" type="number" step="any" placeholder="Fixed Amount" name="amount" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="currency">Currency </label>
                                    <select required name="currency" id="currency" class="select_group form-control select" data-width="1%">
                                        <option selected disabled>Select Currency</option>
                                        <?php foreach ($currencies as $row) { ?>
                                        <option value="<?php echo $row->currency; ?>"><?php echo $row->currency; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <button  class="btn btn-main">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- / Non statutory deduction form --}}
            </div>
        </div>
    </div>


@include("app/includes/update_allowances")
    <!-- /basic datatable -->
@endsection

@section('modal')
    @include('setting.deduction.add_deduction')
@endsection


@push('footer-script')
<script type="text/javascript">

    function deletededuction(id)
        {
            if (confirm("Are You Sure You Want To Delete This Deduction") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/delete_non_statutory_deduction');?>/"+id,
                success:function(data)
                {
                    var data  = JSON.parse(data);
                  if(data.status == 'OK'){
                  alert("Deduction Deleted Successifully!");
                  $("#allowanceList").load(" #allowanceList");
                  // $('#record'+id).hide();
                  } else{
                  alert("Allowance Not Deleted, Some Error Occured In Deleting");
                  }
            //    $('#deleteFeedback').fadeOut('fast', function(){
            //   $('#deleteFeedback').fadeIn('fast').html(data.message);
            // });

            setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);;


                }

                });
            }
        }
        function activateAllowance(id)
        {
            if (confirm("Are You Sure You Want To Activate This Allowance") == true) {
            var id = id;
            $.ajax({
                url:"<?php echo url('flex/activateAllowance');?>/"+id,
                success:function(data)
                {
                    var data  = JSON.parse(data);
                  if(data.status == 'OK'){
                  alert("Allowance Activated Successifully!");
                  $("#allowanceList").load(" #allowanceList");
                  // $('#record'+id).hide();
                  } else{
                  alert("Allowance Not Activated, Try Again");
                  }
               $('#deleteFeedback').fadeOut('fast', function(){
              $('#deleteFeedback').fadeIn('fast').html(data.message);
            });


                }

                });
            }
        }
    </script>
<script>

    jQuery(document).ready(function($){

        $('#policy').change(function () {

        $("#policy option:selected").each(function () {
            var value = $(this).val();
            if(value == "1") {
                // $('#amount').show();
                // $('#percent').hide();
                $("#percentf").attr("disabled", "disabled");
                $("#amountf").removeAttr("disabled");

            } else if(value == "2") {
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

    jQuery(document).ready(function($){

        $('#deduction_policy').change(function () {

        $("#deduction_policy option:selected").each(function () {
            var value = $(this).val();
            if(value == "1") {
                $("#deduction_percentf").attr("disabled", "disabled");
                $("#deduction_amountf").removeAttr("disabled");

            } else if(value == "2") {
                $("#deduction_amountf").attr("disabled", "disabled");
                $("#deduction_percentf").removeAttr("disabled");

            }else if(value == "3") {
                $("#deduction_amountf").attr("disabled", "disabled");
                $("#deduction_percentf").removeAttr("disabled");

            }

        });
      });


    });
    </script>
    <script>
        $('#addAllowance').submit(function(e){
            e.preventDefault();
                 $.ajax({
                     url:"{{ route('flex.addAllowance') }}",
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     type:"post",
                     data:new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false
                 })
            .done(function(data){
            //  $('#resultSubmission').fadeOut('fast', function(){
            //       $('#resultSubmission').fadeIn('fast').html(data);
            //     });

          //$('#addAllowance')[0].reset();
          setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);
            })
            .fail(function(){
         alert('FAILED, Check Your Network Connection and Try Again! ...');
            });
        });
    </script>

    <script>
        $('#addOvertime').submit(function(e){
            e.preventDefault();
                 $.ajax({
                     url:"{{ route('flex.addOvertimeCategory') }}",
                     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                     type:"post",
                     data:new FormData(this),
                     processData:false,
                     contentType:false,
                     cache:false,
                     async:false
                 })
            .done(function(data){
              $('#resultOvertimeSubmission').fadeOut('fast', function(){
                  $('#resultOvertimeSubmission').fadeIn('fast').html(data);
                });

              $('#addOvertime')[0].reset();
            })
            .fail(function(){
         alert('FAILED, Check Your Network Connection and Try Again! ...');
            });
        });
    </script>

    {{-- Submiting non statutory deduction --}}
    <script>
        $('#addDeduction').submit(function(e){
            e.preventDefault();

            $.ajax({
                url:"{{ route('flex.addDeduction') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"post",
                data:new FormData(this),
                processData:false,
                contentType:false,
                cache:false,
                async:false
            })
            .done(function(data){
                //  $('#resultSubmissionDeduction').fadeOut('fast', function(){
                //       $('#resultSubmissionDeduction').fadeIn('fast').html(data);
                //     });

                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            })
            .fail(function(){
                alert('FAILED, Check Your Network Connection and Try Again! ...');
            });
        });
    </script>
@endpush
