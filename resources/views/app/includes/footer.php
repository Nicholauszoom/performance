
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Flex Performance - <a href="https://mirajissa1@gmail.com">CITS</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    </body>


    <!-- jQuery -->
    <script src="<?php echo url();?>style/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo url();?>style/css/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Datatables -->
    <script src="<?php echo url();?>style/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo url();?>style/datatables/js/dataTables.bootstrap.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo url();?>style/date-picker/moment.min.js"></script>
    <script src="<?php echo url();?>style/date-picker/daterangepicker.js"></script>

     <!-- Switchery -->
    <script src="<?php echo url();?>style/select2/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo url();?>style/select2/select2.full.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php echo url();?>style/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <!-- Datatables -->

    <!-- notification Js -->
    <script src="<?php echo url();?>includes/notification/js/bootstrap-growl.min.js"></script>

    <script>

        $("a[href='#bottom']").click(function() {
    $('html, body').animate({
        scrollTop: $("#myForm").offset().top
    }, "slow");
});
    </script>

    <script>
      $(document).ready(function() {
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable').dataTable();

      });
    </script>

    <script>

      $(document).ready(function() {
        $('#datatable-task-table').DataTable({
          keys: true
        });

        $('#datatable-arrears').dataTable();
      });
    </script>

    <script> //For Deleting records without Page Refreshing

    function deleteOutputDomain(id)
    {
        if (confirm("Are You Sure You Want To Delete This Record From List?") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteoutcome');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Record Deleted Sussessifully!");
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Deleted, Error In Deleting");
               }

            $('#domain'+id).hide();
            // document.location.reload();

            }

            });
        }
    }




    function deleteDomain(id)
    {
        if (confirm("Are You Sure You Want To Revoke This Property From Whom was asssigned to!") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/deleteproperty');?>/"+id,
            success:function(data)
            {
              // success :function(result){
              // $('#alert').show();

              if(data.status == 'OK'){
              alert("Property Revoked Sussessifully!");
              }else if(data.status != 'SUCCESS'){
              alert("Property Not Revoked, Error In Revoking");
              }

            $('#domain'+id).hide();
            // document.location.reload();

            }

            });
        }
    }

    function deleteStrategy(id)
    {
        if (confirm("Are You Sure You Want To Delete This Strategy (All Outcome, Output and Task associated with this Strategy will be Deleted too)") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteStrategy');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Strategy Deleted Sussessifully!");
              $("#loadTable-outcome").load(" #loadTable-outcome");
              $("#loadTable-output").load(" #loadTable-output");
              }else if(data.status != 'SUCCESS'){
              alert("Strategy Not Deleted, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });
            $('#record'+id).hide();

            }

            });
        }
    }



    function selectStrategy(id)
    {
        if (confirm("Do You Want To Select This Strategy as Default") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/selectStrategy');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Strategy Selected Sussessifully!");
              location.reload();
              }else if(data.status != 'SUCCESS'){
              alert("Strategy Not Seleted, Some Error Occured");
              }
           $('#resultFeedback').fadeOut('fast', function(){
              $('#resultFeedback').fadeIn('fast').html(data.message);
            });

            }

            });
        }
    }

    function deleteOutcome(id)
    {
        if (confirm("Are You Sure You Want To Delete This Outcome (All  Output and Task associated with this Outcome will be Deleted too)") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteOutcome');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Outcome Deleted Sussessifully!");
              $("#loadTable-outcome").load(" #loadTable-outcome");
              $("#loadTable-output").load(" #loadTable-output");
              $('#record'+id).hide();
              }else if(data.status != 'SUCCESS'){
              alert("Outcome Not Deleted, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });


            }

            });
        }
    }

    function deleteOutput(id)
    {
        if (confirm("Are You Sure You Want To Delete This Output (All Task associated with this Output will be Deleted too)") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteOutput');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Output Deleted Sussessifully!");
              $("#loadTable-output").load(" #loadTable-output");
              $('#recordOutput'+id).hide();
              }else if(data.status != 'SUCCESS'){
              alert("Output Not Deleted, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });


            }

            });
        }
    }

    function deleteTask(id)
    {
        if (confirm("Are You Sure You Want To Delete This Task") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/deleteTask');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Task Deleted Sussessifully!");
              $('#recordTask'+id).hide();
              }else if(data.status != 'SUCCESS'){
              alert("Task Not Deleted, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });


            }

            });
        }
    }

     function selectOutcome(id)
    {
        if (confirm("Are You Sure You Want To Delete This Strategy (All Outcome, Output and Task associated with this Strategy will be Deleted too)"+id) == true) {
        var id = id;
        //TEST

         $('#outcomeSelect').submit(function(e){

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
 url: "<?php echo url(); ?>flex/home/"+id,
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
      $("#outcomeGraphTitle").load(" #outcomeGraphTitle");
      $("#outcomeGraph").load(" #outcomeGraph");
    })
    .fail(function(){
 alert('Outcome Title Updation Failed!! ...');
    });

});
    }
    }

    function cancelTask(id)
    {
        if (confirm("Are You Sure You Want To Cancel This Task") == true) {
        var id = id;
        $('#hide'+id).show();
        $.ajax({
            url:"<?php echo url('flex/performance/cancelTask');?>/"+id,
            success:function(data)
            {
              if(data.status == 'OK'){
              alert("Task Cancelled Sussessifully!");
              }else if(data.status != 'SUCCESS'){
              alert("Task Not Cancelled, Some Error Occured In Deleting");
              }
           $('#resultFeedback').fadeOut('fast', function(){
          $('#resultFeedback').fadeIn('fast').html(data.message);
        });
            // $('#recordTask'+id).hide();

            }

            });
        }
    }

</script>


    <script>
      $(document).ready(function() {
        $('#single_caltime').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'H:m'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>


    <script>
      $(document).ready(function() {
        $('#single_calmonth1').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>


    <script>
      $(document).ready(function() {
        $('#single_calmonth_year1').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>


    <script>
      $(document).ready(function() {
        $('#single_calmonth_year2').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>

    <!-- CALENDAR INITIALIZATION -->
    <script>
      $(document).ready(function() {
        $('#single_cal3').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      $(document).ready(function() {
        $('#single_cal_year').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      $(document).ready(function() {
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      $(document).ready(function() {
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'DD/MM/YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });

      $(document).ready(function() {
        $('#single_cal_year').daterangepicker({
          singleDatePicker: true,
          locale: {
            format: 'YYYY'
          },
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select a Line Manager",
          allowClear: true
        });

        $(".select1_single").select2({
          placeholder: "Select Position",
          allowClear: true
        });

        $(".select3_single").select2({
          placeholder: "Select Department",
          allowClear: true
        });

        $(".select4_single").select2({
          placeholder: "Select Employee",
          allowClear: true
        });

        $(".select_type").select2({
          placeholder: "Select Type",
          allowClear: true
        });

        $(".select2_type").select2({
          placeholder: "Select Type",
          allowClear: true
        });

        $(".select_course").select2({
          placeholder: "Select Course",
          allowClear: true
        });

        $(".select6_single").select2({
          placeholder: "Select Reference Output",
          allowClear: true
        });

        $(".select_country").select2({
          placeholder: "Select Country",
          allowClear: true
        });

          $(".select_segment").select2({
              placeholder: "Select Segment",
              allowClear: true
          });

          $(".select_funder").select2({
              placeholder: "Select Funder",
              allowClear: true
          });

          $(".select_employee").select2({
              placeholder: "Select Employee",
              allowClear: true
          });

        $(".select_group").select2({
          placeholder: "Select Group",
          allowClear: true
        });


        $(".select_bonus").select2({
          placeholder: "Select Bonus",
          allowClear: true
        });


        $(".select_pension").select2({
          placeholder: "Select Pension Fund",
          allowClear: true
        });

        $(".select_branch").select2({
          placeholder: "Select Branch",
          allowClear: true
        });

        $(".select_merital_status").select2({
          placeholder: "Select Merital Status",
          allowClear: true
        });

        $(".select_contract").select2({
          placeholder: "Select Merital Status",
          allowClear: true
        });

        $(".select_bank").select2({
          placeholder: "Select Bank",
          allowClear: true
        });

        $(".select_payroll_month").select2({
          placeholder: "Select Payroll Month",
          allowClear: true
        });

          $(".select_payroll_project").select2({
              placeholder: "Select Project",
              allowClear: true
          });

          $(".status").select2({
              placeholder: "Select Status",
              allowClear: true
          });

        $(".select_payroll_year").select2({
          placeholder: "Select Payroll Year",
          allowClear: true
        });

        $(".select_leave_type").select2({
          placeholder: "Select Leave Nature",
          allowClear: true
        });

        $(".select_bank_branch").select2({
          placeholder: "Select Bank Branch",
          allowClear: true
        });


        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "Max Selection Limit 4",
          allowClear: true
        });
        $(".select_multiple_employees").select2({
          maximumSelectionLength: 4,
          placeholder: "Select Employees (Max 4 Employees)",
          allowClear: true
        });

      });
    </script>

 <script>
  $('#update_company_info').submit(function(e){

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
 url: "<?php echo url(); ?>flex/update_postaladdress",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultfeed').fadeOut('fast', function(){
          $('#resultfeed').fadeIn('fast').html(data);
        });

  $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Postal Address Form Updation Failed!! ...');
    });

});
</script>


<!--Notification Processing-->
<script>
function loadlink(){

    $('#task_notification').load("<?php echo url('flex/performance/task_notification');?>", function () {
        //  $(this).unwrap();
            });
    $('#allnotifications').load("<?php echo url('flex/allnotifications');?>", function () {
    });

    $('#leave_notification').load("<?php echo url('flex/attendance/leave_notification');?>", function () {
    });

    $('#loan_notification').load("<?php echo url('flex/loan_notification');?>", function () {
    });

    $('#expire_contracts').load("<?php echo url('flex/expire_contracts_notification');?>", function () {
    });

    $('#retire').load("<?php echo url('flex/retire_notification');?>", function () {
    });

    $('#emp_activation').load("<?php echo url('flex/activation_notification');?>", function () {
    });
}
    loadlink(); // This will run on page load
    setInterval(function(){
        loadlink() // this will run after every 5 seconds
    }, 5000);

</script>
<!--Notification Processing-->


<!-- ATTENDANCE -->
<script type="text/javascript">
  $('#attendance').submit(function(e){

    e.preventDefault(); // Prevent Default Submission

    $.ajax({
 url: "<?php echo url(); ?>flex/attendance/attendance",
 type: 'POST',
 data: $(this).serialize(), // it will serialize the form data
        dataType: 'html'
    })
    .done(function(data){
     $('#resultAttendance').fadeOut('fast', function(){
          $('#resultAttendance').fadeIn('fast').html(data);
        });
 alert('Attendace Confirmed');
 location.reload();

//   $('#update_company_info')[0].reset();
    })
    .fail(function(){
 alert('Attendance Updation Faile, Check Your Network Connection and Retry');
    });

});
</script>
<!-- ATTENDANCE-->



<!-- Custom Theme Scripts -->
<script src="<?php echo url();?>style/build/js/custom.min.js"></script>
