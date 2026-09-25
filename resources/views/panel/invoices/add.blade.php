<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered set_modal_width" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header border-0">
                <h6 class="modal-title tx-20 tx-bold" id="exampleModalLabel2">{{ addTitle($module) }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route($module . '.add') }}" id="addForm">
                    @csrf
                    <input type="hidden" value="{{ $revenue_type_id }}" name="type_id" id="type_id">
                    <input type="hidden" value="" name="tenant_id" id="tenant_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ tn('Invoice Date') }}</label>
                                <input type="text" name="revenue_start_date" id="revenue_start_date"
                                    class="form-control" placeholder="{{ tn('Start Date') }}" value="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ t('common.payment_method') }}</label>
                                <select class="custom-select mr-0 font-weight-500" name="payment_method_id"
                                    id="payment_method_id">
                                    <option value="">{{ t('common.payment_method') }}</option>
                                    @foreach ($payment_methods as $payment_method)
                                        <option value="{{ $payment_method->id }}">
                                            {{ $payment_method->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ tn('Description (Optional)') }}</label>
                                <textarea id="description" name="description" class="form-control" cols="30" rows="3"
                                    placeholder="{{ tn('Enter Description') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="property-section">
                        <div class="row">
                            <div class="col-sm-6 property">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">{{ t('common.property') }}</label>
                                    <select class="custom-select mr-0 font-weight-500 property_name" data-counter="1" name="extras[1][property_id]"
                                        id="property_id">
                                        <option value="">{{ t('common.property') }}</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}">
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 property">
                                <div class="form-group" id="unit">
                                    <label for="" class="mb-1 tx-medium">Unit</label>
                                    <select class="custom-select mr-0 font-weight-500 unit-id-1" name="extras[1][unit_id]"
                                        id="unit_id">
                                        <option value="">{{ tn('Select Unit') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">{{ t('common.amount') }}</label>
                                    <input type="text" name="extras[1][total_amount]" id="total_amount"
                                        class="form-control" placeholder="{{ t('common.amount') }}"
                                        onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="mb-1 tx-medium">{{ tn('Lease/Non Lease') }}</label>
                                <div class="custom-control custom-switch cusToggle mg-t-8">
                                    <input type="hidden" name="extras[1][is_lease]" value="1">
                                    <input type="checkbox" name="extras[1][is_lease]" id="extras[1][is_lease]"
                                        class="custom-control-input check-lease" data-count="1" value="0">
                                    <label class="custom-control-label" for="extras[1][is_lease]"></label>
                                </div>
                            </div>
                            <div class="col-sm-6 waive-amount-1 d-flex">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">{{ tn('Waived amount') }}</label>
                                    <input type="text" name="extras[1][waive_amount]" id="waive_amount"
                                        class="form-control" placeholder="{{ t('common.amount') }}"
                                        onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                                </div>
                                <input class="mx-2" type="checkbox" name="" id="" checked>
                            </div>
                            <div class="col-sm-6">
                            </div>
                            <hr />
                        </div>
                    </div>
                    <input type="hidden" id="section-count" value="1">
                    <button class="btn btn-primary" type="button" id="add">{{ tn('Add') }} (+)</button>
                    <button class="btn btn-primary" type="button" id="sub">{{ tn('Remove') }} (-)</button>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group cusCheckBox custom-control custom-checkbox">
                                <input type="hidden" name="deposit" value="0">
                                {{-- <input type="checkbox" class="custom-control-input" name="deposit" id="deposit"
                                       value="1">
                                <label class="custom-control-label tx-medium" for="deposit">Deposit</label> --}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="document">{{ tn('Attachments') }}</label>
                                <div class="needsclick dropzone cusDropzone dropzone dz-clickable d-flex align-items-center justify-content-center"
                                    id="document-dropzone">

                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="text-right submitBtn">
                        <button class="btn btn-primary download-btn" type="submit">{{ tn('Submit') }}</button>
                    </div> --}}
                    <div
                        class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
                        <div class="btn_loader">
                            <div class="loader"></div>
                        </div>
                        <button class="btn btn-primary download-btn" type="submit">{{ tn('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addnewexpenses_modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered set_modal_width" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header border-0">
                <h6 class="modal-title tx-20 tx-bold" id="exampleModalLabel2">{{ t('form.add_expenses') }}</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route($module . '.expense') }}" id="addForm">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="type_id" value="{{ $expense_type_id }}">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ tn('Invoice Date') }}</label>

                                <input type="text" name="date_start_expense" id="date_start_expense"
                                    class="form-control" placeholder="Start Date" value="">
                            </div>
                        </div>
                        <div class="col-sm-12 property">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ tn('Description (Optional)') }}</label>
                                <textarea name="description" class="form-control" cols="30" rows="3" placeholder="{{ tn('Enter Description') }}"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 lease">

                            <div class="form-group" id="unit">
                                <label for="" class="mb-1 tx-medium">{{ t('common.property') }}</label>
                                <select name="expense_property_id" class="form-control border"
                                    id="expense_property_id">
                                    <option value="">{{ tn('Select Property') }}</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}">
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 lease">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">{{ t('common.amount') }}</label>
                                <input type="text" name="expense_amount" id="expense_amount" class="form-control"
                                    placeholder="{{ t('common.amount') }}" onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="document" class="tx-medium">{{ tn('Attachments') }}</label>
                                <div class="needsclick dropzone cusDropzone dz-clickable d-flex align-items-center justify-content-center"
                                    id="document-dropzone">

                                    <div class="dz-default dz-message">
                                        <button class="dz-button" type="button">{{ tn('Drop files here to upload') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- <div class="text-right submitBtn">
                        <button class="btn btn-primary download-btn" type="submit">{{ tn('Submit') }}</button>
                    </div> --}}
                    <div
                        class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
                        <div class="btn_loader">
                            <div class="loader"></div>
                        </div>
                        <button class="btn btn-primary download-btn" type="submit">{{ tn('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





@push('custom-head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
@endpush
@push('custom-scripts')
    <script type="text/javascript">
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('invoices.storeMedia') }}',
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(function() {

                document.getElementById("date_start_expense").readOnly = true;
                document.getElementById("revenue_start_date").readOnly = true;
            });

            $(document).on('change', '.property_name', function () {
                let id = $(this).val();
                let counter = $(this).data('counter');
                if (id) {
                    let requested_url = base_url + '/properties-get-property-units/' + id;

                    $.get(requested_url).done(function(data) {

                        $('.unit-id-'+counter).html(data);

                    }).fail(function(error) {

                    });
                }
            });



            $('input[name="date_start_expense"]').daterangepicker({
                timePicker: false,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('input[name="revenue_start_date"]').daterangepicker({
                timePicker: false,
                singleDatePicker: true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $("div#personal-pic").dropzone({
                url: $(this).attr('action'),
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(file, response) {
                    $('input[name=personal_pic]').val(response);
                }
            });

            $('#add').on('click', function() {
                var count = $('#section-count').val();
                count++;
                var html = `<div class="row">
                            <div class="col-sm-6 property">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">{{ t('common.property') }}</label>
                                    <select class="custom-select mr-0 font-weight-500 property_name" data-counter=`+count+` name="extras[`+count+`][property_id]"
                                        id="property_id">
                                        <option value="">{{ t('common.property') }}</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}">
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 property">
                                <div class="form-group" id="unit">
                                    <label for="" class="mb-1 tx-medium">Unit</label>
                                    <select class="custom-select mr-0 font-weight-500 unit-id-`+count+`" name="extras[`+count+`][unit_id]"
                                        id="unit_id">
                                        <option value="">{{ tn('Select Unit') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">Amount</label>
                                    <input type="text" name="extras[`+count+`][total_amount]" id="total_amount" class="form-control"
                                        placeholder="Amount" onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="mb-1 tx-medium">{{ tn('Lease/Non Lease') }}</label>
                                <div class="custom-control custom-switch cusToggle mg-t-8">
                                    <input type="hidden" name="extras[`+count+`][is_lease]" value="1">
                                    <input type="checkbox" name="extras[`+count+`][is_lease]" id="extras[`+count+`][is_lease]" class="custom-control-input check-lease" data-count=`+count+` value="0">
                                    <label class="custom-control-label" for="extras[`+count+`][is_lease]"></label>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex waive-amount-`+count+`">
                                <div class="form-group">
                                    <label for="" class="mb-1 tx-medium">Amount</label>
                                    <input type="text" name="extras[`+count+`][waive_amount]" id="waive_amount" class="form-control"
                                        placeholder="Amount"
                                        onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                                </div>
                                <input class="mx-2" type="checkbox" name="" id="" checked>
                            </div>
                            <div class="col-sm-6">
                            </div>
                            <hr />
                        </div>`;
                $('.property-section').append(html);
                $('#section-count').val(count);
            });

            $('#sub').on('click', function() {
                var count = $('#section-count').val();
                if (count == 1) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "last element couldn't be deleted!",
                    });
                    return false;
                }
                count--;
                $('.property-section').children().last().remove();
                $('#section-count').val(count);
            });

            $(document).on('change', '.check-lease', function () {
                var count = $(this).data('count');
                if ($(this).is(":checked")) {
                    $('.waive-amount-'+count).removeClass('d-flex');
                    $('.waive-amount-'+count).hide();
                } else {
                    $('.waive-amount-'+count).show();
                    $('.waive-amount-'+count).addClass('d-flex');
                }
            });
        });
    </script>
@endpush
