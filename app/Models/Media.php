<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kyslik\ColumnSortable\Sortable;

class Media extends Model
{
    use HasFactory, Sortable;

    protected $table='social_medias';
    protected $fillable=[
        'telegram',
        'instagram',
        'facebook',
        'whatsapp',
        'youtube',
        'x_link',
        'linkedin',
        'map_data',
        'google_plus',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function socialmediaable():morphTo
    {
        return $this->morphTo();
    }
}
