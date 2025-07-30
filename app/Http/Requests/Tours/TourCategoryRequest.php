<?php

namespace App\Http\Requests\Tours;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourCategoryRequest extends FormRequest
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
        $tour_category = $this->route('tour_category');

        return [
            'title' => [
                'required',
                'string',
                $tour_category ? Rule::unique('tour_categories', 'title')->ignoreModel($tour_category) : Rule::unique('tour_categories', 'title'),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.unique' => 'This title is already taken. Please choose another.',
            'image.image' => 'The uploaded file must be an image.',
            'image.max' => 'Image must be under 2MB.',
        ];
    }
}
