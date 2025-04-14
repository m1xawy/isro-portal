<header class="p-3 text-bg-dark">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{ url('/') }}" class="d-flex align-items-center me-3 mb-2 mb-lg-0 text-white text-decoration-none">
                @if (!empty(config('constants.general.options.logo')))
                    <img src="{{ asset(config('constants.general.options.logo')) }}" alt="" width="" height="40" class="">
                @else
                    <img src="{{ asset('images/bootstrap-logo-white.svg') }}" alt="" width="" height="40" class="">
                @endif
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="{{ url('/') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} px-2 text-white">{{ __('Home') }}</a></li>
                <li><a href="{{ route('pages.download') }}" class="nav-link {{ request()->routeIs('pages.download') ? 'active' : '' }} px-2 text-white">{{ __('Download') }}</a></li>
                <li><a href="{{ route('ranking') }}" class="nav-link {{ request()->routeIs('ranking') ? 'active' : '' }} px-2 text-white">{{ __('Ranking') }}</a></li>

                <li class="dropdown">
                    <a href="#" class="nav-link px-2 text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ __('Search') }}</a>
                    <ul class="dropdown-menu" style="">
                        <li><a class="dropdown-item" href="{{ route('pages.timers') }}">{{ __('Event Times') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.uniques') }}">{{ __('Unique Tracker') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.fortress') }}">{{ __('Fortress History') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.global') }}">{{ __('Global History') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link px-2 text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{ __('Pages') }}</a>
                    <ul class="dropdown-menu" style="">
                        @php $pages = Outl1ne\PageManager\Helpers\NPMHelpers::getPages(); @endphp
                        @if (!empty($pages) && count($pages) !== 0)
                            @foreach ($pages as $page)
                                <li><a class="dropdown-item" href="{{ '/page/' .$page['slug']['en'] }}">{{ $page['name']['en'] }}</a></li>
                            @endforeach
                        @else
                            <li><a class="dropdown-item" href="#">{{ __('No Pages') }}</a></li>
                        @endif
                    </ul>
                </li>
            </ul>

            <div class="d-flex text-end">
                <div class="dropdown d-none">
                    <a href="#" class="nav-link px-2 py-2 me-2 text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ language()->getName($code = 'default') }}
                    </a>
                    <ul class="dropdown-menu" style="">
                        @foreach (language()->allowed() as $code => $name)
                            <li><a class="dropdown-item" href="{{ language()->back($code) }}">{{ $name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                @if (Route::has('login'))
                    @auth
                        <div class="dropdown">
                            <a href="{{ route('profile') }}" class="d-block text-decoration-none dropdown-toggle px-2 text-white" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle"> {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">{{ __('Account') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Settings') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.donate') }}">{{ __('Donate') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.donate.history') }}">{{ __('Donate History') }}</a></li>
                                @if (Auth::user()->role == 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ url('/admin') }}">{{ __('Admin panel') }}</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">{{ __('Log Out') }}</a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-warning">{{ __('Register') }}</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</header>
