<script type="text/javascript">

  $(document).ready(function() {
    $('#imprest_startDate').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'DD/MM/YYYY'
      },
      singleClasses: "picker_1",
      startDate: "<?php if(isset($startDate)){echo date('d/m/Y', strtotime($startDate));} ?>"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {

    $('#imprest_endDate').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'DD/MM/YYYY'
      },
      singleClasses: "picker_1",
      startDate: <?php if(isset($endDate)){echo date('d/m/Y', strtotime($endDate));} ?>"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
</script>

<script type="text/javascript">

  function deleteImprest(id){
    if (confirm("Are You Sure You Want To CANCEL/DELETE This Imprest (All Requirement Associated With It Will Be Deleted Too) ?") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/deleteImprest');?>/"+id,
        success:function(data)
        {
          var data = JSON.parse(data);
          if(data.status == 'OK'){
          alert("Imprest Deleted Sussessifully!");
          setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 2000);
          $('#recordImprest'+id).hide();
          }else{
          alert("Imprest Not Deleted, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });


        }

        });
    }
  }

  function deleteRequirement(id){
    if (confirm("Are You Sure You Want To Delete This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:'{{ url("flex/imprest/deleteRequirement") }}/'+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Deleted Sussessifully!");
          setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 2000);
          }else if(data.status != 'SUCCESS'){
          alert("Requirement Not Deleted, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        $('#recordRequirement'+id).hide();

        }

        });
    }
  }

  function approveRequirement(id){
    if (confirm("Are You Sure You Want To Approve This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/approveRequirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Approved Sussessifully!");
          setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 2000);
          }else if(data.status != 'SUCCESS'){
          alert("Requirement Not Approved, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        // $('#recordRequirement'+id).hide();

        }

        });
    }
  }


  function disapproveRequirement(id){
    if (confirm("Are You Sure You Want To Approve This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/disapproveRequirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Disapproved Sussessifully!");
          setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 2000);
          }else if(data.status != 'SUCCESS'){
          alert("Failed, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        // $('#recordRequirement'+id).hide();

        }

        });
    }
  }



  function confirmRequirement(id){
    if (confirm("Are You Sure You Want To Confirm This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/confirmRequirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Confirmed Sussessifully!");
          setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
          }else if(data.status != 'SUCCESS'){
          alert("Failed, Some Error Occured In Confirmation");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
        });
         $('#recordRequirement'+id).hide();

        }

        });
    }
  }


  function unconfirmRequirement(id){
    if (confirm("Are You Sure You Want To Unconfirm This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/unconfirmRequirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Unconfirmed Sussessifully!");
          setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
          }else if(data.status != 'SUCCESS'){
          alert("Failed, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        // $('#recordRequirement'+id).hide();

        }

        });
    }
  }
  function confirmRequirementRetirement(id){
    if (confirm("Are You Sure You Want To Confirm This Requirement as Retired") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/confirmRequirementRetirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Confirmed Sussessifully!");
          setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
          }else if(data.status != 'SUCCESS'){
          alert("Failed, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        // $('#recordRequirement'+id).hide();

        }

        });
    }
  }
  function unconfirmRequirementRetirement(id){
    if (confirm("Are You Sure You Want To Unconfirm This Requirement From Retirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/unconfirmRequirementRetirement');?>/"+id,
        success:function(data)
        {
          if(data.status == 'OK'){
          alert("Requirement Unconfirmed Sussessifully!");
          setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
          }else if(data.status != 'SUCCESS'){
          alert("Failed, Some Error Occured In Deleting");
          }
       $('#resultFeedback').fadeOut('fast', function(){
      $('#resultFeedback').fadeIn('fast').html(data.message);
    });
        // $('#recordRequirement'+id).hide();

        }

        });
    }
  }



  function deleteEvidence(id){
    if (confirm("Are You Sure You Want To Delete Evidence for This Requirement") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/imprest/deleteEvidence');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){// wait for 5 secs(2)
          location.reload(); // then reload the page.(3)
        }, 2000);


        }

        });
    }
  }
</script>

<script type="text/javascript">
    $('#addRequirement').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/imprest/add_imprest_requirement",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });
    $('#addRequirement')[0].reset();
    setTimeout(function(){
          location.reload();
        }, 1500);
        })
        .fail(function(){
     alert('Failed To Add!! ...');
     setTimeout(function(){
          location.reload();
        }, 1500);
        });
    });
</script>

<script type="text/javascript">
    $('#update_imprestTitle').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/imprest/updateImprestTitle",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });
            setTimeout(function(){
          location.reload();
        }, 1500);

        })
        .fail(function(){
     alert('Upload Failed!! ...');
     setTimeout(function(){
          location.reload();
        }, 1500);
        });
    });
</script>


<script type="text/javascript">
    $('#update_imprestDescription').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/imprest/updateImprestDescription",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });
            setTimeout(function(){
          location.reload();
        }, 1500);

        })
        .fail(function(){
     alert('Upload Failed!! ...');
     setTimeout(function(){
          location.reload();
        }, 1500);
        });
    });
</script>


<script type="text/javascript">
    $('#updateImprestDateRange').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/imprest/updateImprestDateRange",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeed').fadeOut('fast', function(){
              $('#resultFeed').fadeIn('fast').html(data);
            });
            setTimeout(function(){
          location.reload();
        }, 1500);

        })
        .fail(function(){
     alert('Upload Failed!! ...');
     setTimeout(function(){
          location.reload();
        }, 1500);
        });
    });
</script>


<!-- END FIRST -->
<script>

    function holdImprest(id)
    {
        if (confirm("Are You Sure You Want to Hold This Imprest Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/holdImprest');?>/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">HELD</span></div>');
                });
             alert('Request Held!');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Hold Failed!! ...');
                });
        }
    }

     function approveImprest(id)
    {
        if (confirm("Are You Sure You Want to Approve This Imprest Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/approveImprest');?>/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             alert('Request Approved Successifully!! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Approval Failed!! ...');
             setTimeout(function(){
          location.reload();
        }, 1500);
                });
        }
    }

    function disapproveImprest(id)
    {
        if (confirm("Are You Sure You Want to Dissaprove This Imprest Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/disapproveImprest');?>/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             alert('Request Dissaproved! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Dissaproval Failed!! ...');
             setTimeout(function(){
          location.reload();
        }, 1500);
                });
        }
    }


    function recommendImprest(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Imprest Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/recommendImprest');?>/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Recommendation Failed!! ...');
                });
        }
    }


    function hr_recommendImprest(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Imprest Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/hr_recommendImprest');?>/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Recommendation Failed Unconfirmed Reuirements!! ...');
                });
        }
    }



    function confirmImprest(id)
    {
        if (confirm("Are You Sure You Want to Confirm This Imprest Request, Action can not be Reversed") == true) {
        var imprestid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/confirmImprest');?>/"+imprestid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>');
                });
             alert('Request Confirmed Successifully!! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Confirmation Failed!! ...');
                });
        }
    }

    function unconfirmImprest(id)
    {
        if (confirm("Are You Sure You Want to Unconfirm This Imprest Request") == true) {
        var imprestid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/unconfirmImprest');?>/"+imprestid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>');
                });
             alert('Request Confirmed Successifully!! ...');
             setTimeout(function(){// wait for 2 secs(2)
                     location.reload(); // then reload the div to clear the success notification
                }, 1500);
                })
            .fail(function(){
             alert('Imprest Confirmation Failed!! ...');
                });
        }
    }

    function confirmImprestRetirement(id)
    {
        if (confirm("Are You Sure You Want to Confirm Retirement for This Imprest Request, Action can not be Reversed") == true) {
        var imprestid = id;

            $.ajax({
                url: "<?php echo url('flex/imprest/confirmImprestRetirement');?>/"+imprestid
            })
            .done(function(data){
             $('#resultfeedImprest').fadeOut('fast', function(){
                  $('#resultfeedImprest').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>');
                });
             alert('Request Confirmed Successifully!! ...');
             setTimeout(function(){
                     location.reload();
                }, 1500);

                })
            .fail(function(){
             alert('Imprest Confirmation Failed!! ...');
                });
        }
    }

    function pendingConfirmationAlert() {
        alert("Confirmation FAILED: Some Requirements For This Imprest are Not Confirmed, Please Confirm and Try Again");
    }

    function pendingApprovalAlert() {
        alert("Approval FAILED: Some Requirements For This Imprest are Not Approved, Please Approve Them and Try Again");
    }

    function pendingRetireAlert() {
        alert("Retirement FAILED: Some Requirements For This Imprest are Not Confirmed as Retired, Please Confirm their Retirement and Try Again");
    }

    function empPendingRetireAlert() {
        alert("Retirement FAILED: Some Requirements For This Imprest are Not Retired, Please Confirm  Requirement Retirement and Try Again");
    }






</script>
