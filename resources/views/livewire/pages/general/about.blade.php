<x-slot name="extra_head">
    <meta name="description" content="Simian Safaris - Kenya's premier safari experts offering bespoke wildlife adventures, luxury beach getaways, and mountain trekking experiences. Book your authentic African safari today." />
    <meta name="keywords" content="Kenya Safari, African Wildlife Tours, Luxury Safaris, Beach Holidays, Mountain Trekking, Cultural Experiences, Eco-Friendly Safaris" />
    <title>{{ config('app.name') }} | About Us</title>
</x-slot>

<div class="AboutPage">
    <section class="CustomJumbotron">
        <div class="container">
            <h1>About Us</h1>
            <div class="breadcrumbs">
                <a href="/">Home</a>
                <span>About Us</span>
            </div>
        </div>
    </section>

    <section class="About">
        <div class="container">
            <div class="content">
                <div class="section_header">
                    <p>Welcome to Simian Safaris</p>
                    <h2>Your Gateway to Breathtaking Safaris.</h2>
                </div>

                <div class="text">
                    <p>At Simian Safaris, we believe that every adventure has a story, and we’re here to help you write yours. Whether you’re drawn to the thrill of wildlife encounters, the serenity of breathtaking landscapes, or immersive cultural experiences, our expertly crafted safaris offer more than just a journey – we commit to provide unforgettable adventures.</p>
                    <p>We are on <a href="https://www.safaribookings.com/" target="_blank" referrerpolicy="no-referrer" class="themed_text">Safari Bookings</a>.</p>
                </div>
            </div>

            <div class="images">
                <div class="image image_one">
                    <img src="{{ asset('assets/images/simian-safaris-about-us_about-1.jpg') }}" alt="About Us Image 1">
                </div>

                <div class="other_images">
                    <div class="image image_two">
                        <img src="{{ asset('assets/images/simian-safaris-about-us_about-2.jpg') }}" alt="About Us Image 2">
                    </div>

                    <div class="image image_three">
                        <img src="{{ asset('assets/images/simian-safaris-about-us_about-3.jpg') }}" alt="About Us Image 3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="MissionStatements">
        <div class="container">
            <div class="image">
                <img src="{{ asset('assets/images/simian-safaris-about-us_mission_statement.jpg') }}" alt="Mission Statement Image 1">
            </div>

            <div class="content">
                <div class="section_header">
                    <p>Our Mission</p>
                    <h2>Why Choose Simian Safaris?</h2>
                </div>

                <div class="text">
                    <p>From the lush landscapes of the Serengeti to the majestic wonders of Amboseli, Simian Safaris specializes in connecting travelers with Africa’s most extraordinary destinations. We have partnered with <a href="https://www.safarigo.com" target="_blank" referrerpolicy="no-referrer" class="themed_text">Safari Go</a>.</p>
                    <p>Our team of seasoned safari experts goes beyond merely booking your travel; we immerse ourselves in each destination to bring you exclusive insights, hidden gems, and unique encounters that make your adventure truly exceptional.</p>

                    <p class="title">Our Promise to you</p>
                    <ul>
                        <li>Customized Safaris: Every traveler is unique, and so are our safaris. We tailor your journey to match your passions, interests, and travel aspirations.</li>
                        <li>Local Expertise: Our guides are locals who know their regions intimately. They’ll take you off the beaten path to experience Africa’s authentic beauty and wildlife.</li>
                        <li>Responsible Travel: We are committed to sustainable tourism. Our safaris support local communities, protect natural habitats, and ensure your travels benefit both you and the destinations you explore.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="MoreInfo">
        <div class="container">
            <div class="section_header">
                <h2>Let's Start your Journey Today</h2>
            </div>
            <p>With Simian Safaris, the world is at your fingertips. Our dedicated team is here to turn your dream holiday into a reality. Whether you’re tracking wildlife in Uganda’s forests, basking on Tanzania’s beaches, or embarking on a game drive through the Maasai Mara, we’ll craft a journey that leaves you with stories to tell for years to come.</p>

            <div class="more_content">
                <div class="content">
                    <p class="title">Destinations That Captivate</p>
                    <p>Imagine tracking the Big Five in the Serengeti, marveling at the Great Migration, or experiencing the diverse landscapes of Ngorongoro Crater. Whether you’re a wildlife enthusiast, a cultural explorer, or seeking relaxation in Africa’s stunning settings, we have the perfect safari for you.</p>
                    <ul>
                        <li><span>Wildlife Enthusiasts</span>: From thrilling game drives to up-close wildlife encounters, our safaris offer extraordinary opportunities to witness Africa’s rich fauna in their natural habitat.</li>
                        <li><span>Cultural Explorers</span>: Engage with vibrant local cultures and histories, from traditional Maasai villages to ancient archaeological sites, with immersive experiences that enrich your journey.</li>
                        <li><span>Relaxation & Adventure</span>: Balance your safari with moments of relaxation and adventure, whether it’s unwinding in luxury lodges or exploring Africa’s diverse landscapes.</li>
                    </ul>

                    <p class="title">How it Works</p>
                    <ul>
                        <li><span>Step 1</span>: Choose your dream destination or type of travel experience.</li>
                        <li><span>Step 2</span>: Get in touch with our team of expert travel planners to customize your itinerary.</li>
                        <li><span>Step 3</span>: Book your adventure and prepare for an experience of a lifetime!</li>
                    </ul>
                </div>

                <div class="image">
                    <img src="{{ asset('assets/images/simian-safaris-about-us_more_info.jpg') }}" alt="More Info Image" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <livewire:partials.call-to-action />
</div>
