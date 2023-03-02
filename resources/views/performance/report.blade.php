<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <title>Basic JavaScript Heat Map Chart with Custom Color Scale</title>
  <link href="https://playground.anychart.com/MJw05U3Q/iframe" rel="canonical">
  <meta content="HeatMap Chart" name="keywords">
  <meta content="AnyChart - JavaScript Charts designed to be embedded and integrated" name="description">
  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  <style>html, body, #container {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}</style>
 </head>
 <body>
  <div id="container"></div>
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
 </body>
</html>