<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'state_id' => 1,
            'name'=>'Bharuch'

            
        ]);

        City::create([
            'state_id' => 1,
            'name'=>'Surat'

            
        ]);
        
    }
}
