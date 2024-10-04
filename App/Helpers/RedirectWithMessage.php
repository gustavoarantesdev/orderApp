<?php

namespace App\Helpers;

abstract class RedirectWithMessage
{
    /**
     * Redireciona o usuário, definindo a flash message.
     * @param string $url
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function redirect(string $url, string $type, string $message): void
    {
        FlashMessage::set($type, $message);
        header("Location: $url");
        exit;
    }
}
