<x-slot name="extra_head">
    <meta name="description" content="Best Tour and Travel Company in Nairobi, we offer memorable safaris, thrilling gamedrives, peaceful beaches escapes and challenging mountain climbs. Book with us Today!" />
    <title>{{ config('app.name') }} | Best Tour and Travel Company in Nairobi, Kenya</title>
</x-slot>

<div class="HomePage">
    <section class="Hero">
        <video src="{{ asset('assets/videos/hero-section.mp4') }}" autoplay loop muted playsinline></video>
        <div class="mask"></div>
        <div class="content">
            <h1 class="title">Simian Safaris</h1>
            <p class="subtitle">Explore African Wildlife</p>
            <p class="description">Every adventure has a story, we’re here to help you write yours</p>
        </div>
    </section>

    <section class="About">
        <div class="container">
            <div class="content">
                <div class="section_header">
                    <p>WHO WE ARE</p>
                    <h2>About Simian Safaris</h2>
                </div>

                <div class="text">
                    <p>At Simian Safaris, we believe that every adventure has a story, and we’re here to help you write yours. Whether you’re drawn to the thrill of wildlife encounters, the serenity of breathtaking landscapes, or immersive cultural experiences, our expertly crafted safaris offer more than just a journey – they promise unforgettable adventures.</p>

                    <p class="subtitle">Why Choose Simian Safaris?</p>
                    <p>From the lush landscapes of the Serengeti to the majestic wonders of Amboseli, Simian Safaris specializes in connecting travelers with Africa’s most extraordinary destinations. Our team of seasoned safari experts goes beyond merely booking your travel; we immerse ourselves in each destination to bring you exclusive insights, hidden gems, and unique encounters that make your adventure truly exceptional.</p>

                    <div class="btn_wrapper">
                        <a href="{{ Route::has('about-page') ? route('about-page') : '#' }}" class="btn">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="image">
                <img src="{{ asset('assets/images/about-simian-safaris.jpg') }}" alt="About Simian Safaris">
            </div>
        </div>
    </section>

    <section class="Tours">
        <div class="container">
            <div class="section_header">
                <p>EXPLORE OUR Safaris</p>
                <h2>Discover Our Safaris</h2>
            </div>

            <div class="tours_list custom_cards">
                @foreach($tours as $tour)
                    <div class="tour card">
                        <div class="image">
                            <img src="{{ $tour->image }}" alt="{{ $tour->title }}">
                        </div>

                        <div class="content">
                            <p class="title">{{ $tour->title }}</p>
                            <p class="price">
                                <span>$ {{ number_format($tour->price) }}</span>
                                @if($tour->price_ranges_to)
                                    <span>- $ {{ number_format($tour->price_ranges_to, 2) }}</span>
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

    <section class="Destinations">
        <div class="container">
            <div class="section_header">
                <p>EXCELLENT PLACES TO GO</p>
                <h2>Discover Our Destinations</h2>
            </div>

            <div class="destinations_list custom_cards">
                @foreach($destinations as $destination)
                    <div class="destination card">
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

    <section class="CTA">
        <div class="container">
            <div class="image">
                <img src="{{ asset('assets/images/simian-safaris-cta-image.jpg') }}" alt="Book Your Safari">
            </div>

            <div class="content">
                <div class="section_header">
                    <p>YOUR TRIP AWAITS</p>
                    <h2>Book Your Safari Today</h2>
                </div>

                <div class="text">
                    <p>Ready to explore Africa's wild beauty? We're here to help you embark on the adventure of a lifetime. Reach out and let us craft your perfect safari experience together.</p>

                    <div class="buttons_group">
                        <a href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}" class="btn">Plan Your Trip</a>
                        <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}" class="btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
