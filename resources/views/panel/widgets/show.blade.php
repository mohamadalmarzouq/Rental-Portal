@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <h3 class="tx-18">{{ setText($module) }} Management</h3>
                        <div>
                            @if(hasRole($module , 'add'))
                                <a href="#addModal" data-toggle="modal">
                                    <button type="button" class="btn btn-primary mr-2">Add
                                        New {{ setText($module,true) }}</button>
                                </a>
                            @endif
                        </div>
                    </div>
                    @include('panel.includes.datatable')
                </div>
            </div>
        </div>
    </div>

    @include('panel.widgets.add')
@endsection
