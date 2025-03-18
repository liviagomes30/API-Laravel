<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProdutoController extends Controller
{
    // Lista produtos com paginação e opcional filtro por nome
    // public function index(Request $request): JsonResponse
    // {
    //     $query = Produto::query();

    //     if ($request->filled('nome')) {
    //         $query->where('nome', 'like', '%' . $request->nome . '%');
    //     }

    //     $produtos = $query->paginate(10);

    //     return response()->json($produtos);
    // }

    // public function index(Request $request)
    // {
    //     // Define o número de itens por página (padrão 10, mas pode ser alterado via query string)
    //     $perPage = $request->input('per_page', 10);

    //     // Retorna os produtos paginados
    //     return Produto::paginate($perPage);
    // }

    public function index(Request $request): JsonResponse
    {
        $perPage = min(max((int) $request->input('per_page', 10), 1), 100); 
        $query = Produto::query();

        if ($request->has('nome')) {
            $nome = $request->input('nome');
            $query->whereRaw('LOWER(nome) LIKE LOWER(?)', ["%{$nome}%"]);
        }

        $produtos = $query->paginate($perPage);
        return response()->json($produtos);
    }


    // Cria um novo produto
    public function store(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'integer|min:0'
        ]);

        $produto = Produto::create($dados);

        return response()->json($produto, 201);
    }

    // Exibe detalhes do produto
    public function show(Produto $produto): JsonResponse
    {
        return response()->json($produto);
    }

    // Atualiza o produto existente
    public function update(Request $request, Produto $produto): JsonResponse
    {
        $dados = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'sometimes|required|numeric|min:0',
            'estoque' => 'sometimes|integer|min:0'
        ]);

        $produto->update($dados);

        return response()->json($produto);
    }

    // Exclui um produto existente
    public function destroy(Produto $produto): JsonResponse
    {
        $produto->delete();

        return response()->json(null, 204);
    }
}
