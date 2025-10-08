<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'full_name' => 'Hasan Hasanzadeh',
            'email' => 'hasan.hasanzadeh.dev@gmail.com',
            'mobile' => '09384446491',
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'gender' => 'male',
            'birthday' => '1991-02-13',
            'password' => Hash::make('2890065707'),
            'remember_token' => Str::random(100),
        ]);
    }
}
