<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('poltronas', function (Blueprint $table) {
            // Verifica se a chave única antiga existe e remove
            $indexes = DB::select("SHOW INDEX FROM poltronas WHERE Key_name = 'poltronas_numero_unique'");
            if (!empty($indexes)) {
                $table->dropUnique('poltronas_numero_unique');
            }

            // Agora adicionamos a chave única correta
            $table->unique(['numero', 'onibus'], 'poltronas_numero_onibus_unique');
        });
    }

    public function down()
    {
        Schema::table('poltronas', function (Blueprint $table) {
            $table->dropUnique('poltronas_numero_onibus_unique');
            $table->unique('numero', 'poltronas_numero_unique'); // Restaura a restrição original
        });
    }
};
