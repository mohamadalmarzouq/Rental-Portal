@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            <div class="col-md-4">
                <div class="totalPropertiesWrap mg-b-20">
                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">Total Leases</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1">{{ $total_leases }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="totalPropertiesWrap mg-b-20">
                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">Pending Leases</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1"> {{ $pending_leases }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="totalPropertiesWrap mg-b-20">
                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">Active Leases</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1"> {{ $approved_leases }}</h3>
                    </div>
                </div>
            </div>

            @foreach($widgets as $widget)
                @include('panel.widget_types.module_widget_counter',['widget' => $widget,'col' => 6])
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">{{ setText($module) }} Management</h3>
                    <div>
                        <a href="{{ route($module.'.export') }}" type="button" class="btn btn-primary download-btn mr-2">Download</a>
                        @if(hasRole($module , 'add'))
                            <a href="#addModal" data-toggle="modal">
                                <button type="button" class="btn btn-success addNewBtn">Add
                                    New {{ setText($module,true) }}</button>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="d-flex propertyManagementSearchWrap mg-b-10">
                    <div class="search-form w-40 mr-3 ht-35">
                        <button class="btn border-0" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <input type="search" id="search" class="form-control border-0" placeholder="Search">
                    </div>
                    <form method="GET" action="{{ route($module.'.search') }}">
                        <div class="d-flex flex-row cusSelectWrp">
                            <select data-placeholder="Lease Type" class="cusSelect custom-select font-weight-500 mr-3 w-auto" name="type" id="type">
                                <option value="">Lease Type</option>
                                @foreach($types as $type)
                                    <option
                                        {{ isset($search_lease['type'])  ? checkSelectValue($search_lease['type'], $type->id) : '' }}
                                        value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select data-placeholder="All Status" class="cusSelect custom-select font-weight-500 mr-3" name="status"
                                    id="status">
                                <option value="">Status</option>
                                @foreach($statuses as $status)
                                    <option
                                        {{ isset($search_lease['status'])  ? checkSelectValue($search_lease['status'], $status->id) : '' }}
                                        value="{{ $status->id }}">
                                        {{ $status->status }}
                                    </option>
                                @endforeach
                            </select>

                            <select data-placeholder="Property" class="cusSelect custom-select font-weight-500 mr-3" name="property"
                                    id="property">
                                <option value="">Property</option>
                                @foreach($properties as $property)
                                    <option
                                        {{ isset($search_lease['property'])  ? checkSelectValue($search_lease['property'], $property->id) : '' }}
                                        value="{{ $property->id }}">
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary download-btn mr-2">Search</button>
                            <a class="btn btn-primary download-btn" href="{{ route($module.'.show') }}">Clear</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mg-b-20">
            <div class="col-12">
                @include('panel.includes.datatable')
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between mg-b-20">
                        <h3 class="m-0 tx-27 tx-bold">OverDue Payments</h3>
                    </div>

                    @include('panel.includes.datatable',
                                ['module' => 'invoices',
                                'data_table_columns' => $overdue_data_table_columns,
                                'route_name_for_listing' => $overdue_route_name,
                                'ordering' => $ordering_column_overdue
                                ])
            </div>
        </div>
    </div>
    @include('panel.includes.comment_modal')
    @include('panel.leases.add')

@endsection

@push('custom-scripts')

    <script type="text/javascript">

function changeInvoiceStatus(id, method, module) {

        if(id)
        {

            $.ajax({
                type: 'get',
                url: base_url+'/invoices-check_tenant/'+id,
                data: {'id':id},
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                  let  response = JSON.parse(data);
                  const csrfToken = "{{ csrf_token() }}";
                    if(response.tenant_status == 'blocked')
                    {
                        Swal.fire({
                        title: 'Invoice can not be sent! the tenant is blocked.',
                        text: "Are you sure you want to unblock the tenant ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, unblock!'
                        }).then((result) => {
                            if (result.value
                            ) {

                                $.ajax({
                                    method: 'post',
                                    url: base_url+'/invoices-update_tenant/'+id,
                                    data: {'id':id,_token: csrfToken},
                                    cache: false,
                                    success: function (data) {
                                    let  update_res = JSON.parse(data);
                                        if(update_res.tenant_status)
                                        {
                                            Swal.fire({
                                            title: 'Success!',
                                            text: 'Tenant has been unblocked.',
                                            icon: 'success',
                                            }).then(() => {
                                                location.reload();
                                            });
                                        }
                                    },error: function (err) {

                                    }
                                });
                             }
                        }) //swal then end
                    }
                    else if(response.tenant_status == 'active')
                    {
                        Swal.fire({
                            title: 'Are you sure???',
                            text: "You want to " + method + " the invoice!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, ' + method + ' it!'
                        }).then((result) => {
                            if (result.value) {
                                let request_url = base_url + '/invoices-' + method + '_invoice/' + id;

                                // Show loader before making AJAX request
                                Swal.fire({
                                    title: 'Sending Email',
                                    html: 'Please wait...',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    }
                                });

                                $.get(request_url).done(function () {

                                    var table = $('#datatable-' + module).DataTable();
                                    table.ajax.reload();
                                    let method_name = method;
                                    if (method == 'cancel') {
                                        method_name = 'cancelled';
                                    }

                                    // Close loader after a short delay
                                    setTimeout(() => {
                                        Swal.close();
                                        Swal.fire(
                                            'Success!',
                                            'Invoice has been sent.',
                                            'success'
                                        );
                                    }, 500);

                                }).fail(function (err) {
                                    console.log(err);
                                    // Close loader in case of failure
                                    Swal.close();
                                });
                            }
                        });
                    }

                }, error: function (err) {
                   // btn.attr("disabled", false);
                   // btn.removeClass('loader');
                    //showErrorMsgs(err);
                }
            });
        }


        }

        function changeLeaseStatus(id, method) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + method + " the lease!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + method + ' it!'
            }).then((result) => {
                if (result.value
                ) {
                    let request_url = base_url + '/{{ $module }}-' + method + '_lease/' + id;

                    $.get(request_url).done(function () {

                        var table = $('#datatable-{{ $module }}').DataTable();
                        table.ajax.reload();

                        Swal.fire(
                            'Success!',
                            'Lease has been ' + method + 'ed.',
                            'success'
                        )
                    }).fail(function (err) {
                        console.log(err);
                    });
                }
            })
        }

    </script>

@endpush
