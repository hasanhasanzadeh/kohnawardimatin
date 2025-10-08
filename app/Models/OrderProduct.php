<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table='order_product';
    protected $fillable=[
        'order_id',
        'product_id',
        'original_price',
        'price',
        'discount',
        'qty',
        'option',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product');
    }
}
