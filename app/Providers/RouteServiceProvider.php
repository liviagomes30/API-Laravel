<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // Define a constante para a rota inicial padrão
    public const HOME = '/home';

    // Método de inicialização do provedor de serviço
    public function boot(): void
    {
        // Configura as limitações de taxa para requisições
        $this->configureRateLimiting();

        // Define as rotas da aplicação
        $this->routes(function () {
            // Define rotas para a API com middleware 'api' e prefixo 'api'
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Define rotas para a interface web com middleware 'web'
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    // Configura as regras de limitação de taxa para a API
    protected function configureRateLimiting(): void
    {
        // Define uma limitação específica para a API
        RateLimiter::for('api', function (Request $request) {
            // Limita a 60 requisições por minuto, identificado pelo ID do usuário ou IP
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}