@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
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
                        <input type="search" id="search" class="form-control border-0" placeholder="Search User">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('panel.includes.datatable')
            </div>
        </div>
    </div>

    @include('panel.employees.add')

@endsection
@push('custom-scripts')
<script>
    $('.addNewBtn').click(function(){
        $('#email').val('');
        $('#password').val('');
    })
</script>
@endpush
