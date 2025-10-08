<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory, Sortable;
    protected $table='categories';
    protected $fillable=[
      'id',
      'name',
      'slug',
      'parent_id',
      'status',
    ];
    public array $sortable = [
        'name',
        'status',
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

    public function parents(): HasMany
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function children(): HasMany
    {
        return $this->parents()->with('children');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
