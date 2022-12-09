<script>

$("#apply").click(function() {
    $('html,body').animate({
        scrollTop: $("#applyForm").offset().top},
        'slow');
});

$("#insertDirect").click(function() {
    $('html,body').animate({
        scrollTop: $("#insertDirectForm").offset().top},
        'slow');
});
</script>
<script>
    $('#directLoan').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/insert_directLoan",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedSubmissionDirect').fadeOut('fast', function(){
              $('#resultfeedSubmissionDirect').fadeIn('fast').html(data);
            });
          
      $('#directLoan')[0].reset();
      setTimeout(function() {
                location.reload();
             }, 2000);
        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 
</script>
<script>

    $('#applyLoan').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/apply_salary_advance",
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
    
      $('#applyLoan')[0].reset();
      setTimeout(function() {
                location.reload();
             }, 2000);

        })
        .fail(function(){
     alert('Request Failed!! ...'); 
        });
    }); 

   
    function approveLoan(id)
    {
        if (confirm("Are You Sure You Want to Approve This Loan Request (The Operation Can be IRREVERSIBLE)") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/approveLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             alert('Request Approved Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Loan Approval Failed!.Client has possibly unpaid salary advance loan'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }
    

    function rejectLoan(id)
    {
        if (confirm("Are You Sure You Want to Disapprove This Loan Request") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/rejectLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             alert('Request Disapproved Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Loan Disapproval Failed!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }
    

    function holdLoan(id)
    {
        if (confirm("Are You Sure You Want to Hold on This Loan Request") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/holdLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-warning">HELD</span></div>');
                });
             alert('Request Held Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Loan Hold Failed!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }
    

    
    
    function recommendLoan(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Loan Request") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/recommendLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Loan Recommendation Failed!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }
    

    function hrrecommendLoan(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Loan Request") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/hrrecommendLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeed').fadeOut('fast', function(){
                  $('#resultfeed').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">RECOMENDED</span></div>');
                });
             alert('Request Recommended Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Loan Recommendation Failed!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }

    

    function cancelLoan(id)
    {
        if (confirm("Are You Sure You Want to CANCEL/DELETE This Loan Request") == true) {
        var loanid = id;
  
            $.ajax({
                url: "<?php echo url('flex/cancelLoan');?>/"+loanid
            })
            .done(function(data){
             $('#resultfeedCancel').fadeOut('fast', function(){
                  $('#resultfeedCancel').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>');
                });
             alert('Request Cancelled Successifully!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Cancellation Failed!! ...'); 
             setTimeout(function() {
                location.reload();
             }, 2000);
                });
        }
    }


</script>