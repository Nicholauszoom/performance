<script type="text/javascript">

var attandee_table = $('#datatable').DataTable({
            bPaginate: true,
            bInfo: true,
            ordering: false,
            columns: [
                {'data': 'SNo'},
                {'data': 'name'},
                {'data': 'DEPARTMENT'},
                {'data': 'time_in'},
                {'data': 'time_out'}
            ]
        });

$(document).ready(function(){
    $('#single_cal3').on('change',function(){
        var formValue = $(this).val();
        if(formValue){
            $.ajax({
                type:'POST',
                url:'<?php echo  url(''); ?>/flex/attendance/attendeesFetcher/',
                data:'due_date='+formValue,
                success:function(html){
                  let jq_json_obj = $.parseJSON(html);
                  let jq_obj = eval (jq_json_obj);
                  attandee_table.clear();
                  attandee_table.rows.add(jq_obj);
                  attandee_table.draw();
                    
                }
            });
        }
    });
});
</script>




<script>
  $(document).ready(function() {

    $('#department').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'<?php echo  url(''); ?>/flex/positionFetcher/',
                data:'dept_id='+stateID,
                success:function(html){
                    // $('#pos').html(html);
                    let jq_json_obj = $.parseJSON(html);
                    let jq_obj = eval (jq_json_obj);

                    //populate position
                    $("#pos option").remove();
                    $('#pos').append($('<option>', {
                        value: '',
                        text: 'Select Position',
                        selected: true,
                        disabled: true
                    }));
                    $.each(jq_obj.position, function (detail, name) {
                        $('#pos').append($('<option>', {value: name.id, text: name.name}));
                    });
                }
            });
        }else{
            // $('#pos').html('<option value="">Select state first</option>');
        }
    });
  });
</script>
