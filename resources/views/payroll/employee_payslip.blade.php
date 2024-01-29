@extends('layouts.vertical', ['title' => 'Payslip'])

@push('head-script')
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    @php
        $payrollList =    $data['payrollList'];
        $month_list =  $data['month_list'];
        $employee =  $data['employee'];
    @endphp


    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 border-0 shadow-none">
        <div class="card-header">
            <h4 class="text-warning">Employee Payslip</h4>
        </div>

        @can('view-employee-payslip')
        <div class="card-body">
            <form id="demo-form2" enctype="multipart/form-data" method="post" action="{{ url('/flex/reports/payslip') }}" target="_blank" data-parsley-validate>
                @csrf

                <div class="row">

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Employee Type :</label>
                            <select id="employee_exited_list" onchange="filterType()" class="form-control select" tabindex="-1">
                                <option value="1">Active</option>
                                <option value="2">Exited</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Employee Name:</label>
                            <select required="" name="employee" id="employee_list" class="select4_single form-control select" tabindex="-1">
                                <option> Select Employee </option>
                                @foreach ( $employee as $row)
                                <option value="{{ $row->empID }}">{{ $row->empID }} - {{ $row->NAME }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Payroll Month:</label>
                            <select required="" name="payrolldate" class="select_payroll_month form-control select" tabindex="-1">
                                <option> Select Month</option>
                                @foreach ($month_list as $row)
                                <option value="{{ $row->payroll_date }}">{{ date('F, Y', strtotime($row->payroll_date)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">
                            <button class="btn btn-main px-3 mt-4" type="submit">
                                <i class="ph-printer me-2"></i> Print
                            </button>

                        </div>
                    </div>
                </div>
                {{-- /row --}}

                <hr class="my-2">

                <div class="row">
                    <div class="col-3">
                        <div class="mb-3">
                            <label class="form-label">Payslip Type</label>
                            <div>
                                <label class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="type" value="1" checked>
                                    <span class="form-check-label">Employee</span>
                                </label>

                                {{-- <label class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="2" name="type">
                                    <span class="form-check-label">temporary</span>
                                </label> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <hr>
        @endcan
    </div>

    <div class="card">
        {{-- start of payslip mail delivery --}}
        <div class="card-header">
            <h4 class="text-warning">Payroll List</h4>
        </div>

        <table id="datatable" class="table datatable-basic table-bordered">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Payroll Month</th>
                <th>Status</th>
                {{-- <th>Mail Status</th> --}}
                <th>Option</th>
                <th hidden ></th>
            </tr>
            </thead>

            <tbody>
                <?php
                $i=1;

                    foreach ($payrollList as $row) { ?>

                    <tr id="domain<?php echo $row->id;?>">
                        <td width="1px">{{ $i }}</td>
                        <td><?php //echo $row->payroll_date; ?><?php echo date('F, Y', strtotime($row->payroll_date));; ?></td>
                        <td>
                            <?php if($row->state==1 || $row->state==2 ){   ?>

                                <span class="badge bg-pending">PENDING</span><br>

                            <?php if(!$row->pay_checklist==1){ ?>
                                <!-- <script>   setTimeout(function(){
                                        var url = "<?php echo url('flex/payroll/temp_payroll_info/?pdate='.base64_encode($payrollList[0]->payroll_date))?>"
                                        window.location.href = url;
                                    }, 1000)
                                </script> -->
                            <?php  }?>

                            <?php } else { ?>
                                <span class="badge bg-success">APPROVED</span><br>
                            <?php  } ?>
                        </td>
                        {{-- <td>
                            <?php if($row->email_status==0){ ?>
                                <span class="badge bg-pending">NOT SENT</span><br>
                            <?php } else { ?>
                                <span class="badge bg-success">SENT</span><br>
                            <?php  } ?>
                        </td> --}}

                        <td class="options-width">
                            <div class="d-inline-flex">


                            <?php if($row->state==1 || $row->state==2){ ?>

                                {{--  cancel payroll button --}}
                                @can('cancel-payroll')
                                <a href="javascript:void(0)" onclick="cancelPayroll()"  title="Cancel Payroll" class="me-2">
                                    <button class="btn bg-danger text-white btn-xs"> <i class="ph-x"></i></button>
                                </a>
                                @endcan
                                {{-- / --}}

                                {{-- view payroll details button  --}}
                                @can('view-payroll')
                                <a href="<?php echo url('flex/payroll/temp_payroll_info/?pdate='.base64_encode($row->payroll_date));?>" title="Info and Details" class="me-2">
                                    <button class="btn bg-secondary text-white btn-xs"> <i class="ph-info"></i></button>
                                </a>
                                @endcan

                                <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Send Pay Slip as Email" class="me-2">
                                    <button class="btn bg-main text-white btn-xs"> <i class="ph-envelope"></i></button>
                                </a>
                                
                                {{-- / --}}
                            <?php } else {  ?>

                                {{-- view payroll details button --}}
                                <a href="<?php echo url('flex/payroll/payroll_info/?pdate='.base64_encode($row->payroll_date));?>" title="Info and Details" class="me-2">
                                    <button class="btn bg-main text-white btn-xs"> <i class="ph-info"></i></button>
                                </a>
                                {{-- / --}}
                                <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Send Pay Slip as Email" class="me-2">
                                    <button class="btn bg-main text-white btn-xs"> <i class="ph-envelope"></i></button>
                                </a>


                                <?php if($row->state==0){ ?>
                                    <?php if($row->pay_checklist==1){ ?>
                                        {{-- print report button --}}
                                        <a href ="<?php echo  url(''); ?>/flex/reports/payroll_report/?pdate=<?php echo base64_encode($row->payroll_date); ?>" target = "blank" title="Print Report" class="me-2">
                                            <button class="btn bg-pending text-white btn-xs"> <i class="ph-printer"></i></button>
                                        </a>
                                        {{-- / --}}
                                    <?php } else {  ?>
                                        {{-- report not ready status --}}
                                        <a title="Checklist Report Not Ready" class="me-2">
                                            <button class="btn bg-warning text-white btn-xs"> <i class="ph-file"></i></button>
                                        </a>
                                        {{-- / --}}
                                    <?php } ?>

                                    <?php if($row->email_status==0){ ?>

                                        {{-- send payslip mail button --}}
                                        {{-- @can('mail-payroll') --}}
                                        <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Send Pay Slip as Email" class="me-2">
                                            <button class="btn bg-main text-white btn-xs"> <i class="ph-envelope"></i></button>
                                        </a>
                                        {{-- @endcan --}}
                                        {{-- / --}}
                                        <?php } else { ?>
                                        {{-- re-send payslip email button --}}
                                        <a href="javascript:void(0)" onclick="sendEmail('<?php echo $row->payroll_date; ?>')" title="Resend Pay Slip as Email" class="me-2">
                                        <button class="btn bg-warning text-white btn-xs"> <i class="ph-repeat"></i>&nbsp;&nbsp;<i class="ph-envelope"></i> </button>
                                        </a>
                                        {{-- / --}}


                                    <?php }
                                ?>
                            <?php } ?>
                            <?php } ?>
                        </div>

                        </td>
                        <td hidden></td>
                    </tr>
                <?php $i++; }  ?>
                </tbody>
            </table>

        </div>
    </div>






@endsection

 @push('footer-script')
 <script>
    function sendEmail(payrollDate) {

      if (confirm("Are You Sure You Want To want to Send The Payslips Emails to the Employees For the selected Payroll Month??") == true) {

        $.ajax({
          url:"<?php echo url('flex/payroll/send_payslips');?>/"+payrollDate,
          success:function(data)
          {
            let jq_json_obj = $.parseJSON(data);
            let jq_obj = eval (jq_json_obj);
            if (jq_obj.status === 'SENT'){
              $('#feedBackMail').fadeOut('fast', function(){
                  $('#feedBackMail').fadeIn('fast').html("<p class='alert alert-success text-center'>Emails Have been sent Successifully</p>");
              });
              setTimeout(function(){// wait for 2 secs(2)
              location.reload(); // then reload the div to clear the success notification
              }, 1500);
            }else{
              $('#feedBackMail').fadeOut('fast', function(){
                  $('#feedBackMail').fadeIn('fast').html("<p class='alert alert-danger text-center'>Emails sent error</p>");
              });
              setTimeout(function(){// wait for 2 secs(2)
                  location.reload(); // then reload the div to clear the success notification
              }, 1500);
            }

          }

        });

      }

    }

    $('#print_all').on('click',function () {
        $('#employee_list').prop('required',false);
    });

    $('#print').on('click',function () {
        $('#employee_list').prop('required',true);
    });

    function filterType(){
      let type = $('#employee_exited_list').val(); //1 active, 2 inactive

      $.ajax({
          url:"<?php echo url('flex/payroll/employeeFilter');?>/"+type,
          success:function(data)
          {
            let jq_json_obj = $.parseJSON(data);
            let jq_obj = eval (jq_json_obj);


            //populate employee
            $("#employee_list option").remove();
            $('#employee_list').append($("<option value='' selected disabled>Select Employee</option>"));
            $.each(jq_obj, function (detail, name) {
                $('#employee_list').append($('<option>', {value: name.empID, text: name.NAME}));
            });


          }

        });



    }

    </script>
 @endpush
