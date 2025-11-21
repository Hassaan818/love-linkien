<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class InspirationUpdateRequest extends FormRequest
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
        $slug = $this->route('slug');

        return [
            'name' => 'required|string|max:255|unique:inspirations,name,' . $slug . ',slug',
            'short_description' => 'nullable|string|max:500',
            'notes' => 'nullable|string',
            'gallery' => 'nullable|array',
            'gallery.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The inspiration name is required.',
            'name.max' => 'The name cannot exceed 255 characters.',
            'gallery.*.image' => 'Each gallery file must be an image.',
            'gallery.*.mimes' => 'Only jpg, jpeg, png, and webp formats are allowed.',
            'gallery.*.max' => 'Each image must not exceed 2MB.',
        ];
    }
}
