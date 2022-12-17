@extends('layouts.vertical', ['title' => 'Attandance'])

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

<div class="card">
    <div class="card-header">
        <h5 class="text-main">Attendance</h5>
    </div>

    <div class="card-body">
        <form id="printAttendance" method ="post" action="{{ url('/flex/reports/attendance') }}" target="_blank" class="form-horizontal form-label-left">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label mb-2" >Employee Attendance ON</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <input type="date" name="start" class="form-control daterange-single" id="single_cal3" value="{{ date('Y-m-d') }}">
                        <button name="print"  class="btn btn-main">PRINT</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <table  class="table table-striped table-bordered datatable-basic">
        <thead>
          <tr>
            <th><b>S/N</b></th>
            <th><b>Name</b></th>
            <th><b>Department</b></th>
            <th><b>Sign IN</b></th>
            <th><b>Sign OUT</b></th>
          </tr>
        </thead>


        <tbody>
          <?php

            foreach ($attendee as $row) { ?>
            <tr >
              <td width="1px"><?php echo $row->SNo; ?></td>
              <td><?php echo $row->name; ?></td>
              <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
              <td><?php echo $row->time_in; ?></td>
              <td><?php  echo  $row->time_out; ?></td>
              </tr>
            <?php } //} ?>
        </tbody>
      </table>
</div>



@endsection

@push('footer-script')

<script type="text/javascript">

    // var attandee_table = $('#datatable').DataTable({
    //             bPaginate: true,
    //             bInfo: true,
    //             ordering: false,
    //             columns: [
    //                 {'data': 'SNo'},
    //                 {'data': 'name'},
    //                 {'data': 'DEPARTMENT'},
    //                 {'data': 'time_in'},
    //                 {'data': 'time_out'}
    //             ]
    //         });

    $(document).ready(function(){
        $('#single_cal3').on('change',function(){
            var formValue = $(this).val();
            if(formValue){
                $.ajax({
                    type:'POST',
                    url:'{{ url("/flex/attendance/attendeesFetcher/") }}',
                    data:'due_date='+formValue,
                    success:function(html){
                      let jq_json_obj = $.parseJSON(html);
                      let jq_obj = eval (jq_json_obj);
                      attandee_table.clear();
                      attandee_table.rows.add(jq_obj);
                      attandee_table.draw();

                    }
                });
            }
        });
    });
    </script>


<script>
    $(document).ready(function() {

      $('#department').on('change',function(){
          var stateID = $(this).val();
          if(stateID){
              $.ajax({
                  type:'POST',
                  url:'{{ url("/flex/positionFetcher/") }}',
                  data:'dept_id='+stateID,
                  success:function(html){
                      // $('#pos').html(html);
                      let jq_json_obj = $.parseJSON(html);
                      let jq_obj = eval (jq_json_obj);

                      //populate position
                      $("#pos option").remove();
                      $('#pos').append($('<option>', {
                          value: '',
                          text: 'Select Position',
                          selected: true,
                          disabled: true
                      }));
                      $.each(jq_obj.position, function (detail, name) {
                          $('#pos').append($('<option>', {value: name.id, text: name.name}));
                      });
                  }
              });
          }else{
              // $('#pos').html('<option value="">Select state first</option>');
          }
      });
    });
  </script>


<script>

    function testing() {
      console.log('adfsd');
      // notify('Sale list empty', 'top', 'right', 'success');

    }

    function notify(message, from, align, type) {
      $.growl({
          message: message,
          url: ''
      }, {
          element: 'body',
          type: type,
          allow_dismiss: true,
          placement: {
              from: from,
              align: align
          },
          offset: {
              x: 30,
              y: 30
          },
          spacing: 10,
          z_index: 999999,
          delay: 2500,
          timer: 1000,
          url_target: '_blank',
          mouse_over: false,

          icon_type: 'class',
          template: '<div data-growl="container" class="alert" role="alert">' +
              '<button type="button" class="close" data-growl="dismiss">' +
              '<span aria-hidden="true">&times;</span>' +
              '<span class="sr-only">Close</span>' +
              '</button>' +
              '<span data-growl="icon"></span>' +
              '<span data-growl="title"></span>' +
              '<span data-growl="message"></span>' +
              '<a href="#!" data-growl="url"></a>' +
              '</div>'
      });
    }



</script>
@endpush
