<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Produto;
use App\Models\User;

class ProdutoTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco após cada teste

    /**
     * Teste para listar os produtos (GET /api/produtos).
     */
    public function test_listar_produtos()
    {
        // Criando usuário e gerando token
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        // Criando produtos no banco de testes
        Produto::factory()->count(3)->create();

        // Faz a requisição autenticada
        $response = $this->getJson('/api/produtos', [
            'Authorization' => 'Bearer ' . $token
        ]);

        // Valida a resposta
        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }


    /**
     * Teste para criar um produto (POST /api/produtos).
     */
    public function test_criar_produto()
    {
        // Cria um usuário e gera token
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        // Define os dados do produto a ser criado
        $produtoData = [
            "nome" => "Mouse Gamer",
            "descricao" => "Mouse óptico RGB",
            "preco" => 250.99,
            "estoque" => 15
        ];

        // Faz a requisição autenticada
        $response = $this->postJson('/api/produtos', $produtoData, [
            'Authorization' => 'Bearer ' . $token
        ]);

        // Valida que o produto foi criado com sucesso
        $response->assertStatus(201)
                 ->assertJsonFragment(["nome" => "Mouse Gamer"]);
    }

    /**
     * Teste para buscar um produto específico (GET /api/produtos/{id}).
     */
    public function test_buscar_produto()
    {
        // Criando usuário e gerando token
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        // Criando produto fictício
        $produto = Produto::factory()->create();

        // Faz a requisição autenticada
        $response = $this->getJson("/api/produtos/{$produto->id}", [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment(["nome" => $produto->nome]);
    }


    /**
     * Teste para atualizar um produto (PUT /api/produtos/{id}).
     */
    public function test_atualizar_produto()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        $produto = Produto::factory()->create();

        $novosDados = [
            "preco" => "300.00", // Aqui forçamos a string para evitar erros
            "estoque" => 20
        ];

        $response = $this->putJson("/api/produtos/{$produto->id}", $novosDados, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment(["preco" => "300.00"]); // Comparação como string
    }


    /**
     * Teste para deletar um produto (DELETE /api/produtos/{id}).
     */
    public function test_deletar_produto()
    {
        $user = User::factory()->create();
        $token = $user->createToken('api_token')->plainTextToken;

        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}", [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}
