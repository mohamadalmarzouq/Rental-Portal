@if(hasRole($url_column['route_name'],'show') && $url_column['route_name'] != 'roles')
    <a href='{{ url($url_column['route_name']).'-view/'.$id}}'>{{ $text }}</a>
@else
    <span>{{ $text }}</span>
@endif
