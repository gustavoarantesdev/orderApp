<?php

namespace App\Exceptions;

use Exception;

/**
 * Classe Responsável por gerenciar as exeções da classe Application.
 */
class ApplicationException extends Exception
{
    /**
     * Exceção para quando o Controller não for encontrado no array de rotas.
     *
     * @param string $controller Controller não encontrado.
     * @return self
     */
    public static function controllerNotFound(string $controller): self
    {
        $message = "Controller '{$controller}' não existe no array de rotas.";

        return new self(
            message: $message,
            code: 404 // Not Found
        );
    }

    /**
     * Exceção para quando o método do Controller não for encontrado no array de rotas.
     *
     * @param string $method Método não encontrado.
     * @param string $controller Controller encontrado.
     * @return self
     */
    public static function methodNotFound(string $method, string $controller): self
    {
        $message = "Método '{$method}' não existe no controller '{$controller}'.";

        return new self(
            message: $message,
            code: 405 // Method Not Allowed
        );
    }

    /**
     * Exceção para quando a Rota informada não for econtrada no array de rotas.
     *
     * @param string $route Rota não econtada.
     * @return self
     */
    public static function routeNotFound(string $route): self
    {
        $message = "Rota '{$route}' não existe no array de rotas.";

        return new self(
            message: $message,
            code: 404 // Not Found
        );
    }

    /**
     * Exeção para quando o parâmetro 'id' da QueryString não existir na URI.
     *
     * @return self
     */
    public static function queryStringId(): self
    {
        $message = "QueryString 'id' não encontrado na rota, solicitada.";

        return new self(
            message: $message,
            code: 405 // Method Not Allowed
        );
    }
}
