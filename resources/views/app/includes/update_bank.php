

<script type="text/javascript">
  $('#updateBankName').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBankName",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){
      
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");

      if(data.status == 'OK'){
        alert(result);
                $('#feedbackBankName').fadeOut('fast', function(){
                  $('#feedbackBankName').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBankName').fadeOut('fast', function(){
                  $('#feedbackBankName').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to add Branch, Review Your Network Connection...'); 
    });

});
</script>
<script type="text/javascript">
  $('#updateAbbrev').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateAbbrev",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackAbbrev').fadeOut('fast', function(){
                  $('#feedbackAbbrev').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackAbbrev').fadeOut('fast', function(){
                  $('#feedbackAbbrev').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED Update, Review Your Network Connection...'); 
    });

});
</script>
<script type="text/javascript">
  $('#updateBankCode').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBankCode",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBankCode').fadeOut('fast', function(){
                  $('#feedbackBankCode').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBankCode').fadeOut('fast', function(){
                  $('#feedbackBankCode').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update Bank Code, Review Your Network Connection...'); 
    });

});
</script>

<script type="text/javascript">
  $('#updateBranchName').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchName",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchName').fadeOut('fast', function(){
                  $('#feedbackBranchName').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchName').fadeOut('fast', function(){
                  $('#feedbackBranchName').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>



<script type="text/javascript">
  $('#updateBranchCode').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchCode",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchCode').fadeOut('fast', function(){
                  $('#feedbackBranchCode').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchCode').fadeOut('fast', function(){
                  $('#feedbackBranchCode').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>

<script type="text/javascript">
  $('#updateBranchSwiftcode').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchSwiftcode",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchSwiftcode').fadeOut('fast', function(){
                  $('#feedbackBranchSwiftcode').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchSwiftcode').fadeOut('fast', function(){
                  $('#feedbackBranchSwiftcode').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>


<script type="text/javascript">
  $('#updateBranchStreet').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchStreet",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchStreet').fadeOut('fast', function(){
                  $('#feedbackBranchStreet').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchStreet').fadeOut('fast', function(){
                  $('#feedbackBranchStreet').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>


<script type="text/javascript">
  $('#updateBranchRegion').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchRegion",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchRegion').fadeOut('fast', function(){
                  $('#feedbackBranchRegion').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchRegion').fadeOut('fast', function(){
                  $('#feedbackBranchRegion').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>


<script type="text/javascript">
  $('#updateBranchCountry').submit(function(e){
  
    e.preventDefault(); // Prevent Default Submission
  
    $.ajax({
 url: "<?php echo  url(''); ?>/flex/updateBranchCountry",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'json'
    })
    .done(function(data){

      if(data.status == 'OK'){
        var regex = /(<([^>]+)>)/ig
        var body = data.message;
        var result = body.replace(regex, "");
        alert(result);
                $('#feedbackBranchCountry').fadeOut('fast', function(){
                  $('#feedbackBranchCountry').fadeIn('fast').html(data.message);
                });

              } else{
                alert(data.message);
                $('#feedbackBranchCountry').fadeOut('fast', function(){
                  $('#feedbackBranchCountry').fadeIn('fast').html(data.message);
                });
              }
    })
    .fail(function(){
 alert('FAILED to Update, Review Your Network Connection...'); 
    });

});
</script>



