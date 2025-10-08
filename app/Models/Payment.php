<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Kyslik\ColumnSortable\Sortable;

class Payment extends Model
{
    use HasFactory, Sortable;
    protected $table='payments';

    protected $fillable=[
        'authority',
        'status',
        'RefID',
        'pay_wallet',
        'pay_get_way',
        'user_id',
        'paymentable_type',
        'paymentable_id'
    ];

    public array $sortable = [
        'authority',
        'status',
        'RefID',
        'created_at'
    ];
    public function status(): string
    {
        return match ($this->status) {
            'undone' => 'پرداخت نشده',
            'pending' => 'معلق',
            'done' => 'پرداخت شده',
            default => 'وضعیت نامشخص',
        };
    }
     /*
      * -----------------------------------------------
      *          Relation
      * -----------------------------------------------
      */
    public function paymentable():morphTo
    {
        return $this->morphTo();
    }

    public function user():belongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
