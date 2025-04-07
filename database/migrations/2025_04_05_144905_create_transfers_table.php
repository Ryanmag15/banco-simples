<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar a tabela `transfers`.
 *
 * Esta tabela registra transferências financeiras entre usuários,
 * especificando o tipo de movimentação, os envolvidos e o valor.
 */
return new class extends Migration
{
    /**
     * Executa a criação da tabela `transfers`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            // Conta relacionada à transferência
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');

            // Tipo da transferência (ex: entrada ou saída)
            $table->string('type');

            // Usuário que realizou o pagamento (remetente)
            $table->foreignId('payer_id')->constrained('users');

            // Usuário que recebeu o pagamento (destinatário)
            $table->foreignId('payee_id')->constrained('users');

            // Valor da transferência
            $table->decimal('value', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverte a criação da tabela `transfers`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
