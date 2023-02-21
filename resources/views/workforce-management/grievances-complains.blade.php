@extends('layouts.vertical', ['title' => ' Disciplinary Actions'])

@push('head-script')
    <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
    <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
@endpush

@section('page-header')
  @include('layouts.shared.page-header')
@endsection

@section('content')

<div class="card border-top  border-top-width-3 border-top-main rounded-0">
    <div class="card-header border-0">
        <div class="">
            <div class="row">
                <div class="col-md-9">
                    <h5 class="mb-0 text-muted text-warning"> Disciplinary Actions</h5>
                </div>
                <div class="col-md-3">
                    {{-- start of add disciplinary action button --}}
                    @can('add-grivance')
                        <a href="{{ route('flex.addDisciplinary') }}" class="btn btn-perfrom ">
                            <i class="ph-plus me-2"></i> Add Disciplinary Action
                        </a>
                    @endcan
                    {{-- / --}}
                </div>
            </div>
            <hr class="text-warning">



        </div>
    </div>
    @if (session('msg'))
    <div class="alert alert-success col-md-10 mx-auto" role="alert">
    {{ session('msg') }}
    </div>
    @endif
    <table class="table table-striped table-bordered datatable-basic">
        <thead>
            <tr>
                <th>SN</th>
                <th>Employee Name</th>
                <th>Department</th>
                {{-- <th>Suspension</th> --}}
                <th>Charge Date</th>
                <th >Action</th>
                <th hidden></th>
            </tr>
        </thead>

        <tbody>
               @foreach ($actions as $item)
            <tr>
            <td>{{$i++}}</td>
             <td>{{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}</td>
             <td>{{ $item->departments->name}}</td>
             {{-- <td>  {{ $item->suspension}}  </td> --}}
             <td> {{ $item->date_of_charge}}</td>
             <td>
                <a  href="{{ route('flex.viewDisciplinary', base64_encode($item->id)) }}"  title="Info and Details">
                    <button type="button" class="btn btn-sm btn-main btn-xs"><i class="ph-info"></i></button>
                </a>
                @can('edit-grivance')
                <a href="{{ route('flex.editDisciplinary', base64_encode($item->id)) }}" class="btn btn-main btn-sm">
                    <i class="ph-pen"></i>
                </a>
                @endcan

                @can('delete-grivance')
                <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                onclick="cancelTermination(<?php echo $item->id; ?>)">
                <button class="btn btn-danger btn-sm">  <i class="ph-trash"></i></button>
                 </a>
                @endcan
             </td>
             <td hidden>

             </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('footer-script')
    {{-- @include("app.includes.overtime_operations") --}}

    <script>
      


        function cancelTermination(id) {

            Swal.fire({
                title: 'Are You Sure You Want to Delete This Disciplinary Action?',
                // text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var terminationid = id;

                    $.ajax({
                        url: "{{ url('flex/delete-disciplinary') }}/" + terminationid
                    })
                    .done(function(data) {
                        $('#resultfeedOvertime').fadeOut('fast', function() {
                            $('#resultfeedOvertime').fadeIn('fast').html(data);
                        });

                        $('#status' + id).fadeOut('fast', function() {
                            $('#status' + id).fadeIn('fast').html(
                                '<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>'
                                );
                        });

                        // alert('Request Cancelled Successifully!! ...');

                        Swal.fire(
                            'Cancelled!',
                            'Disciplinary Action Deleted Successifully!!.',
                            'success'
                        )

                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    })
                    .fail(function() {
                        Swal.fire(
                            'Failed!',
                            'Disciplinary Action deletion  Failed!! ....',
                            'success'
                        )

                        alert('Disciplinary Action deletion Failed!! ...');
                    });
                }
            });

          
        }
    </script>



 

@endpush

