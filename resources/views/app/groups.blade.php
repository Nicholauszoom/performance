@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php 
  foreach ($groupInfo as $row) {
     $groupName = $row->name;
     $groupID = $row->id;
  }

?>


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Groups</h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $groupName; ?> &nbsp;&nbsp;(<b> <?php echo $headcounts; ?> Employees</b>) </h2>
                          
                    <div class="col-md-6 col-sm-12 col-xs-12">
                    <form id="updateGroup" enctype="multipart/form-data" autocomplete="off"  method="post"  data-parsley-validate class="form-horizontal form-label-left" >
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input type="text" name="group_name" value="<?php echo $groupName; ?>" class="form-control">
                              <input type="hidden" name="group_id" value="<?php echo $groupID;?>">
                              <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">UPDATE</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      </div>

                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   @if(Session::has('note'))      {{ session('note') }}  @endif  ?>
                   <div id="feedBackRemove"></div>
                    <form id="removeFromGroup"  method="post">
                    <input type="text" name="groupID" hidden="" value="<?php echo $groupID; ?>">
                    
                        <!-- </div> -->
                    <table  id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Option</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($members as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->NAME; ?></td>
                            <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                            
                            <td class="options-width">
                           <label class="containercheckbox">
                           <input type="checkbox" name="option[]" value="<?php echo $row->EGID."|".$row->ID; ?>">
                            <span class="checkmark"></span>
                          </label></td>
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-warning">Remove Selected</button>
                        </div>
                    </div>   
                    </form>
                  </div>
                  
                </div>
              </div>

              <!-- Groups -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Employees </h2><br>
                    <small><b>Mark Employees to add them in this Group</b></small>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <?php echo $this->session->flashdata("notegroup");  ?>
                   <div id="feedBackAdd"></div>
                    <form id="addToGroup" method="post">

                    <input type="text" name="groupID" hidden="" value="<?php echo $groupID; ?>">
                    <table  id="datatable-keytable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Name</th>
                          <th>Department</th>
                          <th>Mark</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php
                        // if ($department->num_rows() > 0){
                          foreach ($nonmembers as $row) { ?>
                          <tr>
                            <td width="1px"><?php echo $row->SNo; ?></td>
                            <td><?php echo $row->NAME; ?></td>
                            <td><?php echo "<b>Department: </b>".$row->DEPARTMENT."<br><b>Position: </b>".$row->POSITION; ?></td>
                            
                            <td class="options-width">
                           <label class="containercheckbox">
                           <input type="checkbox" name="option[]" value="<?php echo $row->ID; ?>">
                            <span class="checkmark"></span>
                          </label>

                           </td>
                           </td>
                            </tr>
                          <?php } //} ?>
                      </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button  class="btn btn-success">Add Selected</button>
                        </div>
                    </div>   
                        </form>
                  </div>
                </div>
              </div>
              <!-- Groups -->
            </div>

          </div>
        </div>


        <!-- /page content -->   



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

</script>

<script type="text/javascript">
    $('#removeFromGroup').submit(function(e){
        if (confirm("Are You Sure You Want To Remove The Selected Employee(s) From  This Group?") == true ) {
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/removeEmployeeFromGroup",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackRemove').fadeOut('fast', function(){
              $('#feedBackRemove').fadeIn('fast').html(data);
            });
    
     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 2000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    } 
    }); 
</script>


<script type="text/javascript">
    $('#addToGroup').submit(function(e){
        if (confirm("Are You Sure You Want To Add The selected Employee(s) Into  This Group?") == true ) {
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/addEmployeeToGroup",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAdd').fadeOut('fast', function(){
              $('#feedBackAdd').fadeIn('fast').html(data);
            });
    
     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 2000); 
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    } 
    });

    $('#updateGroup').on('submit',function (e) {
        e.preventDefault();

        $.ajax({
            url: "<?php echo url(); ?>flex/updateGroupEdit",
            type: 'POST',
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        }).done(function(data){
                if(data.status == 'OK'){
                    notify('Group updated successfully!', 'top', 'right', 'success');
                    setTimeout(function(){// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                } else{
                    notify('Group update error!', 'top', 'right', 'danger');
                    setTimeout(function(){// wait for 2 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);

                }
            }).fail(function(){
                // alert('Registration Failed, Review Your Network Connection...');
            });

    });

</script>
 @endsection