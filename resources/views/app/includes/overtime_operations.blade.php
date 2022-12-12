<script>

    function holdOvertime(id)
    {
        if (confirm("Are You Sure You Want to Hold This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/holdOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">HELD</span></div>');
                });
             alert('Request Canceled!');
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Hold Failed!! ...');
                });
        }
    }

     function approveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/approveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }




    function lineapproveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/lineapproveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }
    function hrapproveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/hrapproveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }

    function fin_approveOvertime(id)
    {
        if (confirm("Are You Sure You Want to Approve This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/fin_approveOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             /*$('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-success">APPROVED</span></div>');
                });*/
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Approval Failed!! ...');
                });
        }
    }


    function denyOvertime(id)
    {
        if (confirm("Are You Sure You Want to Dissaprove This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/denyOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             $('#record'+id).fadeOut('fast', function(){
                  $('#record'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-danger">DISAPPROVED</span></div>');
                });
             alert('Request Dissaproved! ...');
                })
            .fail(function(){
             alert('Overtime Dissaproval Failed!! ...');
                });
        }
    }


    function recommendOvertime(id)
    {
        if (confirm("Are You Sure You Want to Recommend This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/recommendOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
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
             alert('Overtime Recommendation Failed!! ...');
                });
        }
    }



    function confirmOvertime(id)
    {
        if (confirm("Are You Sure You Want to Confirm This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/confirmOvertime') }}/"+overtimeid
            })
            .done(function(data){
             $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-info">CONFIRMED</span></div>');
                });
             alert('Request Confirmed Successifully!! ...');
             setTimeout(function() {
                location.reload();
             }, 2000);
                })
            .fail(function(){
             alert('Overtime Confirmation Failed!! ...');
                });
        }
    }




    function cancelOvertime(id)
    {
        if (confirm("Are You Sure You Want to Cancel This Overtime Request") == true) {
        var overtimeid = id;

            $.ajax({
                url: "{{ url('flex/cancelOvertime') }}/"+overtimeid
            })
            .done(function(data){
               $('#resultfeedOvertime').fadeOut('fast', function(){
                  $('#resultfeedOvertime').fadeIn('fast').html(data);
                });
             $('#status'+id).fadeOut('fast', function(){
                  $('#status'+id).fadeIn('fast').html('<div class="col-md-12"><span class="label label-warning">CANCELLED</span></div>');
                });
             alert('Request Cancelled Successifully!! ...');
             setTimeout(function() {
                location.reload();
             }, 1000);
                })
            .fail(function(){
             alert('Overtime Cancellation Failed!! ...');
                });
        }
    }


</script>
