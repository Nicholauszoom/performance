
@extends('layouts.vertical', ['title' => 'My Grievances'])

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




{{-- start of leave application --}}

@if (session('msg'))
    <div class="alert alert-success col-md-8 mx-auto mt-4" role="alert">
    {{ session('msg') }}
    </div>
    @endif
<div class="card border-top  border-top-width-3 border-top-main border-bottom-main rounded-0 col-lg-12 ">
    <div class="card-header">
        <h5 class="text-warning"> Add Grievance</h5>
    </div>
    {{-- id="applyLeave" --}}
    <div class="card-body">
        <form  autocomplete="off" action="{{ url('flex/attendance/save_leave') }}"  method="post"  enctype="multipart/form-data">
          @csrf
            <!-- START -->
            <div class="row">

            <div class="col-12 mb-2">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Description</label>
                    <textarea name="description" id="" class="form-control" rows="5" placeholder="Enter Grievance Description Here.."></textarea>
                </div>
            </div>
          
    

          <div class="form-group col-6">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <input required="required" class="form-control col-md-7 col-xs-12" type="file" name="image">
              <span class="text-danger"></span>
            </div>
          </div>

          <div class="form-group col-6">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Anonymous</label>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-3">
                    <input type="radio" name="anonymous" value="Yes" id="yes"> <label for="yes">Yes </label>
                </div>
                <div class="col-3">
                    <input type="radio" name="anonymous" value="No" id="no"> <label for="no">No </label>
                </div>
            </div>
          
            </div>
          </div>
     
            <!-- END -->
            <div class="form-group py-2">
              <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 col-md-offset-3">
                 <button  type="submit" class="btn btn-main float-end" >Submit  Grievance</button>
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


        @if(Session::has('note'))      {{ session('note') }}  @endif
    </div>

    <table class="table table-striped table-bordered datatable-basic">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Description</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Timed</th>
            <th>Option</th>
          </tr>
        </thead>


        <tbody>
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
