<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMenuLabel">iSRO CMS</h5>
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
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#cart"/></svg>
                    Download
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#people"/></svg>
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#graph-up"/></svg>
                    Pages
                </a>
            </li>
        </ul>

        <hr class="my-3">

        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#gear-wide-connected"/></svg>
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2" href="#">
                    <svg class="bi" aria-hidden="true"><use xlink:href="#door-closed"/></svg>
                    Sign out
                </a>
            </li>
        </ul>
    </div>
</div>
