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
        color:#de6866;
    }
</style>

<div class="">

    <h6>Average Performance Per Person : {{ $average_performance}} </h6>
    <h6>Average Behaviour Per Person : {{ $average_behaviour}} </h6>

    @php
        if ($average_performance==$average_behaviour) {
            $value=$average_behaviour;
            $retVal = ($value<20) ?  $need_improvement=$value : $need_improvement=0;
            $retVal = ($value>20 && $value <40 ) ?  $good=$value :$good=0 ;
            $retVal = ($value>40 && $value <60 ) ?  $strong=$value :$strong=0 ;
            $retVal = ($value>60 && $value <80 ) ?  $very_strong=$value :$very_strong=0 ;
            $retVal = ($value>80 ) ?  $outstanding=$value :$outstanding=0 ;
           
        }
        else {

            // For Diagonal
            $retVal = ($average_behaviour<20 && $average_performance <20) ?  $need_improvement=$value : $need_improvement=0;
            $retVal = ($average_behaviour>20 && $average_behaviour <40 && $average_performance>20 && $average_performance <40  ) ?  $good=$average_behaviour+$average_performance/2 : $good=0;
            $retVal = ($average_behaviour>40 && $average_behaviour <60 && $average_performance>40 && $average_performance <60  ) ?  $strong=$average_behaviour+$average_performance/2 : $strong=0;
            $retVal = ($average_behaviour>60 && $average_behaviour <80 && $average_performance>60 && $average_performance <80  ) ?  $very_strong=$average_behaviour+$average_performance/2 : $very_strong=0;
            $retVal = ($average_behaviour>80  && $average_performance>80  ) ?  $outstanding=$average_behaviour+$average_performance/2 : $outstanding=0;

            // For Behaviour at need improvement
            $retVal = ($average_behaviour<20  && $average_performance>20 && $average_performance <40  ) ?  $improvement_good=$average_behaviour+$average_performance/2 : $improvement_good=0;
            $retVal = ($average_behaviour<20  && $average_performance>40 && $average_performance <60  ) ?  $improvement_strong=$average_behaviour+$average_performance/2 : $improvement_strong=0;
            $retVal = ($average_behaviour<20  && $average_performance>60 && $average_performance <80  ) ?  $improvement_very_strong=$average_behaviour+$average_performance/2 :  $improvement_very_strong=0;
            $retVal = ($average_behaviour<20  && $average_performance>80  ) ?  $improvement_outstanding=$average_behaviour+$average_performance/2 : $improvement_outstanding=0;

            // For Behaviour Good
            $retVal = ($average_behaviour>20 && $average_behaviour <40 && $average_performance>80  ) ?  $good_outstanding=$average_behaviour+$average_performance/2 : $good_outstanding=0;
            $retVal = ($average_behaviour>20 && $average_behaviour <40 && $average_performance>60 && $average_performance <80  ) ?  $good_very_strong=$average_behaviour+$average_performance/2 : $good_very_strong=0;
            $retVal = ($average_behaviour>20 && $average_behaviour <40 && $average_performance>40 && $average_performance <60  ) ?  $good_strong=($average_behaviour+$average_performance)/2 : $good_strong=0;
            $retVal = ($average_behaviour>20 && $average_behaviour <40 && $average_behaviour<20   ) ?  $good_improvement=$average_behaviour+$average_performance/2 : $good_improvement=0;

            // For  Behaviour Strong
            $retVal = ($average_behaviour>40 && $average_behaviour <60 && $average_performance>80  ) ?  $strong_outstanding=$average_behaviour+$average_performance/2 : $strong_outstanding=0;
            $retVal = ($average_behaviour>40 && $average_behaviour <60 && $average_performance>60 && $average_performance <80  ) ?  $strong_very_strong=$average_behaviour+$average_performance/2 : $strong_very_strong=0;
            $retVal = ($average_behaviour>40 && $average_behaviour <60 && $average_performance>20 && $average_performance <40  ) ?  $strong_good=$average_behaviour+$average_performance/2 : $strong_good=0;
            $retVal = ($average_behaviour>40 && $average_behaviour <60 && $average_behaviour<20   ) ?  $strong_improvement=$average_behaviour+$average_performance/2 : $strong_improvement=0;


            // For Very Strong Behaviour
            $retVal = ($average_behaviour>60 && $average_behaviour <80 && $average_performance>80  ) ?  $very_strong_outstanding=$average_behaviour+$average_performance/2 : $very_strong_outstanding=0;
            $retVal = ($average_behaviour>60 && $average_behaviour <80 && $average_performance>40 && $average_performance <60  ) ?  $very_strong__strong=$average_behaviour+$average_performance/2 : $very_strong_strong=0;
            $retVal = ($average_behaviour>60 && $average_behaviour <80 && $average_performance>20 && $average_performance <40  ) ?  $very_strong_good=$average_behaviour+$average_performance/2 : $very_strong_good=0;
            $retVal = ($average_behaviour>60 && $average_behaviour <80 && $average_behaviour<20   ) ?  $very_strong_improvement=$average_behaviour+$average_performance/2 : $very_strong_improvement=0;

            // For Outstanding Behaviour
            $retVal = ($average_behaviour>80 && $average_performance>80 && $average_performance <80  ) ?  $outstanding_very_strong=$average_behaviour+$average_performance/2 : $outstanding_very_strong=0;
            $retVal = ($average_behaviour>80  && $average_performance>40 && $average_performance <60  ) ?  $outstandiing_strong=$average_behaviour+$average_performance/2 : $outstanding_strong=0;
            $retVal = ($average_behaviour>80  && $average_performance>20 && $average_performance <40  ) ?  $outstanding_good=$average_behaviour+$average_performance/2 : $outstanding_good=0;
            $retVal = ($average_behaviour>80 && $average_behaviour<20   ) ?  $outstanding_improvement=$average_behaviour+$average_performance/2 : $outstanding_improvement=0;

            

        }
    @endphp
</div>
<div class="row">
    {{-- <col class="" ></div>/ --}}
    <div class="col-11">
        <div class="container" style="height:600px" id="container"></div>
    </div>
    <div class="col-1 p-1 bg-danger " style="width:50px;border:2px solid black;">
    <p class="text-center float-end" style="writing-mode: vertical-rl;text-orientation: mixed;color:white;text-align-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The "what" - delivery against objectives</p>
    </div>
    <div class="col-8 mx-auto p-1 bg-danger" style="height:50px;border:2px solid black;">
        <p class="text-center text-white"> The "how" - Values in Action</p>
    </div>
</div>


  <script src="{{ asset('js/anychart-core.min.js') }}"></script>
  <script src="{{ asset('js/anychart-heatmap.min.js') }}"></script>
  <script type="text/javascript">anychart.onDocumentReady(function () {

  // create the data 
  var data = [

    // First Column  
    { x: "Improvement Needed ", y: " Outstanding", heat: {{ $improvement_outstanding }}},
    { x: "Improvement Needed ", y: "very Strong ", heat:{{ $improvement_very_strong }} },
    { x: "Improvement Needed ", y: "Strong ", heat: {{ $improvement_strong }}},
    { x: "Improvement Needed ", y: "Good ", heat: {{ $improvement_good }} },
    { x: "Improvement Needed ", y: "Improvement Needed", heat: {{ $need_improvement }} },

    // Second Column
    { x: "Good ", y: " Outstanding", heat: {{ $good_outstanding }} },
    { x: "Good ", y: "very Strong ", heat: {{ $good_very_strong }}  },
    { x: "Good ", y: "Strong ", heat: {{ $good_strong }} },
    { x: "Good ", y: "Good ", heat: {{ $good }}  },
    { x: "Good ", y: "Improvement Needed", heat: {{ $good_improvement }} },

    // Third Column
    { x: "Strong ", y: " Outstanding", heat: {{ $strong_outstanding }} },
    { x: "Strong ", y: "very Strong ", heat: {{$strong_very_strong }} },
    { x: "Strong ", y: "Strong ", heat: {{ $strong }} },
    { x: "Strong ", y: "Good ", heat: {{$strong_good }} },
    { x: "Strong ", y: "Improvement Needed", heat: {{$strong_improvement }} },

    // Fourth Column

    { x: "Very Strong ", y: " Outstanding", heat: {{ $very_strong_outstanding }}  },
    { x: "Very Strong ", y: "very Strong ", heat: {{ $very_strong }} },
    { x: "Very Strong ", y: "Strong ", heat:  {{ $very_strong_strong }} },
    { x: "Very Strong ", y: "Good ", heat: {{ $very_strong_good }}  },
    { x: "Very Strong ", y: "Improvement Needed", heat: {{ $very_strong_improvement }} },

    // Fifth Column
    { x: "Outstanding ", y: " Outstanding", heat: {{ $outstanding }} },
    { x: "Outstanding ", y: "very Strong ", heat: {{ $outstanding_very_strong}} },
    { x: "Outstanding ", y: "Strong ", heat: {{ $outstanding_strong}} },
    { x: "Outstanding ", y: "Good ", heat: {{ $outstanding_good}} },
    { x: "Outstanding ", y: "Improvement Needed", heat: {{ $outstanding_improvement }} },
   
   

    

  ];        
        
  // create the chart and set the data
  chart = anychart.heatMap(data);
        
  // set the chart title
  chart.title("Performance Development Index by Region");
        
  // create and configure the color scale
  var customColorScale = anychart.scales.ordinalColor();
  customColorScale.ranges([
    { less: 20 },
    { from: 21, to: 40 },
    { from: 40, to: 60 },
    { from: 70, to: 80 },
    { greater: 80 }
  ]);
  
  // set the colors for each range, from smaller to bigger
  customColorScale.colors(["#736c6c", "#db9190", "#de6866", "#790f0d", "#5b0403"]);
        
  // set the color scale as the color scale of the chart
  chart.colorScale(customColorScale);
        
  // set the container id
  chart.container("container");

  // set the onclick

  chart.listen("pointDblClick", function(e){ 
//   var new_value = e.iterator.get("url");
//   window.open(new_value,"_blank"); var index = e.iterator.getIndex();

var index = e.iterator.getIndex();
//   var row = dataSet.row(index);

// alert(index)

if(index==0){
       alert("High Performer"+"High Potential",)



}

else if(index==1){
       alert("Medium Performer"+"Medium Potential",)


}
else if(index==2){
       alert("Low Performer"+"Low Potential",)

}

else if(index==3){
       alert("High Performer"+"Medium Potential")


}



else if(index==4){
       alert("Medium Performer"+"High Potential")


}



else if(index==5){
       alert("Low Performer"+"Medium Potential")


}



else if(index==6){
       alert("Low Performer"+"High Potential")


}



else if(index==7){
       alert("High Performer"+"Low Potential")

}


else if(index==8){
       alert("Medium Performer"+"Low Potential")


}






// alert("Hello, world!")
});




//   chart.container.
        
  // initiate drawing the chart
  chart.draw();
        
});</script>


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