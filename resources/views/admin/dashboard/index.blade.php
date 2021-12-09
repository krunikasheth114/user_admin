@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading my-2">Chart Demo</div>
                  <div class="col-lg-8">
                <canvas id="userChart" class="rounded shadow"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets\plugins\chart.js\chart.min.js') }}"></script>
@push('script')
<script>
    ChartJs.prototype.init = function() {
            //creating lineChart
            var lineChart = {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September",
                    "October"
                ],
                datasets: [{
                        label: "Sales Analytics",
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: "rgba(80, 138, 235, 0.2)",
                        borderColor: "#508aeb",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#508aeb",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#508aeb",
                        pointHoverBorderColor: "#508aeb",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [65, 59, 80, 81, 56, 55, 40, 55, 30, 80]
                    },
                   
                ]
            };
            var lineOpts = {
                scales: {
                    yAxes: [{
                        ticks: {
                            max: 100,
                            min: 20,
                            stepSize: 10
                        }
                    }]
                }
            };
            this.respChart($("#lineChart"), 'Line', lineChart, lineOpts);
        }(window.jQuery),
        //initializing
        function($) {
            "use strict";
            $.ChartJs.init()
        }(window.jQuery);
</script>
@endpush

@endsection
