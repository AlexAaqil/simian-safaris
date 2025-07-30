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
            'duration_days' => ['required','integer'],
            'duration_nights' => ['nullable','integer'],
            'currency' => ['required','string','in:$'],
            'price' => ['required','numeric'],
            'price_ranges_to' => ['nullable','numeric'],
            'tour_category_id' => ['required','exists:tour_categories,id'],

            'images.*' => 'nullable|image|max:2048',

            'itineraries' => ['nullable', 'array'], // <-- prevents structure errors

            'itineraries.*.title' => [
                'required_with:itineraries.*.day_number,itineraries.*.description',
                'string',
                'max:255',
            ],
            'itineraries.*.description' => [
                'required_with:itineraries.*.title,itineraries.*.day_number',
                'string',
            ],
            'itineraries.*.day_number' => [
                'required_with:itineraries.*.title,itineraries.*.description',
                'integer',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.unique' => 'This title is already taken. Please choose another.',
            'title.max' => 'Title must not exceed 120 characters.',

            'itineraries.*.title.required_with' => 'Please fill in the itinerary title.',
            'itineraries.*.description.required_with' => 'Please provide a description.',
            'itineraries.*.day_number.required_with' => 'Please provide a day number.',
            'itineraries.*.day_number.integer' => 'Day number must be a number like 1, 2, 3...',

            'image.*.image' => 'The uploaded file must be an image.',
            'image.*.max' => 'Image must be under 2MB.',
        ];
    }
}
