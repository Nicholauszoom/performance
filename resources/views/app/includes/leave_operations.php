<script>


    $('#applyLeave').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/attendance/apply_leave",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedSubmission').fadeOut('fast', function(){
              $('#resultfeedSubmission').fadeIn('fast').html(data);
            });
            setTimeout(function() {
                location.reload();
            }, 1000);
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

   
    function approveLeave(id)
    {
        if (confirm("Are You Sure You Want to Approve This Leave Request") == true) {
        var leaveid = id;
  
            $.ajax({
                url: "<?php echo url('flex/attendance/approveLeave');?>/"+leaveid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             alert('Request Approved Successifully!! ...'); 
             setTimeout(function(){
                     location.reload();
                }, 1500); 
                })
            .fail(function(){
             alert('Leave Approval Failed!! ...'); 
                });
        }
    }
    

    function rejectLeave(id)
    {
        if (confirm("Are You Sure You Want to Disapprove This Leave Request") == true) {
        var leaveid = id;
  
            $.ajax({
                url: "<?php echo url('flex/attendance/rejectLeave');?>/"+leaveid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             alert('Request Disapproved Successifully!! ...');
             setTimeout(function(){
                     location.reload();
                }, 1500);  
                })
            .fail(function(){
             alert('Leave Disapproval Failed!! ...'); 
                });
        }
    }
    

    function holdLeave(id)
    {
        if (confirm("Are You Sure You Want to Hold on This Leave Request") == true) {
        var leaveid = id;
  
            $.ajax({
                url: "<?php echo url('flex/attendance/holdLeave');?>/"+leaveid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-warning">HELD</span></div>');
                });
             alert('Request Held Successifully!! ...'); 
             setTimeout(function(){
                     location.reload();
                }, 1500); 
                })
            .fail(function(){
             alert('Leave Hold Failed!! ...'); 
                });
        }
    }
    

    
    
    function recommendLeave(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Leave Request") == true) {
        var leaveid = id;
  
            $.ajax({
                url: "<?php echo url('flex/attendance/recommendLeave');?>/"+leaveid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...'); 
             setTimeout(function(){
                     location.reload();
                }, 1500); 
                })
            .fail(function(){
             alert('Leave Recommendation Failed!! ...'); 
                });
        }
    }
    

    

    function cancelLeave(id)
    {
        if (confirm("Are You Sure You Want to Cancel and Delete This Leave Request") == true) {
        var leaveid = id;
  
            $.ajax({
                url: "<?php echo url('flex/attendance/cancelLeave');?>/"+leaveid
            })
            .done(function(data){
             $('#resultfeedCancel').fadeOut('fast', function(){
                  $('#resultfeedCancel').fadeIn('fast').html(data);
                });
             $('#record'+id).hide();
             alert('Request Cancelled Successifully!! ...'); 
             setTimeout(function(){
                     location.reload();
                }, 1500); 
                })
            .fail(function(){
             alert('Leave Deletion Failed!! ...'); 
                });
        }
    }

</script>
<script type="text/javascript">        

  $(document).ready(function() {
    $('#leave_startDate').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'DD/MM/YYYY'
      },
      singleClasses: "picker_1",
      startDate: "<?php echo date('d/m/Y', strtotime($startDate)); ?>"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
</script>

<script type="text/javascript">

  $(document).ready(function() {

    $('#leave_endDate').daterangepicker({
      singleDatePicker: true,
      locale: {
        format: 'DD/MM/YYYY'
      },
      singleClasses: "picker_1",
      startDate: "<?php echo date('d/m/Y', strtotime($endDate)); ?>"
    }, function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });
  });
</script>

<script type="text/javascript">
    $('#updateLeaveReason').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/attendance/updateLeaveReason",
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
    
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateLeaveDateRange').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/attendance/updateLeaveDateRange",
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
    
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateLeaveAddress').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/attendance/updateLeaveAddress",
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
    
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateLeaveMobile').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/attendance/updateLeaveMobile",
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
    
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
        });
    }); 
</script>