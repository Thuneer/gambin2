import Chart from 'chart.js';
import $ from 'jquery';

var ctx = $("#myChart1");
var ctx1 = $("#myChart2");

if (ctx.length) {

    var myChart1 = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", 'Sunday'],
            datasets: [{
                label: 'Articles',
                data: [12, 19, 3, 5, 2, 3, 9],
                backgroundColor: [
                    'rgba(9, 78, 191, 0.5)'
                ],
                borderColor: [
                    'rgba(9, 78, 191, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    var myPieChart = new Chart(ctx1,{
        type: 'doughnut',
        data: {
            labels: ["Users", "Articles", "Pages"],
            datasets: [{
                label: 'Articles',
                data: [12, 19, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {

        }
    });

}