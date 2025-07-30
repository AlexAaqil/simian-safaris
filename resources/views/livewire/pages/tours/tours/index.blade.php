<div class="Tours">
    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ Route::has('tour-categories.index') ? route('tour-categories.index') : '#' }}" wire:navigate>Categories</a>
            <a href="{{ Route::has('tour-destinations.index') ? route('tour-destinations.index') : '#' }}" wire:navigate>Destinations</a>
            <span>Tours</span>
        </div>

        <div class="app_header">
            <div class="info">
                <h2>Tours</h2>
                <div class="stats">
                    <span>{{ $count_tours }} {{ Str::plural('tour', $count_tours) }}</span>
                    <span>{{ $count_published }} published</span>
                    <span>{{ $count_featured }} featured</span>
                </div>
            </div>

            <div class="search">
                <input type="text" placeholder="Search...">
            </div>

            <div class="button">
                <a href="{{ Route::has('tours.create') ? route('tours.create') : '#' }}" class="btn">New Tour</a>
            </div>
        </div>

        <div class="tours_list">
            @forelse($tours as $tour)
                <div class="tour">
                    <div class="image">
                        <img src="{{ $tour->image }}" alt="{{ $tour->title }}">
                    </div>

                    <div class="content">
                        <div class="info">
                            <h3 class="title">{{ $tour->title }}</h3>
                            <p class="price">
                                <span>{{ $tour->currency }} {{ $tour->price }}</span>
                                @if($tour->price_ranges_to)
                                    <span> - {{ $tour->currency }} {{ $tour->price_ranges_to }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="crud">
                            <div class="buttons_group">
                                <button wire:click="toggleIsFeatured({{ $tour->id }})" class="px-1 border rounded-sm {{ $tour->is_featured ? 'bg-green-100 text-green-900 border-green-900' : 'bg-red-100 text-red-900 border-red-900' }}">featured</button>
                                <button wire:click="toggleIsPublished({{ $tour->id }})" class="px-1 border rounded-sm {{ $tour->is_published ? 'bg-green-100 text-green-900 border-green-900' : 'bg-red-100 text-red-900 border-red-900' }}">published</button>
                            </div>

                            <div class="buttons_group">
                                <a href="{{ Route::has('tours.edit') ? route('tours.edit', ['tour' => $tour->uuid]) : '#' }}">
                                    <x-svgs.edit class="w-4 h-4 mr-1 text-green-600 cursor-pointer" />
                                </a>
                                <button x-data="" x-on:click.prevent="$wire.set('delete_tour_id', {{ $tour->id }}); $dispatch('open-modal', 'confirm-tour-deletion')" class="btn_transparent" >
                                    <x-svgs.trash class="w-4 h-4 text-red-600" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No tours found.</p>
            @endforelse
        </div>
    </div>

    <x-modal name="confirm-tour-deletion" :show="$delete_tour_id !== null" focusable>
        <div class="custom_form">
            <form wire:submit="deleteTour" @submit="$dispatch('close-modal', 'confirm-tour-deletion')" class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Confirm Deletion
                </h2>

                <p class="mt-2 mb-4 text-sm text-gray-600">
                    Are you sure you want to permanently delete this tour and it's bookings?
                </p>

                <div class="buttons_group">
                    <button type="submit" class="btn_danger">
                        Delete tour
                    </button>

                    <button type="button" class="mr-2" x-on:click="$dispatch('close-modal', 'confirm-tour-deletion')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
