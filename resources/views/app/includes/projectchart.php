
    <!-- ECharts -->

    <script src="<?php echo  url('');?>style/charts/echarts.min.js"></script>
    <script src="<?php echo  url('');?>style/charts/highcharts.js"></script>
    <script src="<?php echo  url('');?>style/charts/exporting.js"></script>
<script>
      var theme = {
          color: [
              '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
              '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
              itemGap: 8,
              textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
              }
          },

          dataRange: {
              color: ['#1f610a', '#97b58d']
          },

          toolbox: {
              color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
              backgroundColor: 'rgba(0,0,0,0.5)',
              axisPointer: {
                  type: 'line',
                  lineStyle: {
                      color: '#408829',
                      type: 'dashed'
                  },
                  crossStyle: {
                      color: '#408829'
                  },
                  shadowStyle: {
                      color: 'rgba(200,200,200,0.3)'
                  }
              }
          },

          dataZoom: {
              dataBackgroundColor: '#eee',
              fillerColor: 'rgba(64,136,41,0.2)',
              handleColor: '#408829'
          },
          grid: {
              borderWidth: 0
          },

          categoryAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },

          valueAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitArea: {
                  show: true,
                  areaStyle: {
                      color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },
          timeline: {
              lineStyle: {
                  color: '#408829'
              },
              controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
              }
          },

          k: {
              itemStyle: {
                  normal: {
                      color: '#68a54a',
                      color0: '#a9cba2',
                      lineStyle: {
                          width: 1,
                          color: '#408829',
                          color0: '#86b379'
                      }
                  }
              }
          },
          map: {
              itemStyle: {
                  normal: {
                      areaStyle: {
                          color: '#ddd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  },
                  emphasis: {
                      areaStyle: {
                          color: '#99d2dd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  }
              }
          },
          force: {
              itemStyle: {
                  normal: {
                      linkStyle: {
                          strokeColor: '#408829'
                      }
                  }
              }
          },
          chord: {
              padding: 4,
              itemStyle: {
                  normal: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  },
                  emphasis: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  }
              }
          },
          gauge: {
              startAngle: 225,
              endAngle: -45,
              axisLine: {
                  show: true,
                  lineStyle: {
                      color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                      width: 8
                  }
              },
              axisTick: {
                  splitNumber: 10,
                  length: 12,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              axisLabel: {
                  textStyle: {
                      color: 'auto'
                  }
              },
              splitLine: {
                  length: 18,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              pointer: {
                  length: '90%',
                  color: 'auto'
              },
              title: {
                  textStyle: {
                      color: '#333'
                  }
              },
              detail: {
                  textStyle: {
                      color: 'auto'
                  }
              }
          },
          textStyle: {
              fontFamily: 'Arial, Verdana, sans-serif'
          }
      };
      

      <?php if($mode==1){ ?>
      
      var echartBarLineOutcomes = echarts.init(document.getElementById('outcomes'), theme);

      echartBarLineOutcomes.setOption({
        title: {
          x: 'center',
          y: 'top',
          padding: [0, 0, 20, 0],
          text: 'Overall Strategy Progress: <?php echo number_format($strategyProgress, 1); ?>%',
          textStyle: {
            fontSize: 15,
            fontWeight: 'normal'
          }
        },
        tooltip: {
          trigger: 'axis'
        },
        toolbox: {
          show: true,
          feature: {
            dataView: {
              show: true,
              readOnly: false,
              title: "Text View",
              lang: [
                "Text View",
                "Close",
                "Refresh",
              ],
            },
            restore: {
              show: true,
              title: 'Restore'
            },
            saveAsImage: {
              show: true,
              title: 'Save'
            }
          }
        },
        calculable: true,
        legend: {
          data: ['Outcome'/*, 'Input Cost', 'Time Spent'*/],
          y: 'bottom'
        },
        xAxis: [{
          type: 'category',
          
          data: [
              
              <?php foreach($outcomesGraph as $rowGraph){ 
              
              echo '"Outcome No: '.$rowGraph->SNo.'",'; } ?> 
              
              ]
        }],
        yAxis: [{
          type: 'value',
          name: 'Percentage',
          
        }],
        series: [{
          name: 'Outcome',
          type: 'bar',
          data: [
              
               <?php foreach($outcomesGraph as $rowGraph){ 
                  if($rowGraph->sumProgress==0||$rowGraph->sumProgress=='' || $rowGraph->taskCount==0 ) $progressStatus = 0; else {$progressStatus = ($rowGraph->sumProgress/$rowGraph->taskCount);}
              
              echo number_format($progressStatus, 2).','; } ?>
              
              ]
        }]
      });
      
      <?php } if($mode==2){ ?>
      
       var echartBarLineOutputs = echarts.init(document.getElementById('outputsGraph'), theme);
      
       echartBarLineOutputs.setOption({
        title: {
          x: 'center',
          y: 'top',
          padding: [0, 0, 20, 0],
          text: 'Overall Strategy Progress: <?php echo number_format($strategyProgress, 1); ?>%',
          textStyle: {
            fontSize: 15,
            fontWeight: 'normal'
          }
        },
        tooltip: {
          trigger: 'axis'
        },
        toolbox: {
          show: true,
          feature: {
            dataView: {
              show: true,
              readOnly: false,
              title: "Text View",
              lang: [
                "Text View",
                "Close",
                "Refresh",
              ],
            },
            restore: {
              show: true,
              title: 'Restore'
            },
            saveAsImage: {
              show: true,
              title: 'Save'
            }
          }
        },
        calculable: true,
        legend: {
          data: ['Outputs'],
          y: 'bottom'
        },
        xAxis: [{
          type: 'category',
          
          data: [
              
               <?php foreach($outputsGraph as $rowGraphOutput){ 
              
              echo '"Output No: '.$rowGraphOutput->SNo.'",'; } ?> 
              
              ]
        }],
        yAxis: [{
          type: 'value',
          name: 'Percentage',
          
        }],
        series: [{
          name: 'Output',
          type: 'bar',
          data: [
              
               <?php foreach($outputsGraph as $rowGraphOutput){ 
                  if($rowGraphOutput->sumProgress==0||$rowGraphOutput->sumProgress=='' || $rowGraphOutput->countTask==0 ) $progressStatus = 0; else {$progressStatus = ($rowGraphOutput->sumProgress/$rowGraphOutput->countTask);}
              
              echo number_format($progressStatus, 2).','; } ?>  
              
              ]
        }]
      });
      <?php }  ?>
      
      
    </script>