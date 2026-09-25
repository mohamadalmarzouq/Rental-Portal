@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills mg-b-85 invoice_nav" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-revenue-tab" data-toggle="pill" href="#pills-revenue"
                            role="tab" aria-controls="pills-revenue" aria-selected="true">{{ tn('Revenue') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-expenses-tab" data-toggle="pill" href="#pills-expenses" role="tab"
                            aria-controls="pills-expenses" aria-selected="false">{{ t('page.expenses') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-revenue" role="tabpanel"
                        aria-labelledby="pills-revenue-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="totalPropertiesWrap mg-b-20">
                                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">{{ t('page.total_invoices') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1">
                                            {{ $widgets['revenues']['total'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mg-b-50 d-flex col-md-6">
                                <div class="card card-body border-primary">
                                    <h6 class="tx-uppercase tx-16 tx-spacing-1 tx-color-02 tx-semibold mb-2">
                                        {{ t('page.approved') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto mg-b-0 tx-30">{{ $widgets['revenues']['approved'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mg-b-50 d-flex col-md-6">
                                <div class="card card-body border-primary">
                                    <h6 class="tx-uppercase tx-16 tx-spacing-1 tx-color-02 tx-semibold mb-2">
                                        {{ t('page.pending') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto mg-b-0 tx-30">{{ $widgets['revenues']['pending'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mg-b-20">
                                    <h3 class="m-0 tx-27 tx-bold">{{ t('page.revenues') }}</h3>
                                    <div>
                                        <a href="{{ route($module . '.revenue.export') }}" type="button"
                                            class="btn btn-primary download-btn mr-2">{{ t('common.download') }}</a>
                                        @if (hasRole($module, 'add'))
                                            <a href="#addModal" data-toggle="modal">
                                                <button type="button" class="btn btn-success addNewBtn">{{ t('common.add_new') }} {{ setText($module, true) }}</button>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="propertyManagementSearchWrap mg-b-10">
                                    <div class="search-form w-40 ht-35 mg-b-25">
                                        <button class="btn border-0" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </button>
                                        <input type="search" id="search-{{ $module }}" class="form-control border-0"
                                            placeholder="{{ t('common.search') }}">
                                        @push('custom-scripts')
                                            <script type="text/javascript">
                                                $('#search-{{ $module }}').keyup(function() {
                                                    let table = $('#datatable-{{ $module }}').DataTable();
                                                    table.search(this.value).draw();
                                                });
                                            </script>
                                        @endpush
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">

                                            <form method="GET" action="{{ route($module . '.search') }}">
                                                <div class="d-flex flex-row cusSelectWrp">
                                                    <select data-placeholder="Property"
                                                        class="cusSelect custom-select font-weight-500 mr-3 w-auto"
                                                        name="property" id="property">
                                                        <!-- <input type="text"> -->
                                                        <option value="">Property</option>
                                                        @foreach ($properties as $property)
                                                            <option
                                                                {{ isset($search_invoice['property']) ? checkSelectValue($search_invoice['property'], $property->id) : '' }}
                                                                value="{{ $property->id }}">
                                                                {{ $property->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>



                                                    <select data-placeholder="All Status"
                                                        class="cusSelect custom-select font-weight-500 mr-3" name="status"
                                                        id="status">
                                                        <option value="">Status</option>
                                                        @foreach ($statuses as $status)
                                                            <option
                                                                {{ isset($search_invoice['status']) ? checkSelectValue($search_invoice['status'], $status->id) : '' }}
                                                                value="{{ $status->id }}">
                                                                {{ $status->status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select data-placeholder="Payment Method"
                                                        class="cusSelect custom-select font-weight-500 mr-3" name="method"
                                                        id="method">
                                                        <option value="">Method</option>
                                                        @foreach ($payment_methods as $payment_method)
                                                            <option
                                                                {{ isset($search_invoice['method']) ? checkSelectValue($search_invoice['method'], $payment_method->id) : '' }}
                                                                value="{{ $payment_method->id }}">
                                                                {{ $payment_method->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mb-0 mr-3">
                                                        <div class="datepickstart bg-white form-control">
                                                            <span class="text-secondary">dd/mm/yyyy</span>
                                                            <i class="fa fa-calendar text-dark float-right"></i>
                                                            <input type="date" name="date" id="date_start"
                                                                class="form-control cusInput" placeholder="Start Date"
                                                                value="{{ isset($search_invoice['date_start']) ? $search_invoice['date_start'] : '' }}">

                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0 mr-3">
                                                        <div class="datepickend bg-white form-control">
                                                            <span class="text-secondary">dd/mm/yyyy</span>
                                                            <i class="fa fa-calendar text-dark float-right"></i>
                                                            <input type="date" name="date" id="date_end"
                                                                class="form-control cusInput" placeholder="Start Date"
                                                                value="{{ isset($search_invoice['date_end']) ? $search_invoice['date_end'] : '' }}">

                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <button type="submit" class="btn btn-primary download-btn mr-2">
                                                            {{ t('common.search') }}
                                                        </button>

                                                    </div>
                                                    <a class="btn btn-primary download-btn"
                                                        href="{{ route($module . '.show') }}">{{ t('common.clear') }}</a>
                                                </div>




                                            </form>



                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-12">
                                @include('panel.includes.datatable')
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-expenses" role="tabpanel" aria-labelledby="pills-expenses-tab">
                        <div class="row">
                            <div class="col-12">
                                <div class="totalPropertiesWrap mg-b-20">
                                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">{{ t('page.total_invoices') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1">
                                            {{ $widgets['expenses']['total'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mg-b-50 d-flex col-md-6">
                                <div class="card card-body border-primary">
                                    <h6 class="tx-uppercase tx-16 tx-spacing-1 tx-color-02 tx-semibold mb-2">
                                        {{ t('page.approved') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto mg-b-0 tx-30">{{ $widgets['expenses']['approved'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="mg-b-50 d-flex col-md-6">
                                <div class="card card-body border-primary">
                                    <h6 class="tx-uppercase tx-16 tx-spacing-1 tx-color-02 tx-semibold mb-2">
                                        {{ t('page.pending') }}</h6>
                                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                                        <h3 class="tx-bold tx-roboto mg-b-0 tx-30">{{ $widgets['expenses']['pending'] }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between mg-b-20">
                                    <h3 class="m-0 tx-27 tx-bold">{{ t('page.expenses') }}</h3>
                                    <div>
                                        <a href="{{ route($module . '.expense.export') }}" type="button"
                                            class="btn btn-primary download-btn mr-2">{{ t('common.download') }}</a>

                                        <a href="#addnewexpenses_modal" data-toggle="modal">
                                            <button type="button" class="btn btn-success addNewBtn">
                                                {{ t('page.add_new_expenses') }}</button>
                                        </a>
                                    </div>
                                </div>
                                <div class="propertyManagementSearchWrap mg-b-10">
                                    <div class="search-form w-40 ht-35 mg-b-25">
                                        <button class="btn border-0" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65">
                                                </line>
                                            </svg>
                                        </button>
                                        <input type="search" id="search-expense_invoice" class="form-control border-0"
                                            placeholder="{{ t('common.search') }}">
                                        @push('custom-scripts')
                                            <script type="text/javascript">
                                                $('#search-expense_invoice').keyup(function() {
                                                    let table = $('#datatable-expense_invoice').DataTable();
                                                    table.search(this.value).draw();
                                                });
                                            </script>
                                        @endpush

                                    </div>

                                    <div class="row">
                                        <div class="col-md-10">

                                            <form method="GET" action="{{ route($module . '.search') }}">
                                                <div class="d-flex flex-row cusSelectWrp">
                                                    <select data-placeholder="Property"
                                                        class="cusSelect custom-select font-weight-500 mr-3 w-auto"
                                                        name="property" id="property">
                                                        <!-- <input type="text"> -->
                                                        <option value="">Property</option>
                                                        @foreach ($properties as $property)
                                                            <option
                                                                {{ isset($search_invoice['property']) ? checkSelectValue($search_invoice['property'], $property->id) : '' }}
                                                                value="{{ $property->id }}">
                                                                {{ $property->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>



                                                    <select data-placeholder="All Status"
                                                        class="cusSelect custom-select font-weight-500 mr-3"
                                                        name="status" id="status">
                                                        <option value="">Status</option>
                                                        @foreach ($statuses as $status)
                                                            <option
                                                                {{ isset($search_invoice['status']) ? checkSelectValue($search_invoice['status'], $status->id) : '' }}
                                                                value="{{ $status->id }}">
                                                                {{ $status->status }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select data-placeholder="Payment Method"
                                                        class="cusSelect custom-select font-weight-500 mr-3"
                                                        name="method" id="method">
                                                        <option value="">Method</option>
                                                        @foreach ($payment_methods as $payment_method)
                                                            <option
                                                                {{ isset($search_invoice['method']) ? checkSelectValue($search_invoice['method'], $payment_method->id) : '' }}
                                                                value="{{ $payment_method->id }}">
                                                                {{ $payment_method->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="form-group mb-0 mr-3">
                                                        <div class="datepickstart bg-white form-control">
                                                            <span class="text-secondary">dd/mm/yyyy</span>
                                                            <i class="fa fa-calendar text-dark float-right"></i>
                                                            <input type="date" name="date" id="date_start"
                                                                class="form-control cusInput" placeholder="Start Date"
                                                                value="{{ isset($search_invoice['date_start']) ? $search_invoice['date_start'] : '' }}">

                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-0 mr-3">
                                                        <div class="datepickend bg-white form-control">
                                                            <span class="text-secondary">dd/mm/yyyy</span>
                                                            <i class="fa fa-calendar text-dark float-right"></i>
                                                            <input type="date" name="date" id="date_end"
                                                                class="form-control cusInput" placeholder="Start Date"
                                                                value="{{ isset($search_invoice['date_end']) ? $search_invoice['date_end'] : '' }}">

                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <button type="submit" class="btn btn-primary download-btn mr-2">
                                                            {{ t('common.search') }}
                                                        </button>

                                                    </div>
                                                    <a class="btn btn-primary download-btn"
                                                        href="{{ route($module . '.show') }}">{{ t('common.clear') }}</a>
                                                </div>




                                            </form>



                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @include('panel.includes.datatable', [
                                    'module' => 'expense_invoice',
                                    'route_name_for_listing' => $expense_route_name_for_listing,
                                    'data_table_columns' => $expense_data_table_columns,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="invoice-print" style="display: none"></div>
    @include('panel.invoices.add')
@endsection

@push('custom-scripts')
    <script type="text/javascript">
        function changePropertyFilter(value) {

            var table = $('#datatable-{{ $module }}').DataTable();
            // var state = table.state.loaded();

            $('#property_filter').on('change', function() {
                if (value == "all") {

                    table.search('').columns().search('').draw();
                } else {

                    table.search(value).draw();
                }
                // table.search(this.value).draw();
            });

        }

        /* function changeInvoiceStatus(id, method, module) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + method + " the invoice!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + method + ' it!'
            }).then((result) => {
                if (result.value
                ) {
                    let request_url = base_url + '/{{ $module }}-' + method + '_invoice/' + id;

                    $.get(request_url).done(function () {

                        var table = $('#datatable-' + module).DataTable();
                        table.ajax.reload();
                        let method_name = method;
                        if (method == 'cancel') {
                            method_name = 'cancelled';
                        }

                        Swal.fire(
                            'Success!',
                            'Invoice has been ' + method_name + '.',
                            'success'
                        )
                    }).fail(function (err) {
                        console.log(err);
                    });
                }
            })
        } */

        function markAsPaidInvoice(id, module) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to paid the invoice!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, paid it!'
            }).then((result) => {
                if (result.value) {
                    let request_url = base_url + '/{{ $module }}-paid_invoice/' + id;

                    $.get(request_url).done(function() {

                        var table = $('#datatable-' + module).DataTable();
                        table.ajax.reload();

                        Swal.fire(
                            'Success!',
                            'invoice has been paid.',
                            'success'
                        )
                    }).fail(function(err) {
                        console.log(err);
                    });
                }
            })
        }

        function printInvoice(id) {

            let requested_url = base_url + '/{{ $module }}-view/' + id;

            $.get(requested_url, function(data) {
                let printWindow = window.open(''); // Open a new window
                printWindow.document.write('<html><head><title>Print Invoice</title></head><body>');
                printWindow.document.write(data); // Inject the invoice data
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();

                // Wait for the content to load, then print
                setTimeout(function() {
                    printWindow.print();
                    printWindow.onafterprint = function() {
                        printWindow.close(); // Close the print window after printing
                    };
                }, 500);
            }).fail(function(error) {

            });

        }

        $(document).ready(function() {


            $('#datatable-invoices td').css('word-wrap', 'break-word');
            $('#datatable-invoices td').css('max-width', '400px');
            $('#datatable-invoices td').css('white-space', 'inherit');

            // $("#date_start").change(function(){
            //     $('input[id$=date_start]').datepicker({
            //         dateFormat: 'dd/mm/yy'
            //     });
            // });

            // $("#date_start").change(function(){
            //     var checkdate = $("#date_start").val();
            //     var date = moment(checkdate).format('DD-MM-YYYY')
            //     $(".datepickstart span").text(date);
            //     $(".datepickstart #date_start").val(date);
            //
            //     var dateval = $(".datepickstart #date_start").attr('value', date);
            //     console.log(dateval);
            // });
            //
            // $("#date_end").change(function(){
            //     var checkdate = $("#date_end").val();
            //     var date = moment(checkdate).format('DD-MM-YYYY')
            //     $(".datepickend span").text(date);
            //     $(".datepickend #date_end").val(date);
            //
            //     var dateval = $(".datepickend #date_end").attr('value', date);
            //     console.log(dateval);
            // });

        });
    </script>
@endpush


<style>
    .select_option {
        margin-left: 30px;
        border-radius: 8px;
    }
</style>
