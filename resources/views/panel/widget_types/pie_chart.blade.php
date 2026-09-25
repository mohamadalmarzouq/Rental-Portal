@push('custom-head')
    <link rel="stylesheet" href="{{ asset('assets/css/Chart.css') }}" type="text/css" />
@endpush

<div class="col-xl-4 col-lg-6 d-flex flex-column mg-b-50">
    <div class="d-flex align-items-center justify-content-between mg-b-20">
        <h3 class="tx-24 tx-bold m-0">{{ t('page.vacancy_rate') }}</h3>
        @isset($show_in_dashboard)
            <div class="col show_in_dashboard text-right">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="show{{ $widget->id }}"
                        id="show{{ $widget->id }}" data-id="{{ $widget->id }}"
                        {{ showInDashboard($widget->id) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show{{ $widget->id }}">{{ tn('Show in Dashboard') }}</label>
                </div>
            </div>
        @endisset
    </div>
    <div class="card card-body">
        {{-- <form class="d-flex justify-content-end">
            <span style="background:none;outline:none;border:none;width:40px;margin-top:10px;margin-right:-10px" id="refreshForm2"><i
                    class="fa fa-sync" style="cursor: pointer"></i></span>
            <div class="form-group m-0">
                <input type="text" name="date" id="start_date{{ $widget->id }}" class="form-control"
                    placeholder="Start Date">
            </div>
        </form> --}}

        <div class="row">
            <div class="col-12">
                <div class="chart-thirteen">
                    <canvas id="chartDonut"></canvas>
                    <div class="total_units_center">
                        <h6 id="main_heading" class="tx-color-navy mb-0 tx-30 font-weight-bold  tx-roboto">
                            {{ $widget->graph_data->total_units->data }}</h6>
                        <p class="tx-color-navy tx-12 mb-0">Total Units</p>
                    </div>
                </div>
            </div>
            <div class="col-12 tx-12 mg-t-30">
                {{-- <div class="d-flex align-items-center">
                    <div class="wd-10 ht-10 vr-bg-color-1 rounded-circle pos-relative t--1"></div>
                    <span class="tx-medium mg-l-10">Total Units</span>
                    <span class="tx-rubik mg-l-auto"
                        id="total_units">{{ $widget->graph_data->total_units->data }}</span>
                </div> --}}
                <div class="d-flex align-items-center mg-t-10">
                    <div class="wd-10 ht-10 vr-bg-color-1 rounded-circle pos-relative t--1"></div>
                    <span class="tx-medium mg-l-10">Vacant Units</span>
                    <span class="tx-rubik mg-l-auto"
                        id="vacant_units">{{ $widget->graph_data->vacant_units->data }}</span>
                </div>
                <div class="d-flex align-items-center mg-t-10">
                    <div class="wd-10 ht-10 vr-bg-color-3 rounded-circle pos-relative t--1"></div>
                    <span class="tx-medium mg-l-10">Occupied Units</span>
                    <span class="tx-rubik mg-l-auto"
                        id="occupied_units">{{ $widget->graph_data->occupied_units->data }}</span>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card card-body justify-content-center">
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
        <div class="text-center">
            <div class="media-body pd-l-10">
                <h6 class="tx-color-navy mg-b-6 tx-36 font-weight-bold  tx-roboto">{{ $widget->graph_data->total_properties->data }}</h6>
                <p class="tx-color-navy tx-18 mg-b-34">Total properties</p>
            </div>
        </div>
        <div id="vmap" class="ht-200"
             style="position: relative; overflow: hidden; background-color: rgb(255, 255, 255);">

            <canvas id="myChart-{{ $widget->id }}" width="200" height="200"></canvas>

        </div>
    </div> --}}
</div>

{{-- <div class="{{ isset($class) ? $class : 'col-md-4' }}">
    <div class="card set-min-height">
        <div class="card-header">
            <h6 class="mg-b-0">{{ $widget->title }}</h6>
        </div><!-- card-header -->
        <div class="card-body pd-lg-25">
            <div id="vmap" class="ht-200"
                 style="position: relative; overflow: hidden; background-color: rgb(255, 255, 255);">

                    <canvas id="myChart-{{ $widget->id }}" width="200" height="200"></canvas>

            </div>
            <div class="card-footer mt-4 pd-0 border-0">
                <div class="row pl-2 pr-2 mb-3">
                    <div class="media align-items-center">
                        <div class="wd-45 ht-45 bg-gray-900 set_icon_color rounded d-flex align-items-center justify-content-center">
                            --}}{{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" --}}{{--
                                 --}}{{-- fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" --}}{{--
                                 --}}{{-- stroke-linejoin="round" class="feather feather-github tx-white-7 wd-20 ht-20"> --}}{{--
                                --}}{{-- <path --}}{{--
                                    --}}{{-- d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path> --}}{{--
                            --}}{{-- </svg> --}}{{--
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="media-body pd-l-10">
                            <h6 class="tx-color-01 mg-b-3 tx-20">{{ $widget->graph_data->total_properties->data }}</h6>
                            <p class="tx-12 mg-b-0">TOTAL PROPERTIES</p>
                        </div>
                    </div>
                </div><!-- row -->
                <div class="row pr-2 pl-2 justify-content-between">
                    <div>
                        <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5 mt-0 tx-20"> {{ $widget->graph_data->total_units->data }} </h3>
                        <h6 class="tx-uppercase tx-12 tx-color-02 tx-semibold mg-b-10"> TOTAL UNITS </h6>
                    </div>
                    <div>
                        <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5 mt-0 tx-20"> {{ $widget->graph_data->vacant_units->data }} </h3>
                        <h6 class="tx-uppercase tx-12 tx-color-02 tx-semibold mg-b-10"> TOTAL VACANT
                            UNITS </h6>
                    </div>
                    <div>
                        <h3 class="tx-normal tx-rubik tx-spacing--2 mg-b-5 mt-0 tx-20"> {{ $widget->graph_data->occupied_units->data }} </h3>
                        <h6 class="tx-uppercase tx-12 tx-color-02 tx-semibold mg-b-10"> TOTAL OCCUPIED
                            UNITS </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@push('custom-scripts')
    <script src="{{ asset('assets/js/Chart.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/Chart.bundle.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            // document.getElementById("start_date{{ $widget->id }}").readOnly = true;

            // $('#start_date{{ $widget->id }}').daterangepicker({
            //     timePicker: false,
            //     locale: {
            //         format: 'YYYY-MM-DD'
            //     }
            // });

            var item = [];
            var y = [];

            // item.push('{{ $widget->graph_data->total_units->data }}');
            // y.push('{{ $widget->graph_data->total_units->title }}');
            // '#ededfa',

            item.push('{{ $widget->graph_data->vacant_units->data }}');
            y.push('{{ $widget->graph_data->vacant_units->title }}');

            item.push('{{ $widget->graph_data->occupied_units->data }}');
            y.push('{{ $widget->graph_data->occupied_units->title }}');

            var datapie = {
                labels: y,
                datasets: [{
                    backgroundColor: ['#6d75a0', '#514be0'],
                    data: item,
                }]
            };

            var optionpie = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };
            var ctx2 = document.getElementById('chartDonut');
            var myDonutChart = new Chart(ctx2, {
                type: 'doughnut',
                data: datapie,
                options: optionpie
            });
            $('#refreshForm2').on('click', function(){
                myDonutChart.data = datapie;
                myDonutChart.update();
                $('#main_heading').html({{ $widget->graph_data->total_units->data}});
                // $('#total_units').html({{$widget->graph_data->total_units->data}});
                $('#vacant_units').html({{$widget->graph_data->vacant_units->data}});
                $('#occupied_units').html({{$widget->graph_data->occupied_units->data}});
            });
            $('#start_date_global_search').on('change', function() {
                let date = $(this).val().split(' - ');
                let start_date = date[0];
                let end_date = date[1];

                if (start_date == end_date) {
                    return;
                }
                let request_uri = base_url + '/{{ 'properties-getUnitForDateRange' }}';
                $.get(request_uri, {
                    'start_date': start_date,
                    'end_date': end_date
                }).done(function(data) {
                    let y = [];
                    let item = [];

                    // item.push(data.total_units.data);
                    // y.push(data.total_units.title);
                    item.push(data.vacant_units.data);
                    y.push(data.vacant_units.title);
                    item.push(data.occupied_units.data);
                    y.push(data.occupied_units.title);

                    var datapie2 = {
                        labels: y,
                        datasets: [{
                            backgroundColor: ['#6d75a0', '#514be0'],
                            data: item,
                        }]
                    };
                    myDonutChart.data = datapie2;
                    myDonutChart.update();
                    $('#main_heading').html(data.total_units.data);
                    // $('#total_units').html(data.total_units.data);
                    $('#vacant_units').html(data.vacant_units.data);
                    $('#occupied_units').html(data.occupied_units.data);
                }).fail(function(error) {
                    console.log(error);
                });
            })
        });
        // For a pie chart
    </script>
@endpush
