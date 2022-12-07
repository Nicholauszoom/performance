@extends('layouts.vertical', ['title' => 'Active Employees'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/tables/datatables/extensions/responsive.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_extension_responsive.js') }}"></script>
@endpush


@section('content')

    <div class="card">
        <div class="card-header border-0">
            <h5 class="mb-0 text-muted">Employee</h5>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5>List of employees</h5>

                <a href="{{ route('employee.create') }}" class="btn btn-primary">Register Employee</a>
            </div>
        </div>

        <table class="table datatable-responsive-column-controlled">
            <thead>
                <tr>
                    <th></th>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Position</th>
                    <th>Linemanager</th>
                    <th>Contacts</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($employee as $row)
                <tr>
                    <td></td>
                    <td>{{ $row->SNo }}</td>
                    <td><a href="{{ route('employee.profile') }}">{{ $row->NAME }}</a></td>
                    <td>{{ $row->gender }}</td>
                    <td>
                        <p>
                            <strong>Department :</strong> {{ $row->DEPARTMENT }}
                        </p>
                        <p>
                            <strong>Position :</strong> {{ $row->POSITION }}
                        </p>
                    </td>
                    <td>{{ $row->LINEMANAGER }}</td>
                    <td>
                        <p>
                            <strong>Email :</strong> {{ $row->email }}
                        </p>
                        <p>
                            <strong>Mobile :</strong> {{ $row->mobile }}
                        </p>
                    </td>

                    <td class="text-center">
                        <div class="d-flex">
                            <a
                                href="{{ route('employee.profile') }}"
                                title="info and detail"
                                class="icon-2 info-tooltip btn text-white bg-info btn-sm"
                            >
                                <i class="ph-info"></i>
                            </a>

                            <a
                                href="javascript:void(0)"
                                onclick="requestDeactivation('{{ $row->emp_id }}')"
                                title="Deactivate"
                                class="icon-2 info-tooltip btn text-white bg-danger btn-sm ms-1"
                            >
                                <i class="ph-prohibit"></i>
                            </a>

                            <a
                                href="javascript:void(0)"
                                title="Update"
                                class="icon-2 info-tooltip btn text-white bg-warning btn-sm ms-2"
                            >
                                <i class="ph-note-pencil"></i>
                            </a>

                            <a
                                href="javascript:void(0)"
                                title="Evaluate"
                                class="icon-2 info-tooltip btn text-white bg-success btn-sm ms-2"
                            >
                                Evaluate
                            </a>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('modal')

    <div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="message"></div>
                </div>

                <div class="row">
                    <div class="col-sm-4">

                    </div>
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No</button>
                        <button type="button" id="yes_delete" class="btn btn-danger btn-sm">Yes</button>
                    </div>
                    <div class="col-sm-2">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer-script')
    <script>

        function requestDeactivation(id) {

            console.log('OK deactivate me');

            const message = "Are you sure you want to deactivate this employee?";

            $('#delete').modal('show');
            $('#delete').find('.modal-body #message').text(message);

            var id = id;

            $("#yes_delete").click(function () {
                $.ajax({

                    url:"{{ route('employee.exit', ['id' => $row->emp_id]) }}"
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
            if (confirm("Are You Sure You Want To Delete This Employee?") == true) {
              var id = id;

                //index.php/cipay/employeeDeactivationRequest
                // index.php/cipay/employee_exit

            }
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



