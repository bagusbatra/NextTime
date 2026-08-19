<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'alpha_dash', 'max:255', 'unique:projects,slug'],
            'title' => ['required', 'string', 'max:255'],
            'tag' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:umkm,company-profile,landing-page'],
            'status' => ['required', 'in:available,soon'],
            'mockup_type' => ['nullable', 'required_if:status,available', 'in:resto,shop,company'],
            'thumbnail' => ['nullable', 'image', 'max:4096'],
            'icon' => ['nullable', 'required_if:status,soon', 'string', 'max:100'],
            'summary' => ['required', 'string'],
            'overview' => ['nullable', 'required_if:status,available', 'string'],
            'features' => ['nullable', 'string'],
            'featured' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }
}
