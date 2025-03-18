<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    // Define o modelo associado à factory
    protected $model = Produto::class;

    /**
     * Define o estado padrão do modelo Produto.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(), // Gera uma palavra aleatória como nome do produto
            'descricao' => $this->faker->sentence(), // Gera uma frase aleatória como descrição
            'preco' => $this->faker->randomFloat(2, 10, 5000), // Gera um preço aleatório entre 10 e 5000 com 2 casas decimais
            'estoque' => $this->faker->numberBetween(0, 100) // Gera um número inteiro aleatório entre 0 e 100 para o estoque
        ];
    }
}