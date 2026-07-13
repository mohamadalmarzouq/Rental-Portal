<div class="dropdown-header">Notifications</div>
@foreach($data as $value)
    @if(isset($value->module))
        <a href="{{ $value->identifier=="land_lord_approved"?"#":route($value->module.'.edit' , ['id' => $value->ref_id]) }}" class="dropdown-item">
            <div class="media">
                <div class="avatar avatar-sm avatar-{{ $value->read ? 'offline' : 'online' }}"><img src="{{ getUserAvatar($value->sender) }}" class="rounded-circle"
                                                                 alt=""></div>
                <div class="media-body mg-l-15">
                    {{ $value->makeNotificationBody($value) }}
                    <span>{{ $value->created_at->diffForHumans() }}</span>
                </div><!-- media-body -->
            </div><!-- media -->
        </a>
    @endif
@endforeach
@if(count($data))
    <div class="dropdown-footer"><a href="{{ route('notification.show') }}">View all
            Notifications</a></div>
@else
    <span>No Notifications</span>
@endif
