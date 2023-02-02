@extends('layouts.vertical', ['title' => 'Email Notifications'])

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
            <h6 class="mb-0 text-muted">Email Notifications</h6>


        </div>
    <hr>
    </div>
    <div class="row mx-1">
        <div class="col-12">
            @if (session('msg'))
            <div class="alert alert-success mx-auto" role="alert">
            {{ session('msg') }}
            </div>
            @endif
            <div class="">
                <table class="table datatable-basic">
                    <thead>
                        <th>SN</th>
                        <th>Email Type</th>
                        <th>Receiving Email</th>
                        <th>Actions</th>
                        <th hidden></th>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $item )
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{ $item->name}}</td>
                                <td>
                                    <form
                                    action="{{ url('flex/update-email-notification')}}"
                                    method="POST"
                                    
                                >
                                    @csrf
                                    @method('PUT')

                                                    <input type="hidden" name="name" disabled   value="{{ $item->name }}"  class="form-control disable" placeholder="Enter Holiday Name">
                                                    <input type="hidden" name="id"  value="{{ $item->id }} " >


                                                    <input type="checkbox"  name="status"  id="{{ $item->id }}"  {{ $item->status=='1'? 'checked':'' }}  class="">

                                                    <label for="{{ $item->id }}" class="form-label">{{ $item->status=='1'? 'Yes':'No' }}</label>
                                </td>
                                <td>

                                        <button type="submit" class="btn btn-perfrom btn-sm">Update </button>

                                </form>

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


