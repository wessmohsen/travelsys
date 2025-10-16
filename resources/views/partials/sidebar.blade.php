<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <a href="{{ route('dashboard') }}" class="brand-link text-center">
    <span class="brand-text font-weight-bold">Sambo System</span>
  </a>

  <div class="sidebar-wrapper">
    <nav class="mt-2">
      {{-- 👇 لاحظ data-lte-toggle بدلاً من data-widget --}}
      <ul class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false">

        @foreach(config('modules') as $module)
          @if(isset($module['children']))
            @php
              $isActive = collect($module['children'])
                ->pluck('route')
                ->contains(fn($r) => request()->routeIs($r));
            @endphp

            <li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ $isActive ? 'active' : '' }}">
                <i class="nav-icon {{ $module['icon'] }}"></i>
                <p>
                  {{ $module['name'] }}
                  {{-- 👇 السهم لازم يحمل nav-arrow --}}
                  <i class="nav-arrow fas fa-angle-right"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                @foreach($module['children'] as $child)
                  <li class="nav-item">
                    <a href="{{ route($child['route']) }}"
                       class="nav-link {{ request()->routeIs($child['route']) ? 'active' : '' }}">
                      <i class="nav-icon {{ $child['icon'] }}"></i>
                      <p>{{ $child['name'] }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a href="{{ route($module['route']) }}"
                 class="nav-link {{ request()->routeIs($module['route']) ? 'active' : '' }}">
                <i class="nav-icon {{ $module['icon'] }}"></i>
                <p>{{ $module['name'] }}</p>
              </a>
            </li>
          @endif
        @endforeach

      </ul>
    </nav>
  </div>
</aside>
