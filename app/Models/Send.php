<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Send extends Model
{
    use HasFactory, Sortable;
    protected $table='sends';
    protected $fillable=[
        'user_id',
        'status',
    ];

    public array $sortable = [
        'status' ,
        'created_at'
    ];
    /*
     * ----------------------------------------------------
     *          Relations
     *-----------------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
