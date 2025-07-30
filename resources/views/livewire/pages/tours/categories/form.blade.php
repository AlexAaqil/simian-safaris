<div class="custom_form py-4 max-w-4xl mx-auto">
    <div class="header">
        <h2>{{ $tour_category_id ? 'Edit Tour Category' : 'Create New Tour Category' }}</h2>
    </div>

    <form wire:submit="saveTourCategory" enctype="multipart/form-data">
        <div class="inputs">
            <label for="title" class="required">Title</label>
            <input type="text" wire:model="title" id="title" autocomplete="title" autofocus>
            <x-form-input-error field="title" />
        </div>

        <div class="inputs">
            <label for="image">Image (Less than 2MB)</label>
            <input type="file" wire:model="image" id="image">
            <x-form-input-error field="image" />

            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover">
            @elseif ($existing_image)
                <img src="{{ Storage::url('tour-categories/images/' . $existing_image) }}" class="w-32 h-32 object-cover">
            @endif
        </div>

        <div class="inputs">
            <label for="description">Description</label>
            <x-ckeditor wire:model="description" :value="$description" />
            <x-form-input-error field="description" />
        </div>

        <div class="buttons_group">
            <button type="submit" wire:loading.attr="disabled" wire:target="saveTourCategory">
                <span wire:loading.remove wire:target="saveTourCategory">{{ $tour_category_id ? 'Update' : 'Create' }} Tour Category</span>
                <span wire:loading wire:target="saveTourCategory">Saving Tour Category...</span>
            </button>
            <a href="{{ Route::has('tours-categories.index') ? route('tours-categories.index') : '#' }}" wire:navigate class="btn btn_danger">Cancel</a>
        </div>
    </form>
</div>
