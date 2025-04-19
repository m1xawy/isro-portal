<div class="offcanvas-md offcanvas-end bg-body-tertiary h-100" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ config('settings.site_title') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.home') ? 'active' : '' }}" aria-current="page" href="{{ route('admin.home') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#house-fill"/></svg>
                    {{ __('Dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.news.index') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#file-earmark"/></svg>
                    {{ __('News') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.download.index') ? 'active' : '' }}" href="{{ route('admin.download.index') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#cart"/></svg>
                    {{ __('Download') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#people"/></svg>
                    {{ __('Users') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.pages.index') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#graph-up"/></svg>
                    {{ __('Pages') }}
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#gear-wide-connected"/></svg>
                    {{ __('Settings') }}
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to Sign out?')" onclick="event.preventDefault();this.closest('form').submit();">
                        <svg class="bi" aria-hidden="true"><use xlink:href="#door-closed"/></svg>
                        {{ __('Log Out') }}
                    </a>
                </form>
            </li>
        </ul>
    </div>
</div>
