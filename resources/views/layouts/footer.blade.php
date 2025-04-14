<!-- FOOTER -->
<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-body-secondary">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Privacy Policy</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Terms & Conditions</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>

            @php $backlinks = json_decode(setting('backlinks'));@endphp
            @if (!empty($backlinks))
                @foreach($backlinks as $backlink)
                    <li class="nav-item">
                        <a href="{{ $backlink->attributes->backlink_url }}" class="nav-link px-2 text-body-secondary">
                            @if (isset($backlink->attributes->backlink_icon))
                                <img class="d-inline-block" src="{{ $backlink->attributes->backlink_icon }}" alt="">
                            @endif
                            {{ $backlink->attributes->backlink_name }}
                        </a>
                    </li>
                @endforeach
            @else
            @endif
        </ul>
        <p class="text-center text-body-secondary">© 2025 <a href="{{ setting('server_url', config('app.url')) }}">{{ setting('server_name', config('app.name', 'Silkroad Online')) }}</a>, Inc - All Rights Reserved.</p>
        <p class="text-center text-body-secondary">Coded by <a class="link-default" href="https://mix-shop.tech/" target="_blank">m1xawy</a></p>
    </footer>
</div>
