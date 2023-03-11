@if(isset($resources) && count($resources) > 0)
    @foreach($resources as $resource)
        @can(strtolower($resource->plural) . '_index')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ inRoutes(['adminr.'.strtolower($resource->plural).'.index', 'adminr.'.strtolower($resource->plural).'.create', 'adminr.'.strtolower($resource->plural).'.edit'], 'c-active') }}"
                   href="{{ route('adminr.'.$resource->menu->route) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ adminrIcon('cil-folder') }}"></use>
                        </svg>
                    {{ ucfirst($resource->menu->label) }}
                </a>
            </li>
        @endcan
    @endforeach
@endif
@can('manage_resources')
    @if(config('app.env') == 'local')
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link"
               href="{{ route('adminr.builder') }}">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ adminrIcon('cil-plus') }}"></use>
                </svg>
                {{ __('Add new') }}
            </a>
        </li>
    @endif
@endcan
