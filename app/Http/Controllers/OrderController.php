<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemsRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\GroupedOrderItemResource;
use App\Http\Resources\OrderCollection;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $user_id = $request->input('user_id');

        $query = Order::with(['orderItems.product.brand']);

        if ($user_id) {
            $query->where('user_id', $user_id);
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->get();
        $groupedByBrand = $orders->flatMap(function ($order) {
            return $order->orderItems;
        })->groupBy(function ($orderItem) {
            return $orderItem->product->brand->brand_name;
        })->map(function ($items, $brandName) {
            return [
                'brand_name' => $brandName,
                'order_items' => $items->map(function ($item) {
                    return [
                        'order_id' => $item->order_id,
                        'order_number' => $item->order->order_number,
                        'product_name' => $item->product->product_name,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'total_amount' => $item->order->total_amount,
                        'status' => $item->order->status,
                        'created_at' => $item->created_at
                    ];
                })
            ];
        })->values();

        return GroupedOrderItemResource::collection($groupedByBrand);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreOrderRequest $request) {}

    public function bulkOrderStore(StoreOrderRequest $request)
    {
        $orderIds = [];
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return $arr;
        });
        foreach ($bulk as $orderData) {
            $order = Order::create($orderData);
            $orderIds[] = $order->id;
        }
        return response()->json(['order_id' => $orderIds]);
    }

    public function bulkOrderItemStore(StoreOrderItemsRequest $request)
    {

        $bulk = collect($request->all())->map(function ($arr, $key) {
            return $arr;
        });
        OrderItem::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
