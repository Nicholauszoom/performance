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

<div class="">
    {{-- <div class="card-header border-0">
        <div class="">
            <h5 class="mb-0 text-muted">Email Notifications</h5>


        </div>
    <hr>
    </div> --}}
    <div class="row mx-1">

        <div id="save_termination" class="col-6 mx-auto" tabindex="-1">
            <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0p-1">
                <div class="card-header">
                    <h6>Edit Email Notification</h6>
                </div>
                <div class="modal-content">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form
                        action="{{ url('flex/update-email-notification')}}"
                        method="POST"
                        class="form-horizontal"
                    >
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Holiday Name:</label>
                                        <input type="text" name="name" disabled  @if($notification) value="{{ $notification->name }}" @endif  class="form-control disable" placeholder="Enter Holiday Name">
                                        <input type="hidden" name="id" @if($notification) value="{{ $notification->id }} " @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <div class="mb-1">

                                        <label for="recurring" class="form-label">Receive Email:</label>
                                        <input type="checkbox"  name="status"  id="status" @if($notification) {{ $notification->status=='1'? 'checked':'' }} @endif class="">
                                    </div>
                                </div>



                        </div>


                        </div>

                        <div class="modal-footer">
                            <hr>

                            <button type="submit" class="btn btn-perfrom mb-2 mt-2">Update Permission</button>
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


