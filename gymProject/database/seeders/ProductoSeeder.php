<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Barras Proteicas',
                'descripcion' => 'Barras energéticas ricas en proteína.',
                'precio' => 12.99,
                'stock' => 30,
                'categoria' => 'suplemento',
                'imagen' => 'productos/barras_proteicas.jpg',
            ],
            [
                'nombre' => 'Bote Aminos',
                'descripcion' => 'Aminoácidos esenciales para recuperación muscular.',
                'precio' => 24.50,
                'stock' => 15,
                'categoria' => 'suplemento',
                'imagen' => 'productos/bote_aminos.jpg',
            ],
            [
                'nombre' => 'Camiseta GymTeam',
                'descripcion' => 'Camiseta deportiva de algodón, transpirable.',
                'precio' => 14.95,
                'stock' => 20,
                'categoria' => 'complemento',
                'imagen' => 'productos/camiseta.jpg',
            ],
            [
                'nombre' => 'Cinturón de Gimnasio',
                'descripcion' => 'Soporte lumbar para levantamiento de peso.',
                'precio' => 19.99,
                'stock' => 10,
                'categoria' => 'complemento',
                'imagen' => 'productos/cinturon_gym.jpg',
            ],
            [
                'nombre' => 'Creatina Monohidratada',
                'descripcion' => 'Mejora el rendimiento y la fuerza.',
                'precio' => 17.75,
                'stock' => 25,
                'categoria' => 'suplemento',
                'imagen' => 'productos/creatina.jpg',
            ],
            [
                'nombre' => 'Guantes de entrenamiento',
                'descripcion' => 'Evitan ampollas y mejoran el agarre.',
                'precio' => 9.99,
                'stock' => 18,
                'categoria' => 'complemento',
                'imagen' => 'productos/guantes.jpg',
            ],
            [
                'nombre' => 'Mancuernas 5kg',
                'descripcion' => 'Mancuernas revestidas en goma.',
                'precio' => 29.99,
                'stock' => 12,
                'categoria' => 'complemento',
                'imagen' => 'productos/mancuernas.jpg',
            ],
            [
                'nombre' => 'Proteína Whey',
                'descripcion' => 'Suplemento de proteína de suero.',
                'precio' => 39.90,
                'stock' => 22,
                'categoria' => 'suplemento',
                'imagen' => 'productos/proteina.jpg',
            ],
            [
                'nombre' => 'Shaker mezclador',
                'descripcion' => 'Mezclador para batidos, 600ml.',
                'precio' => 6.50,
                'stock' => 50,
                'categoria' => 'complemento',
                'imagen' => 'productos/shaker.jpg',
            ],
        ]);
    }
}
