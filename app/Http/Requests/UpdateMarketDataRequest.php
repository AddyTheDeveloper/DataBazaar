<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $marketData = $this->route('market_data');
        return auth()->user()->isAdmin() || $marketData->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01|max:9999999.99',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'Please enter a product name.',
            'price.required' => 'Please enter the product price.',
            'price.min' => 'Price must be at least ₹0.01.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category is invalid.',
            'location.required' => 'Please enter the market location.',
            'date.required' => 'Please enter the date of observation.',
            'date.before_or_equal' => 'Date cannot be in the future.',
        ];
    }
}
