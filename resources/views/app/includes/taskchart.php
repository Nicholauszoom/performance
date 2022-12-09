
    <!-- ECharts -->
    <!-- <script src="../vendors/echarts/dist/echarts.min.js"></script> -->


    <script src="<?php echo url();?>style/charts/echarts.min.js"></script>
    <script src="<?php echo url();?>style/charts/highcharts.js"></script>
    <script src="<?php echo url();?>style/charts/exporting.js"></script>
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
          data: ['Behaviour', 'Target','Total']
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
          name: 'Behaviour',
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
              name: 'Maximum Behaviour'
            }, {
              type: 'min',
              name: 'Minimum Behaviour'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average Behaviour'
            }]
          }
        }, {
          name: 'Target',
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
              name: 'Maximum Target'
            }, {
              type: 'min',
              name: 'Minimum Target'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average Target'
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

      // Wanted
      
      var echartBarLine = echarts.init(document.getElementById('outcome'), theme);

      echartBarLine.setOption({
        title: {
          x: 'center',
          y: 'top',
          padding: [0, 0, 20, 0],
          text: 'Project Perfomance :: Revenue vs Input vs Time Spent',
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
          data: ['Revenue', 'Cash Input', 'Time Spent'],
          y: 'bottom'
        },
        xAxis: [{
          type: 'category',
          data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        }],
        yAxis: [{
          type: 'value',
          name: 'Amount',
          axisLabel: {
            formatter: '{value} ml'
          }
        }, {
          type: 'value',
          name: 'Hours',
          axisLabel: {
            formatter: '{value} °C'
          }
        }],
        series: [{
          name: 'Revenue',
          type: 'bar',
          data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
        }, {
          name: 'Cash Input',
          type: 'bar',
          data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
        }, {
          name: 'Time Spent',
          type: 'line',
          yAxisIndex: 1,
          data: [2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
        }]
      });

      // 
    </script>