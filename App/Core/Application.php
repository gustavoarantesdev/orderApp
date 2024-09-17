<?php

namespace App\Core;

use App\Routes\Routes;
use App\Core\Uri;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\NotFoundException;

/**
 * Classe Router que gerencia o sistema de rotas da aplicação.
 */
class Application
{
    private array $routes;
    private string $uri;

    /**
     * Construtor que carrega as rotas e a URI da requisição atual.
     */
    public function __construct()
    {
        // Obtém e armazena as rotas definidas.
        $this->routes = Routes::getRoutes();

        // Obtém e armazena as rotas definidas.
        $this->uri = Uri::getUri();

        // Executa o sistema de roteamento com as rotas e URI carregadas.
        $this->run();
    }

    /**
     * Executa o sistema de rotas.
     */
    private function run(): void
    {
        // Percorre todas as rotas.
        foreach ($this->routes as $path => $controllerAndAction) {
            // Verifica se a URI contém uma QueryString.
            if (strpos($this->uri, '?')) {
                $this->handleQueryString();
            }

            // Substitui o placeholder {id} por um padrão de expressão regular.
            $pattern = '#^' . preg_replace('/{id}/', '(\d+)', $path) . '$#';

            // Verifica se a URI atual corresponde ao padrão de rota.
            if (preg_match($pattern, $this->uri, $matches)) {
                // Remove o primeiro valor do array $matches (a URI completa).
                array_shift($matches);

                // Divide o controlador e o método a partir da rota correspondente.
                [$controllerName, $methodName] = explode('@', $controllerAndAction);

                // Define o namespace completo do controlador.
                $controllerNamespace = "App\\Controllers\\{$controllerName}";

                // Verifica se o controlador existe, caso contrário lança uma exceção.
                if (!class_exists($controllerNamespace)) {
                    // throw new NotFoundException('<center><h1>404 - Controller not found!</h1></center>');
                }

                // Instancia o controlador.
                $controllerInstance = new $controllerNamespace;

                // Verifica se o método do controlador existe, caso contrário lança uma exceção.
                if (!method_exists($controllerInstance, $methodName)) {
                    // throw new MethodNotAllowedException('<center><h1>405 - Method not found!</h1></center>');
                }

                // Verifica se há parâmetros capturados na rota.
                if (!empty($matches)) {
                    // Converte o array de parâmetros em uma string.
                    $parameter = implode($matches);

                    // Invoca o método do controlador passando o parâmetro.
                    $controllerInstance->$methodName($this->sanitizeParameter($parameter));

                    exit;
                }

                // Invoca o método do controlador sem parâmetros.
                $controllerInstance->$methodName();

                exit;
            }
        }

        // Se nenhuma rota corresponder, lança uma exceção de rota não encontrada.
        // throw new NotFoundException('<center><h1>404 - Route not found!</h1></center>');
    }

    /**
     * Trata a URI que contém uma QueryString.
     */
    private function handleQueryString(): void
    {
        // Armazena apenas a URI, ignorando a QueryString.
        $uriValue = parse_url($this->uri, PHP_URL_PATH);

        // Verifica se o parâmetro 'id' está presente na QueryString
        if (!isset($_GET['id'])) {
            // throw new NotFoundException('<center><h1>404 - Route parameter not found!</h1></center>');
        }

        // Armazena o valor do parâmetro 'id'.
        $queryStringValue = (int) $_GET['id'];

        // Atualiza a URI, anexando o valor da QueryString.
        $this->uri = "$uriValue/$queryStringValue";

        // Redireciona para a nova URI sem a QueryString.
        header('Location:' . BASE_URL . $this->uri);
    }

    /**
     * Sanitiza os parametros da URI.
     */
    private function sanitizeParameter($parameter): int
    {
        return (int) htmlspecialchars($parameter);
    }
}
