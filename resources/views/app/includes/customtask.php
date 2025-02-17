
    <!-- ECharts -->
    <!-- <script src="../vendors/echarts/dist/echarts.min.js"></script> -->


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


       var echartBar = echarts.init(document.getElementById('mainb'), theme);

      echartBar.setOption({
        title: {
          text: 'Task Evaluation Graph',
          subtext: ''
        },
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['Quality', 'Quantity','Total']
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              title: {
                line: 'Line',
                bar: 'Bar',
                stack: 'Stack',
                tiled: 'Tiled'
              },
              type: ['line', 'bar', 'stack', 'tiled']
            },
            restore: {
              show: true,
              title: "Restore"
            },
            saveAsImage: {
              show: true,
              title: "Save Image"
            }
          }
        },
        calculable: true,
        
        xAxis: [{
          type: 'category',
          data: [

          <?php
     foreach ($chartvalue as $row) {
 echo "'".$row->NAME."',";
} 
 ?>

          ]
        }],


        yAxis: [{
          type: 'value'
        }],
        series: [{
          name: 'Quality',
          type: 'bar',
          data: [

      <?php
          foreach ($chartvalue as $row) {
          echo (number_format((float)$row->QUALITY, 2,'.','')).",";
            } 
      ?>

          ],
          markPoint: {
            data: [{
              type: 'max',
              name: 'Maximum Quality'
            }, {
              type: 'min',
              name: 'Minimum Quality'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average Quality'
            }]
          }
        }, {
          name: 'Quantity',
          type: 'bar',
          data: [

      <?php
        foreach ($chartvalue as $row) {
        echo (number_format((float)$row->QUANTITY, 2,'.','')).",";
          } 
      ?>

 ],
          markPoint: {
            data: [{
              type: 'max',
              name: 'Maximum Quantity'
            }, {
              type: 'min',
              name: 'Minimum Quantity'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average Quantity'
            }]
          }
        }, {
          name: 'Total',
          type: 'line',
          data: [

      <?php
        foreach ($chartvalue as $row) {
        echo (number_format((float)$row->TOTAL, 2,'.','')).",";
          } 
      ?>

 ],
          markPoint: {
            data: [{
              type: 'max',
              name: 'Maximum Marks'
            }, {
              type: 'min',
              name: 'Minimum Marks'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average Marks'
            }]
          }
        }]
      });

</script>