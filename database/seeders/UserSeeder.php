<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder responsável por popular a tabela de usuários (users).
 *
 * Este seeder cria três usuários com diferentes perfis:
 * - Usuário comum
 * - Lojista
 * - Outro usuário fictício
 */
class UserSeeder extends Seeder
{
    /**
     * Executa o seeder para inserir usuários fictícios no banco de dados.
     *
     * @return void
     */
    public function run(): void
    {
        // Usuário comum
        $user1 = User::create([
            'name' => 'João Silva',
            'email' => 'joao@email.com',
            'cpf' => '12345678901',
            'password' => Hash::make('senha123'),
        ]);

        // Lojista
        $user2 = User::create([
            'name' => 'Maria Oliveira',
            'email' => 'maria@email.com',
            'cpf' => '98765432109',
            'password' => Hash::make('senha456'),
        ]);

        // Outro usuário
        $user3 = User::create([
            'name' => 'Pedro Santos',
            'email' => 'pedro@email.com',
            'cpf' => '54432167890',
            'password' => Hash::make('senha123'),
        ]);
    }
}
