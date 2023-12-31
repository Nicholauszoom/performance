@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <?php
    foreach ($groupInfo as $row) {
        $groupName = $row->name;
        $groupID = $row->id;
    }
    ?>

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    @include('app.headers_payroll_input')

                    <div class="card-header py-3">
                        <h5><?php echo $groupName; ?> &nbsp;&nbsp;(<b> <?php echo $headcounts; ?> Employees</b>) </h5>

                        {{-- <div class="col-md-6 col-sm-12 col-xs-12">
                            <form id="updateGroup" enctype="multipart/form-data" autocomplete="off" method="post"
                                data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="text" name="group_name" value="<?php echo $groupName; ?>"
                                                class="form-control">
                                            <input type="hidden" name="group_id" value="<?php echo $groupID; ?>">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-main">UPDATE</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> --}}

                    </div>

                    <div class="card-body">
                        @if (Session::has('note'))
                            {{ session('note') }}
                        @endif
                        <div id="feedBackRemove"></div>
                        <form id="removeFromGroup" method="POST">
                            @csrf
                            <input type="text" name="groupID" hidden="" value="<?php echo $groupID; ?>">
                            <input type="hidden" name="groupName" value="<?php echo $groupName; ?>" class="form-control">
                            <input type="hidden" name="option" id="option" value="" class="form-control">



                            <table id="datatable" class="table table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                // if ($department->num_rows() > 0){
                                foreach ($members as $row) { ?>
                                    <tr>
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->ID.' - '.$row->NAME; ?></td>
                                        <td><?php echo '<b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION; ?></td>
                                        <td hidden></td>
                                        <td hidden></td>
                                        <td hidden></td>
                                        <td class="options-width">
                                            <label class="containercheckbox">
                                                <input type="checkbox" name="option1[]" value="<?php echo $row->EGID . '|' . $row->ID; ?>">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php } //} ?>
                                </tbody>
                            </table>

                            <div class="form-group mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button class="btn btn-warning">Remove Selected</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-main">All Employees </h5>
                        <p><b>Mark Employees to add them in this Group</b></p>
                    </div>

                    <div class="card-body">
                        <?php echo session('notegroup'); ?>
                        <div id="feedBackAdd"></div>

                        <form id="addToGroup" method="post">
                            @csrf
                            <input type="text" name="groupID" hidden="" value="<?php echo $groupID; ?>">
                            {{-- <input type="text" name="groupName" value="" class="form-control"> --}}
                            <input type="hidden" name="option" id="option" value="" class="form-control">



                            <table id="datatable-keytable" class="table table-bordered datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Mark</th>
                                        <th hidden></th>
                                        <th hidden></th>
                                        <th hidden></th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                // if ($department->num_rows() > 0){
                                foreach ($nonmembers as $row) { ?>
                                    <tr>
                                        <td width="1px"><?php echo $row->SNo; ?></td>
                                        <td><?php echo $row->ID.' - '.$row->NAME; ?></td>
                                        <td><?php echo '<b>Department: </b>' . $row->DEPARTMENT . '<br><b>Position: </b>' . $row->POSITION; ?></td>

                                        <td class="options-width">
                                            <label class="containercheckbox">
                                                <input type="checkbox" name="option1[]" value="<?php echo $row->ID; ?>">
                                                <span class="checkmark"></span>
                                            </label>

                                        </td>
                                        <td hidden></td>
                                        <td hidden></td>
                                        <td hidden></td>
                                    </tr>
                                    <?php } //} ?>
                                </tbody>
                            </table>

                            <div class="form-group mt-3">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button  class="btn btn-success">Add Selected</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
        // JavaScript code to get selected users

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
    </script>

    <script type="text/javascript">
        $('#removeFromGroup').submit(function(e) {
            if (confirm("Are You Sure You Want To Remove The Selected Employee(s) From  This Group?") == true) {

                    //e.preventDefault();
                    var selectedUsers = []; // initialize an empty array

                    // get all rows in the table
                    var rows = $('#datatable').DataTable().rows().nodes();


                    // loop through the rows
                    $(rows).each(function() {
                        var checkbox = $(this).find('input[type="checkbox"]');

                        if (checkbox.is(':checked')) { // if checkbox is checked
                            selectedUsers.push(checkbox.val()); // add its value to the array
                        }
                    });
                    //console.log(selectedUsers);
                    var option =selectedUsers;
                    document.getElementById('option').value = option;
                    e.preventDefault();
                $.ajax({
                        url: "<?php echo url(''); ?>/flex/removeEmployeeFromGroup",
                        type: "post",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false
                    })
                    .done(function(data) {
                        $('#feedBackRemove').fadeOut('fast', function() {
                            $('#feedBackRemove').fadeIn('fast').html(data);
                        });

                        setTimeout(function() { // wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);
                    })
                    .fail(function() {
                        alert('Update Failed!! ...');
                    });
            }
        });
    </script>


    <script type="text/javascript">
        $('#addToGroup').submit(function(e) {




                    //e.preventDefault();
                    var selectedUsers = []; // initialize an empty array

                    // get all rows in the table
                    var rows = $('#datatable-keytable').DataTable().rows().nodes();


                    // loop through the rows
                    $(rows).each(function() {
                        var checkbox = $(this).find('input[type="checkbox"]');

                        if (checkbox.is(':checked')) { // if checkbox is checked
                            selectedUsers.push(checkbox.val()); // add its value to the array
                        }
                    });
                    var option =selectedUsers;
                    document.getElementById('option').value = option;
                    e.preventDefault();
                    $.ajax({
                            url: "<?php echo url(''); ?>/flex/addEmployeeToGroup",
                            type: "post",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            cache: false,
                            async: false
                        })
                        .done(function(data) {
                    console.log(data);

                            $('#feedBackAdd').fadeOut('fast', function() {
                                $('#feedBackAdd').fadeIn('fast').html(data);
                            });

                            setTimeout(function() { // wait for 5 secs(2)
                                location.reload(); // then reload the page.(3)
                            }, 3000);
                        })
                        .fail(function() {
                            new Noty({
                                text: 'Update Failed!! ....',
                                type: 'error'
                            }).show();
                        });





        });

        $('#updateGroup').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo url(''); ?>/flex/updateGroupEdit",
                type: 'POST',
                data: $(this).serialize(), // it will serialize the form data
                dataType: 'json'
            }).done(function(data) {
                if (data.status == 'OK') {
                    notify('Group updated successfully!', 'top', 'right', 'success');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else {
                    notify('Group update error!', 'top', 'right', 'danger');
                    setTimeout(function() { // wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }
            }).fail(function() {
                // alert('Registration Failed, Review Your Network Connection...');
            });

        });
    </script>
@endsection
