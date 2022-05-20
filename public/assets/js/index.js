$(function() {
    "use strict";

	
// chart 1

var ctx = document.getElementById('chart1').getContext('2d');


var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#008cff');
    gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');


    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Actual registration',
          data: [3, 30, 10, 10, 22, 12, 5,10,20,30,40,5],
          pointBorderWidth: 2,
          pointHoverBackgroundColor: gradientStroke1,
          backgroundColor: gradientStroke1,
          borderColor: gradientStroke1,
          borderWidth: 3
        }]
      },
      options: {
          maintainAspectRatio: false,
          legend: {
            position: 'bottom',
            display:false
          },
          tooltips: {
            displayColors:false,	
            mode: 'nearest',
            intersect: false,
            position: 'nearest',
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10
          }
       }
    });


	  
    var ctx = document.getElementById('chart11').getContext('2d');


var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#008cff');
    gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');


    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Actual registration',
          data: [3, 30, 10, 10, 22, 12, 5,10,20,30,40,5],
          pointBorderWidth: 2,
          pointHoverBackgroundColor: gradientStroke1,
          backgroundColor: gradientStroke1,
          borderColor: gradientStroke1,
          borderWidth: 3
        }]
      },
      options: {
          maintainAspectRatio: false,
          legend: {
            position: 'bottom',
            display:false
          },
          tooltips: {
            displayColors:false,	
            mode: 'nearest',
            intersect: false,
            position: 'nearest',
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10
          }
       }
    });

	 
// chart 2

 var ctx = document.getElementById("chart2").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#fc4a1a');
      gradientStroke1.addColorStop(1, '#f7b733');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#4776e6');
      gradientStroke2.addColorStop(1, '#8e54e9');



      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ["Catking", "Non-Catking"],
          datasets: [{
            backgroundColor: [
              gradientStroke1,
              gradientStroke2
            ],
            hoverBackgroundColor: [
              gradientStroke1,
              gradientStroke2
            ],
            data: [20, 80],
			borderWidth: [1, 1]
          }]
        },
        options: {
			maintainAspectRatio: false,
			cutoutPercentage: 75,
            legend: {
			  position: 'bottom',
              display: false,
			  labels: {
                boxWidth:8
              }
            },
			tooltips: {
			  displayColors:false,
			}
        }
      });

   

// worl map

jQuery('#geographic-map-2').vectorMap(
{
    map: 'world_mill_en',
    backgroundColor: 'transparent',
    borderColor: '#818181',
    borderOpacity: 0.25,
    borderWidth: 1,
    zoomOnScroll: false,
    color: '#009efb',
    regionStyle : {
        initial : {
          fill : '#008cff'
        }
      },
    markerStyle: {
      initial: {
				r: 9,
				'fill': '#fff',
				'fill-opacity':1,
				'stroke': '#000',
				'stroke-width' : 5,
				'stroke-opacity': 0.4
                },
                },
    enableZoom: true,
    hoverColor: '#009efb',
    markers : [{
        latLng : [21.00, 78.00],
        name : 'Lorem Ipsum Dollar'
      
      }],
    hoverOpacity: null,
    normalizeFunction: 'linear',
    scaleColors: ['#b6d6ff', '#005ace'],
    selectedColor: '#c9dfaf',
    selectedRegions: [],
    showTooltip: true,
});


// chart 3

//  var ctx = document.getElementById('chart3').getContext('2d');


//   var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
//       gradientStroke1.addColorStop(0, '#008cff');
//       gradientStroke1.addColorStop(1, 'rgba(22, 195, 233, 0.1)');

//       var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
//       gradientStroke2.addColorStop(0, '#fc4a1a');
//       gradientStroke2.addColorStop(1, '#f7b733');

//       var myChart = new Chart(ctx, {
//         type: 'line',
//         data: {
//           labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
//           datasets: [{
//             label: 'Actual registration',
//             data: [3, 30, 10, 10, 22, 12, 5],
//             pointBorderWidth: 2,
//             pointHoverBackgroundColor: gradientStroke1,
//             backgroundColor: gradientStroke1,
//             borderColor: gradientStroke1,
//             borderWidth: 3
//           },
//           {
//             label: 'Target profile registration',
//             data: [30, 50, 15, 5, 20, 10, 35],
//             pointBorderWidth: 2,
//             pointHoverBackgroundColor: gradientStroke2,
//             backgroundColor: gradientStroke2,
//             borderColor: gradientStroke2,
//             borderWidth: 3
//           }]
//         },
//         options: {
// 			maintainAspectRatio: false,
//             legend: {
// 			  position: 'bottom',
//               display:false
//             },
//             tooltips: {
// 			  displayColors:false,	
//               mode: 'nearest',
//               intersect: false,
//               position: 'nearest',
//               xPadding: 10,
//               yPadding: 10,
//               caretPadding: 10
//             }
//          }
//       });



// // chart 4

	  
//   // chart 5

//     var ctx = document.getElementById("chart5").getContext('2d');
   
//       var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
//       gradientStroke1.addColorStop(0, '#f54ea2');
//       gradientStroke1.addColorStop(1, '#ff7676');

//       var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
//       gradientStroke2.addColorStop(0, '#42e695');
//       gradientStroke2.addColorStop(1, '#3bb2b8');

//       var myChart = new Chart(ctx, {
//         type: 'bar',
//         data: {
//           labels: ['SP Jain','MIT','IIT','CATking','Test'],
//           datasets: [{
//             label: 'upload',
//             data: [40, 30, 60, 35, 60, 25, 50, 40],
//             borderColor: gradientStroke1,
//             backgroundColor: gradientStroke1,
//             hoverBackgroundColor: gradientStroke1,
//             pointRadius: 0,
//             fill: false,
//             borderWidth: 1
//           }, {
//             label: 'review',
//             data: [50, 60, 40, 70, 35, 75, 30, 20],
//             borderColor: gradientStroke2,
//             backgroundColor: gradientStroke2,
//             hoverBackgroundColor: gradientStroke2,
//             pointRadius: 0,
//             fill: false,
//             borderWidth: 1
//           }]
//         },
// 		options:{
// 		  maintainAspectRatio: false,
// 		  legend: {
// 			  position: 'bottom',
//               display: false,
// 			  labels: {
//                 boxWidth:8
//               }
//             },	
// 		  scales: {
// 			  xAxes: [{
// 				barPercentage: .5
// 			  }]
// 		     },
// 			tooltips: {
// 			  displayColors:false,
// 			}
// 		}
//       });

      var ctx = document.getElementById("chart51").getContext('2d');
   
      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#f54ea2');
      gradientStroke1.addColorStop(1, '#ff7676');

      var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#42e695');
      gradientStroke2.addColorStop(1, '#3bb2b8');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['SP Jain','MIT','IIT','CATking','Test'],
          datasets: [{
            label: 'upload',
            data: [40, 30, 60, 35, 60, 25, 50, 40],
            borderColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            hoverBackgroundColor: gradientStroke1,
            pointRadius: 0,
            fill: false,
            borderWidth: 1
          }, {
            label: 'review',
            data: [50, 60, 40, 70, 35, 75, 30, 20],
            borderColor: gradientStroke2,
            backgroundColor: gradientStroke2,
            hoverBackgroundColor: gradientStroke2,
            pointRadius: 0,
            fill: false,
            borderWidth: 1
          }]
        },
		options:{
		  maintainAspectRatio: false,
		  legend: {
			  position: 'bottom',
              display: false,
			  labels: {
                boxWidth:8
              }
            },	
		  scales: {
			  xAxes: [{
				barPercentage: .5
			  }]
		     },
			tooltips: {
			  displayColors:false,
			}
		}
      });


      var ctx = document.getElementById("chart52").getContext('2d');
   
      var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#f54ea2');
      gradientStroke1.addColorStop(1, '#ff7676');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Below 60', '60-70', '70-80', '80-90', '90-100'],
          datasets: [{
            label: 'upload',
            data: [40, 30, 60, 35, 60, 25, 50, 40],
            borderColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            hoverBackgroundColor: gradientStroke1,
            pointRadius: 0,
            fill: false,
            borderWidth: 1
          }]
        },
		options:{
		  maintainAspectRatio: false,
		  legend: {
			  position: 'bottom',
              display: false,
			  labels: {
                boxWidth:8
              }
            },	
		  scales: {
			  xAxes: [{
				barPercentage: .5
			  }]
		     },
			tooltips: {
			  displayColors:false,
			}
		}
      });

      



   });	 
   