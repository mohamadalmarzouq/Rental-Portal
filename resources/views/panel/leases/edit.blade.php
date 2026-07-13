@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Edit {{ setText($module,true) }}</h3>
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm"
                              class="m-0">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Property</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Lease Name" value="{{ $data->property->name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="unit">
                                        <label for="" class="mb-1">Unit</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Lease Name">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" id="unit">
                                        <label for="" class="mb-1">Unit Type</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Lease Name" value="{{ $data->unit->type }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Lease Type</label>
                                        <select class="custom-select mr-0 font-weight-500" name="type_id" id="type_id">
                                            <option value="">Lease Type</option>
                                            @foreach($types as $type)
                                                <option
                                                    {{ $data->type_id == $type->id ? 'selected' : '' }} value="{{ $type->id }}">
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Status</label>
                                        <select class="custom-select mr-0 font-weight-500" name="lease_status_id"
                                                id="lease_status_id">
                                            @foreach($statuses as $status)
                                                <option
                                                    {{ $data->lease_status_id == $status->id ? 'selected' : '' }}
                                                    value="{{ $status->id }}">
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group" id="res_type_status">
                                        <label for="" class="mb-1 ">Residence Type</label>
                                        <select onchange="checkResidenceTypeEdit($(this).val());"
                                                class="custom-select mr-0 font-weight-500"
                                                name="residence_type" id="residence_type">

                                            <option
                                                {{ isset($data->residence_type) ? $data->residence_type == 'commercial' ? 'selected' : '' : '' }}
                                                value="commercial">
                                                Commercial
                                            </option>
                                            @if(isset($data->unit) && $data->unit->type== 'residential')
                                                <option
                                                    {{ isset($data->residence_type) ? $data->residence_type == 'residential' ? 'selected' : '' : ''}}
                                                    value="residential">
                                                    Residential
                                                </option>
                                            @endif
                                        </select>
                                        @if(isset($data->residence_type) && $data->residence_type== 'residential')
                                            <div id="res_status" class="mt-3">
                                                <label for="" class="mb-1 ">Choose Status</label>
                                                <div id="marriage_status">
                                                    <label for="" class="mb-1">Family</label>
                                                    <input
                                                        {{ $data->marriage_status=="family" ?"checked":""}} type="radio"
                                                        name="marriage_status" value="family"></div>
                                                <div><label for="" class="mb-1">Single</label>
                                                    <input
                                                        {{ $data->marriage_status=="single" ?"checked":""}} type="radio"
                                                        name="marriage_status" value="single"/>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-sm-6" id="rental_div"
                                     style="display: {{ $data->type_id == 3 ? 'block' : 'none' }}">
                                    <label for="" class="mb-1">Unit Type</label>
                                    <select class="custom-select mr-0 font-weight-500" id="rental" disabled>
                                        <option
                                            {{ $data->rental == 'commercial' ? 'selected' : '' }} value="commercial">
                                            Commercial
                                        </option>
                                        <option
                                            {{ $data->rental == 'residential' ? 'selected' : '' }} value="residential">
                                            Residential
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <h4 class="mt-3">Contact Details</h4>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Tenant</label>
                                        <input type="text" class="form-control" disabled
                                               placeholder="Lease Name" value="{{ $data->tenant->name }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1 ">Advance Payments</label>
                                        <input type="text" value="{{ $data->advance_payment }}"
                                               name="advance_payment" id="advance_payment" class="form-control"
                                               placeholder="Enter Advance Payment"
                                               onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1 ">Total Waived amount</label>
                                        <input type="text" value="{{ $data->waived_amount }}"
                                               name="waived_amount" id="waived_amount" class="form-control"
                                               placeholder="Enter Total Waived amount"
                                               onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1 ">Overdue Amount</label>
                                        <input type="text" name="overdue_amount" id="overdue_amount"
                                               class="form-control"
                                               placeholder="Overdue Amount"
                                               onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <h4>Lease Information</h4>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Frequency</label>
                                        <select class="custom-select mr-0 font-weight-500" name="frequency_id"
                                                id="frequency_id">
                                            @foreach($frequencies as $frequency)
                                                <option {{ $data->frequency_id == $frequency->id ? 'selected' : '' }}
                                                        value="{{ $frequency->id }}">
                                                    {{ $frequency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Monthly Rent</label>
                                        <input type="text" name="monthly_rent" id="monthly_rent" class="form-control"
                                               placeholder="Monthly Rent"
                                               value="{{ $data->monthly_rent }}"
                                               onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Lease Start Date</label>
                                        <input type="text" name="start_date" id="start_date"
                                               class="form-control"
                                               placeholder="Lease Start Date" value="{{ $data->start_date }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Lease End Date</label>
                                        <input type="text" name="end_date" id="end_date"
                                               class="form-control"
                                               placeholder="Lease End Date" value="{{ $data->end_date }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="document" class="mb-1">Attachments</label>
                                        <div class="custom-file-upload">
                                            <input type="file" name="file" onchange="changeName()">
                                            <label id="attachment-name">{{$data->attachment_name}}</label>
                                            <span class="remove_upload_file">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($data->attachments)
                                    <div class="col-12 col-md-6 d-flex align-items-center" id="download-attach">
                                        <div class="form-group m-0">
                                            <a href="{{ URL::asset($data->attachments) }}" type="button"
                                               class="btn btn-primary download-btn mr-2" download>Download
                                                Attachment</a>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Description (Optional)</label>
                                        <textarea id="description" name="description" class="form-control" cols="30"
                                                  rows="3"
                                                  placeholder="Description (Optional)">{{ $data->description }}</textarea>
                                    </div>
                                </div>
                                {{--<div class="col-sm-12">
                                    <h4>Insurance Information (optional, one-time payment)</h4>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Amount – Manual input by user</label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                               placeholder="Amount – Manual input by user"
                                               value="{{ $data->amount }}"
                                               onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                                    </div>
                                </div>--}}
                                <div class="col-sm-12">
                                    <h4>Deposit Information</h4>
                                </div>
                                <div class="col-sm-12">
                                    <div class="custom-control custom-checkbox pd-l-28 mr-5 mb-3">
                                        <input type="hidden" name="enable_email" value="0">
                                        <input {{ $data->deposit ? 'checked' : '' }} type="checkbox"
                                               class="custom-control-input" name="enable_deposit"
                                               id="yes" value="1" onclick="show_amount($(this).val());">
                                        <label class="custom-control-label" for="yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 deposit_info mb-3">
                                    @if($data->deposit)
                                        <div class="form-group m-0 "><label for=""
                                                                            class="mb-1 ">Deposit</label><input
                                                type="text" name="deposit" id="deposit" class="form-control" value="{{ $data->deposit }}"
                                                placeholder="Enter Amount"></div>
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <h4>Notification Settings</h4>
                                </div>
                                <div class="col-sm-12 d-flex">
                                    <div class="custom-control custom-checkbox pd-l-28 mr-5 mb-3">
                                        <input type="hidden" name="enable_email" value="0">
                                        <input type="checkbox" class="custom-control-input" name="enable_email"
                                               id="enable_email" {{ $data->enable_email ? 'checked' : '' }} value="1">
                                        <label class="custom-control-label" for="enable_email">Email</label>
                                    </div>
                                    <div class="custom-control custom-checkbox pd-l-15">
                                        <input type="hidden" name="enable_sms" value="0">
                                        <input type="checkbox" class="custom-control-input" name="enable_sms"
                                               id="enable_sms" {{ $data->enable_sms ? 'checked' : '' }} value="1">
                                        <label class="custom-control-label" for="enable_sms">SMS</label>
                                    </div>
                                </div>
                                <div class="row mg-b-20 tenant-email-wrapper" style="display: block">
                                    <div class="col-sm-12">
                                        <label for="" style="color:red" class="tenant-email-error"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_loader_wrap add position-relative d-flex align-items-center">
                                <div class="btn_loader">
                                    <div class="loader"></div>
                                </div>
                                <a class="btn btn-secondary mx-2" href="{{ route($module.'.show') }}">Cancel</a>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                            {{--<button class="btn btn-primary float-right" type="submit">Submit</button>--}}
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

    $('#enable_email').change(function(){
            if($(this).is(":checked")) {
                var email = "{{ $data->tenant->email }}"
                if(!email)
                {
                    $('.tenant-email-error').text('Warning: tenant does not have any email address');
                }
            } else {
                $('.tenant-email-error').text('');
            }
        });

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
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }

    </script>

    <script type="text/javascript">

        var marriage_status_family = "{!! $data->marriage_status=="family"?"checked": "" !!}";
        var mariage_status_single = "{!! $data->marriage_status=="single"?"checked": "" !!}";
        //console.log(marriage_status);
        $(document).ready(function () {
            var residence_type = document.getElementById("unit_residence_type").value;

            if (residence_type == "residential") {
                $("#res_type_status").append('<div id="res_status" class="col-sm-6">' +
                    '<label for="" class="mb-1 ">Choose Status</label>\n' +
                    '                            <div>\n' +
                    '                                <label for="" class="mb-1">Family</label>\n' +
                    '                                <input type="radio" name="marriage_status" value="family"' + marriage_status_family + '/></div>\n' +
                    '                                <div><label for="" class="mb-1">Single</label>\n' +
                    '                                <input type="radio" name="marriage_status"value="single" ' + mariage_status_single + '/>\n' +
                    '                            </div>\n' +
                    '                        </div>');
            }
        });

        function checkResidenceTypeEdit(value) {

            if (value == 'residential') {
                $("#res_type_status").append('<div id="res_status" class="mt-3">' +
                    '<label for="" class="mb-1 ">Choose Status</label>\n' +
                    '                            <div>\n' +
                    '                                <label for="" class="mb-1">Family</label>\n' +
                    '                                <input type="radio" name="marriage_status" value="family"' + marriage_status_family + '/></div>\n' +
                    '                                <div><label for="" class="mb-1">Single</label>\n' +
                    '                               <input type="radio" name="marriage_status"value="single" ' + mariage_status_single + '/>\n' +
                    '                            </div>\n' +
                    '                        </div>');
                //$('#res_status').css('display','block');
                //alert("you selected res");

            } else if (value == "commercial") {
                $("#res_status").remove();
            }

        }


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

        $('#type_id').on('change', function () {

            if ($(this).val() == 3) {
                $("#rental_div").css("display", "block");
            } else {
                $("#rental_div").css("display", "none");
            }

        });

        $('#property_id').on('change', function () {

            let id = $(this).val();

            let requested_url = base_url + '/properties-get-property-units/' + id;

            $.get(requested_url).done(function (data) {

                $('#unit').html(data);

            }).fail(function (error) {

            });
        });

        /**/
        // Referneces
        var control = $(".custom-file-upload input"),
            clearBn = $(".remove_upload_file");

        // Setup the clear functionality
        clearBn.on("click", function () {


            $.get('{{ url('leases-remove-file/'.$data->id) }}').done(function (data) {
                $('#attachment-name').html('')
                control.replaceWith(control.val(''))
                $('#download-attach').html('')
            })
        });

        function changeName(){
            $('#attachment-name').html('')
        }

    </script>

@endpush


<style>
    .custom-file-upload {
        border: 1px solid #ccc;
        /*display: inline-block;*/
        padding: 6px 12px;
        cursor: pointer;
        width: auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .remove_upload_file {
        position: absolute;
        z-index: 100;
        top: 14px;
        right: 6px;
    }
    #attachment-name {
        width: 180px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0 20px 0 0;
        text-align: right;
    }
</style>
