@php
    $existingIteneraryCount = old('itineraries') ? count(old('itineraries')) : $tour->itineraries->count();
@endphp

<x-app-layout>
    <div class="custom_form py-4">
        <div class="header">
            <a href="{{ Route::has('tours.index') ? route('tours.index') : '#' }}">
                <x-svgs.arrow-left class="w-5 h-5" />
            </a>
            <h2>Edit Tour</h2>
        </div>

        <form action="{{ route('tours.update', $tour->uuid) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="title" class="required">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $tour->title) }}" autocomplete="title" autofocus>
                    <x-form-input-error field="title" />
                </div>

                <div class="inputs">
                    <label for="summary" class="required">Tour Summary</label>
                    <input type="text" name="summary" id="summary" value="{{ old('summary', $tour->summary) }}" autocomplete="summary">
                    <x-form-input-error field="summary" />
                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs custom_checkbox">
                    <label><input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured', $tour->is_featured)) /> Featured</label>
                </div>

                <div class="inputs custom_checkbox">
                    <label><input type="checkbox" name="is_published" id="is_published" value="1" @checked(old('is_published', $tour->is_published)) /> Published</label>

                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="tour_category_id" class="required">Tour Category</label>
                    <select name="tour_category_id" id="tour_category_id">
                        <option value="">Select Tour Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('tour_category_id', $tour->tour_category_id) == $category->id)>{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <x-form-input-error field="tour_category_id" />
                </div>

                <div class="inputs">
                    <label for="duration_days" class="required">Duration of Days</label>
                    <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $tour->duration_days) }}" autocomplete="duration_days">
                    <x-form-input-error field="duration_days" />
                </div>

                <div class="inputs">
                    <label for="duration_nights">Duration of Nights</label>
                    <input type="number" name="duration_nights" id="duration_nights" value="{{ old('duration_nights', $tour->duration_nights) }}" autocomplete="duration_nights">
                    <x-form-input-error field="duration_nights" />
                </div>
            </div>

            <div class="inputs_group_3">
                <div class="inputs">
                    <label for="currency" class="required">Currency</label>
                    <input type="text" name="currency" id="currency" placeholder="$" value="{{ old('currency', $tour->currency) }}">
                    <x-form-input-error field="currency" />
                </div>

                <div class="inputs">
                    <label for="price" class="required">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $tour->price) }}" autocomplete="price">

                    <x-form-input-error field="price" />
                </div>

                <div class="inputs">
                    <label for="price_ranges_to">Price Ranges To</label>
                    <input type="number" name="price_ranges_to" id="price_ranges_to" value="{{ old('price_ranges_to', $tour->price_ranges_to) }}" autocomplete="price_ranges_to">

                    <x-form-input-error field="price_ranges_to" />
                </div>
            </div>

            <div class="inputs mt-12">
                <label for="images">Upload Images (Max of 5 images and 2MB each)</label>
                <input type="file" name="images[]" id="images" multiple />
                <x-form-input-error field="images.*" />

                @if ($tour->images->count())
                    <div class="existing_images flex gap-2 flex-wrap mt-2" id="sortable">
                        @foreach ($tour->images as $image)
                            <div class="relative w-32 h-32 sortable_images" id="{{ $image->id }}">
                                <img src='{{ asset("storage/tours/images/{$image->image}") }}' alt="Tour Image" class="w-full h-full object-cover rounded" />

                                <a href="#" data-action="{{ route('tour-images.destroy', $image->uuid) }}" data-image-id="{{ $image->id }}" class="delete-image-link absolute top-1 right-1 btn_danger text-white p-1 rounded-full shadow hover:bg-red-100">
                                    <x-svgs.trash class="w-4 h-4" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="inputs mt-12">
                <label for="description">Description</label>
                <textarea name="description" id="ckeditor" placeholder="Enter a Description">{{ old('description', $tour->description) }}</textarea>
                <x-form-input-error field="description" />
            </div>

            <div class="inputs mt-12">
                <h3>Itineraries</h3>
                <div id="itineraries-wrapper" data-itinerary-index="{{ count(old('itineraries', $tour->itineraries->toArray())) }}">
                    @foreach (old('itineraries', $tour->itineraries->toArray()) as $index => $itinerary)
                        @include('partials.tour-itinerary-row', ['index' => $index, 'itinerary' => $itinerary])
                    @endforeach
                </div>
                <button type="button" id="add-itinerary" class="btn_transparent">+ Add Itinerary</button>
            </div>

            <div class="buttons_group mt-16">
                <button type="submit">Update Tour</button>
                <a href="{{ Route::has('tours.index') ? route('tours.index') : '#' }}" wire:navigate class="btn btn_danger">Cancel</a>
            </div>
        </form>

        <form id="delete-image-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    @push('scripts')
        <x-ckeditor />
        <script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('itineraries-wrapper');

    // Initialize index based on existing items
    let itineraryIndex = wrapper.querySelectorAll('.itinerary-row').length;

    document.getElementById('add-itinerary').addEventListener('click', function () {
        const newRow = document.createElement('div');
        newRow.classList.add('itinerary-row', 'border', 'rounded-sm', 'p-2', 'my-4');
        newRow.innerHTML = `
            <div class="inputs_group_3">
                <div class="inputs">
                    <label>Day Number</label>
                    <input type="number" name="itineraries[${itineraryIndex}][sort_order]"
                           value="${itineraryIndex + 1}" min="1" required>
                </div>
                <div class="inputs">
                    <label>Title</label>
                    <input type="text" name="itineraries[${itineraryIndex}][title]" required>
                </div>
            </div>
            <div class="inputs">
                <label>Description</label>
                <textarea name="itineraries[${itineraryIndex}][description]" required></textarea>
            </div>
            <button type="button" class="btn_danger remove-itinerary">Remove</button>
        `;

        wrapper.appendChild(newRow);
        itineraryIndex++;
    });

    // Delegate event for remove buttons
    wrapper.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-itinerary')) {
            if (confirm('Are you sure you want to remove this itinerary?')) {
                e.target.closest('.itinerary-row').remove();
            }
        }
    });
});
        </script>

        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/jquery_ui.js') }}"></script>
        <script>
            $(document).ready(function() {
            $("#sortable").sortable({
                update : function(event, ui) {
                    var photo_id = new Array();
                    $('.sortable_images').each(function() {
                        var id = $(this).attr('id');
                        photo_id.push(id);
                    });

                    $.ajax({
                        type : "POST",
                        url : "{{ url('admin/tour-images/sort') }}",
                        data : {
                            "photo_id" : photo_id,
                            "_token" : "{{ csrf_token() }}"
                        },
                        dataType : "json",
                        success : function(data) {

                        },
                        error : function (data) {

                        }
                    });
                }
            });
        });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deleteLinks = document.querySelectorAll('.delete-image-link');
                const deleteForm = document.getElementById('delete-image-form');

                deleteLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();

                        if (confirm('Are you sure you want to delete this image?')) {
                            deleteForm.setAttribute('action', this.dataset.action);
                            deleteForm.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>

