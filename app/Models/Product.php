<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Sortable;
    protected $table='products';
    protected $fillable=[
        'title',
        'original_name',
        'slug',
        'description',
        'attribute',
        'buy_price',
        'price',
        'quantity',
        'status',
        'original_price',
        'discount',
        'special',
        'expired_at',
        'photo_id',
        'brand_id',
        'category_id',
        'view_count',
        'user_id',
        'sku',
    ];

    public $sortable = [
        'title',
        'price',
        'status',
        'quantity',
        'created_at'
    ];
    /*
     * --------------------------------------------
     *              Relation
     * --------------------------------------------
     *
     */
    public function images():morphMany
    {
        return $this->morphMany(File::class,'fileable');
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(File::class,'photo_id','id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->belongsTo(Order::class)->withPivot(['price','qty','original_price','discount','option']);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function carts():belongsToMany
    {
        return $this->belongsToMany(Cart::class)->withPivot(['price','quantity','sum_price','option']);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValues::class)->withPivot(['value_id','attribute_id']);
    }
}
