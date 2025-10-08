<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;
    protected $table='files';
    protected $fillable = [
        'title',
        'path',
        'filename',
        'type',
        'mimes',
        'width',
        'height',
        'size',
        'time',
        'fileable_id',
        'fileable_type',
    ];


    public function getAddressAttribute(): string
    {
        $path=str_replace('public/', 'storage/', $this->attributes['path']);
        return '/'.$path;
    }

    public function getUrlAttribute(): string
    {
        str_replace('/storage/', '', $this->attributes['path']);
        return '/'.$this->attributes['path'];
    }

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function fileable():morphTo
    {
        return $this->morphTo();
    }

    public function videoPoster():morphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }

}
