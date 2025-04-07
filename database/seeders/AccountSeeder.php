<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder responsável pela criação de contas bancárias associadas a usuários específicos.
 *
 * Este seeder cria três contas para os usuários com IDs 1, 2 e 3, cada uma com diferentes
 * números de conta, agências e tipos de conta.
 */
class AccountSeeder extends Seeder
{
    /**
     * Executa o seeder para popular a tabela de contas bancárias (accounts).
     *
     * @return void
     */
    public function run(): void
    {
        // Cria conta para o usuário com ID 1
        $user = User::find(1);
        Account::create([
            'user_id' => $user->id,
            'number' => '123456',
            'agencia' => '1234',
            'type_account' => 1,
            'balance' => 1000,
        ]);

        // Cria conta para o usuário com ID 2
        $userSecond = User::find(2);
        Account::create([
            'user_id' => $userSecond->id,
            'number' => '654321',
            'agencia' => '123456',
            'type_account' => 2,
            'balance' => 1000,
        ]);

        // Cria conta para o usuário com ID 3
        $userThird = User::find(3);
        Account::create([
            'user_id' => $userThird->id,
            'number' => '123456',
            'agencia' => '1234',
            'type_account' => 3,
            'balance' => 1000,
        ]);
    }
}
