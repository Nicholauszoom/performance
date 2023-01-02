@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')

<script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<?php
  ////$CI_Model = get_instance();
  //$CI_Model->load->model('flexperformance_model');
?>


        <!-- page content -->
         <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
            <h5 class="mb-0">User Activity Logs</h5>


                    <?php if(!empty($logs) && session('mng_audit')){ ?><a href="<?php echo url('flex/export_audit_logs/');?>"
                      title="Export and Delete"
                       class="icon-2 info-tooltip"
                       target="_blank">
                       <button   type="button"
                    class="btn btn-perfrom"
                    data-bs-toggle="modal"
                    data-bs-target="#save_department">
              PURELOGS

          </button>
           </div>
                      </a> <?php } ?>
                    </h5>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                  <div id="feedBack"></div>
                    <table id="datatable" class="table datatable-basic">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Employee Name</th>
                          <th>Position</th>
                          <th>Action Description</th>
                          <th>Agent</th>
                          <th>Time</th>
                        </tr>
                      </thead>

                      <tbody id="list">
                        <?php
                        $sno = 1;
                        foreach ($logs as $key => $row) { ?>
                          <tr id="domain<?php echo $row->id;?>">
                            <td width="1px"><?php echo $sno; ?></td>
                            <td width="30px"><b>
                            <a title="More Details"><?php echo $row->empName; ?></a></b> </td>
                            <td><?php echo "<b>Department: </b>".$row->department."<br><b>Position: </b>".$row->position; ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo "<b>Platform: </b>".$row->platform."<br><b>Agent: </b>".$row->agent; ?></td>
                            <td><?php echo "<b>Date: </b>".$row->dated."<br><b>Time: </b>".$row->timed; ?></td>

                           </tr>
                          <?php $sno++; }  ?>
                        <?php
                        foreach ($purge_logs as $key => $row) { ?>
                            <tr id="domain<?php echo $row->id;?>">
                                <td width="1px"><?php echo $sno; ?></td>
                                <td width="30px"><b>
                                        <a title="More Details"><?php echo $row->empName; ?></a></b> </td>
                                <td><?php echo "<b>Department: </b>".$row->department."<br><b>Position: </b>".$row->position; ?></td>
                                <td><?php echo $row->description; ?></td>
                                <td><?php echo "<b>Platform: </b>".$row->platform."<br><b>Agent: </b>".$row->agent; ?></td>
                                <td><?php echo "<b>Date: </b>".$row->dated."<br><b>Time: </b>".$row->timed; ?></td>

                            </tr>
                        <?php $sno++;  }  ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>




        <!-- /page content -->



<script type="text/javascript">


$('#purge_btn').on('click',function () {
    setTimeout(function() {
          location.reload();
        }, 1000);
});

function exportLogs()
    {
        if (confirm("Are You Sure You Want To Export and Delete This Audit Trails?") == true) {
        var id = id;

        $.ajax({
            url:"<?php echo url('flex/export_audit_logs/');?>",
            success:function(data)
            {
            // alert("Sussess!");
            // setTimeout(function() {
            //       location.reload();
            //     }, 2000);

          }


            });
        }
    }
</script>






 @endsection
