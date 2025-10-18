<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div>
        <img src="https://sambodivers.com/wp-content/uploads/2025/10/for-dark-bg.png" alt="Sambo System Logo" class="my-3" style="max-width: 150px; display: block; margin-left: auto; margin-right: auto;">
        <div align="center"><a href="{{ route('dashboard') }}" class="brand-link text-center" style="text-decoration: none;font-size: 1.2rem;font-weight: bold;">
            <span class="brand-text font-weight-bold" style="color: #fff;">Sambo System</span>
        </a></div>
    </div>


  <div class="sidebar-wrapper">
    <nav class="mt-2">
      {{-- 👇 لاحظ data-lte-toggle بدلاً من data-widget --}}
      <ul class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false">

        @foreach(config('modules') as $module)
          @php
            // Check if user has required role
            $hasAccess = !isset($module['roles']) || auth()->user()->hasAnyRole(...$module['roles']);
          @endphp

          @if($hasAccess)
            @if(isset($module['children']))
              @php
                $isActive = collect($module['children'])
                  ->pluck('route')
                  ->contains(fn($r) => request()->routeIs($r));

                // Filter children based on role access
                $accessibleChildren = collect($module['children'])->filter(function($child) {
                  return !isset($child['roles']) || auth()->user()->hasAnyRole(...$child['roles']);
                });
              @endphp

              @if($accessibleChildren->isNotEmpty())
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
                    @foreach($accessibleChildren as $child)
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
              @endif
            @else
              <li class="nav-item">
                <a href="{{ route($module['route']) }}"
                   class="nav-link {{ request()->routeIs($module['route']) ? 'active' : '' }}">
                  <i class="nav-icon {{ $module['icon'] }}"></i>
                  <p>{{ $module['name'] }}</p>
                </a>
              </li>
            @endif
          @endif
        @endforeach

      </ul>
    </nav>
  </div>
</aside>
