<header class="navbar navbar-header w-100 px-4">
    <div class="container-fluid">
        <div class="row w-100 flex-fill">
            <div class="d-flex w-100 pt-3 pb-3">
                <a href="" id="mainMenuOpen" class="burger-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>
                <div class="navbar-brand p-0">
                    <a href="{{ route('home') }}" class="df-logo"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
                </div>

                <div id="navbarMenu" class="navbar-menu-wrapper">
                    <ul class="nav navbar-menu">
                        <li class="nav-item with-sub m-auto">
                            <div class="search-form search_box mg-t-20 mg-sm-t-0">
                                {{--<button id="addInputClass" class="btn border-0" type="button" onclick="search()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </button>
                                <input type="search" id="global_search" class="form-control border-0 pl-1 clickInput"
                                       placeholder="Search">
                                <div id="search_results" style="display: none"></div>--}}
                            </div>
                        </li>
                    </ul>
                </div>
                @include('panel.includes.view_modal')
                <div class="navbar-right">
                    <div class="dropdown dropdown-notification">
                        <a href="" class="dropdown-link new-indicator" data-toggle="dropdown"
                           onclick="getNotifications(4)">
                            <img class="notification_ic" src="{{ asset('assets/img/notification_ic.png') }}">

                        </a>
                        <div class="dropdown-menu dropdown-menu-right be-notifications added_border_top">
                        </div>
                    </div>
{{--                    <div class="dropdown dropdown-notification">--}}
{{--                        <a href="" class="dropdown-link new-indicator" data-toggle="dropdown"--}}
{{--                           onclick="getNotifications(4)">--}}
{{--                            <img class="notification_ic" src="{{ asset('assets/img/messege_ic.png') }}">--}}

{{--                        </a>--}}
{{--                        <div class="dropdown-menu dropdown-menu-right be-notifications added_border_top">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="dropdown dropdown-notification">
                        <a href="" class="dropdown-link  set_dropdown_icon position-relative" data-toggle="dropdown">
                            <img class="notification_ic" src="{{ asset('assets/img/setting_ic.png') }}">
                        </a>

                        @if(!empty($settings['children']))
                            <div class="dropdown-menu dropdown-menu-right added_border_top ">
                                @foreach($settings['children'] as $children)
                                    @if(hasRole($children['slug'] , 'is_visible'))
                                        <a class="dropdown-item {{ $current_route_name == $children['route_name'] ? 'active' : '' }}"
                                           href="{{ route($children['route_name']) }}">{{ t('nav.' . $children['slug'], $children['title']) }}</a>
                                    @endif
                                @endforeach
                                <a class="dropdown-item"
                                   href="#" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">{{ t('nav.sign_out') }}</a>
                            </div>
                        @endif
                    </div>
                    <div class="user_detail d-flex align-items-center">
                        <div class="avatar avatar-xxl avatar-online  ml-3 mr-2">
                            <img class="notification_ic" src="{{ getUserAvatar(auth()->user()->id) }}"
                                 class="rounded-circle" alt="">
                        </div>
                        <div>
                            <h6 class="m-0">{{ auth()->user()->name }}</h6>
                            <span class="">{{ tn(auth()->user()->role->name) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navWrap social_links d-flex justify-content-center w-100 p-3">
                <nav class="nav nav-classic tx-13">
                    <ul class="p-0 m-0 d-md-flex">
                        @foreach($modules as $module)
                            @if(!empty($module['children']) || hasRole($module['slug'] , 'is_visible') || ($module['route_name'] == 'home') && !checkInMultiDeminsionalArray(Auth()->user()->excludeDashboardRoleIds() , 'role_id' ,Auth()->user()->role_id ))
                                <li class=" {{ !empty($module['children']) ? 'dropdown side_bar_dropdown' : '' }}
                                {{ checkInMultiDeminsionalArray($module['children'], 'route_name' , $current_route_name) ? 'active' : '' }}">
                                    <a class="nav-link {{ $current_route_name == $module['route_name'] ? 'active' : '' }} {{ !empty($module['children']) ? 'set_dropdown_icon position-relative dropdown-toggle' : '' }}"
                                       href="{{ $module['route_name'] == '#' ? '#' : route($module['route_name']) }}"
                                       data-toggle="{{ !empty($module['children']) ? 'dropdown' : '' }}">
                                        <i class="{{ $module['icon'] }}"></i> &nbsp;
                                        {{ t('nav.' . $module['slug'], $module['title']) }}
                                    </a>
                                    @if(!empty($module['children']))
                                        <div
                                            class="dropdown-menu {{ checkInMultiDeminsionalArray($module['children'], 'route_name' , $current_route_name) ? 'show' : '' }}">
                                            @foreach($module['children'] as $children)
                                                @if(hasRole($children['slug'] , 'is_visible'))
                                                    <a class="dropdown-item {{ $current_route_name == $children['route_name'] ? 'active' : '' }}"
                                                       href="{{ route($children['route_name']) }}">{{ t('nav.' . $children['slug'], $children['title']) }}</a>
                                                @endif
                                            @endforeach
                                            <a class="dropdown-item"
                                               href="#" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">{{ t('nav.sign_out') }}</a>
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
    </div>
</header>

