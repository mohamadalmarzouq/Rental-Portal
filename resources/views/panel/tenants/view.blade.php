<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Tenant Name</h6></label>
            <p>{{ $data->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Email</h6></label>
            <p>{{ $data->email }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Contact Number</h6></label>
            <p>{{ $data->contact_number }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>National ID</h6></label>
            <p>{{ $data->national_id }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Age</h6></label>
            <p>{{ $data->age }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Gender</h6></label>
            <p>{{ setText($data->gender) }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Residence Type</h6></label>
            <p>{{ $data->residence_type }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Status</h6></label>
            <p>{!! $data->tenant_status !!}</p>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Waived Amount</h6></label>
            <p>{!! addCommaForNumeric($waived_amount) !!}</p>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Overdue Amount</h6></label>
            <p>{!! addCommaForNumeric($overdue_amount) !!}</p>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Advance Payments</h6></label>
            <p>{!! addCommaForNumeric($advance_payments) !!}</p>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Deposit</h6></label>
            <p>{!! addCommaForNumeric($deposit) !!}</p>
        </div>
    </div>


</div>
