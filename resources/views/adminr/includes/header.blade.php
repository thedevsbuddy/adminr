<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
            <span class="c-icon  c-icon-lg">
                <i class="mdi mdi-menu"></i>
            </span>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
        <span>{{ config('app.name') }}</span>
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true">
        <span class="c-icon  c-icon-lg">
                <i class="mdi mdi-menu"></i>
            </span>
    </button>
{{--    <ul class="c-header-nav d-md-down-none">--}}
{{--        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>--}}
{{--        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>--}}
{{--        <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>--}}
{{--    </ul>--}}
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item d-md-down-none mx-2"><a class="c-header-nav-link" href="#">
                <svg class="c-icon">
                    <use xlink:href="{{ coreUiIcon('cil-cog') }}"></use>
                </svg>
            </a>
        </li>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{ asset(auth()->user()->avatar ) }}" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                <a class="dropdown-item" href="#">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{ coreUiIcon('cil-bell') }}"></use>
                    </svg>
                    Updates<span class="badge badge-info ml-auto">42</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{coreUiIcon('cil-account-logout') }}"></use>
                    </svg>
                    {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

</header>