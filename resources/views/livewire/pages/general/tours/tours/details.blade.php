<div class="TourDetailsPage">
    <div class="container tour">
        <div class="images_wrapper" x-data="{ mainImage: '{{ $tour->image }}' }">
            <div class="main_image">
                <div class="image">
                    <img :src="mainImage" alt="{{ $tour->title }}" id="mainImage" />
                </div>
            </div>

            <div class="other_images">
                @forelse($tour->images as $image)
                    <div class="image">
                        <img src="{{ $image->url }}" alt="{{ $tour->title }}" class="thumbnail cursor-pointer" @click="mainImage = '{{ $image->url }}'" :class="{ 'ring-2 ring-blue-500': mainImage === '{{ $image->url }}' }" />
                    </div>
                @empty
                    <p>No other images available</p>
                @endforelse
            </div>
        </div>

        <div class="content_wrapper">
            <h2 class="title">{{ $tour->title }}</h2>

            {{-- <p class="price">
                <span>$ {{ $tour->price }}</span>
                @if($tour->price_ranges_to)
                <span>- $ {{ $tour->price_ranges_to }}</span>
                @endif
            </p> --}}

            <p class="summary">{{ $tour->summary }}</p>

            <div class="extra_details">
                <p>
                    <span>No. of days</span>
                    <span>: {{ $tour->duration_days }}</span>
                </p>
                <p>
                    <span>No. of nights</span>
                    <span>: {{ $tour->duration_nights ?? 'N/A' }}</span>
                </p>
                <p>
                    <span>Category</span>
                    <span>: {{ Str::title($tour->category->title) }}</span>
                </p>
            </div>

            <div class="action_btn">
                <p>Your thrill for adventure and serenity of African nature begins here. Book your spot now!</p>
                <div class="buttons_group">
                    <a href="{{ Route::has('book-tour') ? route('book-tour', $tour->slug) : '#' }}" wire:navigate class="btn btn_themed">Book This Tour</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container tour_details_wrapper">
        <div class="ckedited_description">
            {!! $tour->description !!}
        </div>

        @if($tour->itineraries->count() > 0)
            <div class="itineraries">
                <h3>Itineraries</h3>
                @foreach($tour->itineraries as $index => $itinerary)
                    <div class="itinerary" x-data="{ open: false }">
                        <h3 class="title" @click="open = !open">
                            <span>{{ $itinerary->title }}</span>
                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </h3>

                        <div class="description mt-2 text-sm text-gray-700" x-show="open" x-transition x-cloak>
                            {!! $itinerary->description !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="container other_tours">
        <h2 class="title">Related Tours</h2>
        <div class="custom_cards">
            @forelse($other_tours as $other_tour)
                <div class="card">
                    <div class="image">
                        <img src="{{ $other_tour->image }}" alt="{{ $other_tour->title }}">
                    </div>

                    <div class="content">
                        <p class="title">{{ $other_tour->title }}</p>
                        <p class="price">
                            <span>{{ $other_tour->currency }} {{ $other_tour->price }}</span>
                            @if($other_tour->price_ranges_to)
                                <span>- {{ $other_tour->currency }} {{ $other_tour->price_ranges_to }}</span>
                            @endif
                        </p>
                        <div class="button_wrapper">
                            <a href="{{ Route::has('tour-details-page') ? route('tour-details-page', $other_tour->slug) : '#' }}" wire:navigate class="btn_link">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No other tours found.</p>
            @endforelse
        </div>
    </div>
</div>
