<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar as tabelas de cache do Laravel.
 * - cache: armazena entradas de cache persistente quando o driver 'database' é usado.
 * - cache_locks: utilizada para controlar locks em tarefas críticas (ex: evitar execução concorrente).
 */
return new class extends Migration
{
    /**
     * Executa a criação das tabelas 'cache' e 'cache_locks'.
     */
    public function up(): void
    {
        // Tabela usada pelo driver de cache "database"
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // chave do cache (identificadora)
            $table->mediumText('value'); // valor serializado
            $table->integer('expiration'); // timestamp unix de expiração
        });

        // Tabela usada para controle de locks no cache (evita concorrência de processos)
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // identificador único do lock
            $table->string('owner'); // identificador do "dono" do lock (ex: processo/UUID)
            $table->integer('expiration'); // timestamp unix de expiração do lock
        });
    }

    /**
     * Reverte as alterações feitas por esta migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
