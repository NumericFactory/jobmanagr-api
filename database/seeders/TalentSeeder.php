<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TalentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make a seed for each talent
        DB::table('talents')->insert([
            'last' => 'Doe',
            'first' => 'John',
            'xp' => 5,
            'tjm' => 500,
            'city' => 'Paris',
            'country' => 'France',
            'remote' => false,
            'linkedin' => 'https://www.linkedin.com/in/john-doe',
            'indicatifphone' => '+33',
            'phone' => '0600000000',
            'email' => 'johndoe@gmail.com'
        ]);
    
            // change values for this talent
            DB::table('talents')->insert([
                'last' => 'Doe',
                'first' => 'Jane',
                'xp' => 10,
                'tjm' => 700,
                'city' => 'Paris',
                'country' => 'France',
                'remote' => true,
                'linkedin' => 'https://www.linkedin.com/in/jane-doe',
                'indicatifphone' => '+33',
                'phone' => '0600000000',
                'email' => ''
            ]);
    }

}