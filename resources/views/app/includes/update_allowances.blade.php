

<script type="text/javascript">


function cancelBonus(id)
    {
        if (confirm("Are You Sure You Want To Cancel This Entitlement to this Employee?") == true) {
        var id = id;

        $.ajax({
            url:"<?php echo url('flex/cancelBonus');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Bonus Cancelled Successifully");
               $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data.message);
                });
              // $('#record'+id).hide();
              $("#status"+id).load(" #status"+id);
              $("#option"+id).load(" #option"+id);
              }else{
              alert("Bonus Not Canceled, Some Error Occured");
              }



            }

            });
        }
    }

function confirmBonus(id)
    {
        if (confirm("Are You Sure You Want To Confirm This Bonus Entitlement to this Employee?") == true) {
        var id = id;

        $.ajax({
            url:"<?php echo url('flex/confirmBonus');?>/"+id,
            success:function(data)
            {   var data = JSON.parse(data);
                alert(data.status);
              if(data.status == 'OK'){
              alert("Bonus Confirmed Successifully");
               $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data.message);
                });
               $("#status"+id).load(" #status"+id);
              $("#option"+id).load(" #option"+id);
                setTimeout(function(){// wait for 5 secs(2)
         location.reload(); // then reload the page.(3)
      }, 2000);
              }else if(data.status != 'SUCCESS'){
              alert("Bonus Not Canceled, Some Error Occured");
              }



            }

            });
        }
    }


function recommendBonus(id)
    {
        if (confirm("Are You Sure You Want To Confirm This Bonus Entitlement to this Employee?") == true) {
        var id = id;

        $.ajax({
            url:"<?php echo url('flex/recommendBonus');?>/"+id,
            success:function(data)
            {
              var data = JSON.parse(data);
              if(data.status == 'OK'){
              alert("Bonus Confirmed Successifully");
               $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data.message);
                });
               $("#status"+id).load(" #status"+id);
              $("#option"+id).load(" #option"+id);
                setTimeout(function(){// wait for 5 secs(2)
         location.reload(); // then reload the page.(3)
      }, 2000);
              }else if(data.status != 'SUCCESS'){
              alert("Bonus Not Canceled, Some Error Occured");
              }
            }

           });
           
        }
    }


function deleteBonus(id)
    {
        if (confirm("Are You Sure You Want To Delete This Bonus Entitlement for this Employee?") == true) {
        var id = id;

        $.ajax({
            url:"<?php echo url('flex/deleteBonus');?>/"+id,
            success:function(data)
            {  
                var data = JSON.parse(data);
              if(data.status == 'OK'){
              alert("Bonus Deleted Successifully");
               $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data.message);
                });
               $("#status"+id).load(" #status"+id);
              $("#option"+id).load(" #option"+id);
                setTimeout(function(){// wait for 5 secs(2)
         location.reload(); // then reload the page.(3)
      }, 2000);
              }else if(data.status != 'SUCCESS'){
              alert("Bonus Not Canceled, Some Error Occured");
              }



            }

            });
        }
    }







    $('#updateName').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowanceName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
            var data = JSON.parse(data);
         $('#feedBackSubmission').fadeOut('fast', function(){
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...');
        });
    });


    $('#updateTaxable').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowanceTaxable",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...');
        });
    });

    $('#updatePentionable').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowancePentionable",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Upload Failed!! ...');
        });
    });
</script>


<script type="text/javascript">
    $('#updateAmount').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowanceAmount",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script>
<script type="text/javascript">
    $('#updatePercent').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowancePercent",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script>

<script type="text/javascript">
    $('#updatePolicy').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateAllowancePolicy",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSubmission').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackSubmission').fadeIn('fast').html(data);
            });

    setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 2000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    });
</script>

<script type="text/javascript">
    $('#assignIndividual').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/assign_allowance_individual",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAssignment').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackAssignment').fadeIn('fast').html(data);
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
    $('#assignGroup').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/assign_allowance_group",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackAssignment').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackAssignment').fadeIn('fast').html(data);
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
    $('#removeIndividual').submit(function(e){
        if (confirm("Are You Sure You Want To Delete The selected Employee(s) from Receiving This Allowance?") == true) {
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/remove_individual_from_allowance",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackRemove').fadeOut('fast', function(){
            var data = JSON.parse(data);
              $('#feedBackRemove').fadeIn('fast').html(data);
            });

     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    }
    });
</script>

<script type="text/javascript">
    $('#removeGroup').submit(function(e){
        if (confirm("Are You Sure You Want To Delete The selected Employee(s) from Receiving This Allowance?") == true) {
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/remove_group_from_allowance",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackRemoveGroup').fadeOut('fast', function(){
              $('#feedBackRemoveGroup').fadeIn('fast').html(data);
            });

     setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Update Failed!! ...');
        });
    }
    });
</script>

<script type="text/javascript">

function deleteAllowance(id)
    {
        if (confirm("Are You Sure You Want To Delete This Allowance") == true) {
        var id = id;
        $.ajax({
            url:"<?php echo url('flex/deleteAllowance');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Allowance Deleted Successifully!");
              $("#allowanceList").load(" #allowanceList");
              // $('#record'+id).hide();
              } else{
              alert("Allowance Not Deleted, Some Error Occured In Deleting");
              }
           $('#deleteFeedback').fadeOut('fast', function(){
          $('#deleteFeedback').fadeIn('fast').html(data.message);
        });


            }

            });
        }
    }
    function activateAllowance(id)
    {
        if (confirm("Are You Sure You Want To Activate This Allowance") == true) {
        var id = id;
        $.ajax({
            url:"<?php echo url('flex/activateAllowance');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Allowance Activated Successifully!");
              $("#allowanceList").load(" #allowanceList");
              // $('#record'+id).hide();
              } else{
              alert("Allowance Not Activated, Try Again");
              }
           $('#deleteFeedback').fadeOut('fast', function(){
          $('#deleteFeedback').fadeIn('fast').html(data.message);
        });


            }

            });
        }
    }
</script>

<script type="text/javascript">
    $('#addToBonus').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/addToBonus",
                 type:"post",
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
            $("#employeeList").load(" #employeeList");
            $('#addToBonus')[0].reset();

             setTimeout(function(){// wait for 5 secs(2)
                   location.reload(); // then reload the page.(3)
              }, 1000);

        })
        .fail(function(){
          alert('Update Failed!! ...');
          setTimeout(function(){// wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
           }, 1000);
        });
    });
</script>

<script type="text/javascript">
    $('#addBonusTag').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/addBonusTag",
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

        // $("#addToBonus").load(" #addToBonus");
        setTimeout(function(){// wait for 5 secs(2)
         location.reload(); // then reload the page.(3)
      }, 3000);
        })
        .fail(function(){
     alert('Failed To Add! ...');
        });
    });
</script>
