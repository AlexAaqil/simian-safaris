<nav x-data="{ open:false }" @click.outside="open = false" class="guest_nav relative">
    <div class="container">
        <div class="branding">
            <a href="/" wire:navigate>
                <x-app-logo width="50" height="50" />
                {{ config('app.name') }}
            </a>
        </div>

        <div class="burger_menu" @click="open = !open">
            <span :class="open ? 'rotate-45 translate-y-1.5' : ''"></span>
            <span :class="open ? 'opacity-0' : ''"></span>
            <span :class="open ? '-rotate-45 -translate-y-1.5' : ''"></span>
        </div>

        <div class="nav_links" :class="{ 'open' : open }">
            <div class="main_links">
                @auth
                    <a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}" wire:navigate>Dashboard</a>
                @endif

                <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}" class="{{ Route::is('home-page') ? 'active' : '' }}" wire:navigate>Home</a>
                <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}" class="{{ Route::is('about-page') ? 'active' : '' }}" wire:navigate>About</a>

                <!-- Tours Dropdown -->
                <div
                    x-data="{ open: false }"
                    @mouseenter.window="if (window.innerWidth >= 768) open = true"
                    @mouseleave.window="if (window.innerWidth >= 768) open = false"
                    class="relative"
                >
                    <!-- Wrapper around Tours text and chevron (for hover and focus/tap) -->
                    @php
                        $isToursPage = Route::is('tours-page') || Route::is('categorized-tours-page');
                    @endphp
                    <button
                        type="button"
                        @click="open = !open"
                        class="inline-flex items-center text-base text-gray-800 hover:text-primary transition-colors mt-0"
                        :class="{ 'active': open }"
                    >
                        <span>Safaris </span>
                        <svg class="ml-1 w-4 h-4 transform transition-transform duration-200" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        @click.outside="open = false"
                        class="absolute left-0 mt-2 w-56 md:w-64 bg-white shadow-xl rounded-lg z-50 py-4 px-4 flex flex-col space-y-4 lg:space-y-6 border border-gray-200"
                        style="display: none;"
                    >
                        <!-- Optional: Link to all tours -->
                        <a
                            href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}"
                            wire:navigate
                            class="block text-sm lg:text-base text-gray-800 hover:text-primary hover:underline"
                        >
                            All Safaris
                        </a>

                        <!-- Categories -->
                        @foreach ($tour_categories as $category)
                            <a
                                href="{{ route('categorized-tours-page', ['category' => $category->slug]) }}"
                                wire:navigate
                                class="block text-sm lg:text-base text-gray-800 hover:text-primary hover:underline"
                            >
                                {{ Str::title($category->title) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ Route::has('destinations-page') ? route('destinations-page') : '#' }}" class="{{ Route::is('destinations-page') ? 'active' : '' }}" wire:navigate>Destinations</a>
                <a href="{{ Route::has('gallery-page') ? route('gallery-page') : '#' }}" class="{{ Route::is('gallery-page') ? 'active' : '' }}" wire:navigate>Gallery</a>
                <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}" class="{{ Route::is('contact-page') ? 'active' : '' }}" wire:navigate>Contact</a>
            </div>

            <div class="other_links">
                @auth
                    <button wire:click="logout" class="btn btn_danger">Logout</button>
                @else
                    <a href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}">Plan Your Trip</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
