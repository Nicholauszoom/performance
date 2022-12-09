@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Funder </h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php if($action == 0 && session('mng_proj')){ ?>

        <?php } if($action ==1  && !empty($funder_info)){

            foreach ($funder_info as $row) {
                $funderID = $row->id;
                $name = $row->name;
                $email = $row->email;
                $phone = $row->phone;
                $description = $row->description;
                $type = $row->type;
                $country = null;
                $country_code = null;
                foreach ($country_list as $item){
                    if ($row->country == $item->code){
                        $country = $item->name;
                        $country_code = $item->code;
                    }
                }

            }

            ?>

            <!-- UPDATE INFO AND SECTION -->
            <div class="row">
                <!-- Groups -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-info-cycle"></i>&nbsp;&nbsp;<b>Details</b></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id ="feedBackAssignment"></div>
                            <h5> Name:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $name; ?></b></h5>
                            <h5> Email:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $email; ?></b></h5>
                            <h5> Phone:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $phone; ?></b></h5>
                            <h5> Country:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $country; ?></b></h5>
                            <h5> Funder Type:
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $type; ?></b></h5>
                            <h5>Description:   &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo $description; ?></b>
                            </h5>
                            <br>
                        </div>
                    </div>
                </div>
                <!-- Groups -->

                <!--UPDATE-->
                <?php if(session('mng_proj')){  ?>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-edit"></i>&nbsp;&nbsp;<b>Update</b></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id ="feedBackSubmission"></div>
                                <form autocomplete="off" id="updateName" class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input hidden name ="funderID" value="<?php echo $funderID; ?>">
                                                <input required="" class="form-control col-md-7 col-xs-12" value="<?php echo $name; ?>" name ="name" placeholder="Project Name">
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary">Update Name</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form autocomplete="off" id="updateEmail" class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input hidden name ="funderID" value="<?php echo $funderID; ?>">
                                                <input required="" type="email" name ="email" value="<?php echo $email; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <button  class="btn btn-primary">Update Email</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form autocomplete="off" id="updatePhone" class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input hidden name ="funderID" value="<?php echo $funderID; ?>">
                                                <input required="" type="text" name ="phone" value="<?php echo $phone; ?>" class="form-control">
                                                <span class="input-group-btn">
                                                        <button  class="btn btn-primary">Update Phone</button>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form autocomplete="off" id="updateDescription" class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input hidden name ="funderID" value="<?php echo $funderID; ?>">
                                                <textarea required="" class="form-control col-md-7 col-xs-12" name ="description" placeholder="Project Description" rows="3"><?php echo $description; ?></textarea>
                                                <span class="input-group-btn">
                            <button  class="btn btn-primary">Update Description</button>
                          </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- END UPDATE SECTION  -->
        <?php } ?>

    </div>
</div>




<!-- /page content -->




<script type="text/javascript">

    $('#updateName').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo url(); ?>flex/performance/updateFunderName",
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
                setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            })
            .fail(function(){
                alert('Request Failed!! ...');
            });
    });

    $('#updateEmail').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo url(); ?>flex/performance/updateFunderEmail",
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
                setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            })
            .fail(function(){
                alert('Request Failed!! ...');
            });
    });

    $('#updatePhone').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo url(); ?>flex/performance/updateFunderPhone",
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
                setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            })
            .fail(function(){
                alert('Request Failed!! ...');
            });
    });

    $('#updateDescription').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo url(); ?>flex/performance/updateFunderDescription",
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
                setTimeout(function(){// wait for 2 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1000);
            })
            .fail(function(){
                alert('Request Failed!! ...');
            });
    });

</script>





 @endsection