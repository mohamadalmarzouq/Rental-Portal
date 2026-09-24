@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            @include('auth.includes.flash_mesages')
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">Language</h3>
                </div>
                <div class="card card-body">
                    <form method="POST" action="{{ route('languages.edit') }}" id="editForm">
                        @csrf
                        <div class="form-group">
                            <label class="mb-2 tx-medium">Display language</label>
                            <select class="custom-select" name="locale" style="max-width: 320px;">
                                <option value="en" {{ session('locale', 'en') === 'en' ? 'selected' : '' }}>English</option>
                                <option value="ar" {{ session('locale') === 'ar' ? 'selected' : '' }}>العربية</option>
                            </select>
                            <small class="form-text text-muted d-block mt-2">Choose English or Arabic here. The site will not use Google Translate.</small>
                        </div>
                        <div class="text-right submitBtn mt-3">
                            <a class="btn btn-secondary mx-2" href="{{ url()->previous() }}">Cancel</a>
                            <button class="btn btn-primary download-btn" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
