<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Service;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Fitra Fajar',
            'email' => 'fitra@gmail.com',
            'password' => bcrypt('12345')
        ]);

        Stock::create([
            'name' => 'Deterjen',
            'quantity' => 10,
        ]);
        Stock::create([
            'name' => 'Plastik',
            'quantity' => 20,
        ]);
        Stock::create([
            'name' => 'Pewangi',
            'quantity' => 10,
        ]);

        Service::create([
            'name' => 'Pria'
        ]);
        Service::create([
            'name' => 'Wanita'
        ]);
        Service::create([
            'name' => 'Anak - Anak'
        ]);
        
        Customer::factory(10)->create();
    }
}
