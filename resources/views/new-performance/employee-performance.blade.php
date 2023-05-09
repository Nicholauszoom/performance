@extends('layouts.vertical', ['title' => 'Employee List'])

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
            <div class="d-flex justify-content-between">
                <h5 class="mb-0 text-warning">Name: <small class="text-main">{{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }} </small></h5>
                {{-- <h5 class="mb-0 text-warning">Name: <small class="text-main">{{ $employee->position }}</small></h5> --}}


            </div>
            <a href="{{ url('flex/save-evaluation/'.$employee->emp_id) }}" class="btn btn-sm btn-main float-end"> New Evaluation </a>
       
           
       
        </div>
        <hr>
        <div id="save_termination" class="" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    @if (session('msg'))
                        <div class="alert alert-success col-md-8 mx-auto" role="alert">
                            {{ session('msg') }}
                        </div>
                    @endif

                    <table class="table datatable-basic">
                        <thead>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Employee</th>
                           
                            <th>Actions</th>
                            <th hidden></th>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @forelse ($evaluations as $item )
                                <tr>
                                    <td>{{ $i++}}</td>
                                  
                                    <td>{{ date('d-M-Y',$item->creates_at)}}</td>
                                    @php
                                        $user = APP\Models\User::where('emp_id',$item->empID)->first();
                                    @endphp
                                    <td>{{ $user->fname}}  {{ $user->lname}}</td>
                                 
                                    <td>
                                        <a href="{{ route('flex.show_evaluation',$item->id) }}" class="btn btn-sm btn-main">
                                            <i class="ph-pen"></i>
                                        </a>
    
                                        <a href="javascript:void(0)" title="Cancel" class="icon-2 info-tooltip"
                                        onclick="deleteHoliday(<?php echo $item->id; ?>)">
                                        <button class="btn btn-danger btn-sm"><i class="ph-trash"></i> </button>
                                         </a>
    
                                    </td>
                                    <td hidden>
    
                                    </td>
                                </tr>
                            @empty
    
                            @endforelse
                        </tbody>
                    </table>
                 

                </div>
            </div>
        </div>


    </div>
@endsection

@push('footer-script')
    <script>
        $('#docNo').change(function() {
            var id = $(this).val();
            var url = '{{ route('getDetails', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {

                        document.getElementById("oldsalary").value = response.salary;
                        document.getElementById("oldRate").value = response.rate;

                        $('#salary').val(response.salary + ' ' + response.currency);
                        $('#oldLevel').val(response.emp_level);
                        $('#oldPosition').val(response.position.name);
                    }
                }
            });
        });
    </script>
@endpush
