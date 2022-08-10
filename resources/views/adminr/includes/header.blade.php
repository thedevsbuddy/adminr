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
		@can('manage_resources')
			@if(Adminr::isInDev())
				<li class="c-header-nav-item">
					<a class="c-header-nav-link" href="{{ route(config('adminr.route_prefix').'.builder') }}" data-toggle="tooltip" title="{{ __('Resource Builder') }}">
						<svg style="width: 20px; height: 20px">
							<use xlink:href="{{ coreUiIcon('cil-diamond') }}"></use>
						</svg>
						<span class="ml-2">{{ __('Builder') }}</span>
					</a>
				</li>
				<li class="c-header-nav-item">
					<a class="c-header-nav-link" href="{{ route(config('adminr.route_prefix').'.resources.index') }}" data-toggle="tooltip" title="{{ __('Generated Resources') }}">
						<svg style="width: 20px; height: 20px">
							<use xlink:href="{{ coreUiIcon('cil-apps') }}"></use>
						</svg>
						<span class="ml-2">{{ __('Generated Resources') }}</span>
					</a>
				</li>
			@endif

		@endcan

			@can('manage_settings')
				<li class="c-header-nav-item dropdown">
					<a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<i class="mdi mdi-cog-outline font-xl"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right pt-0">
						<div class="dropdown-header bg-light py-2"><strong>Configurations</strong></div>
						@can('manage_mail_templates')
							<x-link class="dropdown-item" href="{{ route(config('adminr.route_prefix').'.templates.index') }}">
								{{ __('Email Templates') }}
							</x-link>
						@endcan
						<x-link class="dropdown-item" href="{{ route(config('adminr.route_prefix').'.settings.general') }}">
							{{ __('General') }}
						</x-link>
						<x-link class="dropdown-item" href="{{ route(config('adminr.route_prefix').'.settings.email') }}">
							{{ __('Email') }}
						</x-link>
						<x-link class="dropdown-item" href="{{ route(config('adminr.route_prefix').'.settings.features') }}">
							{{ __('Features') }}
						</x-link>
					</div>
				</li>
			@endcan
			<li class="c-header-nav-item dropdown">
				<a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<div class="c-avatar">
						<img class="c-avatar-img" src="{{ asset(auth()->user()->avatar ) }}" alt="user@email.com">
					</div>
				</a>
				<div class="dropdown-menu dropdown-menu-right pt-0">
					<div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
					<a class="dropdown-item" href="#">
						<x-cicon name="bell" class="c-icon mr-2"/>
						Profile <span class="badge badge-info ml-auto">42</span>
					</a>
					<div class="dropdown-divider"></div>
					<x-link class="dropdown-item" href="{{ route('auth.logout') }}" as="form" method="POST">
						<x-cicon name="account-logout" class="c-icon mr-2"/>
						{{ __('Logout') }}
					</x-link>
				</div>
			</li>
	</ul>

</header>
