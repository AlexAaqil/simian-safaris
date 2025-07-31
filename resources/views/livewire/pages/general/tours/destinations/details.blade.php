<div class="DestinationDetailsPage">
    <div class="hero_section">
        <div class="image">
            <div class="overlay"></div>
            <div class="text">
                <h1>{{ $destination->title }}</h1>
            </div>
            <img src="{{ $destination->image }}" alt="{{ $destination->title }}">
        </div>
    </div>

    <div class="container">
        <div class="ckedited_description">
            {!! $destination->description !!}
        </div>

        @if($other_destinations->count() > 0)
            <div class="other_destinations">
                <h2>Other Destinations</h2>
                <div class="custom_cards">
                    @foreach($other_destinations as $destination)
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
        @endif
    </div>
</div>
