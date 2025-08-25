<footer>
    <div class="container">
        <div class="content">
            <div class="branding">
                {{-- <div class="logo">
                    <x-app-logo />
                </div> --}}

                <h3>{{ config('app.name') }}</h3>
                <p>{{ config('app.slogan') }}</p>
                <div class="info">
                    <p class="location">
                        {!! config('app.address') !!}
                    </p>
                </div>

                <div class="image">
                    <img src="{{ asset('assets/images/payment-methods.png') }}" alt="Payment Methods Accepted" loading="lazy">
                </div>
            </div>

            <div class="quick_links">
                <h3>Quick Links</h3>
                <div class="links">
                    <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}" wire:navigate>Home</a>
                    <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}" wire:navigate>About</a>
                    <a href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}" wire:navigate>Tours</a>
                    <a href="{{ Route::has('destinations-page') ? route('destinations-page') : '#' }}" wire:navigate>Destinations</a>
                    <a href="{{ Route::has('contact-page') ? route('about-page') : '#' }}" wire:navigate>Contact</a>
                </div>
            </div>

            <div class="packages">
                <h3>Safaris</h3>
                <div class="links">
                    @foreach ($categories as $category)
                        <a href="{{ Route::has('categorized-tours-page') ? route('categorized-tours-page', $category->slug) : '#' }}">{{ Str::title($category->title) }}</a>
                    @endforeach
                </div>
            </div>

            <div class="connect">
                <h3>Connect With Us</h3>
                <p>Follow us for updates and insights</p>
                <div class="socials">
                    <a href="{{ config('app.instagram') }}" target="_blank" rel="noopener noreferrer">
                        <x-svgs.instagram />
                    </a>
                    <a href="{{ config('app.facebook') }}" target="_blank" rel="noopener noreferrer">
                        <x-svgs.facebook />
                    </a>
                    <a href="{{ config('app.linkedin') }}" target="_blank" rel="noopener noreferrer">
                        <x-svgs.linkedin />
                    </a>
                    <a href="{{ config('app.whatsapp') }}" target="_blank" rel="noopener noreferrer">
                        <x-svgs.whatsapp />
                    </a>
                    {{-- <a href="{{ config('app.tiktok') }}" target="_blank" rel="noopener noreferrer">
                        <x-svgs.tiktok />
                    </a> --}}
                </div>

                <div class="contacts">
                    <p>
                        <span>{{ config('app.phone_number') }}</span>
                        <span>{{ config('app.secondary_phone_number') }}</span>
                    </p>
                    <p>
                        <span>{{ config('app.email') }}</span>
                        <span>{{ config('app.other_email') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="copyrights">
            <p class="text">&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            <p class="text">Powered by: <a href="#">Pentach Tech</a></p>
        </div>
    </div>
</footer>
