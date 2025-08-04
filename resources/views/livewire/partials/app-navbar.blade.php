<nav class="app_navbar">
    <div class="nav_container">
        <div class="branding">
            <a href="/" wire:navigate>
                <x-app-logo width="100" height="100" />
            </a>
        </div>

        <div class="nav_links">
            <div class="main_links">
                @php
                    use App\Enums\USER_ROLES;

                    $user = auth()->user();

                    $nav_items = [
                        [
                            'route' => 'dashboard',
                            'label' => 'Dashboard',
                            'wire_navigate' => false, // explicitly no wire:navigate
                        ],
                        [
                            'route' => 'users.index',
                            'label' => 'Users',
                            'can' => $user && $user->isAdmin(),
                            'wire_navigate' => true,
                        ],
                        [
                            'route' => 'tours.index',
                            'label' => 'Tours',
                            'wire_navigate' => true,
                        ],
                        [
                            'route' => 'bookings.index',
                            'label' => 'Bookings',
                            'wire_navigate' => true,
                        ],
                        [
                            'route' => 'gallery.index',
                            'label' => 'Gallery',
                            'wire_navigate' => true,
                        ],
                        [
                            'route' => 'contact-messages.index',
                            'label' => 'Messages',
                            'wire_navigate' => true,
                        ],
                    ];
                @endphp

                @foreach ($nav_items as $item)
                    @if (!isset($item['can']) || $item['can'])
                        <a
                            href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                            class="{{ Route::is($item['route']) ? 'active' : '' }}"
                            @if (!empty($item['wire_navigate'])) wire:navigate @endif
                        >
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="other_links">
                @auth
                    <div class="profile">
                        <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}" wire:navigate>
                            {{ $user->full_name }}
                            <span class="role">{{ $user->email }}</span>
                        </a>
                    </div>
                    <button wire:click="logout" class="text-left w-full">Logout</button>
                @endauth

                @guest
                    <a href="{{ route('login') }}" wire:navigate>Login</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
