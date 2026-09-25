<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" translate="no" class="notranslate {{ app()->getLocale() === 'ar' ? 'locale-ar' : 'locale-en' }}">

@include('panel.includes.head')

<body>

    @include('panel.includes.top_bar')

    <section class="main-content-wrap w-100 d-flex">
        <div class="container-fluid">
            <div class="row">
                {{--@include('panel.includes.left_bar')--}}
                @yield('main')
            </div>
        </div>
    </section>

@include('panel.includes.scripts')

@stack('custom-scripts')
</body>
</html>
