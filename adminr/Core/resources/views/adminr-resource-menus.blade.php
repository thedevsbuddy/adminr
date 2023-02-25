@foreach ($menus as $menu)
    <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ inRoutes(['adminr.'.strtolower($menu->adminrResource->name).'.index', 'adminr.'.strtolower($menu->adminrResource->name).'.create', 'adminr.'.strtolower($menu->adminrResource->name).'.edit'], 'c-active') }}"
                   href="{{ route('adminr.'.$menu->route) }}">
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
                            <use xlink:href="{{ adminrIcon('cil-folder') }}"></use>
                        </svg>
                    @endif
                    {{ ucfirst($menu->label) }}
                </a>
            </li>
@endforeach
