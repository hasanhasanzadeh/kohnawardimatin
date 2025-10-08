<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Coupon extends Model
{
    use HasFactory;
    protected $table='coupons';
    protected $fillable=[
        'title',
        'slug',
        'code',
        'discount',
        'expired_at',
        'description',
        'status',
        'user_id',
    ];

    use Sortable;
    public array $sortable = [
        'title',
        'slug',
        'code',
        'discount',
        'expired_at',
        'description',
        'status',
        'created_at'
    ];
    /*
    * --------------------------------------------
    *              Relations
    * --------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }

    public function orders():hasMany
    {
        return $this->hasMany(Comment::class,'coupon_id','id');
    }
}
