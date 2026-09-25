@extends('panel.master')

@section('main')
    <div class="primary-bg-color contents mg-y-60 mg-x-70 w-100">
        <div class="row">
            @include('auth.includes.flash_mesages')
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mg-b-20">
                    <h3 class="m-0 tx-27 tx-bold">{{ t('language.title') }}</h3>
                </div>
                <div class="card card-body">
                    <form method="POST" action="{{ route('languages.edit') }}" id="editForm">
                        @csrf
                        <div class="form-group">
                            <label class="mb-2 tx-medium">{{ t('language.display') }}</label>
                            <select class="custom-select" name="locale" style="max-width: 320px;">
                                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ t('language.english') }}</option>
                                <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>{{ t('language.arabic') }}</option>
                            </select>
                            <small class="form-text text-muted d-block mt-2">{{ t('language.help') }}</small>
                        </div>
                        <div class="text-right submitBtn mt-3">
                            <a class="btn btn-secondary mx-2" href="{{ url()->previous() }}">{{ t('common.cancel') }}</a>
                            <button class="btn btn-primary download-btn" type="submit">{{ t('common.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
