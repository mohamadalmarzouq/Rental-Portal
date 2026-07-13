@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            @include('auth.includes.flash_mesages')
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">Edit {{ setText($module,true) }}</h3>
                </div>
                <div class="card card-body">
                    <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                        @csrf
                        <div id="google_translate_element"></div>
                        <div class="text-right submitBtn mt-3">
                            <a class="btn btn-secondary mx-2" href="{{ url()->previous() }}">Cancel</a>
                            <button class="btn btn-primary download-btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
