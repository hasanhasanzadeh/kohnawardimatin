<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Setting extends Model
{
    use HasFactory, Sortable;
    protected $table='settings';
    protected $fillable=[
        'title',
        'url',
        'address',
        'product_text',
        'favicon_id',
        'logo_id',
        'about',
        'copy_right',
        'user_id',
        'free_post',
        'tel',
        'email',
        'text_chat',
    ];

    public array $sortable = [
        'title' ,
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class,'logo_id','id');
    }

    public function favicon(): BelongsTo
    {
        return $this->belongsTo(File::class,'favicon_id','id');
    }

    public function symbols(): HasMany
    {
        return $this->hasMany(Symbol::class);
    }

    public function meta():morphOne
    {
        return $this->morphOne(Meta::class,'metaable');
    }

    public function media():morphOne
    {
        return $this->morphOne(Media::class,'socialmediaable');
    }

}
