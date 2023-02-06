@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<?php
?>


        <!-- page content -->
        <div class="right_col " role="main">
          <div class="">
            <div class="card">
                <ul class="nav nav-tabs nav-tabs-underline nav-justified mb-3" id="tabs-target-right" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ url('/flex/financial_group')}}" class="nav-link "
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Packages
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ url('/flex/allowance_overtime')}}" class="nav-link active show" aria-selected="false" role="tab"
                            tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Overtime
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="{{ url('/flex/allowance')}}" class="nav-link"
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Allowance
                        </a>
                    </li>


                    <li class="nav-item" role="presentation">
                        <a href="{{ url('/flex/statutory_deductions')}}" class="nav-link "
                            aria-selected="false" role="tab" tabindex="-1">
                            <i class="ph-list me-2"></i>
                            Statutory Deductions
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a href="{{ url('/flex/non_statutory_deductions')}}" class="nav-link "
                          aria-selected="false" role="tab" tabindex="-1">
                          <i class="ph-list me-2"></i>
                          Non Statutory Deductions
                      </a>
                  </li>

                </ul>
            </div>
            <div class="clearfix"></div>


            <?php

            foreach($category as $row){
                $categoryID = $row->id;
                $name = $row->name;
                $day_percent = $row->day_percent;
                $night_percent = $row->night_percent;
                $state = $row->state;
            }

            ?>
            <!--START Overtimes-->
            {{-- <div class="row">
              <!-- Groups -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <div id ="feedBackAssignment"></div>
                      <h5> Name:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                    <h5>Day Hours Rate:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo (100*$day_percent); ?> Tsh</b>
                    <h5>Night Hours Rate:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo (100*$night_percent); ?> Tsh</b>
                    </h5>
                    <br>
                  </div>
                </div>
              </div>
              <!-- Groups -->

              <!--UPDATE-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <div id ="feedBackSubmission"></div>
                      <form autocomplete="off" id="updateOvertimeName" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                            <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="text" name ="name" value="<?php echo $name; ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-main">Update Name</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateRateDay" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="number" step="0.01" name="day_percent" step ="1" min="0.01" max="300" value="<?php echo (100*$day_percent); ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-main">UPDATE DAY RATE</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                      <form autocomplete="off"  id="updateRateNight" class="form-horizontal form-label-left">
                      <div class="form-group">
                        <div class="col-sm-9">
                          <div class="input-group">
                              <input hidden name ="categoryID" value="<?php echo $categoryID; ?>">
                            <input required="" type="number" step="0.01" name="night_percent" step ="1" min="0.01" max="300" value="<?php echo (100*$night_percent); ?>" class="form-control">
                            <span class="input-group-btn">
                              <button  class="btn btn-main">UPDATE NIGHT RATE</button>
                            </span>
                          </div>
                        </div>
                      </div>
                      </form>
                  </div>
                </div>
              </div>
              <!--UPDATE-->
            </div> <!--end row Overtimes --> --}}

            <div class="row">
              <div class="card border-top border-bottom border-bottom-width-3 border-top-width-3 border-top-main border-bottom-main rounded-0col-md-6">
                  <div class="card-header">
                      <h5 class="mb-0">Details</h5>
                  </div>

                  <div class="table-responsive">
                      <tbody>
                          <table class="table table-bordered">
                              <tr>
                                  <th>Name</th>
                                  <td>{{ $name }}</td>
                              </tr>
                              <tr>
                                  <th>Day Hours Rate:</th>
                                  <td>{{ $day_percent }}</td>
                              </tr>
                              <tr>
                                  <th>Night Hours Rate</th>
                                  <td>{{$night_percent }}</td>
                              </tr>

                      </tbody>
                      </table>
                  </div>
              </div>
              <!-- Groups -->

              <!--UPDATE-->
              <div class="col-lg-6">
                  <div class="card">
                      <div class="card-header">
                          <h6 class="mb-0">Update</h6>
                      </div>

                      <div class="card-body">
                          @if (Session::has('success'))
                              <div class="alert alert-success" role="alert">
                                  <p>{{ Session::get('success') }}</p>
                              </div>
                          @endif
                          <form action="{{ route('flex.updateOvertimeName') }}" method="POST"
                              class="form-horizontal">
                              @csrf
                              <div class="mb-3">
                                  <div class="d-md-flex">
                                      <div class="col-sm-8">
                                          <input type="hidden" name='categoryID' value="{{ $categoryID }}"
                                              class="form-control">
                                          <input type="text" value="{{ $name }}" name="name"
                                              class="form-control">
                                      </div>
                                      <div class="btn-group flex-shrink-0 ms-md-3">
                                          <button type="submit" class="btn btn-perfrom multiselect-order-options-button"
                                              id="updateLevelName">Update Name</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <form action="{{ route('flex.updateOvertimeRateDay') }}" method="POST" class="form-horizontal">
                              @csrf
                              <div class="mb-3">
                                  <div class="d-md-flex">
                                      <div class="col-sm-7">
                                          <input type="hidden" name='categoryID' value="{{ $categoryID }}"
                                              class="form-control">
                                          <input type="number" min="0" name="day_percent" value="{{ $day_percent }}"
                                              class="form-control">
                                      </div>
                                      <div class="btn-group flex-shrink-0 ms-md-3">
                                          <button type="submit"
                                              class="btn btn-perfrom multiselect-order-options-button">Update Day Rate</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <form action="{{ route('flex.updateOvertimeRateNight') }}" method="POST" class="form-horizontal">
                              @csrf
                              <div class="mb-3">
                                  <div class="d-md-flex">
                                      <div class="col-sm-7">
                                          <input type="hidden" name='categoryID' value="{{ $categoryID }}"
                                              class="form-control">
                                          <input type="number" min="0" name="night_percent" value="{{ $night_percent }}"
                                              class="form-control">
                                      </div>
                                      <div class="btn-group flex-shrink-0 ms-md-3">
                                          <button type="submit"
                                              class="btn btn-perfrom multiselect-order-options-button">Update Night Rate</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>


              {{-- <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                      <div class="card-head">
                          <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                          <div class="clearfix"></div>
                      </div>
                      <div class="card-body">
                          <div id="feedBackSubmission"></div>
                          <form autocomplete="off" id="updateLevelName" class="form-horizontal form-label-left">
                              <div class="form-group">
                                  <div class="col-sm-9">
                                      <div class="input-group">
                                          <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                          <input required="" type="text" name="name" value="<?php echo $name; ?>"
                                              class="form-control">
                                          <span class="input-group-btn">
                                              <button class="btn btn-main">Update Name</button>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </form>


                          <form autocomplete="off" id="updateMinSalary" class="form-horizontal form-label-left">
                              {{-- <div class="row mb-3">
                              <div class="col-lg-9">
                                  <div class="d-md-flex">
                                      <div class="flex-grow-1">
                                          <div class="form-group">
                                              <label class="">Contract Name</label>
                                              <input type="text" class="form-control" name="name" required>
                                          </div>
                                      </div>

                                      <div class="btn-group flex-shrink-0 ms-md-3">
                                          <button type="button"
                                              class="btn btn-main multiselect-order-options-button">Order</button>
                                      </div>
                                  </div>
                              </div>
                          </div}}>
                              <div class="form-group">
                                  <div class="col-sm-9">
                                      <div class="input-group">
                                          <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                          <input required="" type="number" step="0.01" name="minSalary"
                                              step="1" min="1" max="1000000000" value="<?php echo $minSalary; ?>"
                                              class="form-control">
                                          <span class="input-group-btn">
                                              <button class="btn btn-main">UPDATE MIN SALARY</button>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <form autocomplete="off" id="updateMaxSalary" class="form-horizontal form-label-left">
                              <div class="form-group">
                                  <div class="col-sm-9">
                                      <div class="input-group">
                                          <input hidden name="levelID" value="<?php echo $levelID; ?>">
                                          <input required="" type="number" step="1" name="maxSalary"
                                              step="1" min="1" max="1000000000" value="<?php echo $maxSalary; ?>"
                                              class="form-control">
                                          <span class="input-group-btn">
                                              <button class="btn btn-main">UPDATE MAX SALARY</button>
                                          </span>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div> --}}
          </div>

            <!--END DEDUCTION-->
            <?php  //} ?>


          </div>
        </div>


        <!-- /page content -->

{{--
  <?php
//@include("app/includes/update_deductions")

<script type="text/javascript">
    $('#updateOvertimeName').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateOvertimeName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });


        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script>
<script type="text/javascript">
    $('#updateRateDay').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateOvertimeRateDay",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });


        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script>
<script type="text/javascript">
    $('#updateRateNight').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateOvertimeRateNight",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });


        setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script> --}}
 @endsection
