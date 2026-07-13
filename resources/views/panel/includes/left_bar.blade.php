<div class="side_bar">
    <div class="user_detail">
        <div class="avatar avatar-xxl avatar-online">
            <img src="{{ getUserAvatar(Auth()->user()->id) }}" class="rounded-circle" alt="">
        </div>
        <div>
            <h5 class="mg-b-2 tx-spacing--1 mt-3">{{ Auth()->user()->name }}</h5>
            <p class="tx-color-03 mg-b-25">{{ Auth()->user()->role->name }}</p>
        </div>
    </div>
    <div class="social_links">
        <nav class="nav nav-classic tx-13">
            <ul class="p-0">
                @foreach($modules as $module)
                    @if(!empty($module['children']) || hasRole($module['slug'] , 'is_visible') || ($module['route_name'] == 'home') && !checkInMultiDeminsionalArray(Auth()->user()->excludeDashboardRoleIds() , 'role_id' ,Auth()->user()->role_id ))
                        <li class="mt-2 mb-3 {{ !empty($module['children']) ? 'dropdown side_bar_dropdown' : '' }}
                        {{ checkInMultiDeminsionalArray($module['children'], 'route_name' , $current_route_name) ? 'active' : '' }}">
                            <a class="nav-link {{ $current_route_name == $module['route_name'] ? 'active' : '' }} {{ !empty($module['children']) ? 'set_dropdown_icon position-relative dropdown-toggle' : '' }}"
                               href="{{ $module['route_name'] == '#' ? '#' : route($module['route_name']) }}"
                               data-toggle="{{ !empty($module['children']) ? 'dropdown' : '' }}">
                                <i class="{{ $module['icon'] }}"></i> &nbsp;
                                {{ $module['title'] }}
                            </a>
                            @if(!empty($module['children']))
                                <div
                                    class="dropdown-menu {{ checkInMultiDeminsionalArray($module['children'], 'route_name' , $current_route_name) ? 'show' : '' }}">
                                    @foreach($module['children'] as $children)
                                        @if(hasRole($children['slug'] , 'is_visible'))
                                            <a class="dropdown-item {{ $current_route_name == $children['route_name'] ? 'active' : '' }}"
                                               href="{{ route($children['route_name']) }}">{{ $children['title'] }}</a>
                                        @endif
                                    @endforeach
                                    <a class="dropdown-item"
                                       href="#" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">Sign Out</a>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">{{ csrf_field() }}</form>
    </div>
</div>
