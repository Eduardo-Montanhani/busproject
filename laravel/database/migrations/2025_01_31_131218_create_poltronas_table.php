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
        Schema::create('poltronas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->unique(); // Número único para cada poltrona
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete(); // Associa a um usuário e remove a relação se o usuário for deletado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poltronas');
    }
};
