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
                <form method="POST" action="{{ route($module.'.add') }}" id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mg-b-30">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Property</label>
                                <select class="custom-select mr-0 font-weight-500" name="property_id" id="property_id">
                                    <option value="">Select Property</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}">
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" id="unit">
                                <label for="" class="mb-1 tx-medium">Unit</label>
                                <select class="custom-select mr-0 font-weight-500 unit_id" name="unit_id" id="unit_id">
                                    {{--                                    <option value="commercial">Commercial</option>--}}
                                    {{--                                    <option value="residential">Residential</option> --}}
                                </select>
                            </div>
                        </div>



                        <div class="col-sm-6" id="unit_residence_type">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Residence Type</label>
                                <select onchange="checkResidenceType($(this).val());"
                                        class="custom-select mr-0 font-weight-500"
                                        name="residence_type" id="residence_type">
                                    <option value="">Select Residence Type</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="residential">Residential</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-0">
                                <label for="" class="mb-1 tx-medium">Lease Type</label>
                                <select class="custom-select mr-0 font-weight-500" name="type_id" id="type_id">
                                    <option value="">Lease Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Unit Type</label>
                                <input type="text" id="unit_type" class="form-control" readonly="true"
                                       placeholder="Unit Type"
                                       >
                            </div>
                        </div>
{{--
                        <div class="col-md-6">
                            <div class="form-group m-0" id="rental_div" style="display: none">
                                <label for="" class="mb-1 tx-medium">Unit Type</label>
                                <select onchange="setUnitType()" class="custom-select mr-0 font-weight-500"
                                        name="rental" id="rental">
                                    <option value="commercial" data-value="Commercial">Commercial</option>
                                    <option value="residential" data-value="Residential">Residential</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>

                    <div class="row mg-b-30">
                        <div class="col-md-12">
                            <h4 class="tx-20 tx-bold">Contact Details</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Tenant</label>
                                <select class="custom-select mr-0 font-weight-500" name="tenant_id" id="tenant_id">
                                    <option value="">Select Tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}">
                                            {{ $tenant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    <!-- <div class="col-sm-6">
                            <div class="form-group" >
                            <label for="" class="mb-1 tx-medium">Residence Type</label>
                            <select onchange="checkResidenceType($(this).val());" class="custom-select mr-0 font-weight-500"
                                    name="unit[residence][residence_type]" id="unit_residence_type">

                                <option {{ isset($data->residence_type) ? $data->residence_type == 'commercial' ? 'selected' : '' : '' }}
                        value="commercial">
                    Commercial
                </option>
                <option {{ isset($data->residence_type) ? $data->residence_type == 'residential' ? 'selected' : '' : ''}}
                        value="residential">
                    Residential
                </option>
            </select>
            </div>
        </div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Email</label>
                                <input type="text" name="tenant_email" id="tenant_email" class="form-control" readonly="true"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group m-0">
                                <label for="" class="mb-1 tx-medium">Advance Payments</label>
                                <input type="text" name="advance_payment" id="advance_payment" class="form-control" readonly="true"
                                       placeholder="Enter Advance Payment"
                                       onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Total Waived amount</label>
                                <input type="text" name="waived_amount" id="waived_amount" class="form-control" readonly="true"
                                       placeholder="Enter Total Waived amount"
                                       onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Overdue Amount</label>
                                <input type="text" name="overdue_amount" id="overdue_amount" class="form-control" readonly="true"
                                       placeholder="Overdue Amount"
                                       onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>

                        <div id="res_type_status" class="col-sm-6">

                        </div>
                    </div>

                    <div class="row mg-b-30">
                        <div class="col-sm-12">
                            <h4 class="tx-20 tx-bold">Lease Information</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Frequency</label>
                                <select class="custom-select mr-0 font-weight-500" name="frequency_id"
                                        id="frequency_id">
                                    @foreach($frequencies as $frequency)
                                        <option value="{{ $frequency->id }}">
                                            {{ $frequency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Monthly Rent</label>
                                <input type="text" name="monthly_rent" id="monthly_rent" class="form-control"
                                       placeholder="Enter Amount"
                                       onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Lease Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                       placeholder="Lease Start Date">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Lease End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                       placeholder="Lease End Date">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group custom-file-upload">
                                <label for="document">Attachments</label><br/>
                                <input type="file" name="file">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-0">
                                <label for="" class="mb-1 tx-medium">Description (Optional)</label>
                                <textarea id="description" name="description" class="form-control" cols="30" rows="3"
                                          placeholder="Description (Optional)"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-b-30">
                        <div class="col-sm-12">
                            <h4 class="tx-20 tx-bold">Deposit Information</h4>
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-control custom-checkbox pd-l-28 mr-5 mb-3">
                                <input type="hidden" name="enable_email" value="0">
                                <input type="checkbox" class="custom-control-input" name="enable_deposit"
                                       id="yes" value="1" onclick="show_amount($(this).val());">
                                <label class="custom-control-label" for="yes">Yes</label>
                            </div>
                        </div>
                        <div class="col-sm-12 deposit_info">

                        </div>
                        {{--<div class="col-sm-12">
                            <div class="form-group">
                                <label for="" class="mb-1 tx-medium">Amount – Manual input by user</label>
                                <input type="text" name="amount" id="amount" class="form-control"
                                       placeholder="Amount – Manual input by user"
                                       onkeyup="ReplaceNumberWithCommas($(this).val(),$(this))">
                            </div>
                        </div>--}}
                    </div>
                    <div class="row mg-b-20">

                        <div class="col-sm-12">
                            <h4 class="tx-20 tx-bold">Notification Settings</h4>
                        </div>
                        <div class="col-sm-12">
                            <div class="custom-control custom-checkbox">

                                <input type="checkbox" class="custom-control-input" name="enable_notifications"
                                       id="enable_notifications"
                                       onclick="show_options($(this).val());">


                                <label class="custom-control-label" for="enable_notifications">Yes</label>

                            </div>
                        </div>
                        <div class="col-sm-12" id="notification_types_box"></div>
                    </div>
                    <div class="row mg-b-20 tenant-email-wrapper" style="" >
                        <div class="col-sm-12">
                            <p for="" style="color:red" class="tenant-email-error"></p>
                        </div>
                    </div>
                   {{-- <div class="text-right submitBtn">
                        <button class="btn btn-primary download-btn" type="submit">Submit</button>
                    </div>--}}

                    <div class="btn_loader_wrap add position-relative d-flex align-items-center justify-content-end ml-auto submitBtn mt-3">
                        <div class="btn_loader">
                            <div class="loader"></div>
                        </div>
                        <button class="btn btn-primary download-btn" type="submit" id="lease-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('custom-head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet"/>
@endpush
@push('custom-scripts')
    <script type="text/javascript">

// document.addEventListener('DOMContentLoaded', function() {
//     const frequencySelect = document.getElementById('frequency_id');
//     const startDateInput = document.getElementById('start_date');
//     const endDateInput = document.getElementById('end_date');

//     // Add event listeners
//     frequencySelect.addEventListener('change', updateEndDate);
//     startDateInput.addEventListener('change', updateEndDate);

//     function updateEndDate() {
//         var frequency = parseInt(frequencySelect.value); // Get frequency in months
//         const startDate = new Date(startDateInput.value);
//         if(frequency == 18)
//         {
//             frequency = 1; //one month
//         }
//         else if(frequency == 19)
//         {
//             frequency = 3; //quarterly / three months
//         }
//         else if(frequency == 20)
//         {
//             frequency = 6; //sami annually / six months
//         }
//         else if(frequency == 22)
//         {
//             frequency = 12; //annually / twell months
//         }
//         if (isNaN(startDate.getTime())) {
//             endDateInput.value = '';
//             endDateInput.setAttribute('disabled', true);
//             return;
//         }

//         // Calculate the end date
//         const endDate = new Date(startDate);
//         endDate.setMonth(endDate.getMonth() + frequency);

//         // Format end date to YYYY-MM-DD
//         const endDateFormatted = endDate.toISOString().split('T')[0];
//         endDateInput.value = endDateFormatted;

//         // Disable dates after the end date
//         endDateInput.setAttribute('min', startDateInput.value);
//         endDateInput.setAttribute('max', endDateFormatted);
//         endDateInput.removeAttribute('disabled');
//     }
// });


        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: '{{ route('leases.storeMedia') }}',
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
            }
        }

    </script>
@endpush

@push('custom-scripts')

    <script type="text/javascript">
    $(document).on('change', '#tenant-email', function() {
        if ($(this).is(":checked")) {
        var email = $('#tenant_email').val();

            if(!email)
            {
                // $('.tenant-email-wrapper').show();
                $('.tenant-email-error').text('Error: tenant does not have any email address');
            }
        } else {
              //  $('.tenant-email-error').text('');
        }
    });


        /* Start Date */
        // $('input[name="start_date"]').daterangepicker({
        //     timePicker: false,
        //     singleDatePicker: true,
        //     locale: {
        //         format: 'YYYY-MM-DD'
        //     }
        // });
        //
        // /* End Date */
        // $('input[name="end_date"]').daterangepicker({
        //     timePicker: false,
        //     singleDatePicker: true,
        //     locale: {
        //         format: 'YYYY-MM-DD'
        //     }
        // });

        $('#type_id').on('change', function () {

            if ($(this).val() == 3) {
                $("#rental_div").css("display", "block");
            } else {
                $("#rental_div").css("display", "none");
            }

        });

        $('#unit_id').on('change', function () {

            console.log("ASDasd");

        });



        $('#property_id').on('change', function () {

            let id = $(this).val();

            let requested_url = base_url + '/properties-get-property-units/' + id;

            $.get(requested_url).done(function (data) {
                $('#unit').html(data);
                $('#residence_type').html(
                    '<option value="">Select Residence Type</option>' +
                    '<option value="commercial">Commercial</option>' +
                    '<option value="residential">Residential</option>'
                );
                $("#res_type_status").html('');
                $('#unit_occupied_error').remove();
                $('#unit_type').val('');

            }).fail(function (error) {

            });
        });

        $('#tenant_id').on('change', function () {

            let id = $(this).val();

            let request_url = base_url + '/{{ $module }}-get-waived-amount/' + id;

            $.get(request_url).done(function (data) {

                $('#waived_amount').val(data.waived_amount);
                $('#tenant_email').val(data.tenant_email);
                var email = data.tenant_email;
                var tenant_status = data.status;
              /*   if(tenant_status == 'in-active')
                {
                    alert('Tenant is not activated. Please activate first!');
                    $('.tenant-email-error').html('Tenant is not activated. Please activate first!');
                    $('#lease-submit').attr('disabled',true);
                }
                else
                {
                    $('#lease-submit').attr('disabled',false);
                    $('.tenant-email-error').html('');
                } */
                if(!email)
                {
                    $('.tenant-email-error').text('Error: tenant does not have any email address');
                }
                else if(tenant_status != 'in-active')
                {
                    $('.tenant-email-error').text('');
                }
                $('#overdue_amount').val(data.overdue_amount);

            }).fail(function (error) {

            });

        });

    </script>

@endpush


<style>
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        width: auto;
    }
</style>
