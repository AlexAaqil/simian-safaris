<div class="tours_form">
    <div class="custom_form py-4">
        <div class="header">
            <h2>{{ $tour_id ? 'Edit Tour' : 'Create New Tour' }}</h2>
        </div>

        <form wire:submit="saveTour" enctype="multipart/form-data">
            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="title" class="required">Title</label>
                    <input type="text" wire:model="title" id="title" autocomplete="title" autofocus>
                    <x-form-input-error field="title" />
                </div>

                <div class="inputs">
                    <label for="summary" class="required">Tour Summary</label>
                    <input type="text" wire:model="summary" id="summary" autocomplete="summary">
                    <x-form-input-error field="summary" />
                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs custom_checkbox">
                    <label><input type="checkbox" wire:model="is_featured" id="is_featured" /> Featured</label>
                </div>

                <div class="inputs custom_checkbox">
                    <label><input type="checkbox" wire:model="is_published" id="is_published" /> Published</label>
                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="tour_category_id" class="required">Tour Category</label>
                    <select wire:model="tour_category_id" id="tour_category_id">
                        <option value="">Select Tour Category</option>
                        @foreach ($tour_categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <x-form-input-error field="tour_category_id" />
                </div>

                <div class="inputs">
                    <label for="duration_days" class="required">Duration of Days</label>
                    <input type="number" wire:model="duration_days" id="duration_days" autocomplete="duration_days">
                    <x-form-input-error field="duration_days" />
                </div>

                <div class="inputs">
                    <label for="duration_nights">Duration of Nights</label>
                    <input type="number" wire:model="duration_nights" id="duration_nights" autocomplete="duration_nights">
                    <x-form-input-error field="duration_nights" />
                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="currency" class="required">Currency</label>
                    <input type="text" wire:model="currency" id="currency" placeholder="$">
                    <x-form-input-error field="currency" />
                </div>

                <div class="inputs">
                    <label for="price" class="required">Price</label>
                    <input type="number" wire:model="price" id="price" autocomplete="price">
                    <x-form-input-error field="price" />
                </div>

                <div class="inputs">
                    <label for="price_ranges_to">Price Ranges To</label>
                    <input type="number" wire:model="price_ranges_to" id="price_ranges_to" autocomplete="price_ranges_to">
                    <x-form-input-error field="price_ranges_to" />
                </div>
            </div>

            <div class="inputs">
                <h3>Iteneraries</h3>
                @foreach($itineraries as $index => $itenerary)
                    <div class="border p-2 my-4" wire:key="itenerary-{{ $index }}">
                        <div class="inputs_group">
                            <div class="inputs">
                                <label for="iteneraries.{{ $index }}.title">Title</label>
                                <input type="text" wire:model="iteneraries.{{ $index }}.title" placeholder="Title" />
                                <x-form-input-error field="iteneraries.{{ $index }}.title" />
                            </div>

                            <div class="inputs">
                                <label for="iteneraries.{{ $index }}.day_number">Day Number</label>
                                <input type="number" wire:model="iteneraries.{{ $index }}.day_number" placeholder="Day Number" />
                                <x-form-input-error field="iteneraries.{{ $index }}.day_number" />
                            </div>
                        </div>

                        <div class="inputs">
                            <label for="description">Description</label>
                            <textarea wire:model="iteneraries.{{ $index }}.description" placeholder="Description"></textarea>
                            <x-form-input-error field="iteneraries.{{ $index }}.description" />
                        </div>
                        <button type="button" wire:click="removeItineraryRow({{ $index }})" class="btn_danger">Remove</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addItineraryRow">+ Add Itinerary</button>
            </div>

            <div class="inputs">
                <label for="images">Upload Images (Max 2MB each)</label>
                <input type="file" wire:model="images" id="images" multiple />
                <x-form-input-error field="images.*" />
                <!-- @error('images.*') <span class="text-red-600">{{ $message }}</span> @enderror -->

                <div class="grid grid-cols-4 gap-2 mt-2">
                    @foreach ($images as $upload)
                        <img src="{{ $upload->temporaryUrl() }}" class="h-24 w-24 object-cover rounded border" />
                    @endforeach
                </div>
            </div>

            @if ($existing_images)
                <div>
                    <label>Existing Images</label>
                    <div class="grid grid-cols-4 gap-2 mt-2">
                        @foreach ($existing_images as $id => $path)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $path) }}" class="h-24 w-24 object-cover rounded border" />
                                <button type="button" wire:click="removeExistingImage({{ $id }})"
                                    class="absolute top-0 right-0 bg-red-600 text-white px-1 rounded">x</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="inputs">
                <label for="description">Description</label>
                <textarea wire:model="description" id="editor_ckeditor" placeholder="Enter a Description"></textarea>
                <x-form-input-error field="description" />
            </div>

            <div class="buttons_group">
                <button type="submit" wire:loading.attr="disabled" wire:target="saveTour">
                    <span wire:loading.remove wire:target="saveTour">{{ $tour_id ? 'Update' : 'Create' }} Tour</span>
                    <span wire:loading wire:target="saveTour">Saving Tour...</span>
                </button>
                <a href="{{ Route::has('tours.index') ? route('tours.index') : '#' }}" wire:navigate class="btn btn_danger">Cancel</a>
            </div>
        </form>
    </div>
</div>

<x-slot name="javascript">
    <x-ckeditor />
</x-slot>

