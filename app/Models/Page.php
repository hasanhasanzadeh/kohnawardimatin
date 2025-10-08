<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Page extends Model
{
    use HasFactory, Sortable;
    protected $table='pages';
    protected $fillable=[
        'title',
        'slug',
        'description',
        'page_cat_id',
        'status'
    ];
    public array $sortable = [
        'title',
        'status',
        'created_at'
    ];
    /*
     * -----------------------------------------------
     *          Relation
     * -----------------------------------------------
     */
    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }

    public function page_cat(): BelongsTo
    {
        return $this->belongsTo(Page_Cat::class,'page_cat_id','id');
    }

}
