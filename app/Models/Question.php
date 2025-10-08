<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Question extends Model
{
    use HasFactory, Sortable;
    protected $table='questions';
    protected $fillable=[
        'title',
        'description',
        'status',
    ];

    public array $sortable = [
        'title',
        'status',
        'created_at'
    ];
    /*
    * --------------------------------------------
    *              Relation
    * --------------------------------------------
    *
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
