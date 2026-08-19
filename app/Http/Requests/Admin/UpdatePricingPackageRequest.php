<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePricingPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tier' => ['required', 'in:silver,gold,diamond,custom'],
            'icon' => ['required', 'string', 'max:100'],
            'price_prefix' => ['required', 'string', 'max:50'],
            'price_amount' => ['required', 'string', 'max:50'],
            'price_unit' => ['nullable', 'string', 'max:20'],
            'features' => ['nullable', 'string'],
            'cta_text' => ['required', 'string', 'max:100'],
            'cta_link' => ['required', 'string', 'max:255'],
            'is_best_seller' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
        ];
    }
}
