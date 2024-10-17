<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer'],
            '*.productId' => ['required', 'integer'],
            '*.quantity' => ['required', 'integer'],
            '*.status' => ['required', Rule::in(['P', 'S', 'C'])],
            '*.totalCost' => ['required', 'integer'],
            '*.createdAt' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.updatedAt' => ['date_format:Y-m-d H:i:s', 'nullable']
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['product_id'] = $obj['productId'] ?? null;
            $obj['total_cost'] = $obj['totalCost'] ?? null;
            $obj['created_at'] = $obj['createdAt'] ?? null;
            $obj['updated_at'] = $obj['updatedAt'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
