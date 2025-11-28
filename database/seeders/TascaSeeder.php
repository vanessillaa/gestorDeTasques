<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tasca;
use Carbon\Carbon;

class TascaSeeder extends Seeder
{
    public function run()
    {
        Tasca::create([
            'titol' => 'Fer la maleta',
            'descripcio' => 'Viatge a Mallorca.',
            'data_limit' => Carbon::now()->addDays(3),
            'estat' => 'pendent'
        ]);

        Tasca::create([
            'titol' => 'Fer exercici',
            'descripcio' => 'Sortir a caminar 30 minuts cada dia.',
            'data_limit' => Carbon::now()->addWeek(),
            'estat' => 'en_curs'
        ]);

        Tasca::create([
            'titol' => 'Anar al mercadona',
            'descripcio' => 'Comprar gelat, pa i ous.',
            'data_limit' => Carbon::now()->addDays(1),
            'estat' => 'completada'
        ]);
    }
}
