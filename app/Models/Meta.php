<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Meta extends Model
{
    use HasFactory;
    protected $table='metas';
    protected $fillable=[
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    /*
     * -----------------------------------------------
     *          Relation
     * -----------------------------------------------
     */
    public function metaable():morphTo
    {
        return $this->morphTo();
    }
}
