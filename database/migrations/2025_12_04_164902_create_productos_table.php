<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2); // 10 dígitos, 2 decimales
            $table->integer('stock')->default(0);
            $table->string('imagen_url')->nullable(); // Guardaremos la ruta de la foto
            $table->string('categoria')->nullable(); // Ej: "Bebidas", "Almacén"
            $table->boolean('activo')->default(true); // Para ocultar sin borrar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
