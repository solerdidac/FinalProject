<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportarProductos extends Command
{
    protected $signature = 'productos:importar';
    protected $description = 'Importar productos desde un CSV';

    public function handle()
    {
        $path = storage_path('app/lote_productos.csv');

        if (!file_exists($path)) {
            $this->error('Archivo CSV no encontrado.');
            return;
        }

        $csv = array_map('str_getcsv', file($path));
        $headers = array_map('trim', array_shift($csv));

        foreach ($csv as $row) {
            $data = array_combine($headers, $row);

            DB::table('productos')->insert([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'precio' => floatval($data['precio']),
                'stock' => intval($data['stock']),
                'categoria' => $data['categoria'],
                'imagen' => $data['imagen'],
                'fecha_creacion' => now()
            ]);
        }

        $this->info('✅ Productos importados correctamente.');
    }
}
