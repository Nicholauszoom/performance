

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
              $('#record'+id).hide();
              }else if(data.status != 'SUCCESS'){
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
            {
              if(data.status == 'OK'){
              alert("Bonus Confirmed Successifully");
               $('#feedBack').fadeOut('fast', function(){
                  $('#feedBack').fadeIn('fast').html(data.message);
                });
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


    $('#updateFirstName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateFirstName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackFname').fadeOut('fast', function(){
              $('#feedBackFname').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackFname").load(" #feedBackFname"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 

    $('#updateCode').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateCode",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackFname').fadeOut('fast', function(){
              $('#feedBackFname').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackFname").load(" #feedBackFname"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    });

    $('#updateLevel').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateLevel",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackFname').fadeOut('fast', function(){
              $('#feedBackFname').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackFname").load(" #feedBackFname"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    });
</script>


<script type="text/javascript">
    $('#updateMiddleName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateMiddleName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackMname').fadeOut('fast', function(){
              $('#feedBackMname').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackMname").load(" #feedBackMname"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>



<script type="text/javascript">
    $('#updatedob').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateDob",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackDob').fadeOut('fast', function(){
              $('#feedBackDob').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackDob").load(" #feedBackDob"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updations Failed!! ...'); 
        });
    }); 
</script>




<script type="text/javascript">
    $('#updatePensionFund').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeePensionFund",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPension').fadeOut('fast', function(){
              $('#feedBackPension').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackPension").load(" #feedBackPension"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>



<script type="text/javascript">
    $('#updateLastName').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateLastName",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackLname').fadeOut('fast', function(){
              $('#feedBackLname').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackLname").load(" #feedBackLname"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#updateGender').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateGender",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackGender').fadeOut('fast', function(){
              $('#feedBackGender').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackGender").load(" #feedBackGender"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#updateExpatriate').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateExpatriate",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackExpatriate').fadeOut('fast', function(){
              $('#feedBackExpatriate').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackExpatriate").load(" #feedBackExpatriate"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#updatePosition').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeePosition",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPosition').fadeOut('fast', function(){
              $('#feedBackPosition').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>



<script type="text/javascript">
    $('#updateBranch').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeeBranch",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackBranch').fadeOut('fast', function(){
              $('#feedBackBranch').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>



<script type="text/javascript">
    $('#updateNationality').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeeNationality",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackNationality').fadeOut('fast', function(){
              $('#feedBackNationality').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>


<script type="text/javascript">
    $('#updateDeptPos').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateDeptPos",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackDeptPos').fadeOut('fast', function(){
              $('#feedBackDeptPos').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
          location.reload(); // then reload the page.(3)
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateSalary').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateSalary",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackSalary').fadeOut('fast', function(){
              $('#feedBackSalary').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackSalary").load(" #feedBackSalary"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Request For Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateEmail').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmail",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackEmail').fadeOut('fast', function(){
              $('#feedBackEmail').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackEmail").load(" #feedBackEmail"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updatePostAddress').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updatePostAddress",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPostAddress').fadeOut('fast', function(){
              $('#feedBackPostAddress').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackPostAddress").load(" #feedBackPostAddress"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updatePostCity').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updatePostCity",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPostCity').fadeOut('fast', function(){
              $('#feedBackPostCity').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackPostCity").load(" #feedBackPostCity"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updatePhysicalAddress').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updatePhysicalAddress",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPhysicalAddress').fadeOut('fast', function(){
              $('#feedBackPhysicalAddress').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackPhysicalAddress").load(" #feedBackPhysicalAddress"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateMobile').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateMobile",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackMobile').fadeOut('fast', function(){
              $('#feedBackMobile').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackMobile").load(" #feedBackMobile"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateHomeAddress').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateHomeAddress",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackHomeAddress').fadeOut('fast', function(){
              $('#feedBackHomeAddress').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackHomeAddress").load(" #feedBackHomeAddress"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateNationalID').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo  url(''); ?>/flex/updateNationalID",
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false
        })
            .done(function(data){
                $('#feedBackNationalID').fadeOut('fast', function(){
                    $('#feedBackNationalID').fadeIn('fast').html(data);
                });
                setTimeout(function(){// wait for 2 secs(2)
                    $("#feedBackNationalID").load(" #feedBackNationalID"); // then reload the div to clear the success notification
                }, 2000);
                //   $('#updateMiddleName')[0].reset();
            })
            .fail(function(){
                alert('Updation Failed!! ...');
            });
    });
</script>

<script type="text/javascript">
    $('#updateTin').submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"<?php echo  url(''); ?>/flex/updateTin",
            type:"post",
            data:new FormData(this),
            processData:false,
            contentType:false,
            cache:false,
            async:false
        })
            .done(function(data){
                $('#feedBackTin').fadeOut('fast', function(){
                    $('#feedBackTin').fadeIn('fast').html(data);
                });
                setTimeout(function(){// wait for 2 secs(2)
                    $("#feedBackTin").load(" #feedBackTin"); // then reload the div to clear the success notification
                }, 2000);
                //   $('#updateMiddleName')[0].reset();
            })
            .fail(function(){
                alert('Updation Failed!! ...');
            });
    });
</script>

<script type="text/javascript">
    $('#updateBankAccountNo').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateBankAccountNo",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackBankAccountNo').fadeOut('fast', function(){
              $('#feedBackBankAccountNo').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackBankAccountNo").load(" #feedBackBankAccountNo"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 

</script>

<script type="text/javascript">
    $('#updateBank_Bankbranch').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateBank_Bankbranch",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackBank_Bankbranch').fadeOut('fast', function(){
              $('#feedBackBank_Bankbranch').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackBank_Bankbranch").load(" #feedBackBank_Bankbranch"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    });
</script>





<script type="text/javascript">
    $('#updatePensionFundNo').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updatePensionFundNo",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackPensionFundNo').fadeOut('fast', function(){
              $('#feedBackPensionFundNo').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackPensionFundNo").load(" #feedBackPensionFundNo"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateMeritalStatus').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateMeritalStatus",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackMeritalStatus').fadeOut('fast', function(){
              $('#feedBackMeritalStatus').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackMeritalStatus").load(" #feedBackMeritalStatus"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateLineManager').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateLineManager",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackLineManager').fadeOut('fast', function(){
              $('#feedBackLineManager').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackLineManager").load(" #feedBackLineManager"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateContract').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeeContract",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackContract').fadeOut('fast', function(){
              $('#feedBackContract').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackContract").load(" #feedBackContract"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateEmployeePhoto').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateEmployeePhoto",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackEmployeePhoto').fadeOut('fast', function(){
              $('#feedBackEmployeePhoto').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackEmployeePhoto").load(" #feedBackEmployeePhoto"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
        });
    }); 
</script>

<script type="text/javascript">
    $('#updateOldID').submit(function(e){
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/updateOldID",
                 type:"post",
                 data:new FormData(this),
                 processData:false,
                 contentType:false,
                 cache:false,
                 async:false
             })
        .done(function(data){
         $('#feedBackOldID').fadeOut('fast', function(){
              $('#feedBackOldID').fadeIn('fast').html(data);
            });
    setTimeout(function(){// wait for 2 secs(2)
           $("#feedBackOldID").load(" #feedBackOldID"); // then reload the div to clear the success notification
      }, 2000); 
    //   $('#updateMiddleName')[0].reset();
        })
        .fail(function(){
     alert('Updation Failed!! ...'); 
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
    $('#deleteAllowance').submit(function(e){
        if (confirm("Are You Sure You Want To Delete This Allowance?") == true) {
        e.preventDefault(); 
             $.ajax({
                 url:"<?php echo  url(''); ?>/flex/deleteAllowance",
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
              } else if(data.status != 'SUCCESS'){
              alert("Allowance Not Deleted, Some Error Occured In Deleting");
              }
           $('#deleteFeedback').fadeOut('fast', function(){
          $('#deleteFeedback').fadeIn('fast').html(data.message);
        });
            $('#record'+id).hide();
               
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
    
     /*setTimeout(function(){// wait for 5 secs(2)
           location.reload(); // then reload the page.(3)
      }, 1000); */
      
        })
        .fail(function(){
     alert('Update Failed!! ...'); 
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

<script type="text/javascript">
    function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>

<script type="text/javascript">
    function readURL2(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#cropped').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp2").change(function() {
  readURL2(this);
});
</script>
