<section class="CTA">
    <div class="container">
        <div class="image">
            <img src="{{ asset('assets/images/simian-safaris-cta-image.jpg') }}" alt="Book Your Safari" loading="lazy">
        </div>

        <div class="content">
            <div class="section_header">
                <p>YOUR AFRICAN STORY BEGINS NOW</p>
                <h2>Personalized Safari Experiences Await</h2>
            </div>

            <div class="text">
                <p>Ready to witness Africa's breathtaking beauty firsthand? Our safari specialists combine local expertise with personalized service to create your perfect adventure - where wildlife encounters, luxurious comfort, and authentic experiences blend seamlessly.</p>

                <div class="trust_badges">
                    @php
                        $badges = [
                            'assets/images/trust-badges/safari-bookings.jpg',
                            'assets/images/trust-badges/tripadvisor.jpg',
                            'assets/images/trust-badges/national-museums-of-kenya.jpg',
                            'assets/images/trust-badges/kenya-wildlife-service.jpg',
                            'assets/images/trust-badges/amref-health-africa.jpg',
                        ];
                    @endphp

                    @foreach ($badges as $badge)
                        <div class="image badge flex items-center gap-2">
                            <img src="{{ asset($badge) }}" alt="{{ Str::title(str_replace('-', ' ', pathinfo($badge, PATHINFO_FILENAME))) }}">
                        </div>
                    @endforeach
                </div>

                <div class="buttons_group">
                    <a href="{{ Route::has('tours-page') ? route('tours-page') : '#' }}" class="btn">Design My Safari &rarr;</a>
                    <a href="{{ Route::has('contact-page') ? route('contact-page') : '#' }}" class="btn btn_secondary">Speak to Our Experts &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</section>
