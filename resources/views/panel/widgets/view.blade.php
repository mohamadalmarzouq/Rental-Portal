@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">View {{ setText($module,true) }}</h3>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group pt-2">
                                <label for="inputEmail"><h6>Tenant Name</h6></label>
                                <p>{{ $data->name }}</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group pt-2">
                                <label for="inputEmail"><h6>Email</h6></label>
                                <p>{{ $data->email }}</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group pt-2">
                                <label for="inputEmail"><h6>Contact Number</h6></label>
                                <p>{{ $data->contact_number }}</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group pt-2">
                                <label for="inputEmail"><h6>National ID</h6></label>
                                <p>{{ $data->national_id }}</p>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group pt-2">
                                <label for="inputEmail"><h6>Status</h6></label>
                                <p>{!! $data->tenant_status !!}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

