<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'warehouseName' => $this->warehouse_name,
            'warehousePhone' => $this->warehouse_phone,
            'warehouseCountry' => $this->warehouse_country,
            'warehouseEmail' => $this->warehouse_email,
            'warehouseZipCode' => $this->warehouse_zipcode,
            'warehouseCity' => $this->warehouse_city,
        ];
    }
}
