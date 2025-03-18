<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Método para autenticação de usuários
    public function login(Request $request)
    {
        // Valida os dados enviados na requisição
        $credentials = $request->validate([
            'email' => ['required', 'email'], // O email é obrigatório e deve ser um email válido
            'password' => ['required'], // A senha é obrigatória
        ]);

        // Tenta autenticar o usuário com as credenciais fornecidas
        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user = Auth::user(); // Obtém o usuário autenticado
            $token = $user->createToken('api_token')->plainTextToken; // Gera um token de API para o usuário
        
            // Retorna o token em uma resposta JSON com status 200 (OK)
            return response()->json(['token' => $token], 200);
        }
        
        // Retorna uma mensagem de erro em JSON com status 401 (Não autorizado) se a autenticação falhar
        return response()->json(['error' => 'Credenciais inválidas'], 401);
    }
}