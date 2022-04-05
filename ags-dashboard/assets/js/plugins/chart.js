'use strict';
$(document).ready(function() {
    setTimeout(function() {
        floatchart()
    }, 700);
});

var arr = [];
var fdArr = [];
$.getJSON("classes/dashboard.php?Salesexcl", function(result){
    $.each(result, function(key, val){  
      arr.push(val[0].yesterday, val[3].yesterday, val[2].yesterday, val[1].yesterday);  
    });
});

$.getJSON("classes/dashboard.php?Purchase", function(result){
    $.each(result, function(key, val){  
      console.log(val);
      fdArr.push(val[0].yesterday, val[3].yesterday, val[1].yesterday, val[2].yesterday);  
    });
});

function floatchart() {
    $(function() {

        var options = {
            series: [{
            name: 'Revenue',
            data: arr
          }],           
          chart: {
            height: 350,
            type: 'bar',
          },
          plotOptions: {
            bar: {
              borderRadius: 10,
              columnWidth: '50%',
            }
          },
          dataLabels: {
            enabled: true
          },
          stroke: {
            width: 2
          },
          
          grid: {
            row: {
              colors: ['#fff', '#f2f2f2']
            }
          },
          xaxis: {
            labels: {
            rotate: -45
          },categories: ['T.Nagar', 'Allapakkam', 'Villivakkam', 'Navalur'],
            tickPlacement: 'on'
          },
          yaxis: {
            title: {
              text: 'Revenues(Rs)',
            },
          },
          fill: {
            type: 'gradient',
            gradient: {
              shade: 'light',
              type: "horizontal",
              shadeIntensity: 0.25,
              gradientToColors: undefined,
              inverseColors: true,
              opacityFrom: 0.85,
              opacityTo: 0.85,
              stops: [50, 0, 100]
            },
          },
	tooltip: {
          y: {
            formatter: function (val) {
              return "&#8377; " + val + ""
            }
          }
        }
          };

          var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
          chart.render();  
    });
    $(function() {
    var options = {
      series: fdArr,
      chart: {
      width: 380,
      type: 'pie',
    },
    labels: ['T.Nagar', 'Allapakkam', 'Navallur', 'Villivakkam'],
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }]
    };

    var chart = new ApexCharts(document.querySelector("#Purchasechart"), options);
    chart.render();
  });  
  
}
