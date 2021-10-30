<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
            Country::create([
                'name' => 'India',

                
            ]);
            
            Country::create([
                'name' => 'china',

                
            ]);
            Country::create([
                'name' => 'U.S',

                
            ]);
            Country::create([
                'name' => 'srilanka',

                
            ]);
       
    }
}
