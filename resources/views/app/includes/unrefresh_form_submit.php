
<!-- UPDATE OUTCOME -->
<script type="text/javascript">
  $('#update_outcomeDescriptions').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcome",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
 alert('Outcome Title Updated Successifully!! ...'); 

  $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Outcome Description Updation Failed!! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#update_outcomeTitle').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcome",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
 alert('Outcome Title Updated Successifully!! ...'); 
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Outcome Title Updation Failed!! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#update_outcomeIndicator').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcome",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
 alert('Outcome Indicator Updated Successifully!! ...'); 
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Outcome Indicator Updation Failed!! Check Your Network Connection ...'); 
    });

});
</script>



<script type="text/javascript">
  $('#updateOutcomeDateRange').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcomeDateRange",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
     var regex = /(<([^>]+)>)/ig
      var body = data
      var result = body.replace(regex, "");
      alert(result); 
      location.reload();
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Outcome Dates Updation Failed!! Check Your Network Connection ...'); 
    });

});
</script>


<!-- END UPDATE OUTCOME -->


<!-- START UPDATE OUTPUT-->
<script type="text/javascript">
  $('#update_outputDes').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateoutputDescription",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

  $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Output Description Updation Failed!! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#updateOutputDateRange').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutputDateRange",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Output Start Date Updation Failed!! ...'); 
    });

});
</script>


<script type="text/javascript">
  $('#update_outputTitle').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performancey/updateOutputTitle",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Output Title Updation Failed!! ...'); 
    });

});
</script>


<!-- END UPDATE OUTPUT -->


<!-- UPDATE STRATEGY -->

<!-- Update Title -->
<script type="text/javascript">
  $('#update_strategyTitle').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateStrategy",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
 alert('Strategy Title Updated Successifully!! ...'); 
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Strategy Title Updation Failed!! ...'); 
    });

});
</script>

<!-- Update Description  -->
<script type="text/javascript">
  $('#update_strategyDescription').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateStrategy",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
 alert('Strategy Description Updated Successifully!! ...'); 
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Strategy Description Updation Failed!! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#updateStrategyDateRange').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateStrategyDateRange",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
      var regex = /(<([^>]+)>)/ig
      var body = data
      var result = body.replace(regex, "");
      alert(result); 
      location.reload();
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Strategy Indicator Updation Failed!! Check Your Network Connection ...'); 
    });

});
</script>


<script type="text/javascript">
  $('#addOutcome').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/addOutcome",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
 dataType: 'json'
    })
    .done(function(data){
      if(data.status == 'OK'){
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              $('#name').val('');
              $('#textdescription').val('');

              setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 2000);

              } else{
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('Outcome not Added! Check Your Network Connection ...'); 
    });

});
</script>



<!-- END UPDATE STRATEGY -->


<!-- START UPDATE TASK-->
<script type="text/javascript">
  $('#update_taskDes').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskDescription",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

  $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Task Description Updation Failed!! ...'); 
    });

});
</script>



<script type="text/javascript">
  $('#update_taskTitle').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskTitle",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Task Title Updation Failed!! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#update_taskCost').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskCost",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
         var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Task Market Time Updation Failed!! ...'); 
    });

});
</script>
<script type="text/javascript">
  $('#updateTaskDateRange').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskDateRange",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });
     var regex = /(<([^>]+)>)/ig
      var body = data
      var result = body.replace(regex, "");
      alert(result); 
      location.reload();
//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Outcome Dates Updation Failed!! Check Your Network Connection ...'); 
    });

});
</script>


<script type="text/javascript">
  $('#update_taskOutputReference').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskAdvanced",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
    alert('Task Updated Successifully'); 
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Task Updation Failed!! ...'); 
    });

});
</script>
<script type="text/javascript">
  $('#update_taskAssignedTo').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateTaskAdvanced2",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
    alert('Task Updated Successifully'); 
     $('#resultfeedDes').fadeOut('fast', function(){
          $('#resultfeedDes').fadeIn('fast').html(data);
        });

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Task Updation Failed!! ...'); 
    });

});
</script>

</script>

<script type="text/javascript">
  $('#createNewTask').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/createNewTask",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              $('#title').val('');
              $('#textdescription').val('');
              $('#target').val('');
              $('#timecost').val('');
              $('#employee').val('');
              setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 2000);

              } else{
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('Task Not Added! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#outputAdvancedAssign').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/assign_output",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
    alert(data); 
        setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 1000);
    })
    .fail(function(){
 alert('Updation Failed ...'); 
    });

});


  $('#outputAdvancedOutcomeRef').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/reference_output",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
    alert(data); 
        setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 1000);
    })
    .fail(function(){
 alert('Updation Failed ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#formAddOutput').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/addOutput",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json' 
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);        
      if(data.status == 'OK'){
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              $('#title').val('');
              $('#textdescription').val('');
              setTimeout(function(){// wait for 5 secs(2)
             location.reload(); // then reload the page.(3)
          }, 2000);

              } else{
                $('#resultfeedDes').fadeOut('fast', function(){
                  $('#resultfeedDes').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('Output Not Added! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#formAddTask').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/addtask",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedBack').fadeOut('fast', function(){
          $('#resultfeedBack').fadeIn('fast').html(data);
        });
        
     $("#taskList").load(" #taskList");

  // $('#formAddTask')[0].reset();
  $('#title').val("");
  $('#description').val("");
  $('#quantity').val("");
  $('#monetary_value').val("");

    })
    .fail(function(){
 alert('Task Not Added! ...'); 
    });

});
</script>

<script type="text/javascript">
  
  $('#outcomeAdvancedAssign').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcomeAssign",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedBack').fadeOut('fast', function(){
          $('#resultfeedBack').fadeIn('fast').html(data);
        });
        
     location.reload();
    })
    .fail(function(){
 alert('Task Not Added! ...'); 
    });

});

 
  $('#outcomeAdvancedStrategyRef').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/performance/updateOutcomeStrategy_ref",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedBack').fadeOut('fast', function(){
          $('#resultfeedBack').fadeIn('fast').html(data);
        });
        
     $("#strategy_ref").load(" #strategy_ref");

  $('#formAddTask')[0].reset();
    })
    .fail(function(){
 alert('Task Not Added! ...'); 
    });

});
</script>

<script type="text/javascript">
  $('#formAddBudget').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/addBudget",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
        var regex = /(<([^>]+)>)/ig
        var body = data
        var result = body.replace(regex, "");
        alert(result);
     $('#resultfeedBack').fadeOut('fast', function(){
          $('#resultfeedBack').fadeIn('fast').html(data);
        });
        
     $("#itemList").load(" #itemList");

  $('#formAddBudget')[0].reset();
    })
    .fail(function(){
 alert('Output Not Added! ...'); 
    });

});
</script>
<!-- END UPDATE TASK -->





<script type="text/javascript">
    $('#addEmployee').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/confirmGraduation",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#resultfeedBackAttachment').fadeOut('fast', function(){
              $('#resultfeedBackAttachment').fadeIn('fast').html(data);
            });
    
      $('#receiptAttachment')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...'); 
        });
    }); 
</script>