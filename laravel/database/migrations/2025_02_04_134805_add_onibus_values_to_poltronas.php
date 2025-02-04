<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poltronas', function (Blueprint $table) {
            $table->string('onibus')->nullable(); // Adiciona a coluna 'onibus'
        });
    }

    public function down(): void
    {
        Schema::table('poltronas', function (Blueprint $table) {
            $table->dropColumn('onibus');
        });
    }
};
