<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Kingtas',
            'last_name' => 'college',
            'username' => 'admin',
            'email' => 'kingtascolg@gmail.com',
            'password' => Hash::make('Kingtas@123'), 
            'phone' => '+92323434543',
            'status' => '1',
        ]);
    }
}
