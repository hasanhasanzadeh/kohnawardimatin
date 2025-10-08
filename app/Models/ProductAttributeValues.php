<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductAttributeValues  extends Pivot
{
    use HasFactory;
    protected $table = 'attribute_product';
    protected $fillable = [
        'product_id',
        'attribute_id',
        'value_id'
    ];
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class , 'attribute_id' , 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }

}
