<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar a tabela `personal_access_tokens`.
 *
 * Esta tabela é utilizada para armazenar tokens de autenticação pessoal
 * (geralmente usados com Laravel Sanctum).
 */
return new class extends Migration
{
    /**
     * Executa a criação da tabela `personal_access_tokens`.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable'); // Relacionamento polimórfico
            $table->string('name'); // Nome do token
            $table->string('token', 64)->unique(); // Token único
            $table->text('abilities')->nullable(); // Permissões associadas ao token
            $table->timestamp('last_used_at')->nullable(); // Último uso do token
            $table->timestamp('expires_at')->nullable(); // Expiração do token
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverte a criação da tabela `personal_access_tokens`.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
