<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'country_id' => 1,
            'name' => 'Gujarat',      
        ]);

        State::create([
            'country_id' => 1,
            'name' => 'Haryana',      
        ]);

        State::create([
            'country_id' => 3,
            'name' => 'California',      
        ]);

        State::create([
            'country_id' => 2,
            'name' => 'Beijing',      
        ]);

        
        
    }
}
