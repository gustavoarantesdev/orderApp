<?php

namespace App\Core;

use App\Routes\Routes;
use App\Core\Uri;
use App\Exceptions\ApplicationException;

/**
 * Classe responsável por gerenciar o sistema de rotas da aplicação.
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

        // Inicia o tratamento de exceções.
        $this->handleException();
    }

    /**
     * Exeucuta a aplicação e trata exceções durante a execução.
     *
     * @return void
     */
    private function handleException(): void
    {
        try {
            // Inicia o sistema de rotas.
            $this->run();
        } catch (ApplicationException $e) {
            http_response_code($e->getCode());
            require __DIR__ . '/../Views/errors/404.php';
        }
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
                    throw ApplicationException::controllerNotFound($controllerName);
                }

                // Instancia o controlador.
                $controllerInstance = new $controllerNamespace;

                // Verifica se o método do controlador existe, caso contrário lança uma exceção.
                if (!method_exists($controllerInstance, $methodName)) {
                    throw ApplicationException::methodNotFound($methodName, $controllerName);
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
        throw ApplicationException::routeNotFound($this->uri);
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
            throw ApplicationException::queryStringId();
        }

        // Armazena o valor do parâmetro 'id'.
        $queryStringValue = (int) $_GET['id'];

        // Atualiza a URI, anexando o valor da QueryString.
        $this->uri = "$uriValue/$queryStringValue";

        // Redireciona para a nova URI sem a QueryString.
        header('Location:' . BASE_URL . $this->uri);
        exit;
    }

    /**
     * Sanitiza os parametros da URI.
     */
    private function sanitizeParameter($parameter): int
    {
        return (int) htmlspecialchars($parameter);
    }
}
