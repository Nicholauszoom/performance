<!DOCTYPE html>
<html>
<head>
    <title>Larave Generate Invoice PDF - Nicesnippest.com</title>
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
   <table class="table w-100 ">
<tfoot>

        <tr>
            <td class="w-50">
                <div class="box-text">
                      <img class="pl-lg" style="width: 133px;height:120px;" src="https://www.bancabc.co.tz/images/banc_abc_logo.png">
                </div>
            </td>

                  <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>

            <td class="w-50">
                <div class="box-text">
                   <p> <strong>Invoice :</strong></p>
      <p> <strong>Invoice Date : </strong></p>
                </div>
            </td>
        </tr>
</tfoot>
    </table>



    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p></p>
                    <p></p>
                    <p>Contact :</p>
                 <p>Email: </p>
                    <p>TIN : </p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>ee</p>
                    <p>33</p>
                     <p>Contact : </p>
                 <p>Email: <a href=""></p>
                    <p>TIN : </p>
                </div>
            </td>
        </tr>
</tbody>
    </table>
</div>
<!--
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div>
-->

<?php

                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;

                                 ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<thead>
        <tr>
             <th class="col-sm-1 w-50">#</th>
            <th class=" col-sm-2 w-50" >Route Name</th>
           <th class="col-sm-1 w-50">Charge Type</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Tax</th>
            <th class=" col-sm-2 w-50">Total</th>
        </tr>
</thead>
        <tbody>
             @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax;
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                 <?php
                                          //$item_name = App\Models\Pacel\PacelList::find($row->item_name);
                          $item_name = App\Models\Route::find($row->item_name);
                                        ?>
                <td>From {{$item_name->from}}  to  {{$item_name->to}} ({{$row->distance}} km)
                </td>
              <td>{{ $row->charge_type }} </td>
             <td >{{number_format($row->price ,2)}}</td>
                <td >{{ $row->quantity }}</td>

                <td>  {{number_format($row->total_tax ,2)}} {{$purchases->currency_code}}</td>
                <td >{{number_format($row->total_cost ,2)}} {{$purchases->currency_code}}</td>

            </tr>
           @endforeach
                                        @endif
       </tbody>

  <tfoot>
<tr>
            <td colspan="5">  </td>
                <td> </td>
               <td></td>
            </td>
        </tr>
  <tr>
       <tr>
            <td colspan="5">  </td>
                <td> <b> Sub Total</b></td>
               <td>22</td>
            </td>
        </tr>
  <tr>
            <td colspan="5">  </td>
                <td><b>  VAT  (18%)</b></td>
               <td>22</td>
            </td>
        </tr>

  <tr>
            <td colspan="5">  </td>
                <td><b>  Total Amount</b></td>
               <td>33</td>
            </td>
        </tr>
  </tfoot>
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
<!--
    <tr>
        <td style="width: 50%;">
            <div class="right" style="">
        <div><u> <h3><b> Account Details For Us-Dollar</b></h3></u> </div>
        <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632013 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
        <div></div>
        </div></td>
    </tr>
-->


</table>


</div>

<footer>
This is a computer generated invoice
</footer>
</body>
</html>
