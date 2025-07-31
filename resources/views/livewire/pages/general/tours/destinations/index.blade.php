<div class="DestinationsPage">
    <section class="CustomJumbotron">
        <div class="container">
            <h1>Destinations</h1>
            <div class="breadcrumbs">
                <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}" wire:navigate>Home</a>
                <span>Destinations</span>
            </div>
        </div>
    </section>

    <section class="Destinations">
        <div class="container">
            <div class="custom_cards">
                @foreach($destinations as $destination)
                    <div class="card">
                        <div class="image">
                            <img src="{{ $destination->image }}" alt="{{ $destination->title }}">
                        </div>

                        <div class="content">
                            <p class="title">{{ $destination->title }}</p>
                            <div class="button_wrapper">
                                <a href="{{ Route::has('destination-details-page') ? route('destination-details-page', $destination->slug) : '#' }}" wire:navigate class="btn_link">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
