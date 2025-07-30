<div class="Tours TourCategories">
    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ Route::has('tour-destinations.index') ? route('tour-destinations.index') : '#' }}" wire:navigate>Destinations</a>
            <a href="{{ Route::has('tours.index') ? route('tours.index') : '#' }}" wire:navigate>Tours</a>
            <span>Tour Categories</span>
        </div>

        <div class="app_header">
            <div class="info">
                <h2>Tours</h2>
                <div class="stats">
                    <span>{{ $count_tour_categories }} {{ Str::plural('category', $count_tour_categories) }}</span>
                </div>
            </div>

            <div class="search">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>

            <div class="button">
                <a href="{{ Route::has('tour-categories.create') ? route('tour-categories.create') : '#' }}" class="btn">New Tour Category</a>
            </div>
        </div>

        <div class="tour_categories_list">
            @forelse($tour_categories as $category)
                <div class="tour_category">
                    <div class="image">
                        <img src="{{ $category->image }}" alt="{{ $category->title }}">
                    </div>

                    <div class="content">
                        <div class="info">
                            <h3 class="title">{{ $category->title }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $category->tours_count }} {{ Str::plural('Tour', $category->tours_count) }}
                            </p>
                        </div>

                        <div class="crud">
                            <div class="buttons_group">
                                <a href="{{ Route::has('tour-categories.edit') ? route('tour-categories.edit', $category->uuid) : '#' }}">
                                    <x-svgs.edit class="w-4 h-4 mr-1 text-green-600 cursor-pointer" />
                                </a>
                                <button x-data="" x-on:click.prevent="$wire.set('delete_tour_category_id', '{{ $category->uuid }}'); $dispatch('open-modal', 'confirm-tour-category-deletion')" class="btn_transparent" >
                                    <x-svgs.trash class="w-4 h-4 text-red-600" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No tour categories found.</p>
            @endforelse
        </div>
    </div>

    <x-modal name="confirm-tour-category-deletion" :show="$delete_tour_category_id !== null" focusable>
        <div class="custom_form">
            <form wire:submit="deleteTourCategory" @submit="$dispatch('close-modal', 'confirm-tour-category-deletion')" class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Confirm Deletion
                </h2>

                <p class="mt-2 mb-4 text-sm text-gray-600">
                    Are you sure you want to permanently delete this tour category and it's tours?
                </p>

                <div class="buttons_group">
                    <button type="submit" class="btn_danger">
                        Delete category
                    </button>

                    <button type="button" class="mr-2" x-on:click="$dispatch('close-modal', 'confirm-tour-category-deletion')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
