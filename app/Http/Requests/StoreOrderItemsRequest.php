<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemsRequest extends FormRequest
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
            '*.sub_total' => ['required', 'integer'],
            '*.order_id' => ['required', 'integer'],
            '*.price' => ['required', 'integer'],
            '*.product_id' => ['required', 'integer'],
            '*.quantity' => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $data[] = $obj;
        }
        $this->merge($data);
    }
}
