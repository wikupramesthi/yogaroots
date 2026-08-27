    <!-- Sidebar-->
    <div id="sidebar">
      <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
          <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
              <a href="{{ route('dashboard.index') }}">
                <img id="logo-light" src="{{ asset('img/logo-slb.png') }}" alt="Logo" class="d-block" />
                <img id="logo-dark" src="{{ asset('img/logo-slb.png') }}" alt="Logo" class="d-none" />
              </a>
            </div>

            <div class="sidebar-toggler x">
              <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
          </div>
        </div>

        <div class="sidebar-menu">

          <ul class="menu">
            <li class="sidebar-title">Main Menu</li>
            <li class="sidebar-item ">
              <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                <i class="bx bx-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
            @foreach ($menus as $menu)
            @can($menu->permission_name)
            @php
            // Determine if any of the submenu items are active
            $isActive = false;
            foreach ($menu->items as $item) {
            if (request()->routeIs($item->route)) {
            $isActive = true;
            break;
            }
            }
            @endphp

            <li class="sidebar-item has-sub {{ $isActive ? 'active' : '' }} ">
              <a href="#" class='sidebar-link'>
                <i class="bx {{ $menu->icon }}"></i>
                <span>{{ $menu->name }}</span>
              </a>

              <ul class="submenu">
                @foreach ($menu->items as $item)
                @can($item->permission_name)
                <li class="submenu-item {{ request()->routeIs($item->route) ? 'active' : '' }} ">
                  <a href="{{ route($item->route) }}" class="submenu-link">
                    {{ $item->name }}</a>
                </li>
                @endcan
                @endforeach
              </ul>
            </li>

            <!-- end foreach items -->
            @endcan
            <!-- end can menu -->
            @endforeach
            @if (Auth::check())
            @can('admin')
            <li class="sidebar-title">
              <a class="dropdown-item" href="#"
                target="_blank" title="User Guide">
                Panduan <i class="icon-mid bi bi-info-circle me-2"></i></a>
            </li>
            @endcan
 
            <li class="sidebar-item  ">
              <a class='sidebar-link' href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-arrow-bar-left"></i>
                <span>Logout</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </a>
            </li>
            @endif

          </ul>
        </div>

      </div>
    </div>