<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('poltronas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero'); // Número da poltrona
            $table->string('onibus')->nullable(); // Ônibus associado
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamps();

            // Chave única combinando numero e onibus
            $table->unique(['numero', 'onibus'], 'poltronas_numero_onibus_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poltronas');
    }
};
