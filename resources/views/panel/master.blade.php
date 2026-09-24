<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}" translate="no" class="notranslate">

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
