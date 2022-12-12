
@extends('layouts.vertical', ['title' => 'Workforce Managemen'])

@push('head-script')
  <script src="{{ asset('assets/js/components/tables/datatables/datatables.min.js') }}"></script>

  <script src="{{ asset('assets/js/components/ui/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/components/pickers/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/js/components/pickers/datepicker.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
  <script src="{{ asset('assets/js/pages/datatables_basic.js') }}"></script>
@endpush

@section('content')

<section id="apply_imprest">
  <div class="row">
    <div class="col-md-6 offset-3">
      <div class="card">
        <div class="card-header">
          <h5 class="text-muted">Request Imprest</h5>
        </div>

        <div class="card-body">
          <form
            id="requestImprest"
            enctype="multipart/form-data"
            method="post"
            data-parsley-validate
            autocomplete="off"
          >

            <div class="row mb-3">
              <label class="col-form-label col-md-3 col-sm-3 col-xs-12">Imprest Name <span class="text-danger">*</span>
              </label>
              <div class="col-sm-9">
                <textarea required class="form-control" name="title" rows="2" placeholder='Name'></textarea>
              </div>
            </div>


            <div class="row mb-3">
              <label class="col-form-label col-sm-3">Description <span class="text-danger">*</span>
              </label>
              <div class="col-sm-9">
                <textarea required class="form-control" name="description" rows="3" cols="3" re placeholder='Description'></textarea>
              </div>
            </div>

            <div class="row mb-3">
                <label class="col-form-label col-sm-3">Start Date :</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <input type="text" required  placeholder="Start Date" name="start" id="date_start" class="form-control daterange-single" >
                    </div>
                </div>
            </div>

            <div class="row mb-3">
              <label class="col-form-label col-sm-3">End Date :</label>
              <div class="col-sm-9">
                  <div class="input-group">
                      <span class="input-group-text"><i class="ph-calendar"></i></span>
                      <input type="text" required  placeholder="End Date" name="end" id="date_end" class="form-control daterange-single" >
                  </div>
              </div>
          </div>



            <div class="row">
              <div class="col-md-6 offset-9">
                <button class="btn btn-main">SEND REQUEST</button>
            </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="card">
  <div class="card-header">
    <div class="d-flex justify-content-between">
      <h4 class="text-muted">My Imprest</h4>

      <a href="apply_imprest" class="btn btn-main"> <i class="ph-plus me-2"></i> REQUEST IMPREST</a>
    </div>
  </div>


  <table id="datatable" class="table table-striped table-bordered datatable-basic">
    <thead>
      <tr>
        <th>S/N</th>
        <th>Name</th>
        <th>Description</th>
        <th>Date Requested</th>
        <th>Cost</th>
        <th>Status</th>
        <th>Option</th>
      </tr>
    </thead>


    <tbody>
      <?php
        foreach ($my_imprests as $row) { ?>
         <?php if ($row->status==5) { continue; } ?>
        <tr id="recordImprest<?php echo $row->id;?>">
          <td width="1px"><?php echo $row->SNo; ?></td>
          <td><?php echo $row->title; ?></td>
          <td>

            <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseDescription<?php echo $row->id; ?>" aria-expanded="false">
              <span class="label label-default">DESCRIPTION</span>
            </a>
            <div id="collapseDescription<?php echo $row->id; ?>" class="panel-collapse collapse" role="tabpanel" >
                <p><?php echo $row->description;  ?> </p>
            </div>

          </td>

          <td><?php echo date('d-m-Y', strtotime($row->application_date)); ?></td>

          <td><?php echo "<b><font class='green'>REQUESTED: </font></b>".number_format($row->requested_amount, 2); ?></td>

          <td>
          <div id ="status<?php echo $row->id; ?>">
          <?php if($row->status==0){ ?> <div class="col-md-12"><span class="label label-default">REQUESTED</span></div><?php }
          elseif($row->status==1){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED BY FINANCE</span></div><?php }
          elseif($row->status==9){ ?><div class="col-md-12"><span class="label label-info">RECOMENDED BY HR</span></div><?php }
          elseif($row->status==2){ ?><div class="col-md-12"><span class="label label-success">APPROVED</span></div><?php }
          elseif($row->status==3){ ?><div class="col-md-12"><span class="label label-success">CONFIRMED</span></div><?php }
          elseif($row->status==4){ ?><div class="col-md-12"><span class="label label-success">RETIRED</span></div><?php }
          elseif($row->status==5){ ?><div class="col-md-12"><span class="label label-success">RETIREMENT CONFIRMED</span></div><?php }
          elseif($row->status==6){ ?><div class="col-md-12"><span class="label label-danger">DISSAPPROVED</span></div><?php }
          elseif($row->status==7){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED</span></div><?php }
          elseif($row->status==8){ ?><div class="col-md-12"><span class="label label-danger">UNCONFIRMED RETIREMENT</span></div><?php } ?></div>

          </td>


          <td class="options-width">
          <?php
            if($row->status==0 || $row->status==1 || $row->status==6){ ?>
          <a href="javascript:void(0)" onclick="deleteImprest(<?php echo $row->id;?>)">
          <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></a>
          <?php }
          if($row->status==3){

          $pendings = $this->imprest_model->empRetiredRequirement($row->id);
              if($pendings>0){  ?>
            <a href="javascript:void(0)" onclick="empPendingRetireAlert()">
            <button class="btn btn-warning btn-xs btn-xs">Retirement</button></a>
          <?php } else { ?>

          <a href="javascript:void(0)" onclick="retirementImprest(<?php echo $row->id;?>)">
          <button class="btn btn-warning btn-xs btn-xs">Retirement</button></a>
          <?php } } if($row->status==4){  ?>

          <a href="javascript:void(0)" onclick="unretirementImprest(<?php echo $row->id;?>)">
          <button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>
          <?php }   ?>
          <a  href="<?php echo  url('')."flex/imprest/imprest_info/?id=".base64_encode($row->id); ?>"
            title="Info and Details" class="icon-2 info-tooltip">
            <button type="button" class="btn btn-info btn-xs"><i class="fa fa-info-circle"></i></button> </a>
          </td>
          </tr>
        <?php }  ?>
    </tbody>
  </table>
</div>









 @endsection

 @push('footer-script')


 @include('app.includes.imprest_operations')
 <script>
  $(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    var dateToday = dd + '-' + mm + '-' + yyyy;
    $('#date_start').daterangepicker({
      drops: 'down',
      singleDatePicker: true,
      autoUpdateInput: false,
      startDate:dateToday,
      minDate:dateToday,
      locale: {
        format: 'DD-MM-YYYY'
      },
      singleClasses: "picker_1"
    }, function(start, end, label) {
      // var years = moment().diff(start, 'years');
      // alert("The Employee is " + years+ " Years Old!");

    });
      $('#date_start').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
      $('#date_start').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  });
  </script>

  <script>
  $(function() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    var dateToday = dd + '-' + mm + '-' + yyyy;
    $('#date_end').daterangepicker({
      drops: 'down',
      singleDatePicker: true,
      autoUpdateInput: false,
      startDate:dateToday,
      minDate:dateToday,
      locale: {
        format: 'DD-MM-YYYY'
      },
      singleClasses: "picker_1"
    }, function(start, end, label) {
      // var years = moment().diff(start, 'years');
      // alert("The Employee is " + years+ " Years Old!");

    });
      $('#date_end').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
      $('#date_end').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });
  });
  </script>


  <script type="text/javascript">


      $('#requestImprest').submit(function(e){
          e.preventDefault();
               $.ajax({
                   url:'{{ url("/flex/imprest/requestImprest") }}',
                   type:"post",
                   data:new FormData(this),
                   processData:false,
                   contentType:false,
                   cache:false,
                   async:false
               })
          .done(function(data){

            if(data.status == 'OK'){
            alert("Imprest Request Sent Successifully");
            $('#resultfeedSubmission').fadeOut('fast', function(){
                $('#resultfeedSubmission').fadeIn('fast').html(data.message);
              });
            $('#requestImprest')[0].reset();
            setTimeout(function(){// wait for 5 secs(2)
             location.reload();
              var url = "<?php echo  url(''); ?>/flex/imprest/imprest_info/?id="+data.id
              window.location.href = url;
            }, 1000);

            } else {
            alert("Failed!");
            $('#resultfeedSubmission').fadeOut('fast', function(){
                $('#resultfeedSubmission').fadeIn('fast').html(data.message);
              });
            }


          })
          .fail(function(){
          alert('Request Failed!! ...');
          setTimeout(function(){
            location.reload();
          }, 1500);
          });
      });

  </script>
 @endpush
