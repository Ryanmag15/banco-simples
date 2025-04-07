<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Factory responsável por gerar instâncias do modelo User com dados falsos,
 * utilizada principalmente em testes e seeders.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Armazena a senha criptografada usada em todos os usuários criados por essa factory.
     * Evita múltiplas chamadas ao Hash::make(), otimizando a performance nos testes.
     */
    protected static ?string $password;

    /**
     * Define o estado padrão do modelo User.
     *
     * @return array<string, mixed> Um array de atributos falsos para preencher o modelo.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'cpf' => fake()->numerify('###########'),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Define um estado alternativo onde o e-mail do usuário não está verificado.
     *
     * @return static Instância da factory com o estado "unverified"
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
