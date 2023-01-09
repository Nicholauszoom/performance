<script type="text/javascript">

    var config = {
        container: '#custom-colored',

        nodeAlign: 'BOTTOM',
        
        connectors: {
            type: 'step'
        },
        node: {
            HTMLclass: 'nodeExample1'
        }
    },

    // HEAD        HTMLclass: 'blue',
<?php

 foreach ($topposition as $rowtop) {

    echo $rowtop->POSITION." = {
        childrenDropLevel: 1,
        text:{
            name: '".$rowtop->NAME."',
            contact: 'Top Position'
        }
    },"; 
     
 } 
   
  foreach ($otherpositions as $rowother) {

    echo $rowother->child_position." = {
        parent:".$rowother->parent_position.",
        childrenDropLevel: 1,
        text:{
            name: '".$rowother->name."',
            contact: 'Head Counts: ".$rowother->head_counts."',
            title: 'Emp Cost: ".number_format($rowother->employment_cost, 2)."/='
            
        },
        link: {
            href: '". url('')."flex/cipay/position_info/".$rowother->positionID."'
        }
    },"; }

    echo "chart_config = [
        config,";
        
    
foreach ($allpositioncodes as $rowall) {

    echo $rowall->POSITION.","; 
    
} 
 echo "];";
?>


</script>
<!--DEPARTMENT-->
<script type="text/javascript">

    var configDept = {
        container: '#custom-colored_dept',

        nodeAlign: 'BOTTOM',
        
        connectors: {
            type: 'step'
        },
        node: {
            HTMLclass: 'nodeExample1'
        }
    },

    // HEAD        HTMLclass: 'blue',
<?php

 foreach ($topDepartment as $rowtop) {

    echo $rowtop->pattern." = {
        childrenDropLevel: 1,
        text:{
            name: '".$rowtop->name."',
            contact: 'Top Department'
        }
    },"; 
     
 } 
   
  foreach ($childDepartments as $rowother) {

    echo $rowother->child_department." = {
        parent:".$rowother->parent_department.",
        childrenDropLevel: 1,
        text:{
            name: '".$rowother->name."',
            contact: 'Head Counts: ".$rowother->head_counts."',
            title: 'Emp Cost: ".number_format($rowother->employment_cost, 2)."/='
            
        },
        link: {
            href: '". url('')."flex/cipay/department_info/".base64_encode($rowother->deptID)."'
        }
    },"; }

    echo "chart_config_dept = [
        configDept,";
        
    
foreach ($allDepartments as $rowall) {

    echo $rowall->department.","; 
    
} 
 echo "];";
?>


</script>
<!--End Department-->
<script>
    new Treant( chart_config );
</script>
<script>
    new Treant( chart_config_dept );
</script>