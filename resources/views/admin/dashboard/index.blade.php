@extends('layouts.master')
@section('content')
    <br>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat m-b-30">
                <div class="p-3 bg-primary text-white">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-right mb-0"></i>
                    </div>
                    <h6 class="text-uppercase mb-0"> {{__('messages.users')}}</h6>
                </div>
                <div class="card-body">
                    <div class="border-bottom pb-4">
                        <span class="badge badge-success"></span> <span class="ml-2 text-muted"> {{__('messages.total_users')}}</span>
                    </div>
                    <div class="mt-4 text-muted">
                        <div class="float-right">
                            <p class="m-0"> </p>
                        </div>
                        <h5 class="m-0">{{ $users }}<i class="mdi mdi-arrow-up text-success ml-2"></i>
                        </h5>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat m-b-30">
                <div class="p-3 bg-primary text-white">
                    <div class="mini-stat-icon">
                        <i class="mdi mdi-cube-outline float-right mb-0"></i>
                    </div>
                    <h6 class="text-uppercase mb-0"> {{__('messages.blogs')}}</h6>
                </div>
                <div class="card-body">
                    <div class="border-bottom pb-4">
                        <span class="badge badge-success"></span> <span class="ml-2 text-muted">{{__('messages.total_blogs')}}</span>
                    </div>
                    <div class="mt-4 text-muted">
                        <div class="float-right">
                            <p class="m-0"> </p>
                        </div>
                        <h5 class="m-0">{{ $total_blog }}<i class="mdi mdi-arrow-up text-success ml-2"></i>
                        </h5>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">{{__('messages.line_chart')}}</h4>
                    <p class="text-muted m-b-30 font-14 d-inline-block text-truncate w-100"></p>
                    <canvas id="lineChart" height="300" style="width: 507px; height: 300px;"></canvas>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    @push('page_scripts')
        <script>
            ! function($) {
                "use strict";
                var ChartJs = function() {};
                ChartJs.prototype.respChart = function(selector, type, data, options) {
                        var ctx = selector.get(0).getContext("2d");
                        var container = $(selector).parent();
                        $(window).resize(generateChart);

                        function generateChart() {
                            var ww = selector.attr('width', $(container).width());
                            switch (type) {
                                case 'Line':
                                    new Chart(ctx, {
                                        type: 'line',
                                        data: data,
                                        options: options
                                    });
                                    break;
                            }
                        };
                        generateChart();
                    },
                    ChartJs.prototype.init = function() {
                        var lineChart = {
                            labels: <?php echo json_encode($blogs); ?>,
                            datasets: [{
                                    label: "{{__('messages.blog_like')}}",
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
                                    data: <?php echo json_encode($likes); ?>,
                                },

                            ]
                        };
                        var lineOpts = {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        max: 50,
                                        min: 5,
                                        stepSize: 5
                                    }
                                }]
                            }
                        };
                        this.respChart($("#lineChart"), 'Line', lineChart, lineOpts);
                    },
                    $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs
            }(window.jQuery),
            function($) {
                "use strict";
                $.ChartJs.init()
            }(window.jQuery);
        </script>
    @endpush

@endsection
