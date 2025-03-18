<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable; // Inclui traits para tokens de API, factory e notificações

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', // Nome do usuário
        'email', // Email do usuário
        'password', // Senha do usuário
    ];

    /**
     * Os atributos que devem ser ocultados durante a serialização.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', // Oculta a senha
        'remember_token', // Oculta o token de lembrança
    ];

    /**
     * Obtém os atributos que devem ser convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Converte o campo email_verified_at para um objeto DateTime
            'password' => 'hashed', // Garante que a senha seja armazenada como hash
        ];
    }
}