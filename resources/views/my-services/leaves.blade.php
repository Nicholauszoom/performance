
@extends('layouts.vertical', ['title' => 'Leave'])


@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('content')



<?php $totalAccrued = number_format($leaveBalance,2); ?>


{{-- start of leave application --}}

@if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
    {{ session('msg') }}
    </div>
    @endif
    <div class="card border-top border-top-width-3 border-top-main border-bottom-main rounded-0 col-lg-12">
        <div class="card-header">
            <h5 class="text-warning">Apply Leave</h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form autocomplete="off" action="{{ url('flex/attendance/save_leave') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="start-date">Start Date <span class="text-danger">*</span></label>
                                <input type="date" name="start" id="start-date" class="form-control" required>
                            </div>
                            <input type="text" name="limit" hidden value="{{ $totalAccrued }}">
                            <input type="text" name="empId" id="empID" hidden value="{{ Auth::User()->emp_id }}">
                            <div class="form-group col-md-6">
                                <label for="end-date">End Date <span class="text-danger">*</span></label>
                                <input type="date" required id="end-date" name="end" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="docNo">Nature of Leave <span class="text-danger">*</span></label>
                                <select class="form-control" required id="docNo" name="nature">
                                    <option value="">Select Nature</option>
                                    @php
                                    $gender = Auth::user()->gender == 'Male' ? 1 : 2;
                                    @endphp
                                    @foreach($leave_type as $key)
                                        @if ($key->gender <= 0 || $key->gender == $gender)
                                            <option value="{{ $key->id }}">{{ $key->type }} Leave</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="sub" style="display:none">
                                <label for="subs_cat">Sub Category <span class="text-danger">*</span></label>
                                <select name="sub_cat" class="form-control select custom-select" id="subs_cat"></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Leave Address <span class="text-danger">*</span></label>
                                <input required="required" type="text" id="address" name="address" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                <input required="required" class="form-control" type="tel" maxlength="10" name="mobile">
                            </div>
                            <div class="form-group col-md-6" style="display:none" id="attachment">
                                <label for="image">Attachment <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="image">
                            </div>
                            <div class="form-group col-12 mb-2">
                                <label for="reason">Reason For Leave <span class="text-danger">*</span></label>
                                <textarea maxlength="256" class="form-control" name="reason" placeholder="Reason" required="required" rows="3"></textarea>
                            </div>
                            @if($deligate > 0)
                            <div class="form-group col-md-6">
                                <label for="deligate">Deligate Position To <span class="text-danger">*</span></label>
                                <select name="deligate" @if($deligate > 0) required @endif class="form-control" id="deligate">
                                    <option value="">Select Deligate</option>
                                    @foreach($employees as $item)
                                    <option value="{{ $item->emp_id }}">{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>

                        <div class="form-group py-2">
                            <button class="float-end btn btn-main" type="button" data-bs-toggle="modal" data-bs-target="#approval">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card-container">
                        <div class="card specific-card">
                            <div class="card-body">
                                <p><b>Sick Leave Days Remaining: <code class="text-success">{{ $sickLeaveBalance .' Days' }}</b></code></p>
                            </div>
                        </div>
                        @php
                        $gender = Auth::user()->gender == 'Male' ? 1 : 2;
                        @endphp

                        <div class="card specific-card">
                            <div class="card-body">
                                @if ($gender == 1)
                                    <p><b>Paternity Leave Days Remaining: <code class="text-success">{{ $paternityLeaveBalance .' Days' }}</b></code></p>
                                @else
                                    <p><b>Maternity Leave Days Remaining: <code class="text-success">{{ $maternityLeaveBalance .' Days' }}</b></code></p>
                                @endif
                            </div>
                        </div>

                        <div class="card specific-card">
                            <div class="card-body">
                                <p><b>Compassionate Leave Days Remaining: <code class="text-success">{{ $compassionateLeaveBalance .' Days' }}</b></code></p>
                            </div>
                        </div>
                        <div class="card specific-card">
                            <div class="card-body">
                                <p><b>Study Leave Days Remaining: <code class="text-success">{{ $studyLeaveBalance .' Days' }}</b></code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add approval modal -->
    <div id="approval" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h6 class="text-center">Are you Sure?</h6>
                    <div class="row">
                        <div class="col-4 mx-auto">
                            <button type="submit" class="btn bg-main btn-sm px-4">Yes</button>
                            <button type="button" class="btn bg-danger btn-sm px-4 text-light" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

{{-- / --}}
<div class="card border-top  border-top-width-3 border-top-main rounded-0" >
    <div class="card-header">
        <h6 class="text-warning">My Leaves</h6>
    </div>

    <div class="card-body">
        <p><b>Annual Leave Days Accrued: <code class="text-success"> {{ $totalAccrued .' Days' }}</b></code></p>
        {{-- <p><b>Sick Leave Days Accrued: <code class="text-success"> {{ $sickLeaveBalance .' Days' }}</b></code></p>
        <p><b>Compassionate Leave Days Accrued: <code class="text-success"> {{ $compasionteLeaveBalance .' Days' }}</b></code></p>
        <p><b>Maternity Leave Days Accrued: <code class="text-success"> {{ $totalAccrued .' Days' }}</b></code></p>
        <p><b>Study Leave Days Accrued: <code class="text-success"> {{ $totalAccrued .' Days' }}</b></code></p> --}}


        @if(Session::has('note'))      {{ session('note') }}  @endif
    </div>

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Duration</th>
            <th>Nature</th>
            <th>Reason</th>
            <th>Approval State</th>
            <th>Status</th>
            <th>Option</th>
          </tr>
        </thead>


        <tbody>
          <?php
          // if ($leave->num_rows() > 0){
            foreach ($myleave as $row) {
                if($row->position != "Default Apllication"){
            //   if($row->status==2){ continue; }
              $date1=date_create($row->start);
              $date2=date_create($row->end);
              $diff=date_diff($date1,$date2);
              $final = $diff->format("%a Days");
              $final2 = $diff->format("%a");
             ?>
            <tr id="record<?php echo $row->id; ?>">
              <td width="1px"><?php echo $row->SNo; ?></td>



              <td><?php
              // // DATE MANIPULATION
                $start = $row->start;
                $end =$row->end;
                $datewells = explode("-",$start);
                $datewelle = explode("-",$end);
                $mms = $datewells[1];
                $dds = $datewells[2];
                $yyyys = $datewells[0];
                $dates = $dds."-".$mms."-".$yyyys;

                $mme = $datewelle[1];
                $dde = $datewelle[2];
                $yyyye = $datewelle[0];
                $datee = $dde."-".$mme."-".$yyyye;
              //
              echo $row->days .' Days'."<br>From <b>".$dates."</b><br>To <b>".$datee."</b>";?></td>

              <td>
                <p>Nature :<b> <?php echo $row->type->type; ?> Leave</b><br>
                @if($row->sub_category> 0)  Sub Category :<b> <?php echo $row->sub_type->name; ?></b>
                @endif
              </p>
              </td>
              <td><?php echo $row->reason; ?></td>
            <td><div>
                @if($row->position == null) <span class="label label-default badge bg-pending text-white">NOT  APROVED</span> @endif
                <span class="label label-default badge bg-info text-white">{{ $row->position }}</span>
            </div></td>
              <td>
                <div >

                      <?php if ($row->state==1){ ?>
                      <div class="col-md-12">
                      <span class="label label-default badge bg-pending text-white">PENDING</span></div><?php }
                      elseif($row->state==0){?>
                      <div class="col-md-12">
                      <span class="label badge bg-info text-whites label-info">APPROVED</span></div><?php }
                      elseif($row->state==3){?>
                      <div class="col-md-12">
                      <span class="label badge bg-danger text-white">DENIED</span></div><?php } ?>
                </div>

              </td>
              <td class="options-width d-flex">
                {{-- start of cancel leave button --}}
              <?php if($row->status==0 ){ ?>
                <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip disabled"
                onclick="cancelRequest(<?php echo $row->id; ?>)">
                  <button  class="btn btn-danger btn-sm" ><i class="ph-x"></i></button></a>
              <?php } else{ ?>
              {{-- / --}}
              <button  class="btn btn-danger btn-sm"  disabled><i class="ph-x"></i></button></a>
              <?php }  ?>
              </td>

              </tr>

            <?php }} //} ?>
        </tbody>
      </table>
</div>



@endsection





@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
function confirmSubmit() {

Swal.fire({
    title: 'Are You Sure That You Want to Submit This Leave Request ?',
    // text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Approve it!'
}).then((result) => {
    if (result.isConfirmed) {
        var terminationid = id;

        $.ajax({
            url: "{{ url('flex/attendance/approveLeave') }}/" + terminationid
        })
        .done(function(data) {
            $('#resultfeedOvertime').fadeOut('fast', function() {
                $('#resultfeedOvertime').fadeIn('fast').html(data);
            });

            $('#status' + id).fadeOut('fast', function() {
                $('#status' + id).fadeIn('fast').html(
                    '<div class="col-md-12"><span class="label label-warning">Approved</span></div>'
                    );
            });

            // alert('Request Cancelled Successifully!! ...');

            Swal.fire(
                'Cancelled!',
                'Leave Request Approved Successifully!!.',
                'success'
            )

            setTimeout(function() {
                location.reload();
            }, 1000);
        })
        .fail(function() {
            Swal.fire(
                'Failed!',
                'Leave Request Cancellation Failed!! ....',
                'success'
            )

            alert('Leave Request Cancellation Failed!! ...');
        });
    }
});

}


function approveRequest(id) {

Swal.fire({
    title: 'Are You Sure That You Want to Approve This Leave Request ?',
    // text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, Approve it!'
}).then((result) => {
    if (result.isConfirmed) {
        var terminationid = id;

        $.ajax({
            url: "{{ url('flex/attendance/approveLeave') }}/" + terminationid
        })
        .done(function(data) {
            $('#resultfeedOvertime').fadeOut('fast', function() {
                $('#resultfeedOvertime').fadeIn('fast').html(data);
            });

            $('#status' + id).fadeOut('fast', function() {
                $('#status' + id).fadeIn('fast').html(
                    '<div class="col-md-12"><span class="label label-warning">Approved</span></div>'
                    );
            });

            // alert('Request Cancelled Successifully!! ...');

            Swal.fire(
                'Cancelled!',
                'Leave Request Approved Successifully!!.',
                'success'
            )

            setTimeout(function() {
                location.reload();
            }, 1000);
        })
        .fail(function() {
            Swal.fire(
                'Failed!',
                'Leave Request Cancellation Failed!! ....',
                'success'
            )

            alert('Leave Request Cancellation Failed!! ...');
        });
    }
});

}


        function cancelRequest(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Cancel This Leave Request ?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                        url: "{{ url('flex/attendance/cancelLeave') }}/" + terminationid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                                );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Cancelled!',
                            'Leave Request Cancelled Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Leave Request Cancellation Failed!! ....',
                            'success'
                        )

                        alert('Leave Request Cancellation Failed!! ...');
                    });
                }
            });

            // if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {

            //     var overtimeid = id;

            //     $.ajax({
            //             url: "{{ url('flex/cancelOvertime') }}/" + overtimeid
            //         })
            //         .done(function(data) {
            //             $('#resultfeedOvertime').fadeOut('fast', function() {
            //                 $('#resultfeedOvertime').fadeIn('fast').html(data);
            //             });

            //             $('#status' + id).fadeOut('fast', function() {
            //                 $('#status' + id).fadeIn('fast').html(
            //                     '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
            //                     );
            //             });

            //             alert('Request Cancelled Successifully!! ...');

            //             setTimeout(function() {
            //                 location.reload();
            //             }, 1000);
            //         })
            //         .fail(function() {
            //             alert('Overtime Cancellation Failed!! ...');
            //         });
            // }
        }
    </script>






@include('app.includes.leave_operations')

<script>

  $('#docNo').change(function(){
      var id = $(this).val();
      const start = document.getElementById("start-date").value;
      const end = document.getElementById("end-date").value;
    var par= id+'|'+start+'|'+end;
      var url = '{{ route("getSubs", ":id") }}';
      url = url.replace(':id', par);

      if (id==1) {
        $("#attachment").hide();
      } else {
        $("#attachment").show();
      }

      $('#subs_cat').find('option').not(':first').remove();

      $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',

          success: function(response){

            let days=response.days;
             let subs=response.data;
            var status ="<span>"+response.days+" Days</span>"
            $("#remaining").empty(status);
             $("#remaining").append(status);
             $("#remaining").show()
             $("#sub").hide();


            for (var i = 0; i < response.data.length; i++) {

              var id=subs[i].id;
              var name=subs[i].name;
              var option = "<option value='"+id+"'>"+name+"</option>";


              $("#subs_cat").append(option);

              $("#sub").show();

            }


          }
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
      var dateToday = dd + '/' + mm + '/' + yyyy;
      $('#leave_startDate').daterangepicker({
        drops: 'down',
        singleDatePicker: true,
        autoUpdateInput: false,
        startDate:dateToday,
        minDate:dateToday,
        locale: {
          format: 'DD/MM/YYYY'
        },
        singleClasses: "picker_1"
      }, function(start, end, label) {
        // var years = moment().diff(start, 'years');
        // alert("The Employee is " + years+ " Years Old!");

      });
        $('#leave_startDate').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD/MM/YYYY'));
      });
        $('#leave_startDate').on('cancel.daterangepicker', function(ev, picker) {
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
      var dateToday = dd + '/' + mm + '/' + yyyy;
      $('#leave_endDate').daterangepicker({
        drops: 'down',
        singleDatePicker: true,
        autoUpdateInput: false,
        startDate:dateToday,
        minDate:dateToday,
        locale: {
          format: 'DD/MM/YYYY'
        },
        singleClasses: "picker_1"
      }, function(start, end, label) {
        // var years = moment().diff(start, 'years');
        // alert("The Employee is " + years+ " Years Old!");

      });
        $('#leave_endDate').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD/MM/YYYY'));
      });
        $('#leave_endDate').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
    });
    </script>
@endpush
