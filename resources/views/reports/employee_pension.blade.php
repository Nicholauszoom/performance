<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }

    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:200px;
        height:100px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tbody tr, table thead th, table tbody td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:30px;
    }
footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: -20px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }
 table tfoot tr td {
  padding:7px 8px;
        }


        table tfoot tr td:first-child {
            border: none;
        }

        .grid-container-element {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 50px;
    border: 1px solid black;
    width: 100%;
}
.grid-child-element1 {
    margin: 10px;
    width: 100%;
    border: 1px solid red;
}
.grid-child-element2 {
    margin: 10px;
    width: 100%;
    border: 1px solid red;
}

</style>
<body>

<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>

<div class="add-detail ">
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
        <tr>
            <th class="w-50"></th>
            <th class="w-50"></th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p> <strong>Employee :{{ $name }}</strong></p>
                    <p> <strong>Membership Number :</strong></p>
                    <p> <strong>Name Of Employer :</strong></p>

                    <p> <strong>Contribution Date :</strong></p>
                    <p> <strong>Date Of Leaving :</strong></p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>ee</p>
                    <p>33</p>
                    <p> <strong>Employer Number :</strong></p>
                 <p>Email: <a href=""></p>
                    <p>TIN : </p>
                </div>
            </td>
        </tr>
</tbody>
    </table>
</div>


< class="table-section bill-tbl w-100 mt-10">
    <u>  <h5><b>Year 2023</b></h5></u>
    <table class="table w-100 mt-10">
<thead>
        <tr>
             <th class="col-sm-1 w-50">No</th>
            <th class=" col-sm-2 w-50" >Month</th>
           <th class="col-sm-1 w-50">NSSF Number</th>
            <th class="w-50">Income</th>
            <th class="w-50">Employee Contrib</th>
            <th class="w-50">Employer Contrib</th>
            <th class=" col-sm-2 w-50">Total</th>
            <th class=" col-sm-2 w-50">Receipt No</th>
            <th class=" col-sm-2 w-50">Receipt Date</th>
        </tr>
</thead>
        <tbody>
            <tr>
                <td class=" w-50">No</td>
               <td class="  w-50" >Montd</td>
              <td class=" w-50">NSSF Number</td>
               <td class="w-50">Income</td>
               <td class="w-50">Employee Contrib</td>
               <td class="w-50">Employer Contrib</td>
               <td class="  w-50">Total</td>
               <td class="  w-50">Receipt No</td>
               <td class="  w-50">Receipt Date</td>
           </tr>
       </tbody>


    </table>

  <table class="table w-100 mt-10">
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div><u>  <h3><b>BANK DETAILS</b></h3></u> </div>
         <div><b>Account Name</b>:  DALASHO ENTERPRISES LIMITED</div>
        <div><b>Account Number</b>:  0150386968400 </div>
        <div><b>Bank Name</b>: CRDB BANK</div>
        <div><b>Branch</b>: OYSTERBAY BRANCH</div>
        <div><b>Swift Code</b>: Corutztz</div>
          </div>
        </tr>



</table>


</div>

</body>
</html>
