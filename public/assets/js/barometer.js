(function ($) {
    var Barometer = function (element, options) {
        this.$element = $(element);
        //this.modal = this.$element.find('.modal');
        this.init(options);
        this.$element.data('barometer', this);
        this.curretValue = null;
        return this;
    };

    Barometer.prototype = {
        defaultOptions: {
            startvalue: 0,
            placeholder: "Insert rotation degrees",
            steps: 5
        },

        constructor: Barometer,
        init: function (options) {
            const self = this;
            self.options = $.extend({}, this.defaultOptions, options);
            self.createBarometer();
            self.createInputContainer();
            self.bindInput();
        },

        createBarometer: function () {
            const self = this;
            const preview = $("<div class=\"container\">" +
                "<div class=\"first_ring\"><div class=\"second_ring\"><div class=\"third_ring\"></div></div></div>" +
                "<div class=\"pie\"><div class=\"pie_segment red\"></div><div class=\"pie_segment orange\"></div><div class=\"pie_segment green\"></div><div class=\"pie_segment white\"></div></div>" +
                "<div class=\"second_layer\"></div><div class=\"third_layer\"></div>" +
                "<div class=\"arrow\"><div class=\"arrowtop\"></div><div class=\"arrowbottom\"></div></div>" +
                "<div class=\"middle_point\"></div></div>");
            self.$element.append(preview);
        },

        createInputContainer: function () {
            const self = this;
            const input = $("<div class='d-flex align-items-center mt-3'><div class='w-25 mr-3'><label>Percentage</label><input class='form-control' placeholder='Enter Percentage' type=\"number\" min=\"0\" max=\"100\" step=\"" + this.options.steps + "\"/></div><div class='w-25 mr-3'><label>Property Value</label><input class='form-control' placeholder='Property Value' type=\"number\" min=\"0\" max=\"100\"/></div><div class='d-flex'><div class='mr-3'><label>Monthly Target</label><p class='font-weight-bold pt-1 m-0'>500</p></div><div><label>Yearly Target</label><p class='font-weight-bold pt-1 m-0'>500</p></div></div></div>");
            self.$element.append(input);
        },

        rotate: function (degs) {
            // console.log(degs,'degree');
            degs = findPercentage(degs);
            // console.log(degs,'degree');
            const self = this;
            const $arrow = this.$element.find('.arrow');
            // For webkit browsers: e.g. Chrome
            $arrow.css({WebkitTransform: 'translate(-53%, 0%)' + 'rotate(' + degs + 'deg)'});
            // For Mozilla browser: e.g. Firefox
            $arrow.css({'-moz-transform': 'translate(-53%, 0%)' + 'rotate(' + degs + 'deg)'});
        },

        bindInput: function () {
            const self = this;
            self.$element.find('input').on('keyup', '', self, function (e) {
                self.rotate($(e.target).val());
            });
        },

    },

        $.fn.barometer = function (options, arg) {
            return new Barometer(this, options);
        };

    $.fn.barometer.Constructor = Barometer;


}(jQuery));
