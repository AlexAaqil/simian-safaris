<div class="Authentication">
    <div class="container Profile">
        <livewire:auth.profile.update-profile-information />

        <livewire:auth.profile.update-password />

        @auth
            @unless(auth()->user()->isAdmin())
                <livewire:auth.profile.delete-user />
            @endunless
        @endauth
    </div>
</div>
