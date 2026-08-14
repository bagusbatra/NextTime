<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'required', 'alpha_dash', 'max:255',
                Rule::unique('projects', 'slug')->ignore($this->route('project')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'tag' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:umkm,company-profile,landing-page'],
            'status' => ['required', 'in:available,soon'],
            'mockup_type' => ['nullable', 'required_if:status,available', 'in:resto,shop,company'],
            'icon' => ['nullable', 'required_if:status,soon', 'string', 'max:100'],
            'summary' => ['required', 'string'],
            'overview' => ['nullable', 'required_if:status,available', 'string'],
            'features' => ['nullable', 'string'],
            'featured' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }
}
