@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Countries</h5>
                <button type="button"
                 class="btn btn-perfrom"
                  data-bs-toggle="modal"
                   data-bs-target="#addCountry">
                    <i class="ph-plus me-2"></i>Add Country
                </button>
            </div>

        </div>

        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Country Code</th>
                    <?php if(session('mng_org')){ ?>
                    <th>Option</th>
                    <th></th>
                    <th></th>
                    <?php } ?>
                </tr>
            </thead>


            <tbody>
                <?php
                          foreach ($nationality as $row) { ?>
                <tr id="domain<?php echo $row->id; ?>">
                    <td width="1px"><?php echo $row->SNo; ?></td>
                    <td><b><?php echo $row->name; ?> </b> </td>
                    <td><b>+<?php echo $row->code; ?> </b> </td>

                    <?php if(session('mng_org')){ ?>
                    <td class="options-width">
                        <?php
                            // $checkEmployee = $CI_Model->flexperformance_model->checkEmployeeNationality($row->code);
                            $checkEmployee = [];
                            if($checkEmployee>0){ ?>
                        <a title="Country Can Not Be Deleted, Some Employee Have Nationality From This Country"
                            class="icon-2 info-tooltip"><button disabled="" type="button"
                                class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> </a>
                        <?php } else { ?>

                        <a href="javascript:void(0)" onclick="deleteCounty(<?php echo $row->code; ?>)" title="Delete Country"
                            class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i
                                    class="fa fa-trash-o"></i></button> </a>
                        <?php } ?>

                    </td>
                    <td></td>
                    <td></td>
                    <?php } ?>
                </tr>
                <?php }  ?>
            </tbody>
        </table>
    </div>



    <!-- /page content -->
@endsection
@section('modal')
    @include('app.modal.addCountry')
@endsection
