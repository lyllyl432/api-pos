<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderItemsRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
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
        $order = null;
        if ($status == "all") {
            $order = Order::with(['orderItems', 'orderItems.product'])
                ->where('user_id', $user_id)
                ->latest()
                ->paginate(15);
        } else {
            $order = Order::with(['orderItems', 'orderItems.product'])
                ->where('user_id', $user_id)
                ->where('status', $status)
                ->latest()
                ->paginate(15);
        }
        return new OrderCollection(
            $order
        );
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
        $orderId = [];
        $bulk = collect($request->all())->map(function ($arr, $key) {
            return $arr;
        });
        foreach ($bulk as $orderData) {
            $order = Order::create($orderData);
            $orderId[] = $order->id;
        }
        return response()->json(['order_id' => $orderId]);
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
