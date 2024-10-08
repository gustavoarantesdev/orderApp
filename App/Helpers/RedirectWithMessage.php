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
     * @param string $url
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function handle(string $url, string $type, string $message): void
    {
        FlashMessage::set($type, $message);
        header("Location: $url");
        exit;
    }
}
