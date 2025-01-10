<?php

namespace App\Core;

use App\Services\Authenticator;
use App\Helpers\RedirectWithMessage;

/**
 * Classe responsável por centralizar as ações comuns de controladores.
 */
abstract class Controller
{
    /**
     * Verifica se o usuário está logado, caso não esteja redireciona.
     */
    protected function __construct()
    {
        if (!Authenticator::isAuthenticated()) {
            RedirectWithMessage::handle(BASE_URL, FLASH_ERROR, 'Faça login para acessar.');
        }
    }
}
