<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make a seed for each customer
        DB::table('customers')->insert([
            'name' => 'Société Générale',
            'type' => 'entreprise',
            'isorganismeformation' => false,
            'siren' => '552120222',
            'nic' => '00013',
            'siret' => '55212022200013',
            'address' => '29 Boulevard Haussmann',
            'complementaddress' => '',
            'cp' => '75009',
            'city' => 'Paris',
            'country' => 'France',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
            // change values for this customer
            DB::table('customers')->insert([
                'name' => 'EPITA',
                'type' => 'ecole',
                'isorganismeformation' => true,
                'siren' => '752190777',
                'nic' => '00013',
                'siret' => '75219077700057',
                'address' => '2 Rue d\'Hauteville',
                'complementaddress' => '',
                'cp' => '75010',
                'city' => 'Paris',
                'country' => 'France',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
