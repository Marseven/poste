<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Societe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Societe::create([
            'name' => 'La Poste',
            'email' => 'contact@laposte.ga',
            'phone1' => '077010203',
            'phone2' => '062010203',
            'website' => 'laposte.ga',
            'adresse' => 'Centre-Ville',
            'fax' => 'FX0011',
            'immatriculation' => 'NI234875632222',
            'code' => 'LPT',
        ]);
    }
}
