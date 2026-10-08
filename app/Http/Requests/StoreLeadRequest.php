<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->errorBag = (string) $this->route('type');
    }

    /** Send validation errors back to the form that was submitted. */
    protected function getRedirectUrl(): string
    {
        return url()->previous(route('contact')).'#form-'.$this->route('type');
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        $type = $this->route('type');
        $products = array_keys(config('products.items'));

        // Honeypot filled: skip validation so the controller can fake success.
        if ($this->isSpam()) {
            return [];
        }

        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'min:7', 'max:40'],
            'preferred_contact' => ['nullable', Rule::in(['whatsapp', 'phone', 'email'])],
            'product' => ['nullable', Rule::in($products)],
            'message' => ['nullable', 'string', 'max:3000'],
            'consent' => ['accepted'],
        ];

        if ($type === 'contact') {
            $rules['email'] = ['required', 'email', 'max:160'];
            $rules['message'] = ['required', 'string', 'max:3000'];
        }

        if (in_array($type, ['quote', 'callback'], true)) {
            $rules['phone'] = ['required', 'string', 'min:7', 'max:40'];
        }

        if ($type === 'quote') {
            $rules['product'] = ['required', Rule::in($products)];
            $rules['age'] = ['nullable', 'integer', 'min:16', 'max:90'];
            $rules['smoker'] = ['nullable', Rule::in(['yes', 'no'])];
            $rules['dependants'] = ['nullable', 'integer', 'min:0', 'max:20'];
            $rules['budget'] = ['nullable', Rule::in(['under-300', '300-600', '600-1200', '1200-plus', 'unsure'])];
            $rules['timeframe'] = ['nullable', Rule::in(['now', 'month', 'quarter', 'exploring'])];
            $rules['existing_cover'] = ['nullable', Rule::in(['none', 'some', 'reviewing'])];
        }

        if ($type === 'callback') {
            $rules['best_time'] = ['nullable', Rule::in(['morning', 'midday', 'afternoon', 'evening', 'saturday'])];
        }

        if ($type === 'calculator') {
            $rules['calculator'] = ['required', Rule::in(array_keys(config('calculators.items')))];
            $rules['inputs'] = ['required', 'json', 'max:4000'];
            $rules['results'] = ['required', 'json', 'max:4000'];
        }

        return $rules;
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'consent.accepted' => 'Please confirm you are happy for Rachel to contact you.',
            'product.required' => 'Choose the cover you would like a quote for.',
            'phone.required' => 'Add a phone or WhatsApp number so Rachel can reach you.',
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return [
            'preferred_contact' => 'preferred way to be contacted',
            'best_time' => 'best time to call',
            'existing_cover' => 'existing cover',
        ];
    }

    public function isSpam(): bool
    {
        return $this->filled('website') || ! isset(Lead::TYPES[$this->route('type')]);
    }
}
