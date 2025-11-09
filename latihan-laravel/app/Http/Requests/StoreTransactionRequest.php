<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah ditangani middleware auth di route
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'type'        => ['required', 'in:income,expense'],
            'title'       => ['required', 'string', 'max:255'],
            'note'        => ['nullable', 'string'],
            'amount'      => ['required', 'numeric', 'min:0'],
            'occurred_at' => ['required', 'date'],
            'cover'       => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ];
    }
}
