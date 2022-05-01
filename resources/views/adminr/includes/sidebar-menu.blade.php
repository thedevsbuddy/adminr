@can('manage_resources')
    @if(config('app.env') == 'local')
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
    @endif
@endcan
