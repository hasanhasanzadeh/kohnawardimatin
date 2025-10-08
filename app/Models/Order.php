<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{
    use HasFactory, Sortable;
    protected $table='orders';
    protected $fillable=[
        'amount',
        'user_id',
        'address_id',
        'code',
        'post_id',
        'status',
        'serial',
        'coupon_id',
        'post_price',
        'status_send',
    ];
    public array $sortable = [
        'amount',
        'status',
        'status_send',
        'created_at'
    ];
    public function status_send(): string
    {
        return match ($this->status_send) {
            'sending' => 'درحال ارسال',
            'send' => 'ارسال شد',
            'process' => 'پردازش',
            default => 'وضعیت نامشخص',
        };
    }

    /*
     * -----------------------------------------------
     *          Relation
     * -----------------------------------------------
     */
    public function  user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot(['price','qty','original_price','discount','option']);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }

    public function payment():morphOne
    {
        return $this->morphOne(Payment::class,'paymentable');
    }
}
