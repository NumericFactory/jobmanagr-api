<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //make a seed for each job
        DB::table('jobs')->insert([
            'title' => 'Développeur web',
            'customer_id' => 1,
            'description' => 'Le développeur web est un informaticien spécialisé dans la programmation de logiciels applicatifs destinés à être utilisés sur des sites web. Il est chargé de la conception technique d’un site internet, de sa mise en œuvre et de sa maintenance. Il peut également être amené à développer des applications web pour des clients.',
            'isremote' => false,
            'duration' => 3,
            'tjmin' => 300,
            'tjmax' => 500,
            'startDate' => '2021-01-01',
            'city' => 'Paris',
            'country' => 'France',
            'info' => 'Le développeur web est un informaticien spécialisé dans la programmation de logiciels applicatifs destinés à être utilisés sur des sites web. Il est chargé de la conception technique d’un site internet, de sa mise en œuvre et de sa maintenance. Il peut également être amené à développer des applications web pour des clients.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // change values for this job
        DB::table('jobs')->insert([
            'title' => 'Formateur Angular',
            'customer_id' => 1,
            'description' => 'Recherche formateur Angular pour une formation de 19 jours',
            'isremote' => true,
            'duration' => 19,
            'tjmin' => 700,
            'tjmax' => 700,
            'startDate' => '2023-12-15',
            'city' => 'Paris',
            'country' => 'France',
            'info' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
