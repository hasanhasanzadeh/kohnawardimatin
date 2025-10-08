<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    use HasFactory;
    protected $table='likes';
    protected $fillable=[
        'user_id',
        'likeable_type',
        'likeable_id',
    ];


    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
