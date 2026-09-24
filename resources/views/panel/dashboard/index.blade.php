@extends('panel.master')

@section('main')

    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row dashboard-top d-flex align-items-lg-end mg-b-30">
            <div class="col-sm-6">
                <form class="form-inline" id="filter-form" method="get">
                    {{-- <div class="form-group mb-2">
                        <select name="selection" id="widget-global-select" class="form-control card_inner_select">
                            <option value="unit_week">Weekly
                            </option>
                            <option value="unit_months">
                                Monthly
                            </option>
                            <option value="unit_quarterly">
                                Quarterly
                            </option>
                            <option value="unit_semi_annually">
                                Semi Annually
                            </option>
                            <option value="unit_years">
                                Annually
                            </option>
                        </select>
                    </div> --}}
                    <div class="form-group mb-2 ml-2">
                        <input type="text" name="date" id="start_date_global_search" class="form-control"
                            placeholder="Start Date">
                    </div>
                </form>
            </div>
        </div>
        <div class="row dashboard-top d-flex align-items-lg-end mg-b-30">
            <div class="col-sm-4">
                <div class="total_collection">
                    <span
                        class="total_collection_title mg-b-10 d-block">{{ isset($widgets[3]->title) ? $widgets[3]->title : '' }}</span>
                    <h2 class="m-0 tx-roboto dashboard-card-value" id="netAmount" data-widget-id="{{ isset($widgets[3]->id) ? $widgets[3]->id : '' }}"><span class="kwd">KWD</span>
                        {{ isset($widgets[3]->query[0]->value) ? $widgets[3]->query[0]->value : 0 }}
                    </h2>
                </div>
            </div>
            @if (in_array(auth()->user()->role_id, auth()->user()->getLandLordRoleIds()))
                <div class="col-sm-2 ml-auto">
                    <form id="property-form" class="cusSelectWrp" method="get">
                        <select class="cusSelect custom-select font-weight-500" name="property"
                            onchange="changePropertyForReports(event,$(this).val())">
                            <option value="">All Properties</option>
                            @foreach ($properties as $property)
                                <option {{ $property_id == $property->id ? 'selected' : '' }} value="{{ $property->id }}">
                                    {{ $property->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @endif
        </div>

        <div class="row">
            @php
                $widgets = collect($widgets)->values();
                if (isset($widgets[0], $widgets[2])) {
                    $temp = $widgets[0];
                    $widgets[0] = $widgets[2];
                    $widgets[2] = $temp;
                }
            @endphp
            @if (count($widgets) > 0)
                @foreach ($widgets as $key => $widget)
                    @if ($key != 3)
                        @switch ($widget->type->slug)
                            @case ('counter')
                                @include('panel.widget_types.counter')
                            @break

                            @case ('flot_line_chart')
                                @include('panel.widget_types.plot_line_graph', ['widget' => $widget])
                            @break

                            @case ('flot_bar_chart')
                                @include('panel.widget_types.plot_bar_graph', ['widget' => $widget])
                            @break

                            @case ('pie_chart')
                                @include('panel.widget_types.pie_chart', ['widget' => $widget])
                            @break

                            @case ('single_table')
                                @include('panel.widget_types.single_table', ['widget' => $widget])
                            @break

                            @case ('barometer')
                                @include('panel.widget_types.barometer', ['widget' => $widget])
                            @break
                        @endswitch
                    @endif
                @endforeach
            @endif
        </div>
        @include('panel.includes.comment_modal')
    </div>

@endsection
@push('custom-scripts')
    <script type="text/javascript">
        $(function() {
            document.getElementById("start_date_global_search").readOnly = true;

            /* Start Date */
            $('#start_date_global_search').daterangepicker({
                timePicker: false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        });

        function changePropertyForReports(event, val) {
            event.preventDefault();
            if (val) {
                document.getElementById('property-form').submit();
            } else {
                window.location = '{{ route('home') }}'
            }
        }
    </script>
    <script type="text/javascript">
        $("#start_date_global_search").on('apply.daterangepicker', function() {
            let date = $(this).val().split(' - ');

            let start_date = date[0];
            let end_date = date[1];
            let requested_url = base_url + '/date-filter';
            $.get(requested_url, {
                'start_date': start_date,
                'end_date': end_date
            }).done(function(data) {
                data.forEach(function(element) {
                    var value = (element.query && element.query[0] && element.query[0].value)
                        ? element.query[0].value
                        : 0;
                    $('.dashboard-card-value[data-widget-id="' + element.id + '"]').html(
                        '<span class="kwd">KWD</span> ' + value
                    );
                });
            }).fail(function(error) {

            })
        })
    </script>
@endpush
