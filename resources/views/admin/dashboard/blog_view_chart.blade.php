<div class="col-xl-6">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title">Line Chart</h4>
            <p class="text-muted m-b-30 font-14 d-inline-block text-truncate w-100"></p>
            <canvas id="lineChart" height="300" style="width: 507px; height: 300px;"></canvas>
        </div>
    </div>
</div> 

@push('page_scripts')
<script src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
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
                    labels:['dcd','cds'],
                    datasets: [{
                            label: "Blog Views",
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
                            data: [10,20],
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
