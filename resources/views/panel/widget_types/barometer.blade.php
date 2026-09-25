@push('custom-head')
    <link rel="stylesheet" href="{{ asset('assets/css/barometer.css') }}">
@endpush
<div class="col-md-6 d-flex flex-column mg-b-50">
    <h3 class="mg-b-20  tx-24 tx-bold">{{ tn($widget->title) }}</h3>
    <div class="card card-body">

        @isset($show_in_dashboard)
            <div class="mg-b-20 show_in_dashboard text-right mb-4">

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="show{{ $widget->id }}"
                        id="show{{ $widget->id }}" data-id="{{ $widget->id }}"
                        {{ showInDashboard($widget->id) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show{{ $widget->id }}">{{ tn('Show in Dashboard') }}</label>
                </div>
            </div>
        @endisset
        <div id="barometer{{ $widget->id }}"></div>
    </div>
</div>


@push('custom-scripts')
    <script type="text/javascript">
        @if ($widget->method == 'getDataForVacancyBarometer')
        // $(function() {
        //     document.getElementById("start_date{{ $widget->id }}").readOnly = true;
        //     $('#start_date{{ $widget->id }}').daterangepicker({
        //         timePicker: false,
        //         locale: {
        //             format: 'YYYY-MM-DD'
        //         }
        //     });
        // });
        // $('#refreshForm').on('click', function(){
        //     findPercentageForVacancy()
        // });
        $('#start_date_global_search').on('change', function() {
            let date = $(this).val().split(' - ');

            let start_date = date[0];
            let end_date = date[1];

            if (start_date == end_date) {
                return;
            }
                let requested_url = base_url + '/{{ 'properties-vacancy-data' }}/';
                $.get(requested_url, {
                    'start_date': start_date,
                    'end_date': end_date
                }).done(function(data) {
                    let data2 = JSON.parse(data);
                    let percentage{{ $widget->id }} = parseInt(data2.value) ? ((
                        parseInt(data2.value1) / parseInt(
                            data2.value)) * 100).toFixed(2) : 0;

                    let degs{{ $widget->id }} = 0;

                    if (percentage{{ $widget->id }} <= 9) {
                        degs{{ $widget->id }} = 160
                    } else if (percentage{{ $widget->id }} > 9 && percentage{{ $widget->id }} <=
                        11.25) {
                        degs{{ $widget->id }} = 90
                    } else {
                        degs{{ $widget->id }} = 25;
                    }

                    const $arrow{{ $widget->id }} = baro{{ $widget->id }}.$element.find('.arrow');
                    // For webkit browsers: e.g. Chrome
                    $arrow{{ $widget->id }}.css({
                        WebkitTransform: 'translate(-53%, 0%)' + 'rotate(' +
                            degs{{ $widget->id }} + 'deg)'
                    });
                    // For Mozilla browser: e.g. Firefox
                    $arrow{{ $widget->id }}.css({
                        '-moz-transform': 'translate(-53%, 0%)' + 'rotate(' +
                            degs{{ $widget->id }} + 'deg)'
                    });

                    $('#vacancy-percentage').text(percentage{{ $widget->id }} + '%')
                    $('#vacancy-value').text(data2.value1)

                }).fail(function(error) {
                    console.log(error);
                });
            });
            @endif
    </script>
    <script>
        @if ($widget->method == 'getDataForVacancyBarometer')
            function getHtmlForVacancy(options) {
                return $(
                    "<div class='d-flex align-items-center mt-3'><div class='d-flex'><div class='mr-3'><label>{{ tn('Percentage') }}</label><p class='font-weight-bold pt-1 m-0' id='vacancy-percentage'>-</p></div><div><label>{{ tn('Value') }}</label><p class='font-weight-bold pt-1 m-0' id='vacancy-value'>-</p></div></div></div>"
                    );
            }
        @else
            function getHtmlForPerformance(options) {

                return $(
                    "<div class='d-flex align-items-center mt-3 flex-wrap'><div class='mr-3 mb-2'><label>{{ tn('Percentage') }}</label><input class='form-control' oninput='percentageBarometer($(this).val())' placeholder='{{ tn('Enter Percentage') }}' type=\"number\" min=\"0\" max=\"100\" step=\"" +
                    options +
                    "\"/></div><div class='mr-3 mb-2'><label>{{ tn('Property Value') }}</label><input class='form-control' oninput='propertyValueBarometer($(this).val())' placeholder='{{ tn('Property Value') }}' type=\"number\" min=\"0\"/></div><div class='mr-3 mb-2'><label>{{ tn('This Month') }}</label><p class='font-weight-bold pt-1 m-0' id='monthlyIncomeBarometer'>{{ isset($widget->graph_data->monthly_income) ? number_format((float) $widget->graph_data->monthly_income, 2, '.', '') : '0.00' }}</p></div><div class='mr-3 mb-2'><label>{{ tn('Monthly Target') }}</label><p class='font-weight-bold pt-1 m-0' id='monthlyTargetBarometer'>-</p></div><div class='mb-2'><label>{{ tn('Yearly Target') }}</label><p class='font-weight-bold pt-1 m-0' id='yearlyTargetBarometer'>-</p></div></div>"
                    );
            }
        @endif
    </script>
    <script>
        (function($) {
            var Barometer{{ $widget->id }} = function(element, options) {
                this.$element = $(element);
                //this.modal = this.$element.find('.modal');
                this.init{{ $widget->id }}(options);
                this.$element.data('barometer', this);
                this.curretValue = null;
                return this;
            };

            Barometer{{ $widget->id }}.prototype = {
                    defaultOptions: {
                        startvalue: 0,
                        placeholder: "Insert rotation degrees",
                        steps: 5
                    },

                    constructor{{ $widget->id }}: Barometer{{ $widget->id }},
                    init{{ $widget->id }}: function(options) {
                        const self = this;
                        self.options = $.extend({}, this.defaultOptions, options);
                        self.createBarometer{{ $widget->id }}();
                        self.createInputContainer{{ $widget->id }}();
                        self.bindInput{{ $widget->id }}();
                    },

                    createBarometer{{ $widget->id }}: function() {
                        const self = this;
                        const preview = $("<div class=\"container\">" +
                            "<div class=\"first_ring\"><div class=\"second_ring\"><div class=\"third_ring\"></div></div></div>" +
                            "<div class=\"pie\"><div class=\"pie_segment red\"></div><div class=\"pie_segment orange\"></div><div class=\"pie_segment green\"></div><div class=\"pie_segment white\"></div></div>" +
                            "<div class=\"second_layer\"></div><div class=\"third_layer\"></div>" +
                            "<div class=\"arrow\"><div class=\"arrowtop\"></div><div class=\"arrowbottom\"></div></div>" +
                            "<div class=\"middle_point\"></div></div>");
                        self.$element.append(preview);
                    },

                    createInputContainer{{ $widget->id }}: function() {
                        const self = this;
                        // console.log('hey  ', '{{ $widget->method }}');
                        const input = '{{ $widget->method }}' == 'getDataForVacancyBarometer' ? getHtmlForVacancy(
                            this.options.steps) : getHtmlForPerformance(this.options.steps);
                        self.$element.append(input);
                    },

                    rotate{{ $widget->id }}: function(degs) {
                        // console.log(degs,'degree');
                        degs = '{{ $widget->method }}' != 'getDataForVacancyBarometer' ?
                            findPercentageForPerformance(degs) : 0;
                        // console.log(degs,'degree');
                        const self = this;
                        const $arrow = this.$element.find('.arrow');
                        // For webkit browsers: e.g. Chrome
                        $arrow.css({
                            WebkitTransform: 'translate(-53%, 0%)' + 'rotate(' + degs + 'deg)'
                        });
                        // For Mozilla browser: e.g. Firefox
                        $arrow.css({
                            '-moz-transform': 'translate(-53%, 0%)' + 'rotate(' + degs + 'deg)'
                        });
                    },

                    bindInput{{ $widget->id }}: function() {
                        const self = this;
                        /*self.$element.find('input').on('keyup', '', self, function (e) {
                            self.rotate{{ $widget->id }}($(e.target).val());
                        });*/
                    },

                },

                $.fn.barometer{{ $widget->id }} = function(options, arg) {
                    return new Barometer{{ $widget->id }}(this, options);
                };

            $.fn.barometer{{ $widget->id }}.Constructor{{ $widget->id }} = Barometer{{ $widget->id }};


        }(jQuery));
    </script>
    <script type="text/javascript">
        var baro{{ $widget->id }} = ''
        var propertyValue{{ $widget->id }} = 0;
        var propertyValuePercentage{{ $widget->id }} = 0;

        $(function() {

            baro{{ $widget->id }} = $('#barometer{{ $widget->id }}').barometer{{ $widget->id }}({
                startvalue: "-25"
            });

            @if ($widget->method == 'getDataForVacancyBarometer')
                findPercentageForVacancy()
            @endif
        });

        @if ($widget->method == 'getDataForVacancyBarometer')

            function findPercentageForVacancy() {

                let percentage{{ $widget->id }} = parseInt('{{ $widget->graph_data->value }}') ? ((parseInt(
                        {{ $widget->graph_data->value1 }}) / parseInt({{ $widget->graph_data->value }})) * 100).toFixed(
                    2) : 0;

                let degs{{ $widget->id }} = 0;

                if (percentage{{ $widget->id }} <= 9) {
                    degs{{ $widget->id }} = 160
                } else if (percentage{{ $widget->id }} > 9 && percentage{{ $widget->id }} <= 11.25) {
                    degs{{ $widget->id }} = 90
                } else {
                    degs{{ $widget->id }} = 25;
                }

                const $arrow{{ $widget->id }} = baro{{ $widget->id }}.$element.find('.arrow');
                // For webkit browsers: e.g. Chrome
                $arrow{{ $widget->id }}.css({
                    WebkitTransform: 'translate(-53%, 0%)' + 'rotate(' + degs{{ $widget->id }} + 'deg)'
                });
                // For Mozilla browser: e.g. Firefox
                $arrow{{ $widget->id }}.css({
                    '-moz-transform': 'translate(-53%, 0%)' + 'rotate(' + degs{{ $widget->id }} + 'deg)'
                });

                $('#vacancy-percentage').text(percentage{{ $widget->id }} + '%')
                $('#vacancy-value').text({{ $widget->graph_data->value1 }})

            }
        @else
            function findPercentageForPerformance(percentage = 0, property_value = 0) {

                let current_yearly_target{{ $widget->id }} = ((property_value * percentage) / 100).toFixed(2);

                let current_monthly_target{{ $widget->id }} = ((current_yearly_target{{ $widget->id }}) / 12).toFixed(
                    2);

                let monthly_income{{ $widget->id }} = parseFloat(
                    '{{ isset($widget->graph_data->monthly_income) ? $widget->graph_data->monthly_income : 0 }}'
                ) || 0;
                let monthly_target{{ $widget->id }} = parseFloat(current_monthly_target{{ $widget->id }}) || 0;

                let degs{{ $widget->id }} = 160;

                if (monthly_target{{ $widget->id }} > 0) {
                    let ratio{{ $widget->id }} = monthly_income{{ $widget->id }} / monthly_target{{ $widget->id }};

                    if (ratio{{ $widget->id }} >= 1.1) {
                        degs{{ $widget->id }} = 25;
                    } else if (ratio{{ $widget->id }} >= 1) {
                        degs{{ $widget->id }} = 90;
                    } else {
                        degs{{ $widget->id }} = 160;
                    }
                }

                $('#monthlyTargetBarometer').html(current_monthly_target{{ $widget->id }});
                $('#yearlyTargetBarometer').html(current_yearly_target{{ $widget->id }});

                const $arrow{{ $widget->id }} = baro{{ $widget->id }}.$element.find('.arrow');
                // For webkit browsers: e.g. Chrome
                $arrow{{ $widget->id }}.css({
                    WebkitTransform: 'translate(-53%, 0%)' + 'rotate(' + degs{{ $widget->id }} + 'deg)'
                });
                // For Mozilla browser: e.g. Firefox
                $arrow{{ $widget->id }}.css({
                    '-moz-transform': 'translate(-53%, 0%)' + 'rotate(' + degs{{ $widget->id }} + 'deg)'
                });
            }

            function percentageBarometer(val) {

                propertyValuePercentage{{ $widget->id }} = val;

                findPercentageForPerformance(val, propertyValue{{ $widget->id }});
            }

            function propertyValueBarometer(val) {
                propertyValue{{ $widget->id }} = val;

                findPercentageForPerformance(propertyValuePercentage{{ $widget->id }}, val);
            }
        @endif
    </script>
@endpush
