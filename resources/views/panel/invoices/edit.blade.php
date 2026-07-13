@extends('panel.master')

@section('main')

    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Edit {{ setText($module,true) }}</h3>
                    <div>
                        {{--<form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                            @csrf
                            @if($data->type_id == $revenue_type_id)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="" class="mb-1">Invoice Type</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Mobile number" value="{{ $data->type->name }}">
                                    </div>

                                    <div class="col-sm-6" style="display: {{ $data->type_id == 6 ? 'block' : 'none' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Property</label>
                                            <input type="text" class="form-control" disabled
                                                   placeholder="Mobile number" value="{{ $data->property->name }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6" style="display: {{ $data->type_id == 6 ? 'block' : 'none' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Unit</label>
                                            <input type="text" class="form-control" disabled
                                                   placeholder="Mobile number" value="{{ $data->unit->number }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 lease"
                                         style="display: {{ $data->type_id == 5 ? 'block' : 'none' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Lease</label>
                                            <input type="text" class="form-control" disabled
                                                   placeholder=""
                                                   value="{{ isset($data->lease->lease_name) ? $data->lease->lease_name : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <h4 class="mb-3">Customer details</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Tenant</label>
                                            <select class="custom-select mr-0 font-weight-500" name="tenant_id"
                                                    id="tenant_id" disabled>
                                                <option value="">Tenant</option>
                                                @foreach($tenants as $tenant)
                                                    <option {{ $data->tenant_id == $tenant->id ? 'selected' : '' }}
                                                            value="{{ $tenant->id }}">
                                                        {{ $tenant->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Mobile number</label>
                                            <input type="number" name="mobile_number" id="mobile_number"
                                                   class="form-control"
                                                   placeholder="Mobile number"
                                                   value="{{ $data->tenant->contact_number }}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Email ID</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                   placeholder="Email ID"
                                                   value="{{ $data->tenant->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                   placeholder="Name" value="{{ $data->tenant->name }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <h4>Invoice Details</h4>
                                    </div>
                                    @if($data->type->slug == 'revenue')
                                        <div class="col-sm-12 extras" id="extras">
                                            @foreach($data->invoice_extras as $key => $extra)
                                                @include('panel.includes.invoices_extras',['key' => $key,'extra' => $extra])
                                            @endforeach
                                        </div>

                                        <div class="col-sm-12 extras">
                                            <a href="javascript:;" id="add_more">
                                                <button type="button" class="btn btn-primary mr-2">Add More</button>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-sm-6"
                                         style="display: {{ $data->type->slug == 'revenue' ? 'none' : 'block' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Amount</label>
                                            <input type="text" name="total_amount" id="total_amount"
                                                   class="form-control"
                                                   placeholder="Amount"
                                                   onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))"
                                                   value="{{ $data->total_amount }}">
                                        </div>
                                    </div>
                                    @if(in_array(Auth()->user()->role_id,Auth()->user()->getLandLordRoleIds()))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="mb-1">Status</label>
                                                <select class="custom-select mr-0 font-weight-500"
                                                        name="invoice_status_id"
                                                        id="invoice_status_id">
                                                    @foreach($statuses as $status)
                                                        <option
                                                            {{ $data->invoice_status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">
                                                            {{ $status->status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                   placeholder="Start Date" value="{{ $data->start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">End Date</label>
                                            <input type="text" name="end_date" id="end_date" class="form-control"
                                                   placeholder="End Date" value="{{ $data->end_date }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Payment Method</label>
                                            <select class="custom-select mr-0 font-weight-500" name="payment_method_id"
                                                    id="payment_method_id">
                                                <option value="">Payment Method</option>
                                                @foreach($payment_methods as $payment_method)
                                                    <option
                                                        {{ $data->payment_method_id == $payment_method->id ? 'selected' : '' }}
                                                        value="{{ $payment_method->id }}">
                                                        {{ $payment_method->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="document">Attachments</label>
                                            <div
                                                class="needsclick dropzone cusDropzone dropzone dz-clickable d-flex align-items-center justify-content-center"
                                                id="document-dropzone">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Description (mandatory)</label>
                                            <textarea id="description" name="description" class="form-control" cols="30"
                                                      rows="3"
                                                      placeholder="Description (mandatory)">{{ $data->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Comment</label>
                                            <textarea id="comment" name="comment" class="form-control" cols="30"
                                                      rows="3"
                                                      placeholder="Comment">{{ $data->comment }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="" class="mb-1">Invoice Type</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Mobile number" value="{{ $data->type->name }}">
                                    </div>

                                    <div class="col-sm-6" style="display: {{ $data->type_id == 6 ? 'block' : 'none' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Property</label>
                                            <input type="text" class="form-control" disabled
                                                   placeholder="Mobile number" value="{{ $data->property->name }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6"
                                         style="display: {{ $data->type->slug == 'revenue' ? 'none' : 'block' }}">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Amount</label>
                                            <input type="text" name="total_amount" id="total_amount"
                                                   class="form-control"
                                                   placeholder="Amount"
                                                   onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))"
                                                   value="{{ $data->total_amount }}">
                                        </div>
                                    </div>
                                    @if(in_array(Auth()->user()->role_id,Auth()->user()->getLandLordRoleIds()))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="mb-1">Status</label>
                                                <select class="custom-select mr-0 font-weight-500"
                                                        name="invoice_status_id"
                                                        id="invoice_status_id">
                                                    @foreach($statuses as $status)
                                                        <option
                                                            {{ $data->invoice_status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">
                                                            {{ $status->status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Start Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                   placeholder="Start Date" value="{{ $data->start_date }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="end_date" class="form-control"
                                           placeholder="Start Date" value="{{ $data->end_date }}">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="document">Attachments</label>
                                            <div
                                                class="needsclick dropzone cusDropzone dropzone dz-clickable d-flex align-items-center justify-content-center"
                                                id="document-dropzone">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="mb-1">Description (mandatory)</label>
                                            <textarea id="description" name="description" class="form-control" cols="30"
                                                      rows="3"
                                                      placeholder="Description (mandatory)">{{ $data->description }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>--}}

                        <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                            @csrf
                            @if($data->type_id == $revenue_type_id)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Invoice Date</label>
                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                   placeholder="Start Date" value="{{ $data->start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Payment Method</label>
                                            <select class="custom-select mr-0 font-weight-500" name="payment_method_id"
                                                    id="payment_method_id">
                                                @foreach($payment_methods as $payment_method)
                                                    <option
                                                        {{ $data->payment_method_id == $payment_method->id ? 'selected' : '' }} value="{{ $payment_method->id }}">
                                                        {{ $payment_method->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Property</label>
                                            <input disabled class="form-control" name=""
                                                    id="" value="{{ $data->property->name??'' }}"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Unit</label>
                                            <input disabled class="form-control" name=""
                                                   id="" value="{{ $data->unit->number??'' }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Amount</label>
                                            <input type="text" name="total_amount" id="total_amount"
                                                   class="form-control"
                                                   onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))"
                                                   placeholder="Amount"
                                                   value="{{ number_format($data->total_amount) }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group cusCheckBox custom-control custom-checkbox">
                                            <input type="hidden" name="deposit" value="0">
                                            <input {{ $data->deposit ? 'checked' : '' }} type="checkbox" class="custom-control-input" name="deposit" id="deposit"
                                                   value="1">
                                            <label class="custom-control-label tx-medium" for="deposit">Deposit</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document" class="tx-medium">Attachments</label>
                                            <div
                                                class="needsclick dropzone cusDropzone dropzone dz-clickable d-flex align-items-center justify-content-center"
                                                id="document-dropzone">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Description (mandatory)</label>
                                            <textarea id="description" name="description" class="form-control" cols="30"
                                                      rows="3"
                                                      placeholder="Description (mandatory)">{{$invoiceModel->getOriginal('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Invoice Date</label>

                                            <input type="text" name="start_date" id="start_date" class="form-control"
                                                   placeholder="Start Date" value="{{ $data->start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="unit">
                                            <label for="" class="mb-1 tx-medium">Property</label>
                                            <input type="text" disabled class="form-control"
                                                   value="{{ $data->property->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Amount</label>
                                            <input type="text" name="total_amount" id="total_amount"
                                                   class="form-control"
                                                   onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))"
                                                   placeholder="Amount"
                                                   value="{{ number_format($data->total_amount) }}">
                                        </div>
                                    </div>
                                    @if(in_array(Auth()->user()->role_id,Auth()->user()->getLandLordRoleIds()))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="" class="mb-1">Status</label>
                                                <select class="custom-select mr-0 font-weight-500"
                                                        name="invoice_status_id"
                                                        id="invoice_status_id">
                                                    @foreach($statuses as $status)
                                                        <option
                                                            {{ $data->invoice_status_id == $status->id ? 'selected' : '' }}
                                                            value="{{ $status->id }}">
                                                            {{ $status->status }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document" class="tx-medium">Attachments</label>
                                            <div
                                                class="needsclick dropzone cusDropzone dropzone dz-clickable d-flex align-items-center justify-content-center"
                                                id="document-dropzone">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="mb-1 tx-medium">Description (mandatory)</label>
                                            <textarea id="description" name="description" class="form-control" cols="30"
                                                      rows="3"
                                                      placeholder="Description (mandatory)">{{ $data->description }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            <div class="btn_loader_wrap add position-relative d-flex align-items-center">
                                <div class="btn_loader">
                                    <div class="loader"></div>
                                </div>
                                <a class="btn btn-secondary mx-2" href="{{ route($module.'.show') }}">Cancel</a>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                          {{--  <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
@endpush
@push('custom-scripts')

    <script type="text/javascript">

        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('invoices.storeMedia') }}',
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($data) && $data->attachments)
                var files =
                    {!! json_encode($data->attachments) !!};
                for (var i in files) {
                    var file = files[i]
                    file.name = file.name.split('_')[1]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }

    </script>

    <script type="text/javascript">
        $(function () {

            document.getElementById("start_date").readOnly = true;
            document.getElementById("end_date").readOnly = true;

        });

        /* Start Date */
        $('input[name="start_date"]').daterangepicker({
            timePicker: false,
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        /* End Date */
        $('input[name="end_date"]').daterangepicker({
            timePicker: false,
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        @if($data->type_id != $revenue_type_id)
        $('input[name="start_date"]').on('change', function () {
            $('input[name="end_date"]').val($(this).val())
            $('input[name="start_date"]').val($(this).val())
        })
        @endif

        let extras_key = '{{ count($data->invoice_extras) }}';

        $('#add_more').on('click', function () {

            let requested_url = base_url + '/{{ $module }}-extras/' + extras_key;

            $.get(requested_url).done(function (data) {

                $('#extras').append(data);

                extras_key++;

            }).fail(function (error) {

            });

        });

        function removeExtra(key, id) {

            if (id) {
                let requested_url = base_url + '/{{ $module }}-remove-extra/' + id;

                $.get(requested_url).done(function (data) {

                    $('#extras-' + key).remove();

                }).fail(function (error) {

                });
            } else {
                $('#extras-' + key).remove();
            }

        }

    </script>

@endpush
