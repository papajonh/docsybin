<?php
declare(strict_types=1);
namespace Core\Routers;

class Router
{
    // Retorna a rota atual (ex.: '/login', '/api/salvar')   
    public function getCurrentRoute(): string
    {
        // Remove o script name e query string
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($uri, PHP_URL_PATH);

        // Normaliza: remove múltiplos '/' e garante que comece com '/'
        $uri = preg_replace('#/+#', '/', $uri);
        return rtrim($uri, '/') ?: '/';
    }
}