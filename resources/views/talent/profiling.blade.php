
@extends('layouts.vertical', ['title' => 'Employee'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

  @if (session('mng_emp') || session('vw_emp') || session('appr_emp'))
  <div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header  mb-0">
      <h5 class="text-main">Employees Talent Profiling</h5>
    </div>

@can('view-Talent')
    <table id="datatable" class="table table-striped table-bordered datatable-basic">
      <thead>
        <tr>
          <th>Emp_ID</th>
          <th>Employee Name</th>
          <th>Skills Qualification</th>
          <th>Performance Results</th>
          <th>Productivity Rate</th>
          <th hidden></th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $item)

        {{-- For Performance Results --}}
    
        <tr>
            <td>{{ $item->emp_id }}</td>
            <td>{{ $item->fname }} {{ $item->mname }} {{ $item->lname }}</td>
            <td>
                @php
                $position= App\Models\PositionSkills::where('position_ref',$item->position)->count();
                $skills= App\Models\EmployeeSkills::where('empID',$item->emp_id)->count();
                @endphp

                @if ($skills>0 && $position)
                {{   number_format( $skills/$position, 2) * 100  }} %
                @else
                    N/L
                @endif
            </td>
            <td> 
                @php
                $performance= App\Models\EmployeePerformance::where('empID',$item->emp_id)->avg('performance');
                @endphp

                @if ($performance)
                {{ $performance }}
                @else
                    N/L
                @endif
              
            </td>
            <td>
                @php
                $achieved= App\Models\EmployeePerformance::where('empID',$item->emp_id)->avg('achieved');
                $target= App\Models\EmployeePerformance::where('empID',$item->emp_id)->avg('target');
                @endphp
                @if ($achieved>0)
                {{   number_format( $achieved/$target, 2)  }}
                @else
                    N/L
                @endif
            </td>
           <td hidden></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    @endcan
  </div>
  @endif



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
