<?php

namespace App\Helpers;

/**
 * Helper responsável por verificar se a requisição é válida.
 */
abstract class ValidateRequest
{
    /**
     * Verifica se a requisição é válida e redireciona.
     *
     * @param string $urlToRedirect URL que o usuário será redirecionado.
     * @return void
     */
    public static function handle(string $urlToRedirect): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: $urlToRedirect");
            exit;
        }
    }
}
