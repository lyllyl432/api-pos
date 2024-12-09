<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'orderId' => $this->order_id,
            'productId' => new ProductResource($this->product),
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subTotal' => $this->sub_total,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}