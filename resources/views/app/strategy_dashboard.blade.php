@extends('layouts.vertical', ['title' => 'Dashboard'])

@push('head-script')
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
@endpush

@push('head-scriptTwo')
<script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endpush

@section('content')


@include ("app/includes/strategy_charts");

<?php
        foreach ($summary as $row) {
        $employees = $row->EMPLOYEES;
          } 


          foreach ($appreciated as $row) {
        $name = $row->NAME;
        $id = $row->empID;
        $position = $row->POSITION;
        $department = $row->DEPARTMENT;
        $description = $row->description;
        $date = $row->date_apprd;
        $photo = $row->photo;
          }  

          foreach ($taskline as $row) {
        $all = $row->ALL_TASKS;
        $completed = $row->COMPLETED;
          } 


          foreach ($taskstaff as $row) {
        $allstaff = $row->ALL_TASKSTAFF;
        $allstaff_completed = $row->COMPLETEDSTAFF;
          }      
      
      ?>
      
        <!-- page content -->
        <div class="right_col" role="main">

            <div class="page-title">
              <div class="title_left">
                <h3>Performance 
                  <?php if( session('manage_strat') != ''){ ?>
                  <a href ="<?php echo  url(''); ?>/flex/home" style="float: right;"><button type="button" class="btn btn-main btn-xs">
                        Switch to Home Dashboard
                        </button></a> <?php } ?>
                        </h3>
              </div>
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>TRACK TO COMPLETION<small>Strategy. Outcome, Output and Tasks</small>
                      <a href ="<?php echo  url(''); ?>/flex/performance/printDashboard" target = "blank"><button type="button" name="print" value ="print" class="btn btn-info">EXPORT</button></a>

                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">

                    <table class="table table-bordered">
                        
                    <h4><b>Strategy Name: </b> <?php echo $strategyTitle; ?><br><br>
                    <b>Progress: </b> <?php echo number_format($strategyProgress, 1)."%"; ?></h4>
                      <thead>
                        <tr>
                          <th></th>
                          <th><b>Outcomes</b></th>
                          <th><b>Outputs</b></th>
                          <th><b>Tasks</b></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th><b>Not Started</b></th>
                          <td><?php echo $notStartedOutcome; ?></td>
                          <td><?php echo $notStartedOutput; ?></td>
                          <td><?php echo $notStartedTask; ?></td>
                        </tr>
                        <tr>
                          <th ><b>In Progress</b></th>
                          <td><?php  echo $progressOutcome; ?></td>
                          <td><?php  echo $progressOutput; ?></td>
                          <td><?php echo $progressTask; ?></td>
                        </tr>
                        <tr>
                          <th><b>Completed</b></th>
                          <td><?php echo $completedOutcome; ?></td>
                          <td><?php echo $completedOutput; ?></td>
                          <td><?php echo $completedTask; ?></td>
                        </tr>
                        <tr>
                          <th ><b>Total</b></th>
                          <td><?php echo $progressOutcome+$completedOutcome+$notStartedOutcome; ?></td>
                          <td><?php echo $progressOutput+$completedOutput+$notStartedOutput; ?></td>
                          <td><?php echo $progressTask+$completedTask+$notStartedTask; ?></td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              
            <div class="col-md-12 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>TRACK TO SCHEDULE<small> Outcome, Output and Tasks</small>

                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                       
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card">
                          <div class="card-head">
                            <h2>Outcome Analysis</h2>
                            <div class="clearfix"></div>
                          </div>        
                            <div id="canvas-holder" style="width: 290px;">
                              <canvas id="chart-outcome" width="300" height="300"></canvas>
                              <div id="chartjs-tooltip">
                                <table></table>
                              </div>
                            </div>
                        </div>
                      </div>
                       
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card">
                          <div class="card-head">
                            <h2>Output Analysis</h2>
                            <div class="clearfix"></div>
                          </div>        
                            <div id="canvas-holder" style="width: 290px;">
                              <canvas id="chart-output" width="300" height="300"></canvas>
                              <div id="chartjs-tooltip">
                                <table></table>
                              </div>
                            </div>
                        </div>
                      </div>
                       
                       <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="card">
                          <div class="card-head">
                            <h2>Task Analysis</h2>
                            <div class="clearfix"></div>
                          </div>        
                            <div id="canvas-holder" style="width: 290px;">
                              <canvas id="chart-task" width="300" height="300"></canvas>
                              <div id="chartjs-tooltip">
                                <table></table>
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>

            <div class="row">               
              <!-- bar chart -->
              <div class="col-md-12 col-sm-8 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>PROGRESS TO COMPLETION (Outcomes)</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <div id="outcomechart" style="width: 100%; height: 400px;"></div>

                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-8 col-xs-12">
                <div class="card">
                  <div class="card-head">
                    <h2>PROGRESS TO COMPLETION (Outputs)</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="card-body">
                      <div id="outputchart" style="width: 100%; height: 400px;"></div>
                  </div>
                   
                </div>
              </div>
              
              </div>
              

            </div>
          </div>
        </div>
        <!-- /page content -->

       <?php
       // @include("app/includes/homecharts")
        ?>
       
       <script>
            var outcomesChart;

            var outcomeChartData = [
                <?php foreach($outcomesGraph as $row){
                  if($row->taskCount==0){$taskCount = 1;} else {$taskCount =$row->taskCount;}
                    $percent = $row->sumProgress/(100*$taskCount); ?>
                {
                    "outcome": "<?php echo $row->strategy_ref.'.'.$row->id; ?>",
                    "percent": <?php echo 100*number_format($percent, 2); ?>,
                    "url": "<?php echo  url('')."flex/performance/outcome_info/?id=".base64_encode($row->strategy_ref."|".$row->id); ?>"
                }, 
                <?php } ?>
            ];           
            
            /*var chartData = [
                {
                    "country": "USA",
                    "visits": 4025,
                    "url": "https://en.wikipedia.org/wiki/France"
                },
                {
                    "country": "China",
                    "visits": 1882
                },
                {
                    "country": "Poland",
                    "visits": 328
                }
            ];*/


            var outcomesChart = AmCharts.makeChart("outcomechart", {
                type: "serial",
                dataProvider: outcomeChartData,
                categoryField: "outcome",
                depth3D: 0,
                angle: 0,

                categoryAxis: {
                    labelRotation: 45,
                    gridPosition: "start"
                },

                valueAxes: [{
                    title: "Percentage Completion"
                }],

                graphs: [{

                    valueField: "percent",
                    type: "column",
                    fillColors: "#69a77d",
                    urlField: "url",
                    urlTarget: "_self",
                    lineAlpha: 0,
                    fillAlphas: 0.8
                }],

                chartCursor: {
                    cursorAlpha: 0,
                    zoomable: false,
                    categoryBalloonEnabled: false
                },
                "export": {
                    "enabled": true
                }

            });


            




        </script>
        <script>
        
            var outputsChart;
        
             var outputChartData = [
                    <?php foreach($outputsGraph as $rowOutput){
                      if($rowOutput->taskCount==0){$taskCount = 1;} else {$taskCount =$rowOutput->taskCount;}
                        $percentOut = $rowOutput->sumProgress/(100*$taskCount); ?>
                    {
                        "output": "<?php echo $rowOutput->strategy_ref.'.'.$rowOutput->outcome_ref.'.'.$rowOutput->id; ?>",
                        "percentoutput": <?php echo 100*number_format($percentOut, 2); ?>,
                        "url": "<?php echo  url('')."flex/performance/output_info/?id=".base64_encode($rowOutput->strategy_ref."|".$rowOutput->outcome_ref."|".$rowOutput->id); ?>"
                    }, 
                    <?php } ?>
                ];
        
        
            var outputsChart = AmCharts.makeChart("outputchart", {
                type: "serial",
                dataProvider: outputChartData,
                categoryField: "output",
                depth3D: 0,
                angle: 0,

                categoryAxis: {
                    labelRotation: 45,
                    gridPosition: "start"
                },

                valueAxes: [{
                    title: "Percentage Completion"
                }],

                graphs: [{

                    valueField: "percentoutput",
                    type: "column",
                    fillColors: "#69a77d",
                    urlField: "url",
                    urlTarget: "_self",
                    lineAlpha: 0,
                    fillAlphas: 0.8
                }],

                chartCursor: {
                    cursorAlpha: 0,
                    zoomable: false,
                    categoryBalloonEnabled: false
                },
                "export": {
                    "enabled": true
                }

            });
        </script>

<script>

    var outcomeChartData = [ <?php echo $completedOutcome.','.$overdueOutcome.','.$outcomeOffTrack.','.$outcomeOnTrack; ?>];
    var outputChartData = [ <?php echo $completedOutput.','.$overdueOutput.','.$outputOffTrack.','.$outputOnTrack; ?>];
    var taskChartData = [ <?php echo $completedTask.','.$overdueTask.','.$taskOffTrack.','.$taskOnTrack; ?>];

    var outcomeConfig = {
      type: 'pie',
      data: {
        datasets: [{
          data: outcomeChartData,
          backgroundColor: [
            '#27AE60','#E74C3C' ,'#F39C12','#839192',
          ],
        }],
        labels: ['Completed', 'Overdue', 'Delayed', 'On Track']
      },
      options: {
        responsive: true,
        legend: {
          display: true
        },
        tooltips: {
          enabled: true,          
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              var currentValue = dataset.data[tooltipItem.index];
              var percentage = Math.floor(((currentValue/total) * 100)+0.5);

              return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '('+percentage+'%)';
            }
          }
        }
      }
    };

    var outputConfig = {
      type: 'pie',
      data: {
        datasets: [{
          data: outputChartData,
          backgroundColor: [
            '#27AE60','#E74C3C' ,'#F39C12','#839192',
          ],
        }],
        labels: ['Completed', 'Overdue', 'Delayed', 'On Track']
      },
      options: {
        responsive: true,
        legend: {
          display: true
        },
        tooltips: {
          enabled: true,          
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              var currentValue = dataset.data[tooltipItem.index];
              var percentage = Math.floor(((currentValue/total) * 100)+0.5);

              return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '('+percentage+'%)';
            }
          }
        }
      }
    };


    var taskConfig = {
      type: 'pie',
      data: {
        datasets: [{
          data: taskChartData,
          backgroundColor: [
            '#27AE60','#E74C3C' ,'#F39C12','#839192',
          ],
        }],
        labels: ['Completed', 'Overdue', 'Delayed', 'On Track']
      },
      options: {
        responsive: true,
        legend: {
          display: true
        },
        tooltips: {
          enabled: true,          
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              var currentValue = dataset.data[tooltipItem.index];
              var percentage = Math.floor(((currentValue/total) * 100)+0.5);

              return data['labels'][tooltipItem['index']] + ': ' + data['datasets'][0]['data'][tooltipItem['index']] + '('+percentage+'%)';
            }
          }
        }
      }
    };
  window.onload = function() {
    var outcomeContext = document.getElementById('chart-outcome').getContext('2d');
    var outputContext = document.getElementById('chart-output').getContext('2d');
    var taskContext = document.getElementById('chart-task').getContext('2d');
    var outcomeChart = new Chart(outcomeContext, outcomeConfig);
    var outputChart = new Chart(outputContext, outputConfig);
    var taskChart = new Chart(taskContext, taskConfig);

    document.getElementById("chart-outcome").onclick = function(evt){
      var activePoints = outcomeChart.getElementsAtEvent(evt);
      var firstPoint = activePoints[0];

      var label = outcomeChart.data.labels[firstPoint._index];
      var value = outcomeChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
      
      var url = "<?php echo  url(''); ?>/flex/performance/outcome"+label.replace(/\s/g, '').toLowerCase();
      window.location.href = url;
      // window.open(url);
    };

    document.getElementById("chart-output").onclick = function(evt){
      var activePoints = outputChart.getElementsAtEvent(evt);
      var firstPoint = activePoints[0];

      var label = outputChart.data.labels[firstPoint._index];
      var value = outputChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
      
      var url = "<?php echo  url(''); ?>/flex/performance/output"+label.replace(/\s/g, '').toLowerCase();
      window.location.href = url;
      // window.open(url);
    };
    document.getElementById("chart-task").onclick = function(evt){
      var activePoints = taskChart.getElementsAtEvent(evt);
      // 
      var firstPoint = activePoints[0];

      // use _datasetIndex and _index from each element of the activePoints array
      var label = taskChart.data.labels[firstPoint._index];
      var value = taskChart.data.datasets[firstPoint._datasetIndex].data[firstPoint._index];
      
      var url = "<?php echo  url(''); ?>/flex/performance/task"+label.replace(/\s/g, '').toLowerCase();
      // alert(url);
      window.location.href = url;
      // window.open(url);
    };
  };
</script>
 @endsection