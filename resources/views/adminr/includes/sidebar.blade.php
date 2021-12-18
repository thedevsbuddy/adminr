{{--@if(request()->segment(2) != 'manage') c-sidebar-minimized @endif--}}
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show @if(activeRoute(config('app.route_prefix').'.builder')) c-sidebar-minimized @endif"
     id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <span class="c-sidebar-brand-full d-flex align-items-center">
            @if(!is_null(getSetting('app_logo')))
                <img src="{{ asset(getSetting('app_logo')) }}" class="mr-2 rounded"
                     style="max-height: 35px; width: auto" alt="">
            @endif
            <h4 class="m-0">{{ getSetting('app_name') }}</h4>
        </span>
        <span class="c-sidebar-brand-minimized">
            @if(!is_null(getSetting('app_logo')))
                <img src="{{ asset(getSetting('app_logo')) }}" class="rounded" style="max-height: 30px; width: auto"
                     alt="">
            @else
                {{ config('app.shortname') }}
            @endif
            </span>
    </div>
    <ul class="c-sidebar-nav ps ps--active-y">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ coreUiIcon('cil-speedometer') }}"></use>
                </svg>
                {{ __('Dashboard') }}
            </a>
        </li>
        @can('create_crud')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.builder') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-diamond') }}"></use>
                    </svg>
                    {{ __('Builder') }}
                </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.resources.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-apps') }}"></use>
                    </svg>
                    {{ __('Generated Resources') }}
                </a>
            </li>
        @endcan
        @can('manage_menus')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.settings.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-menu') }}"></use>
                    </svg>
                    {{ __('Menu Composer') }}
                </a>
            </li>
        @endcan
        @can('manage_settings')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.settings.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-settings') }}"></use>
                    </svg>
                    {{ __('Settings') }}
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-title">Permissible</li>
        @can('manage_permissions')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="javascript:void(0)" onclick="alert('Coming soon!')">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-star') }}"></use>
                    </svg>
                    {{ __('Roles & Permissions') }}
                </a>
            </li>
        @endcan
        @can('manage_users')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ returnIfRoutes([config('app.route_prefix').'.users.index', config('app.route_prefix').'.users.create', config('app.route_prefix').'.users.edit'], 'c-active') }}"
                   href="{{ route(config('app.route_prefix').'.users.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-user') }}"></use>
                    </svg>
                    {{ __('Users') }}
                </a>
            </li>
        @endcan

        <li class="c-sidebar-nav-title">Resources</li>
        @if(isset($resourceMenus) && count($resourceMenus) > 0)
            @foreach($resourceMenus as $menu)
                @can(strtolower($menu->resource) . '_show_list')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link {{ returnIfRoutes([config('app.route_prefix').'.'.strtolower($menu->resource).'.index', config('app.route_prefix').'.'.strtolower($menu->resource).'.create', config('app.route_prefix').'.'.strtolower($menu->resource).'.edit'], 'c-active') }}"
                           href="{{ route(config('app.route_prefix').'.'.$menu->route) }}">
                            @if($menu->icon_type == 'svg')
                                <span class="c-sidebar-nav-icon">
                                    {!! $menu->icon !!}
                                </span>
                            @elseif($menu->icon_type == 'image')
                                <span class="c-sidebar-nav-icon">
                                    <img src="{{ asset($menu->icon) }}" alt="">
                                </span>
                            @elseif($menu->icon_type == 'icon')
                                <span class="c-sidebar-nav-icon">
                                    <i class="{{ $menu->icon }}"></i>
                                </span>
                            @else
                                <svg class="c-sidebar-nav-icon">
                                    <use xlink:href="{{ coreUiIcon('cil-folder') }}"></use>
                                </svg>
                            @endif
                            {{ ucfirst($menu->label) }}
                        </a>
                    </li>
                @endcan
            @endforeach
        @else
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link"
                   href="{{ route(config('app.route_prefix').'.builder') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-plus') }}"></use>
                    </svg>
                    {{ __('Add new') }}
                </a>
            </li>
        @endif

        {{--        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">--}}
        {{--            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">--}}
        {{--                <svg class="c-sidebar-nav-icon">--}}
        {{--                    <use xlink:href="{{ coreUiIcon('cil-puzzle') }}"></use>--}}
        {{--                </svg>--}}
        {{--                Base--}}
        {{--            </a>--}}
        {{--            <ul class="c-sidebar-nav-dropdown-items">--}}
        {{--                <li class="c-sidebar-nav-item">--}}
        {{--                    <a class="c-sidebar-nav-link" href="base/breadcrumb.html">--}}
        {{--                        <svg class="c-sidebar-nav-icon">--}}
        {{--                            <use xlink:href="{{ coreUiIcon('cil-puzzle') }}"></use>--}}
        {{--                        </svg>--}}
        {{--                        Breadcrumb--}}
        {{--                    </a>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}

    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>