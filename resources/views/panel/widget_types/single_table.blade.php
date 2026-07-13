<div class="col-12 mg-b-50 outstandingBalancesWrap">
    @if(isset($widget->listing_data->total_amount))

        <h3 class="mg-b-20  tx-27 tx-bold">{{ $widget->title }}</h3>
        <div class="total_outstanding">
            <span class="total_collection_title mg-b-10 d-block">{{ $widget->sub_title }}</span>
            <h2 class="m-0 tx-roboto"><span
                    class="kwd ">KWD</span>{{ str_replace('KWD','',addCommaForNumeric($widget->listing_data->total_amount)) }}
            </h2>
        </div>
    @else

        <h3 class="mg-b-20 tx-27 tx-bold">{{ $widget->title }}
            <span class="d-block  mg-t-5">{{ $widget->sub_title }}</span>
        </h3>
    @endif
        @isset($show_in_dashboard)
            <div class="col show_in_dashboard text-right">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="show{{ $widget->id }}"
                           id="show{{ $widget->id }}"
                           data-id="{{ $widget->id }}" {{ showInDashboard($widget->id) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="show{{ $widget->id }}">Show in Dashboard</label>
                </div>
            </div>
        @endisset

    @if(isset($widget->listing_data->search))
        <div class="search-form mg-t-20">
            <button id="addInputClass" class="btn border-0" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <input type="search" id="search{{ $widget->id }}" class="form-control border-0 pl-1 clickInput"
                   placeholder="Search">
        </div>
        @push('custom-scripts')
            <script type="text/javascript">

                $('#search{{ $widget->id }}').keyup(function () {
                    let table = $('#datatable-{{ $widget->listing_data->module }}').DataTable();
                    table.search(this.value).draw();
                });
            </script>
        @endpush
    @endif
    <div class="table-responsive">
        @isset($widget->listing_data)
            @include('panel.includes.datatable' , [
             'data_table_columns' => $widget->listing_data->data_table_columns ,
             'route_name_for_listing' => $widget->listing_data->route_name_for_listing ,
             'module' => $widget->listing_data->module,
             'ordering' => isset($widget->listing_data->ordering) ? $widget->listing_data->ordering : 'false'])
        @endisset
    </div>

</div>

