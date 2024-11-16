<?php

namespace App\Http\Resources;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'category' => new CategoryResource($this->category),
            'brand' => new BrandResource($this->brand),
            'unit' =>  new UnitResource($this->unit),
            'warehouse' => new WarehouseResource($this->warehouse),
            'productName' => $this->product_name,
            'productImage' => $this->product_image,
            'barcodeSymbology' => $this->barcode_symbology,
            'productPrice' => $this->product_price
        ];
    }
}
