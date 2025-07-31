<div class="ToursPage">
    <section class="CustomJumbotron">
        <div class="container">
            <h1>Tours</h1>
            <div class="breadcrumbs">
                <a href="{{ Route::has('home-page') ? route('home-page') : '#' }}" wire:navigate>Home</a>
                <a href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}" wire:navigate>Tours</a>
                <span>{{ Str::title($category->title) }}</span>
            </div>
        </div>
    </section>

    <section class="Tours">
        <div class="container">
            <div class="custom_cards">
                @foreach($category->tours as $tour)
                    <div class="card">
                        <div class="image">
                            <img src="{{ $tour->image }}" alt="{{ $tour->title }}">
                        </div>

                        <div class="content">
                            <p class="title">{{ $tour->title }}</p>
                            <p class="price">
                                <span>$ {{ $tour->price }}</span>
                                @if($tour->price_ranges_to)
                                    <span>- $ {{ $tour->price_ranges_to }}</span>
                                @endif
                            </p>
                            <div class="button_wrapper">
                                <a href="{{ Route::has('tour-details-page') ? route('tour-details-page', $tour->slug) : '#' }}" wire:navigate class="btn_link">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
