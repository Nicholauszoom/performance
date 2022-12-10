<!DOCTYPE html>
<html>

<head>
    <title>Larave Generate Invoice PDF - Nicesnippest.com</title>
</head>
<style type="text/css">
body {
    font-family: 'Roboto Condensed', sans-serif;
}

.m-0 {
    margin: 0px;
}

.p-0 {
    padding: 0px;
}

.pt-5 {
    padding-top: 5px;
}

.mt-10 {
    margin-top: 10px;
}

.text-center {
    text-align: center !important;
}

.w-100 {
    width: 100%;
}

.w-85 {
    width: 85%;
}

.w-15 {
    width: 15%;
}

.logo img {
    width: 45px;
    height: 45px;
    padding-top: 30px;
}

.logo span {
    margin-left: 8px;
    top: 19px;
    position: absolute;
    font-weight: bold;
    font-size: 25px;
}

.gray-color {
    color: #5D5D5D;
}

.text-bold {
    font-weight: bold;
}

.border {
    border: 1px solid black;
}

table tbody tr,
table thead th,
table tbody td {
    border: 1px solid #d2d2d2;
    border-collapse: collapse;
    padding: 7px 8px;
}

table tr th {
    background: #260464;
    font-size: 15px;
    color: white;
}

table tr td {
    font-size: 13px;
}

table {
    border-collapse: collapse;
    width: 80px;
}

.box-text p {
    line-height: 10px;
}

.float-left {
    float: left;
}

.total-part {
    font-size: 16px;
    line-height: 12px;
}

.total-right p {
    padding-right: 30px;
}

footer {
    color: #777777;
    width: 100%;
    height: 30px;
    position: fixed;
    bottom: 0;
    margin-top: 30px;
    border-top: 1px solid #aaaaaa;
    padding: 8px 0;
    text-align: center;
}

table tfoot tr:first-child td {
    border-top: none;
}

table tfoot tr td {
    padding: 7px 8px;
}


table tfoot tr td:first-child {
    border: none;
}

.wrapper{
    /* background: red; */
    padding: 0px 100px;
}

.print-area{
    margin-top: 40px;
    display: flex;
    align-items: flex-end;
    justify-content: end;
}

.print-btn{
    padding: 15px 25px;
    font-size: 1rem;
    color: #fff;
    background-color: #260464;
    border: none;
    border-radius: 2px;
}
</style>

<body>
    <!-- Define header and footer blocks before your content -->


    <!-- Wrap the content of your PDF inside a main tag -->

    <div class="head-title">
        <h1 class="text-center m-0 p-0">Bank ABC</h1>
        <h2 class="text-center m-0 p-0">EMPLOYEE KEY PERFORMANCE INDICATOR(KPI) PLAN</h2>
    </div>
    <div class="add-detail ">



        <div style="clear: both;"></div>
    </div>

    <div class="wrapper">
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <tbody>
                    <tr>
                        <th >Employee Basic Details</th>
                        <th class="w-50"></th>
                        <th class="w-50"></th>
                    </tr>
                    <tr>
                        <td>Name: <?php echo $basic_info->fname; ?> <?php echo $basic_info->mname; ?>
                            <?php echo $basic_info->lname; ?></td>
                        <td>Employee ID: <?php echo $basic_info->emp_id; ?> </td>
                        <td>Department: <?php echo $department->name; ?> </td>
                    </tr>
                    <tr>
                        <td>Teams Leaders Name: <?php if(!empty($line_manager)){  echo $line_manager->fname; ?> <?php echo $line_manager->mname; ?>
                            <?php echo $line_manager->lname; }?></td>
                        <td>Date Started: <?php echo $basic_info->hire_date; ?> </td>
                        <td>Date Updated: <?php echo $basic_info->contract_renewal_date; ?> </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-section bill-tbl w-100 mt-10">
            <table class="table w-100 mt-10">
                <thead>
                    <tr>
                        <th class="col-sm-1 w-50">Specific Priorities/Objectives For The Year</th>
                        <th class=" col-sm-2 w-50">Target</th>
                        <!-- <th class="col-sm-1 w-50">Charge Type</th>-->
                        <th class="col-sm-1 w-50">Start Date</th>
                        <th class="w-50">End Date</th>
                        <th class="w-50">Completion Date</th>
                        <th class="w-50">Status</th>
                        <th class="w-50">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-sm-1 w-50" colspan="7"><b><?php echo $Project_name->name; ?></b></td>

                    </tr>
                    <?php  
                    $total = 0; 
                    $n = 0;
                    ?>
                    <?php if(!empty($activity_result)){foreach($activity_result as $row){  ?>
                    <tr>
                        <td class="col-sm-1 w-50">4.<?php echo $row->deliverable_id.".".$row->id; ?>
                            <?php echo $row->name; ?></td>

                        <td class="col-sm-1 w-50"><?php echo $row->target; ?></td>
                        <td class="col-sm-1 w-50"><?php echo $row->start_date; ?></td>
                        <td class="col-sm-1 w-50"><?php echo $row->end_date; ?></td>
                        <td class="col-sm-1 w-50"><b></b></td>
                        <td class="col-sm-1 w-50"><?php if($row->target-$row->result == 0){
                            echo "Not Started";
                        }
                    
                        elseif($row->result != 0)
                        echo "In Progress";
                        elseif($row->target-$row->result == 0)
                        echo "Complete";

                        
                        
                        ?></td>
                        <td class="col-sm-1 w-50"><?php $n++; $total += ($row->result/$row->target)*100; echo ($row->result/$row->target)*100;  ?>%</td>

                    </tr>
                    <?php }}?>

                </tbody>

                <tfoot>

                </tfoot>
            </table>

            <table class="table w-100 mt-10">
                <tr>
                    <th class="col-sm-1 w-50" colspan="2">Comments to support PM rating,training andcareer development</th>


                </tr>
                <tr>
                    <td style="width: 50%;">

                        <div class="left" style="">
                            <div><u>
                                    <h3><b>Training and Career development Comments by Team Leaders</b></h3>
                                </u> </div>

                        </div>
                    </td>

                    <td style="width: 50%;">

                        <div class="left" style="">

                            <div><b>Performance and Rating</b>: <?php if($n != 0)echo $total/$n; ?>%  </div>
                            <div><b>Generated On</b>: <?php echo date('d/m/y');  ?></div>
                            <hr>
                            <div><b>Sign for Year-end:</b></div>
                            <div><b>Employee Signature</b>:...........................</div>
                            <div><b>Team Leader Signature</b>:.......................</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%;">

                        <div class="left" style="">
                            <div><u>
                                    <h3><b>Team Leaders Comments</b></h3>
                                </u> </div>

                        </div>
                    </td>
                    <td style="width: 50%;">

                        <div class="left" style="">
                            <div><u>
                                    <h3><b>Team Leaders Comments</b></h3>
                                </u> </div>

                        </div>
                    </td>
                </tr>



            </table>


        </div>

        <div class="print-area">
            <button type="button" onclick="window.print()" class="print-btn">Print</button>
        </div>
    </div>
    


</body>

</html>

<?php

   function convertNumberToWordsForIndia($number){
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
    '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
    '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
    '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
    '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
    '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
    '80' => 'eighty','90' => 'ninty');
    
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0,0,0,0,0,0,0,0,0);        
    $received_number_array = array();
    
    //Store all received numbers into an array
    for($i=0;$i<$number_length;$i++){    
  		$received_number_array[$i] = substr($number,$i,1);    
  	}

    //Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
        $number_array[$i] = $received_number_array[$j]; 
    }

    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){
        //"01,23,45,6,78"
        //"00,10,06,7,42"
        //"00,01,90,0,00"
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
                $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                $number_array[$i] = 0;
            }
               
        }
    }

    $value = "";
    for($i=0;$i<9;$i++){
        if($i==0 || $i==2 || $i==4 || $i==7){    
            $value = $number_array[$i]*10; 
        }
        else{ 
            $value = $number_array[$i];    
        }            
        if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
        if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
        if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
        if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
        if($i==6 && $value!=0){    $number_to_words_string.= "Hundred  "; }            

    }
    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
    return ucwords(strtolower("".$number_to_words_string));
}


?>