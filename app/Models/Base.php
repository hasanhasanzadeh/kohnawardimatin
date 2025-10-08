<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kyslik\ColumnSortable\Sortable;

class Base extends Model
{
    use HasFactory, Sortable;
    protected $table='bases';
    protected $fillable=[
        'title',
        'description',
        'status',
    ];

    public array $sortable = [
        'title',
        'status',
        'description',
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

}
