
@extends('layouts.vertical', ['title' => 'Employee'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

@can('view-employee')
  <div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header  mb-0">
      <h5 class="text-main">Employees</h5>
    </div>

    <div class="card-body ">
      <div class="d-flex justify-content-between">
        <h4 class="lead text-warning ">List of Employees</h4>


        @can('add-employee')
          <a href="{{ url('/flex/addEmployee') }}" class="btn btn-main">
            <i class="ph-plus me-2"></i> Register New Employee
          </a>
        @endcan

      </div>
    </div>

    <table id="datatable" class="table table-striped table-bordered datatable-basic">
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Position</th>
          <th>Linemanager</th>
          <th>Contacts</th>
          @can('edit-employee')
          <th>Options</th>
          @endcan
        </tr>
      </thead>


      <tbody>
        @foreach ($employee as $row)
        <tr>
            <td width="1px">{{ $row->id }}</td>

            <td><a title="More Details"  href="{{ route('flex.userprofile', base64_encode($row->emp_id)) }}"> {{ $row->NAME }} </a></td>
            <td>{{ $row->gender }}</td>
            <td>
                <b>Department: </b> {{ $row->DEPARTMENT }} <br>
                <b>Position: </b> {{ $row->POSITION }}
            </td>
            @php
            $l_name = ' ';
            if(!empty($row->line_manager)){
             $mng = App\Models\Employee::all()->where('emp_id',$row->line_manager)->first();
             $l_name = $mng->fname.' '.$mng->mname.' '.$mng->lname;
            }

            @endphp
            <td> {{ $l_name }} </td>
            <td>
                <b>Email: </b> {{ $row->email }} <br>
                <b>Mobile: </b> {{ $row->mobile }}
            </td>
            @can('edit-employee')
            <td class="options-width" style="width:200px !important;">
                <a  href="{{ route('flex.userprofile', base64_encode($row->emp_id)) }}" class="btn btn-main  btn-sm" title="Info and Details">
                    <i class="ph-info"></i>
                </a>

                @can('edit-employee')
                <a  href="{{ route('flex.viewProfile', base64_encode($row->emp_id)) }}" class="btn btn-main  btn-sm"   title="Info and Details">
                    <i class="ph-pen"></i>
                </a>

                <a href="javascript:void(0)" onclick="requestDeactivation('<?php echo $row->emp_id; ?>')"  class="btn btn-danger btn-sm"  title="Deactivate">
                <i class="ph-prohibit"></i>
                </a>

                    <a href="<?php echo  url('') .'/flex/updateEmployee/'.$row->emp_id."|".$row->department; ?>" title="Update">
                        <button type="button" class="btn btn-warning btn-xs"><i class="ph-note-pencil"></i></button>
                    </a>
{{--
                    <a href="<?php echo  url('').'flex/project/evaluateEmployee/'.$row->emp_id.'|'.$row->department; ?>" title="Update">
                        <button type="button" class="btn btn-success btn-xs"><i class="">Evaluate</i></button>
                    </a> --}}
                    @endcan
            </td>

            @endcan
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endcan



<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content py-2">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row">
                <div class="col-sm-4"></div>

                <div class="col-sm-6">
                    <button type="button" class="btn btn-main btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                </div>

                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('footer-script')
    <script>
        function requestDeactivation(id) {

            console.log("Am working fine");

            const message = "Are you sure you want to deactivate this employee?";

            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            var id = id;

            $("#yes_delete").click(function () {
                $.ajax({
                    url:"{{ url('flex/employee_exit') }}/"+id,
                    success:function(data)
                    {
                        // console.log(data);
                        // if(data.status == 'OK'){
                        // alert("SUCCESS");
                        // $('#feedBack').fadeOut('fast', function(){
                        //     $('#feedBack').fadeIn('fast').html(data.message);
                        // });
                        // }else{ }

                        $('#delete').modal('hide');
                        notify('Employee deactivated successfully!', 'top', 'right', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        // alert("FAILED: Delete failed Please Try again");
                        // alert("Status: " + textStatus); alert("Error: " + errorThrown);

                        $('#delete').modal('hide');
                        notify('Department not deleted!', 'top', 'right', 'danger');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    }
                });
            });

            // if (confirm("Are You Sure You Want To Delete This Employee?") == true) {
            //   var id = id;
            //
            //     //index.php/cipay/employeeDeactivationRequest
            //     // index.php/cipay/employee_exit
            //
            // }
        }
    </script>


    <script>

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
                z_index: 1031,
                delay: 5000,
                timer: 1000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
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


        function run(){
            alert("hello world");
        }
    </script>
@endpush
