<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered set_modal_width" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header border-0">
                <h6 class="modal-title tx-20 tx-bold" id="exampleModalLabel2">Add New {{ setText($module,true) }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route($module.'.add') }}" id="addForm">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Property Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">PACI ID (optional)</label>
                                <input type="number" name="paci_id" id="paci_id" class="form-control"
                                       placeholder="PACI ID (optional)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="" class="mb-1 tx-medium">Property Type</label>
                            <select class="custom-select mb-20 mr-0 font-weight-500" name="type_id" id="type_id">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="" class="mb-1 tx-medium">Employee in charge</label>
                            <select class="custom-select mb-20 mr-0 font-weight-500" name="assigned_to"
                                    id="assigned_to">
                                <option value="">Employee </option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                            <label for="" class="mb-1 tx-medium">Country</label>
                            <select class="custom-select mb-20 mr-0 font-weight-500" name="country"
                                    id="country">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option {{ $country->country_code == 'KW' ? 'selected' : '' }}
                                            value="{{ $country->country_code }}">
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Address</label>
                                <input type="text" name="address" id="address" class="form-control"
                                       placeholder="Address">

                            </div>
                            <input type="hidden" name="longitude" id="longitude" value=""/>
                            <input type="hidden" name="latitude" id="latitude" value=""/>
                            <div style="height: 250px; width: 100%" id="map"></div>
                        </div>
                        {{-- <div class="col-3">
                            <div class="form-group" style="margin-top: 26px">
                                <button style="padding: 5px 5px 5px 5px" id='search-address' class="btn btn-primary" type="button"> search address </button>
                            </div>
                        </div> --}}
                    </div>
                    <div class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
                        <div class="btn_loader">
                            <div class="loader"></div>
                        </div>
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>
                   {{-- <div class="text-right submitBtn mt-3">
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>--}}
                </form>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places"></script>

<script type="text/javascript">
    let map, marker, geocoder, autocomplete;

    $(function () {
        // Initialize map based on current location
        initializePropertyLocation();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    // Successfully obtained the user's location
                    initializePropertyLocation1(position.coords.latitude, position.coords.longitude, 15);
                },
                function (error) {
                    // Handle geolocation errors
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            alert("Geolocation failed: User denied the request for Geolocation.");
                            break;
                        case error.POSITION_UNAVAILABLE:
                            alert("Geolocation failed: Location information is unavailable.");
                            break;
                        case error.TIMEOUT:
                            alert("Geolocation failed: The request to get user location timed out.");
                            break;
                        case error.UNKNOWN_ERROR:
                            alert("Geolocation failed: An unknown error occurred.");
                            break;
                    }
                    // Optionally provide a default location
                    initializePropertyLocation1(40.7128, -74.0060, 15); // Default to New York City
                }
            );
        } else {
            alert("Sorry, your browser does not support geolocation services.");
        }

        // Listen for country selection change
        $('#country').on('change', function() {
            let selectedCountryCode = $(this).val();
            initializePropertyLocation(selectedCountryCode);
        });
    });

    function initializePropertyLocation1(lat, lng, zoom) {
        let myLatLng = new google.maps.LatLng(lat, lng);
        let myOptions = {
            zoom: zoom,
            center: myLatLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map'), myOptions);
        geocoder = new google.maps.Geocoder();

        // Initialize marker
        marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true,
            title: "Drag me to update the address!"
        });

        // Add event listener for marker dragend
        google.maps.event.addListener(marker, 'dragend', function (evt) {
            updateAddress(evt.latLng.lat(), evt.latLng.lng());
        });

        // Add event listener for map click
        google.maps.event.addListener(map, 'click', function (event) {
            marker.setPosition(event.latLng);
            updateAddress(event.latLng.lat(), event.latLng.lng());
        });
    }

    function updateAddress(lat, lng) {
        let latlng = {
            lat: parseFloat(lat.toFixed(6)), // Using six decimal places for more precision
            lng: parseFloat(lng.toFixed(6))
        };

        geocoder.geocode({'location': latlng}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    let longitude = document.getElementById('longitude');
                    let address = document.getElementById('address');
                    let latitude = document.getElementById('latitude');

                    latitude.value = lat.toFixed(6); // Use six decimal places for precision
                    address.value = results[0].formatted_address; // Use the most precise address available
                    longitude.value = lng.toFixed(6);

                    // Optional: Log results for debugging
                    console.log('Geocode results:', results);
                } else {
                    alert('No results found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });
    }

    function initializePropertyLocation(countryCode) {
        let input = document.getElementById('address');
        let autocompleteOptions = {};

        // If map exists, reset it before applying new restrictions
        if (map && marker) {
            map.setCenter(new google.maps.LatLng(0, 0)); // Reset map center
            marker.setMap(null); // Remove the existing marker
        }

        // Apply country restriction if selected
        if (countryCode) {
            autocompleteOptions.componentRestrictions = { country: countryCode };
        }

        // Create a new Autocomplete instance for the address input
        autocomplete = new google.maps.places.Autocomplete(input, autocompleteOptions);

        autocomplete.addListener('place_changed', function () {
            let place = autocomplete.getPlace();

            if (!place.geometry) {
                alert("No details available for input: '" + place.name + "'");
                return;
            }

            let longitude = document.getElementById('longitude');
            let latitude = document.getElementById('latitude');

            latitude.value = place.geometry['location'].lat().toFixed(6);
            longitude.value = place.geometry['location'].lng().toFixed(6);

            initializePropertyLocation1(place.geometry['location'].lat(), place.geometry['location'].lng(), 19);
        });
    }
</script>
@endpush
