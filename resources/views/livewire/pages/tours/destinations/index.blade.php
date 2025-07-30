<div class="Tours TourDestinations">
    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ Route::has('tour-categories.index') ? route('tour-categories.index') : '#' }}" wire:navigate>Categories</a>
            <a href="{{ Route::has('tours.index') ? route('tours.index') : '#' }}" wire:navigate>Tours</a>
            <span>Destinations</span>
        </div>

        <div class="app_header">
            <div class="info">
                <h2>Destinations</h2>
                <div class="stats">
                    <span>{{ $count_tour_destinations }} {{ Str::plural('destination', $count_tour_destinations) }}</span>
                </div>
            </div>

            <div class="search">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>

            <div class="button">
                <a href="{{ Route::has('tour-destinations.create') ? route('tour-destinations.create') : '#' }}" class="btn">New Tour Destination</a>
            </div>
        </div>

        <div class="tour_categories_list">
            @forelse($tour_destinations as $destination)
                <div class="tour_category">
                    <div class="image">
                        <img src="{{ $destination->image }}" alt="{{ $destination->title }}">
                    </div>

                    <div class="content">
                        <div class="info">
                            <h3 class="title">{{ $destination->title }}</h3>
                        </div>

                        <div class="crud">
                            <div class="buttons_group">
                                <a href="{{ Route::has('tour-destinations.edit') ? route('tour-destinations.edit', $destination->uuid) : '#' }}">
                                    <x-svgs.edit class="w-4 h-4 mr-1 text-green-600 cursor-pointer" />
                                </a>
                                <button x-data="" x-on:click.prevent="$wire.set('delete_tour_destination_id', '{{ $destination->uuid }}'); $dispatch('open-modal', 'confirm-tour-destination-deletion')" class="btn_transparent" >
                                    <x-svgs.trash class="w-4 h-4 text-red-600" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No tour destinations found.</p>
            @endforelse
        </div>
    </div>

    <x-modal name="confirm-tour-destination-deletion" :show="$delete_tour_destination_id !== null" focusable>
        <div class="custom_form">
            <form wire:submit="deleteTourDestination" @submit="$dispatch('close-modal', 'confirm-tour-destination-deletion')" class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Confirm Deletion
                </h2>

                <p class="mt-2 mb-4 text-sm text-gray-600">
                    Are you sure you want to permanently delete this tour destination?
                </p>

                <div class="buttons_group">
                    <button type="submit" class="btn_danger">
                        Delete destination
                    </button>

                    <button type="button" class="mr-2" x-on:click="$dispatch('close-modal', 'confirm-tour-destination-deletion')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
