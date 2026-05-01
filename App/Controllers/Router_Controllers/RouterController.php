<?php
declare(strict_types=1);
namespace App\Controllers\Router_Controllers;
use Core\Routers\Router;
use App\Controllers\Api_Controllers\Api_Get_Data;

class RouterController
{
    private string $route;

    public function __construct()
    {
        // Configura a rota atual
        $router = new Router();
        $route  = $router->getCurrentRoute();
        $this->route = $route;
    }

    // Decide qual ação executar com base na rota.
    public function dispatch(): void
    {
        switch ($this->route) {

            case '/docsybin':
            case '/docsybin/home':
                echo '<h1>Home Page</h1>';
                break;

            case '/docsybin/login':
                echo '<h1>Página de Login</h1>';
                break;

            case '/docsybin/dashboard':
                echo '<h1>Painel de Controle do SaaS</h1>';
                break;

            /* ---------------------------------------
             * Rotas AJAX / API (exemplo)
             * --------------------------------------- */
            case '/docsybin/api/salvar':
                header('Content-Type: application/json');
                echo json_encode(['status' => 'sucesso', 'msg' => 'Dados salvos']);
                break;

            case '/docsybin/conn':
                // Aqui você pode incluir algum script externo
                $conn = Api_Get_Data::get();
                break;

            default:
                http_response_code(404);
                echo '<h1>Erro 404</h1>';
                echo "A rota <strong>{$this->route}</strong> não existe.";
                break;
        }
    }
}