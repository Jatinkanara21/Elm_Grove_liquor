<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_published' => $this->boolean('is_published'),
            'show_on_homepage' => $this->boolean('show_on_homepage'),
            'show_countdown' => $this->boolean('show_countdown'),
        ]);
    }

    public function rules(): array
    {
        $id = $this->route('event')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('events', 'slug')->ignore($id)],
            'headline' => ['nullable', 'string', 'max:500'],
            'date_label' => ['nullable', 'string', 'max:100'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:5000'],
            'event_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:event_date'],
            'event_type' => ['required', Rule::in(array_keys(\App\Models\Event::TYPES))],
            'hero_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'thumbnail_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'banner_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:100'],
            'accent_color' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/i'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'show_on_homepage' => ['boolean'],
            'show_countdown' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'url', 'max:500'],
            // 'publish_from' => ['nullable', 'datetime'],
            // 'publish_until' => ['nullable', 'datetime', 'after:publish_from'],
            'publish_from' => ['nullable', 'date'],
            'publish_until' => ['nullable', 'date', 'after:publish_from'],
        ];
    }

    public function messages(): array
    {
        return [
            'accent_color.regex' => 'Please enter a valid color in hex format (e.g., #8B4513).',
            'hero_image.max' => 'Hero image must not be larger than 5 MB.',
            'thumbnail_image.max' => 'Thumbnail must not be larger than 5 MB.',
            'banner_image.max' => 'Banner must not be larger than 5 MB.',
        ];
    }
}