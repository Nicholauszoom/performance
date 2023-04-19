@extends('layouts.vertical', ['title' => 'All Projects'])

@push('head-script')
<script src="{{ asset('assets/js/components/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/form_select2.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')

<style>
    p{
        color:#c24240;
    }
</style>

<div class="">


</div>
<div class="row">
    {{-- <col class="" ></div>/ --}}


    <div class="col-11">
        <div class="container" style="height:600px" id="container"></div>
    </div>
    <div class="col-1 p-1 bg-danger " style="width:50px;border:2px solid black;writing-mode: vertical-rl;text-orientation: mixed;">
    <p class="text-center " style="writing-mode: vertical-rl;text-orientation: mixed;color:white;text-align-center"> <i class="ph-arrow-fat-up"></i> The "what" - delivery against objectives</p>
    </div>
    <div class="col-8 mx-auto p-1 bg-danger" style="height:50px;border:2px solid black;">
        <p class="text-center text-white"> <i class="ph-arrow-fat-right"></i> The "how" - Values in Action</p>
    </div>
</div>
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

  <script src="{{ asset('js/anychart-core.min.js') }}"></script>
  <script src="{{ asset('js/anychart-heatmap.min.js') }}"></script>

  <script type="text/javascript">

  anychart.onDocumentReady(function () {

  // create the data
  var data = [

    // First Column
    { x: "Improvement Needed ", y: " Outstanding", heat: {{ $improvement_outstanding  }} },
    { x: "Improvement Needed ", y: "very Strong ", heat:{{ $improvement_very_strong }} },
    { x: "Improvement Needed ", y: "Strong ", heat: {{ $improvement_strong }}},
    { x: "Improvement Needed ", y: "Good ", heat: {{ $improvement_good }} },
    { x: "Improvement Needed ", y: "Improvement Needed", heat: {{ $improvement }} },

     // Second Column
    { x: "Good ", y: " Outstanding", heat: {{  $good_outstanding }} },
    { x: "Good ", y: "very Strong ", heat: {{ $good_very_strong }}   },
    { x: "Good ", y: "Strong ", heat: {{ $good_strong }} },
    { x: "Good ", y: "Good ", heat: {{ $good }} },
    { x: "Good ", y: "Improvement Needed", heat: {{ $good_improvement }} },

    // Third Column
    { x: "Strong ", y: " Outstanding", heat:  {{  $strong_outstanding }}},
    { x: "Strong ", y: "very Strong ", heat: {{ $strong_very_strong }} },
    { x: "Strong ", y: "Strong ", heat: {{ $strong }} },
    { x: "Strong ", y: "Good ", heat: {{ $strong_good }} },
    { x: "Strong ", y: "Improvement Needed", heat: {{ $strong_improvement }} },

    // // Fourth Column

    { x: "Very Strong ", y: " Outstanding", heat: {{ $very_strong_outstanding }}  },
    { x: "Very Strong ", y: "very Strong ", heat:  {{ $very_strong }} },
    { x: "Very Strong ", y: "Strong ", heat: {{ $very_strong_strong }} },
    { x: "Very Strong ", y: "Good ", heat:  {{ $very_strong_good }} },
    { x: "Very Strong ", y: "Improvement Needed", heat: {{ $very_strong_improvement }} },

    // // Fifth Column
    { x: "Outstanding ", y: " Outstanding", heat: {{ $outstanding }} },
    { x: "Outstanding ", y: "very Strong ", heat: {{ $outstanding_very_strong }} },
    { x: "Outstanding ", y: "Strong ", heat: {{ $outstanding_strong }} },
    { x: "Outstanding ", y: "Good ", heat: {{ $outstanding_good }} },
    { x: "Outstanding ", y: "Improvement Needed", heat: {{ $outstanding_improvement }} },





  ];

  // create the chart and set the data
  chart = anychart.heatMap(data);

  // set the chart title
  chart.title("Performance Development Index by Region");

  // create and configure the color scale
  var customColorScale = anychart.scales.ordinalColor();
  customColorScale.ranges([
    { less: 20 },//improvement
    { from: 20, to: 39.99 },//good
    { from: 40, to: 59.99 },//strong
    { from: 60, to: 79.99 },//very Strong
    { greater: 80 } //outstanding
  ]);

  // set the colors for each range, from smaller to bigger
  customColorScale.colors(["#736c6c", "#db9190", "#de6866","#c24240", "#690f0d",]);

  // set the color scale as the color scale of the chart
  chart.colorScale(customColorScale);

  // set the container id
  chart.container("container");

  // set the onclick

  chart.listen("pointDblClick", function(e){


  //var new_value = e.iterator.get("flex/financial_reports");
  //alert(new_value);
  // window.open(new_value,"_blank"); var index = e.iterator.getIndex();

var index = e.iterator.getIndex();
  //var row = dataSet.row(index);



if(index==0){

      var url ="{{route('flex.accelerationDetails',21)}}"
      window.location.href = url;




}

else if(index==1){

    var url ="{{route('flex.accelerationDetails',16)}}"
      window.location.href = url;



}
else if(index==2){
    var url ="{{route('flex.accelerationDetails',11)}}"
      window.location.href = url;

}

else if(index==3){
    var url ="{{route('flex.accelerationDetails',6)}}"
      window.location.href = url;


}



else if(index==4){
    var url ="{{route('flex.accelerationDetails',1)}}"
      window.location.href = url;


}



else if(index==5){

    var url ="{{route('flex.accelerationDetails',22)}}"
       window.location.href = url;


}
else if(index==6){
    var url ="{{route('flex.accelerationDetails',17)}}"
      window.location.href = url;
}

else if(index==7){
    var url ="{{route('flex.accelerationDetails',12)}}"
      window.location.href = url;

}


else if(index==8){
    var url ="{{route('flex.accelerationDetails',7)}}"
      window.location.href = url;


}
else if(index==9){
    var url ="{{route('flex.accelerationDetails',2)}}"
      window.location.href = url;


}
else if(index==10){
        var url ="{{route('flex.accelerationDetails',23)}}"
      window.location.href = url;


}
else if(index==11){
        var url ="{{route('flex.accelerationDetails',18)}}"
      window.location.href = url;
}
else if(index==12){
        var url ="{{route('flex.accelerationDetails',13)}}"
      window.location.href = url;
}
else if(index==13){
        var url ="{{route('flex.accelerationDetails',8)}}"
      window.location.href = url;
}
else if(index==14){
        var url ="{{route('flex.accelerationDetails',3)}}"
      window.location.href = url;
}
else if(index==15){
        var url ="{{route('flex.accelerationDetails',24)}}"
      window.location.href = url;
}
else if(index==16){
        var url ="{{route('flex.accelerationDetails',19)}}"
      window.location.href = url;
}
else if(index==17){
        var url ="{{route('flex.accelerationDetails',14)}}"
      window.location.href = url;
}
else if(index==18){
        var url ="{{route('flex.accelerationDetails',9)}}"
      window.location.href = url;
}
else if(index==19){
        var url ="{{route('flex.accelerationDetails',4)}}"
      window.location.href = url;
}
else if(index==20){
        var url ="{{route('flex.accelerationDetails',25)}}"
      window.location.href = url;
}
else if(index==21){
        var url ="{{route('flex.accelerationDetails',20)}}"
      window.location.href = url;
}
else if(index==22){
        var url ="{{route('flex.accelerationDetails',15)}}"
      window.location.href = url;
}
else if(index==23){
    alert(index);
        var url ="{{route('flex.accelerationDetails',10)}}"
      //window.location.href = url;
}
else if(index==24){
        var url ="{{route('flex.accelerationDetails',5)}}"
      window.location.href = url;
}







// alert("Hello, world!")
});




//   chart.container.

  // initiate drawing the chart
  chart.draw();


});



</script>


        </div>

        {{-- </[object Object]> --}}
<script>

jQuery(document).ready(function($){

    $('#advance_type').change(function () {

    $("#advance_type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#amount_mid').show();
            $("#amount_midf").removeAttr("disabled");
            $('#monthly_deduction').hide();
            $("#monthly_deductionf").attr("disabled", "disabled");

        } else if(value == "2") {
            $('#amount').show();
            $('#monthly_deduction').show();
            $("#amountf").removeAttr("disabled");
            $("#monthly_deductionf").removeAttr("disabled");
            $('#amount_mid').hide();
            $("#amount_midf").attr("disabled", "disabled");

        }

    });
  });


    $('#type').change(function () {

    $("#type option:selected").each(function () {
        var value = $(this).val();
        if(value == "1") {
            $('#deduction').show();
            $('#index_no').hide();
            $("#index_nof").attr("disabled", "disabled");
            $("#deductionf").removeAttr("disabled");

        } else if(value == "2") {
            $('#index_no').show();
            $('#deduction').hide();
            $("#deductionf").attr("disabled", "disabled");
            $("#index_nof").removeAttr("disabled");

        }

    });
  });


});


</script>

 @endsection
