@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Add Future {{ setText($module,true) }}</h3>
                    <div>
                        <form method="POST" action="{{ route($module.'.add') }}" id="addFutureInvoice">
                            @csrf
                            <div class="row">

                                <input type="hidden" name="type_id" value="{{ getTypeId($module,'revenue') }}">
                                <input type="hidden" name="property_id" value="{{ $data->property_id }}">
                                <input type="hidden" name="unit_id" value="{{ $data->unit_id }}">
                                <input type="hidden" name="tenant_id" value="{{ $data->tenant_id }}">

                                <div class="col-sm-6 lease">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Invoice Type</label>
                                        <select class="custom-select mr-0 font-weight-500" name="type_id"
                                                id="type_id">
                                            <option value="{{ getTypeId($module,'revenue') }}">Revenue</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 lease">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Property</label>
                                        <select class="custom-select mr-0 font-weight-500" name="property_id"
                                                id="property_id">
                                            <option
                                                value="{{ $data->property_id }}">{{ $data->property->name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 lease">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Unit</label>
                                        <select class="custom-select mr-0 font-weight-500" name="unit_id"
                                                id="unit_id">
                                            <option value="{{ $data->unit_id }}">{{ $data->unit->number }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 lease">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Lease</label>
                                        <select class="custom-select mr-0 font-weight-500" name="lease_id"
                                                id="lease_id">
                                            <option value="{{ $data->id }}">{{ $data->lease_name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <h4 class="mb-3">Customer details</h4>
                                </div>

                                <div class="col-sm-6 lease">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Tenant Name</label>
                                        <select class="custom-select mr-0 font-weight-500" name="tenant_id"
                                                id="tenant_id">
                                            <option value="{{ $data->tenant_id }}">{{ $data->tenant->name }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Mobile number</label>
                                        <input type="number" name="mobile_number" id="mobile_number"
                                               class="form-control" disabled
                                               placeholder="Mobile number" value="{{ $data->tenant->contact_number }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Email ID</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               placeholder="Email ID" disabled
                                               value="{{ $data->tenant->email }}">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <h4>Invoice Details</h4>
                                </div>
                                <div class="col-sm-12 extras" id="extras">
                                </div>

                                <div class="col-sm-12 extras">
                                    <a href="javascript:;" id="add_more">
                                        <button type="button" class="btn btn-primary mr-2">Add More</button>
                                    </a>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Start Date</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                               placeholder="Start Date" value="{{ old('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                               placeholder="End Date" value="{{ old('end_date') }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Payment Method</label>
                                        <select class="custom-select mr-0 font-weight-500" name="payment_method_id"
                                                id="payment_method_id">
                                            <option value="">Payment Method</option>
                                            @foreach($payment_methods as $payment_method)
                                                <option value="{{ $payment_method->id }}">
                                                    {{ $payment_method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Description (mandatory)</label>
                                        <textarea id="description" name="description" class="form-control" cols="30"
                                                  rows="3"
                                                  placeholder="Description (mandatory)">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Comment</label>
                                        <textarea id="comment" name="comment" class="form-control" cols="30" rows="3"
                                                  placeholder="Comment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')

    <script type="text/javascript">

        let extras_key = 0;

        $(function () {

            $('#add_more').trigger('click');

        });

        $('#add_more').on('click', function () {

            let requested_url = base_url + '/{{ $module }}-extras/' + extras_key;

            $.get(requested_url).done(function (data) {

                $('#extras').append(data);

                extras_key++;

            }).fail(function (error) {

            });

        });

        $(document).on('submit', '#addFutureInvoice', function (event) {
            event.preventDefault();
            removeAjaxMsgs();
            let form = $(this);
            let btn = form.find('.btn');
            btn.attr("disabled", true);
            btn.addClass('loader');
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    window.location = '{{ route('invoices.show') }}';
                }, error: function (err) {
                    btn.attr("disabled", false);
                    btn.removeClass('loader');
                    showErrorMsgs(err);
                }
            });
        });

    </script>

@endpush
