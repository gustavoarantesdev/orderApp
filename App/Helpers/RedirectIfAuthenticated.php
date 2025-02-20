<?php

namespace App\Helpers;

use App\Helpers\login\Authenticator;

/**
 * Helper responável por redicionar caso o usuário esteja logado.
 */
abstract class RedirectIfAuthenticated
{
    /**
     * Redireciona o usuário.
     *
     * @return void
     */
    public static function handle()
    {
        if (Authenticator::isAuthenticated()) {
            header('Location:' . BASE_URL . '/encomenda/home');
            exit;
        }
    }
}
