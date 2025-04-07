<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar a tabela `accounts`.
 *
 * A tabela armazena informações das contas bancárias dos usuários,
 * incluindo número, agência, saldo, e os relacionamentos com usuários e tipos de conta.
 */
return new class extends Migration
{
    /**
     * Executa a criação da tabela `accounts`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            // Número da conta bancária
            $table->string('number');

            // Número da agência
            $table->string('agencia');

            // Saldo atual da conta
            $table->string('balance');

            // Chave estrangeira para o usuário dono da conta
            $table->unsignedBigInteger('user_id');

            // Chave estrangeira para o tipo da conta (ex: comum, lojista, etc.)
            $table->unsignedBigInteger('type_account');

            // Definição das foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_account')->references('id')->on('type_accounts');

            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela `accounts`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
