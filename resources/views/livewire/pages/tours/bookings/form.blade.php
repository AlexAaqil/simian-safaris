<div class="BookTourPage">
    <div class="CustomJumbotron">
        <div class="container">
            <h1>Book {{ $tour->title }}</h1>
            <div class="breadcrumbs">
                <a href="{{ Route::has('tour-details-page') ? route('tour-details-page', $tour->slug) : '#' }}" wire:navigate>View Tour</a>
                <span>Book</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="custom_form mt-6">
            <form wire:submit.prevent="submit" class="space-y-4">
                <div class="inputs_group">
                    <div class="inputs">
                        <label for="name" class="required">Full Name</label>
                        <input type="text" wire:model="name" autofocus />
                        @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="inputs">
                        <label for="email" class="required">Email</label>
                        <input type="email" wire:model="email" />
                        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="inputs_group">
                    <div class="inputs">
                        <label for="phone_number" class="required">Phone Number</label>
                        <input type="text" wire:model="phone_number" />
                        @error('phone_number') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="inputs">
                        <label for="date_of_travel">Date of Travel</label>
                        <input type="date" wire:model="date_of_travel" />
                        @error('date_of_travel') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="inputs_group">
                    <div class="inputs">
                        <label for="number_of_adults" class="required">Adults</label>
                        <input type="number" wire:model="number_of_adults" min="1" />
                        @error('number_of_adults') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="inputs">
                        <label for="number_of_children">Children</label>
                        <input type="number" wire:model="number_of_children" min="0" />
                        @error('number_of_children') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="inputs">
                    <label for="additional_information">Additional Information</label>
                    <textarea wire:model="additional_information"></textarea>
                    @error('additional_information') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn_primary w-full">
                        <span wire:loading.remove>Book Tour</span>
                        <span wire:loading>Booking...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
