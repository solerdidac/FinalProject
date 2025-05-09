<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock')->default(0);
            $table->enum('categoria', ['suplemento', 'complemento']);
            $table->string('imagen', 255)->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
