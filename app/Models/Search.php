<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Search extends Model
{
    use HasFactory,SoftDeletes, Sortable;
    protected $table='searches';
    protected $fillable=[
        'user_id',
        'search_text',
        'ip_address' ,
    ];
    public array $sortable = [
        'search_text',
        'ip_address' ,
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
