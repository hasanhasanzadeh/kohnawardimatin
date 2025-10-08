<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Article extends Model
{
    use HasFactory;
    protected $table='articles';
    protected $fillable=[
        'title',
        'slug',
        'publish_date',
        'description',
        'body',
        'status',
        'view_count',
        'user_id',
    ];

    use Sortable;
    public array $sortable = [
        'title',
        'status',
        'publish_date',
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

    public function comments():morphMany
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
