@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            <div class="col-12">
                <div class="totalPropertiesWrap mg-b-20">
                    <h6 class="tx-uppercase tx-15 tx-color-02 tx-semibold mb-2">{{ t('page.total_tenants') }}</h6>
                    <div class="d-flex d-lg-block d-xl-flex align-items-end mb-0">
                        <h3 class="tx-bold tx-roboto tx-color-navy mg-b-0 mg-r-5 lh-1">{{ $total_tenants }}</h3>
                    </div>
                </div>
            </div>
            @foreach($widgets as $widget)
                @include('panel.widget_types.module_widget_counter',['widget' => $widget,'col' => 3])
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">

                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">{{ setText($module) }} {{ t('common.management') }}</h3>
                    <div>
                        <a href="{{ route($module.'.export') }}" type="button" class="btn btn-primary download-btn mr-2">{{ t('common.download') }}</a>
                        @if(hasRole($module , 'add'))
                            <a href="#addModal" data-toggle="modal">
                                <button type="button" class="btn btn-success addNewBtn">{{ t('common.add_new') }} {{ setText($module,true) }}</button>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="d-flex propertyManagementSearchWrap mg-b-10">
                    <div class="search-form w-40 ht-35">
                        <button class="btn border-0" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <input type="search" id="search" class="form-control border-0" placeholder="{{ t('common.search') }}">
                    </div>
                    <div class="d-flex flex-row cusSelectWrp" >

                        <select data-placeholder="{{ tn('Select Property') }}"  class="cusSelect custom-select font-weight-500 mr-3 w-auto" onchange="changeProperty($(this).val())"  id="property_filter">
                            <option value="" disabled selected>{{ tn('Select Property') }}</option>
                            <option value="all" >{{ tn('All') }}</option>
                            @foreach($properties as $key=>$value)
                                <option value="{{$value}}">{{$key}}</option>
                            @endforeach

                        </select>

                        <select data-placeholder="{{ tn('Select Status') }}"  class="cusSelect custom-select font-weight-500 mr-3 w-auto" onchange="changeStatus($(this).val())"  id="status_filter">
                            <option value="" disabled selected>{{ tn('Select Status') }}</option>
                            <option value="all" >{{ tn('All') }}</option>
                            @foreach($statuses as $key=>$value)

                                <option value="{{$value->id}}">{{$value->status}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                @include('panel.includes.datatable')
            </div>
        </div>
    </div>

    @include('panel.tenants.add')

@endsection

@push('custom-scripts')

    <script type="text/javascript">


        function changeProperty(value){
          //  console.log(value);
            var table = $('#datatable-{{ $module }}').DataTable();
            var state = table.state.loaded();


                if(value=="all") {
                    console.log('aa');
                    table.search('').columns(1).search('').draw();
                }
                else{
                    console.log(value);
                    table.column(1).search(value,true, false).draw();
                }
               // table.search(this.value).draw();


        }

        function changeStatus(value){
            var table = $('#datatable-{{ $module }}').DataTable();




                if(value=="all") {
                    table.search('').columns(3).search('').draw();
                }
                else{
                    table.column(3).search(value, true, false).draw();
                }



        }



        function changeLeaseStatus(id, method) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to " + method + " the tenant!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, ' + method + ' it!'
            }).then((result) => {
                if (result.value
                ) {
                    let request_url = base_url + '/{{ $module }}-' + method + '_tenant/' + id;

                    $.get(request_url).done(function () {

                        var table = $('#datatable-{{ $module }}').DataTable();

                        table.ajax.reload();

                        Swal.fire(
                            'Success!',
                            'Tenant has been ' + method + 'ed.',
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



<style>
    .select_option{
        margin-left: 30px;
        border-radius: 8px;
    }
</style>


