<div class="row">

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Property</h6></label>
            <p>{{ $data->property->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Unit</h6></label>
            <p>{{ $data->unit->number?? '' }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Type</h6></label>
            <p>{{ $data->type->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Tenant</h6></label>
            <p>{{ $data->tenant->name }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Frequency</h6></label>
            <p>{{ $data->frequency->name }}</p>
        </div>
    </div>



    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Advance Payments</h6></label>
            <p>{{ addCommaForNumeric($data->advance_payment) }}</p>
        </div>
    </div>


    <div style="color: {{ $data->status->status != 'active' ? 'red' : '' }}" class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Total Waived amount</h6></label>
            <p>{{ addCommaForNumeric($data->waived_amount) }}</p>
        </div>
    </div>

    <div style="color: {{ $data->status->status != 'active' ? 'red' : '' }}" class="col-12 col-md-12">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Overdue amount</h6></label>
            <p>{{ addCommaForNumeric($overdue_amount) }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Lease Payable</h6></label>
            <p>{{ $data->lease_payable }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Pending Amount</h6></label>
            <p>{{ $data->pending_amount }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Monthly Rent</h6></label>
            <p>{{ $data->month_rent }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Start Date</h6></label>
            <p>{{  date('F jS, Y', strtotime($data->start_date)) }}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Due Date</h6></label>
            <p>{{ $data->due_date ? date('F jS, Y', strtotime($data->due_date)) : date('F jS, Y', strtotime($data->end_date)) }}</p>
            <small class="text-muted">(Due date includes grace period)</small>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Status</h6></label>
            <p>{!! $data->lease_status !!}</p>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group pt-2">
            <label for="inputEmail"><h6>Description</h6></label>
            <p>{{ $data->description }}</p>
        </div>
    </div>
    @if($data->attachments)
        <div class="col-12 col-md-6">
            <div class="form-group pt-2">
                <a href="{{ URL::asset($data->attachments) }}" type="button" class="btn btn-primary download-btn mr-2" download>Download Attachment</a>
            </div>
        </div>
    @endif



</div>
