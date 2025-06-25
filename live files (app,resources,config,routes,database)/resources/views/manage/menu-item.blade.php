@foreach ($menuItems as $menu)
    @if ($menu->children->isEmpty())
        <li data-url="{{ route($menu->menu_url) }}" class="sidebar-item">
            <a href="javascript:void(0)">
                <i class="{{ $menu->icon }}"></i> {{ $menu->menu_name }}
            </a>
        </li>
    @else
    <li class="nav-item">
        <a href="javascript:void(0)" data-bs-toggle="collapse" class="nav-link menu-link collapsed p-0"
            data-bs-target="#dropdown-{{ $menu->id }}" role="button" aria-expanded="false" aria-controls="dropdown-{{ $menu->id }}">
            <i class="{{ $menu->icon }}"></i> {{ $menu->menu_name }}
        </a>
        <div class="menu-dropdown collapse" id="dropdown-{{ $menu->id }}">
            <ul class="nav nav-sm flex-column">
                @include('manage.menu-item', ['menuItems' => $menu->children])
            </ul>
        </div>
    </li>
    @endif
@endforeach
