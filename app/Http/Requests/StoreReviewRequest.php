<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'body' => ['required', 'string', 'min:10', 'max:1500'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Please choose a star rating.',
            'body.required' => 'Please write a short review.',
            'body.min' => 'Your review must be at least 10 characters.',
        ];
    }

    public function attributes(): array
    {
        return ['body' => 'review'];
    }
}