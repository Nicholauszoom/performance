@extends('layouts.vertical', ['title' => 'Financial Settings'])

@push('head-script')
  <script src="{{ asset('assets/js/components/notifications/bootbox.min.js') }}"></script>
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/components_modals.js') }}"></script>
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<div class="row">

  <div class="col-md-12 col-lg-12 col-sm-6">

    <div class="card border-toadd-financp  border-top-width-3 border-top-main rounded-0 p-2">
       @include('app.headers_payroll_input')

        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="text-main lead">
                    Packages <br> <small>Allowances, Bonuses and Deductions</small>
                </h5>

                @can('add-package-group')   
                <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#add-finance-group">
                    <i class="ph-plus me-2"></i>New Group
                </button>
                @endcan

            </div>
        </div>

        <table  class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Grouped By</th>
                    <?php if($pendingPayroll==0 ){ ?>
                    <th>Option</th>
                    <?php } ?>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($financialgroups as $row) { ?>
                    
                    <tr id = "recordFinanceGroup<?php echo $row->id; ?>">
                        <td width="1px"><?php echo $row->SNo; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td>@if($row->grouped_by == 1) Employee @else Role @endif</td>

                        <?php if($pendingPayroll==0 ){ ?>
                        <td class="options-width">
                            <?php if($row->type>0){ ?>
                            {{-- @if($row->grouped_by == 1)  --}}
                            <a  href="<?php echo  url(''); ?>/flex/financial_groups_details/<?php echo base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip">
                                <button type="button" class="btn btn-main btn-xs"><i class="ph-info me-2"></i> By Emp</button>
                            </a>
                            {{-- @else  --}}
                            <a  href="<?php echo  url(''); ?>/flex/financial_groups_byRole_details/<?php echo base64_encode($row->id); ?>" title="Info and Details" class="icon-2 info-tooltip">
                                <button type="button" class="btn btn-main btn-xs"><i class="ph-info me-2"></i> By Role</button>
                            </a>
                            {{-- @endif --}}
                            <a href="javascript:void(0)" onclick="deleteFinanceGroup(<?php echo $row->id; ?>)" title="Delete" class="icon-2 info-tooltip">
                                <button type="button" class="btn btn-danger btn-xs"><i class="ph-trash"></i></button>
                            </a>
                            <?php } ?>
                        </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
      </table>
    </div>
  </div>
  {{-- /col --}}
</div>

@endsection


@section('modal')
  
        <div>
            @include('app.modal.add-role-group')
        </div>

        <div>
            @include('app.modal.add-role')
        </div>

        <div>
            @include('app.modal.finance-group')
        </div>
  
@endsection


@push('footer-script')

<script type="text/javascript">

    function deleteRole(id)
    {
        if (confirm("Are You Sure You Want To Delete This Role?") == true) {

            var id = id;

            $.ajax({
                url:"<?php echo url('flex/deleteRole');?>/"+id,
                success:function(data)
                {
                    if(data.status == 'OK'){
                        alert("DELETED Successifully");
                        $('#feedBackRole').fadeOut('fast', function(){
                        $('#feedBackRole').fadeIn('fast').html(data.message);
                    });

                    $('#recordRole'+id).hide();
                }else{
                    alert("FAILED: Delete failed Please Try again");
                }
              }
            });
        }
    }


    function deleteRoleGroup(id)
    {
        if (confirm("Are You Sure You Want To Delete This Group?") == true) {
            var id = id;

            $.ajax({
                url:"<?php echo url('flex/deleteGroup');?>/"+id,
                success:function(data)
                {

                    var data = JSON.parse(data);
                    if(data.status == 'OK'){
                        alert("Group DELETED Successifully");
                        $('#feedBackRoleGroup').fadeOut('fast', function(){
                            $('#feedBackRoleGroup').fadeIn('fast').html(data.message);
                        });
                        $('#recordRoleGroup'+id).hide();

                    }else{
                        alert("FAILED: Delete failed Please Try again");
                    }
                }
            });
        }
    }


    function deleteFinanceGroup(id)
    {
        if (confirm("Are You Sure You Want To Delete This Group?") == true)
        {
            var id = id;

            $.ajax({
                url:"<?php echo url('flex/deleteGroup');?>/"+id,
                success:function(data)
                {
                    var data = JSON.parse(data);
                    if(data.status == 'OK'){
                        alert("Group DELETED Successifully");
                        $('#feedBackFinanceGroup').fadeOut('fast', function(){
                            $('#feedBackFinanceGroup').fadeIn('fast').html(data.message);
                        });
                        $('#recordFinanceGroup'+id).hide();
                    }else{
                        alert("FAILED: Delete failed Please Try again");
                    }
                }
            });
        }
    }

</script>
@endpush

