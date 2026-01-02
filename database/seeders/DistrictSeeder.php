<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            'Железнодорожный',
            'Кировский',
            'Ленинский',
            'Октябрьский',
            'Свердловский',
            'Советский',
            'Центральный',
        ];

        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'city_id' => 1,
                'name' => $district
            ]);
        }
    }
}
