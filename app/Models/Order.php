<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = [];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
