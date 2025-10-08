<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Country extends Model
{
    use HasFactory, Sortable;
    protected $table='countries';

    protected $fillable=[
        'country_name',
        'country_code',
    ];
    public array $sortable = [
        'country_name',
        'country_code',
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function provinces(): HasOne
    {
        return $this->hasOne(Province::class);
    }

    public function flag():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }
}
