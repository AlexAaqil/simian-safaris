<div class="itinerary-row border rounded-sm p-2 my-4">
    <div class="inputs_group_3">
        <div class="inputs">
            <label>Day Number</label>
            <input type="number" name="itineraries[{{ $index }}][day_number]" value="{{ old("itineraries.$index.day_number", $itinerary['day_number'] ?? '') }}">
            <x-form-input-error field="itineraries.{{ $index }}.day_number" />
        </div>
        <div class="inputs">
            <label>Title</label>
            <input type="text" name="itineraries[{{ $index }}][title]" value="{{ old("itineraries.$index.title", $itinerary['title'] ?? '') }}">
            <x-form-input-error field="itineraries.{{ $index }}.title" />
        </div>
        <div class="inputs">
            <label>Description</label>
            <textarea name="itineraries[{{ $index }}][description]">{{ old("itineraries.$index.description", $itinerary['description'] ?? '') }}</textarea>
            <x-form-input-error field="itineraries.{{ $index }}.description" />
        </div>
    </div>
    <button type="button" class="btn_danger remove-itinerary">Remove</button>
</div>
