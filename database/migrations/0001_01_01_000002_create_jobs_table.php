<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration responsável por criar as tabelas para gerenciamento de filas e jobs no Laravel:
 * - jobs: fila de jobs pendentes
 * - job_batches: controle de batches de jobs (com suporte a Laravel Batch)
 * - failed_jobs: registro de jobs que falharam
 */
return new class extends Migration
{
    /**
     * Executa a criação das tabelas jobs, job_batches e failed_jobs.
     *
     * @return void
     */
    public function up(): void
    {
        // Tabela padrão usada por workers para armazenar jobs pendentes
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index(); // nome da fila
            $table->longText('payload'); // dados serializados do job
            $table->unsignedTinyInteger('attempts'); // número de tentativas
            $table->unsignedInteger('reserved_at')->nullable(); // quando o job foi reservado
            $table->unsignedInteger('available_at'); // quando o job estará disponível
            $table->unsignedInteger('created_at'); // timestamp de criação
        });

        // Tabela utilizada para gerenciar batches de jobs (Job Batching do Laravel)
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // UUID do batch
            $table->string('name'); // nome identificador do batch
            $table->integer('total_jobs'); // número total de jobs no batch
            $table->integer('pending_jobs'); // jobs ainda não concluídos
            $table->integer('failed_jobs'); // quantidade de falhas
            $table->longText('failed_job_ids'); // IDs dos jobs que falharam
            $table->mediumText('options')->nullable(); // configurações do batch (ex: callbacks)
            $table->integer('cancelled_at')->nullable(); // timestamp do cancelamento (se houver)
            $table->integer('created_at'); // criação
            $table->integer('finished_at')->nullable(); // finalização (se aplicável)
        });

        // Tabela para armazenar jobs que falharam após todas as tentativas
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique(); // identificador único do job
            $table->text('connection'); // conexão usada
            $table->text('queue'); // fila usada
            $table->longText('payload'); // dados serializados do job
            $table->longText('exception'); // stack trace do erro
            $table->timestamp('failed_at')->useCurrent(); // quando falhou
        });
    }

    /**
     * Reverte a criação das tabelas de jobs.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
