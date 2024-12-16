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
            '*.user_id' => ['required', 'integer'],
            '*.order_number' => ['required', 'string'],
            '*.total_amount' => ['required', 'integer'],
            '*.status' => ['required', Rule::in(['pending', 'to_ship', 'to_receive', 'completed', 'cancelled', 'refunded'])],
            '*.shipping_fee' => ['required', 'integer'],
            '*.created_at' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.updated_at' => ['date_format:Y-m-d H:i:s', 'nullable']
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
