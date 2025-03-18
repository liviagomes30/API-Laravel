<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * A senha atual sendo usada pela factory.
     */
    protected static ?string $password;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), // Gera um nome aleatório
            'email' => fake()->unique()->safeEmail(), // Gera um email único e seguro
            'email_verified_at' => now(), // Define a data de verificação do email como o momento atual
            'password' => static::$password ??= Hash::make('password'), // Usa a senha padrão 'password' criptografada, se não definida
            'remember_token' => Str::random(10), // Gera um token aleatório de 10 caracteres
        ];
    }

    /**
     * Indica que o endereço de email do modelo não deve ser verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null, // Define a verificação de email como nula
        ]);
    }
}