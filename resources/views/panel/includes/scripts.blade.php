<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/lib/bootstrapp/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/lib/feather-icons/feather.min.js') }}"></script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/lib/jquery.flot/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/lib/jquery.flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('assets/lib/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/lib/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

<script src="{{ asset('assets/js/dropzone.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.js') }}"></script>
<script src="{{ asset('assets/js/dashforge.sampledata.js') }}"></script>

<script src="{{ asset('assets/lib/js-cookie/js.cookie.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/sound.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    var base_url = "{{ url('') }}";

    ion.sound({
        sounds: [
            {
                name: "button_tiny"
            }
        ],
        volume: 0.5,
        path: "{{ asset('assets/js/sounds/') }}/",
        preload: true
    });

</script>

<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/printThis.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/jquery.datetimepicker.js') }}"></script>


<script type="text/javascript">

        $(document).ready(function() {
            $("#date_start").change(function(){
                var checkdate = $("#date_start").val();
                var date = moment(checkdate).format('DD-MM-YYYY');
                $(".datepickstart span").text(date);
                $(".datepickstart #date_start").val(date);
                var dateval = $(".datepickstart #date_start").attr('value', date);
                $("#date_start_expense").val(date);
                // console.log(dateval);
            });

            $("#date_end").change(function(){
                var checkdate = $("#date_end").val();
                var date = moment(checkdate).format('DD-MM-YYYY')
                $(".datepickend span").text(date);
                $(".datepickend #date_end").val(date);

                var dateval = $(".datepickend #date_end").attr('value', date);
                // console.log(dateval);
            });

            $("#addnewexpenses_date_start").change(function(){
                var checkdate = $("#addnewexpenses_date_start").val();
                var date = moment(checkdate).format('DD-MM-YYYY')
                $("#addnewexpenses_modal .datepickstart span").text(date);
                $("#addnewexpenses_modal .datepickstart #addnewexpenses_date_start").val(date);
                $("#date_start_expense").val(date);

                var dateval = $("#addnewexpenses_modal .datepickstart #addnewexpenses_date_start").attr('value', date);
                // console.log(dateval);
            });
            // $('#date_start').datepicker({ dateFormat: 'dd-mm-yy' }).val();
            $('#pills-revenue .custom-select').select2({
                placeholder: $(this).attr('data-placeholder'),
                minimumResultsForSearch: Infinity
            });
            // $('#pills-expenses .custom-select').select2({
            //     placeholder: $(this).attr('data-placeholder'),
            //     minimumResultsForSearch: Infinity
            // });



    //    $('#date_start').datepicker({ dateFormat: 'dd-mm-yy' }).val();
    });
</script>

