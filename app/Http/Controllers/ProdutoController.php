<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    // Lista produtos com paginação e filtro opcional por nome
    public function index(Request $request): JsonResponse
    {
        // Define o número de itens por página, limitando entre 1 e 100, com padrão 10
        $perPage = min(max((int) $request->input('per_page', 10), 1), 100); 
        // Inicia uma consulta ao modelo Produto
        $query = Produto::query();

        // Verifica se o parâmetro 'nome' foi fornecido na requisição
        if ($request->has('nome')) {
            // Obtém o valor do parâmetro 'nome'
            $nome = $request->input('nome');
            // Filtra produtos cujo nome contém o valor fornecido, ignorando maiúsculas/minúsculas
            $query->whereRaw('LOWER(nome) LIKE LOWER(?)', ["%{$nome}%"]);
        }

        // Executa a consulta com paginação usando o número de itens por página definido
        $produtos = $query->paginate($perPage);
        // Retorna os produtos paginados em formato JSON
        return response()->json($produtos);
    }

    // Cria um novo produto
    public function store(Request $request): JsonResponse
    {
        // Valida os dados enviados na requisição
        $dados = $request->validate([
            'nome' => 'required|string|max:255', // Nome é obrigatório, string, máx. 255 caracteres
            'descricao' => 'nullable|string', // Descrição é opcional, string
            'preco' => 'required|numeric|min:0', // Preço é obrigatório, numérico, mínimo 0
            'estoque' => 'integer|min:0' // Estoque é opcional, inteiro, mínimo 0
        ]);

        // Cria um novo produto no banco de dados com os dados validados
        $produto = Produto::create($dados);

        // Retorna o produto criado em JSON com status 201 (Criado)
        return response()->json($produto, 201);
    }

    // Exibe detalhes de um produto específico
    public function show(Produto $produto): JsonResponse
    {
        // Retorna os detalhes do produto em formato JSON
        return response()->json($produto);
    }

    // Atualiza um produto existente
    public function update(Request $request, Produto $produto): JsonResponse
    {
        // Valida os dados enviados, permitindo atualização parcial
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:255', // Nome é obrigatório apenas se enviado
            'descricao' => 'nullable|string', // Descrição é opcional
            'preco' => 'sometimes|required|numeric|min:0', // Preço é obrigatório apenas se enviado
            'estoque' => 'sometimes|integer|min:0' // Estoque é opcional, inteiro, mínimo 0
        ]);

        // Atualiza o produto com os dados validados
        $produto->update($dados);

        // Retorna o produto atualizado em formato JSON
        return response()->json($produto);
    }

    // Exclui um produto existente
    public function destroy(Produto $produto): JsonResponse
    {
        // Remove o produto do banco de dados
        $produto->delete();

        // Retorna uma resposta vazia com status 204 (Sem conteúdo)
        return response()->json(null, 204);
    }
}