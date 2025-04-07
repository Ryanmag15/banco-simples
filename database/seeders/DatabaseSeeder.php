<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal responsável por orquestrar a execução dos demais seeders da aplicação.
 *
 * Este seeder chama em sequência:
 * - UserSeeder: Criação de usuários fictícios
 * - TypeAccountSeeder: Criação dos tipos de conta
 * - AccountSeeder: Criação das contas associadas aos usuários
 * - TransferSeeder: (atualmente vazio, reservado para futuras transferências)
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Executa os seeders definidos para popular o banco de dados com dados iniciais.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TypeAccountSeeder::class,
            AccountSeeder::class,
            TransferSeeder::class,
        ]);
    }
}
