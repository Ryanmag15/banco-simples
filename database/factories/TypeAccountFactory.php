<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para a model TypeAccount.
 *
 * Esta factory define os valores padrão para a criação de registros
 * da model \App\Models\TypeAccount.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeAccount>
 */
class TypeAccountFactory extends Factory
{
    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed> Os atributos padrão para o modelo TypeAccount.
     */
    public function definition(): array
    {
        return [
            'name' => 'common',
            'internal_name' => 'Conta Comum',
        ];
    }
}
