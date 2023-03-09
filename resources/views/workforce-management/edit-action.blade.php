@extends('layouts.vertical', ['title' => 'Add Complain'])

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
        <div class="d-flex justify-content-between">
            <h5 class="mb-0 text-muted">Update Disciplinary Action</h5>

                <a href="{{ route('flex.grievancesCompain') }}" class="btn btn-perfrom">
                    <i class="ph-list me-2"></i> All Disciplinary Actions
                </a>
        </div>
    <hr>
    </div>


            <div id="save_termination" class="" tabindex="-1">
                <div class="col-12 mx-auto p-2">
                    <div class="modal-content">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @foreach ($actions as $item)
                        <form
                            action="{{ url('flex/update-action/'.$item->id) }}"
                            method="POST"
                            class="form-horizontal"
                        >
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="row ">

                                            <div class="col-12">
                                                <h6>Employee Name:

                                                    <span class="text-muted font-weight-light">
                                                        {{ $item->employee->fname}} {{ $item->employee->mname}} {{ $item->employee->lname}}
                                                    </span>
                                                </h6>

                                            </div>
                                            <div class="col-12">
                                            <h6> Department Name:

                                                <span class="text-muted font-weight-light">
                                                    {{ $item->departments->name}}
                                                </span>
                                            </h6>
                                            </div>

                                            <hr>
                                        </div>

                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Suspension:</label>
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="text" name="suspension" value="{{ $item->suspension }}" class="form-control" placeholder="Enter Suspension">
                                        </div>
                                    </div>
                                    <div class="col-3 col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Charge:</label>
                                            <input type="date" name="date_of_charge" value="{{ $item->date_of_charge}}" class="form-control" placeholder="Enter Date of Charge">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Charge Description:</label>
                                            <textarea name="charge_description" id="hearing" value="{{ $item->detail_of_charge}}" class="form-control" rows="6" placeholder="Enter Charge Description..">{{ $item->detail_of_charge}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-3 col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label">Date of Hearing:</label>
                                            <input type="date" name="date_of_hearing" value="{{ $item->date_of_hearing}}" class="form-control" placeholder="Enter Date of Hearing">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Hearing Description:</label>
                                            <textarea id="description" name="hearing_description" value="{{ $item->detail_of_hearing}}" class="form-control" placeholder="Enter Hearing details here.." rows="6">{{ $item->detail_of_hearing }}</textarea>
                                        </div>
                                    </div>
                                {{-- <div class="col-md-12 col-lg-12 mb-3">
                                    <label class="form-label ">Findings</label>

                                    <textarea name="findings" id="findings" class="form-control" value="{{ $item->findings}}" placeholder="Enter Case Findings Here.." rows="4">{{ $item->findings }}</textarea>
                                        @error('findings')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div> --}}
                                <div class="col-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Recommended Sanction:</label>
                                        <input type="text" name="recommended_sanctum" value="{{ $item->recommended_sanctum}}" class="form-control" placeholder="Enter Recommended Sanction">
                                    </div>
                                </div>


                                <div class="col-md-12 col-lg-12 mb-3">
                                    <label class="form-label ">Final Decission</label>

                                    <textarea name="final_decission" value="{{ $item->final_decission}}" id="decission"  class="form-control" placeholder="Enter Final Decission Here.." rows="4">{{ $item->final_decission}}</textarea>
                                        @error('description')
                                            <p class="text-danger mt-1"> Input field Error </p>
                                        @enderror
                                </div>


                            </div>

                            @endforeach
                            </div>

                            <div class="modal-footer">
                                <hr>

                                <button type="submit" class="btn btn-perfrom mb-2 mt-2">Update Case</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


</div>




@endsection

@push('footer-script')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Summernote JS - CDN Link -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#summernote").summernote();
            $('.dropdown-toggle').dropdown();
        });
    </script>
    <!-- //Summernote JS - CDN Link -->
<script>
//     $(document).ready(function(){
//         $('#summernote').summernote({
//     placeholder: 'Add Notes Here...',
//     tabsize: 2,
//     height: 100
//   });

//         $('.dropdown-toggle').dropdown();
//     });

$('#findings').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });

$('#decission').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });

$('#reference').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });

  $('#charge').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });

  $('#hearing').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });
  $('#content').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100,
     callbacks: {
        onImageUpload: function(files) {
            url = $(this).data('upload'); //path is defined as data attribute for  textarea
            sendFile(files[0], url, $(this));
        }
    }
  });
  function sendFile(file, url, editor) {
    var data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: url,
        cache: false,
        contentType: false,
        processData: false,
        success: function(objFile) {
            editor.summernote('insertImage', objFile.folder+objFile.file);
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
    });
}
  $('#description').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });
  $('#terms').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });
  $('#privacy').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });
  $('#values').summernote({
    placeholder: 'Add content Here...',
    tabsize: 2,
    height: 100
  });

</script>

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


