<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }

    public function rules(): array
    {
        $id = $this->route('store')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('stores', 'slug')->ignore($id)],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:50'],
            'zip' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+()\-\s.]*$/'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'opening_hours' => ['nullable', 'string', 'max:1000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'google_maps_url' => ['nullable', 'url:http,https', 'max:500'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Please enter a valid phone number.',
            'image.max' => 'The image must not be larger than 5 MB.',
            'image.mimes' => 'The image must be a JPG, PNG or WEBP file.',
        ];
    }
}