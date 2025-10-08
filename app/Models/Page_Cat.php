<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class Page_Cat extends Model
{
    use HasFactory, Sortable;
    protected $table='page_cats';
    protected $fillable=[
        'name',
        'description',
    ];
    public array $sortable = [
        'name',
        'created_at'
    ];
    /*
     * -----------------------------------------------
     *          Relation
     * -----------------------------------------------
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class,'page_cat_id','id');
    }
}
