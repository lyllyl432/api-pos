<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupedOrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'brand' => $this->resource['brand'],
            'items' => OrderItemResource::collection($this->resource['items'])
        ];
    }
}
