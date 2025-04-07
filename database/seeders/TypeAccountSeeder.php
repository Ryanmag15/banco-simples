<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeAccount;

/**
 * Seeder responsável por popular a tabela de tipos de conta (type_accounts).
 *
 * Este seeder cria três tipos de conta:
 * - Conta Comum
 * - Conta Lojista
 * - Conta Estudante
 */
class TypeAccountSeeder extends Seeder
{
    /**
     * Executa o seeder para inserir os tipos de conta padrão no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        TypeAccount::create([
            'name' => 'Conta Comum',
            'internal_name' => 'common',
        ]);

        TypeAccount::create([
            'name' => 'Conta Lojista',
            'internal_name' => 'merchant',
        ]);

        TypeAccount::create([
            'name' => 'Conta Estudante',
            'internal_name' => 'student',
        ]);
    }
}
