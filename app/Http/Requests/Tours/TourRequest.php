<?php

namespace App\Http\Requests\Tours;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tour = $this->route('tour');

        return [
            'title' => [
                'required',
                'string',
                'max:120',
                $tour ? Rule::unique('tours', 'title')->ignoreModel($tour) : Rule::unique('tours', 'title'),
            ],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'summary' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'duration_days' => ['required','integer','min:1'],
            'duration_nights' => ['nullable','integer','min:0'],
            'currency' => ['required','string','in:$'],
            'price' => ['required','numeric','min:0'],
            'price_ranges_to' => ['nullable','numeric','min:0'],

            'tour_category_id' => ['required','exists:tour_categories,id'],

            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],

            'itineraries' => ['nullable', 'array'],
            'itineraries.*.title' => ['required_with:itineraries', 'string', 'max:255'],
            'itineraries.*.description' => ['required_with:itineraries', 'string'],
            'itineraries.*.sort_order' => ['required_with:itineraries', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.unique' => 'This title is already taken. Please choose another.',
            'title.max' => 'Title must not exceed 120 characters.',

            'itineraries.*.title.required' => 'Each itinerary item requires a title',
            'itineraries.*.description.required' => 'Each itinerary item requires a description',
            'itineraries.*.sort_order.required' => 'Each itinerary item requires a day number',
            'itineraries.*.sort_order.integer' => 'Day number must be a whole number',
            'itineraries.*.sort_order.min' => 'Day number must be at least 1',

            'images.*.image' => 'The uploaded file must be an image.',
            'images.*.max' => 'Image must be under 2MB.',
        ];
    }
}
