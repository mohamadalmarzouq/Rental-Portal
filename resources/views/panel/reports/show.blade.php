@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        @include('auth.includes.flash_mesages')

        <h4 class="tx-24 tx-bold m-0">{{ tn('Filter') }}</h4>
        <div class="row dashboard-top d-flex align-items-lg-end mg-b-30">

            @if (in_array(auth()->user()->role_id,
                auth()->user()->getLandLordRoleIds()))
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
                                placeholder="{{ tn('Start Date') }}">
                        </div>
                    </form>
                </div>
                <div class="col-sm-2 ml-auto">
                    <form id="property-form" class="cusSelectWrp" method="get">
                        <select class="cusSelect custom-select font-weight-500" name="property"
                            onchange="changePropertyForReports(event,$(this).val())">
                            <option value="">{{ t('common.all_properties') }}</option>
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
            @if (count($widgets) > 0)
                @foreach ($widgets as $key => $widget)
                    @if ($key > 0)
                        @switch ($widget->type->slug)
                            @case ('flot_line_chart')
                                @include('panel.widget_types.plot_line_graph', [
                                    'widget' => $widget,
                                    'show_in_dashboard' => 1,
                                ])
                            @break

                            @case ('flot_bar_chart')
                                @include('panel.widget_types.plot_bar_graph', [
                                    'widget' => $widget,
                                    'show_in_dashboard' => 1,
                                ])
                            @break

                            @case ('pie_chart')
                                @include('panel.widget_types.pie_chart', [
                                    'widget' => $widget,
                                    'show_in_dashboard' => 1,
                                ])
                            @break

                            @case ('single_table')
                                @include('panel.widget_types.single_table', [
                                    'widget' => $widget,
                                    'show_in_dashboard' => 1,
                                ])
                            @break

                            @case ('barometer')
                                @include('panel.widget_types.barometer', [
                                    'widget' => $widget,
                                    'show_in_dashboard' => 1,
                                ])
                            @break
                        @endswitch
                    @endif
                @endforeach
            @endif

            {{-- <div class="col-12 mg-b-20">
                 <label class="mr-3" for="">Show in dashboard</label>
                 <input type="checkbox" name="show" id="show" value="1" {{ $show_in_dashboard ? 'checked' : '' }}>
             </div> --}}
            @include('panel.includes.comment_modal')
        </div>
    </div>

@endsection
@push('custom-scripts')
<script type="text/javascript">
    $(function () {
        document.getElementById("start_date_global_search").readOnly = true;

        /* Start Date */
        $('#start_date_global_search').daterangepicker({
            timePicker: false,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
</script>
    <script type="text/javascript">
        $('.custom-control-input').on('change', function() {

            let value = $(this).is(":checked") ? 1 : 0;

            let widget_id = $(this).attr('data-id');

            let requested_url = base_url + '/{{ $module }}-show-in-dashboard';

            $.get(requested_url, {
                'widget_id': widget_id,
                'show': value
            }).done(function(data) {

            }).fail(function(error) {

            });

        });

        function changePropertyForReports(event, val) {
            event.preventDefault();
            if (val) {
                document.getElementById('property-form').submit();
            } else {
                window.location = '{{ route('reports.show') }}'
            }
        }

        // function changeSelectForReport(event, val) {
        //     event.preventDefault();
        //     if (val) {
        //         document.getElementById('filter-form').submit();
        //     } else {
        //         window.location = '{{ route('reports.show') }}'
        //     }
        // }

        // function changeSelectForReport()
        // {
        //     let date = $(this).val().split(' - ');

        //         let start_date = date[0];
        //         let end_date = date[1];

        //         if (start_date == end_date) {
        //             return;
        //         }
        //     document.getElementById('filter-form').submit();
        // }
    </script>
@endpush
