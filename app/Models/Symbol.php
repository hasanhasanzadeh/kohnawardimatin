<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Symbol extends Model
{
    use HasFactory, Sortable;
    protected $table='symbols';
    protected $fillable=[
        'title',
        'link',
        'description',
        'setting_id'
    ];

    public array $sortable = [
        'title',
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }

    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }
}
