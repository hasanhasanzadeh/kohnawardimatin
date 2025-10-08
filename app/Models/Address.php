<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table='addresses';
    protected $fillable=[
        'receptor_name',
        'receptor_mobile',
        'address_text',
        'post_code',
        'city_id',
        'user_id',
    ];

     /*
     * --------------------------------------------
     *              Relations
     * --------------------------------------------
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
