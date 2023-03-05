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
  
      { x: "High Performer", y: "High Potential", heat: 10 },
      { x: "Medium Performer", y: "Medium Potential", heat: 20 },
      { x: "Low Performer", y: "Low Potential", heat: 40 },
     
      { x: "High Performer", y: "Medium Potential", heat: 5 },
      { x: "Medium Performer", y: "High Potential", heat: 8 },
      { x: "Low Performer", y: "Medium Potential", heat: 9 },
      { x: "Low Performer", y: "High Potential", heat: 9 },
  
      { x: "High Performer", y: "Low Potential", heat: 5 },
      { x: "Medium Performer", y: "Low Potential", heat: 7 },
      
  
    ];        
          
    // create the chart and set the data
    chart = anychart.heatMap(data);
          
    // set the chart title
    chart.title("Human Development Index by region (2010-2018)");
          
    // create and configure the color scale
    var customColorScale = anychart.scales.ordinalColor();
    customColorScale.ranges([
      { less: 5 },
      { from: 6, to: 10 },
      { from: 11, to: 15 },
      { greater: 16 }
    ]);
    
    // set the colors for each range, from smaller to bigger
    customColorScale.colors(["#CF7A78", "#E69645", "#69A231", "#4D7623"]);
          
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
 @endsection