<?php

namespace Database\Seeders;

use App\Models\Support\Administration\SupPanicLevel;
use App\Models\Support\Administration\SupReceptionMode;
use App\Models\Support\Administration\SupServiceArea;
use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SupPanicLevel::create([
            'description' => 'Normal',
            'state' => true
        ]);
        SupPanicLevel::create([
            'description' => 'Urgente',
            'state' => true
        ]);

        SupReceptionMode::create([
            'description' => 'Teléfono',
            'state' => true
        ]);
        SupReceptionMode::create([
            'description' => 'Email',
            'state' => true
        ]);
        SupReceptionMode::create([
            'description' => 'microsoft teams',
            'state' => true
        ]);
        SupReceptionMode::create([
            'description' => 'helpdesk',
            'state' => true
        ]);
        SupServiceArea::create([
            'description' => 'Nivel 1',
            'state' => true
        ]);
        SupServiceArea::create([
            'description' => 'Nivel 2',
            'state' => true
        ]);
        SupServiceArea::create([
            'description' => 'Nivel 3',
            'state' => true
        ]);
        SupServiceArea::create([
            'description' => 'Nivel Usuario Solicitante',
            'state' => false
        ]);
    }
}
