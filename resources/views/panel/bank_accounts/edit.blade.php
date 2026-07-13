@extends('panel.master')

@section('main')
    <div class="contents pt-4 pl-4 pr mb-3">
        <div class="row row-xs mt-2">
            <div class="col-sm-12 col-lg-12">
                <div class="card card-body">
                    <h3 class="tx-18">Edit {{ setText($module,true) }}</h3>
                    <div>
                        <form method="POST" action="{{ route($module.'.edit',['id' => $data->id]) }}" id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Bank Name</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control"
                                               placeholder="Bank Name" value="{{ $data->bank_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Account Title</label>
                                        <input type="text" name="account_title" id="account_title" class="form-control"
                                               placeholder="Account Title" value="{{ $data->account_title }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="" class="mb-1">Account Number</label>
                                        <input type="text" name="account_number" id="account_number"
                                               class="form-control"
                                               placeholder="Account Number" value="{{ $data->account_number }}">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right" type="submit">Submit</button>
                            <a class="btn btn-secondary float-right mx-2" href="{{ route($module.'.show') }}">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

