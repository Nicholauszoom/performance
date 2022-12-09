

<script type="text/javascript">        
    
  function deleteBudget(id){
    if (confirm("Are You Sure You Want To Delete This Budget ?") == true) {
      var id = id;
      // $('#recordRequirement'+id).show();
      $.ajax({
        url:"<?php echo url('flex/deleteBudget');?>/"+id,
        success:function(data)
        {
          $('#resultFeedback').fadeOut('fast', function(){
            $('#resultFeedback').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);       
           
        }
           
      });
    }
  }      
    
    
    
  function approveBudget(id){
    if (confirm("Are You Sure You Want To Approve This Budget") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/approveBudget');?>/"+id,
        success:function(data)
        {
       $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
       setTimeout(function(){
        location.reload();
       }, 1000);
        // $('#recordRequirement'+id).hide();
           
        }
           
        });
    }
  }  
    
  function disapproveBudget(id){
    if (confirm("Are You Sure You Want To Approve This Budget") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/disapproveBudget');?>/"+id,
        success:function(data) {
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data);
        });
           
        }
           
        });
    }
  }
    
    
  function recommendRequest(id){
    if (confirm("Are You Sure You Want To Recommend This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/recommendTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
           }, 2000);
            // $('#recordRequirement'+id).hide();           
          }           
      });
    }
  }    
    
  function suspendRequest(id){
    if (confirm("Are You Sure You Want To Suspend This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/suspendTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }
    
  function approveRequest(id){
    if (confirm("Are You Sure You Want To Approve This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/approveTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }
    
  function disapproveRequest(id){
    if (confirm("Are You Sure You Want To Disapprove This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/disapproveTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }
    
  function confirmRequest(id){
    if (confirm("Are You Sure You Want To Confirm This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/confirmTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }
    
  function unconfirmRequest(id){
    if (confirm("Are You Sure You Want To Unonfirm This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/unconfirmTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#feedbackRequest').fadeOut('fast', function(){
            $('#feedbackRequest').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }
    
  function deleteRequest(id){
    if (confirm("Are You Sure You Want To Cancel/Delete This Request") == true) {
    var id = id;
    // $('#recordRequirement'+id).show();
    $.ajax({
        url:"<?php echo url('flex/deleteTrainingRequest');?>/"+id,
        success:function(data) {
          alert("SUCCESS");
          $('#resultFeedback').fadeOut('fast', function(){
            $('#resultFeedback').fadeIn('fast').html(data);
          });
          setTimeout(function(){
            location.reload();
          }, 2000);
            // $('#recordRequirement'+id).hide();           
        }
           
      });
    }
  }


 
</script>

<script type="text/javascript">
    $('#update_budgetDescription').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateBudgetDescription",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeedDes').fadeOut('fast', function(){
              $('#resultFeedDes').fadeIn('fast').html(data);
            });
    $('#addRequirement')[0].reset();
        })
        .fail(function(){
     alert('Failed To Add!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#update_budgetDateRange').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateBudgetDateRange",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeedDes').fadeOut('fast', function(){
              $('#resultFeedDes').fadeIn('fast').html(data);
            });
    
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#update_budgetAmount').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/updateBudgetAmount",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeedDes').fadeOut('fast', function(){
              $('#resultFeedDes').fadeIn('fast').html(data);
            });
    
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#applyTraining').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo url(); ?>flex/requestTraining2",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultFeedDes').fadeOut('fast', function(){
              $('#resultFeedDes').fadeIn('fast').html(data.message);
            });
         setTimeout(function() {
          location.reload();
         }, 2000);
    
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
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
  var dateToday = dd + '/' + mm + '/' + yyyy;
  $('#startDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#startDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#startDate').on('cancel.daterangepicker', function(ev, picker) {
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
  var dateToday = dd + '/' + mm + '/' + yyyy;
  $('#endDate').daterangepicker({
    drops: 'down',
    singleDatePicker: true,
    autoUpdateInput: false,
    minDate:dateToday,
    locale: {      
      format: 'DD/MM/YYYY'
    },
    singleClasses: "picker_1"
  }, function(start, end, label) {
    var years = moment().diff(start, 'years');

  });
    $('#endDate').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY'));
  });
    $('#endDate').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});
</script>



