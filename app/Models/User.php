<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'mobile',
        'gender',
        'birthday',
        'email',
        'ip_address',
        'status',
        'card_number',
        'national_code',
        'news_letter',
        'wallet',
    ];
    public array $sortable = [
        'full_name',
        'mobile',
        'email',
        'ip_address',
        'status',
        'created_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    /*
 * ----------------------------------------------------
 *          Relations
 *-----------------------------------------------------
 */
    public function photo():morphOne
    {
        return $this->morphOne(File::class,'fileable');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function searches(): HasMany
    {
        return $this->hasMany(Search::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
