<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CartCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_id = $request->input('category_id');
        $brand_id = $request->input('brand_id');
        $products = Product::query()
            ->when($category_id, function (Builder $query, int $category_id) {
                $query->where('category_id', $category_id);
            })->when($brand_id, function (Builder $query, int $brand_id) {
                $query->where('brand_id', $brand_id);
            })
            ->get();
        return new ProductCollection($products);
    }

    //get all the cart products 
    public function cartProducts(StoreCartRequest $request)
    {
        $validated = $request->validated();
        $carts = Brand::with('products')->whereHas('products', function ($query) use ($validated) {
            $query->whereIn("id", $validated['product_id']);
        })->get();
        return new CartCollection($carts);
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
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
