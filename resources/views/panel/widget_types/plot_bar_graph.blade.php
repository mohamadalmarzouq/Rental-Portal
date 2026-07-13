<div class="{{ $widget->class }} d-flex flex-column mg-b-50">
    <div class="d-flex align-items-center justify-content-between mg-b-20">
        <h3 class="tx-24 tx-bold m-0">{{ $widget->title }}</h3>
        @isset($show_in_dashboard)
            <div class="col show_in_dashboard text-right">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="show{{ $widget->id }}"
                           id="show{{ $widget->id }}"
                           data-id="{{ $widget->id }}" {{ showInDashboard($widget->id) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show{{ $widget->id }}">Show in Dashboard</label>
                </div>
            </div>
        @endisset
    </div>
    <div class="card card-body">
        <div class="row align-items-center flex-row-reverse mg-b-20">
            <div class="col-6">
                {{-- <form class="d-flex justify-content-end">
                    <div class="form-group m-0">
                        <input type="text" name="date" id="start_date{{ $widget->id }}" class="form-control"
                               placeholder="Start Date">
                    </div>
                </form> --}}

            </div>
            <div class="col-6">

                @if(isset($widget->graph_data->select_data))
                    <div class="row">
                        <div class="form-group col-md-8 mb-0">
                            {{-- <select id="widget-select-{{ $widget->id }}"
                                    onchange="getGraphData{{ $widget->id }}($(this).val())"
                                    class="form-control card_inner_select">

                                @foreach($widget->graph_data->select_data as $data)
                                    <option value="{{ $data->tab_value }}">
                                        {{ $data->tab_title }}
                                    </option>
                                @endforeach
                            </select> --}}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($widget->graph_data->nav_data))
            <ul class="nav nav-pills mb-3 card_inner_nav" id="pills-tab" role="tablist">
                @foreach($widget->graph_data->nav_data as $key => $data)
                    <li class="nav-item">
                        <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="pills-collected-tab{{ $key }}"
                           data-toggle="pill"
                           href="#pills{{ $key }}" role="tab" aria-controls="pills-collected"
                           aria-selected="true">{{ $data->name }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="pills-tabContent">
                @foreach($widget->graph_data->nav_data as $key => $data)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="pills{{ $key }}" role="tabpanel"
                         aria-labelledby="pills-collected-tab{{ $key }}">
                        <canvas class="mg-t-25" height="230" id="canvas{{ $key }}-{{ $widget->id }}"></canvas>
                    </div>
                @endforeach
            </div>

        @else

            <div class="">
                <canvas class="mg-t-25"
                        height="{{ isset($widget->graph_data->canvas_height) ? $widget->graph_data->canvas_height : '230' }}"
                        id="canvas{{ $widget->id }}"></canvas>
            </div>
        @endif
    </div>
</div>

@push('custom-scripts')
    <script src="{{ asset('assets/js/canvasjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/utils.js') }}"></script>
    <script type="text/javascript">
        // $(function () {
        //     document.getElementById("start_date{{ $widget->id }}").readOnly = true;

        //     /* Start Date */
        //     $('#start_date{{ $widget->id }}').daterangepicker({
        //         timePicker: false,
        //         locale: {
        //             format: 'YYYY-MM-DD'
        //         }
        //     });
        // });
    </script>
    @if(isset($widget->graph_data->nav_data))
        <script type="text/javascript">
            $('#widget-global-select').on('change', function(){
                    let date = $('#start_date_global_search').val().split(' - ');

                    start_date = date[0];
                    end_date = date[1];
                    if (start_date == end_date) {
                        start_date = '';
                        end_date = '';
                    }
                getGraphData1($('#widget-global-select').val(), start_date, end_date)
                getGraphData20_2($('#widget-global-select').val(), start_date, end_date)
            })
            $('#start_date_global_search').on('change', function () {
                let date = $(this).val().split(' - ');

                let start_date = date[0];
                let end_date = date[1];

                if (start_date == end_date) {
                    return;
                }

                getGraphData1($('#widget-global-select').val(), start_date, end_date)
                getGraphData20_2($('#widget-global-select').val(), start_date, end_date)
                getGraphData29_2($('#widget-global-select').val(), start_date, end_date)
            })

            var color = Chart.helpers.color;

            @foreach($widget->graph_data->nav_data as $key => $data)

            window['barChartData_{{ $key }}_{{ $widget->id }}'] = {
                labels: {!! json_encode($data->label) !!},
                datasets: [
                    {
                        label: '{{ $data->x[0] }}',
                        // barThickness: 15,
                        backgroundColor: color({!! $data->colors[0] !!}).rgbString(),
                        data: {!! json_encode($data->dataPoints) !!}
                    },
                        @if(isset($data->x[1]))
                    {
                        label: '{{ $data->x[1] }}',
                        // barThickness: 15,
                        backgroundColor: color({!! $data->colors[1] !!}).rgbString(),
                        data: {!! json_encode($data->dataPoints1) !!}
                    },
                    {
                        label: '{{ $data->x[2] }}',
                        // barThickness: 15,
                        backgroundColor: color({!! $data->colors[2] !!}).rgbString(),
                        data: {!! json_encode($data->dataPoints1) !!}
                    }
                    @endif
                ]
            }
            @endforeach
            $(function () {
                chartData{{ $widget->id }}();
            });

            function chartData{{ $widget->id }}() {

                @foreach($widget->graph_data->nav_data as $key => $data)

                var ctx_{{ $key }}_{{ $widget->id }} = document.getElementById('canvas{{ $key }}-{{ $widget->id }}').getContext('2d');
                window['ctx_{{ $key }}_{{ $widget->id }}'] = new Chart(ctx_{{ $key }}_{{ $widget->id }}, {
                    type: 'bar',
                    data: window['barChartData_{{ $key }}_{{ $widget->id }}'],
                    axisY:{
                        valueFormatString: "#,##0.##",
                    },
                    options: {
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
                                        // autoSkip: false,
                                        fontSize: 12,
                                        fontColor: '#6d75a0',
                                        fontStyle: "bold",
                                        padding: 0,
                                    }
                                }
                            ],
                            yAxes: [
                                {
                                    gridLines: {
                                        drawBorder: false
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
                                    },
                                    valueFormatString: "#,##0.##",
                                }
                            ]
                        },
                        responsive: true,
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
                @endforeach
            }

            function getGraphData1(value, start_date = '', end_date = '') {
                if (!start_date && !end_date) {
                    let date = $('#start_date_global_search').val().split(' - ');

                    start_date = date[0];
                    end_date = date[1];
                    if (start_date == end_date) {
                        start_date = '';
                        end_date = '';
                    }
                }
                let requested_url = base_url + '/{{ $widget->graph_data->route_for_search }}/' + value;
                $.get(requested_url, {
                    'property': '{{ isset($property_id) ? $property_id : '' }}',
                    'start_date': start_date,
                    'end_date': end_date
                }).done(function (data) {
                    data = JSON.parse(data);
                    color = Chart.helpers.color;
                    $.each(data.nav_data, function (index, value) {

                        window['ctx_' + index + '_{{ $widget->id }}'].destroy();

                        let data{{ $widget->id }} = [];

                        switch (value.colors[0]) {
                            case 'window.chartColors.green':
                                value.colors[0] = window.chartColors.green;
                                break;
                            case 'window.chartColors.red':
                                value.colors[0] = window.chartColors.red;
                                break;
                            case 'window.chartColors.grey':
                                value.colors[0] = window.chartColors.grey;
                                break;
                            case 'window.chartColors.warmblue':
                                value.colors[0] = window.chartColors.warmblue;
                                break;
                            case 'window.chartColors.palegrey':
                                value.colors[0] = window.chartColors.palegrey;
                                break;
                        }

                        if (value.x.length > 1) {

                            switch (value.colors[1]) {
                                case 'window.chartColors.green':
                                    value.colors[1] = window.chartColors.green;
                                    break;
                                case 'window.chartColors.red':
                                    value.colors[1] = window.chartColors.red;
                                    break;
                                case 'window.chartColors.grey':
                                    value.colors[1] = window.chartColors.grey;
                                    break;
                                case 'window.chartColors.warmblue':
                                    value.colors[1] = window.chartColors.warmblue;
                                    break;
                                case 'window.chartColors.palegrey':
                                    value.colors[1] = window.chartColors.palegrey;
                                    break;
                            }

                            data{{ $widget->id }}.push(
                                {
                                    label: value.x[0],
                                    // barThickness: 15,
                                    backgroundColor: color(value.colors[0]).rgbString(),
                                    data: value.dataPoints
                                }, {
                                    label: value.x[1],
                                    // barThickness: 15,
                                    backgroundColor: color(value.colors[1]).rgbString(),
                                    data: value.dataPoints1
                                }
                            );

                        } else {
                            data{{ $widget->id }}.push(
                                {
                                    label: value.x[0],
                                    // barThickness: 15,
                                    backgroundColor: color(value.colors[0]).rgbString(),
                                    data: value.dataPoints
                                }
                            );
                        }


                        window['barChartData_' + index + '_{{ $widget->id }}'] = {
                            labels: value.label,
                            datasets: data{{ $widget->id }}
                        }

                    });

                    chartData{{ $widget->id }}();

                }).fail(function (error) {
                    console.log(error);
                });
            }
        </script>

    @else
        <script type="text/javascript">

            $('#start_date_global_search').on('change', function () {
                let date = $(this).val().split(' - ');

                let start_date = date[0];
                let end_date = date[1];

                if (start_date == end_date) {
                    return;
                }

                getGraphData{{$widget->id}}_2($('#widget-global-select').val(), start_date, end_date)
            })

            var color = Chart.helpers.color;

            window['barChartData{{ $widget->id }}'] = {
                labels: {!! json_encode($widget->graph_data->graph_data->label) !!},
                datasets: [
                    {
                        label: '{{ $widget->graph_data->graph_data->x[0] }}',
                        // barThickness: 15,
                        backgroundColor: color({!! $widget->graph_data->graph_data->colors[0] !!}).rgbString(),
                        data: {!! json_encode($widget->graph_data->graph_data->dataPoints) !!}
                    }, {
                        label: '{{ $widget->graph_data->graph_data->x[1] }}',
                        // barThickness: 15,
                        backgroundColor: color({!! $widget->graph_data->graph_data->colors[1] !!}).rgbString(),
                        data: {!! json_encode($widget->graph_data->graph_data->dataPoints1) !!}
                    }
                ]
            }

            $(function () {
                chartData{{ $widget->id }}();
            });

            function chartData{{ $widget->id }}() {

                var ctx{{ $widget->id }} = document.getElementById('canvas{{ $widget->id }}').getContext('2d');
                window['ctx{{ $widget->id }}'] = new Chart(ctx{{ $widget->id }}, {
                    type: 'bar',
                    data: window['barChartData{{ $widget->id }}'],
                    options: {
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
                                        padding: 0,
                                    }
                                }
                            ],
                            yAxes: [
                                {
                                    gridLines: {
                                        drawBorder: false
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
                        responsive: true,
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

            function getGraphData{{$widget->id}}_2(value, start_date, end_date) {
                if (!start_date && !end_date) {
                    let date = $('#start_date_global_search').val().split(' - ');

                    start_date = date[0];
                    end_date = date[1];
                    if (start_date == end_date) {
                        start_date = '';
                        end_date = '';
                    }
                }
                let requested_url = base_url + '/{{ $widget->graph_data->route_for_search }}/' + value;

                if (!value) {
                    requested_url = base_url + '/{{ $widget->graph_data->route_for_search }}';

                }

                $.get(requested_url, {
                    'property': '{{ isset($property_id) ? $property_id : '' }}',
                    'start_date': start_date,
                    'end_date': end_date
                }).done(function (data) {
                    data = JSON.parse(data);

                    window['ctx{{ $widget->id }}'].destroy();

                    for (let i in data.graph_data.colors) {

                        switch (data.graph_data.colors[i]) {
                            case 'window.chartColors.dodgerblue':
                                data.graph_data.colors[i] = window.chartColors.dodgerblue;
                                break;
                            case 'window.chartColors.lipstick':
                                data.graph_data.colors[i] = window.chartColors.lipstick;
                                break;
                            case 'window.chartColors.greenblue':
                                data.graph_data.colors[i] = window.chartColors.greenblue;
                                break;

                        }
                    }


                    window['barChartData{{ $widget->id }}'] = {
                        labels: data.graph_data.label,
                        datasets: [
                            {
                                label: data.graph_data.x[0],
                                // barThickness: 15,
                                backgroundColor: color(data.graph_data.colors[0]).rgbString(),
                                data: data.graph_data.dataPoints
                            }, {
                                label: data.graph_data.x[1],
                                // barThickness: 15,
                                backgroundColor: color(data.graph_data.colors[1]).rgbString(),
                                data: data.graph_data.dataPoints1
                            }
                        ]
                    }

                    chartData{{ $widget->id }}();

                }).fail(function (error) {
                    console.log(error);
                });
            }
        </script>
    @endif
@endpush
