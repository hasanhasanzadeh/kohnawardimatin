<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProduct extends Model
{
    use HasFactory;
    protected $table='cart_product';
    protected $fillable=[
        'cart_id',
        'product_id',
        'price',
        'qty',
        'sum_price',
        'option',
    ];

    /*
    * --------------------------------------------
    *              Relations
    * --------------------------------------------
    */
    public function cart():belongsTo
    {
        return $this->belongsTo(Cart::class,'cart_id','id');
    }

    public function product():belongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
