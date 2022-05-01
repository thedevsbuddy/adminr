@if(isset($resourceMenus) && count($resourceMenus) > 0)
    @foreach($resourceMenus as $menu)
        @can(strtolower($menu->adminrResource->name) . '_list')
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ returnIfRoutes([config('app.route_prefix').'.'.strtolower($menu->adminrResource->name).'.index', config('app.route_prefix').'.'.strtolower($menu->adminrResource->name).'.create', config('app.route_prefix').'.'.strtolower($menu->adminrResource->name).'.edit'], 'c-active') }}"
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
    @can('manage_resources')
        @if(config('app.env') == 'local')
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
    @endcan
@endif
