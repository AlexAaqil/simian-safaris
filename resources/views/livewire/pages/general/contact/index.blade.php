<div class="ContactPage">
    <section class="Hero">
        <div class="container">
            <h1>Get In Touch</h1>
            <p>Ready to collaborate or have any questions? Reach out to us and our expert team will gladly help you out.</p>
        </div>
    </section>

    <section class="Contact">
        <div class="container">
            <div class="contacts">
                <div class="contact_column">
                    <h3>Contact Information</h3>
                    <div class="contact_content">
                        <div class="contact">
                            <x-svgs.telephone />
                            <div>
                                <h4>Phone</h4>
                                <p>{{ config('app.phone_number') }}</p>
                                <p>{{ config('app.secondary_phone_number') }}</p>
                            </div>
                        </div>

                        <div class="contact">
                            <x-svgs.whatsapp class="whatsapp_svg" />
                            <div>
                                <h4>WhatsApp</h4>
                                <p>{{ config('app.whatsapp_number') }}</p>
                            </div>
                        </div>

                        <div class="contact">
                            <x-svgs.email />
                            <div>
                                <h4>Email</h4>
                                <p>{{ config('app.email') }}</p>
                            </div>
                        </div>

                        <div class="contact">
                            <x-svgs.location />
                            <div>
                                <h4>Location</h4>
                                <p>{!! config('app.address') !!}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact_column">
                    <h3>Send us a Message</h3>
                    <div class="contact_content">
                        <livewire:pages.general.contact.form />
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
