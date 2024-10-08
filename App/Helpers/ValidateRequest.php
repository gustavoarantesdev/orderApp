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
     * @param string $url
     * @return void
     */
    public static function handle(string $url): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: $url");
            exit;
        }
    }
}
