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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            // Relación con el usuario que compró
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('total', 10, 2);
            $table->string('metodo_pago'); // 'mercadopago' o 'efectivo'
            $table->string('estado')->default('pendiente'); // pendiente, pagado, entregado

            // Datos de Mercado Pago (pueden ser nulos si paga en efectivo)
            $table->string('mercadopago_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
