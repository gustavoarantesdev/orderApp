<?php

namespace App\Core;

/**
 * Classe abstrata que fornece métodos para capturar e normalizar a URI da URL
 */
abstract class Uri
{
    /**
     * Obtém e retorna a URI da requisição atual.
     */
    public static function getUri(): string
    {
        // Armazena a URI completa da URL.
        $uri = $_SERVER['REQUEST_URI'];

        // Normaliza e retorna a URI.
        return self::normalizeUri($uri);
    }

    /**
     * Normaliza a URI removendo a URL base e ajustando o formato.
     */
    private static function normalizeUri($uri): string
    {
        // Remove a URL base da URI.
        if (strpos($uri, BASE_URL) === 0) {
            $uri = substr($uri, strlen(BASE_URL));
        }

        // Remove a barra final da URI.
        return $uri !== '/' ? rtrim($uri, '/') : $uri;
    }
}
