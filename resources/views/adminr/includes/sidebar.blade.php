{{--@if(request()->segment(2) != 'manage') c-sidebar-minimized @endif--}}
<div
    class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show @if(activeRoute(config('app.route_prefix').'.builder')) c-sidebar-minimized @endif"
    id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <span class="c-sidebar-brand-full d-flex align-items-center">
            @if(!is_null(getSetting('app_logo')))
                <img src="{{ asset(getSetting('app_logo')) }}" class="mr-2 rounded"
                     style="max-height: 35px; width: auto" alt="">
            @else
                <h4 class="m-0">{{ getSetting('app_name') }}</h4>
            @endif

        </span>
        <span class="c-sidebar-brand-minimized">
            @if(!is_null(getSetting('app_logo')))
                <img src="{{ asset(getSetting('app_logo')) }}" class="rounded" style="max-height: 30px; width: auto"
                     alt="">
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
        @include('adminr.includes.sidebar-menu')

        <li class="c-sidebar-nav-title">Permissible</li>
        @can('manage_permissions')
            @if(config('app.env') == 'local')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link"
                       href="{{ route(config('app.route_prefix').'.roles-and-permissions.index') }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ coreUiIcon('cil-star') }}"></use>
                        </svg>
                        {{ __('Roles & Permissions') }}
                    </a>
                </li>
            @endif
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
        <li class="c-sidebar-nav-title">Configurations</li>
        @can('manage_mail_templates')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.templates.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-pen') }}"></use>
                    </svg>
                    {{ __('Email Templates') }}
                </a>
            </li>
        @endcan
        @can('manage_settings')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:void(0)">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-settings') }}"></use>
                    </svg>
                    {{ __('Settings') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link"
                           href="{{ route(config('app.route_prefix').'.settings.general') }}">
                            General
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.settings.email') }}">
                            Email
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link"
                           href="{{ route(config('app.route_prefix').'.settings.features') }}">
                            Features
                        </a>
                    </li>
                </ul>
            </li>
            {{--            <li class="c-sidebar-nav-item">--}}
            {{--                <a class="c-sidebar-nav-link" href="{{ route(config('app.route_prefix').'.settings.index') }}">--}}
            {{--                    <svg class="c-sidebar-nav-icon">--}}
            {{--                        <use xlink:href="{{ coreUiIcon('cil-settings') }}"></use>--}}
            {{--                    </svg>--}}
            {{--                    {{ __('Settings') }}--}}
            {{--                </a>--}}
            {{--            </li>--}}
        @endcan
        <li class="c-sidebar-nav-title">Resources</li>
        @include('adminr.includes.sidebar-resources-menu')


    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
