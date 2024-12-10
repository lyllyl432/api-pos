<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupedOrderItemResource;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $status = $request->input('status');

        // Get the base query
        $query = OrderItem::with(['product.brand']);
        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        // Get the results and group them
        $orderItems = $query->get();
        $groupedItems = $orderItems->groupBy('product.brand.brand_name')
            ->map(function ($items, $brandName) {
                return [
                    'brand' => $brandName,
                    'items' => $items
                ];
            })->values();
        return GroupedOrderItemResource::collection($groupedItems);
    }
}
