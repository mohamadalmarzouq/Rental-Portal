@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">{{ setText($module) }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('panel.includes.datatable')
            </div>
        </div>
    </div>
@endsection
