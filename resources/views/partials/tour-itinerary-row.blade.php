<div class="itinerary-row border rounded-sm p-2 my-4">
    <div class="inputs_group_3">
        <div class="inputs">
            <label>Day Number</label>
            <input type="number"
                   name="itineraries[{{ $index }}][sort_order]"
                   value="{{ $itinerary['sort_order'] ?? ($index + 1) }}"
                   min="1"
                   required>
            @error("itineraries.$index.sort_order")
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="inputs">
            <label>Title</label>
            <input type="text"
                   name="itineraries[{{ $index }}][title]"
                   value="{{ $itinerary['title'] ?? '' }}"
                   required>
            @error("itineraries.$index.title")
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="inputs">
        <label>Description</label>
        <textarea name="itineraries[{{ $index }}][description]" required>{{ $itinerary['description'] ?? '' }}</textarea>
        @error("itineraries.$index.description")
            <span class="error">{{ $message }}</span>
        @enderror
    </div>
    <button type="button" class="btn_danger remove-itinerary">Remove</button>
</div>
