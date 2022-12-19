@extends('layouts.vertical', ['title' => 'Update P.A.Y.E'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<div class="mb-3">
    <h4 class="text-main">P.A.Y.E</h4>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-main">Update P.A.Y.E</h3>
            </div>

            <div class="card-body">
                <div id="feedBackSubmission"></div>

                <?php
                    if (isset($paye)){
                        foreach ($paye as $row) {
                            $minimum=$row->minimum;
                            $maximum=$row->maximum;
                            $id=$row->id;
                            $rate=$row->rate;
                            $excess=$row->excess_added;
                        }
                    }
                ?>

                <form autocomplete="off" id="updatePAYE"  method="post" data-parsley-validate class="form-horizontal form-label-left">

                    <input type="text" name="payeID" value="<?php echo $id; ?>" hidden >

                    <div class="mb-3">
                        <label class="control-label" for="first-name">Minimum Aomunt<span class="text-danger">*</span></label>
                        <input required="" type="number" min="0" max="100000000" step="1"  value="<?php echo $minimum; ?>" name="minimum"  class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="control-label">Maximum Amount <span class="text-danger">*</span></label>
                        <input required="" type="number" min="0" max="100000000" step="1" value="<?php echo $maximum; ?>" name="maximum" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="control-label" >Excess Amount Added<span class="text-danger">*</span></label>
                        <input required="" type="number" min="0" max="100000000" step="1" value="<?php echo $excess; ?>" name="excess"  class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="control-label" >Percent Contribution with Respect to the Amount that Exceed Minimum Range<span class="text-danger">*</span></label>
                        <input required="" type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate); ?>" name="rate"  class="form-control">
                    </div>
                    <!-- <div class="ln_solid"></div> -->
                    <div class="mb-3">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {{-- <button type="submit" class="btn btn-primary">Cancel</button> --}}
                            <button class="btn btn-main">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@push('footer-script')
<script type="text/javascript">
    $('#updatePAYE').submit(function(e){
        e.preventDefault(); // Prevent Default Submission

        $.ajax({
            url: '{{ url("/flex/updatepaye") }}',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: $(this).serialize(), // it will serialize the form data
            dataType: 'json'
        })
        .done(function(data){
            alert(data.title);

            if(data.status == 'OK'){
                // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload()// then reload the page.(3)
                }, 2000);

            } else{
                  // alert(data.title);
                $('#feedBackSubmission').fadeOut('fast', function(){
                    $('#feedBackSubmission').fadeIn('fast').html(data.message);
                });
            }
        })
        .fail(function(){
            alert('UPDATION Failed, Review Your Network Connection...');
        });

    });
</script>
@endpush
