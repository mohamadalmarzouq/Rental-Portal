@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Edit {{ setText($module,true) }}</h3>
                    <div>
                        <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Property Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               placeholder="Name"
                                               value="{{ $data->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">PACI ID (optional)</label>
                                        <input type="number" name="paci_id" id="paci_id" class="form-control"
                                               placeholder="PACI ID (optional)" value="{{ $data->paci_id }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="" class="mb-1">Property Type</label>
                                    <select  onchange="setUnitType(this.value)"  class="custom-select mb-20 mr-0 font-weight-500 form-control" name="type_id"
                                            id="type_id">
                                        @foreach($types as $type)
                                            <option {{ $data->type_id == $type->id ? 'selected' : ''}}
                                                    value="{{ $type->id }}" data-value="{{$type->name}}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label for="" class="mb-1">Employee In Charge</label>
                                    <select class="custom-select mb-20 mr-0 font-weight-500 form-control" name="assigned_to"
                                            id="assigned_to">
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option {{ $property_assigned_to_id == $employee->id ? 'selected' : '' }}
                                                    value="{{ $employee->id }}">
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label for="" class="mb-1">Country</label>
                                    <select class="custom-select mb-20 mr-0 font-weight-500 form-control" name="country"
                                            id="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option {{ $country->id == $data->country ? 'selected' : '' }}
                                                    value="{{ $country->country_code }}">
                                                {{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <label for="" class="mb-1">Status</label>
                                    <select class="custom-select mr-0 font-weight-500 form-control" name="property_status_id"
                                            id="property_status_id">
                                        @foreach($statuses as $status)
                                            <option
                                                {{ $data->property_status_id == $status->id ? 'selected' : '' }}
                                                value="{{ $status->id }}">
                                                {{ $status->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                               placeholder="Address" value="{{ $data->address }}">
                                    </div>
                                    <input type="hidden" name="longitude" id="longitude" value="{{ $data->longitude }}"/>
                                    <input type="hidden" name="latitude" id="latitude" value="{{ $data->latitude }}"/>
                                    <div style="height: 300px; width: 100%" id="map"></div>

                                </div>
                                <div id="units">
                                    @foreach($data->units as $index => $unit)
                                        @include('panel.includes.units',['data' => $unit, 'index' => $index,'property'=>$data])
                                    @endforeach

                                </div>
                                <div class="col-md-12 mt-4 d-flex">
                                    <a class="btn btn-secondary mx-2" href="{{ route($module.'.show') }}">Cancel</a>
                                    <a href="javascript:;" id="add_unit">
                                        <button type="button" class="btn btn-primary mr-2">Add Unit</button>
                                    </a>
                                    <div class="btn_loader_wrap add position-relative d-flex align-items-center ml-0">
                                        <div class="btn_loader">
                                            <div class="loader"></div>
                                        </div>
                                        <button class="btn btn-primary" id="unitDuplication" type="submit">Submit</button>
                                    </div>
                                    {{--<button class="btn btn-primary" type="submit">Submit</button>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}
        &amp;libraries=places"></script>
    <script type="text/javascript">



        let index = '{{ count($data->units) }}';

        $(function () {

            initializePropertyLocation();
            initializePropertyLocation1('{{ $data->latitude }}', '{{ $data->longitude }}', 19);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    console.log("HEre2");
                    initializePropertyLocation1('{{ $data->latitude }}', '{{ $data->longitude }}', 19);
                });
            } else {

                alert("Sorry, your browser does not support geolocation services.");
            }

            $('#country').on('change', function() {
                let selectedCountryCode = $(this).val();
                initializePropertyLocation(selectedCountryCode);
            });

        });

        $('#type_id').on('change',function(){
            var selected_text = $("#type_id :selected").data('value');
            console.log(selected_text);
            if(selected_text=="Residential" || selected_text=="Investment"){

            var html='<option id="residential_type"'+
            'value="residential">'+
            'Residential </option>';

            $('#unit_select_type').append(html);
                $('.no_of_bedroom').css('display','block');

            }
            else{
                $("#residential_type").remove();
                $('.no_of_bedroom').css('display','none');
            }
        });


        function initializePropertyLocation1(lat, lng, zoom) {
            let myLatLng = new google.maps.LatLng(lat, lng),
                myOptions = {
                    zoom: zoom,
                    center: myLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                },
                map = new google.maps.Map(document.getElementById('map'), myOptions),
                marker = new google.maps.Marker({position: myLatLng, map: map, draggable: true});

            marker.setMap(map);

            google.maps.event.addListener(marker, 'dragend', function (evt) {
                let geocoder = new google.maps.Geocoder;

                let latlng = {
                    lat: parseFloat(evt.latLng.lat().toFixed(3)),
                    lng: parseFloat(evt.latLng.lng().toFixed(3))
                };
                geocoder.geocode({'location': latlng}, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            let longitude = document.getElementById('longitude');

                            let address = document.getElementById('address');

                            let latitude = document.getElementById('latitude');

                            latitude.value = evt.latLng.lat().toFixed(3);

                            address.value = results[0].formatted_address;

                            longitude.value = evt.latLng.lng().toFixed(3);

                        } else {
                            alert('No results found');
                        }
                    } else {
                        alert('Geocoder failed due to: ' + status);
                    }
                });
            });

        }



       /*  $('#address').on('keyup', function () {
            initializePropertyLocation();
        }); */

        // function initializePropertyLocation() {
            function initializePropertyLocation(countryCode) {

            let input = document.getElementById('address');

            let autocompleteOptions = {};

            if (countryCode) {
                autocompleteOptions.componentRestrictions = { country: countryCode };
            }
            let autocomplete = new google.maps.places.Autocomplete(input,autocompleteOptions);
            // let autocomplete = new google.maps.places.Autocomplete(input);


            autocomplete.addListener('place_changed', function () {

                let place = autocomplete.getPlace();

                let longitude = document.getElementById('longitude');

                let latitude = document.getElementById('latitude');

                latitude.value = place.geometry['location'].lat();

                longitude.value = place.geometry['location'].lng();

                initializePropertyLocation1(place.geometry['location'].lat(), place.geometry['location'].lng(), 19);

            });
        }

        function checkUnitNumber(number)
        {
            let units = @json($data->units);
            let unique_units = [];
            units.forEach(unit => {
                unique_units.push(Number(unit.number));
            });
            var unit_input = document.getElementById('unit_'+number+'_number');
            var unit_div = document.getElementById('unit'+number);
            let check = unique_units.includes(Number(unit_input.value));
            let error = document.getElementById('unitNumberValidation');
            let submitBtn = document.getElementById('unitDuplication');
            if(check){
                $("#unitCustomMessage").remove();
                $("#unit_"+number+"_number").after('<div class="alert alert-danger" id="unitCustomMessage">Unit number already exists</div>');
                submitBtn.setAttribute('disabled', true);
            }
            else{
                $("#unitCustomMessage").remove();
                submitBtn.removeAttribute('disabled', false);
            }
        }

        $('#add_unit').on('click', function () {

            let requested_url = base_url + '/{{ $module }}-get-unit-view/' + index + '/'+{!! $data->id !!};

            $.get(requested_url).done(function (data) {
                $('#units').append(data);

                index++;

            }).fail(function (error) {

            });

        });

        function checkUnitType(index, value) {

            if (value == 'residential') {

                $('#residential' + index).css('display', 'block');
            } else {
                $('#residential' + index).css('display', 'none');
                $('#unit_' + index + '_no_of_bedrooms').val('');
                $('#unit_' + index + '_no_of_bathrooms').val('');
            }
        }

        function removeUnit(unit_div, unit_id) {

            let requested_url = base_url + '/{{ $module }}-remove-unit/' + unit_id;

            $.get(requested_url).done(function (data) {

                $('#' + unit_div).remove();

                index--;

            }).fail(function (error) {

            });
        }

    </script>

@endpush
