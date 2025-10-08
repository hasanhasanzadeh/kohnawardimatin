<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Slider extends Model
{
    use HasFactory, Sortable;
    protected $table='sliders';
    protected $fillable=[
      'category_id',
      'status',
      'rang',
      'url'
    ];
    public array $sortable = [
        'status',
        'rang',
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }
}
