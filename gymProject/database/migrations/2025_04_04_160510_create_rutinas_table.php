<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutinasTable extends Migration
{
    public function up()
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->boolean('es_default')->default(0); // 1 = pública (predeterminada), 0 = privada
            $table->string('tipo', 20); // 'fuerza' o 'alimentacion'
            $table->timestamp('fecha_creacion')->useCurrent();
            
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('rutinas');
    }
}
