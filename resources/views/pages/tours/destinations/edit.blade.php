<x-app-layout>
    <div class="custom_form py-4 max-w-4xl mx-auto">
        <div class="header">
            <a href="{{ Route::has('tour-destinations.index') ? route('tour-destinations.index') : '#' }}" wire:navigate>
                <x-svgs.arrow-left class="w-5 h-5" />
            </a>
            <h2>Update Tour Destination</h2>
        </div>

        <form action="{{ route('tour-destinations.update', ['destination' => $destination->uuid]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="inputs">
                <label for="title" class="required">Title</label>
                <input type="text" name="title" id="title" autocomplete="title" value="{{ old('title', $destination->title) }}">
                <x-form-input-error field="title" />
            </div>

            <div class="inputs">
                <label for="image">Image (Less than 2MB)</label>
                <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg, .webp, .svg">
                <x-form-input-error field="image" />
            </div>

            <div class="inputs">
                <label for="description">Description</label>
                <textarea name="description" id="ckeditor" cols="30" rows="10">{{ old('description', $destination->description) }}</textarea>
                <x-form-input-error field="description" />
            </div>

            <div class="buttons_group">
                <button type="submit">Save Tour Destination</button>
                <a href="{{ Route::has('tour-destinations.index') ? route('tour-destinations.index') : '#' }}" wire:navigate class="btn btn_danger">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <x-ckeditor />
    @endpush
</x-app-layout>

