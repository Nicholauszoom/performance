@extends('layouts.vertical', ['title' => 'Holidays'])

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

<div class="card">
    <div class="card-header border-0">
        <div class="">
            <h5 class="mb-0 text-muted">Holidays</h5>

               
        </div>
    <hr>
    </div>
    <div class="row mx-1">
        <div class="col-12">
            <div class="card">
                <table class="table table-bordered datatable-basic">
                    <thead>
                        <th>SN</th>
                        <th>Holiday</th>
                        <th>Date</th>
                        <th>Recurring</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($holidays as $item )
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->date}}</td>
                                <td>{{ $item->recurring=='1'? 'Yes':'No' }}</td>
                                <td>
                                    <a href="{{ route('flex.editholiday', base64_encode($item->id)) }}" class="btn btn-sm btn-info">
                                        <i class="ph-pen"></i>
                                    </a>
                            
                                </td>
                                <td>
                                    <a href="{{ route('flex.deleteholiday',$item->id) }}" class="btn btn-sm btn-danger">
                                        <i class="ph-trash"></i>
                                        </a>
                                </td>
                            </tr>
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div> 
        
        
        <div id="save_termination" class="col-12" tabindex="-1">
            <div class="card p-1">
                <div class="card-header">
                    <h6>Add Holiday</h6>
                </div>
                <div class="modal-content">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form
                        action="{{ route('flex.saveHoliday') }}"
                        method="POST"
                        class="form-horizontal"
                    >
                        @csrf

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Name:</label>
                                        <input type="text" name="name" id="" class="form-control" placeholder="Enter Holiday Name">
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Date:</label>
                                        <input type="date" name="date" id="" class="form-control" placeholder="Enter Date of Charge">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-12">
                                    <div class="mb-1">
                                        
                                        <label for="recurring" class="form-label">Holiday Recurring:</label>
                                        <input type="checkbox" name="recurring" id="recurring" class="check">
                                    </div>
                                </div>

                                

                        </div>


                        </div>

                        <div class="modal-footer">
                            <hr>

                            <button type="submit" class="btn btn-perfrom mb-2 mt-2">Save Holiday</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  


</div>




@endsection

@push('footer-script')

<script>

$('#docNo').change(function(){
    var id = $(this).val();
    var url = '{{ route("getDetails", ":id") }}';
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        success: function(response){
            if(response != null){
                $('#salary').val(response.salary+' '+response.currency);
                $('#oldLevel').val(response.emp_level);
                $('#oldPosition').val(response.position.name);
            }
        }
    });
});


</script>


@endpush


