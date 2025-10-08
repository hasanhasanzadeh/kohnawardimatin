<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    protected $table='carts';
    protected $fillable=[
        'session_id',
        'user_id',
        'post_id',
        'quantity',
        'sum_price',
        'amount',
        'post_price',
        'total_price',
        'coupon_id',
    ];

    /*
    * --------------------------------------------
    *              Relations
    * --------------------------------------------
    */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }

    public function products():belongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['price','qty','sum_price','option']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
