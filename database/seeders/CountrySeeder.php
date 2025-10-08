<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::factory(1)->create();
        $country = Country::first();

        $country->flag()->save(File::factory()->create([
            'path' => 'flags/flag-' . $country->id . '.png',
            'fileable_id' => $country->id,
            'fileable_type' => Country::class
        ]));
    }
}
