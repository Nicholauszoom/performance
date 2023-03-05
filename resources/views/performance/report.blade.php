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