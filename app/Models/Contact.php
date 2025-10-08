<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Contact extends Model
{
    use HasFactory, Sortable;
    protected $table='contacts';
    protected $fillable=[
      'message',
      'subject',
      'name',
      'mail',
      'mobile',
      'ip_address',
      'user_id',
      'read',
    ];
    public array $sortable = [
        'subject',
        'name',
        'mail',
        'mobile',
        'ip_address',
        'read',
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
