<?php

namespace Database\Seeders;

use App\Models\Niche;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class NicheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $niches = [
            [
                'name' => 'Dentista',
                'color' => '#5BC0DE' // Azul-claro
            ],

            [
                'name' => 'Contabilidade',
                'color' => '#343A40' // (Cinza-escuro)
            ],

            [
                'name' => 'Padaria',
                'color' => '#FFCE56' // (Amarelo-pão)
            ],

            [
                'name' => 'Pastelaria',
                'color' => '#F39C12' // (Laranja-pastel)
            ],

            [
                'name' => 'Lanchonete',
                'color' => '#E74C3C' // (Vermelho-tomate)
            ],

            [
                'name' => 'Pizzaria',
                'color' => '#C0392B' // (Vermelho-pizza)
            ],

            [
                'name' => 'Autopeças',
                'color' => '#3498DB' // (Azul-auto)
            ],

            [
                'name' => 'Peças Agrícolas',
                'color' => '#27AE60' // (Verde-campo)
            ],

            [
                'name' => 'Mercado',
                'color' => '#8E44AD' // (Roxo-mercado)
            ],

            [
                'name' => 'Coworking',
                'color' => '#1ABC9C' // (Verde-água)
            ],

            [
                'name' => 'Fábrica de Software',
                'color' => '#2C3E50' // (Azul-escuro)
            ],

            [
                'name' => 'Lojas de Roupas',
                'color' => '#E74C3C' // (Vermelho-moda)
            ],

            [
                'name' => 'Ópticas',
                'color' => '#9B59B6' // (Roxo-óptica)
            ],
            [
                'name' => 'Advogados',
                'color' => '#34495E' // (Azul-marinho)
            ],
        ];

        foreach ($niches as $row) {

            $niche = new Niche();
            $niche->name = $row['name'];
            $niche->slug = Str::slug($row['name']);
            $niche->color = $row['color'];
            $niche->companyId = 1;
            $niche->save();
        }
    }
}
