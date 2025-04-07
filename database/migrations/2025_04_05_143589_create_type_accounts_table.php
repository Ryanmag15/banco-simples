<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar a tabela `type_accounts`.
 *
 * Essa tabela armazena os tipos de contas disponíveis, como "Conta Comum", "Conta Lojista", etc.,
 * com um nome legível e um nome interno usado para controle de regras de negócio.
 */
return new class extends Migration
{
    /**
     * Executa a criação da tabela `type_accounts`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('type_accounts', function (Blueprint $table) {
            $table->id();

            // Nome exibido do tipo de conta (ex: "Conta Comum")
            $table->string('name');

            // Nome interno usado no sistema (ex: "common")
            $table->string('internal_name');

            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela `type_accounts`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('type_accounts');
    }
};
