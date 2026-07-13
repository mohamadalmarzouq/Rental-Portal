<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Name</h6></label>
            <p>{{ $data->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Total Units</h6></label>
            <p>{{ $data->total_units }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Vacant Units</h6></label>
            <p>{{ $data->vacant_units }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Occupied Units</h6></label>
            <p>{{ $data->occupied_units }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Status</h6></label>
            <p>{!! $data->property_status !!}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Address</h6></label>
            <p>{{ $data->address }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Country</h6></label>
            <p>{{ $data->countries->country_name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>PACI ID</h6></label>
            <p>{{ $data->paci_id }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>type</h6></label>
            <p>{{ $data->type->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Land Lord</h6></label>
            <p>{{ $data->land_lord }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Employee</h6></label>
            <p>{{ $data->employee }}</p>
        </div>
    </div>
</div>@if(count($data->units))
    <div class="row">
        <div class="col-12">
            <table id="" class="table table-bordered shadow-none">
                <thead>
                <tr>
                    <th class="font-weight-bold">Unit#</th>
                    <th class="font-weight-bold">Type</th>
                    <th class="font-weight-bold">Size</th>
                    <th class="font-weight-bold">Estimated Rent</th>
                </tr>
                </thead>
                <tbody>

                @foreach($data->units as $units)

                    <tr class="shadow-none">
                        <td>
                            <p>{{ $units->number }}</p>
                        </td>
                        <td><p>{{ $units->type }}</p></td>
                        <td><p>{{ $units->size }}</p></td>
                        <td><p>{{ addCommaForNumeric($units->estimated_rent) }}</p></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endif




