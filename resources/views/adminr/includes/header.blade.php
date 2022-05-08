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
    <a href="{{ route('index') }}" target="_blank" class="d-flex align-items-center justify-content-center c-header-toggler  d-md-down-none">
            <span class="c-icon c-icon-lg" style="margin-top: -12px">
                <i class="mdi mdi-home-outline"></i>
            </span>
    </a>
    <ul class="c-header-nav ml-auto mr-4">
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{ asset(auth()->user()->avatar ) }}" alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                <a class="dropdown-item" href="#">
                    <x-cicon name="bell" class="c-icon mr-2" />
                    Profile <span class="badge badge-info ml-auto">42</span>
                </a>
                <div class="dropdown-divider"></div>
                <x-link class="dropdown-item" href="{{ route('auth.logout') }}" as="form" method="POST">
                    <x-cicon name="account-logout" class="c-icon mr-2" />
                    {{ __('Logout') }}
                </x-link>
            </div>
        </li>
    </ul>

</header>
