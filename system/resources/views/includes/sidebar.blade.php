<div
    class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show @if(activeRoute('adminr.builder')) c-sidebar-minimized @endif"
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
            <a class="c-sidebar-nav-link" href="{{ route('adminr.index') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ coreUiIcon('cil-speedometer') }}"></use>
                </svg>
                {{ __('Dashboard') }}
            </a>
        </li>
        <li class="c-sidebar-nav-title">Resources</li>
        @include('adminr::includes.sidebar-resources-menu')
        <li class="c-sidebar-nav-title">Permissible</li>
        @can('manage_permissions')
            @if(Adminr::inDev())
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link"
                       href="{{ route('adminr.roles-and-permissions.index') }}">
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
                <a class="c-sidebar-nav-link {{ inRoutes(['adminr.users.index', 'adminr.users.create', 'adminr.users.edit'], 'c-active') }}"
                   href="{{ route('adminr.users.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ coreUiIcon('cil-user') }}"></use>
                    </svg>
                    {{ __('Users') }}
                </a>
            </li>
        @endcan
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
