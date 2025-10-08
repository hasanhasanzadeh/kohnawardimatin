<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Brand extends Model
{
    use HasFactory, Sortable;
    protected $table='brands';
    protected $fillable=[
        'title',
        'description',
        'photo_id',
        'slug',
        'brand_url',
        'user_id',
    ];

    public array $sortable = [
        'title',
        'created_at'
    ];

    /*
    * --------------------------------------------
    *              Relations
    * --------------------------------------------
    */
    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }
}
