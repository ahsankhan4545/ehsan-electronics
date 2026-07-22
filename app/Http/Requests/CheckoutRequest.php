<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:100'],
            'shipping_same_as_billing' => ['sometimes', 'boolean'],
            'shipping_name' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:255'],
            'shipping_address' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:500'],
            'shipping_city' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:100'],
            'shipping_state' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:100'],
            'shipping_zip' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:20'],
            'shipping_country' => ['required_if:shipping_same_as_billing,false', 'nullable', 'string', 'max:100'],
            'payment_method' => ['required', 'in:cod,bank_transfer,easypaisa'],
        ];
    }
}
