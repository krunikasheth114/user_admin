<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin@123'),
            'is_admin'=>'1',
        ]);
    }
}
