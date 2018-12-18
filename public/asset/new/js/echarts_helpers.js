function getTheme()
{
    var theme = {
  color: [
      '#299900', '#FF6E00', '#000080', '#FF0000',
      '#0051FF', '#7F00FF', '#FF00EE', '#bfd3b7'
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
    return theme;
}

// 新增 echart 圖表(折線圖,長條圖)
//  id = 元素 id, reqUrl = 要請求的 url
function createEchart(id, reqUrl, tableData)
{
  var obj = [];
  var unit = '';
  var max = null;
  var min = null;
  if ($('#' + id).length ){
    var echartLine = echarts.init(document.getElementById(id), getTheme());
    $.ajax({
      url: reqUrl,
      async: true,
      success: function(result){
          obj = JSON.parse(result);
          if (typeof(obj.unit) !== 'undefined') {
            unit = obj.unit;
          }
          if (typeof(obj.max) !== 'undefined') {
            max = obj.max;
          }
          if (typeof(obj.min) !== 'undefined') {
            min = obj.min;
          }

          createDataTable(tableData, obj);
          //console.log(obj);
          echartLine.setOption({
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                x: 220,
                y: 40,
                data: obj.legend,
                top: '1%',
                left: '1%',
            },
            toolbox: {
                show: true,
                feature: {
                    magicType: {
                        show: true,
                        title: {
                            line: '曲線',
                            bar: '長條',
                        },
                        type: ['line', 'bar',]
                    },
                    saveAsImage: {},
                }
            },
            dataZoom : {
                show : true,
                realtime: true,
                start : 0,
                end : 100
            },
            calculable: true,
            xAxis: [{
                type: 'category',
                // boundaryGap: false,
                data: obj.category
            }],
            yAxis: [{
                type: 'value',
                // min: min,
                // max: max,
                scale: true,
                axisLabel : {
                    formatter: '{value}' + unit
                }
            }],
            series: obj.data
        });
    }});
  }
  return obj;
}

// 新增 datatable
// id = 元素的 id
function createDataTable(id, obj)
{
    $('.dataTables_paginate').hide();

  if ($("#"+id).length) {
    var tb = $("#"+id).DataTable({
		  dom: 'pB',
		  columns: obj.columns,
		  data: obj.tableData,
		  buttons: [
			'excel',
		  ],
		  responsive: true
		});

	var pages = tb.page.info().pages;

	if(pages < 2){
		$("#"+ id +"_paginate").html('');
	}
  }

}