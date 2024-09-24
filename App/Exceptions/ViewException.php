<?php

namespace App\Exceptions;

use Exception;

/**
 * Classe responsável por gerenciar a exceção da classe View.
 */
class ViewException extends Exception
{
    /**
     * Exceção para quando uma view não existir no diretório Views/.
     *
     * @param string $view View não econtrada.
     * @return self
     */
    public static function ViewNotFound(string $view): self
    {
        $message = "View '{$view}' não existe no diretório Views/.";

        return new self(
            message: $message,
            code: 404 // Not Found
        );
    }
}
