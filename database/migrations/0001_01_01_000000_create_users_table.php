<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável pela criação das tabelas:
 * - users
 * - password_reset_tokens
 * - sessions
 *
 * Tabela `users`: armazena dados dos usuários do sistema.
 * Tabela `password_reset_tokens`: armazena tokens de redefinição de senha.
 * Tabela `sessions`: armazena sessões ativas dos usuários.
 */
return new class extends Migration
{
    /**
     * Executa as migrações.
     *
     * Cria as tabelas `users`, `password_reset_tokens` e `sessions` com suas respectivas colunas.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID único do usuário
            $table->string('name'); // Nome do usuário
            $table->string('email')->unique(); // E-mail único
            $table->string('cpf')->unique(); // CPF único
            $table->timestamp('email_verified_at')->nullable(); // Data de verificação do e-mail
            $table->string('password'); // Senha criptografada
            $table->rememberToken(); // Token de "lembrar-me"
            $table->timestamps(); // created_at e updated_at
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // E-mail como chave primária
            $table->string('token'); // Token de redefinição de senha
            $table->timestamp('created_at')->nullable(); // Data de criação do token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID da sessão
            $table->foreignId('user_id')->nullable()->index(); // ID do usuário relacionado
            $table->string('ip_address', 45)->nullable(); // Endereço IP da sessão
            $table->text('user_agent')->nullable(); // Informações do navegador/dispositivo
            $table->longText('payload'); // Dados da sessão
            $table->integer('last_activity')->index(); // Timestamp da última atividade
        });
    }

    /**
     * Reverte as migrações.
     *
     * Remove as tabelas `users`, `password_reset_tokens` e `sessions`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
