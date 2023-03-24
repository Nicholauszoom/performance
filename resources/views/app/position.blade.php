@extends('layouts.vertical', ['title' => 'Positions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
         <!--Start Tabs Content-->
          <div class="col-md-12 col-sm-6 col-xs-12">
            <div class="card border-top  border-top-width-3 border-top-main rounded-0">
              <!-- <div class="card-head">

                  <h3 class="green"></h3>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div> -->
              <div class="card-body">


    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php if(session('mng_org')){ ?>
            <div  class="col-md-12 col-lg-12 col-sm-12 col-xs-12 ">

                <div class="card border-top  border-top-width-3 border-top-main rounded-0 p-2">
                  <div class="card-head">
                    <h2 class="text-warning"><i class="fa fa-tasks"></i> Add Position</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                <div id="positionAddFeedBack"></div>

                    <form id="addPosition12" enctype="multipart/form-data" action="{{ route('flex.addPosition') }}"  method="post"  data-parsley-validate class="form-horizontal form-label-left">
                       @csrf
                      <!-- START -->
                      <div class="row">
                      <div class="form-group col-6 mb-3">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Position Name</label>
                        </label>
                        <input type="text" required="" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name" >


                      </div>
                      <div class="form-group col-6 mb-3">
                        <label class="control-label col-md-3  col-xs-6" >Organization Level</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                                <select required="" id='org' name="organization_level" class="select_level form-control">

                                   <?php foreach ($levels as $row){ ?>
                                  <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                </select>
                        </div>
                      </div>

                 
                      <div class="form-group col-6 mb-3">
                        <label class="control-label col-md-3  col-xs-6" >Department</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                                <select required="" id='dept' name="department" class="select3_single form-control">
                                <option></option>
                                   <?php foreach ($ddrop as $row){ ?>
                                  <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> <?php } ?>
                                </select>
                        </div>
                      </div>
                      <div class="form-group col-6 mb-3">
                        <label class="control-label col-md-3  col-xs-6">Reports To</label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="input-group">
                            <select required="" id="pos" name="parent" class="select1_single form-control" tabindex="-1">
                            <option></option>

                                   <?php foreach ($all_position as $row){
                                  // if ($row->name == $parent) continue;?>
                                <option value="<?php echo $row->position_code."|".$row->level; ?>"><?php echo $row->name; ?></option> <?php } ?>
                            </select>
                            </div>
                        </div>
                      </div>
                      <div class="form-group col-12 mb-3">
                        <label class="control-label" for="last-name">Purpose of This Position</label>
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="purpose" placeholder="Purpose" rows="3"></textarea>
                        </div>
                      </div> <br>
                        <div class="form-group col-8 mb-3">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                        </label>
                      
                      </div>  <br>
                      <!-- END -->
                      <div class="form-group col-4">
                        <div class="">
                          <input type="submit" class="btn btn-main form-control"/>
                        </div>
                      </div>
                      </div>
                      </form>

                  </div>
                </div>
            </div>
            <?php } ?>
        <div class="card border-top   rounded-0 ">
          <div class="card-head p-2">
            <h2 class="text-warning">List of Positions   </h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if(session('mng_org')){ ?>
            {{-- <a  href="#bottom"><button type="button"  class="btn btn-main float-end">ADD POSITION</button></a> --}}
            <?php } ?>
            <div class="clearfix"></div>
          </div>
          <div class="card-body">
             <?php //echo $this->session->flashdata("note");  ?>
             <div id="feedBackTable"></div>
            <table id="datatable" class="table table-striped table-bordered datatable-basic">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Reports To</th>
                  <th>Department</th>
                  <th hidden>Created By</th>
                  <th hidden>Date Created</th>
                  <?php if(session('mng_org')){ ?>
                  <th>Options</th>
                  <?php } ?>
                </tr>
              </thead>


              <tbody>
                <?php
                //if ($employee->num_rows() > 0){
                  foreach ($position as $row) { ?>
                  <tr id="record<?php echo $row->id;?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td width="380px"><?php echo $row->name; ?></td>
                    <td>
                        <?php if($row->id == 6) echo "Top Position"; else echo $row->parent; ?>
                    </td>
                    <td hidden></td>
                    <td hidden></td>
                    <td><b> <?php echo $row->department; ?></b></td>

                    <?php if(session('mng_org')){ ?>
                    <td class="options-width">
                        <a  href="{{ route('flex.position_info',$row->id) }}" title="Info and Details" class="icon-2 info-tooltip"><button type="button" class="btn btn-main btn-sm"><i class="ph-info"></i></button> </a>
                        <?php if($row->id!=1){ ?>
                        <a href="javascript:void(0)" onclick="deletePosition(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-sm"><i class="ph-trash"></i></button> </a>
                        <?php } ?>
                    </td>
                        <?php } ?>
                    </tr>
                  <?php } //} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>



    <!--END EDIT TAB-->

              </div>
            </div>

          </div>
        </div>
    </div>




  </div>
</div>


@endsection

@push('footer-script')
<script type="text/javascript">

  $(".select_level").select2({
          placeholder: "Select Organization Level",
          allowClear: true
        });
    $('#addPosition').submit(function(e){
        e.preventDefault();
        var maxSalary = $('#maxSalary').val();
        var minSalary = $('#minSalary').val();
        if (minSalary > maxSalary) {
          alert("Maximum Salary should be Greater Than Minimum salary");
        }else{
          $.ajax({
               url:"{{ route('flex.addPosition') }}",
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:false
           })
            .done(function(data){
              $('#positionAddFeedBack').fadeOut('fast', function(){
                  $('#positionAddFeedBack').fadeIn('fast').html(data.message);
                });
                notify('Position added successfully!', 'top', 'right', 'success');
              setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);
            })
            .fail(function(){
              alert('Request Failed!! ...');
            });
        }
    });
</script>
<script> //For Deleting records without Page Refreshing

    function deletePosition(id)
    {
        if (confirm("Are You Sure You Want To Delete This Position") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/deletePosition');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Deleted Sussessifully!");
              $('#domain'+id).hide();
              $('#feedBackTable').fadeOut('fast', function(){
              $('#feedBackTable').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Position Not Deleted, Error In Deleting");
               }


            // document.location.reload();

            }

            });
        }
    }

    function activatePosition(id)
    {
        if (confirm("Are You Sure You Want To Activate This Department") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/activatePosition');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("SUCCESS!");
              $('#domain'+id).hide();
              $('#feedBackTable2').fadeOut('fast', function(){
              $('#feedBackTable2').fadeIn('fast').html(data.message);
            });
              setTimeout(function() {
                location.reload();
              }, 1000);
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Activated, Error In Activation");
               }


            }

            });
        }
    }
</script>

@endpush


