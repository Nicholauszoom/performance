@extends('layouts.vertical', ['title' => 'Departments'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h3 class="text-main">Departments</h3>
</div>

<div class="row">

    <div class="@if(session('mng_org')) col-md-7 @else col-md-12 @endif">
        @can('view-department')
        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <h4 class="text-main">Department List</h4>
                <?php session("note"); ?>
                <div id="feedBackTable"></div>
            </div>

            <table id="datatable" class="table datatable-basic table-bordered">
                <thead>
                    {{-- <tr> --}}
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Cost Center</th>
                        <th>Head Of department</th>

                        <th>Reports To</th>
                        <?php if(session('mng_org')){ ?>
                        <th>Option</th>
                        <?php } ?>
                        <th hidden></th>
                    {{-- </tr> --}}
                </thead>
                <tbody>
                    @foreach ($department as $row)
                        <tr id="domain<?php echo $row->id;?>">
                            <td width="1px">{{ $loop->iteration }}</td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->CostCenterName; ?></td>
                            <td><a title="More Details"  href="{{ route('flex.employee_info',$row->hod) }}"><?php echo $row->hod; ?></a></td>
                            <td><?php echo $row->parentdept; ?></td>

                            <?php if(session('mng_org')){ ?>
                            <td class="options-width">
                                <a href="{{ route('flex.department_info',$row->id) }}" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-main btn-xs"><i class="ph-info"></i></button> </a>
                                <?php if($row->id!=3){ ?>
                                <a href="javascript:void(0)" onclick="deleteDepartment(<?php echo $row->id; ?>)" title="Delete Department" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button> </a>
                                <?php } ?>
                            </td>
                            <?php } ?>
                            <td hidden></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endcan
        </div>
    </div>

    @can('add-department')

    <?php if(session('mng_org')){ ?>
    <div class="col-md-5">
        <div class="card border-top  border-top-width-3 border-top-main rounded-0">
            <div class="card-header">
                <h4 class="text-main">Add Department</h4>
                <div id="feedBack" class="mt-2"></div>
            </div>
            <div class="card-body">

                <form autocomplete="off" id="departmentAdd" enctype="multipart/form-data"  method="post"  data-parsley-validate>

                    <!-- START -->
                    <div class="mb-3">
                        <label class="form-label" for="department-name">Department Name</label>
                        <textarea required="" class="form-control" name="name" placeholder="Department Name" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Cost Center</label>
                        <select required name="cost_center_id" class="select4_single form-control select" tabindex="-1">
                            <option> Select </option>
                            <?php  foreach ($cost_center as $row) { ?>
                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Head of Department</label>
                        <select required="" name="hod" class="select4_single form-control select" tabindex="-1">
                            <option> Select </option>
                            <?php  foreach ($employee as $row) { ?>
                            <option value="<?php echo $row->empID; ?>"><?php echo $row->NAME; ?></option> <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Reports To</label>
                        <select required="" name="parent" class="select3_single form-control select" tabindex="-1">
                            <option>Select </option>
                            <?php  foreach ($parent_department as $row) {  ?>
                            <option value="<?php echo $row->id."|".$row->department_pattern."|".$row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                        </select>
                    </div>

                    <!-- END -->
                    <div class="mb-3">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 py-3">
                            <input type="submit"  value="SAVE DEPARTMENT" name="add" class="btn btn-main"/>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php } ?>
</div>

@endcan


@can('view-disabled-department')
<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header">
        <h4 class="text-main"> Disabled Departments</h4>
        <?php echo session("note");  ?>
        <div id="feedBackTable2"></div>
    </div>

    <table id="datatable" class="table datatable-basic table-bordered">
        <thead>
            <tr>
                <th>S/N</th>
                <th hidden></th>
                <th>Reports To</th>
                <th>Name</th>
                <th>Head Of department</th>


                <?php if(session('mng_org')){ ?>
                <th>Option</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            {{-- {{dd($inactive_department)}} --}}
        <?php foreach ($inactive_department as $row) { ?>
            <tr id="domain<?php echo $row->id;?>">
                <td width="1px"><?php echo $row->id; ?></td>
                <th hidden></th>
                <td><?php echo $row->name; ?></td>
                <td><a title="More Details"  href=""><?php echo $row->hod; ?></a></td>
                <td><?php echo $row->parent_pattern; ?></td>
                <?php if(session('mng_org')){ ?>
                <td class="options-width d-flex">
                    <a href="{{ route('flex.department_info',$row->id) }}" title="Info and Details" class="icon-2 info-tooltip me-2">
                        <button type="button" class="btn btn-main btn-xs"><i class="ph-info"></i></button>
                    </a>
                    <?php if($row->id!=3){ ?>
                    <a href="javascript:void(0)" onclick="activateDepartment(<?php echo $row->id; ?>)" title="Activate Department" class="icon-2 info-tooltip">
                        <button type="button" class="btn btn-success btn-xs"><i class="ph-check"></i></button>
                    </a>
                    <?php } ?>
                </td>
                    <?php } ?>
            </tr>
        <?php } //} ?>
        </tbody>
      </table>
</div>

@endcan

<div class="modal fade bd-example-modal-sm" data-backdrop="static" data-keyboard="false" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="message"></div>
            </div>

            <div class="row mb-4">
                <div class="col-sm-4"></div>

                <div class="col-sm-6">
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">No</button>
                    <button type="button" id="yes_delete" class="btn btn-main btn-sm">Yes</button>
                </div>

                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('footer-script')

<script>
  function notify(message, from, align, type) {
    $.growl({
        message: message,
        url: ''
    },
    {
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
      $('#departmentAdd').submit(function(e){
          e.preventDefault();

               $.ajax({
                    url:"{{ route('flex.departmentAdd') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:"post",
                    data:new FormData(this),
                    processData:false,
                    contentType:false,
                    cache:false,
                    async:false
                }).done(function(data){

                    new Noty({
                        text: 'Department added successfuly.',
                        type: 'success'
                    }).show();

                    //notify('Department added successfuly!', 'top', 'right', 'success');

                    // $('#feedBack').fadeOut('fast', function(){
                    //      $('#feedBack').fadeIn('fast').html(data);
                    //    });

                    setTimeout(function(){// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 2000);

                    //   $('#updateMiddleName')[0].reset();
                }).fail(function(){
                    // alert('Request Failed!! ...');

                    new Noty({
                        text: 'Request Failed!! ....',
                        type: 'warning'
                    }).show();
                });
      });
  </script>
  <script> //For Deleting records without Page Refreshing

      function deleteDepartment(id)
      {
        const message = "Are you sure you want to Deactivate this department?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;
            $("#yes_delete").click(function(){
            $('#hide'+id).show();

            $.ajax({
                url:"<?php echo url('flex/deleteDepartment');?>/"+id,
                success:function(data)
                {
                    // success :function(result){
                    // $('#alert').show();
                  var data = JSON.parse(data);
                    if(data.status == 'OK'){
                        // alert("Record Deleted Sussessifully!");
                        $('#domain'+id).hide();
                        $('#delete').modal('hide');

                        // notify('Department deleted successfuly!', 'top', 'right', 'success');

                        new Noty({
                            text: 'Department not deleted.',
                            type: 'success'
                        }).show();

                        // $('#feedBackTable').fadeOut('fast', function(){
                        // $('#feedBackTable').fadeIn('fast').html(data.message);
                        // });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    } else if (data.status != 'SUCCESS'){
                        $('#delete').modal('hide');

                        new Noty({
                            text: 'Department not deleted.',
                            type: 'warning'
                        }).show();

                        //   notify('Department not deleted!', 'top', 'right', 'danger');
                        // alert("Property Not Deleted, Error In Deleting");
                    }
                }

            });
        });
          // if (confirm("Are You Sure You Want To Delete This Department") == true) {
          //
          // }
      }

      function activateDepartment(id)
      {
        const message = "Are you sure you want to activate this department?";
        $('#delete').modal('show');
        $('#delete').find('.modal-body #message').text(message);

        var id = id;
        $('#yes_delete').click(function() {
          $('#hide'+id).show();
          $.ajax({
              url:"<?php echo url('flex/activateDepartment');?>/"+id,
              success:function(data)
              {
                // success :function(result){
                // $('#alert').show();
                var data = JSON.parse(data);
                if(data.status == 'OK'){
                    // alert("Record Deleted Sussessifully!");

                    $('#domain'+id).hide();
                    $('#delete').modal('hide');

                    new Noty({
                        text: 'Department activated successfuly.',
                        type: 'success'
                    }).show();

                    //   $('#feedBackTable2').fadeOut('fast', function(){
                    //   $('#feedBackTable2').fadeIn('fast').html(data.message);
                    // });

                    setTimeout(function() {
                        location.reload();
                    }, 1000);

                } else if (data.status != 'SUCCESS'){
                    $('#delete').modal('hide');

                    new Noty({
                        text: 'Department not deleted.',
                        type: 'warning'
                    }).show();
                }


              }

              });
        });

      }
  </script>
@endpush

