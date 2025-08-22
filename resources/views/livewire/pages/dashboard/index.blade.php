<div class="Dashboard">
    <section class="Hero">
        <div class="container">
            <h2>Hi, {{ auth()->user()->first_name }}</h2>
        </div>
    </section>

    @if(auth()->user()->isAdmin())
        <livewire:pages.dashboard.admin />
    @else
        <livewire:pages.dashboard.staff />
    @endif
</div>
