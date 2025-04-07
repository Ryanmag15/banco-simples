<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para a model Account.
 *
 * Esta factory é utilizada para gerar dados fictícios da model \App\Models\Account,
 * ideal para testes automatizados ou seeds de desenvolvimento.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed> Os atributos padrão para o modelo Account.
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'number' => $this->faker->numerify('########'), // Número da conta com 8 dígitos
            'agencia' => $this->faker->numerify('####'), // Código da agência com 4 dígitos
            'type_account' => 1, // ID do tipo de conta (referência à tabela TypeAccount)
            'balance' => $this->faker->randomFloat(2, 0, 10000), // Saldo da conta entre 0 e 10.000
        ];
    }
}
