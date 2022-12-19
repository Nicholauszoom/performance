



@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
@endpush

@push('head-scriptTwo')
@endpush

@section('content')

<div class="mb-3">
    <h3 class="text-main">Deductions</h3>
</div>

<div class="row">
    <div class="col-md-6 offser-3">

        <div class="card">
            <div class="card-header">
                <h4 class="text-main">Update Deduction</h4>
            </div>

            <div class="card-body">

                <?php
                    if (isset($deductions)){
                        foreach ($deductions as $row) {
                        $name=$row->name;
                        $deductionID=$row->id;
                        $rate_employer=$row->rate_employer;
                        $rate_employee = $row->rate_employee;
                        }
                    }

                ?>

                <form autocomplete="off" id="updateDeductions" method="post" data-parsley-validate class="form-horizontal form-label-left">

                    <div class="mb-3">
                        <label class="form-label" for="first-name"> Name <span class="text-danger">*</span></label>
                        <input hidden name = "deductionID" value="<?php echo $deductionID; ?>">
                        <input  type="text"   value="<?php echo $name; ?>" name="name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Amount Contributed by Employer<span class="text-danger">*</span></label>
                        <input required="" type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate_employer); ?>" name="rate_employer" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" >Amount Contributed by Employee <span class="text-danger">*</span></label>
                        <input required=""  type="number" min="0" max="99" step="0.1" value="<?php echo 100*($rate_employee); ?>" name="rate_employee"  class="form-control">
                    </div>
                <!-- <div class="ln_solid"></div> -->

                    <div class="mb-3">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {{-- <button type="reset" class="btn btn-primary">Cancel</button> --}}
                            <button type="submit"  class="btn btn-main">Update</button>
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
        $('#updateDeductions').submit(function(e){

            e.preventDefault(); // Prevent Default Submission

            $.ajax({
                url: '{{ url("/flex/updateCommonDeductions/") }}',
                type: 'POST',
                data: $(this).serialize(), // it will serialize the form data
                dataType: 'html'
            })
            .done(function(data){
                var regex = /(<([^>]+)>)/ig
                var body = data
                var result = body.replace(regex, "");
                alert(result);
                $('#feedback').fadeOut('fast', function(){
                    $('#feedback').fadeIn('fast').html(data);
                });
                // location.reload();
            })
            .fail(function(){
                alert('Updation Failed!');
            });
        
        });
    </script>
@endpush
