@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')
    <!-- page content -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Banks</h5>
                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#add-bank">
                    <i class="ph-plus me-2"></i>Add Banks
                </button>
            </div>
        </div>
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Option</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>


            <tbody>
                @foreach ($banks as $row)
                    <tr id="domain">
                        <td width="1px">{{ $row->SNo }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->bank_code }}</td>
                        <td class="options-width">
                            <a href="<?php echo url(''); ?>/flex/updateBank/?category=1&id=".base64_encode{{ $row->id }};
                                <button type="button" class="btn btn-info btn-xs">
                                  <i class="fa fa-info-circle"></i></button> </a>
                            <a href="javascript:void(0)" onclick="deleteBank(<?php echo $row->id; ?>)" title="Delete"
                                class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i
                                        class="fa fa-trash-o"></i></button> </a>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Branches</h5>
                <button type="button" class="btn btn-perfrom" data-bs-toggle="modal" data-bs-target="#add-branch">
                    <i class="ph-plus me-2"></i>Add Branch
                </button>
            </div>
        </div>
        <table id="dataTables" class="table datatable-basic">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Bank Name</th>
                    <th>Branch Name</th>
                    <th>Location</th>
                    <th>Branch Code</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branch as $row)
                    <tr id="domain {{ $row->id }}">
                        <td width="1px">{{ $row->SNo }}</td>
                        <td>{{ $row->bankname }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->country }}<br>{{ $row->region }}</td>
                        <td>{{ $row->branch_code }}</td>
                        <td class="options-width">
                            <a href="{{ url('') }}/flex/updateBank/?category=2&id=".base64_encode{{ $row->id }}
                                <button type="button" class="btn btn-info btn-xs"><i
                                    class="fa fa-info-circle"></i></button> </a>
                            <a href="javascript:void(0)" onclick="deleteBank(<?php echo $row->id; ?>)" title="Delete"
                                class="icon-2 info-tooltip"><button type="button" class="btn btn-danger btn-xs"><i
                                        class="fa fa-trash-o"></i></button> </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal')
    <div>
        @include('app.modal.add-bank')

    </div>

    @include('app.modal.add-branch')
@endsection

@push('footer-script')
    <script type="text/javascript">
        $('#add-branch').submit(function(e) {

            e.preventDefault(); // Prevent Default Submission

            $.ajax({
                    url: "<?php echo url(''); ?>/flex/addBankBranch",
                    type: 'POST',
                    data: $(this).serialize(), // it will serialize the form data
                    dataType: 'json'
                })
                .done(function(data) {

                    if (data.status == 'OK') {
                        var regex = /(<([^>]+)>)/ig
                        var body = data.message;
                        var result = body.replace(regex, "");
                        alert(result);
                        $('#feedbackBankBranch').fadeOut('fast', function() {
                            $('#feedbackBankBranch').fadeIn('fast').html(data.message);
                        });
                        $('#add-branch')[0].reset();
                        $("#branchList").load(" #branchList"); // then reload the div to clear the
                        /*setTimeout(function(){// wait for 5 secs(2)
                   location.reload();
                }, 2000);*/

                    } else {
                        alert(data.message);
                        $('#feedbackBankBranch').fadeOut('fast', function() {
                            $('#feedbackBankBranch').fadeIn('fast').html(data.message);
                        });
                    }
                })
                .fail(function() {
                    alert('FAILED to add Branch, Review Your Network Connection...');
                });

        });
    </script>
@endpush
