
@extends('layouts.vertical', ['title' => 'Leave'])

@push('head-script')
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')



<?php $totalAccrued = number_format($leaveBalance,2); ?>


{{-- start of leave application --}}

@if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
    {{ session('msg') }}
    </div>
    @endif
<div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 col-lg-12 ">
    <div class="card-header">
        <h5 class="text-warning"> Apply Leave</h5>
    </div>
    {{-- id="applyLeave" --}}
    <div class="card-body">
        <form  autocomplete="off" action="{{ route('flex.test') }}"  method="post"  enctype="multipart/form-data">
          @csrf
            <!-- START -->
            <div class="row">

        
            <div class="form-group col-6">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to Start</label>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="has-feedback">
                        <input type="date" name="start" class="form-control col-xs-12 " placeholder="Start Date"  required="" >
                        <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
                        </div>
                <span class="text-danger"><?php// echo form_error("fname");?></span>
            </div>

        </div>
            <input type="text" name="limit" hidden value="<?php echo $totalAccrued; ?>">
            <input type="text" name="empId" id="empID" hidden value="{{ Auth::User()->emp_id }}">

        <div class="form-group col-6">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Date to Finish
          </label>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="has-feedback">
            <input type="date" required="" placeholder="End Date" name="end" class="form-control col-xs-12 " >
            <span class="fa fa-calendar-o form-control-feedback right" aria-hidden="true"></span>
          </div>
            <span class="text-danger"><?php// echo form_error("fname");?></span>
          </div>
        </div>
        <div class="form-group col-6">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name" for="stream" >Nature of Leave</label>
                  <select class="form-control select @error('emp_ID') is-invalid @enderror" id="docNo" name="nature">
                      <option value=""> Leave Nature </option>
                      <?php  $sex = Auth::user()->gender;
                      if ($sex=='Male') { $gender = 1; }else if($sex=='Female') {$gender = 2; }
                      foreach($leave_type as $key){ if($key->gender > 0 && $key->gender!= $gender) continue; ?>
                     <option value="<?php echo $key->id; ?>"><?php echo $key->type; ?></option> <?php  } ?>
                  </select>
      
        </div>
        {{-- @if($days<336) --}}
        <div class="col-6 form-group" id="sub" style="display:none">
          <label class="control-label col-md-3 col-sm-3 col-xs-12 ">Sub Category</label>
          <select name="sub_cat" class="form-control select custom-select" id="subs_cat">
            <option value="0" id="first">--Select Sub Nature --</option>
          </select>
        </div>
        {{-- @endif --}}

        <div class="form-group col-6">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Leave Address
          </label>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <input required="required" type="text" id="address" name="address" class="form-control col-md-7 col-xs-12">
            <span class="text-danger"><?php// echo form_error("lname");?></span>
          </div>
        </div>
        <div class="form-group col-6">
          <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile</label>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <input required="required" class="form-control col-md-7 col-xs-12" type="text" name="mobile">
            <span class="text-danger"><?php// echo form_error("mname");?></span>
          </div>
        </div>
          {{-- start of attachment --}}

          <div class="form-group col-6">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <input required="required" class="form-control col-md-7 col-xs-12" type="file" name="image">
              <span class="text-danger"><?php// echo form_error("mname");?></span>
            </div>
          </div>
        <div class="form-group col-12">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Reason For Leave(Optional)
          </label>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <textarea maxlength="256" class="form-control col-md-7 col-xs-12" name="reason" placeholder="Reason" required="required" rows="3"></textarea>
            <span class="text-danger"><?php// echo form_error("lname");?></span>
          </div>
        </div>

      
            <!-- END -->
            <div class="form-group py-2">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-3">
                 <button  type="submit" class="btn btn-main float-end" >Apply Leave</button>
              </div>
            </div>

          </div>
            </form>
    </div>
</div>
{{-- / --}}
<div class="card border-top  border-top-width-3 border-top-main rounded-0" >
    <div class="card-header">
        <h6 class="text-warning">My Leaves</h6>
    </div>

    <div class="card-body">
        <p>Days Accrued: <code> {{ $totalAccrued .' Days' }}</code></p>


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
                @if($row->position == null) <span class="label label-default badge bg-pending text-white">NOT YET RECOMMENDED</span> @endif
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

            <?php } //} ?>
        </tbody>
      </table>
</div>



@endsection





@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
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
      var url = '{{ route("getSubs", ":id") }}';
      url = url.replace(':id', id);

      $('#subs_cat').find('option').not(':first').remove();
  
      $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          success: function(response){
             let subs=response;

           
             $("#sub").hide();
           
            for (var i = 0; i < response.length; i++) {
              
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
