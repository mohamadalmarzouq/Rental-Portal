<div class="{{ $widget->class }} d-flex flex-column mg-b-50">
    <div class="d-flex align-items-center justify-content-between mg-b-20">
        <h3 class="tx-24 tx-bold m-0">{{ tn($widget->title) }}</h3>
        @isset($show_in_dashboard)
            <div class="col show_in_dashboard text-right">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="show{{ $widget->id }}"
                           id="show{{ $widget->id }}"
                           data-id="{{ $widget->id }}" {{ showInDashboard($widget->id) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show{{ $widget->id }}">{{ tn('Show in Dashboard') }}</label>
                </div>
            </div>
        @endisset
    </div>
    <div class="card card-body">

        <div class="">
            <canvas height="150" id="lineChart{{ $widget->id }}"></canvas>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script>
        window['barChartData{{ $widget->id }}'] = {
            labels: {!! json_encode($widget->graph_data->graph_data->label) !!},
            datasets: [
                {
                    label: '{{ $widget->graph_data->graph_data->x }}',
                    backgroundColor: color({!! $widget->graph_data->graph_data->colors[0] !!}).rgbString(),
                    fill: false,
                    pointBackgroundColor: color({!! $widget->graph_data->graph_data->colors[1] !!}).rgbString(),
                    pointHoverRadius: 6,
                    pointHoverBorderWidth: 4,
                    pointRadius: 6,
                    pointHoverBackgroundColor: color({!! $widget->graph_data->graph_data->colors[2] !!}).rgbString(),
                    borderWidth: 6,
                    pointBorderWidth: 4,
                    borderColor: color({!! $widget->graph_data->graph_data->colors[3] !!}).rgbString(), // Add custom color border (Line)
                    data: {!! json_encode($widget->graph_data->graph_data->dataPoints) !!}
                }]

        };

        $(function () {

            chartData{{ $widget->id }}();

        });

        $('#start_date_global_search').on('change', function () {
            let date = $(this).val().split(' - ');

            let start_date = date[0];
            let end_date = date[1];

            if (start_date == end_date) {
                return;
            }

            getGraphData{{ $widget->id }}(start_date, end_date)
        })

        function chartData{{ $widget->id }}() {

            var ctx{{ $widget->id }} = document.getElementById("lineChart{{ $widget->id }}").getContext('2d');
            window['ctx{{ $widget->id }}'] = new Chart(ctx{{ $widget->id }}, {
                type: 'line',
                data: window['barChartData{{ $widget->id }}'],
                options: {
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    scaleBeginAtZero: false,
                    scales: {
                        xAxes: [
                            {
                                barPercentage: 0.8,
                                categoryPercentage: 0.6,
                                gridLines: {
                                    display: false
                                },
                                ticks: {
                                    fontSize: 12,
                                    fontColor: '#6d75a0',
                                    fontStyle: "bold",
                                    padding: 0
                                }
                            }
                        ],
                        yAxes: [
                            {
                                gridLines: {
                                    drawBorder: false,
                                    color: "#eef1f8",
                                },
                                ticks: {
                                    beginAtZero: true,
                                    callback: function (value) {
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        return value;
                                    },
                                    fontSize: 14,
                                    fontColor: '#6d75a0',
                                    fontStyle: "bold",
                                    padding: 15
                                }
                            }
                        ]
                    },
                    responsive: true, // Instruct chart js to respond nicely.
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            fontColor: '#001737',
                            fontSize: 14,
                            fontStyle: "normal",
                            boxWidth: 12,
                            boxHeight: 2

                        },
                        position: 'bottom'
                    }
                }
            });
        }

        function getGraphData{{ $widget->id }}(start_date, end_date) {

            if (!start_date && !end_date) {
                let date = $('#start_date_global_search').val().split(' - ');

                start_date = date[0];
                end_date = date[1];
                if (start_date == end_date) {
                    start_date = '';
                    end_date = '';
                }
            }

            let requested_url = base_url + '/{{ $widget->graph_data->route_for_search }}';


            $.get(requested_url, {
                'property': '{{ isset($property_id) ? $property_id : '' }}',
                'start_date': start_date,
                'end_date': end_date
            }).done(function (data) {

                data = JSON.parse(data);

                window['ctx{{ $widget->id }}'].destroy();

                for (let i in data.graph_data.colors) {

                    switch (data.graph_data.colors[i]) {
                        case 'window.chartColors.palegrey':
                            data.graph_data.colors[i] = window.chartColors.palegrey;
                            break;
                        case 'window.chartColors.white':
                            data.graph_data.colors[i] = window.chartColors.white;
                            break;
                        case 'window.chartColors.lipstick':
                            data.graph_data.colors[i] = window.chartColors.lipstick;
                            break;

                    }
                }

                window['barChartData{{ $widget->id }}'] = {
                    labels: data.graph_data.label,
                    datasets: [
                        {
                            label: data.graph_data.x,
                            backgroundColor: color(data.graph_data.colors[0]).rgbString(),
                            fill: false,
                            pointBackgroundColor: color(data.graph_data.colors[1]).rgbString(),
                            pointHoverRadius: 6,
                            pointHoverBorderWidth: 4,
                            pointRadius: 6,
                            pointHoverBackgroundColor: color(data.graph_data.colors[2]).rgbString(),
                            borderWidth: 6,
                            pointBorderWidth: 4,
                            borderColor: color(data.graph_data.colors[3]).rgbString(), // Add custom color border (Line)
                            data: data.graph_data.dataPoints
                        }]
                }

                chartData{{ $widget->id }}();

            }).fail(function (error) {
                console.log(error);
            });
        }

        // $(function () {

        //     document.getElementById("start_date_global_search").readOnly = true;

        //     /* Start Date */
        //     $('#start_date{{ $widget->id }}').daterangepicker({
        //         timePicker: false,
        //         locale: {
        //             format: 'YYYY-MM-DD'
        //         }
        //     });
        // });

    </script>
@endpush
