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

<div class="row">
    {{-- <col class="" ></div>/ --}}
    <div class="col-11">
        <div class="container" style="height:600px" id="container"></div>
    </div>
    <div class="col-1 p-1 " style="background:red;width:50px;">
    <p class="text-center" style="writing-mode: vertical-rl;text-orientation: mixed;color:white;"> Test</p>
    </div>
    <div class="col-8 mx-auto p-1" style="background:red;height:50px;">
        <p class="text-center text-white"> The "how"</p>
    </div>
</div>


  <script src="{{ asset('js/anychart-core.min.js') }}"></script>
  <script src="{{ asset('js/anychart-heatmap.min.js') }}"></script>
  <script type="text/javascript">anychart.onDocumentReady(function () {

  // create the data 
  var data = [

    // First Column  
    { x: "Improvement Needed ", y: " outstanding", heat: 10 },
    { x: "Improvement Needed ", y: "very Strong ", heat: 30 },
    { x: "Improvement Needed ", y: "Strong ", heat: 50 },
    { x: "Improvement Needed ", y: "Good ", heat: 20 },
    { x: "Improvement Needed ", y: "Improvement Needed", heat: 60 },

    // Second Column
    { x: "Good ", y: " outstanding", heat: 10 },
    { x: "Good ", y: "very Strong ", heat: 30 },
    { x: "Good ", y: "Strong ", heat: 50 },
    { x: "Good ", y: "Good ", heat: 20 },
    { x: "Good ", y: "Improvement Needed", heat: 60 },

    // Third Column
    { x: "Strong ", y: " outstanding", heat: 10 },
    { x: "Strong ", y: "very Strong ", heat: 30 },
    { x: "Strong ", y: "Strong ", heat: 50 },
    { x: "Strong ", y: "Good ", heat: 20 },
    { x: "Strong ", y: "Improvement Needed", heat: 60 },

    // Fourth Column

    { x: "Very Strong ", y: " outstanding", heat: 78 },
    { x: "Very Strong ", y: "very Strong ", heat: 50 },
    { x: "Very Strong ", y: "Strong ", heat: 80 },
    { x: "Very Strong ", y: "Good ", heat: 80 },
    { x: "Very Strong ", y: "Improvement Needed", heat: 10 },

    // Fifth Column
    { x: "Outstanding ", y: " outstanding", heat: 82 },
    { x: "Outstanding ", y: "very Strong ", heat: 78 },
    { x: "Outstanding ", y: "Strong ", heat: 89 },
    { x: "Outstanding ", y: "Good ", heat: 78 },
    { x: "Outstanding ", y: "Improvement Needed", heat: 21 },
   
   

    

  ];        
        
  // create the chart and set the data
  chart = anychart.heatMap(data);
        
  // set the chart title
  chart.title("Performance Development Index by Region");
        
  // create and configure the color scale
  var customColorScale = anychart.scales.ordinalColor();
  customColorScale.ranges([
    { less: 20 },
    { from: 21, to: 39 },
    { from: 40, to: 69 },
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