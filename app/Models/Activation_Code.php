<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activation_Code extends Model
{
    use HasFactory;
    protected $table="activation_codes";
    protected $fillable=[
        'use',
        'code',
        'user_id',
        'expired',
        'mobile_email'
    ];

    public function scopeCreateCode($query , $user)
    {
        $code=$this->code();
        return $query->create([
            'user_id'=>$user->id,
            'code'=>$code,
            'expired'=>Carbon::now()->addMinutes(5),
        ]);
    }

    public function scopeCreateCodes($query , $mobile_email)
    {
        $code=$this->code();
        return $query->create([
            'mobile_email'=>$mobile_email,
            'code'=>$code,
            'expired'=>Carbon::now()->addMinutes(5),
        ]);
    }

    private function code(): int
    {
        do{
            $code=mt_rand(10000,99999);
            $check_code=static::whereCode($code)->get();
        }while(!$check_code->isEmpty());
        return $code;
    }

    /*
     * --------------------------------------------
     *              Relations
     * --------------------------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



}
