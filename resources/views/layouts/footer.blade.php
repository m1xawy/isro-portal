<!-- FOOTER -->
<div class="container">
    <footer class="row py-5 my-5 border-top">
        <div class="col-md-6 mb-3">
            <a href="{{ url('/') }}" class="d-flex align-items-center me-3 mb-2 mb-lg-0 text-white text-decoration-none" aria-label="Bootstrap">
                @if (!empty(config('constants.general.options.logo')))
                    <img src="{{ asset(config('constants.general.options.logo')) }}" alt="" width="" height="40" class="">
                @else
                    <img src="{{ asset('images/bootstrap-logo.svg') }}" alt="" width="" height="40" class="">
                @endif
            </a>
            <p class="text-body-secondary mb-0">© 2025 <a href="{{ config('constants.general.options.server_url') }}">{{ config('constants.general.options.server_name') }}</a>, Inc - All Rights Reserved.</p>
            <p class="text-body-secondary">Coded by <a class="link-default" href="https://github.com/m1xawy" target="_blank">m1xawy</a></p>
        </div>

        <div class="col-md-2 mb-3">
            <h5>General</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Privacy Policy</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Terms & Conditions</a></li>
            </ul>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Social Media</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Facebook</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Discord</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Youtube</a></li>
            </ul>
        </div>

        <div class="col-md-2 mb-3">
            <h5>Backlink</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Elitepvpers</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Silkroad4arab</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">SroCave</a></li>
            </ul>
        </div>
    </footer>
</div>
