<?php

namespace App\Helpers;

/**
 * Helper responsável por definir a flash message e redirecionar.
 */
abstract class RedirectWithMessage
{
    /**
     * Defini a flash message e redireciona o usuário.
     *
     * @param string $urlToRirect URL que o usuário será redirecionado.
     * @param string $type Tipo da flashmessage.
     * @param string $message Contéudo da flashmessage.
     * @return void
     */
    public static function handle(string $urlToRedirect, string $type, string $message): void
    {
        FlashMessage::set($type, $message);
        header("Location: $urlToRedirect");
        exit;
    }
}
