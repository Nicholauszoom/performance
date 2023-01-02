<script type="text/javascript">
    $('#updateName').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updatePensionName") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

            //   $('#updateName')[0].reset();
        })
        .fail(function(){
             alert('Update Failed!! ...');
        });
    });
</script>

<script type="text/javascript">
    $('#percentEmployee').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updatePercentEmployee") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

            //   $('#updateName')[0].reset();
        })
        .fail(function(){
            alert('Update Failed!! ...');
        });
    });
</script>

<script type="text/javascript">
    $('#percentEmployer').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updatePercentEmployer") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

            //   $('#updateName')[0].reset();
        })
        .fail(function(){
            alert('Update Failed!! ...');
        });
    });
</script>

<script type="text/javascript">
    $('#deductionFrom').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updatePensionPolicy") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateDeductionName').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updateDeductionName") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateDeductionAmount').submit(function(e){
        e.preventDefault();

        $.ajax({
            url:'{{ url("/flex/updateDeductionAmount") }}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateDeductionPercent').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateDeductionPercent") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateDeductionPolicy').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateDeductionPolicy") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateMealsName').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateMealsName") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateMealsMargin').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateMealsMargin") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateMealsLowerAmount').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateMealsLowerAmount") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
    $('#updateMealsUpperAmount').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url:'{{ url("/flex/updateMealsUpperAmount") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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


    $('#MODIFIES').submit(function(e){
        e.preventDefault();
             $.ajax({
                 url: '{{ url("/flex/updateCompanyName") }}',
                 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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

        setTimeout(function(){// wait for 5 secs(2)
        $("#feedBackSubmission").load(" #feedBackSubmission");
      }, 3000);

        })
        .fail(function(){
     alert('Upload Failed!! ...');
        });
    });
</script>

