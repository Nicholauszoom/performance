@extends('layouts.vertical', ['title' => 'Overtime'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
  <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
  <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')
<div id="apply_overtime">
  <div class="row">
    <div class="col-md-6 offest-4">
      <div class="card">
        <div class="card-header border-0 shadow-none">
          <h5 class="text-muted">Apply Overtime</h5>
        </div>

        <div class="card-body">
        <div id="resultfeedSubmission" class="mb-3"></div>

          <form
            id="applyOvertime"
            enctype="multipart/form-data"
            method="post"
            data-parsley-validate
            autocomplete="off"
          >
          @csrf

          <div class="modal-body">
              <div class="row mb-3">
                  <label class="col-form-label col-sm-3">Overtime Category <span class="text-danger">*</span> :</label>
                  <div class="col-sm-9">

                      <select class="form-control select_category select" name="category" required>
                          <option selected disabled> Select </option>
                          @foreach ($overtimeCategory as $overtimeCategorie)
                          <option value="{{ $overtimeCategorie->id }}"> {{ $overtimeCategorie->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="row mb-3">
                  <label class="col-form-label col-sm-3">Time Start <span class="text-danger">*</span> :</label>
                  <div class="col-sm-9">
                      <div class="input-group">
                          <span class="input-group-text"><i class="ph-calendar"></i></span>
                          <input type="text" required placeholder="Start Time" name="time_start" id="time_start" class="form-control daterange-single" >
                      </div>
                  </div>
              </div>

              <div class="row mb-3">
                  <label class="col-form-label col-sm-3">Time End <span class="text-danger">*</span> :</label>
                  <div class="col-sm-9">
                      <div class="input-group">
                          <span class="input-group-text"><i class="ph-calendar"></i></span>
                          <input type="text" required placeholder="Finish Time" name="time_finish" id="time_end" class="form-control daterange-single">
                      </div>
                  </div>
              </div>

              <div class="row mb-3">
                  <label class="col-form-label col-sm-3">Reason for overtime <span class="text-danger">*</span> :</label>
                  <div class="col-sm-9">
                      <textarea rows="3" cols="3" required class="form-control" name="reason" placeholder='Reason'></textarea>
                  </div>
              </div>
          </div>

          <div class="modal-footer">
              <button type="submit" class="btn btn-perfrom">Send Request</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
    <div class="card-header mb-0">
        <div class="d-flex justify-content-between">
            <h4 class="text-muted">My Overtime</h4>
            <a href="#apply_overtime" class="btn btn-perfrom"><i class="ph-plus me-2"></i> Apply Overtime</a>
        </div>
    </div>

    <div class="card-body border-0 shadow-none">
        <?php session("note"); ?>
        <div id ="myResultfeedOvertime"></div>
    </div>

    <table id="datatable" class="table table-striped table-bordered datatable-basic">
      <thead>
        <tr>
          <th>S/N</th>
          <th>Date</th>
          <th>Total Overtime(in Hrs.)</th>
          <th>Reason(Description)</th>
          <th>Status</th>
          <th>Option</th>
        </tr>
      </thead>


      <tbody>
        <?php foreach ($my_overtimes as $row) { ?>
            <?php if(!$row->status==2) { ?>
            <tr id="domain<?php //echo $row->id;?>">
                <td width="1px"><?php echo $row->SNo; ?></td>
                <td><?php echo date('d-m-Y', strtotime($row->applicationDATE)); ?></td>
                <td>
                    <?php echo "<b>Duration: </b>".$row->totoalHOURS." Hrs.<br><b>From: </b>".$row->time_in." <b> To </b>".$row->time_out; ?>
                </td>
                <td><?php echo $row->reason; ?></td>
                <td>
                    <div id ="status<?php echo $row->eoid; ?>">
                        <?php if($row->status==0){ ?> <span class="badge bg-secondary">REQUESTED</span> <?php }
                        elseif($row->status==1){ ?> <span class="badge bg-info">RECOMENDED</span> <?php }
                        elseif($row->status==2){ ?> <span class="badge bg-success">APPROVED</span> <?php }
                        elseif($row->status==3){ ?> <i style="color:red" class="ph-paper-plane-tilt"></i><?php }  ?>
                    </div>
                </td>
                <td class="options-width">
                    <?php if($row->status==0 || $row->status==3){ ?>
                        <a href="javascript:void(0)" onclick="cancelOvertime(<?php echo $row->eoid;?>)"  title="Cancel overtime">
                            <button type="button" class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php }  ?>
        <?php }  ?>
      </tbody>
    </table>
</div>


@if (count($line_overtime) > 0)
<div class="card mt-4">
    <div class="card-header">
        <h4 class="text-main">Others Overtime</h4>
    </div>

    <div class="card-body border-0 shadow-none">
        <?php session("note"); ?>
        <div id ="myResultfeedOvertime"></div>
    </div>

    <table id="datatable-keytable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Total Overtime(in Hrs.)</th>
                <th>Reason(Description)</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>
          <?php foreach ($line_overtime as $row) { ?>
                <?php  if ($row->status==2) {  continue; } ?>
                <tr>
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo  "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                    <td><?php echo "<b>On: </b>".date('d-m-Y', strtotime($row->applicationDATE))."<br><b>Duration: </b>".$row->totoalHOURS." Hrs.<br><b>From: </b>".$row->time_in." <b> To </b>".$row->time_out; ?> </td>
                    <td><?php echo $row->reason; ?></td>

                    <td>
                        <div id ="record<?php echo $row->eoid; ?>">
                            <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">REQUESTED</span></div><?php }
                            elseif($row->status==1 && $pendingPayroll==0){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED BY LINE MANAGER</span></div><?php }
                            elseif($row->status==4 && $pendingPayroll==0){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY FINANCE</span></div><?php }
                            elseif($row->status==3 && $pendingPayroll==0 ){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY HR</span></div><?php }
                            elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-success">APPROVED BY CD</span></div><?php }
                            elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-success">RETIREMENT CONFIRMED</span></div><?php }
                            elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-danger">DISSAPPROVED</span></div><?php }
                            elseif($row->status==7){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php }
                            elseif($row->status==8){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED RETIREMENT</span></div><?php } ?>
                        </div>


                        <?php  if ($row->status==0) {   ?>
                            <a href="javascript:void(0)" title="Approve" class="icon-2 info-tooltip" onclick="lineapproveOvertime(<?php echo $row->eoid;?>)">
                                <button class="btn btn-success btn-xs" ><i class="ph-check"></i></button>
                            </a>

                            <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip" onclick="cancelOvertime(<?php echo $row->eoid;?>)">
                                <button class="btn btn-danger btn-xs"><i class="ph-x"></i></button>
                            </a>
                        <?php }?>
                    </td>


                    <td class="options-width">
                        <?php //if($row->status==1 || $this->session->userdata('line') !=0 ){ ?> <?php //} ?>
                        <?php //if ($row->status==2) {   ?>
                        <a href="<?php echo url('')."flex/fetchOvertimeComment/".$row->eoid; ?>">
                            <button  class='btn btn-primary btn-xs'>Comment</i></button>
                        </a>
                        <?php //}  ?>
                    </td>
                </tr>
            <?php }  ?>
        </tbody>
      </table>
</div>
@endif


@endsection

@push('footer-script')

{{-- @include("app.includes.overtime_operations") --}}

<script>

    function holdOvertime(id)
    {
        if (confirm("Are You Sure You Want to Hold This Overtime Request") == true) {
            var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/holdOvertime') }}/"+overtimeid
            })
            .done(function(data){
                $('#resultfeedOvertime').fadeOut('fast', function(){
                    $('#resultfeedOvertime').fadeIn('fast').html(data);
                });

                $('#status'+id).fadeOut('fast', function(){
                    $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">HELD</span></div>');
                });

                alert('Request Canceled!');

                setTimeout(function() {
                    location.reload();
                }, 2000);
            })
            .fail(function(){
                alert('Overtime Hold Failed!! ...');
            });
        }
    }

     function approveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/approveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }




    function lineapproveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/lineapproveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }
    function hrapproveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/hrapproveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }

    function fin_approveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/fin_approveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }


    function denyOvertime(id)
    {
        if (confirm("Are You Sure You Want to Dissaprove This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/denyOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             alert('Request Dissaproved! ...');
                })
            .fail(function(){
             alert('Overtime Dissaproval Failed!! ...');
                });
        }
    }


    function recommendOvertime(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/recommendOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...');
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Recommendation Failed!! ...');
                });
        }
    }



    function confirmOvertime(id)
    {
        if (confirm("Are You Sure You Want to Confirm This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/confirmOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>');
                });
             alert('Request Confirmed Successifully!! ...');
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Confirmation Failed!! ...');
                });
        }
    }




    function cancelOvertime(id)
    {
        if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

            var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/cancelOvertime') }}/"+overtimeid
            })
            .done(function(data){
               $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>');
                });
             alert('Request Cancelled Successifully!! ...');
             setTimeout(function() {
                location.reload();
             }, 1000);
                })
            .fail(function(){
             alert('Overtime Cancellation Failed!! ...');
                });
        }
    }


</script>


<script type="text/javascript">
  $(".select_category").select2({
    placeholder: "Select Category",
    allowClear: true
  });

  $(function() {

    $('#time_range').daterangepicker({
        autoUpdateInput: false,
          timePicker: true,
          timePicker24Hour: true,
          timePickerIncrement: 30,
              singleClasses: "picker_1",
        locale: {
            cancelLabel: 'Clear',
            format: 'DD/MM/YYYY H:mm'
        }
    });

    $('#time_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY H:mm') + ' - ' + picker.endDate.format('DD/MM/YYYY H:mm'));
    });

    $('#time_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

  });
</script>

<script>
$(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!

  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  }
  if (mm < 10) {
    mm = '0' + mm;
  }
    var dateToday = dd + '-' + mm + '-' + yyyy;
    $('#time_start').daterangepicker({
      drops: 'down',
      singleDatePicker: true,
      autoUpdateInput: false,
      timePicker: true,
      timePicker24Hour: true,
      timePickerIncrement: 30,
      startDate:dateToday,
      minDate:dateToday,
      locale: {
        format: 'DD-MM-YYYY H:mm'
      },
      singleClasses: "picker_4"
    }, function(start, end, label) {
      // var years = moment().diff(start, 'years');
      // alert("The Employee is " + years+ " Years Old!");

    });
      $('#time_start').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY')+'  at  '+picker.startDate.format('H:mm'));
    });
      $('#time_start').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  });
</script>

<script>
$(function() {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!

  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  }
  if (mm < 10) {
    mm = '0' + mm;
  }
  var dateToday = dd + '-' + mm + '-' + yyyy;
  $('#time_end').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    timePicker: true,
    timePicker24Hour: true,
    timePickerIncrement: 30,
    startDate:dateToday,
    minDate:dateToday,
    locale: {
      format: 'DD-MM-YYYY H:mm'
    },
    singleClasses: "picker_4"
  }, function(start, end, label) {
    // var years = moment().diff(start, 'years');
    // alert("The Employee is " + years+ " Years Old!");

  });
    $('#time_end').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY')+'  at  '+picker.startDate.format('H:mm'));
  });
    $('#time_end').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>

<script type="text/javascript">


    $('#applyOvertime').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"{{ url('/flex/applyOvertime') }}",
                 type:"post",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedSubmission').fadeOut('fast', function(){
              $('#resultfeedSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 1000);
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...');
        });
    });

</script>
@endpush
