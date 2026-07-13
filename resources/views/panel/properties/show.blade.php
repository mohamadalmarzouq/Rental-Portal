@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            <div class="col-12">
                <div class="totalPropertiesWrap mg-b-20">
                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">Total Properties</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1">{{ $total_properties }}</h3>
                    </div>
                </div>
            </div>

            @foreach($widgets as $widget)
                @include('panel.widget_types.module_widget_counter',['widget' => $widget,'col' => 4])
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">Property Management</h3>
                    <div>
                        <a href="{{ route($module.'.export') }}" type="button"
                           class="btn btn-primary download-btn mr-2">Download</a>
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
                    <form action="{{ route($module.'.search') }}" method="get">
                        <div class="d-flex flex-row cusSelectWrp">
                            <select data-placeholder="All Status" class="cusSelect custom-select font-weight-500 mr-3"
                                    name="status"
                                    id="status">
                                <option value="">All Status</option>
                                @foreach($statuses as $status)
                                    <option
                                        {{ isset($search_property['status'])  ? checkSelectValue($search_property['status'], $status->id) : '' }}
                                        value="{{ $status->id }}">
                                        {{ $status->status }}
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
        <div class="row">
            <div class="col-12">
                @include('panel.includes.datatable')
            </div>
        </div>
    </div>

    @include('panel.properties.add')

@endsection
