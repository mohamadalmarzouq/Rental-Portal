@extends('panel.master')

@section('main')

    <div class="contents pt-4 pl-4 pr mb-3">
        @foreach($data as $value)
            @if(isset($value->module))
                <a href="{{ $value->identifier=="land_lord_approved"?"#":route($value->module.'.edit' , ['id' => $value->ref_id]) }}" class="dropdown-item mb-3">
                    <div class="media">
                        <div class="avatar avatar-md avatar-{{ $value->read ? 'offline' : 'online' }}"><img
                                src="{{ getUserAvatar($value->sender) }}"
                                class="rounded-circle"
                                alt=""></div>
                        <div class="media-body mg-l-15">
                            {{ $value->makeNotificationBody($value) }}
                            <span>{{ $value->created_at->diffForHumans() }}</span>
                        </div><!-- media-body -->
                    </div><!-- media -->
                </a>
            @endif
        @endforeach
        @if(!count($data))
            <span>No Notifications</span>
        @endif
    </div>
@endsection
