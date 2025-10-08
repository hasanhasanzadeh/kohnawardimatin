<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use HasFactory, Sortable;
    protected $table='posts';
    protected $fillable=[
        'title',
        'slug',
        'user_id',
        'photo_id',
        'description',
        'price',
        'url',
        'status',
        'payment_state',
        'const_price'
    ];

    public array $sortable = [
        'title',
        'price',
        'status',
        'created_at'
    ];
    /*
     *
     * ----------------------------------
     *          Relations
     * ----------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }

}
