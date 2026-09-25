<div class="mg-b-50 d-flex {{ $widget->class }}">
    <div class="card card-body counterWrap">
        <span class="imgWrp">
            <img class="img-fluid" src="{{ asset($widget->icon) }}" alt="">
        </span>
        <h6 class="tx-uppercase">{{ tn($widget->title) }}</h6>
        <div class="d-flex d-lg-block d-xl-flex align-items-end mb-2" id="cardsData">
            <h3 class="mg-b-0 mg-r-5 lh-1 tx-roboto dashboard-card-value" data-widget-id="{{ $widget->id }}"><span class="kwd">KWD</span> {{ isset($widget->query[0]->value) ? $widget->query[0]->value : 0 }}</h3>
        </div>
    </div>
</div>
