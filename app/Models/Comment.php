<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kyslik\ColumnSortable\Sortable;

class Comment extends Model
{
    use HasFactory, Sortable;
    protected $table='comments';
    protected $fillable=[
        'parent_id',
        'title',
        'body',
        'status',
        'commentable_type',
        'commentable_id',
        'user_id',
        'created_at',
        'updated_at'
    ];
    public array $sortable = [
        'title',
        'body',
        'status',
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class,'parent_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
